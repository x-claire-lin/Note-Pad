<?php
$server="localhost";
$username = 'cst8285Test';
$password = 'password';
$db_name = "notes";
$conn =new mysqli($server,$username, $password, $db_name);

if ($conn->connect_error) {
    die("No connection" . $conn->connect_error);
}
?>
