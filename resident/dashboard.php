<?php

require '../config/database.php';
require '../config/session.php';

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'resident'
) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// ======================================
// GET RESIDENT ID
// ======================================

$res_query = mysqli_query(
    $conn,
    "SELECT id FROM residents WHERE user_id = $user_id LIMIT 1"
);

$resident = mysqli_fetch_assoc($res_query);
$resident_id = $resident['id'] ?? 0;

// ======================================
// REQUEST STATS
// ======================================

$total_requests = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM document_requests
         WHERE resident_id = $resident_id"
    )
);

$pending_requests = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM document_requests
         WHERE resident_id = $resident_id
         AND status = 'Pending'"
    )
);

$approved_requests = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM document_requests
         WHERE resident_id = $resident_id
         AND status = 'Approved'"
    )
);

$released_requests = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM document_requests
         WHERE resident_id = $resident_id
         AND status = 'Released'"
    )
);

// ======================================
// RECENT REQUESTS
// ======================================

$recent_requests = mysqli_query(
    $conn,
    "SELECT dr.*, dt.document_name
     FROM document_requests dr
     INNER JOIN document_types dt
        ON dr.document_type_id = dt.id
     WHERE dr.resident_id = $resident_id
     ORDER BY dr.id DESC
     LIMIT 5"
);

// ======================================
// ANNOUNCEMENTS
// ======================================

$announcements = mysqli_query(
    $conn,
    "SELECT *
     FROM announcements
     WHERE status = 'Published'
     ORDER BY id DESC
     LIMIT 5"
);

$base_url = '../';


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Resident Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">

</head>

<body class="bg-light">

    <?php include '../includes/resident_sidebar.php'; ?>

    <div class="main-wrapper">

        <?php include '../includes/nav.php'; ?>

        <main class="p-4">

            <!-- HEADER -->
            <div class="mb-4">

                <h2 class="fw-bold">
                    Welcome,
                    <?= htmlspecialchars($_SESSION['full_name']) ?>
                </h2>

                <p class="text-muted">
                    Resident Dashboard Overview
                </p>

            </div>

            <!-- STATS CARDS -->
            <div class="row g-3 mb-4">

                <div class="col-md-3">

                    <div class="card dashboard-card">
                        <div class="card-body">
                            <small>Total Requests</small>
                            <h3 class="fw-bold">
                                <?= $total_requests['total'] ?>
                            </h3>
                        </div>
                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card dashboard-card">
                        <div class="card-body">
                            <small>Pending</small>

                            <h3 class="fw-bold text-warning">
                                <?= $pending_requests['total'] ?>
                            </h3>
                        </div>
                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card dashboard-card">
                        <div class="card-body">

                            <small>Approved</small>
                            <h3 class="fw-bold text-success">
                                <?= $approved_requests['total'] ?>
                            </h3>
                        </div>
                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card dashboard-card">

                        <div class="card-body">
                            <small>Released</small>
                            <h3 class="fw-bold text-primary">
                                <?= $released_requests['total'] ?>
                            </h3>
                        </div>
                    </div>

                </div>

            </div>

            <!-- TWO COLUMN SECTION -->
            <div class="row g-4">

                <!-- RECENT REQUESTS -->
                <div class="col-md-6">

                    <div class="card dashboard-card">

                        <div class="card-header bg-white">
                            <h5 class="mb-0">My Recent Requests</h5>
                        </div>

                        <div class="card-body table-responsive">

                            <table class="table table-sm table-hover align-middle">

                                <thead>
                                    <tr>
                                        <th>Document</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php if (mysqli_num_rows($recent_requests) > 0): ?>
                                        <?php while ($row = mysqli_fetch_assoc($recent_requests)): ?>
                                            <tr>
                                                <td>
                                                    <?= htmlspecialchars($row['document_name']) ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        <?= $row['status'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?= date('M d, Y', strtotime($row['requested_at'])) ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>

                                        <tr>
                                            <td colspan="3" class="text-center text-muted">
                                                No requests yet
                                            </td>
                                        </tr>

                                    <?php endif; ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

                <!-- ANNOUNCEMENTS -->
                <div class="col-md-6">

                    <div class="card dashboard-card">

                        <div class="card-header bg-white">
                            <h5 class="mb-0">Announcements</h5>
                        </div>

                        <div class="card-body">
                            <?php if (mysqli_num_rows($announcements) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($announcements)): ?>
                                    <div class="mb-3 border-bottom pb-2">
                                        <h6 class="fw-bold mb-1">
                                            <?= htmlspecialchars($row['title']) ?>
                                        </h6>
                                        <small class="text-muted">
                                            <?= date('M d, Y', strtotime($row['created_at'])) ?>
                                        </small>
                                        <p class="mb-0 small">
                                            <?= nl2br(htmlspecialchars($row['content'])) ?>
                                        </p>

                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>

                                <p class="text-muted">
                                    No announcements available
                                </p>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/scripts.js"></script>

</body>

</html>
