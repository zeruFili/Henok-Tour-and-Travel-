<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   

<section class="header">

   <a href="home.php" class="logo">Henok Tours.</a>

   <nav class="navbar">
      <a href="index.php">home</a>
      <a href="about.php">about</a>
      <a href="package.php">package</a>
<?php

session_start();
    if (isset($_SESSION['user_id'])) {
        echo "<a href='profile.php'>Profile</a>";
        echo "<a href='my-booking.php'>My Bookings</a>";
        echo '<a href="logout.php">Logout</a>';
    } else {
        echo '<a href="login.php">Login</a>';
        echo '<a href="registration.php">Register</a>';
    }
?>
   </nav>

   <div id="menu-btn" class="fas fa-bars"></div>

</section>
</body>

</html>