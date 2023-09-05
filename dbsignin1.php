<?php
include 'dbcon.php';
session_start();
$username = $_POST['username'];
$password = $_POST["password"];
$role = $_POST['role'];

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'";
$result = $con->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc(); 
        $_SESSION['userData'] = $userData; 
        $_SESSION['userType'] = 'user'; 
        include 'main2.html';
        echo '<script>alert("Successfully Signed in as User!")</script>';
    } else {
        $sql = "SELECT * FROM owners WHERE username='$username' AND password='$password' AND role='$role'";
        $result = $con->query($sql);

        if ($result && $result->num_rows > 0) {
            $ownerData = $result->fetch_assoc(); 
            $_SESSION['ownerData'] = $ownerData; 
            $_SESSION['userType'] = 'owner';
            include 'main2.html';
            echo '<script>alert("Successfully Signed in as Owner!")</script>';
        } else {
            $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password' AND role='$role'";
            $result = $con->query($sql);

            if ($result && $result->num_rows > 0) {
                $adminData = $result->fetch_assoc(); 
                $_SESSION['adminData'] = $adminData; 
                $_SESSION['userType'] = 'admin';
                include 'adminmain.html';  // You might need to create an admin page
                echo '<script>alert("Successfully Signed in as Admin!")</script>';
            } else {
                include 'signin.html';
                echo '<script>alert("Invalid Password!")</script>';
            }
        }
    }
} else {
    //include 'signin1.html';
    echo '<script>alert("Invalid Password!")</script>';
}
// You can remove the immediate redirection here
?>
