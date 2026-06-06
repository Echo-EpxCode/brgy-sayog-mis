<?php

require '../../config/database.php';
require '../../config/session.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'secretary') {
    header('Location: ../../auth/login.php');
    exit;
}

$search = trim($_GET['search'] ?? '');

// ======================================
// CERTIFICATE LIST
// ======================================

$sql = "
SELECT
    c.id,
    c.certificate_no,
    c.issued_date,
    c.issued_by,
    r.first_name,
    r.last_name,
    dt.document_name
FROM certificates c
INNER JOIN document_requests dr
    ON c.request_id = dr.id
INNER JOIN residents r
    ON dr.resident_id = r.id
INNER JOIN document_types dt
    ON dr.document_type_id = dt.id
WHERE 1=1
";

if (!empty($search)) {

    $safe = mysqli_real_escape_string($conn, $search);

    $sql .= "
    AND (
        c.certificate_no LIKE '%$safe%'
        OR r.first_name LIKE '%$safe%'
        OR r.last_name LIKE '%$safe%'
        OR dt.document_name LIKE '%$safe%'
    )
    ";
}

$sql .= " ORDER BY c.id DESC";

$result = mysqli_query($conn, $sql);

// ======================================
// BASE URL FOR SIDEBAR
// ======================================

$base_url = '../../';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Certificate History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/css/styles.css" rel="stylesheet">

</head>

<body class="bg-light">

    <?php include '../../includes/secretary_sidebar.php'; ?>

    <div class="main-wrapper">

        <?php include '../../includes/nav.php'; ?>

        <main class="p-4">

            <!-- HEADER -->
            <div class="mb-4">

                <h2 class="fw-bold">
                    Certificate History
                </h2>

                <p class="text-muted">
                    List of all generated barangay certificates
                </p>

            </div>

            <!-- SEARCH -->
            <form method="GET" class="mb-4">

                <div class="input-group">

                    <input type="text" name="search" class="form-control"
                        placeholder="Search certificate, resident, or document..."
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

                        <thead class="table-light">

                            <tr>
                                <th>Certificate No</th>
                                <th>Resident</th>
                                <th>Document</th>
                                <th>Date Issued</th>
                                <th>Issued By (User ID)</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php if (mysqli_num_rows($result) > 0): ?>

                                <?php while ($row = mysqli_fetch_assoc($result)): ?>

                                    <tr>

                                        <td>
                                            <?= htmlspecialchars($row['certificate_no']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['document_name']) ?>
                                        </td>

                                        <td>
                                            <?= date('M d, Y', strtotime($row['issued_date'])) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['issued_by']) ?>
                                        </td>

                                        <td>
                                            <a href="print.php?id=<?= $row['id'] ?>" target="_blank"
                                                class="btn btn-sm btn-primary">

                                                <i class="bi bi-printer"></i>
                                            </a>
                                            <!-- <a href="generate_pdf.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success">

                                                <i class="bi bi-file-earmark-pdf"></i>

                                            </a> -->
                                        </td>

                                    </tr>

                                <?php endwhile; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="5" class="text-center text-muted">
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
