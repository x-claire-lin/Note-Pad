<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['memo']) && isset($_SESSION['userid'])) {
    $memo = $_POST['memo'];
    $userid = $_SESSION['userid'];

    $sql = "INSERT INTO notes (note, userid) VALUES (?, ?)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $memo, $userid); 
    $stmt->execute();

    $stmt->close();


    header("Location: index.php");
    exit;
}
?>