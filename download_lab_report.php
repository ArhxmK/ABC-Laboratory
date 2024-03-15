<?php
// Ensure that the filename is provided as a GET parameter
if (isset($_GET['filename'])) {
    $filename = $_GET['filename'];

    // Set the path to the uploads folder
    $filepath = 'assets/uploads/' . $filename;

    // Check if the file exists
    if (file_exists($filepath)) {
        // Set headers for file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: private, must-revalidate, max-age=0');
        header('Pragma: public');
        header('Expires: 0');
        
        // Output the file content
        readfile($filepath);
        exit;
    } else {
        echo 'File not found.';
    }
} else {
    echo 'Invalid request.';
}
?>
