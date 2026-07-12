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

// Fetch Drivers
$query = "SELECT * FROM drivers ORDER BY driver_id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h3>Add New Driver</h3>
        </div>

        <div class="card-body">

            <?php if(isset($_GET['success'])) { ?>
                <div class="alert alert-success">
                    Driver Added Successfully!
                </div>
            <?php } ?>

            <?php if(isset($_GET['updated'])) { ?>
                <div class="alert alert-success">
                    Driver Updated Successfully!
                </div>
            <?php } ?>

            <?php if(isset($_GET['deleted'])) { ?>
                <div class="alert alert-danger">
                    Driver Deleted Successfully!
                </div>
            <?php } ?>

            <form action="../actions/driver_action.php" method="POST">

                <div class="mb-3">
                    <label class="form-label">Driver Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">License Number</label>
                    <input type="text" name="license_number" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">License Category</label>
                    <select name="license_category" class="form-select" required>
                        <option value="">Select Category</option>
                        <option value="LMV">LMV</option>
                        <option value="HMV">HMV</option>
                        <option value="MCWG">MCWG</option>
                        <option value="Transport">Transport</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">License Expiry</label>
                    <input type="date" name="license_expiry" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" maxlength="10" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Safety Score</label>
                    <input type="number" name="safety_score" class="form-control" min="0" max="100" required>
                </div>

                <button type="submit" name="save_driver" class="btn btn-success">
                    Save Driver
                </button>

            </form>

        </div>

    </div>

    <hr>

    <div class="card shadow mt-4">

        <div class="card-header bg-dark text-white">
            <h4>Driver List</h4>
        </div>

        <div class="card-body">

            <input
                type="text"
                id="searchDriver"
                class="form-control mb-3"
                placeholder="Search Driver..."
            >

            <table class="table table-bordered table-hover" id="driverTable">

                <thead class="table-dark">

                <tr>

                    <th>ID</th>
                    <th>Name</th>
                    <th>License No.</th>
                    <th>Category</th>
                    <th>Expiry</th>
                    <th>Contact</th>
                    <th>Safety Score</th>
                    <th>Status</th>
                    <th>Actions</th>

                </tr>

                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($result)) { ?>

                <?php

                $statusColors = [
                    "Available" => "success",
                    "On Trip" => "primary",
                    "Inactive" => "danger"
                ];

                $badge = $statusColors[$row['status']] ?? "secondary";

                ?>

                <tr>

                    <td><?= $row['driver_id']; ?></td>

                    <td><?= htmlspecialchars($row['name']); ?></td>

                    <td><?= htmlspecialchars($row['license_number']); ?></td>

                    <td><?= htmlspecialchars($row['license_category']); ?></td>

                    <td><?= $row['license_expiry']; ?></td>

                    <td><?= htmlspecialchars($row['contact_number']); ?></td>

                    <td><?= $row['safety_score']; ?></td>

                    <td>
                        <span class="badge bg-<?= $badge ?>">
                            <?= $row['status']; ?>
                        </span>
                    </td>

                    <td>

                       <a href="edit_driver.php?id=<?= $row['driver_id']; ?>"
                   class="btn btn-warning btn-sm">
                    Edit
                    </a>
                        <a href="../actions/driver_action.php?delete=<?= $row['driver_id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this driver?')">
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

document.getElementById("searchDriver").addEventListener("keyup", function(){

    let filter = this.value.toLowerCase();

    let rows = document.querySelectorAll("#driverTable tbody tr");

    rows.forEach(function(row){

        let text = row.innerText.toLowerCase();

        row.style.display = text.includes(filter) ? "" : "none";

    });

});

</script>

<?php
include("../includes/footer.php");
?>