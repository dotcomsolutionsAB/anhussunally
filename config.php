<?php
// C:\anhnew\anhussunally\inc_files\config.php

// Custom error handler function
function handleErrors($errno, $errstr, $errfile, $errline) {
    // Log the error (optional)
    error_log("Error [$errno]: $errstr in $errfile on line $errline");

    // Redirect to the 404 page
    header("Location: /inc_files/404.php");
    exit();
}

// Set the custom error handler
set_error_handler("handleErrors");

// Custom exception handler (optional)
function handleExceptions($exception) {
    error_log("Exception: " . $exception->getMessage());
    header("Location: /inc_files/404.php");
    exit();
}

// Set the exception handler
set_exception_handler("handleExceptions");
?>
