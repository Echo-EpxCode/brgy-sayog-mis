<?php

$current_page = $_SERVER['PHP_SELF'];

?>
<div id="sidebar" class="sidebar">

    <div class="sidebar-header">

        <h5 class="fw-bold text-success mb-0">
            <i class="bi bi-buildings"></i>
            Barangay MIS
        </h5>

    </div>

    <div class="p-3">

        <ul class="nav flex-column">

            <li class="nav-item">
                <a href="<?= $base_url ?>secretary/dashboard.php"
                    class="nav-link <?= strpos($current_page, '/secretary/dashboard.php') !== false ? 'active' : '' ?>">
                    Dashboard

                </a>
            </li>

            <li class="nav-item">
                <a href="<?= $base_url ?>secretary/residents/index.php"
                    class="nav-link <?= strpos($current_page, '/secretary/residents/') !== false ? 'active' : '' ?>">

                    <i class="bi bi-people"></i>
                    Residents

                </a>
            </li>

            <li class="nav-item">
                <a href="<?= $base_url ?>secretary/registrations/index.php"
                    class="nav-link <?= strpos($current_page, '/secretary/registrations/') !== false ? 'active' : '' ?>">

                    <i class="bi bi-person-check"></i>
                    Registrations

                </a>
            </li>

            <li class="nav-item">
                <a href="<?= $base_url ?>secretary/requests/index.php"
                    class="nav-link <?= strpos($current_page, '/secretary/requests/') !== false ? 'active' : '' ?>">

                    <i class="bi bi-file-earmark-text"></i>
                    Requests

                </a>
            </li>

            <li class="nav-item">
                <a href="<?= $base_url ?>secretary/certificates/history.php"
                    class="nav-link <?= strpos($current_page, '/secretary/certificates/') !== false ? 'active' : '' ?>">

                    <i class="bi bi-award"></i>
                    Certificates

                </a>
            </li>

            <li class="nav-item">
                <a href="<?= $base_url ?>secretary/announcements/index.php"
                    class="nav-link <?= strpos($current_page, '/secretary/announcements/') !== false ? 'active' : '' ?>">

                    <i class="bi bi-megaphone"></i>
                    Announcements

                </a>
            </li>

            <li class="nav-item">
                <a href="<?= $base_url ?>secretary/reports/index.php" class="nav-link
                    <?= strpos($current_page, '/secretary/reports/') !== false ? 'active' : '' ?>">

                    <i class="bi bi-bar-chart"></i>
                    Reports

                </a>
            </li>

            <li class="nav-item mt-4">
                <a href="<?= $base_url ?>auth/logout.php" class="nav-link text-danger">

                    <i class="bi bi-box-arrow-right"></i>
                    Logout

                </a>
            </li>

        </ul>

    </div>

</div>

<div id="overlay" class="mobile-overlay" onclick="closeSidebar()">
</div>
