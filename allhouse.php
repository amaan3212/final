<!DOCTYPE html>
<html>
<head>
    <title>Houses</title>
    <link rel="stylesheet" href="house1.css">
</head>
<body>
    <div class="profile-container">
<?php
    include 'dbcon.php';
    echo "<a href='adminmain.html'>Back</a>";
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $sql = "SELECT * FROM houses WHERE housetype LIKE '%$search%' OR location LIKE '%$search%'";
    $result = $con->query($sql);
                 // Include your database connection code
                
                
    if ($result && $result->num_rows > 0) {
        echo '<center>
        <form action="allhouse.php" method="GET">
        <label for="search"></label>
        <input type="text" name="search" id="search">
        <button type="submit">Search</button>
        </form>
        </center>';
        echo "<h1>All Houses</h1>";
        echo "<div class='house-container'>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='house'>";
             // Display inserted images
            $images = explode(',', $row['images']);
            echo "<p>Images:</p>";
            echo "<div class='image-list'>";
            foreach ($images as $image) {
                echo "<img src='$image' alt='House Image' height=100 weidth=100>";
            }
            echo "</div>";
            echo "<p>UserName               : " . $row['username'] . "</p>";
            echo "<p>House Type             : " . $row['housetype'] . "</p>";
            echo "<p>Number of Rooms        : " . $row['norooms'] . "</p>";
            echo "<p>Number of Bedrooms     : " . $row['bedrooms'] . "</p>";
            echo "<p>Number of Bathrooms    : " . $row['bathrooms'] . "</p>";
            echo "<p>Balconies              : " . $row['balconies'] . "</p>";
            echo "<p>Area                   : " . $row['area'] . "</p>";
            echo "<p>Location               : " . $row['location'] . "</p>";
            echo "<p>Tenant Type            : " . $row['tenanttype'] . "</p>";
            echo "<p>Available              : " . $row['available'] . "</p>";
            echo "<p>Parking                : " . $row['parking'] . "</p>";
            echo "<p>Price                  : " . $row['price'] . "</p>";
            echo "<p>Owner Phone Number     : " . $row['phno'] . "</p>";
            echo "<p>Description            : " . $row['description'] . "</p>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<div class='house'>";
        echo "<p>No houses found.</p>";
        echo "</div>";
    }
    ?>
    </div>
</body>
</html>
