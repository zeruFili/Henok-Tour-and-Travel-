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
        <h1>Manage Users</h1>
        <table class="tour-table">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone_number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

<?php
include_once '../db_config/db_connection.php';

$sql = "SELECT * FROM Users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['first_name']."</td>";
        echo "<td>".$row['last_name']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['phone_number']."</td>";
        echo "<td>";
        echo "<a href='Manage-Users.php?delete=".$row['user_id']."'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }

} else {
    echo "<tr><td colspan='5'>No users found</td></tr>";
}

if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $sql = "DELETE FROM Users WHERE user_id=$user_id";
    $conn->query($sql);
    header("Location: Manage-Users.php");
    exit();
}

$conn->close();


?>
            </tbody>
        </table>




                <!-- <tr>
                    <td>John Doe</td>
                    <td>Doe</td>
                    <td>
                        <a href="mailto:
                        ">
                        </a>
                    </td>
                    <td>1234567890</td>
                    <td>
                        <a href="Manage-Users.php?delete=1">Delete</a>
                    </td>
                </tr> -->

    </div>
</body>
</html>