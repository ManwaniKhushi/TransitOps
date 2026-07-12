
<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit;
}
include("../config/db.php");
$query = "SELECT COUNT(*) AS total FROM vehicles";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalVehicles = $row['total'];

$query = "SELECT COUNT(*) AS total FROM drivers";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalDrivers = $row['total'];

$query = "SELECT COUNT(*) AS total FROM trips";
$result = mysqli_query($conn,$query);
$totalTrips = mysqli_fetch_assoc($result)['total'];

$query="SELECT COUNT(*) AS total
FROM vehicles
WHERE status='Available'";
$result=mysqli_query($conn,$query);
$availableVehicles=mysqli_fetch_assoc($result)['total'];

$query="SELECT COUNT(*) AS total
FROM vehicles
WHERE status='On Trip'";
$result=mysqli_query($conn,$query);
$vehiclesOnTrip=mysqli_fetch_assoc($result)['total'];

$query = "SELECT COUNT(*) AS total
          FROM fuel_logs
          WHERE fuel_date = CURDATE()";
$result = mysqli_query($conn, $query);
$fuelToday = mysqli_fetch_assoc($result)['total'];

$query = "SELECT COUNT(*) AS total
          FROM maintenance
          WHERE status='Pending'";

$result = mysqli_query($conn, $query);
$pendingRepairs = mysqli_fetch_assoc($result)['total'];

$query = "SELECT COUNT(*) AS total
          FROM maintenance";

$result = mysqli_query($conn, $query);
$totalMaintenance = mysqli_fetch_assoc($result)['total'];
$query = "SELECT COUNT(*) AS total
          FROM maintenance";
$result = mysqli_query($conn, $query);
$totalMaintenance = mysqli_fetch_assoc($result)['total'];

$query = "SELECT COUNT(*) AS total
          FROM drivers
          WHERE status='Available'";
$result = mysqli_query($conn, $query);
$availableDrivers = mysqli_fetch_assoc($result)['total'];

$query = "SELECT COUNT(*) AS total
          FROM drivers
          WHERE status='On Trip'";
$result = mysqli_query($conn, $query);
$driversOnTrip = mysqli_fetch_assoc($result)['total'];
$query = "SELECT SUM(cost) AS totalCost
          FROM fuel_logs";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalFuelCost = $row['totalCost'] ?? 0;
$query = "SELECT SUM(liters) AS totalLitres
          FROM fuel_logs";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalFuelConsumed = $row['totalLitres'] ?? 0;
include("../includes/header.php");
include("../includes/navbar.php");
?>

<div class="container mt-4">

    <h2 class="mb-4" style="text-align:center">🚛 Fleet Management Dashboard</h2>
<h3>Welcome, <?= $_SESSION['name']; ?> 👋</h3>
<p class="text-muted">
<?= date("l, d F Y") ?>
</p>
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
<br><hr><br>
</div>
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

 <br><hr><br>
   <div class="row">
        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Available Drivers</h5>
                    <h2><?php echo $availableDrivers;?></h2>
                </div>
            </div>
        </div><div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Drivers on Trip</h5>
                    <h2><?php echo $driversOnTrip;?></h2>
                </div>
            </div>
        </div><div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Total Fuel Cost</h5>
                    <h2><?php echo $totalFuelCost;?></h2>
                </div>
            </div>
        </div><div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Total Fuel Consumed</h5>
                    <h2><?php echo $totalFuelConsumed;?></h2>
                </div>
            </div>
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