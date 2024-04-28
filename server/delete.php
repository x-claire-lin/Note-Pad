<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['noteId'])) {
    $noteId = $_POST['noteId'];
    $userid = $_SESSION['userid']; 

    $sql = "DELETE FROM notes WHERE noteid = ? AND userid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $noteId, $userid);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['flash_message'] = "Memo deleted successfully.";
    } else {
        $_SESSION['flash_message'] = "Error: Note could not be deleted or does not exist.";
    }

    $stmt->close();
    $conn->close();

    header("Location: index.php");
    exit;
}
?>
