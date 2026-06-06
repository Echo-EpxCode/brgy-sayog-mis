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

$certificate_id = isset($_GET['id'])
    ? (int) $_GET['id']
    : 0;

if ($certificate_id <= 0) {
    die('Invalid certificate ID.');
}

// ======================================
// LOAD CERTIFICATE DATA
// ======================================

$stmt = mysqli_prepare(
    $conn,
    "SELECT
        c.id,
        c.certificate_no,
        c.issued_date,
        c.file_path,

        dr.id AS request_id,
        dr.purpose,

        dt.document_name,

        r.household_no,
        r.first_name,
        r.middle_name,
        r.last_name,
        r.suffix,
        r.gender,
        r.birth_date,
        r.civil_status,
        r.contact_no,
        r.address,
        r.occupation,
        r.citizenship

    FROM certificates c

    INNER JOIN document_requests dr
        ON c.request_id = dr.id

    INNER JOIN document_types dt
        ON dr.document_type_id = dt.id

    INNER JOIN residents r
        ON dr.resident_id = r.id

    WHERE c.id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $certificate_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    die('Certificate not found.');
}

$certificate = mysqli_fetch_assoc($result);

// ======================================
// FULL NAME
// ======================================

$full_name = trim(
    $certificate['first_name'] . ' ' .
    $certificate['middle_name'] . ' ' .
    $certificate['last_name'] . ' ' .
    $certificate['suffix']
);

// ======================================
// LOAD TEMPLATE
// ======================================

$document_name = trim($certificate['document_name']);

switch ($document_name) {

    case 'Barangay Clearance':

        include 'templates/barangay_clearance.php';
        break;

    case 'Certificate of Indigency':

        include 'templates/certificate_of_indigency.php';
        break;

    case 'Cedula':

        include 'templates/cedula.php';
        break;

    default:

        echo "<h3>Template not found.</h3>";
        break;
}
