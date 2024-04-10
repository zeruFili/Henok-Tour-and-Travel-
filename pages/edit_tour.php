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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include_once 'common/header.php'; ?>
    <div class="container">
        <h2>Welcome, Admin!</h2>
        <table class="tour-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Duration</th>
                    <th>Destinaion</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
<?php 

include_once '../db_config/db_connection.php';

$sql = "SELECT * FROM Tours";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['description']."</td>";
        echo "<td>".$row['duration']."</td>";
        echo "<td>".$row['destination']."</td>";
        echo "<td>".$row['start_date']."</td>";
        echo "<td>".$row['end_date']."</td>";
        echo "<td>".$row['price']."</td>";
        echo "<td>";
        echo "<a href='Dashboard.php?edit=".$row['tour_id']."'>Edit</a>";
        echo " | ";
        echo "<a href='Dashboard.php?delete=".$row['tour_id']."'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }

} else {
    echo "<tr><td colspan='8'>No tours found</td></tr>";
}

?>

            </tbody>
        </table>

    </div>

<?php

include_once '../db_config/db_connection.php';

if(isset($_POST['add_tour'])) {
    // Collect form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $destination = $_POST['destination'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $price = $_POST['price'];

    // Insert tour data into the database
    $sql = "INSERT INTO Tours (name, description, duration, destination, start_date, end_date, price) 
            VALUES ('$name', '$description', '$duration', '$destination', '$start_date', '$end_date', '$price')";

    if ($conn->query($sql) === TRUE) {

        echo "New tour added successfully!";
        header("Location: Dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// $conn->close();
?>

    <div class="container">

<?php
// if there is an edit pre fill the form with the tour data

include_once '../db_config/db_connection.php';


// update tour data
if (isset($_POST['edit_tour'])) {
    $tour_id = $_POST['tour_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $destination = $_POST['destination'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $price = $_POST['price'];

    $sql = "UPDATE Tours SET name='$name', description='$description', duration='$duration', destination='$destination', start_date='$start_date', end_date='$end_date', price='$price' WHERE tour_id=$tour_id";

    if ($conn->query($sql) === TRUE) {
        echo "Tour updated successfully!";
        header("Location: Dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        header("Location: login.php");
    }
}


// pre fill the form with the tour data
if (isset($_GET['edit'])) {
    $tour_id = $_GET['edit'];
    $sql = "SELECT * FROM Tours WHERE tour_id=$tour_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        echo "<form action='Dashboard.php' class='tour-form' method='post'>";
        echo "<input type='text' name='name' placeholder='Tour Name' value='".$row['name']."' required>";
        echo "<input type='text' name='description' placeholder='Description' value='".$row['description']."' required>";
        echo "<input type='number' name='duration' placeholder='Duration' value='".$row['duration']."' required>";
        echo "<input type='text' name='destination' placeholder='Destination' value='".$row['destination']."' required>";
        echo "<label for='start_date'>Start Date</label>";
        echo "<input type='date' name='start_date' placeholder='Start Date' value='".$row['start_date']."' required>";
        echo "<label for='end_date'>End Date</label>";
        echo "<input type='date' name='end_date' placeholder='End Date' value='".$row['end_date']."' required>";
        echo "<input type='number' name='price' placeholder='Price' value='".$row['price']."' required>";
        echo "<input type='hidden' name='tour_id' value='".$row['tour_id']."'>";
        echo "<input type='submit' value='Update Tour' name='edit_tour'>";
        echo " | ";
        echo "<a href='Dashboard.php' class='btn'>Cancel</a>";
        echo "</form>";
    }

    
} else {
        // If no tour id is set it should display the form to add a new tour
        echo '<h2>Add New Tour</h2>';
        echo '<form action="' . $_SERVER["PHP_SELF"] . '" class="tour-form" method="post">';
        echo '<input type="text" name="name" placeholder="Tour Name" required>';
        echo '<input type="text" name="description" placeholder="Description" required>';
        echo '<input type="number" name="duration" placeholder="Duration" required>';
        echo '<input type="text" name="destination" placeholder="Destination" required>';
        echo '<label for="start_date">Start Date</label>';
        echo '<input type="date" name="start_date" placeholder="Start Date" required>';
        echo '<label for="end_date">End Date</label>';
        echo '<input type="date" name="end_date" placeholder="End Date" required>';
        echo '<input type="number" name="price" placeholder="Price" required>';
        echo '<input type="submit" value="Add Tour" name="add_tour">';
        echo '</form>';
    }
    ?>

        <div/>
    </div>


<?php

include_once '../db_config/db_connection.php';

if (isset($_GET['delete'])) {
    $tour_id = $_GET['delete'];
    $sql = "DELETE FROM Tours WHERE tour_id=$tour_id";

    if ($conn->query($sql) === TRUE) {
        echo "Tour deleted successfully!";
        header("Location: Dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

</body>
</html>
