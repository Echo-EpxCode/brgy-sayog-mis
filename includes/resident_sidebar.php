<?php

$current_page = $_SERVER['PHP_SELF'];

?>

<div id="sidebar" class="sidebar">

    <!-- HEADER -->
    <div class="sidebar-header">

        <h5 class="fw-bold text-success mb-0">

            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQoX9_BVQEcoNdQ0nn3nYJ99pr2tkPzpOxfbTBF-r55Gg&s=10"
                width="40" alt="Logo">
            Resident Portal

        </h5>

    </div>

    <!-- NAVIGATION -->
    <div class="p-3">

        <ul class="nav flex-column">

            <!-- DASHBOARD -->
            <li class="nav-item">

                <a href="<?= $base_url ?>resident/dashboard.php"
                    class="nav-link <?= strpos($current_page, '/resident/dashboard.php') !== false ? 'active' : '' ?>">

                    <i class="bi bi-grid"></i>
                    Dashboard

                </a>

            </li>

            <!-- REQUEST DOCUMENT -->
            <li class="nav-item">

                <a href="<?= $base_url ?>resident/documents/request.php"
                    class="nav-link <?= strpos($current_page, '/resident/documents/') !== false ? 'active' : '' ?>">

                    <i class="bi bi-file-earmark-plus"></i>
                    Request Document

                </a>

            </li>

            <!-- MY REQUESTS -->
            <li class="nav-item">

                <a href="<?= $base_url ?>resident/requests/index.php"
                    class="nav-link <?= strpos($current_page, '/resident/requests/') !== false ? 'active' : '' ?>">

                    <i class="bi bi-clock-history"></i>
                    My Requests

                </a>

            </li>

            <!-- ANNOUNCEMENTS -->
            <li class="nav-item">

                <a href="<?= $base_url ?>resident/announcements/index.php"
                    class="nav-link <?= strpos($current_page, '/resident/announcements/') !== false ? 'active' : '' ?>">

                    <i class="bi bi-megaphone"></i>
                    Announcements

                </a>

            </li>

            <!-- PROFILE -->
            <li class="nav-item">

                <a href="<?= $base_url ?>resident/profile/index.php"
                    class="nav-link <?= strpos($current_page, '/resident/profile/') !== false ? 'active' : '' ?>">

                    <i class="bi bi-person-circle"></i>
                    Profile

                </a>

            </li>

            <!-- LOGOUT -->
            <li class="nav-item mt-4">

                <a href="<?= $base_url ?>auth/logout.php" class="nav-link text-danger">

                    <i class="bi bi-box-arrow-right"></i>
                    Logout

                </a>

            </li>

        </ul>

    </div>

</div>

<!-- MOBILE OVERLAY -->
<div id="overlay" class="mobile-overlay" onclick="closeSidebar()"></div>
