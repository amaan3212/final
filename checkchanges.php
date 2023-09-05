<?php
session_start();
include 'dbcon.php';

if (isset($_SESSION['lastCheckedTime'])) {
    // Query the database to check for changes since the last check
    $lastCheckedTime = $_SESSION['lastCheckedTime'];
    $sql = "SELECT COUNT(*) AS changes FROM your_table WHERE last_modified > '$lastCheckedTime'";
    $result = $con->query($sql);
    
    if ($result && $row = $result->fetch_assoc()) {
        $changes = $row['changes'];
        $_SESSION['lastCheckedTime'] = date('Y-m-d H:i:s'); // Update the last checked time
        echo json_encode(['changes' => $changes]);
        exit();
    }
}

echo json_encode(['changes' => 0]); // No changes detected
?>
