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

// ======================================
// FILTER
// ======================================

$type = $_GET['type'] ?? 'requests';
$search = trim($_GET['search'] ?? '');

// ======================================
// SUMMARY CARDS
// ======================================

// Residents
$residents = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM residents")
);

// Pending registrations
$pending_users = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='resident' AND status='pending'")
);

// Requests
$total_requests = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM document_requests")
);

// Certificates
$total_certificates = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM certificates")
);

// ======================================
// REPORT DATA
// ======================================

$data = [];

if ($type === 'requests') {

    $sql = "
        SELECT
            dr.id,
            CONCAT(r.first_name, ' ', r.last_name) AS resident_name,
            dt.document_name,
            dr.status,
            dr.requested_at
        FROM document_requests dr
        INNER JOIN residents r ON dr.resident_id = r.id
        INNER JOIN document_types dt ON dr.document_type_id = dt.id
        WHERE 1=1
    ";

    if (!empty($search)) {
        $safe = mysqli_real_escape_string($conn, $search);
        $sql .= "
            AND (
                r.first_name LIKE '%$safe%'
                OR r.last_name LIKE '%$safe%'
                OR dt.document_name LIKE '%$safe%'
            )
        ";
    }

    $sql .= " ORDER BY dr.id DESC";

    $data = mysqli_query($conn, $sql);
}

// ======================================
// CERTIFICATES REPORT
// ======================================

if ($type === 'certificates') {

    $sql = "
        SELECT
            c.certificate_no,
            c.issued_date,
            c.issued_by,
            CONCAT(r.first_name, ' ', r.last_name) AS resident_name,
            dt.document_name
        FROM certificates c
        INNER JOIN document_requests dr ON c.request_id = dr.id
        INNER JOIN residents r ON dr.resident_id = r.id
        INNER JOIN document_types dt ON dr.document_type_id = dt.id
        WHERE 1=1
    ";

    if (!empty($search)) {
        $safe = mysqli_real_escape_string($conn, $search);
        $sql .= "
            AND (
                c.certificate_no LIKE '%$safe%'
                OR r.first_name LIKE '%$safe%'
                OR r.last_name LIKE '%$safe%'
            )
        ";
    }

    $sql .= " ORDER BY c.id DESC";

    $data = mysqli_query($conn, $sql);
}

$base_url = '../../';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reports</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../../assets/css/styles.css">

</head>

<body>

    <?php include '../../includes/secretary_sidebar.php'; ?>

    <div class="main-wrapper">

        <?php include '../../includes/nav.php'; ?>

        <main class="p-4">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2 class="fw-bold">Reports</h2>
                    <p class="text-muted mb-0">System-wide analytics and summaries</p>

                </div>

                <form method="GET" class="d-flex gap-2">

                    <select name="type" class="form-select">

                        <option value="requests" <?= $type === 'requests' ? 'selected' : '' ?>>
                            Requests
                        </option>

                        <option value="certificates" <?= $type === 'certificates' ? 'selected' : '' ?>>
                            Certificates
                        </option>

                    </select>

                    <input type="text" name="search" class="form-control" placeholder="Search..."
                        value="<?= htmlspecialchars($search) ?>">

                    <button class="btn btn-success">
                        <i class="bi bi-search"></i>
                    </button>

                </form>

            </div>

            <!-- CARDS -->
            <div class="row g-3 mb-4">

                <div class="col-md-3">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <small>Residents</small>
                            <h4>
                                <?= $residents['total'] ?>
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <small>Pending Users</small>
                            <h4>
                                <?= $pending_users['total'] ?>
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <small>Requests</small>
                            <h4>
                                <?= $total_requests['total'] ?>
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <small>Certificates</small>
                            <h4>
                                <?= $total_certificates['total'] ?>
                            </h4>
                        </div>
                    </div>
                </div>

            </div>

            <!-- TABLE -->
            <div class="card dashboard-card">

                <div class="card-body table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <?php if ($type === 'requests'): ?>

                                <tr>
                                    <th>Resident</th>
                                    <th>Document</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>

                            <?php else: ?>

                                <tr>
                                    <th>Certificate No</th>
                                    <th>Resident</th>
                                    <th>Document</th>
                                    <th>Issued Date</th>
                                </tr>

                            <?php endif; ?>

                        </thead>

                        <tbody>

                            <?php if (mysqli_num_rows($data) > 0): ?>

                                <?php while ($row = mysqli_fetch_assoc($data)): ?>

                                    <tr>

                                        <?php if ($type === 'requests'): ?>

                                            <td>
                                                <?= htmlspecialchars($row['resident_name']) ?>
                                            </td>
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

                                        <?php else: ?>

                                            <td>
                                                <?= htmlspecialchars($row['certificate_no']) ?>
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($row['resident_name']) ?>
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($row['document_name']) ?>
                                            </td>
                                            <td>
                                                <?= date('M d, Y', strtotime($row['issued_date'])) ?>
                                            </td>

                                        <?php endif; ?>

                                    </tr>

                                <?php endwhile; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No data found
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
