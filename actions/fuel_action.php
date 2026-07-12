<?php

include("../config/db.php");

/* ===========================================
   ADD FUEL LOG
=========================================== */

if(isset($_POST['save_fuel']))
{
    $vehicle_id = $_POST['vehicle_id'];
    $litres = $_POST['litres'];
    $cost = $_POST['cost'];
    $fuel_date = $_POST['fuel_date'];

    $sql = "INSERT INTO fuel_logs
    (vehicle_id, liters, cost, fuel_date)
    VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "idds",
        $vehicle_id,
        $litres,
        $cost,
        $fuel_date
    );

    if(mysqli_stmt_execute($stmt))
    {
        header("Location: ../pages/fuel.php?success=1");
        exit;
    }
    else
    {
        die("Error: " . mysqli_stmt_error($stmt));
    }
}


/* ===========================================
   UPDATE FUEL LOG
=========================================== */

if(isset($_POST['update_fuel']))
{
    $fuel_id = $_POST['fuel_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $litres = $_POST['litres'];
    $cost = $_POST['cost'];
    $fuel_date = $_POST['fuel_date'];

    $sql = "UPDATE fuel_logs SET

    vehicle_id=?,
    litres=?,
    cost=?,
    fuel_date=?

    WHERE fuel_id=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "iddsi",
        $vehicle_id,
        $litres,
        $cost,
        $fuel_date,
        $fuel_id
    );

    if(mysqli_stmt_execute($stmt))
    {
        header("Location: ../pages/fuel.php?updated=1");
        exit;
    }
    else
    {
        die("Error: " . mysqli_stmt_error($stmt));
    }
}


/* ===========================================
   DELETE FUEL LOG
=========================================== */

if(isset($_GET['delete']))
{
    $fuel_id = $_GET['delete'];

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM fuel_logs WHERE fuel_id=?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $fuel_id
    );

    if(mysqli_stmt_execute($stmt))
    {
        header("Location: ../pages/fuel.php?deleted=1");
        exit;
    }
    else
    {
        die("Error: " . mysqli_stmt_error($stmt));
    }
}
?>