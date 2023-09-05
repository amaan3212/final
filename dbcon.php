<?php
$con = new mysqli("dwellspot", "root", "root", "dwellspot");
if ($con->connect_error) {
    die("Failed to connect to MYSQL: " . $con->connect_errno);
}
?>