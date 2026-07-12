<?php

include("../config/db.php");

/* ==========================
   ADD
========================== */

if(isset($_POST['save_maintenance']))
{

$vehicle_id=$_POST['vehicle_id'];
$reason=trim($_POST['reason']);
$maintenance_date=$_POST['maintenance_date'];
$status=$_POST['status'];

$sql="INSERT INTO maintenance
(vehicle_id,reason,maintenance_date,status)
VALUES(?,?,?,?)";

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"isss",
$vehicle_id,
$reason,
$maintenance_date,
$status
);

if(mysqli_stmt_execute($stmt))
{

if($status=="Pending" || $status=="In Progress")
{

mysqli_query($conn,
"UPDATE vehicles
SET status='In Shop'
WHERE vehicle_id='$vehicle_id'");

}

header("Location: ../pages/maintenance.php?success=1");
exit;

}

}

/* ==========================
   UPDATE
========================== */

if(isset($_POST['update_maintenance']))
{

$maintenance_id=$_POST['maintenance_id'];
$vehicle_id=$_POST['vehicle_id'];
$reason=trim($_POST['reason']);
$maintenance_date=$_POST['maintenance_date'];
$status=$_POST['status'];

$sql="UPDATE maintenance SET

vehicle_id=?,
reason=?,
maintenance_date=?,
status=?

WHERE maintenance_id=?";

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(

$stmt,

"isssi",

$vehicle_id,
$reason,
$maintenance_date,
$status,
$maintenance_id

);

if(mysqli_stmt_execute($stmt))
{

if($status=="Completed")
{

mysqli_query($conn,
"UPDATE vehicles
SET status='Available'
WHERE vehicle_id='$vehicle_id'");

}
else
{

mysqli_query($conn,
"UPDATE vehicles
SET status='In Shop'
WHERE vehicle_id='$vehicle_id'");

}

header("Location: ../pages/maintenance.php?updated=1");
exit;

}

}

/* ==========================
   DELETE
========================== */

if(isset($_GET['delete']))
{

$maintenance_id=$_GET['delete'];

$get=mysqli_query($conn,
"SELECT vehicle_id
FROM maintenance
WHERE maintenance_id='$maintenance_id'");

$row=mysqli_fetch_assoc($get);

mysqli_query($conn,
"UPDATE vehicles
SET status='Available'
WHERE vehicle_id=".$row['vehicle_id']);

$stmt=mysqli_prepare(
$conn,
"DELETE FROM maintenance
WHERE maintenance_id=?"
);

mysqli_stmt_bind_param(
$stmt,
"i",
$maintenance_id
);

mysqli_stmt_execute($stmt);

header("Location: ../pages/maintenance.php?deleted=1");
exit;

}

?>