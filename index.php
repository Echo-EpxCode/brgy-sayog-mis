<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Sayog MIS - Home</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .hero-section {
            overflow: hidden;
            background: #fff;
        }

        .hero-image {
            height: 100%;
            object-fit: cover;
            opacity: .9;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: #198754;
            color: white;
            border-radius: .5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .text-success-custom {
            color: #198754;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
        <div class="container">

            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
                <img src="img/logo.jpg" width="40" alt="Logo">
                Barangay Sayog MIS
            </a>

            <div class="d-flex align-items-center gap-3">
                <a href="login.php" class="text-decoration-none text-secondary fw-medium">
                    Login
                </a>

                <a href="register.php" class="btn btn-success">
                    Register
                </a>
            </div>

        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="flex-grow-1">

        <!-- HERO SECTION -->
        <section class="hero-section py-5">
            <div class="container">
                <div class="row align-items-center">

                    <!-- Left Content -->
                    <div class="col-lg-6">

                        <h1 class="display-4 fw-bold">
                            Digital Governance for
                            <span class="text-success-custom">
                                Barangay Sayog
                            </span>
                        </h1>

                        <p class="lead text-muted mt-4">
                            Access the Management Information System to manage
                            records, request clearances, and serve the community
                            efficiently.
                        </p>

                        <div class="d-flex flex-wrap gap-3 mt-4">

                            <a href="register.php" class="btn btn-success btn-lg px-4">
                                Get Started
                            </a>

                            <a href="login.php" class="btn btn-outline-success btn-lg px-4">
                                Sign In
                            </a>

                        </div>

                    </div>

                    <!-- Right Image -->
                    <div class="col-lg-6 mt-5 mt-lg-0">
                        <div class="bg-success bg-opacity-10 rounded">
                            <img src="img/bg.jpg" class="img-fluid w-100 hero-image rounded" alt="Community">
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- FEATURES -->
        <section class="py-5 bg-light">
            <div class="container">

                <div class="text-center mb-5">

                    <h6 class="text-success text-uppercase fw-semibold">
                        Features
                    </h6>

                    <h2 class="fw-bold">
                        Everything you need in one place
                    </h2>

                    <p class="text-muted fs-5">
                        Streamlined services for residents and administrators.
                    </p>

                </div>

                <div class="row g-5">

                    <!-- Feature 1 -->
                    <div class="col-md-4">

                        <div class="d-flex">
                            <div class="feature-icon me-3">

                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>

                            </div>

                            <div>
                                <h5>Resident Records</h5>

                                <p class="text-muted mb-0">
                                    Securely manage and update resident profiles,
                                    family details, and identification data.
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Feature 2 -->
                    <div class="col-md-4">

                        <div class="d-flex">
                            <div class="feature-icon me-3">

                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>

                            </div>

                            <div>
                                <h5>Clearance Requests</h5>

                                <p class="text-muted mb-0">
                                    Apply for Barangay Clearance, Indigency,
                                    and Business Permits online without
                                    visiting the office.
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Feature 3 -->
                    <div class="col-md-4">

                        <div class="d-flex">
                            <div class="feature-icon me-3">

                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>

                            </div>

                            <div>
                                <h5>Data Analytics</h5>

                                <p class="text-muted mb-0">
                                    Real-time reporting and statistics for
                                    Barangay officials to make informed
                                    decisions.
                                </p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-top py-4 mt-auto">
        <div class="container">
            <p class="text-center text-muted mb-0">
                &copy; 2024 Barangay Sayog MIS. All rights reserved.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
