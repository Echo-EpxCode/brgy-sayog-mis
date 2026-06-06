<?php

require '../config/database.php';

$message = "";

// ======================================
// FORM SUBMISSION
// ======================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $household_no = trim($_POST['household_no']);
    $first_name = strtoupper(trim($_POST['first_name']));
    $middle_name = strtoupper(trim($_POST['middle_name']));
    $last_name = strtoupper(trim($_POST['last_name']));
    $suffix = strtoupper(trim($_POST['suffix']));
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $civil_status = $_POST['civil_status'];
    $contact_no = trim($_POST['contact_no']);
    $address = strtoupper(trim($_POST['address']));
    $occupation = strtoupper(trim($_POST['occupation']));
    $citizenship = strtoupper(trim($_POST['citizenship']));

    // ======================================
    // VALIDATION
    // ======================================

    if (empty($full_name) || empty($email) || empty($password)) {
        $message = "Required fields are missing.";
    } else {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // ======================================
        // INSERT USER
        // ======================================

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO users (full_name, email, password_hash, role, status)
             VALUES (?, ?, ?, 'resident', 'pending')"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $full_name,
            $email,
            $password_hash
        );

        if (mysqli_stmt_execute($stmt)) {

            $user_id = mysqli_insert_id($conn);

            // ======================================
            // INSERT RESIDENT PROFILE
            // ======================================

            $stmt2 = mysqli_prepare(
                $conn,
                "INSERT INTO residents
                (user_id, household_no, first_name, middle_name, last_name, suffix,
                 gender, birth_date, civil_status, contact_no, address, occupation, citizenship)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
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
            $message = "Email already exists.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Registration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card shadow">

                    <div class="card-body">

                        <h3 class="mb-3">Resident Registration</h3>

                        <?php if ($message): ?>
                            <div class="alert alert-info">
                                <?= htmlspecialchars($message) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">

                            <h5>Account Info</h5>

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <input type="text" name="full_name" class="form-control" placeholder="Full Name"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                        required>
                                </div>

                            </div>

                            <hr>

                            <h5>Resident Info</h5>

                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <input type="text" name="household_no" class="form-control"
                                        placeholder="Household No" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <input type="text" name="first_name" class="form-control" placeholder="First Name"
                                        required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <input type="text" name="middle_name" class="form-control"
                                        placeholder="Middle Name">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name"
                                        required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <input type="text" name="suffix" class="form-control" placeholder="Suffix">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <select name="gender" class="form-control">
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <input type="date" name="birth_date" class="form-control" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <input type="text" name="civil_status" class="form-control"
                                        placeholder="Civil Status">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <input type="text" name="contact_no" class="form-control" placeholder="Contact No">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <input type="text" name="address" class="form-control" placeholder="Address">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <input type="text" name="occupation" class="form-control" placeholder="Occupation">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <input type="text" name="citizenship" class="form-control"
                                        placeholder="Citizenship">
                                </div>

                            </div>

                            <button class="btn btn-success w-100">
                                Register
                            </button>

                            <a href="login.php" class="btn btn-link w-100">
                                Already have an account? Login
                            </a>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
