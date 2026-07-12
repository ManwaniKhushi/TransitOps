<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit;
}
if(
$_SESSION['role']!="Fleet Manager" &&
$_SESSION['role']!="Financial Analyst"
)
{
die("Access Denied");
}
include("../config/db.php");
include("../includes/header.php");
include("../includes/navbar.php");

/* Vehicle Dropdown */
$vehicleQuery = "SELECT vehicle_id, registration_number, vehicle_name
FROM vehicles
ORDER BY vehicle_name";

$vehicleResult = mysqli_query($conn,$vehicleQuery);

/* Maintenance List */
$maintenanceQuery = "SELECT
m.*,
v.registration_number,
v.vehicle_name

FROM maintenance m

JOIN vehicles v
ON m.vehicle_id=v.vehicle_id

ORDER BY maintenance_date DESC";

$maintenanceResult = mysqli_query($conn,$maintenanceQuery);
?>

<div class="container mt-4">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h3>Add Maintenance</h3>
</div>

<div class="card-body">

<?php if(isset($_GET['success'])){ ?>
<div class="alert alert-success">Maintenance Added Successfully.</div>
<?php } ?>

<?php if(isset($_GET['updated'])){ ?>
<div class="alert alert-success">Maintenance Updated Successfully.</div>
<?php } ?>

<?php if(isset($_GET['deleted'])){ ?>
<div class="alert alert-danger">Maintenance Deleted Successfully.</div>
<?php } ?>

<form action="../actions/maintenance_action.php" method="POST">

<div class="mb-3">
<label>Vehicle</label>

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

<label>Reason</label>

<textarea
name="reason"
class="form-control"
rows="3"
required></textarea>

</div>

<div class="mb-3">

<label>Maintenance Date</label>

<input
type="date"
name="maintenance_date"
class="form-control"
value="<?= date('Y-m-d'); ?>"
required>

</div>

<div class="mb-3">

<label>Status</label>

<select
name="status"
class="form-select">

<option value="Pending">Pending</option>
<option value="In Progress">In Progress</option>
<option value="Completed">Completed</option>

</select>

</div>

<button
type="submit"
name="save_maintenance"
class="btn btn-success">

Save Maintenance

</button>

</form>

</div>

</div>

<hr>

<div class="card shadow">

<div class="card-header bg-dark text-white">
<h4>Maintenance List</h4>
</div>

<div class="card-body">

<input
type="text"
id="searchMaintenance"
class="form-control mb-3"
placeholder="Search Maintenance...">

<table class="table table-bordered table-hover" id="maintenanceTable">

<thead class="table-dark">

<tr>

<th>ID</th>
<th>Vehicle</th>
<th>Reason</th>
<th>Date</th>
<th>Status</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($maintenance=mysqli_fetch_assoc($maintenanceResult)){ ?>

<?php

$statusColors=[

"Pending"=>"warning",

"In Progress"=>"primary",

"Completed"=>"success"

];

$badge=$statusColors[$maintenance['status']] ?? "dark";

?>

<tr>

<td><?= $maintenance['maintenance_id']; ?></td>

<td>

<?= $maintenance['registration_number']; ?>

<br>

<small><?= $maintenance['vehicle_name']; ?></small>

</td>

<td><?= $maintenance['reason']; ?></td>

<td><?= $maintenance['maintenance_date']; ?></td>

<td>

<span class="badge bg-<?= $badge; ?>">

<?= $maintenance['status']; ?>

</span>

</td>

<td>

<a
href="edit_maintenance.php?id=<?= $maintenance['maintenance_id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="../actions/maintenance_action.php?delete=<?= $maintenance['maintenance_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete Maintenance Record?')">

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

document.getElementById("searchMaintenance").addEventListener("keyup",function(){

let filter=this.value.toLowerCase();

let rows=document.querySelectorAll("#maintenanceTable tbody tr");

rows.forEach(function(row){

let text=row.innerText.toLowerCase();

row.style.display=text.includes(filter)?"":"none";

});

});

</script>

<?php include("../includes/footer.php"); ?>