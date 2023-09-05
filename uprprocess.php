<?php
include 'dbcon.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['userType']) && $_SESSION['userType'] === 'owner') {
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPhno = $_POST['phno'];
    
    $ownerData = $_SESSION['ownerData'];
    $oldUsername = $ownerData['username'];

    // Update owner's profile information in the database
    $sql = "UPDATE owners SET username='$newUsername', email='$newEmail', phno='$newPhno' WHERE username='$oldUsername'";

    if ($con->query($sql) === true) {
        // Update session data with new information
        $_SESSION['ownerData']['username'] = $newUsername;
        $_SESSION['ownerData']['email'] = $newEmail;
        $_SESSION['ownerData']['phno'] = $newPhno;

        // Redirect back to the main page after update
        header("Location: profile1.php");
        exit();
    } else {
        echo "Error updating profile: " . $con->error;
    }
} else {
    // Redirect to signin page if not authorized or incorrect request method
    header("Location: signin.html");
    exit(); 
}
?>
