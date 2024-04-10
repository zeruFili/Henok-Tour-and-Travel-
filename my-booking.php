<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include_once 'db_config/db_connection.php';

$sql = "SELECT * FROM Users WHERE user_id=".$_SESSION['user_id'];
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $address = $row['address'];
}

?>

<!DOCTYPE html><!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>

<?php include_once 'common/header.php'; ?>


<div class="heading" style="background:url(images/header-bg-3.png) no-repeat">
   <h1>book now</h1>
</div>


<section class="booking">

    <h1 class="heading-title">Welcome</h1>
        <table class="tour-table">
             <thead>
                <tr>
                 <th>Booking ID</th>
                 <th>Package Name</th>
                 <th>Start Date</th>
                 <th>End Date</th>
                   <th>Price</th>
                   <th>Status</th>
                   <th>Actions</th>
                </tr>
             </thead>
<?php
include_once 'db_config/db_connection.php';


$sql = "SELECT * FROM Bookings b JOIN Tours t ON b.tour_id = t.tour_id WHERE user_id=".$_SESSION['user_id'];
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['booking_id']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['start_date']."</td>";
        echo "<td>".$row['end_date']."</td>";
        echo "<td>".$row['price']."</td>";
        echo "<td>".$row['booking_status']."</td>";
        echo "<td>";
        echo "<a href='my-booking.php?cancel=".$row['booking_id']."'>Cancel</a>";
        echo "</td>";
        echo "</tr>";
    }
}


if (isset($_GET['cancel'])) {
    $booking_id = $_GET['cancel'];
    $sql = "UPDATE Bookings SET booking_status='cancelled' WHERE booking_id=$booking_id";
    $conn->query($sql);
    header("Location: my-booking.php");
    exit();
}

$conn->close();

?>

         </tbody>
        </table>


</section>

<?php include_once 'common/footer.php'; ?>

</body>
</html>