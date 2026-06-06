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

$user_id = $_SESSION['user_id'];

$message = "";

// ======================================
// GET RESIDENT ID
// ======================================

$res = mysqli_query(
    $conn,
    "SELECT id FROM residents WHERE user_id = $user_id LIMIT 1"
);

$resident = mysqli_fetch_assoc($res);
$resident_id = $resident['id'] ?? 0;

// ======================================
// SUBMIT REQUEST
// ======================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $document_type_id = (int) $_POST['document_type_id'];
    $purpose = trim($_POST['purpose']);

    if ($document_type_id <= 0 || empty($purpose)) {
        $message = "All fields are required.";
    } else {

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO document_requests
            (resident_id, document_type_id, purpose, status)
            VALUES (?, ?, ?, 'Pending')"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "iis",
            $resident_id,
            $document_type_id,
            $purpose
        );

        mysqli_stmt_execute($stmt);

        header("Location: ../requests/index.php?success=1");
        exit;
    }
}

// ======================================
// GET DOCUMENT TYPES
// ======================================

$docs = mysqli_query(
    $conn,
    "SELECT * FROM document_types ORDER BY document_name ASC"
);

// REQUIRED FOR SIDEBAR ACTIVE STATE
$base_url = '../../';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Request Document</title>

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
                    Request Document
                </h2>

                <p class="text-muted">
                    Submit a new barangay document request
                </p>

            </div>

            <!-- ALERT -->
            <?php if (!empty($message)): ?>

                <div class="alert alert-danger">
                    <?= $message ?>
                </div>

            <?php endif; ?>

            <!-- FORM -->
            <div class="card dashboard-card">

                <div class="card-body">

                    <form method="POST">

                        <!-- DOCUMENT TYPE -->
                        <div class="mb-3">

                            <label class="form-label">Document Type</label>

                            <select name="document_type_id" class="form-select" required>

                                <option value="">Select document</option>

                                <?php while ($row = mysqli_fetch_assoc($docs)): ?>

                                    <option value="<?= $row['id'] ?>">
                                        <?= htmlspecialchars($row['document_name']) ?>
                                    </option>

                                <?php endwhile; ?>

                            </select>

                        </div>

                        <!-- PURPOSE -->
                        <div class="mb-3">

                            <label class="form-label">Purpose</label>

                            <textarea name="purpose" class="form-control" rows="4" required></textarea>

                        </div>

                        <!-- SUBMIT -->
                        <button type="submit" class="btn btn-success">

                            <i class="bi bi-send"></i>
                            Submit Request

                        </button>

                    </form>

                </div>

            </div>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/scripts.js"></script>

</body>

</html>
