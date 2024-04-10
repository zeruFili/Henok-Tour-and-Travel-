<?php
// Start a PHP session
session_start();

// Check if the user is already logged in, redirect to home page if logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Include the database connection file
include_once 'db_config/db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user data from database based on email
    $sql = "SELECT * FROM Users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables and redirect to home page
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            header("Location: index.php");
            exit();
        } else {
            // Password is incorrect
            $_SESSION['error_message'] = "Invalid email or password.";
            header("Location: login.php");
            exit();
        }
    } else {
        // User not found
        $_SESSION['error_message'] = "Invalid email or password.";
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
        <link rel="stylesheet" href="css/login/styles.css">
        <title>User Registration</title>
        
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
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login" name = "login">
        </form>
        <p>Don't have an account? <a href="registration.php">Sign Up</a></p>
    </div>
</body>

</html>

