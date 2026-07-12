<?php

include("../config/db.php");


// =======================
// ADD VEHICLE
// =======================

if(isset($_POST['save_vehicle']))
{
    $registration_number = trim($_POST['registration_number']);
    $vehicle_name = trim($_POST['vehicle_name']);
    $vehicle_type = trim($_POST['vehicle_type']);
    $max_capacity = $_POST['max_capacity'];
    $odometer = $_POST['odometer'];
    $acquisition_cost = $_POST['acquisition_cost'];

    $status = "Available";

    $sql = "INSERT INTO vehicles
    (registration_number, vehicle_name, vehicle_type, max_capacity, odometer, acquisition_cost, status)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssiiis",
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
        header("Location: ../pages/vehicles.php?success=1");
        exit;
    }
    else
    {
        die("Error : ".mysqli_error($conn));
    }
}


// =======================
// DELETE VEHICLE
// =======================

if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    $stmt = mysqli_prepare($conn,
    "DELETE FROM vehicles WHERE vehicle_id=?");

    mysqli_stmt_bind_param($stmt,"i",$id);

    mysqli_stmt_execute($stmt);

    header("Location: ../pages/vehicles.php?deleted=1");
    exit;
}



// =======================
// UPDATE VEHICLE
// =======================

if(isset($_POST['update_vehicle']))
{

    $vehicle_id = $_POST['vehicle_id'];

    $registration_number = trim($_POST['registration_number']);
    $vehicle_name = trim($_POST['vehicle_name']);
    $vehicle_type = trim($_POST['vehicle_type']);
    $max_capacity = $_POST['max_capacity'];
    $odometer = $_POST['odometer'];
    $acquisition_cost = $_POST['acquisition_cost'];
    $status = $_POST['status'];

    $sql = "UPDATE vehicles SET

        registration_number=?,
        vehicle_name=?,
        vehicle_type=?,
        max_capacity=?,
        odometer=?,
        acquisition_cost=?,
        status=?

        WHERE vehicle_id=?";

    $stmt = mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param(

        $stmt,

        "sssiiisi",

        $registration_number,
        $vehicle_name,
        $vehicle_type,
        $max_capacity,
        $odometer,
        $acquisition_cost,
        $status,
        $vehicle_id

    );

    if(mysqli_stmt_execute($stmt))
    {
        header("Location: ../pages/vehicles.php?updated=1");
        exit;
    }
    else
    {
        die("Update Failed");
    }

}