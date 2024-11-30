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

// Initialize current question session variable if not set
if (!isset($_SESSION['currentQuestion'])) {
    $_SESSION['currentQuestion'] = null; // Track current question
}

// Handle Start and Close actions
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'start') {
        $_SESSION['started'] = true; // Start the quiz
        $_SESSION['correctScore'] = 0; // Reset correct score
        $_SESSION['wrongScore'] = 0; // Reset wrong score
        $_SESSION['answered'] = false; // Reset answered state
        $_SESSION['currentQuestion'] = generateQuestion($_SESSION['settings']); // Generate a new question
    } elseif ($_POST['action'] === 'close') {
        session_destroy(); // End the session
        echo "<script>alert('Quiz Closed!'); window.location.href = '';</script>"; // Alert and reload page
        exit();
    }
}

// Initialize session settings if not set
if (!isset($_SESSION['settings'])) {
    $_SESSION['settings'] = [
        'level' => '1-10', // Default difficulty level
        'operator' => 'add', // Default operator (addition)
        'numQuestions' => 10, // Default number of questions
        'numChoices' => 4, // Default number of choices per question
        'maxDifference' => 10, // Default maximum difference for questions
    ];
}

// Handle Settings Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save-settings'])) {
    // Update level if custom is selected, otherwise use the default
    $level = $_POST['level'] === 'custom' ? $_POST['custom-level'] : $_POST['level'];
    
    // Update session settings based on form input
    $_SESSION['settings'] = [
        'level' => $level, // Set the level
        'operator' => $_POST['operator'], // Set the operator
        'numQuestions' => (int)$_POST['numQuestions'], // Set the number of questions
        'numChoices' => (int)$_POST['numChoices'], // Set the number of answer choices
        'maxDifference' => (int)$_POST['maxDifference'], // Set the max difference for questions
    ];
    
    // Set a success message in session
    $_SESSION['settings_message'] = "Settings successfully updated!"; // Notify user of success
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
<div class="container">
    <h1>Mathematics Quiz</h1>

    <!-- Controls -->
    <div class="controls">
        <form method="POST">
            <button type="submit" name="action" value="start" <?= $_SESSION['started'] ? 'disabled' : '' ?>>Start</button> <!-- Start quiz button -->
            <button type="submit" name="action" value="close" <?= $quizEnded ? 'disabled' : '' ?>>Close</button> <!-- Close quiz button -->
        </form>
    </div>

    <!-- Question Section -->
    <div class="question">
        <p>
            <?php if ($_SESSION['started'] && $questionData && !$quizEnded): ?>
                <b><?= $questionData['question'] ?></b> <!-- Display current question -->
            <?php else: ?>
                <b>Press "Start" to begin the quiz!</b> <!-- Prompt to start quiz -->
            <?php endif; ?>
        </p>
    </div>

    <!-- Answer Buttons -->
    <form method="POST">
        <div class="answers">
            <?php if ($_SESSION['started'] && $questionData && !$quizEnded): ?>
                <?php foreach ($questionData['choices'] as $choice): ?>
                    <button 
                        type="submit" 
                        name="user-answer" 
                        value="<?= $choice ?>"
                        class="<?= (isset($answerFeedback) && $choice == $_POST['user-answer']) ? $answerFeedback : '' ?> 
                                <?= $_SESSION['answered'] ? 'disabled' : '' ?>">
                        <?= $choice ?> <!-- Display answer choices -->
                    </button>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php if ($_SESSION['started'] && $questionData && !$quizEnded): ?>
            <input type="hidden" name="correct-answer" value="<?= $questionData['answer'] ?>"> <!-- Store correct answer -->
        <?php endif; ?>
    </form>
</div>
</body>
</html>