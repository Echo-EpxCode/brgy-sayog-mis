<?php

require_once '../../config/database.php';
require_once '../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class CertificateService
{
    public static function generate($conn, $request_id, $issued_by)
    {
        // ======================================
        // 1. CHECK IF CERTIFICATE EXISTS
        // ======================================

        $check = mysqli_prepare(
            $conn,
            "SELECT * FROM certificates WHERE request_id=?"
        );

        mysqli_stmt_bind_param($check, "i", $request_id);
        mysqli_stmt_execute($check);

        $result = mysqli_stmt_get_result($check);
        $existing = mysqli_fetch_assoc($result);

        if ($existing && !empty($existing['file_path'])) {
            return $existing['file_path'];
        }

        // ======================================
        // 2. GET REQUEST DATA
        // ======================================

        $q = mysqli_query(
            $conn,
            "SELECT dr.*, dt.document_name,
                    r.first_name, r.middle_name, r.last_name, r.suffix, r.address
             FROM document_requests dr
             INNER JOIN document_types dt ON dr.document_type_id = dt.id
             INNER JOIN residents r ON dr.resident_id = r.id
             WHERE dr.id = $request_id"
        );

        $data = mysqli_fetch_assoc($q);

        if (!$data) {
            throw new Exception("Request not found");
        }

        // ======================================
        // 3. CREATE CERTIFICATE IF NOT EXISTS
        // ======================================

        if (!$existing) {

            $certificate_no = "BRGY-" . date('Y') . "-" . strtoupper(substr(md5(uniqid()), 0, 6));

            $insert = mysqli_prepare(
                $conn,
                "INSERT INTO certificates (request_id, certificate_no, issued_date, issued_by)
                 VALUES (?, ?, NOW(), ?)"
            );

            mysqli_stmt_bind_param($insert, "isi", $request_id, $certificate_no, $issued_by);
            mysqli_stmt_execute($insert);
        } else {
            $certificate_no = $existing['certificate_no'];
        }

        // ======================================
        // 4. GENERATE PDF
        // ======================================

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        ob_start();
        include __DIR__ . '/templates/barangay_clearance.php';
        $html = ob_get_clean();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $folder = "assets/uploads/certificates/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $filename = "CERT-" . $certificate_no . ".pdf";
        $file_path = $folder . $filename;

        file_put_contents($file_path, $dompdf->output());

        // ======================================
        // 5. UPDATE FILE PATH
        // ======================================

        $update = mysqli_prepare(
            $conn,
            "UPDATE certificates SET file_path=? WHERE request_id=?"
        );

        mysqli_stmt_bind_param($update, "si", $file_path, $request_id);
        mysqli_stmt_execute($update);

        return $file_path;
    }
}
