<!DOCTYPE html>
<html>
<head>
    <title>Houses</title>
    <link rel="stylesheet" href="edithouse.css">
</head>
<body>
<?php
session_start();
if ($_SESSION['userType'] === 'owner') {
    include 'dbcon.php'; // Include your database connection code

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission to update house details
        $username = $_POST['username'];
        $housetype = $_POST['housetype'];
        $norooms = $_POST['norooms'];
        $bedrooms = $_POST['bedrooms'];
        $bathrooms = $_POST['bathrooms'];
        $balconies = $_POST['balconies'];
        $area = $_POST['area'];
        $location = $_POST['location'];
        $tenanttype = $_POST['tenanttype'];
        $available = $_POST['available'];
        $parking = $_POST['parking'];
        $price = $_POST['price'];
        $phno = $_POST['phno'];
        $description = $_POST['description'];

        // Update house details in the database
        $sql = "UPDATE houses SET username='$username', housetype='$housetype', norooms='$norooms', bedrooms='$bedrooms', bathrooms='$bathrooms', balconies='$balconies', area='$area', tenanttype='$tenanttype', available='$available', parking='$parking', price='$price', phno='$phno', description='$description' WHERE area=location='$location'";
        
        if ($con->query($sql) === TRUE) {
            header("Location: house1.php");
            exit();
        } else {
            echo "Error updating house: " . $con->error;
        }
    } else {
        // Display the edit form
        $location = $_GET['location'];
        $sql = "SELECT * FROM houses WHERE location = '$location'";
        $result = $con->query($sql);

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Display the edit form
            echo '<form action="edithouse.php" method="post">';
            echo '<input type="hidden" name="location" value="' . $location . '">';
            echo '<label for="username">Username:</label>';
            echo '<input type="text" name="username" value="' . $row['username'] . '" required><br>';
            echo '<label for="housetype">House Type:</label>';
            echo '<input type="text" name="housetype" value="' . $row['housetype'] . '" required><br>';
            echo '<label for="norooms">Number of Rooms:</label>';
            echo '<input type="number" name="norooms" value="' . $row['norooms'] . '" required><br>';
            // ... (other form fields)            // ... (other form fields)
            echo '<label for="bedrooms">Number of Bedrooms:</label>';
            echo '<input type="number" name="bedrooms" value="' . $row['bedrooms'] . '" required><br>';
            echo '<label for="bathrooms">Number of Bathrooms:</label>';
            echo '<input type="number" name="bathrooms" value="' . $row['bathrooms'] . '" required><br>';
            echo '<label for="balconies">Balconies:</label>';
            echo '<input type="text" name="balconies" value="' . $row['balconies'] . '" required><br>';
            echo '<label for="area">Area:</label>';
            echo '<input type="text" name="area" value="' . $row['area'] . '" required><br>';
            echo '<label for="tenanttype">Tenant Type:</label>';
            echo '<input type="text" name="tenanttype" value="' . $row['tenanttype'] . '" required><br>';
            echo '<label for="available">Available:</label>';
            echo '<input type="text" name="available" value="' . $row['available'] . '" required><br>';
            echo '<label for="parking">Parking:</label>';
            echo '<input type="text" name="parking" value="' . $row['parking'] . '" required><br>';
            echo '<label for="price">Price:</label>';
            echo '<input type="number" name="price" value="' . $row['price'] . '" required><br>';
            echo '<label for="phno">Owner Phone Number:</label>';
            echo '<input type="text" name="phno" value="' . $row['phno'] . '" required><br>';
            echo '<label for="description">Description:</label>';
            echo '<textarea name="description" required>' . $row['description'] . '</textarea><br>';
            echo '<button type="submit">Save Changes</button>';
            echo '</form>';
        } else {
            echo "House not found.";
        }
    }
} else {
    header("Location: main2.html");
    exit();
}
?>
</body>
</html>