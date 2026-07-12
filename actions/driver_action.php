<?php
include("../config/db.php");

/* ===========================
   ADD DRIVER
=========================== */

if(isset($_POST['save_driver']))
{
    $name = trim($_POST['name']);
    $license_number = trim($_POST['license_number']);
    $license_category = trim($_POST['license_category']);
    $license_expiry = $_POST['license_expiry'];
    $contact_number = trim($_POST['contact_number']);
    $safety_score = $_POST['safety_score'];
    $status = "Available";

    $sql = "INSERT INTO drivers
    (name, license_number, license_category, license_expiry, contact_number, safety_score, status)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssis",
        $name,
        $license_number,
        $license_category,
        $license_expiry,
        $contact_number,
        $safety_score,
        $status
    );

    if(mysqli_stmt_execute($stmt))
    {
        header("Location: ../pages/drivers.php?success=1");
        exit;
    }
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
}


/* ===========================
   UPDATE DRIVER
=========================== */

if(isset($_POST['update_driver']))
{
    $driver_id = $_POST['driver_id'];

    $name = trim($_POST['name']);
    $license_number = trim($_POST['license_number']);
    $license_category = trim($_POST['license_category']);
    $license_expiry = $_POST['license_expiry'];
    $contact_number = trim($_POST['contact_number']);
    $safety_score = $_POST['safety_score'];
    $status = $_POST['status'];

    $sql = "UPDATE drivers SET

    name=?,
    license_number=?,
    license_category=?,
    license_expiry=?,
    contact_number=?,
    safety_score=?,
    status=?

    WHERE driver_id=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssisi",
        $name,
        $license_number,
        $license_category,
        $license_expiry,
        $contact_number,
        $safety_score,
        $status,
        $driver_id
    );

    if(mysqli_stmt_execute($stmt))
    {
        header("Location: ../pages/drivers.php?updated=1");
        exit;
    }
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
}


/* ===========================
   DELETE DRIVER
=========================== */

if(isset($_GET['delete']))
{
    $driver_id = $_GET['delete'];

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM drivers WHERE driver_id=?"
    );

    mysqli_stmt_bind_param($stmt, "i", $driver_id);

    if(mysqli_stmt_execute($stmt))
    {
        header("Location: ../pages/drivers.php?deleted=1");
        exit;
    }
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
}
?>