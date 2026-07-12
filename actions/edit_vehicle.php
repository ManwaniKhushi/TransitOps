<?php

include("../config/db.php");
include("../includes/header.php");
include("../includes/navbar.php");

// Check if ID is passed
if(!isset($_GET['id']))
{
    header("Location: vehicles.php");
    exit;
}

$vehicle_id = $_GET['id'];

// Fetch vehicle details
$stmt = mysqli_prepare($conn, "SELECT * FROM vehicles WHERE vehicle_id = ?");
mysqli_stmt_bind_param($stmt, "i", $vehicle_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$vehicle = mysqli_fetch_assoc($result);

// If vehicle doesn't exist
if(!$vehicle)
{
    echo "<div class='container mt-4'>";
    echo "<div class='alert alert-danger'>Vehicle not found.</div>";
    echo "</div>";
    include("../includes/footer.php");
    exit;
}

?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-warning text-dark">
            <h3>Edit Vehicle</h3>
        </div>

        <div class="card-body">

            <form action="../actions/vehicle_action.php" method="POST">

                <!-- Hidden ID -->
                <input type="hidden" name="vehicle_id" value="<?= $vehicle['vehicle_id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Registration Number</label>
                    <input
                        type="text"
                        name="registration_number"
                        class="form-control"
                        value="<?= htmlspecialchars($vehicle['registration_number']); ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Vehicle Name</label>
                    <input
                        type="text"
                        name="vehicle_name"
                        class="form-control"
                        value="<?= htmlspecialchars($vehicle['vehicle_name']); ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Vehicle Type</label>
                    <input
                        type="text"
                        name="vehicle_type"
                        class="form-control"
                        value="<?= htmlspecialchars($vehicle['vehicle_type']); ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Maximum Capacity (kg)</label>
                    <input
                        type="number"
                        name="max_capacity"
                        class="form-control"
                        value="<?= $vehicle['max_capacity']; ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Odometer (km)</label>
                    <input
                        type="number"
                        name="odometer"
                        class="form-control"
                        value="<?= $vehicle['odometer']; ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Acquisition Cost</label>
                    <input
                        type="number"
                        name="acquisition_cost"
                        class="form-control"
                        value="<?= $vehicle['acquisition_cost']; ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>

                    <select name="status" class="form-select">

                        <option value="Available"
                            <?= ($vehicle['status']=="Available") ? "selected" : ""; ?>>
                            Available
                        </option>

                        <option value="On Trip"
                            <?= ($vehicle['status']=="On Trip") ? "selected" : ""; ?>>
                            On Trip
                        </option>

                        <option value="In Shop"
                            <?= ($vehicle['status']=="In Shop") ? "selected" : ""; ?>>
                            In Shop
                        </option>

                        <option value="Retired"
                            <?= ($vehicle['status']=="Retired") ? "selected" : ""; ?>>
                            Retired
                        </option>

                    </select>

                </div>

                <button
                    type="submit"
                    name="update_vehicle"
                    class="btn btn-primary">

                    Update Vehicle

                </button>

                <a href="vehicles.php" class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>

    </div>

</div>

<?php
include("../includes/footer.php");
?>