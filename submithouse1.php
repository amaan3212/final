<!DOCTYPE html>
<html>
<head>
    <title>Submit Property</title>
    <a href="house1.php">Back</a>
    <link rel="stylesheet" href="submithouse1.css">
</head>
<body>
    <h1>Submit a Property</h1>

    <?php
    session_start();

    // Check if the user is an owner
    if ($_SESSION['userType'] === 'owner') {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include 'dbcon.php'; // Include your database connection code

             // Specify your upload directory
             $uploadedImages = [];

             if (!empty($_FILES['images']['name'][0])) {
                 $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'webp');
                 $imageCount = count($_FILES['images']['name']);
 
                 for ($i = 0; $i < $imageCount; $i++) {
                     $imageName = $_FILES['images']['name'][$i];
                     $tmpName = $_FILES['images']['tmp_name'][$i];
                     $fileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
                     $targetFilePath = "./uploads/" . $imageName;
 
                     if (in_array($fileType, $allowedTypes)) {
                         if (move_uploaded_file($tmpName, $targetFilePath)) {
                             $uploadedImages[] = $targetFilePath;
                         } else {
                             echo "Error moving uploaded file: $targetFilePath<br>";
                         }
                     } else {
                         echo "Invalid file type: $imageName<br>";
                     }
                 }
             }
             
            
            // Handle property submission
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
            // ... Other form fields ...

            // Insert property data into the database
            $imagePaths = implode(',', $uploadedImages);
            $sql = "INSERT INTO houses (images, username, housetype, norooms, bedrooms, bathrooms, balconies, area, location, tenanttype, available, parking, price, phno, description) 
                    VALUES ('$imagePaths', '$username','$housetype','$norooms','$bedrooms', '$bathrooms', '$balconies', '$area', '$location','$tenanttype','$available', '$parking','$price', '$phno', '$description')";

            if ($con->query($sql) === TRUE) {
                echo "<p>House submitted successfully!</p>";
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }

            $con->close();
        }
    } else {
        echo "<p>Only owners can submit Houses.</p>";
    }
    ?>

    <form action="submithouse1.php" method="post" enctype="multipart/form-data">
        
        <label for="images">Images:</label>
        <input type="file" name="images[]" value="Upload" multiple accept="images/*"><br>

        <label for="username">UserName:</label>
        <input type="text" name="username" placeholder="Your UserName" required><br>

        <label for="housetype">House Type:</label>
        <input type="text" name="housetype" placeholder="eg:villa" required><br>

        <label for="norooms">Number of Rooms:</label>
        <input type="text" name="norooms" placeholder="eg:4" required><br>

        <label for="bedrooms">Number of Bedrooms:</label>
        <input type="text" name="bedrooms" placeholder="eg:2" required><br>

        <label for="bathrooms">Number of Bathrooms:</label>
        <input type="text" name="bathrooms" placeholder="eg:2" required><br>

        <label for="balconies">Balconies:</label>
        <input type="text" name="balconies" placeholder="eg:Yes" required><br>

        <label for="area">Area:</label>
        <input type="text" name="area" placeholder="eg:1250 sq.ft" required><br>

        <label for="location">Location:</label>
        <input type="text" name="location" placeholder="Your Address" required><br>

        <label for="tenanttype">Tenant Type:</label>
        <input type="text" name="tenanttype" placeholder="eg:Family" required><br>

        <label for="available">Available:</label>
        <input type="text" name="available" placeholder="eg:Yes/No" required><br>

        <label for="parking">Parking:</label>
        <input type="text" name="parking" placeholder="eg:Yes/No" required><br>

        <label for="price">Price:</label>
        <input type="number" name="price" placeholder="eg:20000" required><br>

        <label for="phno">Owner Phone Number:</label>
        <input type="number" name="phno" placeholder="Your Phone Number" required><br>

        <label for="description">Description:</label>
        <input type="text" name="description" placeholder="about your House" required><br>

        <!-- Other form fields ... -->
        <button type="submit">Submit</button>
    </form>

    <a href="house1.php">Back to house</a>
</body>
</html>