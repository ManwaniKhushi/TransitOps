<?php

include("../config/db.php");
include("../includes/header.php");
include("../includes/navbar.php");

if(!isset($_GET['id']))
{
    header("Location: trips.php");
    exit;
}

$trip_id = $_GET['id'];

/* Fetch Trip */

$stmt = mysqli_prepare($conn,"SELECT * FROM trips WHERE trip_id=?");
mysqli_stmt_bind_param($stmt,"i",$trip_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$trip = mysqli_fetch_assoc($result);

if(!$trip)
{
    die("Trip Not Found");
}

/* Fetch Vehicles */

$vehicleQuery = "SELECT vehicle_id,registration_number,vehicle_name FROM vehicles";
$vehicleResult = mysqli_query($conn,$vehicleQuery);

/* Fetch Drivers */

$driverQuery = "SELECT driver_id,name FROM drivers";
$driverResult = mysqli_query($conn,$driverQuery);

?>

<div class="container mt-4">

<div class="card shadow">

<div class="card-header bg-warning">
<h3>Edit Trip</h3>
</div>

<div class="card-body">

<form action="../actions/trip_action.php" method="POST">

<input
type="hidden"
name="trip_id"
value="<?= $trip['trip_id']; ?>">

<div class="mb-3">

<label class="form-label">Vehicle</label>

<select
name="vehicle_id"
class="form-select"
required>

<?php while($vehicle=mysqli_fetch_assoc($vehicleResult)){ ?>

<option
value="<?= $vehicle['vehicle_id']; ?>"

<?= ($trip['vehicle_id']==$vehicle['vehicle_id']) ? "selected" : ""; ?>

>

<?= $vehicle['registration_number']; ?>

-

<?= $vehicle['vehicle_name']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label class="form-label">Driver</label>

<select
name="driver_id"
class="form-select"
required>

<?php while($driver=mysqli_fetch_assoc($driverResult)){ ?>

<option
value="<?= $driver['driver_id']; ?>"

<?= ($trip['driver_id']==$driver['driver_id']) ? "selected" : ""; ?>

>

<?= $driver['name']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Source</label>

<input
type="text"
name="source"
class="form-control"
value="<?= htmlspecialchars($trip['source']); ?>"
required>

</div>

<div class="mb-3">

<label>Destination</label>

<input
type="text"
name="destination"
class="form-control"
value="<?= htmlspecialchars($trip['destination']); ?>"
required>

</div>

<div class="mb-3">

<label>Cargo Weight (kg)</label>

<input
type="number"
name="cargo_weight"
class="form-control"
value="<?= $trip['cargo_weight']; ?>"
required>

</div>

<div class="mb-3">

<label>Planned Distance (km)</label>

<input
type="number"
name="planned_distance"
class="form-control"
value="<?= $trip['planned_distance']; ?>"
required>

</div>

<div class="mb-3">

<label>Status</label>

<select
name="status"
class="form-select">

<option
value="Scheduled"
<?= ($trip['status']=="Scheduled")?"selected":""; ?>>
Scheduled
</option>

<option
value="On Trip"
<?= ($trip['status']=="On Trip")?"selected":""; ?>>
On Trip
</option>

<option
value="Completed"
<?= ($trip['status']=="Completed")?"selected":""; ?>>
Completed
</option>

<option
value="Cancelled"
<?= ($trip['status']=="Cancelled")?"selected":""; ?>>
Cancelled
</option>

</select>

</div>

<button
type="submit"
name="update_trip"
class="btn btn-primary">

Update Trip

</button>

<a
href="trips.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

<?php
include("../includes/footer.php");
?>