<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "tour_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validate form data (you can add more validation rules as needed)
    if ($password != $confirm_password) {
        echo "Passwords do not match.";
    } else {
        // Hash the password for security
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        echo "Password: " . $password;
        $sql = "INSERT INTO user (first_name, last_name, phone_number, email, password, role) VALUES ('$first_name', '$last_name', '$phone_number', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "User registered successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>