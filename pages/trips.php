<?php
include("../config/db.php");
include("../includes/header.php");
include("../includes/navbar.php");

// Available Vehicles
$vehicleQuery = "SELECT vehicle_id, registration_number, vehicle_name
FROM vehicles
WHERE status='Available'
ORDER BY vehicle_name";

$vehicleResult = mysqli_query($conn, $vehicleQuery);

// Available Drivers
$driverQuery = "SELECT driver_id, name
FROM drivers
WHERE status='Available'
ORDER BY name";

$driverResult = mysqli_query($conn, $driverQuery);

// Trip List
$tripQuery = "SELECT
t.*,
v.registration_number,
v.vehicle_name,
d.name

FROM trips t

JOIN vehicles v
ON t.vehicle_id = v.vehicle_id

JOIN drivers d
ON t.driver_id = d.driver_id

ORDER BY trip_id DESC";

$tripResult = mysqli_query($conn,$tripQuery);

?>

<div class="container mt-4">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h3>Create New Trip</h3>
</div>

<div class="card-body">

<?php if(isset($_GET['success'])){ ?>
<div class="alert alert-success">
Trip Created Successfully.
</div>
<?php } ?>

<?php if(isset($_GET['updated'])){ ?>
<div class="alert alert-success">
Trip Updated Successfully.
</div>
<?php } ?>

<?php if(isset($_GET['deleted'])){ ?>
<div class="alert alert-danger">
Trip Deleted Successfully.
</div>
<?php } ?>

<form action="../actions/trip_action.php" method="POST">

<div class="mb-3">
<label class="form-label">Vehicle</label>

<select name="vehicle_id" class="form-select" required>

<option value="">Select Vehicle</option>

<?php while($vehicle=mysqli_fetch_assoc($vehicleResult)){ ?>

<option value="<?= $vehicle['vehicle_id']; ?>">

<?= $vehicle['registration_number']; ?>

-

<?= $vehicle['vehicle_name']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label class="form-label">Driver</label>

<select name="driver_id" class="form-select" required>

<option value="">Select Driver</option>

<?php while($driver=mysqli_fetch_assoc($driverResult)){ ?>

<option value="<?= $driver['driver_id']; ?>">

<?= $driver['name']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label class="form-label">Source</label>

<input
type="text"
name="source"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Destination</label>

<input
type="text"
name="destination"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Cargo Weight (kg)</label>

<input
type="number"
name="cargo_weight"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Planned Distance (km)</label>

<input
type="number"
name="planned_distance"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Status</label>

<select
name="status"
class="form-select">

<option value="Scheduled">Scheduled</option>

<option value="On Trip">On Trip</option>

<option value="Completed">Completed</option>

<option value="Cancelled">Cancelled</option>

</select>

</div>

<button
type="submit"
name="save_trip"
class="btn btn-success">

Save Trip

</button>

</form>

</div>

</div>

<hr>

<div class="card shadow mt-4">

<div class="card-header bg-dark text-white">
<h4>Trip List</h4>
</div>

<div class="card-body">

<input
type="text"
id="searchTrip"
class="form-control mb-3"
placeholder="Search Trip...">

<table class="table table-bordered table-hover" id="tripTable">

<thead class="table-dark">

<tr>

<th>ID</th>
<th>Vehicle</th>
<th>Driver</th>
<th>Source</th>
<th>Destination</th>
<th>Weight</th>
<th>Distance</th>
<th>Status</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php while($trip=mysqli_fetch_assoc($tripResult)){ ?>

<?php

$statusColors = [

"Scheduled"=>"secondary",

"On Trip"=>"primary",

"Completed"=>"success",

"Cancelled"=>"danger"

];

$badge = $statusColors[$trip['status']] ?? "dark";

?>

<tr>

<td><?= $trip['trip_id']; ?></td>

<td>

<?= $trip['registration_number']; ?>

<br>

<small><?= $trip['vehicle_name']; ?></small>

</td>

<td><?= $trip['name']; ?></td>

<td><?= $trip['source']; ?></td>

<td><?= $trip['destination']; ?></td>

<td><?= $trip['cargo_weight']; ?> kg</td>

<td><?= $trip['planned_distance']; ?> km</td>

<td>

<span class="badge bg-<?= $badge; ?>">

<?= $trip['status']; ?>

</span>

</td>

<td>

<a
href="edit_trip.php?id=<?= $trip['trip_id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="../actions/trip_action.php?delete=<?= $trip['trip_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this trip?')">

Delete

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<script>

document.getElementById("searchTrip").addEventListener("keyup",function(){

let filter=this.value.toLowerCase();

let rows=document.querySelectorAll("#tripTable tbody tr");

rows.forEach(function(row){

let text=row.innerText.toLowerCase();

row.style.display=text.includes(filter)?"":"none";

});

});

</script>

<?php
include("../includes/footer.php");
?>