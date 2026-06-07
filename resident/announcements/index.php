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

// ======================================
// GET ANNOUNCEMENTS
// ======================================

$sql = "
SELECT *
FROM announcements
WHERE status = 'Published'
ORDER BY id DESC
";

$announcements = mysqli_query($conn, $sql);

// REQUIRED FOR SIDEBAR ACTIVE STATE
$base_url = '../../';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Announcements</title>

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
            <div class="mb-4">

                <h2 class="fw-bold">
                    Barangay Announcements
                </h2>

                <p class="text-muted">
                    Official updates and community notices
                </p>

            </div>

            <!-- CONTENT -->
            <div class="row g-3">

                <?php if (mysqli_num_rows($announcements) > 0): ?>

                    <?php while ($row = mysqli_fetch_assoc($announcements)): ?>

                        <div class="col-md-6">

                            <div class="card dashboard-card h-100">

                                <div class="card-body">

                                    <!-- TITLE -->
                                    <h5 class="fw-bold mb-2">
                                        <?= htmlspecialchars($row['title']) ?>
                                    </h5>

                                    <!-- DATE -->
                                    <small class="text-muted d-block mb-2">
                                        <?= date('M d, Y h:i A', strtotime($row['created_at'])) ?>
                                    </small>

                                    <!-- CONTENT -->
                                    <p class="mb-0 text-secondary">
                                        <?= nl2br(htmlspecialchars($row['content'])) ?>
                                    </p>

                                </div>

                            </div>

                        </div>

                    <?php endwhile; ?>

                <?php else: ?>

                    <div class="col-12">

                        <div class="alert alert-info text-center">
                            No announcements available at the moment.
                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/scripts.js"></script>

</body>

</html>
