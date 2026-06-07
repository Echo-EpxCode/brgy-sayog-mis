<?php

use Dompdf\Dompdf;
use Dompdf\Options;

require '../../vendor/autoload.php';

/**
 * Generate certificate PDF
 *
 * @param mysqli $conn
 * @param int $request_id
 * @return string
 */
function generate_certificate_pdf($conn, $request_id)
{
    // ======================================
    // GET REQUEST DATA
    // ======================================

    $stmt = mysqli_prepare(
        $conn,
        "SELECT
            dr.*,
            dt.document_name,
            r.*,
            c.certificate_no
        FROM document_requests dr
        INNER JOIN document_types dt
            ON dr.document_type_id = dt.id
        INNER JOIN residents r
            ON dr.resident_id = r.id
        INNER JOIN certificates c
            ON c.request_id = dr.id
        WHERE dr.id = ?
        LIMIT 1"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $request_id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        die('Certificate data not found.');
    }

    // ======================================
    // LOAD TEMPLATE
    // ======================================

    $document_name = strtolower(
        trim($data['document_name'])
    );

    ob_start();

    switch ($document_name) {

        case 'barangay clearance':
            include __DIR__ . '/templates/barangay_clearance.php';
            break;

        case 'certificate of indigency':
            include __DIR__ . '/templates/certificate_of_indigency.php';
            break;

        case 'cedula':
            include __DIR__ . '/templates/cedula.php';
            break;

        default:
            die('Invalid certificate template.');
    }

    $html = ob_get_clean();

    // ======================================
    // DOMPDF CONFIG
    // ======================================

    $options = new Options();

    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);

    $dompdf->loadHtml($html);

    $dompdf->setPaper(
        'A4',
        'portrait'
    );

    $dompdf->render();

    // ======================================
    // STORAGE DIRECTORY
    // ======================================

    $year = date('Y');

    $storage_dir =
        '../../assets/uploads/certificates/' .
        $year;

    if (!is_dir($storage_dir)) {

        mkdir(
            $storage_dir,
            0777,
            true
        );
    }

    // ======================================
    // FILE NAME
    // ======================================

    $file_name =
        preg_replace(
            '/[^A-Za-z0-9\-]/',
            '_',
            $data['certificate_no']
        ) . '.pdf';

    $absolute_file =
        $storage_dir .
        '/' .
        $file_name;

    // ======================================
    // SAVE PDF
    // ======================================

    file_put_contents(
        $absolute_file,
        $dompdf->output()
    );

    // ======================================
    // RETURN DB PATH
    // ======================================

    return
        'assets/uploads/certificates/' .
        $year .
        '/' .
        $file_name;
}
