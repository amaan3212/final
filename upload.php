<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define the target directory where uploaded images will be stored
    $targetDir = "/uploads/";
    
    // Create the target directory if it doesn't exist
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    // Loop through the uploaded files
    foreach ($_FILES["images"]["tmp_name"] as $key => $tmpName) {
        $fileName = basename($_FILES["images"]["name"][$key]);
        $targetFilePath = $targetDir . $fileName;

        // Move the uploaded file to the target location
        if (move_uploaded_file($tmpName, $targetFilePath)) {
            echo "File $fileName has been uploaded successfully.<br>";
        } else {
            echo "Error uploading $fileName.<br>";
        }
    }
} else {
    echo "Form not submitted.";
}
?>
