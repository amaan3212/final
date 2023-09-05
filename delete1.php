<?php
session_start();

if (isset($_SESSION['userType']) && $_SESSION['userType'] === 'admin') {
    if (isset($_POST['delete'])) {
        $profileId = $_POST['delete'];

        // Include your database connection here
        include 'dbcon.php';

        // Delete from users table
        $sql = "DELETE FROM users WHERE username = ? AND role = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $profileId, $profileId);
        $stmt->execute();
        $stmt->close();

        // Delete from owners table
        $sql = "DELETE FROM owners WHERE username = ? AND role = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $profileId, $profileId);
        $stmt->execute();
        $stmt->close();

        // Add similar delete queries for other roles if needed
    }

    header("Location: allprofiles.php"); // Redirect back to the profile listing
    echo '<script>window.history.pushState(null, null, "adminmain.html");</script>';
    exit();
} else {
    header("Location: signin.html"); // Redirect if not authenticated or authorized
    exit();
}
?>

