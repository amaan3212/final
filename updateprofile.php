<?php
include 'dbcon.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['userType']) && $_SESSION['userType'] === 'owner') {
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPhno = $_POST['phno'];
    
    $ownerData = $_SESSION['ownerData'];

    // Update session data with new information
    $_SESSION['ownerData']['username'] = $newUsername;
    $_SESSION['ownerData']['email'] = $newEmail;
    $_SESSION['ownerData']['phno'] = $newPhno;

    // Update owner's profile information in the database (optional)
    $sql = "UPDATE owners SET email='$newEmail', phno='$newPhno' WHERE username='$newUsername'";

    if ($con->query($sql) === true) {
        header("Location: myprofile.php");
        exit();
        include 'main2.html';
    } else {
        echo "Error updating profile: " . $con->error;
    }
} else {
    // Redirect to signin page if not authorized or incorrect request method
    header("Location: myprofile.php");
    exit(); 
}
?>
