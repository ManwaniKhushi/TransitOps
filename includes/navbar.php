<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">

    <div class="container-fluid px-5">

        <a class="navbar-brand fw-bold fs-2" href="dashboard.php">
            🚛 TransitOps
        </a>

        <button class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- Left Menu -->
            <ul class="navbar-nav ms-5">

                <li class="nav-item">
                    <a class="nav-link px-3 fs-7" href="../pages/dashboard.php">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 fs-7" href="../pages/vehicles.php">Vehicles</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 fs-7" href="../pages/drivers.php">Drivers</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 fs-7" href="../pages/trips.php">Trips</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 fs-7" href="../pages/maintenance.php">Maintenance</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 fs-7" href="../pages/fuel.php">Fuel</a>
                </li>

            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item me-4">
                    <span class="text-white fs-5">
                        👋 <?= htmlspecialchars($_SESSION['name']); ?>
                    </span>
                </li>

                <li class="nav-item">
                    <a class="btn btn-outline-light px-4" href="../logout.php">
                        Logout
                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>