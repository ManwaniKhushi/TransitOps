<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../config/db.php");
if(isset($_POST['save_vehicle']))
{
    $registration_number = trim($_POST['registration_number']);
    $vehicle_name = trim($_POST['vehicle_name']);
    $vehicle_type = trim($_POST['vehicle_type']);
    $max_capacity = $_POST['max_capacity'];
    $odometer = $_POST['odometer'];
    $acquisition_cost = $_POST['acquisition_cost'];

    // New vehicles are always available
    $status = "Available";

    $sql = "INSERT INTO vehicles
    (registration_number, vehicle_name, vehicle_type, max_capacity, odometer, acquisition_cost, status)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssddds",
        $registration_number,
        $vehicle_name,
        $vehicle_type,
        $max_capacity,
        $odometer,
        $acquisition_cost,
        $status
    );

    if(mysqli_stmt_execute($stmt))
    {
      header("Location: vehicles.php?success=1");
exit;
    }
    else
    {
        echo "<div class='alert alert-danger'>Error Adding Vehicle.</div>";
    }

    mysqli_stmt_close($stmt);
}
include("../includes/header.php");
include("../includes/navbar.php");
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h3>Add New Vehicle</h3>
        </div>

        <div class="card-body">

            <form action="" method="POST">

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
                    <input type="text" name="vehicle_type" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Maximum Capacity (kg)</label>
                    <input type="number" name="max_capacity" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Odometer (km)</label>
                    <input type="number" name="odometer" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Acquisition Cost</label>
                    <input type="number" name="acquisition_cost" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>

                    <select name="status" class="form-select">

                        <option value="Available">Available</option>
                        <option value="On Trip">On Trip</option>
                        <option value="In Shop">In Shop</option>
                        <option value="Retired">Retired</option>

                    </select>

                </div>

               <button type="submit" name="save_vehicle" class="btn btn-success">
    Save Vehicle
</button>
            </form>

        </div>

    </div>

</div>

<?php
include("../includes/footer.php");
?>