<?php

require '../../config/database.php';
require '../../config/session.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'secretary') {
    header("Location: ../../auth/login.php");
    exit;
}

// SEARCH
$search = $_GET['search'] ?? "";

// STATS
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM residents"));
$male = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM residents WHERE gender='Male'"));
$female = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM residents WHERE gender='Female'"));

// QUERY
$sql = "
SELECT r.*, u.status
FROM residents r
INNER JOIN users u ON r.user_id = u.id
WHERE u.status='approved'
";

if (!empty($search)) {
    $safe = mysqli_real_escape_string($conn, $search);
    $sql .= " AND (
        r.first_name LIKE '%$safe%' OR
        r.last_name LIKE '%$safe%' OR
        r.household_no LIKE '%$safe%'
    )";
}

$sql .= " ORDER BY r.last_name ASC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Residents</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="../../assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <?php $base_url = '../../'; ?>
    <?php include '../../includes/secretary_sidebar.php'; ?>

    <div class="main-wrapper">

        <?php include '../../includes/nav.php'; ?>

        <main class="p-4">

            <!-- HEADER -->
            <div class="mb-4">
                <h2 class="fw-bold">Residents</h2>
                <p class="text-muted">Manage approved residents</p>
            </div>

            <!-- STATS -->
            <div class="row g-3 mb-4">

                <div class="col-md-4">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h6>Total Residents</h6>
                            <h3><?= $total['total'] ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h6>Male</h6>
                            <h3><?= $male['total'] ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h6>Female</h6>
                            <h3><?= $female['total'] ?></h3>
                        </div>
                    </div>
                </div>

            </div>

            <!-- SEARCH -->
            <form method="GET" class="mb-3">
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
                                <th>Household</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php while ($row = mysqli_fetch_assoc($result)): ?>

                                <tr>

                                    <td><?= htmlspecialchars($row['household_no']) ?></td>

                                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>

                                    <td><?= htmlspecialchars($row['gender']) ?></td>

                                    <td><?= htmlspecialchars($row['contact_no']) ?></td>

                                    <td>
                                        <span class="badge bg-success">
                                            <?= $row['status'] ?>
                                        </span>
                                    </td>

                                    <td>

                                        <!-- VIEW BUTTON -->
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#viewModal<?= $row['id'] ?>">
                                            <i class="bi bi-eye"></i>
                                            View
                                        </button>

                                        <!-- EDIT BUTTON -->
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal<?= $row['id'] ?>">
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </button>

                                    </td>

                                </tr>

                                <!-- ================= VIEW MODAL ================= -->
                                <div class="modal fade" id="viewModal<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Resident Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">

                                                <p><b>Name:</b> <?= $row['first_name'] . ' ' . $row['last_name'] ?></p>
                                                <p><b>Household:</b> <?= $row['household_no'] ?></p>
                                                <p><b>Gender:</b> <?= $row['gender'] ?></p>
                                                <p><b>Birth Date:</b> <?= $row['birth_date'] ?></p>
                                                <p><b>Contact:</b> <?= $row['contact_no'] ?></p>
                                                <p><b>Address:</b> <?= $row['address'] ?></p>
                                                <p><b>Status:</b> <?= $row['status'] ?></p>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- ================= EDIT MODAL ================= -->
                                <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <form action="update.php" method="POST">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Resident</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">

                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">

                                                    <div class="mb-3">
                                                        <label>Household No</label>
                                                        <input type="text" name="household_no" class="form-control"
                                                            value="<?= $row['household_no'] ?>">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Contact</label>
                                                        <input type="text" name="contact_no" class="form-control"
                                                            value="<?= $row['contact_no'] ?>">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Address</label>
                                                        <input type="text" name="address" class="form-control"
                                                            value="<?= $row['address'] ?>">
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-success">
                                                        Save Changes
                                                    </button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>

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
