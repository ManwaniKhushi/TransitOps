<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit;
}

include("../config/db.php");
include("../includes/header.php");
include("../includes/navbar.php");

/* ==========================
   VEHICLE DROPDOWN
========================== */

$vehicleQuery = "SELECT vehicle_id, registration_number, vehicle_name
FROM vehicles
ORDER BY vehicle_name";

$vehicleResult = mysqli_query($conn, $vehicleQuery);

/* ==========================
   FUEL LIST
========================== */

$fuelQuery = "SELECT
f.*,
v.registration_number,
v.vehicle_name

FROM fuel_logs f

JOIN vehicles v
ON f.vehicle_id = v.vehicle_id

ORDER BY fuel_date DESC";

$fuelResult = mysqli_query($conn,$fuelQuery);

?>

<div class="container mt-4">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h3>Add Fuel Log</h3>
</div>

<div class="card-body">

<?php if(isset($_GET['success'])){ ?>
<div class="alert alert-success">
Fuel Log Added Successfully.
</div>
<?php } ?>

<?php if(isset($_GET['updated'])){ ?>
<div class="alert alert-success">
Fuel Log Updated Successfully.
</div>
<?php } ?>

<?php if(isset($_GET['deleted'])){ ?>
<div class="alert alert-danger">
Fuel Log Deleted Successfully.
</div>
<?php } ?>

<form action="../actions/fuel_action.php" method="POST">

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

<label class="form-label">Fuel (Litres)</label>

<input
type="number"
step="0.01"
name="litres"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Cost (₹)</label>

<input
type="number"
step="0.01"
name="cost"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Fuel Date</label>

<input
type="date"
name="fuel_date"
class="form-control"
value="<?= date('Y-m-d'); ?>"
required>

</div>

<button
type="submit"
name="save_fuel"
class="btn btn-success">

Save Fuel Log

</button>

</form>

</div>

</div>

<hr>

<div class="card shadow mt-4">

<div class="card-header bg-dark text-white">
<h4>Fuel Log List</h4>
</div>

<div class="card-body">

<input
type="text"
id="searchFuel"
class="form-control mb-3"
placeholder="Search Fuel Logs...">

<table class="table table-bordered table-hover" id="fuelTable">

<thead class="table-dark">

<tr>

<th>ID</th>
<th>Vehicle</th>
<th>Litres</th>
<th>Cost</th>
<th>Date</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($fuel=mysqli_fetch_assoc($fuelResult)){ ?>

<tr>

<td><?= $fuel['fuel_id']; ?></td>

<td>

<?= $fuel['registration_number']; ?>

<br>

<small><?= $fuel['vehicle_name']; ?></small>

</td>

<td><?= $fuel['liters']; ?> L</td>

<td>₹<?= number_format($fuel['cost'],2); ?></td>

<td><?= $fuel['fuel_date']; ?></td>

<td>

<a
href="edit_fuel.php?id=<?= $fuel['fuel_id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="../actions/fuel_action.php?delete=<?= $fuel['fuel_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this fuel log?')">

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

document.getElementById("searchFuel").addEventListener("keyup",function(){

let filter=this.value.toLowerCase();

let rows=document.querySelectorAll("#fuelTable tbody tr");

rows.forEach(function(row){

let text=row.innerText.toLowerCase();

row.style.display=text.includes(filter)?"":"none";

});

});

</script>

<?php
include("../includes/footer.php");
?>