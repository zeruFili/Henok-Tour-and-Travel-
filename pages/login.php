<?php
// Start a PHP session
session_start();

// Check if the user is already logged in, redirect to home page if logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: Dashboard.php");
    exit();
}

include_once '../db_config/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Admin WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password == $row['password']) {
            $_SESSION['admin_id'] = $row['admin_id'];
            header("Location: Dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Invalid us or password.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Invalid username or password.";
        header("Location: login.php");
        exit();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/login/styles.css">
        <title>Admin Login</title>
        
    </head>
    <body>
        <div class="container">
            <h1>Login</h1>
            <?php
        if (isset($_SESSION['error_message'])) {
            echo "<p style='color: red;'>".$_SESSION['error_message']."</p>";
            unset($_SESSION['error_message']);
        }
        ?>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login" name = "login">
        </form>
        <p>Don't have an account? <a href="registration.php">Sign Up</a></p>
    </div>
</body>

</html>

