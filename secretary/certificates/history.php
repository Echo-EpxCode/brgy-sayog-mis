<?php

require '../../config/database.php';
require '../../config/session.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'secretary') {
    header("Location: ../../auth/login.php");
    exit;
}

// SEARCH
$search = trim($_GET['search'] ?? '');

$sql = "
SELECT
    c.*,
    dr.status,
    dr.purpose,
    dt.document_name,
    r.first_name,
    r.last_name
FROM certificates c
INNER JOIN document_requests dr ON c.request_id = dr.id
INNER JOIN document_types dt ON dr.document_type_id = dt.id
INNER JOIN residents r ON dr.resident_id = r.id
WHERE 1=1
";

if (!empty($search)) {

    $safe = mysqli_real_escape_string($conn, $search);

    $sql .= "
    AND (
        c.certificate_no LIKE '%$safe%'
        OR dt.document_name LIKE '%$safe%'
        OR r.last_name LIKE '%$safe%'
        OR c.file_path LIKE '%$safe%'
    )
    ";
}

$sql .= " ORDER BY c.id DESC";

$result = mysqli_query($conn, $sql);

$base_url = '../../';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificate History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/css/styles.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php include '../../includes/nav.php'; ?>
    <?php include '../../includes/secretary_sidebar.php'; ?>

    <div class="main-wrapper">

        <main class="p-4">

            <h3 class="fw-bold mb-3">Certificate History</h3>
            <p class="text-muted">Audit trail of all issued certificates</p>

            <!-- SEARCH -->
            <form method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search certificate..."
                        value="<?= htmlspecialchars($search) ?>">

                    <button class="btn btn-success">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <div class="card shadow-sm">
                <div class="card-body table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Certificate No</th>
                                <th>Document</th>
                                <th>Resident</th>
                                <th>Status</th>
                                <th>File</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (mysqli_num_rows($result) > 0): ?>

                                <?php while ($row = mysqli_fetch_assoc($result)): ?>

                                    <tr>

                                        <td><?= $row['id'] ?></td>

                                        <td class="fw-bold">
                                            <?= htmlspecialchars($row['certificate_no']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['document_name']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>
                                        </td>

                                        <td>
                                            <span class="badge bg-success">
                                                Issued
                                            </span>
                                        </td>

                                        <td>

                                            <?php if (!empty($row['file_path'])): ?>

                                                <?php if (file_exists($row['file_path'])): ?>

                                                    <a href="<?= $row['file_path'] ?>" class="btn btn-sm btn-primary" target="_blank">
                                                        Download
                                                    </a>

                                                <?php else: ?>

                                                    <span class="badge bg-danger">
                                                        Missing File
                                                    </span>

                                                <?php endif; ?>

                                            <?php else: ?>

                                                <span class="badge bg-warning">
                                                    No File Path
                                                </span>

                                            <?php endif; ?>

                                        </td>

                                        <td>
                                            <?= date('M d, Y h:i A', strtotime($row['issued_date'])) ?>
                                        </td>

                                    </tr>

                                <?php endwhile; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        No certificates found
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
