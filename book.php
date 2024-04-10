<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include_once 'common/header.php'; ?>
    <div class="heading-title" style="background:url(images/header-bg-2.png) no-repeat">

<?php
include_once 'db_config/db_connection.php';

if (isset($_GET['id'])) {
    $tour_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO Bookings (tour_id, user_id) VALUES ('$tour_id', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        echo "<h1>Booking created successfully</h1>";
        echo "<a href='my-booking.php'>View Bookings</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
    </div>
    <?php include_once 'common/footer.php'; ?>


</div>  
</body>
</html>