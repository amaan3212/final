<?php
include 'dbcon.php';
if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $role = $_POST['role'];
}
if ($role === 'user') {
    $sql = "UPDATE users SET password='$password' WHERE email='$email'";
} else {
    $sql = "UPDATE owners SET password='$password' WHERE email='$email'";
}
if($con->query($sql) === True) {
    include 'main.html';
    echo " ";
}
?>
