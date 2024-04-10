<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>

<?php include_once 'common/header.php'; ?>

<div class="heading" style="background:url(images/header-bg-2.png) no-repeat">
   <h1>packages</h1>
</div>


<section class="packages">

   <h1 class="heading-title">top destinations</h1>

   <div class="box-container">

<?php

include_once 'db_config/db_connection.php';

$sql = "SELECT * FROM Tours";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='box'>";
        echo "<img src='images/".$row['image']."' alt=''>";
        echo "<div class='content'>";
        echo "<h3>".$row['name']."</h3>";
        echo "<p>".$row['description']."</p>";
        echo "<p>duration: ".$row['duration']."</p>";
         echo "<p>destination: ".$row['destination']."</p>";
         echo "<p>start date: ".$row['start_date']."</p>";
         echo "<p>end date: ".$row['end_date']."</p>";
         echo "<p>Sprice: ".$row['price']."</p>";
        echo "<a href='book.php?id=".$row['tour_id']."' class='btn'>book now</a>";
        echo "</div>";
        echo "</div>";
    }
}

$conn->close();

?>

   </div>
</section>



<?php include_once 'common/footer.php'; ?>
</body>
</html>