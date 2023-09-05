<?php
session_start();

if ($_SESSION['userType'] === 'owner') {
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['location'])) {
        include 'dbcon.php'; // Include your database connection code

        $location = $_GET['location'];
        
        // Delete the house from the database using prepared statement
        $sql = "DELETE FROM houses WHERE location = ?";
        
        // Prepare the statement
        $stmt = $con->prepare($sql);
        
        if ($stmt) {
            // Bind the parameter
            $stmt->bind_param("s", $location);
            
            // Execute the statement
            if ($stmt->execute()) {
                $stmt->close();
                $con->close();
                header("Location: house1.php");
                exit();
            } else {
                echo "Error deleting house: " . $stmt->error;
            }
        } else {
            echo "Error in prepared statement: " . $con->error;
        }
    }
} else {
    header("Location: main2.html");
    exit();
}
?>
