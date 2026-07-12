<?php

session_start();

include("../config/db.php");

if(isset($_POST['login']))
{

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$sql = "SELECT * FROM users
WHERE email=? AND password=?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"ss",
$email,
$password
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result)==1)
{

$user = mysqli_fetch_assoc($result);

$_SESSION['user_id'] = $user['user_id'];
$_SESSION['name'] = $user['name'];
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $user['role'];

header("Location: ../pages/dashboard.php");
exit;

}
else
{

header("Location: ../pages/login.php?error=1");
exit;

}

}
?>