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
    header("Location: fuel.php");
    exit;
}

$fuel_id = $_GET['id'];

$stmt = mysqli_prepare($conn,
"SELECT * FROM fuel_logs WHERE fuel_id=?");

mysqli_stmt_bind_param($stmt,"i",$fuel_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$fuel = mysqli_fetch_assoc($result);

if(!$fuel)
{
    die("Fuel Log Not Found");
}

/* ==========================
   VEHICLE DROPDOWN
========================== */

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
<h3>Edit Fuel Log</h3>
</div>

<div class="card-body">

<form action="../actions/fuel_action.php" method="POST">

<input
type="hidden"
name="fuel_id"
value="<?= $fuel['fuel_id']; ?>">

<div class="mb-3">

<label class="form-label">Vehicle</label>

<select
name="vehicle_id"
class="form-select"
required>

<?php while($vehicle=mysqli_fetch_assoc($vehicleResult)){ ?>

<option
value="<?= $vehicle['vehicle_id']; ?>"
<?= ($vehicle['vehicle_id']==$fuel['vehicle_id']) ? "selected" : ""; ?>>

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
value="<?= $fuel['litres']; ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Cost (₹)</label>

<input
type="number"
step="0.01"
name="cost"
class="form-control"
value="<?= $fuel['cost']; ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Fuel Date</label>

<input
type="date"
name="fuel_date"
class="form-control"
value="<?= $fuel['fuel_date']; ?>"
required>

</div>

<button
type="submit"
name="update_fuel"
class="btn btn-primary">

Update Fuel Log

</button>

<a
href="fuel.php"
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