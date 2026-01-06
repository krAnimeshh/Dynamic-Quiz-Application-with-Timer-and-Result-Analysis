<?php
if (!isset($_POST['results_json'])) {
    header('Location: index.php');
    exit;
}

$results = json_decode($_POST['results_json'], true);

$totalQuestions = count($results);
$correctAnswers = 0;
$totalTime = 0;
$timePerQuestion = [];
$labels = [];

foreach ($results as $index => $res) {
    if ($res['isCorrect']) {
        $correctAnswers++;
    }
    $totalTime += $res['timeSpent'];
    $timePerQuestion[] = $res['timeSpent'];
    $labels[] = "Q" . ($index + 1);
}

$scorePercentage = ($correctAnswers / $totalQuestions) * 100;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <div class="card">
            <h1>Quiz Completed!</h1>
            <h2>Here is your performance breakdown</h2>

            <div class="summary-stats">
                <div class="stat-box">
                    <span class="stat-value">
                        <?php echo $correctAnswers; ?>/
                        <?php echo $totalQuestions; ?>
                    </span>
                    <span class="stat-label">Score</span>
                </div>
                <div class="stat-box">
                    <span class="stat-value">
                        <?php echo round($scorePercentage); ?>%
                    </span>
                    <span class="stat-label">Accuracy</span>
                </div>
                <div class="stat-box">
                    <span class="stat-value">
                        <?php echo round($totalTime, 1); ?>s
                    </span>
                    <span class="stat-label">Total Time</span>
                </div>
            </div>

            <div class="charts-container">
                <div class="chart-wrapper">
                    <canvas id="timeChart"></canvas>
                </div>
                <div class="chart-wrapper">
                    <canvas id="scoreChart"></canvas>
                </div>
            </div>

            <a href="index.php" class="btn">Play Again</a>
        </div>
    </div>

    <script>
        const timeData = <?php echo json_encode($timePerQuestion); ?>;
        const labels = <?php echo json_encode($labels); ?>;
        const correctCount = <?php echo $correctAnswers; ?>;
        const incorrectCount = <?php echo $totalQuestions - $correctAnswers; ?>;

        // Time Chart
        new Chart(document.getElementById('timeChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Time Spent (seconds)',
                    data: timeData,
                    backgroundColor: 'rgba(56, 189, 248, 0.6)',
                    borderColor: '#38bdf8',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: { labels: { color: '#f8fafc' } }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        ticks: { color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8' }
                    }
                }
            }
        });

        // Score Chart
        new Chart(document.getElementById('scoreChart'), {
            type: 'doughnut',
            data: {
                labels: ['Correct', 'Incorrect'],
                datasets: [{
                    data: [correctCount, incorrectCount],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)', // Success
                        'rgba(239, 68, 68, 0.8)'   // Danger
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                plugins: {
                    legend: { labels: { color: '#f8fafc' } }
                }
            }
        });
    </script>
</body>

</html>