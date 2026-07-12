<?php

include("../config/db.php");
include("../includes/header.php");
include("../includes/navbar.php");

// Check ID
if(!isset($_GET['id']))
{
    header("Location: drivers.php");
    exit;
}

$driver_id = $_GET['id'];

// Fetch Driver
$stmt = mysqli_prepare($conn,"SELECT * FROM drivers WHERE driver_id=?");
mysqli_stmt_bind_param($stmt,"i",$driver_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$driver = mysqli_fetch_assoc($result);

if(!$driver)
{
    echo "<div class='container mt-4'>";
    echo "<div class='alert alert-danger'>Driver Not Found.</div>";
    echo "</div>";
    include("../includes/footer.php");
    exit;
}

?>

<div class="container mt-4">

<div class="card shadow">

<div class="card-header bg-warning">
<h3>Edit Driver</h3>
</div>

<div class="card-body">

<form action="../actions/driver_action.php" method="POST">

<input type="hidden"
name="driver_id"
value="<?= $driver['driver_id']; ?>">

<div class="mb-3">
<label class="form-label">Driver Name</label>

<input
type="text"
name="name"
class="form-control"
value="<?= htmlspecialchars($driver['name']); ?>"
required>

</div>

<div class="mb-3">
<label class="form-label">License Number</label>

<input
type="text"
name="license_number"
class="form-control"
value="<?= htmlspecialchars($driver['license_number']); ?>"
required>

</div>

<div class="mb-3">
<label class="form-label">License Category</label>

<select
name="license_category"
class="form-select">

<option value="LMV"
<?= ($driver['license_category']=="LMV")?"selected":""; ?>>
LMV
</option>

<option value="HMV"
<?= ($driver['license_category']=="HMV")?"selected":""; ?>>
HMV
</option>

<option value="MCWG"
<?= ($driver['license_category']=="MCWG")?"selected":""; ?>>
MCWG
</option>

<option value="Transport"
<?= ($driver['license_category']=="Transport")?"selected":""; ?>>
Transport
</option>

</select>

</div>

<div class="mb-3">
<label class="form-label">License Expiry</label>

<input
type="date"
name="license_expiry"
class="form-control"
value="<?= $driver['license_expiry']; ?>"
required>

</div>

<div class="mb-3">
<label class="form-label">Contact Number</label>

<input
type="text"
name="contact_number"
class="form-control"
value="<?= $driver['contact_number']; ?>"
required>

</div>

<div class="mb-3">
<label class="form-label">Safety Score</label>

<input
type="number"
name="safety_score"
class="form-control"
value="<?= $driver['safety_score']; ?>"
min="0"
max="100"
required>

</div>

<div class="mb-3">

<label class="form-label">Status</label>

<select
name="status"
class="form-select">

<option value="Available"
<?= ($driver['status']=="Available")?"selected":"";?>>
Available
</option>

<option value="On Trip"
<?= ($driver['status']=="On Trip")?"selected":"";?>>
On Trip
</option>

<option value="Inactive"
<?= ($driver['status']=="Inactive")?"selected":"";?>>
Inactive
</option>

</select>

</div>

<button
type="submit"
name="update_driver"
class="btn btn-primary">

Update Driver

</button>

<a href="drivers.php"
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