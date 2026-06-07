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

$search = trim($_GET['search'] ?? '');

// ======================================
// CARDS
// ======================================

$pending = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM document_requests
         WHERE status='Pending'"
    )
);

$approved = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM document_requests
         WHERE status='Approved'"
    )
);

$rejected = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM document_requests
         WHERE status='Rejected'"
    )
);

$released = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM document_requests
         WHERE status='Released'"
    )
);

// ======================================
// REQUESTS
// ======================================

$sql = "
SELECT
    dr.*,
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
";

if (!empty($search)) {

    $safe = mysqli_real_escape_string(
        $conn,
        $search
    );

    $sql .= "
    WHERE
        dt.document_name LIKE '%$safe%'
        OR r.first_name LIKE '%$safe%'
        OR r.last_name LIKE '%$safe%'
    ";
}

$sql .= " ORDER BY dr.id DESC";

$requests = mysqli_query($conn, $sql);

$base_url = '../../';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Document Requests
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../../assets/css/styles.css">

</head>

<body>

    <?php include '../../includes/secretary_sidebar.php'; ?>

    <div class="main-wrapper">

        <?php include '../../includes/nav.php'; ?>

        <main class="p-4">

            <!-- PAGE HEADER -->

            <div class="mb-4">

                <h2 class="fw-bold">
                    Document Requests
                </h2>

                <p class="text-muted mb-0">
                    Manage resident document requests
                </p>

            </div>

            <!-- CARDS -->

            <div class="row g-3 mb-4">

                <div class="col-md-3">

                    <div class="card dashboard-card">

                        <div class="card-body">

                            <small class="text-muted">
                                Pending
                            </small>

                            <h3 class="fw-bold text-warning">
                                <?= $pending['total'] ?>
                            </h3>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card dashboard-card">

                        <div class="card-body">

                            <small class="text-muted">
                                Approved
                            </small>

                            <h3 class="fw-bold text-success">
                                <?= $approved['total'] ?>
                            </h3>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card dashboard-card">

                        <div class="card-body">

                            <small class="text-muted">
                                Rejected
                            </small>

                            <h3 class="fw-bold text-danger">
                                <?= $rejected['total'] ?>
                            </h3>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card dashboard-card">

                        <div class="card-body">

                            <small class="text-muted">
                                Released
                            </small>

                            <h3 class="fw-bold text-primary">
                                <?= $released['total'] ?>
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

            <!-- SEARCH -->

            <form method="GET" class="mb-4">

                <div class="input-group">

                    <input type="text" name="search" class="form-control" placeholder="Search resident or document..."
                        value="<?= htmlspecialchars($search) ?>">

                    <button class="btn btn-success">

                        <i class="bi bi-search"></i>

                    </button>

                </div>

            </form>

            <!-- TABLE -->

            <div class="card dashboard-card">

                <div class="card-body table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>ID</th>
                                <th>Resident</th>
                                <th>Document</th>
                                <th>Status</th>
                                <th>Date Requested</th>
                                <th width="300">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php while ($row = mysqli_fetch_assoc($requests)): ?>

                                <tr>

                                    <td>
                                        #
                                        <?= $row['id'] ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['resident_name']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['document_name']) ?>
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

                                        <span class="badge bg-<?= $badge ?>">
                                            <?= $row['status'] ?>
                                        </span>

                                    </td>

                                    <td>
                                        <?= date(
                                            'M d, Y h:i A',
                                            strtotime(
                                                $row['requested_at']
                                            )
                                        ) ?>
                                    </td>

                                    <td>

                                        <!-- VIEW -->

                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#viewModal<?= $row['id'] ?>">

                                            <i class="bi bi-eye"></i>
                                            View

                                        </button>

                                        <?php if ($row['status'] === 'Pending'): ?>

                                            <!-- APPROVE -->

                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#approveModal<?= $row['id'] ?>">

                                                <i class="bi bi-check-circle"></i>
                                                Approve

                                            </button>

                                            <!-- REJECT -->

                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal<?= $row['id'] ?>">

                                                <i class="bi bi-x-circle"></i>
                                                Reject

                                            </button>

                                        <?php endif; ?>

                                        <?php if ($row['status'] === 'Approved'): ?>

                                            <!-- RELEASE -->

                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#releaseModal<?= $row['id'] ?>">

                                                <i class="bi bi-box-seam"></i>

                                            </button>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                                <?php include 'view.php'; ?>

                                <?php if ($row['status'] === 'Pending'): ?>
                                    <?php include 'approve.php'; ?>
                                    <?php include 'reject.php'; ?>
                                <?php endif; ?>

                                <?php if ($row['status'] === 'Approved'): ?>
                                    <?php include 'release.php'; ?>
                                <?php endif; ?>

                            <?php endwhile; ?>

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
