<?php

require '../../config/database.php';
require '../../config/session.php';

use Dompdf\Dompdf;
use Dompdf\Options;

require '../../vendor/autoload.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'secretary') {
    header('Location: ../../auth/login.php');
    exit;
}

$request_id = (int) $_POST['request_id'];
$issued_by = (int) $_SESSION['user_id'];

mysqli_begin_transaction($conn);

try {

    // ======================================
    // 1. UPDATE REQUEST TO RELEASED
    // ======================================

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE document_requests
         SET status='Released',
             released_at=NOW()
         WHERE id=?"
    );

    mysqli_stmt_bind_param($stmt, "i", $request_id);
    mysqli_stmt_execute($stmt);

    // ======================================
    // 2. FETCH REQUEST DATA FOR PDF
    // ======================================

    $query = mysqli_query(
        $conn,
        "SELECT
            dr.id,
            dr.purpose,
            dt.document_name,
            r.id AS resident_id,
            r.first_name,
            r.middle_name,
            r.last_name,
            r.suffix,
            r.address,
            r.civil_status,
            r.occupation,
            r.citizenship,
            r.household_no
         FROM document_requests dr
         INNER JOIN document_types dt ON dr.document_type_id = dt.id
         INNER JOIN residents r ON dr.resident_id = r.id
         WHERE dr.id = $request_id"
    );

    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        throw new Exception("Request not found.");
    }

    // ======================================
    // 3. CREATE CERTIFICATE IF NOT EXISTS
    // ======================================

    $check = mysqli_prepare(
        $conn,
        "SELECT id FROM certificates WHERE request_id=?"
    );

    mysqli_stmt_bind_param($check, "i", $request_id);
    mysqli_stmt_execute($check);

    $result = mysqli_stmt_get_result($check);

    if (mysqli_num_rows($result) == 0) {

        $certificate_no = "BRGY-" . date('Y') . "-" . strtoupper(substr(md5(uniqid()), 0, 6));

        $insert = mysqli_prepare(
            $conn,
            "INSERT INTO certificates
            (request_id, certificate_no, issued_date, issued_by)
            VALUES (?, ?, NOW(), ?)"
        );

        mysqli_stmt_bind_param(
            $insert,
            "isi",
            $request_id,
            $certificate_no,
            $issued_by
        );

        mysqli_stmt_execute($insert);

        $certificate_id = mysqli_insert_id($conn);

    } else {

        $row = mysqli_fetch_assoc($result);
        $certificate_id = $row['id'];
    }

    // ======================================
    // 4. PREPARE FULL DATA FOR PDF
    // ======================================

    $full_name = trim(
        $data['first_name'] . ' ' .
        $data['middle_name'] . ' ' .
        $data['last_name'] . ' ' .
        $data['suffix']
    );

    // ======================================
    // 5. LOAD TEMPLATE OUTPUT
    // ======================================

    $stmt = mysqli_prepare(
        $conn,
        "SELECT
            c.*,
            dr.purpose,
            dt.document_name,
            r.first_name,
            r.middle_name,
            r.last_name,
            r.suffix,
            r.address,
            r.civil_status,
            r.occupation,
            r.citizenship,
            r.household_no
         FROM certificates c
         INNER JOIN document_requests dr ON c.request_id = dr.id
         INNER JOIN document_types dt ON dr.document_type_id = dt.id
         INNER JOIN residents r ON dr.resident_id = r.id
         WHERE c.id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $certificate_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $certificate = mysqli_fetch_assoc($result);

    ob_start();

    switch ($certificate['document_name']) {

        case 'Barangay Clearance':
            include '../certificates/templates/barangay_clearance.php';
            break;

        case 'Certificate of Indigency':
            include '../certificates/templates/certificate_of_indigency.php';
            break;

        case 'Cedula':
            include '../certificates/templates/cedula.php';
            break;

        default:
            throw new Exception("No template found.");
    }

    $html = ob_get_clean();

    // ======================================
    // 6. GENERATE PDF
    // ======================================

    $options = new Options();
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $folder = "../../assets/uploads/certificates/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $filename = "CERT-" . $certificate['certificate_no'] . ".pdf";
    $file_path = $folder . $filename;

    file_put_contents($file_path, $dompdf->output());

    // ======================================
    // 7. UPDATE FILE PATH
    // ======================================

    $update = mysqli_prepare(
        $conn,
        "UPDATE certificates SET file_path=? WHERE id=?"
    );

    mysqli_stmt_bind_param($update, "si", $file_path, $certificate_id);
    mysqli_stmt_execute($update);

    // ======================================
    // DONE
    // ======================================

    mysqli_commit($conn);

    header("Location: index.php?released=1");
    exit;

} catch (Exception $e) {

    mysqli_rollback($conn);
    die("Release failed: " . $e->getMessage());
}
