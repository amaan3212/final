<!DOCTYPE html>
<html>
<head>
    <title>All Profiles</title>
    <link rel="stylesheet" href="allprofiles.css">
</head>
<body>
    <a href="adminmain.html">Back</a>
    <form action="" method="post">
    <input type="text" name="search" placeholder="Search by username">
    <button type="submit">Search</button>
</form>

<?php
session_start();

if (isset($_SESSION['userType'])) {
    include 'dbcon.php';

        // Delete Profile Logic
        if (isset($_POST['delete'])) {
            $profileUsername = $_POST['delete'];
            $sql = "DELETE FROM users WHERE username = '$profileUsername'";
            $result = $con->query($sql);
            // Add similar delete queries for other roles if needed
        }

        $profiles = array(); // Array to hold all profiles

        // Fetch profiles based on search query
        if (isset($_POST['search'])) {
            $searchUsername = $_POST['search'];
            $sql = "SELECT * FROM users WHERE username LIKE '%$searchUsername%'";
        } else {
            $sql = "SELECT * FROM users";
        }
    
        $result = $con->query($sql);
    
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $profiles[] = $row;
            }
        }
    
        $sql = "SELECT * FROM owners";
        $result = $con->query($sql);
    
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $profiles[] = $row;
            }
        }
    
        // Display filtered profiles or message
        if (count($profiles) > 0) {
            echo '<div class="profile-container">';
            foreach ($profiles as $profile) {
            echo "<div class='profile'>";
            echo "<h1>".$profile['username'] . "'s Profile</h1>";
            echo "<p>Username: " . $profile['username'] . "</p>";
            echo "<p>Role: " . $profile['role'] . "</p>";
            echo "<p>Phone Number: " . $profile['phno'] . "</p>";
            echo "<p>Email: " . $profile['email'] . "</p>";
            echo '<form action="delete1.php" method="post">';
            echo "<button type='submit' name='delete' value='".$profile['username']."'>Delete</button>";
            echo "</form>";
            echo "</div>";
        }
        echo '</div>';
    } else {
        echo '<p>No profiles found matching your search criteria.</p>';
    }
        echo '<center>';
        echo '<form action="logout.php" method="post">';
        echo '<button type="submit">Logout</button>';
        echo '</form></center>';
    } else {
        header("Location: signin.html");
        exit();
    }
    ?>

</body>
<script>
window.onpopstate = function() {
    window.location.href = "adminmain.html";
};

</script>
</html>
