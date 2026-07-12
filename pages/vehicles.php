<?php
session_start();

if($_SESSION['role']!="Fleet Manager")
{
die("Access Denied");
}
if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit;
}
include("../config/db.php");
include("../includes/header.php");
include("../includes/navbar.php");

// Fetch all vehicles
$query = "SELECT * FROM vehicles ORDER BY vehicle_id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h3>Add New Vehicle</h3>
        </div>

        <div class="card-body">

            <?php if(isset($_GET['success'])) { ?>
                <div class="alert alert-success">
                    Vehicle Added Successfully!
                </div>
            <?php } ?>

            <?php if(isset($_GET['updated'])) { ?>
                <div class="alert alert-success">
                    Vehicle Updated Successfully!
                </div>
            <?php } ?>

            <?php if(isset($_GET['deleted'])) { ?>
                <div class="alert alert-danger">
                    Vehicle Deleted Successfully!
                </div>
            <?php } ?>

            <form action="../actions/vehicle_action.php" method="POST">

                <div class="mb-3">
                    <label class="form-label">Registration Number</label>
                    <input type="text" name="registration_number" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Vehicle Name</label>
                    <input type="text" name="vehicle_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Vehicle Type</label>
                    <input type="text" name="vehicle_type" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Maximum Capacity (kg)</label>
                    <input type="number" name="max_capacity" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Odometer (km)</label>
                    <input type="number" name="odometer" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Acquisition Cost</label>
                    <input type="number" name="acquisition_cost" class="form-control" required>
                </div>

                <button type="submit" name="save_vehicle" class="btn btn-success">
                    Save Vehicle
                </button>

            </form>

        </div>

    </div>

    <hr>

    <!-- Search -->

    <div class="card shadow mt-4">

        <div class="card-header bg-secondary text-white">
            <h4>Vehicle List</h4>
        </div>

        <div class="card-body">

            <input
                type="text"
                id="searchVehicle"
                class="form-control mb-3"
                placeholder="Search Vehicle..."
            >

            <table class="table table-bordered table-hover" id="vehicleTable">

                <thead class="table-dark">

                <tr>

                    <th>ID</th>
                    <th>Registration</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Capacity</th>
                    <th>Odometer</th>
                    <th>Cost</th>
                    <th>Status</th>
                    <th width="170">Actions</th>

                </tr>

                </thead>

                <tbody>   <?php while($row = mysqli_fetch_assoc($result)) { ?>

                    <?php

                    $statusColors = [
                        "Available"=>"success",
                        "On Trip"=>"primary",
                        "In Shop"=>"warning",
                        "Retired"=>"danger"
                    ];

                    $badge = $statusColors[$row['status']] ?? "secondary";

                    ?>

                    <tr>

                        <td><?= $row['vehicle_id']; ?></td>

                        <td><?= $row['registration_number']; ?></td>

                        <td><?= $row['vehicle_name']; ?></td>

                        <td><?= $row['vehicle_type']; ?></td>

                        <td><?= $row['max_capacity']; ?> kg</td>

                        <td><?= number_format($row['odometer']); ?> km</td>

                        <td>₹<?= number_format($row['acquisition_cost']); ?></td>

                        <td>

                            <span class="badge bg-<?= $badge ?>">
                                <?= $row['status']; ?>
                            </span>

                        </td>

                        <td>

                            <a href="../actions/edit_vehicle.php?id=<?= $row['vehicle_id']; ?>"
                               class="btn btn-warning btn-sm">

                                Edit

                            </a>

                            <a href="../actions/vehicle_action.php?delete=<?= $row['vehicle_id']; ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Delete this vehicle?')">

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
document.getElementById("searchVehicle").addEventListener("keyup", function () {

    let filter = this.value.toLowerCase();

    let rows = document.querySelectorAll("#vehicleTable tbody tr");

    rows.forEach(function(row){

        let text = row.innerText.toLowerCase();

        row.style.display = text.includes(filter) ? "" : "none";

    });

});
</script>

<?php
include("../includes/footer.php");
?>