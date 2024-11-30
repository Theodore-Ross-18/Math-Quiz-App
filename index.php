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