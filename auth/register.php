<?php
require '../config/database.php';

$message = "";

// ============================
// REGISTER PROCESS
// ============================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // USERS
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // RESIDENTS
    $first_name = strtoupper(trim($_POST['first_name']));
    $middle_name = strtoupper(trim($_POST['middle_name']));
    $last_name = strtoupper(trim($_POST['last_name']));
    $suffix = strtoupper(trim($_POST['suffix']));
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $civil_status = $_POST['civil_status'];
    $contact_no = trim($_POST['contact_no']);
    $address = strtoupper(trim($_POST['address']));
    $occupation = $_POST['occupation'];
    $citizenship = $_POST['citizenship'];

    // ============================
    // VALIDATION
    // ============================

    if ($password !== $confirm) {
        $message = "Passwords do not match.";
    } elseif (empty($username) || empty($email) || empty($password)) {
        $message = "Required fields missing.";
    } else {

        // check duplicate email
        $check = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($check, "s", $email);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {
            $message = "Email already exists.";
        } else {

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // ============================
            // INSERT USER
            // ============================

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO users (full_name, email, password_hash, role, status)
                 VALUES (?, ?, ?, 'resident', 'pending')"
            );

            $full_name = $first_name . " " . $last_name;

            mysqli_stmt_bind_param(
                $stmt,
                "sss",
                $full_name,
                $email,
                $password_hash
            );

            if (mysqli_stmt_execute($stmt)) {

                $user_id = mysqli_insert_id($conn);

                // household number
                $household_no = "HH-" . date("Y") . rand(1000, 9999);

                // ============================
                // INSERT RESIDENT
                // ============================

                $stmt2 = mysqli_prepare(
                    $conn,
                    "INSERT INTO residents (
                        user_id, household_no, first_name, middle_name, last_name,
                        suffix, gender, birth_date, civil_status, contact_no,
                        address, occupation, citizenship
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                );

                mysqli_stmt_bind_param(
                    $stmt2,
                    "issssssssssss",
                    $user_id,
                    $household_no,
                    $first_name,
                    $middle_name,
                    $last_name,
                    $suffix,
                    $gender,
                    $birth_date,
                    $civil_status,
                    $contact_no,
                    $address,
                    $occupation,
                    $citizenship
                );

                mysqli_stmt_execute($stmt2);

                $message = "Registration successful. Wait for admin approval.";

            } else {
                $message = "Email already exists or insert failed.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Barangay Sayog MIS</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }

        .section-title {
            font-weight: 600;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
        <div class="container">
            <img src="../assets/images/logo.jpg" width="50" class="rounded-circle m-2" alt="Logo">
            <a class="navbar-brand fw-bold text-success" href="../index.php">
                Barangay Sayog MIS
            </a>

            <div class="ms-auto">
                <a href="login.php" class="text-decoration-none text-primary fw-bold">
                    Sign In
                    Already have an account? Sign In
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container py-5">

        <div class="text-center mb-4">
            <h3 class="fw-bold">Create Your Barangay ID</h3>
            <p class="text-muted">Register to access digital services and manage your records</p>
        </div>
        <?php if ($message): ?>
            <div class="alert alert-info">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <!-- FORM CARD -->
        <div class="card shadow-sm">
            <div class="card-body p-4">

                <form method="POST">

                    <!-- PERSONAL INFO -->
                    <h5 class="section-title text-success">Personal Information</h5>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">First Name *</label>
                            <input type="text" name="first_name" class="form-control"
                                value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control"
                                value="<?php echo htmlspecialchars($_POST['middle_name'] ?? ''); ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Last Name *</label>
                            <input type="text" name="last_name" class="form-control"
                                value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Suffix</label>
                            <select name="suffix" class="form-select">
                                <option value="">None</option>
                                <option value="Jr." <?php echo (($_POST['suffix'] ?? '') == 'Jr.') ? 'selected' : ''; ?>>
                                    Jr.</option>
                                <option value="Sr." <?php echo (($_POST['suffix'] ?? '') == 'Sr.') ? 'selected' : ''; ?>>
                                    Sr.</option>
                                <option value="II" <?php echo (($_POST['suffix'] ?? '') == 'II') ? 'selected' : ''; ?>>II
                                </option>
                                <option value="III" <?php echo (($_POST['suffix'] ?? '') == 'III') ? 'selected' : ''; ?>>
                                    III</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Birth Date *</label>
                            <input type="date" name="birth_date" class="form-control"
                                value="<?php echo htmlspecialchars($_POST['birth_date'] ?? ''); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gender *</label>
                            <select name="gender" class="form-select" required>
                                <option value="">Select</option>
                                <option value="Male" <?php echo (($_POST['gender'] ?? '') == 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo (($_POST['gender'] ?? '') == 'Female') ? 'selected' : ''; ?>>Female
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Civil Status *</label>
                            <select name="civil_status" class="form-select" required>
                                <option value="">Select</option>
                                <option <?php echo (($_POST['civil_status'] ?? '') == 'Single') ? 'selected' : ''; ?>>
                                    Single</option>
                                <option <?php echo (($_POST['civil_status'] ?? '') == 'Married') ? 'selected' : ''; ?>>
                                    Married</option>
                                <option <?php echo (($_POST['civil_status'] ?? '') == 'Widowed') ? 'selected' : ''; ?>>
                                    Widowed</option>
                                <option <?php echo (($_POST['civil_status'] ?? '') == 'Separated') ? 'selected' : ''; ?>>
                                    Separated</option>
                                <option <?php echo (($_POST['civil_status'] ?? '') == 'Divorced') ? 'selected' : ''; ?>>
                                    Divorced</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Occupation</label>
                            <input type="text" name="occupation" class="form-control"
                                value="<?php echo htmlspecialchars($_POST['occupation'] ?? ''); ?>">
                        </div>

                    </div>
                    <!-- CONTACT -->

                    <h5 class="section-title text-success mt-4">Contact & Address</h5>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control"
                                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact No *</label>
                            <input type="text" name="contact_no" class="form-control"
                                value="<?php echo htmlspecialchars($_POST['contact_no'] ?? ''); ?>" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Full Address *</label>
                            <textarea name="address" class="form-control" rows="3"
                                required><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label">Citizenship</label>
                            <input type="text" name="citizenship" class="form-control"
                                value="<?php echo htmlspecialchars($_POST['citizenship'] ?? 'Filipino'); ?>">
                        </div>

                    </div>

                    <!-- ACCOUNT -->

                    <h5 class="section-title text-success mt-4">Account Security</h5>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Username *</label>
                            <input type="text" name="username" class="form-control"
                                value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>

                    </div>

                    <!-- SUBMIT -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success w-100 py-2">
                            Create Account
                        </button>
                    </div>

                </form>

            </div>
        </div>

        <!-- FOOTER NOTE -->
        <div class="text-center mt-3 text-muted small">
            By registering you agree to Terms & Privacy Policy
        </div>

    </div>

</body>

</html>
