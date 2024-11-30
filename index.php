<!-- Math Quiz Web Application using Php -->

<!-- PHP -->
<?php
session_start();

// Initialize session variables
if (!isset($_SESSION['started'])) {
    $_SESSION['started'] = false; // Track if the session has started
}
if (!isset($_SESSION['correctScore'])) {
    $_SESSION['correctScore'] = 0; // Store the score for correct answers
}
if (!isset($_SESSION['wrongScore'])) {
    $_SESSION['wrongScore'] = 0; // Store the score for wrong answers
}
if (!isset($_SESSION['answered'])) {
    $_SESSION['answered'] = false; // Track if an answer has been selected
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Quiz Web Application</title>
</head>
<body>
    
</body>
</html>