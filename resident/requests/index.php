<?php

require '../../config/database.php';
require '../../config/session.php';

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'resident'
) {
    header('Location: ../../auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// ======================================
// GET RESIDENT ID
// ======================================

$res = mysqli_query(
    $conn,
    "SELECT id FROM residents WHERE user_id = $user_id LIMIT 1"
);

$resident = mysqli_fetch_assoc($res);
$resident_id = $resident['id'] ?? 0;

// ======================================
// REQUEST LIST
// ======================================

$sql = "
SELECT
    dr.*,
    dt.document_name,
    c.file_path,
    c.certificate_no
FROM document_requests dr
INNER JOIN document_types dt
    ON dr.document_type_id = dt.id
LEFT JOIN certificates c
    ON dr.id = c.request_id
WHERE dr.resident_id = $resident_id
ORDER BY dr.id DESC
";

$requests = mysqli_query($conn, $sql);

// REQUIRED FOR SIDEBAR ACTIVE STATE
$base_url = '../../';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Requests</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/css/styles.css" rel="stylesheet">

</head>

<body class="bg-light">

    <?php include '../../includes/resident_sidebar.php'; ?>

    <div class="main-wrapper">

        <?php include '../../includes/nav.php'; ?>

        <main class="p-4">

            <!-- HEADER -->
            <div class="mb-4">

                <h2 class="fw-bold">
                    My Document Requests
                </h2>

                <p class="text-muted">
                    Track the status of your submitted requests
                </p>

            </div>

            <!-- TABLE CARD -->
            <div class="card dashboard-card">

                <div class="card-body table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>#</th>
                                <th>Document</th>
                                <th>Purpose</th>
                                <th>Status</th>
                                <th>Date Requested</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php if (mysqli_num_rows($requests) > 0): ?>

                                <?php while ($row = mysqli_fetch_assoc($requests)): ?>

                                    <tr>

                                        <td>
                                            <?= $row['id'] ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['document_name']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['purpose']) ?>
                                        </td>

                                        <td>

                                            <?php
                                            $badge = 'secondary';

                                            if ($row['status'] === 'Pending') {
                                                $badge = 'warning';
                                            } elseif ($row['status'] === 'Approved') {
                                                $badge = 'success';
                                            } elseif ($row['status'] === 'Rejected') {
                                                $badge = 'danger';
                                            } elseif ($row['status'] === 'Released') {
                                                $badge = 'primary';
                                            }
                                            ?>

                                            <span class="badge bg-<?= $badge ?>">
                                                <?= $row['status'] ?>
                                            </span>

                                        </td>

                                        <td>
                                            <?= date('M d, Y h:i A', strtotime($row['requested_at'])) ?>
                                        </td>
                                        <td>

                                            <?php if ($row['status'] === 'Pending'): ?>

                                                <span class="badge bg-warning text-dark">
                                                    Waiting for approval
                                                </span>

                                            <?php elseif ($row['status'] === 'Approved'): ?>

                                                <span class="badge bg-info text-dark">
                                                    Waiting for release
                                                </span>

                                            <?php elseif ($row['status'] === 'Rejected'): ?>

                                                <span class="badge bg-danger">
                                                    Rejected
                                                </span>

                                            <?php elseif ($row['status'] === 'Released'): ?>

                                                <?php if (!empty($row['file_path'])): ?>

                                                    <a href="<?= $row['file_path'] ?>" target="_blank" class="btn btn-sm btn-primary">

                                                        <i class="bi bi-printer"></i>
                                                        Print

                                                    </a>

                                                    <a href="<?= $row['file_path'] ?>" download class="btn btn-sm btn-success">

                                                        <i class="bi bi-download"></i>
                                                        Download

                                                    </a>

                                                <?php else: ?>

                                                    <span class="badge bg-secondary">
                                                        Processing file...
                                                    </span>

                                                <?php endif; ?>

                                            <?php endif; ?>

                                        </td>

                                    </tr>

                                <?php endwhile; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No requests found
                                    </td>
                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/scripts.js"></script>

</body>

</html>
