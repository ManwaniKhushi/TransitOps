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
    header("Location: drivers.php");
    exit;
}

$driver_id = $_GET['id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM drivers WHERE driver_id=?");
mysqli_stmt_bind_param($stmt, "i", $driver_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$driver = mysqli_fetch_assoc($result);

if(!$driver)
{
    die("Driver not found.");
}

include("../includes/header.php");
include("../includes/navbar.php");
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-warning text-dark">
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

                    <input
                        type="text"
                        name="license_category"
                        class="form-control"
                        value="<?= htmlspecialchars($driver['license_category']); ?>"
                        required>
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
                        value="<?= htmlspecialchars($driver['contact_number']); ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Safety Score</label>

                    <input
                        type="number"
                        name="safety_score"
                        class="form-control"
                        min="0"
                        max="100"
                        value="<?= $driver['safety_score']; ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>

                    <select
                        name="status"
                        class="form-select">

                        <option value="Available"
                            <?= ($driver['status']=="Available") ? "selected" : ""; ?>>
                            Available
                        </option>

                        <option value="On Trip"
                            <?= ($driver['status']=="On Trip") ? "selected" : ""; ?>>
                            On Trip
                        </option>

                        <option value="Inactive"
                            <?= ($driver['status']=="Inactive") ? "selected" : ""; ?>>
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