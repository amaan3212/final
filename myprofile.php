<!DOCTYPE html>
<html>
<head>
<form action="main2.html" method="post">
    <button type="submit">Back</button>
    </form>
    <title>My Profile</title>
    <link rel="stylesheet" href="myprofile.css">
</head>
<body>
    <div class="profile-container">
    <?php
    session_start();
    include 'dbcon.php';
    if (isset($_SESSION['userType'])) {
        if ($_SESSION['userType'] === 'user') {
            $userData = $_SESSION['userData'];
            
            echo "<h1>Welcome! <br>". $userData['username']."</h1>";
            echo "<p>Username: " . $userData['username'] . "</p>";
            echo "<p>Email: " . $userData['email'] . "</p>";
            echo "<p>Phone Number: " . $userData['phno'] . "</p>";
            echo "<p>Role: " . $userData['role'] . "</p>";
             
            echo '<form action="editprofile.php" method="post">';
            echo '<button type="submit">Edit Profile</button>';
            echo '</form><br>';
            
            echo '<form action="logout.php" method="post">';
            echo '<button type="submit">Logout</button>';
            echo '</form>';

        } elseif ($_SESSION['userType'] === 'owner') {
            $ownerData = $_SESSION['ownerData'];
            echo "<h1>Welcome! <br>". $ownerData['username']."</h1>";
            echo "<p>Username: " . $ownerData['username'] . "</p>";
            echo "<p>Email: " . $ownerData['email'] . "</p>";
            echo "<p>Phone Number: " . $ownerData['phno'] . "</p>";
            echo "<p>Role: " . $ownerData['role'] . "</p>";
            
            echo '<form action="editprofile.php" method="post">';
            echo '<button type="submit">Edit Profile</button>';
            echo '</form><br>';
            
            echo '<form action="logout.php" method="post">';
            echo '<button type="submit">Logout</button>';
            echo '</form>';
            
        }
    } else {
        
        header("Location: main2.html");
        exit(); 
    }
    ?>
    </div>
    <script>
function checkForChanges() {
    $.ajax({
        url: 'check_changes.php',
        dataType: 'json',
        success: function(response) {
            if (response.changes > 0) {
                // Display a notification or update the UI as needed
                alert('Changes detected in the database.');
            }
            // Repeat the check after a certain interval
            setTimeout(checkForChanges, 5000); // Check every 5 seconds (adjust as needed)
        },
        error: function() {
            console.error('Error checking for changes.');
            // Repeat the check after a certain interval even if there was an error
            setTimeout(checkForChanges, 5000); // Check every 5 seconds (adjust as needed)
        }
    });
}

// Start checking for changes when the page loads
$(document).ready(function() {
    checkForChanges();
});
</script>
</body>
</html>
