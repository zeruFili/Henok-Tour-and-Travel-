<?php
session_start();

include_once 'db_config/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $phoneNumber = $_POST['phone_number'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($password != $confirmPassword) {
        $_SESSION['error_message'] = "Passwords do not match.";
        header("Location: registration.php");
        exit();
    }

    $sql = "INSERT INTO Users (email, password, first_name, last_name, phone_number) 
            VALUES ('$email', '$hashedPassword', '$firstName', '$lastName', '$phoneNumber')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Registration successful. You can now login.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error: " . $conn->error;
    }
}

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
        <h1>User Registration</h1>
        <?php
        if (isset($_SESSION['error_message'])) {
            echo "<p style='color: red;'>".$_SESSION['error_message']."</p>";
            unset($_SESSION['error_message']);
        }
        ?>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="first_name" name="first_name" placeholder="First Name" required>
            <input type="last_name" name="last_name" placeholder="Last Name" required>
            <input type="phone_number" name="phone_number" placeholder="Phone Number" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <input type="submit" value="Register" name = "register">
        </form>
    </div>
</body>

</html>
