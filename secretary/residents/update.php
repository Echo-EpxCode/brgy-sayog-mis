<?php

require '../../config/database.php';
require '../../config/session.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$id = $_POST['id'];
$household_no = $_POST['household_no'];
$contact_no = $_POST['contact_no'];
$address = $_POST['address'];

$stmt = $conn->prepare("
UPDATE residents
SET household_no=?, contact_no=?, address=?
WHERE id=?
");

$stmt->bind_param("sssi", $household_no, $contact_no, $address, $id);

$stmt->execute();

$_SESSION['success'] = "Resident updated successfully.";

header("Location: index.php");
exit;
