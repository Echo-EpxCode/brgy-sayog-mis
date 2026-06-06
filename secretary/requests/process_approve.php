<?php

require '../../config/database.php';
require '../../config/session.php';

$request_id = (int) $_POST['request_id'];

$stmt = mysqli_prepare(
    $conn,
    "UPDATE document_requests
     SET status='Approved',
         approved_by=?,
         approved_at=NOW()
     WHERE id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $_SESSION['user_id'],
    $request_id
);

mysqli_stmt_execute($stmt);

header("Location: index.php");
exit;
