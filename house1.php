<!DOCTYPE html>
<html>
<head>
    <title>Houses</title>
    <link rel="stylesheet" href="house1.css">
</head>
<body>
    <div class="profile-container">
        <?php
        session_start();
        if (isset($_SESSION['userType'])) {
            if ($_SESSION['userType'] === 'user') {
                // Code for regular user
                // Fetch and display all houses from the database
                include 'dbcon.php';
                echo "<a href='main2.html'>Back</a>";
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $sql = "SELECT * FROM houses WHERE housetype LIKE '%$search%' OR location LIKE '%$search%'";
                $result = $con->query($sql);
                 // Include your database connection code
                
                
                if ($result && $result->num_rows > 0) {
                    echo '<center>
                    <form action="house1.php" method="GET">
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
            } elseif ($_SESSION['userType'] === 'owner') {
                // Code for owner
                // Fetch and display the owner's houses from the database
                include 'dbcon.php'; // Include your database connection code
                echo "<a href='main2.html'>Back</a>";
                $ownerUsername = $_SESSION['ownerData']['username'];
                $sql = "SELECT * FROM houses WHERE username = '$ownerUsername'";
                $result = $con->query($sql);
                if ($result && $result->num_rows > 0) {
                    echo "<h1>Your Houses</h1>";
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
                        echo "<div class='actions'>";
                        echo "<a href='edithouse.php?location=" . $row['location'] . "'>Edit House</a><br>";
                        echo "<a href='deletehouse.php?location=" . $row['location'] . "' onclick='return confirm(\"Are you sure you want to delete this house?\")'>Delete House</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "<div class='house'>";
                    echo '<p>Would you like to add another house?</p>';
                    echo '<a href="submithouse1.php">Add House</a>';
                    echo "</div>";
                } else {
                    echo "<div class='house'>";
                    echo "<p>You haven't added any houses yet.</p>";
                    echo '<p>Please <a href="submithouse1.php">add a house</a>.</p>';
                    echo "</div>";
                }
            }
            
        } else {
            header("Location: main2.html");
            exit(); 
        }
        ?>
    </div>
</body>
</html>