<?php

require '../../config/database.php';
require '../../config/session.php';
require '../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'secretary') {
    header('Location: ../../auth/login.php');
    exit;
}

$request_id = (int) $_POST['request_id'];
$issued_by = (int) $_SESSION['user_id'];

mysqli_begin_transaction($conn);

try {

    // =========================
    // 1. RELEASE REQUEST
    // =========================

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE document_requests
         SET status='Released', released_at=NOW()
         WHERE id=?"
    );

    mysqli_stmt_bind_param($stmt, "i", $request_id);
    mysqli_stmt_execute($stmt);

    // =========================
    // 2. GET REQUEST DATA
    // =========================

    $q = mysqli_query(
        $conn,
        "SELECT dr.*, dt.document_name,
                r.first_name, r.middle_name, r.last_name, r.suffix, r.address, r.civil_status, r.citizenship, r.occupation
         FROM document_requests dr
         INNER JOIN document_types dt ON dr.document_type_id = dt.id
         INNER JOIN residents r ON dr.resident_id = r.id
         WHERE dr.id = $request_id"
    );

    $data = mysqli_fetch_assoc($q);

    if (!$data) {
        throw new Exception("Request not found.");
    }

    // =========================
    // 3. CREATE CERTIFICATE
    // =========================

    $certificate_no = "BRGY-" . date('Y') . "-" . strtoupper(substr(md5(uniqid()), 0, 6));

    $insert = mysqli_prepare(
        $conn,
        "INSERT INTO certificates (request_id, certificate_no, issued_date, issued_by)
         VALUES (?, ?, NOW(), ?)"
    );

    mysqli_stmt_bind_param($insert, "isi", $request_id, $certificate_no, $issued_by);
    mysqli_stmt_execute($insert);

    $certificate_id = mysqli_insert_id($conn);

    // =========================
// 4. GENERATE PDF
// =========================

    $options = new Options();
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);

    ob_start();

    // TEMPLATE ROUTER
    if ($data['document_type_id'] == 1) {

        include '../certificates/templates/barangay_clearance.php';

    } elseif ($data['document_type_id'] == 2) {

        include '../certificates/templates/cedula.php';

    } elseif ($data['document_type_id'] == 3) {

        include '../certificates/templates/certificate_of_indigency.php';

    } else {
        throw new Exception("Invalid document type ID: " . $data['document_type_id']);
    }

    $html = ob_get_clean();

    // SAFETY CHECK
    if (empty($html)) {
        throw new Exception("Template returned empty HTML.");
    }

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // SAVE PDF FILE
    $folder = __DIR__ . "/../../assets/uploads/certificates/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $filename = "CERT-" . $certificate_no . ".pdf";
    $file_path = $folder . $filename;

    file_put_contents($file_path, $dompdf->output());

    if (!file_exists($file_path)) {
        throw new Exception("PDF generation failed. File not created.");
    }

    // =========================
// SAVE DB FILE PATH (MISSING BEFORE)
// =========================

    $web_path = "../../assets/uploads/certificates/" . $filename;

    $update = mysqli_prepare(
        $conn,
        "UPDATE certificates SET file_path=? WHERE id=?"
    );

    mysqli_stmt_bind_param($update, "si", $web_path, $certificate_id);

    if (!mysqli_stmt_execute($update)) {
        throw new Exception("Failed to update file_path: " . mysqli_error($conn));
    }

    // COMMIT
    mysqli_commit($conn);

    header("Location: index.php?success=1");
    exit;

} catch (Exception $e) {

    mysqli_rollback($conn);
    die("Release failed: " . $e->getMessage());
}
