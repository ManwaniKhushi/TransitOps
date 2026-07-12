<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit;
}

include("../config/db.php");

$role = $_SESSION['role'];

include("../includes/header.php");
include("../includes/navbar.php");


// COMMON DATA

// Vehicles
if($role=="Admin" || $role=="Fleet Manager")
{
    $query="SELECT COUNT(*) total FROM vehicles";
    $result=mysqli_query($conn,$query);
    $totalVehicles=mysqli_fetch_assoc($result)['total'];

    $query="SELECT COUNT(*) total FROM vehicles WHERE status='Available'";
    $result=mysqli_query($conn,$query);
    $availableVehicles=mysqli_fetch_assoc($result)['total'];

    $query="SELECT COUNT(*) total FROM vehicles WHERE status='On Trip'";
    $result=mysqli_query($conn,$query);
    $vehiclesOnTrip=mysqli_fetch_assoc($result)['total'];
}


// Drivers
if($role=="Admin" || $role=="Fleet Manager")
{
    $query="SELECT COUNT(*) total FROM drivers";
    $result=mysqli_query($conn,$query);
    $totalDrivers=mysqli_fetch_assoc($result)['total'];

    $query="SELECT COUNT(*) total FROM drivers WHERE status='Available'";
    $result=mysqli_query($conn,$query);
    $availableDrivers=mysqli_fetch_assoc($result)['total'];

    $query="SELECT COUNT(*) total FROM drivers WHERE status='On Trip'";
    $result=mysqli_query($conn,$query);
    $driversOnTrip=mysqli_fetch_assoc($result)['total'];
}


// Trips

if($role=="Admin" || $role=="Dispatcher")
{

$query="SELECT COUNT(*) total FROM trips";
$result=mysqli_query($conn,$query);
$totalTrips=mysqli_fetch_assoc($result)['total'];


$recentTripsQuery="
SELECT 
t.trip_id,
t.source,
t.destination,
t.status,
t.trip_date,
v.registration_number,
v.vehicle_name,
d.name

FROM trips t

JOIN vehicles v 
ON t.vehicle_id=v.vehicle_id

JOIN drivers d
ON t.driver_id=d.driver_id

ORDER BY t.trip_id DESC

LIMIT 5
";


$recentTripsResult=mysqli_query($conn,$recentTripsQuery);

}



// Maintenance

if($role=="Admin" || $role=="Maintenance Manager")
{

$query="
SELECT COUNT(*) total 
FROM maintenance";

$result=mysqli_query($conn,$query);

$totalMaintenance=mysqli_fetch_assoc($result)['total'];


$query="
SELECT COUNT(*) total 
FROM maintenance 
WHERE status='Pending'";

$result=mysqli_query($conn,$query);

$pendingRepairs=mysqli_fetch_assoc($result)['total'];

}


// Fuel

if($role=="Admin" || $role=="Fuel Manager")
{

$query="
SELECT COUNT(*) total 
FROM fuel_logs
WHERE fuel_date=CURDATE()";

$result=mysqli_query($conn,$query);

$fuelToday=mysqli_fetch_assoc($result)['total'];



$query="
SELECT SUM(cost) total
FROM fuel_logs";

$result=mysqli_query($conn,$query);

$totalFuelCost=mysqli_fetch_assoc($result)['total'] ?? 0;



$query="
SELECT SUM(liters) total
FROM fuel_logs";

$result=mysqli_query($conn,$query);

$totalFuelConsumed=mysqli_fetch_assoc($result)['total'] ?? 0;

}

?>



<div class="container mt-4">


<h2 class="text-center">
🚛 Fleet Management Dashboard
</h2>


<h3>
Welcome <?= $_SESSION['name']; ?> 👋
</h3>

<p class="text-muted">
<?=date("l,d F Y")?>
</p>



<h3>Quick Actions</h3>


<div class="row mt-3">


<?php if($role=="Admin" || $role=="Fleet Manager"){ ?>

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

<?php } ?>



<?php if($role=="Admin" || $role=="Dispatcher"){ ?>

<div class="col-md-3">
<a href="trips.php" class="btn btn-warning w-100">
🚛 Create Trip
</a>
</div>

<?php } ?>



<?php if($role=="Admin" || $role=="Fuel Manager"){ ?>

<div class="col-md-3">
<a href="fuel.php" class="btn btn-info w-100">
⛽ Add Fuel Log
</a>
</div>

<?php } ?>


</div>


<hr>


<div class="row">



<?php if(isset($totalVehicles)){ ?>

<div class="col-md-3">
<div class="card shadow text-center">
<div class="card-body">

<h5>Total Vehicles</h5>

<h2><?=$totalVehicles?></h2>

</div>
</div>
</div>

<?php } ?>





<?php if(isset($totalDrivers)){ ?>

<div class="col-md-3">
<div class="card shadow text-center">

<div class="card-body">

<h5>Total Drivers</h5>

<h2><?=$totalDrivers?></h2>

</div>

</div>
</div>

<?php } ?>





<?php if(isset($totalTrips)){ ?>

<div class="col-md-3">
<div class="card shadow text-center">

<div class="card-body">

<h5>Total Trips</h5>

<h2><?=$totalTrips?></h2>

</div>

</div>
</div>

<?php } ?>





<?php if(isset($totalMaintenance)){ ?>

<div class="col-md-3">

<div class="card shadow text-center">

<div class="card-body">

<h5>Maintenance</h5>

<h2><?=$totalMaintenance?></h2>

</div>

</div>

</div>
++++
<?php } ?>


</div>



<hr>



<div class="row">


<?php if(isset($availableVehicles)){ ?>

<div class="col-md-3">
<div class="card shadow text-center">

<div class="card-body">

<h5>Available Vehicles</h5>

<h2><?=$availableVehicles?></h2>

</div>

</div>
</div>

<?php } ?>



<?php if(isset($vehiclesOnTrip)){ ?>

<div class="col-md-3">

<div class="card shadow text-center">

<div class="card-body">

<h5>Vehicles On Trip</h5>

<h2><?=$vehiclesOnTrip?></h2>


</div>
</div>

</div>

<?php } ?>




<?php if(isset($fuelToday)){ ?>

<div class="col-md-3">

<div class="card shadow text-center">

<div class="card-body">

<h5>Fuel Today</h5>

<h2><?=$fuelToday?></h2>

</div>

</div>

</div>

<?php } ?>





<?php if(isset($pendingRepairs)){ ?>

<div class="col-md-3">

<div class="card shadow text-center">

<div class="card-body">

<h5>Pending Repairs</h5>

<h2><?=$pendingRepairs?></h2>

</div>

</div>

</div>


<?php } ?>


</div>



<hr>



<?php if($role=="Admin" || $role=="Dispatcher"){ ?>

<div class="card shadow">


<div class="card-header bg-dark text-white">

<h4>
🛣 Recent Trips
</h4>

</div>



<div class="card-body">


<table class="table table-bordered">


<tr>

<th>Vehicle</th>
<th>Driver</th>
<th>Route</th>
<th>Date</th>
<th>Status</th>

</tr>



<?php

while($trip=mysqli_fetch_assoc($recentTripsResult))
{

?>

<tr>

<td>
<?=$trip['registration_number']?>
<br>
<small><?=$trip['vehicle_name']?></small>
</td>


<td>
<?=$trip['name']?>
</td>


<td>

<?=$trip['source']?> 
→
<?=$trip['destination']?>

</td>


<td>
<?=$trip['trip_date']?>
</td>


<td>

<?=$trip['status']?>

</td>


</tr>


<?php } ?>


</table>



</div>


</div>


<?php } ?>



</div>


<?php

include("../includes/footer.php");

?>