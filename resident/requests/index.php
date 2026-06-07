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

$user_id = (int) $_SESSION['user_id'];

// ======================================
// GET RESIDENT ID
// ======================================

$stmt = mysqli_prepare(
    $conn,
    "SELECT id
     FROM residents
     WHERE user_id = ?
     LIMIT 1"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$resident = mysqli_fetch_assoc(
    mysqli_stmt_get_result($stmt)
);

$resident_id = $resident['id'] ?? 0;

if (!$resident_id) {
    die('Resident profile not found.');
}

// ======================================
// SEARCH
// ======================================

$search = trim($_GET['search'] ?? '');

// ======================================
// REQUESTS QUERY
// ======================================

$sql = "
SELECT
    dr.id,
    dr.purpose,
    dr.status,
    dr.requested_at,

    dt.document_name,

    c.certificate_no,
    c.file_path,

    r.household_no,
    r.first_name,
    r.middle_name,
    r.last_name,
    r.suffix,
    r.contact_no,
    r.address

FROM document_requests dr

INNER JOIN residents r
    ON dr.resident_id = r.id

INNER JOIN document_types dt
    ON dr.document_type_id = dt.id

LEFT JOIN certificates c
    ON dr.id = c.request_id

WHERE dr.resident_id = ?
";

if (!empty($search)) {

    $safe = '%' . $search . '%';

    $sql .= "
    AND (
        dt.document_name LIKE ?
        OR dr.status LIKE ?
        OR dr.purpose LIKE ?
    )
    ";
}

$sql .= " ORDER BY dr.id DESC";

$stmt = mysqli_prepare($conn, $sql);

if (!empty($search)) {

    mysqli_stmt_bind_param(
        $stmt,
        "isss",
        $resident_id,
        $safe,
        $safe,
        $safe
    );

} else {

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $resident_id
    );
}

mysqli_stmt_execute($stmt);

$requests = mysqli_stmt_get_result($stmt);

// REQUIRED FOR SIDEBAR
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
            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2 class="fw-bold mb-1">
                        My Document Requests
                    </h2>

                    <p class="text-muted mb-0">
                        Track your requests and download approved certificates
                    </p>

                </div>

            </div>

            <!-- SEARCH -->
            <div class="card shadow-sm mb-4">

                <div class="card-body">

                    <form method="GET">

                        <div class="input-group">

                            <input type="text" name="search" class="form-control"
                                placeholder="Search document, purpose, status..."
                                value="<?= htmlspecialchars($search) ?>">

                            <button class="btn btn-success">

                                <i class="bi bi-search"></i>

                            </button>

                        </div>

                    </form>

                </div>

            </div>

            <!-- REQUEST TABLE -->
            <div class="card shadow-sm">

                <div class="card-body table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>#</th>
                                <th>Document</th>
                                <th>Purpose</th>
                                <th>Status</th>
                                <th>Date Requested</th>
                                <th width="220">Action</th>

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

                                            <strong>
                                                <?= htmlspecialchars($row['document_name']) ?>
                                            </strong>

                                            <?php if (!empty($row['certificate_no'])): ?>

                                                <br>

                                                <small class="text-muted">
                                                    <?= htmlspecialchars($row['certificate_no']) ?>
                                                </small>

                                            <?php endif; ?>

                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['purpose']) ?>
                                        </td>

                                        <td>

                                            <?php
                                            $badge = 'secondary';

                                            switch ($row['status']) {

                                                case 'Pending':
                                                    $badge = 'warning';
                                                    break;

                                                case 'Released':
                                                    $badge = 'success';
                                                    break;

                                                case 'Rejected':
                                                    $badge = 'danger';
                                                    break;
                                            }
                                            ?>

                                            <span class="badge bg-<?= $badge ?>">
                                                <?= htmlspecialchars($row['status']) ?>
                                            </span>

                                        </td>

                                        <td>

                                            <?= date(
                                                'M d, Y h:i A',
                                                strtotime($row['requested_at'])
                                            ) ?>

                                        </td>

                                        <td>

                                            <!-- VIEW DETAILS -->
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#viewModal<?= $row['id'] ?>">

                                                <i class="bi bi-eye"></i>

                                            </button>

                                            <?php if ($row['status'] === 'Pending'): ?>

                                                <span class="badge bg-warning text-dark">
                                                    Waiting for Approval
                                                </span>

                                            <?php elseif ($row['status'] === 'Approved'): ?>

                                                <span class="badge bg-info">
                                                    Approved
                                                </span>

                                            <?php elseif ($row['status'] === 'Rejected'): ?>

                                                <span class="badge bg-danger">
                                                    Rejected
                                                </span>

                                            <?php elseif ($row['status'] === 'Released'): ?>

                                                <?php if (!empty($row['file_path'])): ?>

                                                    <a href="download.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">

                                                        <i class="bi bi-download"></i>
                                                        Download

                                                    </a>

                                                <?php else: ?>

                                                    <span class="badge bg-secondary">
                                                        File Missing
                                                    </span>

                                                <?php endif; ?>

                                            <?php endif; ?>

                                        </td>
                                        <?php include 'view_modal.php'; ?>

                                    </tr>

                                <?php endwhile; ?>

                            <?php else: ?>

                                <tr>

                                    <td colspan="6" class="text-center py-4 text-muted">

                                        No document requests found.

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
