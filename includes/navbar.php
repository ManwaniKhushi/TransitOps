<?php

if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">

<div class="container-fluid px-4">


<a class="navbar-brand fw-bold" href="dashboard.php">
🚛 TransitOps
</a>


<button class="navbar-toggler" 
type="button" 
data-bs-toggle="collapse" 
data-bs-target="#navbarMenu">

<span class="navbar-toggler-icon"></span>

</button>



<div class="collapse navbar-collapse" id="navbarMenu">


<ul class="navbar-nav me-auto mb-2 mb-lg-0">


<?php

$role = $_SESSION['role'] ?? '';

?>


<!-- =========================
     COMMON DASHBOARD
========================= -->

<li class="nav-item">

<a class="nav-link" href="dashboard.php">
🏠 Dashboard
</a>

</li>



<!-- =========================
     ADMIN / FLEET MANAGER
========================= -->

<?php if($role=="Admin" || $role=="Fleet Manager"){ ?>


<li class="nav-item">

<a class="nav-link" href="vehicles.php">
🚛 Vehicles
</a>

</li>


<li class="nav-item">

<a class="nav-link" href="maintenance.php">
🔧 Maintenance
</a>

</li>


<li class="nav-item">

<a class="nav-link" href="fuel.php">
⛽ Fuel
</a>

</li>


<?php } ?>



<!-- =========================
     DISPATCHER
========================= -->

<?php if($role=="Admin" || $role=="Dispatcher"){ ?>


<li class="nav-item">

<a class="nav-link" href="trips.php">
🛣 Trips
</a>

</li>


<?php } ?>



<!-- =========================
     SAFETY OFFICER
========================= -->

<?php if($role=="Admin" || $role=="Safety Officer"){ ?>


<li class="nav-item">

<a class="nav-link" href="drivers.php">
👨 Drivers
</a>

</li>


<?php } ?>



<!-- =========================
     FINANCIAL ANALYST
========================= -->

<?php if($role=="Admin" || $role=="Financial Analyst"){ ?>


<li class="nav-item">

<a class="nav-link" href="fuel.php">
⛽ Fuel
</a>

</li>


<li class="nav-item">

<a class="nav-link" href="maintenance.php">
🔧 Maintenance
</a>

</li>


<li class="nav-item">

<a class="nav-link" href="reports.php">
📊 Reports
</a>

</li>


<?php } ?>


</ul>




<!-- USER SECTION -->

<div class="d-flex align-items-center">


<span class="text-white me-3">

👤 <?= $_SESSION['name'] ?? "User"; ?>

<br>

<small>
<?= $role; ?>
</small>

</span>



<a href="../actions/logout.php" 
class="btn btn-danger btn-sm">

Logout

</a>


</div>


</div>

</div>

</nav>