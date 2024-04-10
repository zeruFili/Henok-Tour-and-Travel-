<?php
// Start a PHP session
session_start();

// if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
include_once 'db_config/db_connection.php';
// Close the database connection
?>

<?php include_once 'common/header.php'; ?>

<div class="heading" style="background:url(images/header-bg-3.png) no-repeat">
   <h1>book now</h1>
</div>


<section class="booking">

   <h1 class="heading-title">Welcome</h1>

<?php
// pre fill the form with user data

include 'db_config/db_connection.php';

$sql = "SELECT * FROM Users WHERE user_id=".$_SESSION['user_id'];
$result = $conn->query($sql);

if ($result->num_rows == 1) {
   $row = $result->fetch_assoc();
   $first_name = $row['first_name'];
   $last_name = $row['last_name'];
   $email = $row['email'];
   $phone_number = $row['phone_number'];

   echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post' class='book-form'>";
   echo "<h2>Profile Details</h2>";
   echo "<div class='flex'>";
   echo "<div class='inputBox'>";
   echo "<span>First Name :</span>";
   echo "<input type='text' placeholder='enter your name' name='first_name' value='$first_name'>";
   echo "</div>";
   echo "<div class='inputBox'>";
   echo "<span>Last Name :</span>";
   echo "<input type='text' placeholder='enter your name' name='last_name' value='$last_name'>"; // Corrected here
   echo "</div>";
   echo "<div class='inputBox'>";
   echo "<span>email :</span>";
   echo "<input type='email' placeholder='enter your email' name='email' value='$email'>";
   echo "</div>";
   echo "<div class='inputBox'>";
   echo "<span>phone :</span>";
   echo "<input type='number' placeholder='enter your number' name='phone_number' value='$phone_number'>";
   echo "</div>";
   echo "</div>";
   
   echo "<input type='submit' value='submit' class='btn' name='send'>";
   echo "</form>";
}

   // edit if the form is submitted

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $first_name = $_POST['first_name'];
   $last_name = $_POST['last_name'];
   $email = $_POST['email'];
   $phone_number = $_POST['phone_number'];

   $sql = "UPDATE Users SET first_name='$first_name', last_name='$last_name', email='$email', phone_number='$phone_number' WHERE user_id=".$_SESSION['user_id'];

   if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Profile updated successfully
      first_name: $first_name
         last_name: $last_name
         email: $email
         phone_number: $phone_number'
      );</script>";
   } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
   }
}

// edit if the form is submitted

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    $sql = "UPDATE Users SET first_name='$first_name', last_name='$last_name', email='$email', phone_number='$phone_number' WHERE user_id=".$_SESSION['user_id'];

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Profile updated successfully);</script>";
        header("Location: profile.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>




</section>


<?php include_once 'common/footer.php'; ?>

</body>
</html>