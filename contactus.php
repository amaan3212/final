<?php
    include 'dbcon.php';
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $message=$_POST['message'];
    $sql = "INSERT INTO contactus (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";
    $con->query($sql);
    include 'main.html'; 
    echo '<script>document.body.style.backgroundImage = "url("img.jpeg")";
    alert("Your Message has Sent Successfully!")</script>';
?>
