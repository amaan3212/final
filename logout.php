<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the signin page
header("Location: signin.html");
exit();
?>
