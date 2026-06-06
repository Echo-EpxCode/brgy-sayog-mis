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
// ADD ANNOUNCEMENT
// ======================================

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['add_announcement'])
) {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $status = $_POST['status'];
    $posted_by = $_SESSION['user_id'];

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO announcements
        (
            title,
            content,
            posted_by,
            status
        )
        VALUES
        (
            ?, ?, ?, ?
        )"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssis",
        $title,
        $content,
        $posted_by,
        $status
    );

    mysqli_stmt_execute($stmt);

    header('Location: index.php');
    exit;
}

// ======================================
// UPDATE ANNOUNCEMENT
// ======================================

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['update_announcement'])
) {

    $id = (int) $_POST['id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $status = $_POST['status'];

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE announcements
         SET title=?,
             content=?,
             status=?
         WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sssi",
        $title,
        $content,
        $status,
        $id
    );

    mysqli_stmt_execute($stmt);

    header('Location: index.php');
    exit;
}

// ======================================
// DELETE ANNOUNCEMENT
// ======================================

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['delete_announcement'])
) {

    $id = (int) $_POST['id'];

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM announcements
         WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    mysqli_stmt_execute($stmt);

    header('Location: index.php');
    exit;
}

// ======================================
// CARDS
// ======================================

$total = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM announcements"
    )
);

$published = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM announcements
         WHERE status='Published'"
    )
);

$draft = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM announcements
         WHERE status='Draft'"
    )
);

// ======================================
// LIST
// ======================================

$sql = "
SELECT
    a.*,
    u.full_name
FROM announcements a
LEFT JOIN users u
    ON a.posted_by = u.id
";

if (!empty($search)) {

    $safe = mysqli_real_escape_string(
        $conn,
        $search
    );

    $sql .= "
    WHERE
        a.title LIKE '%$safe%'
        OR a.content LIKE '%$safe%'
    ";
}

$sql .= " ORDER BY a.id DESC";

$announcements = mysqli_query(
    $conn,
    $sql
);

$base_url = '../../';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Announcements
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../../assets/css/styles.css">

</head>

<body>

    <?php include '../../includes/secretary_sidebar.php'; ?>

    <div class="main-wrapper">

        <?php include '../../includes/nav.php'; ?>

        <main class="p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2 class="fw-bold">
                        Announcements
                    </h2>

                    <p class="text-muted mb-0">
                        Manage barangay announcements
                    </p>

                </div>

                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">

                    <i class="bi bi-plus-circle"></i>
                    Add Announcement

                </button>

            </div>

            <!-- CARDS -->

            <div class="row g-3 mb-4">

                <div class="col-md-4">

                    <div class="card dashboard-card">

                        <div class="card-body">

                            <small>Total</small>

                            <h3 class="fw-bold">
                                <?= $total['total'] ?>
                            </h3>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card dashboard-card">

                        <div class="card-body">

                            <small>Published</small>

                            <h3 class="fw-bold text-success">
                                <?= $published['total'] ?>
                            </h3>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card dashboard-card">

                        <div class="card-body">

                            <small>Draft</small>

                            <h3 class="fw-bold text-warning">
                                <?= $draft['total'] ?>
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

            <!-- SEARCH -->

            <form method="GET" class="mb-4">

                <div class="input-group">

                    <input type="text" name="search" class="form-control" placeholder="Search announcement..."
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

                                <th>Title</th>
                                <th>Status</th>
                                <th>Posted By</th>
                                <th>Date</th>
                                <th width="150">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php while ($row = mysqli_fetch_assoc($announcements)): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars($row['title']) ?>
                                    </td>

                                    <td>

                                        <span
                                            class="badge bg-<?= $row['status'] === 'Published' ? 'success' : 'warning' ?>">

                                            <?= $row['status'] ?>

                                        </span>

                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['full_name'] ?? 'N/A') ?>
                                    </td>

                                    <td>
                                        <?= date('M d, Y', strtotime($row['created_at'])) ?>
                                    </td>

                                    <td>

                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#edit<?= $row['id'] ?>">

                                            <i class="bi bi-pencil"></i>

                                        </button>

                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#delete<?= $row['id'] ?>">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </td>

                                </tr>

                                <?php include 'edit_modal.php'; ?>
                                <?php include 'delete_modal.php'; ?>

                            <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </main>

    </div>

    <?php include 'add_modal.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/scripts.js"></script>

</body>

</html>
