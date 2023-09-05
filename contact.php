<!DOCTYPE html>
<html>
<head>
    <title>Contacts</title>
    <link rel="stylesheet" href="allprofiles.css">
</head>
<body>
    <a href="adminmain.html">Back</a>

    <center>
        <form action="" method="post">
            <p align="center">
                <input type="text" name="search" placeholder="Search by username">
                <button type="submit">Search</button>
            </p>
        </form>
    </center>

    <?php
    session_start();

    if (isset($_SESSION['userType'])) {
        include 'dbcon.php';

        // Delete Profile Logic
        if (isset($_POST['delete'])) {
            $profileName = $_POST['delete']; // Change to the appropriate field name (e.g., 'name')
            $deleteSql = "DELETE FROM contactus WHERE name = '$profileName'"; // Change the table name and field accordingly
            $deleteResult = $con->query($deleteSql);

            if ($deleteResult) {
                echo "<p>Profile for '$profileName' has been deleted.</p>";
            } else {
                echo "<p>Error deleting profile for '$profileName'.</p>";
            }
        }

        // Fetch profiles based on search query
        if (isset($_POST['search'])) {
            $searchUsername = $_POST['search'];
            $sql = "SELECT * FROM contactus WHERE name LIKE '%$searchUsername%'";
        } else {
            $sql = "SELECT * FROM contactus";
        }

        $result = $con->query($sql);

        if ($result && $result->num_rows > 0) {
            $profiles = array(); // Array to hold all profiles
            while ($row = $result->fetch_assoc()) {
                $profiles[] = $row;
            }

            echo '<div class="profile-container">';

            foreach ($profiles as $profile) {
                echo "<div class='profile'>";
                echo "<h1>".$profile['name'] . "'s Message</h1>";
                echo "<p>Username: " . $profile['name'] . "</p>";
                echo "<p>Email: " . $profile['email'] . "</p>";
                echo "<p>Phone Number: " . $profile['phone'] . "</p>";
                echo "<p>Message: " . $profile['message'] . "</p>";
                echo '<form action="delete1.php" method="post">'; // Use the same page as the form action
                echo "<button type='submit' name='delete' value='".$profile['name']."'>Delete</button>";
                echo "</form>";
                echo "</div>";
            }

            echo '</div>';
        } else {
            echo '<p>No profiles found.</p>';
        }
    } 
    ?>

</body>
</html>
