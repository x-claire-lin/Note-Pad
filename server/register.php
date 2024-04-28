<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {?>
  	 <script>alert('Username already exists.');</script> <?php
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database using prepared statement
        $insertSql = "INSERT INTO user (username, password) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ss", $username, $hashedPassword);
        
        if ($insertStmt->execute()) {?>
        <script>alert('You have been successfully registered');</script>;
        <script>window.location = "login.php"; </script>
        <?php 
        } else {
            echo "Error: " . $insertSql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../scripts/main.js" defer></script>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h2>MEMO</h2>
            <form action="register.php" method="POST" onsubmit="return validate();">
                <input type="text" placeholder="username" name="username">
                <div class="warning" id="loginWarning"></div>
                <input type="password" placeholder="Password" name="password">
                <div class="warning" id="passWarning"></div>
                <input type="password" placeholder="Re-type password" name="password2">
                <div class="warning" id="pass2Warning"></div>
                <button type="submit">Register</button>
            </form>
            <a href="login.php">Login</a>
        </div>
    </div>
</body>
</html>