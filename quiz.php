<?php
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$difficulty = isset($_GET['difficulty']) ? $_GET['difficulty'] : 'all';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz in Progress</title>
    <link rel="stylesheet" href="assets/style.css">
    <script>
        const QUIZ_CONFIG = {
            category: "<?php echo htmlspecialchars($category); ?>",
            difficulty: "<?php echo htmlspecialchars($difficulty); ?>"
        };
    </script>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="timer-bar-container">
                <div id="timer-bar" class="timer-bar"></div>
            </div>

            <div id="quiz-content">
                <div class="header-info"
                    style="display: flex; justify-content: space-between; margin-bottom: 20px; color: var(--text-muted);">
                    <span id="question-counter">Question 1/10</span>
                    <span id="timer-text">15s</span>
                </div>

                <h2 id="question-text" class="question-text">Loading question...</h2>

                <div id="options-container" class="options-grid">
                    <!-- Options injected here -->
                </div>

                <button id="next-btn" class="btn" style="display: none; margin-top: 20px;">Next Question</button>
            </div>

            <form id="submission-form" action="result.php" method="POST" style="display: none;">
                <input type="hidden" name="results_json" id="results_json">
            </form>
        </div>
    </div>

    <script src="assets/script.js"></script>
</body>

</html>