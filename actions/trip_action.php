<?php

include("../config/db.php");

if(isset($_POST['save_trip']))
{
    $vehicle_id = $_POST['vehicle_id'];
    $driver_id = $_POST['driver_id'];
    $source = trim($_POST['source']);
    $destination = trim($_POST['destination']);
    $cargo_weight = $_POST['cargo_weight'];
    $planned_distance = $_POST['planned_distance'];
    $status = $_POST['status'];
    $trip_date = date("Y-m-d");
   $sql = "INSERT INTO trips
   (source,destination,vehicle_id,driver_id,cargo_weight,planned_distance,status,trip_date)
VALUES (?,?,?,?,?,?,?,?)";

    $stmt = mysqli_prepare($conn,$sql);

  mysqli_stmt_bind_param(
    $stmt,
    "ssiiddss",
    $source,
    $destination,
    $vehicle_id,
    $driver_id,
    $cargo_weight,
    $planned_distance,
    $status,
    $trip_date
);

    if(mysqli_stmt_execute($stmt))
    {
        // Vehicle Status
        mysqli_query($conn,
        "UPDATE vehicles
        SET status='On Trip'
        WHERE vehicle_id='$vehicle_id'");

        // Driver Status
        mysqli_query($conn,
        "UPDATE drivers
        SET status='On Trip'
        WHERE driver_id='$driver_id'");

        header("Location: ../pages/trips.php?success=1");
        exit;
    }
}
if(isset($_GET['delete']))
{
    $trip_id = $_GET['delete'];
    $trip = mysqli_query($conn,
    "SELECT vehicle_id,driver_id
    FROM trips
    WHERE trip_id='$trip_id'");

    $row = mysqli_fetch_assoc($trip);

    // Make them Available again
    mysqli_query($conn,
    "UPDATE vehicles
    SET status='Available'
    WHERE vehicle_id=".$row['vehicle_id']);

    mysqli_query($conn,
    "UPDATE drivers
    SET status='Available'
    WHERE driver_id=".$row['driver_id']);

    // Delete Trip
    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM trips WHERE trip_id=?"
    );

    mysqli_stmt_bind_param($stmt,"i",$trip_id);

    mysqli_stmt_execute($stmt);

    header("Location: ../pages/trips.php?deleted=1");
    exit;
}
if(isset($_POST['update_trip']))
{

    $trip_id = $_POST['trip_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $driver_id = $_POST['driver_id'];

    $source = trim($_POST['source']);
    $destination = trim($_POST['destination']);

    $cargo_weight = $_POST['cargo_weight'];
    $planned_distance = $_POST['planned_distance'];

    $status = $_POST['status'];

    $sql = "UPDATE trips SET

    source=?,
    destination=?,
    vehicle_id=?,
    driver_id=?,
    cargo_weight=?,
    planned_distance=?,
    status=?

    WHERE trip_id=?";

    $stmt = mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param(

        $stmt,

        "ssiiddss",

        $source,
        $destination,
        $vehicle_id,
        $driver_id,
        $cargo_weight,
        $planned_distance,
        $status,
        $trip_id

    );

    if(mysqli_stmt_execute($stmt))
    {

        if($status=="Completed" || $status=="Cancelled")
        {

            mysqli_query($conn,
            "UPDATE vehicles
            SET status='Available'
            WHERE vehicle_id='$vehicle_id'");

            mysqli_query($conn,
            "UPDATE drivers
            SET status='Available'
            WHERE driver_id='$driver_id'");

        }
        else
        {

            mysqli_query($conn,
            "UPDATE vehicles
            SET status='On Trip'
            WHERE vehicle_id='$vehicle_id'");

            mysqli_query($conn,
            "UPDATE drivers
            SET status='On Trip'
            WHERE driver_id='$driver_id'");

        }

        header("Location: ../pages/trips.php?updated=1");
        exit;
    }

}

?>