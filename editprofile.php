<!DOCTYPE html>
<html>
<head>
<a href="myprofile.php">Back</a>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="editprofile.css">
</head>
<body>
    <div class="profile-container">
    <?php
    session_start();
    
    if (isset($_SESSION['userType'])) {
        if ($_SESSION['userType'] === 'user') {
            $userData = $_SESSION['userData'];
            
            echo "<center><h1>Edit Profile <br>" . $userData['username'] . "</h1></center>";
            ?>
            <form action="updateprofile.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $userData['username']; ?>" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $userData['email']; ?>" required><br>

                <label for="phno">Phone Number:</label>
                <input type="tel" id="phno" name="phno" value="<?php echo $userData['phno']; ?>" required><br>

                <input type="submit" value="Update Profile">
            </form>
            <?php
            // Display a form here to allow users to edit their profile information
        } elseif ($_SESSION['userType'] === 'owner') {
            $ownerData = $_SESSION['ownerData'];
            
            echo "<center><h1>Edit Profile <br>" . $ownerData['username'] . "</h1></center>";
            ?>
            <form action="updateprofile.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $ownerData['username']; ?>" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $ownerData['email']; ?>" required><br>

                <label for="phno">Phone Number:</label>
                <input type="tel" id="phno" name="phno" value="<?php echo $ownerData['phno']; ?>" required><br>

                <input type="submit" value="Update Profile">
            </form>
            <?php
        }
    } else {
        header("Location: signin.html");
        exit(); 
    }
    ?>
    </div>
</body>
<script>
    window.onpopstate = function() {
        window.location.href = "profile1.php";
    };
</script>
</html>
