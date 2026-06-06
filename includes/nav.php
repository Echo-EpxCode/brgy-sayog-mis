<nav class="navbar topbar p-3">

    <button class="btn btn-outline-success d-lg-none" onclick="toggleSidebar()">

        <i class="bi bi-list"></i>

    </button>

    <div class="ms-auto">

        <span class="fw-semibold">

            <i class="bi bi-person-circle"></i>

            <?= htmlspecialchars($_SESSION['full_name']) ?>

        </span>

    </div>

</nav>
