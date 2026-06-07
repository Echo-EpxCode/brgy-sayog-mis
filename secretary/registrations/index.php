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
// APPROVE REGISTRATION
// ======================================

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['approve_user_id'])
) {

    $user_id = (int) $_POST['approve_user_id'];

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE users
         SET status='approved'
         WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $user_id
    );

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}

// ======================================
// REJECT REGISTRATION
// ======================================

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['reject_user_id'])
) {

    $user_id = (int) $_POST['reject_user_id'];

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE users
         SET status='rejected'
         WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $user_id
    );

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}

$base_url = '../../';

$search = trim($_GET['search'] ?? '');

// ======================================
// CARDS
// ======================================

$pending = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM users
         WHERE role='resident'
         AND status='pending'"
    )
);

$approved = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM users
         WHERE role='resident'
         AND status='approved'"
    )
);

$rejected = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM users
         WHERE role='resident'
         AND status='rejected'"
    )
);

// ======================================
// REGISTRATIONS
// ======================================

$sql = "
SELECT
    u.id AS user_id,
    u.full_name,
    u.email,
    u.status,

    r.id AS resident_id,
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
    r.citizenship,
    r.created_at
FROM users u
INNER JOIN residents r
    ON u.id = r.user_id
WHERE u.role='resident'
";

if (!empty($search)) {

    $safe = mysqli_real_escape_string(
        $conn,
        $search
    );

    $sql .= "
    AND (
        u.full_name LIKE '%$safe%'
        OR u.email LIKE '%$safe%'
        OR r.household_no LIKE '%$safe%'
    )
    ";
}

$sql .= " ORDER BY r.id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Registrations
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
                    Resident Registrations
                </h2>

                <p class="text-muted mb-0">
                    Review and approve resident accounts
                </p>

            </div>

            <!-- CARDS -->

            <div class="row g-3 mb-4">

                <div class="col-md-4">

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

                <div class="col-md-4">

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

                <div class="col-md-4">

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

            </div>

            <!-- SEARCH -->

            <form method="GET" class="mb-4">

                <div class="input-group">

                    <input type="text" name="search" class="form-control" placeholder="Search resident..."
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

                                <th>Name</th>
                                <th>Email</th>
                                <th>Household No.</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th width="180">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php while ($row = mysqli_fetch_assoc($result)): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars(
                                            trim(
                                                $row['first_name'] . ' ' .
                                                $row['middle_name'] . ' ' .
                                                $row['last_name'] . ' ' .
                                                $row['suffix']
                                            )
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['email']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['household_no']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['gender']) ?>
                                    </td>

                                    <td>

                                        <?php
                                        $badge = 'secondary';

                                        if ($row['status'] === 'pending') {
                                            $badge = 'warning';
                                        }

                                        if ($row['status'] === 'approved') {
                                            $badge = 'success';
                                        }

                                        if ($row['status'] === 'rejected') {
                                            $badge = 'danger';
                                        }
                                        ?>

                                        <span class="badge bg-<?= $badge ?>">
                                            <?= ucfirst($row['status']) ?>
                                        </span>

                                    </td>
                                    <td>

                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#viewModal<?= $row['user_id'] ?>">

                                            <i class="bi bi-eye"></i>

                                        </button>

                                        <?php if ($row['status'] === 'pending'): ?>

                                            <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#approveModal<?= $row['user_id'] ?>">

                                                <i class="bi bi-check-circle"></i>

                                            </button>

                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal<?= $row['user_id'] ?>">

                                                <i class="bi bi-x-circle"></i>

                                            </button>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                                <?php if ($row['status'] === 'pending'): ?>

                                    <?php include 'approve.php'; ?>
                                    <?php include 'reject.php'; ?>

                                <?php endif; ?>

                                <?php include 'view_modal.php'; ?>

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
