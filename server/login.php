<?php
session_start(); 

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare a statement for safer execution
    $stmt = $conn->prepare("SELECT userid, username, password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

     if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        if (password_verify($password, $row['password'])) {
            // Set session variables after successful authentication
            $_SESSION['username'] = $row['username']; 
            $_SESSION['userid'] = $row['userid']; 
            
            header("Location: index.php");
            exit;
        } else {
            $errorMessage = "Invalid username or password.";
        }
    } else {
        $errorMessage = "Invalid username or password.";
    }
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>MEMO</h2>
            <form action="login.php" method="POST">
                <input type="text" placeholder="username" name="username" required>
                <input type="password" placeholder="Password" name="password" required>
                <button type="submit">Login</button>
            </form>
            <?php 
            if (isset($errorMessage)) { ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
            <?php } 
            ?>
            <a href="register.php">Register</a>
        </div>
    </div>
    
</body>
</html>
