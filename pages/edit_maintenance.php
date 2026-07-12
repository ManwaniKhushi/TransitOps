<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit;
}

include("../config/db.php");

if(!isset($_GET['id']))
{
    header("Location: maintenance.php");
    exit;
}

$maintenance_id = $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM maintenance WHERE maintenance_id=?"
);

mysqli_stmt_bind_param($stmt,"i",$maintenance_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$maintenance = mysqli_fetch_assoc($result);

if(!$maintenance)
{
    die("Maintenance Record Not Found");
}

/* Vehicle Dropdown */

$vehicleQuery = "SELECT vehicle_id,
registration_number,
vehicle_name
FROM vehicles
ORDER BY vehicle_name";

$vehicleResult = mysqli_query($conn,$vehicleQuery);

include("../includes/header.php");
include("../includes/navbar.php");
?>

<div class="container mt-4">

<div class="card shadow">

<div class="card-header bg-warning text-dark">

<h3>Edit Maintenance</h3>

</div>

<div class="card-body">

<form action="../actions/maintenance_action.php" method="POST">

<input
type="hidden"
name="maintenance_id"
value="<?= $maintenance['maintenance_id']; ?>">

<div class="mb-3">

<label class="form-label">Vehicle</label>

<select
name="vehicle_id"
class="form-select"
required>

<?php while($vehicle=mysqli_fetch_assoc($vehicleResult)){ ?>

<option
value="<?= $vehicle['vehicle_id']; ?>"
<?= ($vehicle['vehicle_id']==$maintenance['vehicle_id']) ? "selected" : ""; ?>>

<?= $vehicle['registration_number']; ?>

-

<?= $vehicle['vehicle_name']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label class="form-label">Reason</label>

<textarea
name="reason"
class="form-control"
rows="3"
required><?= htmlspecialchars($maintenance['reason']); ?></textarea>

</div>

<div class="mb-3">

<label class="form-label">Maintenance Date</label>

<input
type="date"
name="maintenance_date"
class="form-control"
value="<?= $maintenance['maintenance_date']; ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Status</label>

<select
name="status"
class="form-select">

<option
value="Pending"
<?= ($maintenance['status']=="Pending") ? "selected" : ""; ?>>
Pending
</option>

<option
value="In Progress"
<?= ($maintenance['status']=="In Progress") ? "selected" : ""; ?>>
In Progress
</option>

<option
value="Completed"
<?= ($maintenance['status']=="Completed") ? "selected" : ""; ?>>
Completed
</option>

</select>

</div>

<button
type="submit"
name="update_maintenance"
class="btn btn-primary">

Update Maintenance

</button>

<a
href="maintenance.php"
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