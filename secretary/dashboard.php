<?php

require '../config/database.php';
require '../config/session.php';

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'secretary'
) {
    header('Location: ../auth/login.php');
    exit;
}

// ======================================
// DASHBOARD COUNTS
// ======================================

$residents = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM residents"
    )
);

$pending_registrations = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM users
         WHERE role='resident'
         AND status='pending'"
    )
);

$pending_requests = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM document_requests
         WHERE status='Pending'"
    )
);

$approved_requests = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM document_requests
         WHERE status='Approved'"
    )
);

$released_requests = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM document_requests
         WHERE status='Released'"
    )
);

$announcements = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM announcements"
    )
);

// ======================================
// RECENT REQUESTS
// ======================================

$recent_requests = mysqli_query(
    $conn,
    "SELECT
        dr.id,
        dr.status,
        dr.requested_at,
        dt.document_name,
        CONCAT(
            r.first_name,
            ' ',
            r.last_name
        ) AS resident_name
    FROM document_requests dr
    INNER JOIN residents r
        ON dr.resident_id = r.id
    INNER JOIN document_types dt
        ON dr.document_type_id = dt.id
    ORDER BY dr.id DESC
    LIMIT 10"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Dashboard | Barangay Sayog MIS
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../assets/css/styles.css">

</head>

<body>
    <?php $base_url = '../'; ?>
    <!-- SIDEBAR -->
    <?php include '../includes/secretary_sidebar.php'; ?>

    <!-- MAIN -->
    <div class="main-wrapper">

        <!-- NAVBAR -->
        <?php include '../includes/nav.php'; ?>

        <!-- PAGE CONTENT -->
        <main class="p-4">

            <!-- PAGE HEADER -->

            <div class="mb-4">

                <h2 class="fw-bold mb-1">
                    Dashboard
                </h2>

                <p class="text-muted mb-0">
                    Barangay Sayog Management Information System
                </p>

            </div>

            <!-- CARDS -->

            <div class="row g-4 mb-4">

                <div class="col-sm-6 col-xl-4">

                    <div class="card dashboard-card h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <small class="text-muted">
                                        Total Residents
                                    </small>

                                    <h2 class="fw-bold mb-0">
                                        <?= $residents['total']; ?>
                                    </h2>

                                </div>

                                <div class="dashboard-icon bg-success-subtle text-success">

                                    <i class="bi bi-people-fill"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-xl-4">

                    <div class="card dashboard-card h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <small class="text-muted">
                                        Pending Registrations
                                    </small>

                                    <h2 class="fw-bold mb-0">
                                        <?= $pending_registrations['total']; ?>
                                    </h2>

                                </div>

                                <div class="dashboard-icon bg-warning-subtle text-warning">

                                    <i class="bi bi-person-check-fill"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-xl-4">

                    <div class="card dashboard-card h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <small class="text-muted">
                                        Pending Requests
                                    </small>

                                    <h2 class="fw-bold mb-0">
                                        <?= $pending_requests['total']; ?>
                                    </h2>

                                </div>

                                <div class="dashboard-icon bg-info-subtle text-info">

                                    <i class="bi bi-file-earmark-text-fill"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-xl-4">

                    <div class="card dashboard-card h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <small class="text-muted">
                                        Approved Requests
                                    </small>

                                    <h2 class="fw-bold mb-0">
                                        <?= $approved_requests['total']; ?>
                                    </h2>

                                </div>

                                <div class="dashboard-icon bg-primary-subtle text-primary">

                                    <i class="bi bi-check-circle-fill"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-xl-4">

                    <div class="card dashboard-card h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <small class="text-muted">
                                        Released Documents
                                    </small>

                                    <h2 class="fw-bold mb-0">
                                        <?= $released_requests['total']; ?>
                                    </h2>

                                </div>

                                <div class="dashboard-icon bg-success-subtle text-success">

                                    <i class="bi bi-award-fill"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-xl-4">

                    <div class="card dashboard-card h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <small class="text-muted">
                                        Announcements
                                    </small>

                                    <h2 class="fw-bold mb-0">
                                        <?= $announcements['total']; ?>
                                    </h2>

                                </div>

                                <div class="dashboard-icon bg-danger-subtle text-danger">

                                    <i class="bi bi-megaphone-fill"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- RECENT REQUESTS -->

            <div class="card dashboard-card">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Recent Document Requests
                    </h5>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">

                                <tr>
                                    <th>ID</th>
                                    <th>Resident</th>
                                    <th>Document</th>
                                    <th>Status</th>
                                    <th>Requested At</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php if (mysqli_num_rows($recent_requests) > 0): ?>

                                    <?php while ($row = mysqli_fetch_assoc($recent_requests)): ?>

                                        <tr>

                                            <td>
                                                #<?= $row['id']; ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($row['resident_name']); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($row['document_name']); ?>
                                            </td>

                                            <td>

                                                <?php

                                                $badge = 'secondary';

                                                switch ($row['status']) {

                                                    case 'Pending':
                                                        $badge = 'warning';
                                                        break;

                                                    case 'Approved':
                                                        $badge = 'success';
                                                        break;

                                                    case 'Rejected':
                                                        $badge = 'danger';
                                                        break;

                                                    case 'Released':
                                                        $badge = 'primary';
                                                        break;
                                                }

                                                ?>

                                                <span class="badge bg-<?= $badge; ?>">
                                                    <?= $row['status']; ?>
                                                </span>

                                            </td>

                                            <td>
                                                <?= date(
                                                    'M d, Y h:i A',
                                                    strtotime($row['requested_at'])
                                                ); ?>
                                            </td>

                                        </tr>

                                    <?php endwhile; ?>

                                <?php else: ?>

                                    <tr>

                                        <td colspan="5" class="text-center text-muted">

                                            No document requests found.

                                        </td>

                                    </tr>

                                <?php endif; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/js/scripts.js"></script>

</body>

</html>
