<?php

require '../../config/database.php';
require '../../config/session.php';

// ======================================
// AUTH CHECK
// ======================================

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'resident'
) {
    header('Location: ../../auth/login.php');
    exit;
}

$user_id = (int) $_SESSION['user_id'];

$request_id = (int) ($_GET['id'] ?? 0);

if ($request_id <= 0) {
    die('Invalid request.');
}

// ======================================
// GET RESIDENT ID
// ======================================

$stmt = mysqli_prepare(
    $conn,
    "SELECT id
     FROM residents
     WHERE user_id = ?
     LIMIT 1"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$resident = mysqli_fetch_assoc(
    mysqli_stmt_get_result($stmt)
);

$resident_id = $resident['id'] ?? 0;

if (!$resident_id) {
    die('Resident profile not found.');
}

// ======================================
// GET CERTIFICATE
// ======================================

$stmt = mysqli_prepare(
    $conn,
    "SELECT
        dr.id,
        dr.status,
        dt.document_name,
        c.certificate_no,
        c.file_path
     FROM document_requests dr
     INNER JOIN document_types dt
        ON dr.document_type_id = dt.id
     LEFT JOIN certificates c
        ON dr.id = c.request_id
     WHERE
        dr.id = ?
        AND dr.resident_id = ?
     LIMIT 1"
);

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $request_id,
    $resident_id
);

mysqli_stmt_execute($stmt);

$data = mysqli_fetch_assoc(
    mysqli_stmt_get_result($stmt)
);

if (!$data) {
    die('Request not found.');
}

// ======================================
// RELEASED CHECK
// ======================================

if ($data['status'] !== 'Released') {
    die('Certificate is not available for download.');
}

// ======================================
// FILE CHECK
// ======================================

if (empty($data['file_path'])) {
    die('Certificate file not found.');
}

// Convert DB path to physical path

// $physical_file = '../../' . ltrim(
//     $data['file_path'],
//     '/'
// );

$physical_file = realpath(
    $data['file_path']
);

if (!file_exists($physical_file)) {
    die('PDF file does not exist.');
}

// ======================================
// DOWNLOAD PDF
// ======================================

$download_name =
    preg_replace(
        '/[^A-Za-z0-9\-_]/',
        '_',
        $data['certificate_no']
    ) . '.pdf';

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $download_name . '"');
header('Content-Length: ' . filesize($physical_file));
header('Cache-Control: private');

readfile($physical_file);
exit;
