<?php

include("../config/db.php");

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
    echo "Error: " . mysqli_error($conn);
}
mysqli_stmt_close($stmt);
}

?>