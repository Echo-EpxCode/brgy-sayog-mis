<?php

require '../config/database.php';
require '../config/session.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (
        empty($email) ||
        empty($password) ||
        empty($role)
    ) {

        $error = "All fields are required.";

    } else {

        $sql = "SELECT *
                FROM users
                WHERE email = ?
                LIMIT 1";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $email
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {

            if (
                !password_verify(
                    $password,
                    $user['password_hash']
                )
            ) {

                $error = "Invalid email or password.";

            } elseif ($user['status'] === 'pending') {

                $error = "Your account is pending approval.";

            } elseif ($user['status'] === 'rejected') {

                $error = "Your account has been rejected.";

            } elseif ($user['role'] !== $role) {

                $error = "Invalid role selected.";

            } else {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['status'] = $user['status'];

                if ($user['role'] === 'secretary') {

                    header(
                        'Location: ../secretary/dashboard.php'
                    );
                    exit;

                } elseif ($user['role'] === 'resident') {

                    header(
                        'Location: ../resident/dashboard.php'
                    );
                    exit;
                }
            }

        } else {

            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Barangay Sayog MIS</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
        }

        .bg-brand {
            background: #059669;
        }

        .role-btn.active {
            background: #059669;
            color: #fff;
        }

        .brand-circle-top {
            position: absolute;
            top: -100px;
            right: -100px;
            width: 320px;
            height: 320px;
            background: rgba(16, 185, 129, .2);
            border-radius: 50%;
            filter: blur(60px);
        }

        .brand-circle-bottom {
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 320px;
            height: 320px;
            background: rgba(45, 212, 191, .2);
            border-radius: 50%;
            filter: blur(60px);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 5;
        }

        .form-control-icon {
            padding-left: 45px;
        }
    </style>
</head>

<body>

    <main class="container-fluid vh-100 overflow-hidden">
        <div class="row h-100">

            <!-- LEFT SIDE -->
            <div
                class="col-md-6 d-none d-md-flex bg-brand text-white position-relative flex-column justify-content-between p-5">

                <div class="brand-circle-top"></div>
                <div class="brand-circle-bottom"></div>

                <div class="position-relative">

                    <div class="d-flex align-items-center gap-3 mb-4">

                        <!-- <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg> -->
                        <img src="../assets/images/logo.jpg" width="100" class="rounded-circle" alt="Logo">

                        <h3 class="fw-bold mb-0">
                            Barangay Sayog MIS
                        </h3>

                    </div>

                    <h1 class="display-5 fw-bold mb-3">
                        Digital Governance for a Better Community.
                    </h1>

                    <p class="fs-5 text-light">
                        Access the Management Information System to manage
                        records, services, and community data efficiently.
                    </p>

                </div>

                <small class="position-relative">
                    © 2026 Barangay Sayog. All rights reserved.
                </small>

            </div>

            <!-- RIGHT SIDE -->
            <div class="col-12 col-md-6 bg-white d-flex justify-content-center align-items-center">

                <div style="width:100%; max-width:500px;" class="p-4">

                    <!-- Mobile Header -->
                    <div class="d-md-none text-center mb-4">

                        <div class="d-flex justify-content-center align-items-center gap-2">

                            <svg width="32" height="32" fill="none" stroke="#059669" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>

                            <h4 class="fw-bold mb-0">
                                Barangay Sayog
                            </h4>

                        </div>

                    </div>

                    <div class="mb-4">
                        <h2 class="fw-bold">
                            Welcome Back
                        </h2>

                        <p class="text-muted">
                            Please sign in to continue to your dashboard.
                        </p>
                    </div>

                    <!-- Role Selection -->
                    <div class="btn-group w-100 mb-4">
                        <button type="button" class="btn role-btn active" onclick="selectRole('secretary', this)">
                            Secretary
                        </button>

                        <button type="button" class="btn role-btn btn-light" onclick="selectRole('resident', this)">
                            Resident
                        </button>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" id="loginForm">

                        <input type="hidden" id="selected_role" name="role" value="secretary">

                        <!-- Username -->
                        <div class="mb-3">

                            <label class="form-label">
                                Username / Email
                            </label>

                            <div class="position-relative">

                                <span class="input-icon">
                                    👤
                                </span>

                                <input type="text" class="form-control form-control-icon" name="email"
                                    placeholder="Enter your username" required>

                            </div>

                        </div>

                        <!-- Password -->
                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <div class="position-relative">

                                <span class="input-icon">
                                    🔒
                                </span>

                                <input type="password" id="password" class="form-control form-control-icon"
                                    name="password" placeholder="••••••••" required>

                            </div>

                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">

                            <label class="form-label">
                                Confirm Password
                            </label>

                            <div class="position-relative">

                                <span class="input-icon">
                                    ✓
                                </span>

                                <input type="password" id="confirm_password" class="form-control form-control-icon"
                                    placeholder="••••••••" required>

                            </div>

                            <div id="password_error" class="text-danger small mt-1 d-none">
                                Passwords do not match.
                            </div>

                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-success w-100 py-3">
                            Sign In
                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <p class="text-muted mb-0">
                            New to the system?

                            <a href="register.php" class="text-success fw-semibold text-decoration-none">
                                Register here
                            </a>
                        </p>

                    </div>

                </div>

            </div>

        </div>
    </main>

    <script>
        function selectRole(role, element) {

            document.getElementById('selected_role').value = role;

            document.querySelectorAll('.role-btn')
                .forEach(btn => {
                    btn.classList.remove('active');
                });

            element.classList.add('active');
        }

        document.getElementById('loginForm')
            .addEventListener('submit', function (e) {

                const password =
                    document.getElementById('password').value;

                const confirm =
                    document.getElementById('confirm_password').value;

                const error =
                    document.getElementById('password_error');

                if (password !== confirm) {
                    e.preventDefault();
                    error.classList.remove('d-none');
                } else {
                    error.classList.add('d-none');
                }
            });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
