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

$success = '';
$error = '';

// ======================================
// UPDATE PROFILE
// ======================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $contact_no = trim($_POST['contact_no']);
    $address = trim($_POST['address']);
    $occupation = trim($_POST['occupation']);
    $civil_status = trim($_POST['civil_status']);

    if (
        empty($full_name) ||
        empty($email)
    ) {

        $error = "Full Name and Email are required.";

    } else {

        mysqli_begin_transaction($conn);

        try {

            // USERS TABLE

            $stmt = mysqli_prepare(
                $conn,
                "UPDATE users
                 SET full_name=?,
                     email=?
                 WHERE id=?"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssi",
                $full_name,
                $email,
                $user_id
            );

            mysqli_stmt_execute($stmt);

            // RESIDENTS TABLE

            $stmt = mysqli_prepare(
                $conn,
                "UPDATE residents
                 SET contact_no=?,
                     address=?,
                     occupation=?,
                     civil_status=?
                 WHERE user_id=?"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssssi",
                $contact_no,
                $address,
                $occupation,
                $civil_status,
                $user_id
            );

            mysqli_stmt_execute($stmt);

            mysqli_commit($conn);

            $success = "Profile updated successfully.";

        } catch (Exception $e) {

            mysqli_rollback($conn);

            $error = "Failed to update profile.";
        }
    }
}

// ======================================
// LOAD PROFILE
// ======================================

$stmt = mysqli_prepare(
    $conn,
    "SELECT
        u.full_name,
        u.email,
        r.household_no,
        r.contact_no,
        r.address,
        r.occupation,
        r.civil_status,
        r.gender
     FROM users u
     INNER JOIN residents r
        ON u.id = r.user_id
     WHERE u.id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$profile = mysqli_fetch_assoc($result);

$base_url = '../../';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../../assets/css/styles.css">

</head>

<body>

    <?php include '../../includes/resident_sidebar.php'; ?>

    <div class="main-wrapper">

        <?php include '../../includes/nav.php'; ?>

        <main class="p-4">

            <!-- HEADER -->

            <div class="mb-4">

                <h2 class="fw-bold">
                    My Profile
                </h2>

                <p class="text-muted">
                    Manage your personal information
                </p>

            </div>

            <!-- ALERTS -->

            <?php if (!empty($success)): ?>

                <div class="alert alert-success">

                    <?= $success ?>

                </div>

            <?php endif; ?>

            <?php if (!empty($error)): ?>

                <div class="alert alert-danger">

                    <?= $error ?>

                </div>

            <?php endif; ?>

            <!-- PROFILE CARD -->

            <div class="card dashboard-card">

                <div class="card-body">

                    <form method="POST">

                        <div class="row">

                            <!-- FULL NAME -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Full Name
                                </label>

                                <input type="text" name="full_name" class="form-control"
                                    value="<?= htmlspecialchars($profile['full_name']) ?? '' ?>" required>

                            </div>

                            <!-- EMAIL -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Email
                                </label>

                                <input type="email" name="email" class="form-control"
                                    value="<?= htmlspecialchars($profile['email']) ?? '' ?>" required>

                            </div>

                            <!-- HOUSEHOLD -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Household No.
                                </label>

                                <input type="text" class="form-control"
                                    value="<?= htmlspecialchars($profile['household_no']) ?? '' ?>" readonly>

                            </div>

                            <!-- GENDER -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Gender
                                </label>

                                <input type="text" class="form-control"
                                    value="<?= htmlspecialchars($profile['gender']) ?? '' ?>" readonly>

                            </div>

                            <!-- CONTACT -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Contact Number
                                </label>

                                <input type="text" name="contact_no" class="form-control"
                                    value="<?= htmlspecialchars($profile['contact_no']) ?? '' ?>">

                            </div>

                            <!-- OCCUPATION -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Occupation
                                </label>

                                <input type="text" name="occupation" class="form-control"
                                    value="<?= htmlspecialchars($profile['occupation']) ?? '' ?>">

                            </div>

                            <!-- CIVIL STATUS -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Civil Status
                                </label>

                                <input type="text" name="civil_status" class="form-control"
                                    value="<?= htmlspecialchars($profile['civil_status']) ?? '' ?>">

                            </div>

                            <!-- ADDRESS -->

                            <div class="col-md-12 mb-3">

                                <label class="form-label">
                                    Address
                                </label>

                                <textarea name="address" class="form-control"
                                    rows="3"><?= htmlspecialchars($profile['address']) ?? '' ?></textarea>

                            </div>

                        </div>

                        <button type="submit" class="btn btn-success">

                            <i class="bi bi-save"></i>
                            Update Profile

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
