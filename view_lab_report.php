<?php
// view_lab_report.php

if (isset($_GET['filename'])) {
    $filename = $_GET['filename'];
    $filePath = __DIR__ . "/assets/uploads/" . $filename;

    if (file_exists($filePath)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        readfile($filePath);
    } else {
        echo 'File not found.';
    }
} else {
    echo 'Invalid request.';
}