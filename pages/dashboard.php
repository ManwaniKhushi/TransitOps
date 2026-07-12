<?php
include("../config/db.php");
$query = "SELECT COUNT(*) AS total FROM vehicles";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalVehicles = $row['total'];
$query = "SELECT COUNT(*) AS total FROM drivers";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalDrivers = $row['total'];
$totalTrips = 0;
$totalMaintenance = 0;
$availableVehicles = 0;
$vehiclesOnTrip = 0;
$fuelToday = 0;
$pendingRepairs = 0;
include("../includes/header.php");
include("../includes/navbar.php");
?>

<div class="container mt-4">

    <h2 class="mb-4" style="text-align:center">🚛 TransitOps Dashboard</h2>
    <h3>Welcome, Fleet Manager 👋</h3>
<p class="text-muted">
<?= date("l, d F Y") ?>
</p>
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Total Vehicles</h5>
                    <h2><?php echo $totalVehicles;?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Total Drivers</h5>
                    <h2><?php echo $totalDrivers ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Active Trips</h5>
                    <h2><?php echo $totalTrips ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Maintenance</h5>
                    <h2><?php echo $totalMaintenance ?></h2>
                </div>
            </div>
        </div>

    </div>
  <br><hr><br>
        <div class="row">
        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Available Vehicles</h5>
                    <h2><?php echo $availableVehicles;?></h2>
                </div>
            </div>
        </div><div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Vehicles on Trip</h5>
                    <h2><?php echo $vehiclesOnTrip;?></h2>
                </div>
            </div>
        </div><div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Fuel Logs Today</h5>
                    <h2><?php echo $fuelToday;?></h2>
                </div>
            </div>
        </div><div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Repairs pending</h5>
                    <h2><?php echo $pendingRepairs;?></h2>
                </div>
            </div>
        </div>
</div>

<h3>Quick Actions</h3>

<div class="row mt-3">

<div class="col-md-3">
<a href="vehicles.php" class="btn btn-primary w-100">
➕ Add Vehicle
</a>
</div>

<div class="col-md-3">
<a href="drivers.php" class="btn btn-success w-100">
👨 Add Driver
</a>
</div>

<div class="col-md-3">
<a href="trips.php" class="btn btn-warning w-100">
🚛 Create Trip
</a>
</div>

<div class="col-md-3">
<a href="fuel.php" class="btn btn-info w-100">
⛽ Add Fuel Log
</a>
</div>

</div>
<br><hr><br>

<div class="card shadow">

<div class="card-header">

<h4>Recent Activity</h4>

</div>

<div class="card-body">

<p class="text-muted">

No recent activity yet.

</p>

</div>

</div>
<br><br>
</div>


<?php
include("../includes/footer.php");
?>