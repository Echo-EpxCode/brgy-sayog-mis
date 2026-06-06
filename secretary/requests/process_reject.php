<?php

require '../../config/database.php';
require '../../config/session.php';

$request_id = (int) $_POST['request_id'];

$remarks = trim($_POST['remarks']);

$stmt = mysqli_prepare(
    $conn,
    "UPDATE document_requests
     SET status='Rejected',
         remarks=?
     WHERE id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "si",
    $remarks,
    $request_id
);

mysqli_stmt_execute($stmt);

header("Location: index.php");
exit;
