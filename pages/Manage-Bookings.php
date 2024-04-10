<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
    <div class="container">
        <h1>Manage Bookings</h1>
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
            <tbody>
<?php
include_once '../db_config/db_connection.php';

// use join to get the tour name
$sql = "SELECT b.booking_id, t.name, t.start_date, t.end_date, t.price, b.booking_status FROM Bookings b JOIN Tours t ON b.tour_id = t.tour_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['booking_id']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['start_date']."</td>";
        echo "<td>".$row['end_date']."</td>";
        echo "<td>".$row['price']."</td>";
        echo "<td>";
        echo "<form method='post' action='$_SERVER[PHP_SELF]'>";
        echo "<input type='hidden' name='booking_id' value='".$row['booking_id']."'>";
            echo "<select class='booking-status' name='status'>";
            echo "<option value='pending'".($row['booking_status'] == 'pending' ? ' selected' : '')."'>Pending</option>";
            echo "<option value='confirmed'".($row['booking_status'] == 'confirmed' ? ' selected' : '')." >Confirmed</option>";
            echo "<option value='cancelled'".($row['booking_status'] == 'cancelled' ? ' selected' : '')." >Cancelled</option>";
            echo "<option value='completed'".($row['booking_status'] == 'completed' ? ' selected' : '')." >Completed</option>";
            echo "</select>";
            echo "</td>";
            echo "<td>";
            echo "<input type='submit' value='Save'>";
            // echo "<a href='Manage-Bookings.php?save=".$row['booking_id']."'>Save</a>";
            echo "</td>";
            echo "</form>";
        echo "</tr>";
    }

} else {
    echo "<tr><td colspan='7'>No bookings found</td></tr>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];
    $sql = "UPDATE Bookings SET booking_status='$status' WHERE booking_id=$booking_id";
    $conn->query($sql);
    header("Location: Manage-Bookings.php");
    // exit();
}

$conn->close();

?>

            </tbody>

            </tbody>
        </table>

</body>
</html>