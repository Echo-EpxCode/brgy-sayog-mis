<?php

require '../../config/database.php';
require '../../config/session.php';

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'secretary'
) {
    header('Location: ../../auth/login.php');
    exit;
}

$request_id = (int) ($_GET['id'] ?? 0);

if ($request_id <= 0) {
    header('Location: history.php');
    exit;
}

// ======================================
// GET REQUEST DETAILS
// ======================================

$stmt = mysqli_prepare(
    $conn,
    "SELECT
        dr.*,
        dt.document_name,
        r.*
     FROM document_requests dr
     INNER JOIN document_types dt
        ON dr.document_type_id = dt.id
     INNER JOIN residents r
        ON dr.resident_id = r.id
     WHERE dr.id = ?
     LIMIT 1"
);

mysqli_stmt_bind_param($stmt, "i", $request_id);
mysqli_stmt_execute($stmt);

$request = mysqli_fetch_assoc(
    mysqli_stmt_get_result($stmt)
);

if (!$request) {
    die('Request not found.');
}

// ======================================
// ALREADY APPROVED
// ======================================

if ($request['status'] === 'Approved') {

    header(
        'Location: ../requests/index.php?msg=already-approved'
    );

    exit;
}

// ======================================
// GENERATE CERTIFICATE NUMBER
// ======================================

$certificate_no =
    'CERT-' .
    date('Y') .
    '-' .
    str_pad($request_id, 5, '0', STR_PAD_LEFT);

// ======================================
// CREATE CERTIFICATE RECORD
// ======================================

$check_stmt = mysqli_prepare(
    $conn,
    "SELECT id
     FROM certificates
     WHERE request_id = ?
     LIMIT 1"
);

mysqli_stmt_bind_param(
    $check_stmt,
    "i",
    $request_id
);

mysqli_stmt_execute($check_stmt);

$existing = mysqli_fetch_assoc(
    mysqli_stmt_get_result($check_stmt)
);

if (!$existing) {

    $insert_stmt = mysqli_prepare(
        $conn,
        "INSERT INTO certificates
        (
            request_id,
            certificate_no,
            issued_date,
            issued_by
        )
        VALUES
        (
            ?,
            ?,
            NOW(),
            ?
        )"
    );

    mysqli_stmt_bind_param(
        $insert_stmt,
        "isi",
        $request_id,
        $certificate_no,
        $_SESSION['user_id']
    );

    mysqli_stmt_execute($insert_stmt);

    $certificate_id = mysqli_insert_id($conn);

} else {

    $certificate_id = $existing['id'];
}

// ======================================
// PDF GENERATION
// ======================================

require 'generate_pdf.php';

$pdf_path = generate_certificate_pdf(
    $conn,
    $request_id
);

// ======================================
// UPDATE FILE PATH
// ======================================

$update_cert_stmt = mysqli_prepare(
    $conn,
    "UPDATE certificates
     SET file_path = ?
     WHERE id = ?"
);

mysqli_stmt_bind_param(
    $update_cert_stmt,
    "si",
    $pdf_path,
    $certificate_id
);

mysqli_stmt_execute($update_cert_stmt);

// ======================================
// APPROVE REQUEST
// ======================================

$approve_stmt = mysqli_prepare(
    $conn,
    "UPDATE document_requests
     SET
        status = 'Approved',
        approved_by = ?,
        approved_at = NOW()
     WHERE id = ?"
);

mysqli_stmt_bind_param(
    $approve_stmt,
    "ii",
    $_SESSION['user_id'],
    $request_id
);

mysqli_stmt_execute($approve_stmt);

// ======================================
// REDIRECT
// ======================================

header(
    'Location: ../requests/index.php?msg=approved'
);

exit;
