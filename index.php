<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frugal Quiz - Challenge Yourself</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" href="data:;base64,=">
</head>

<body>
    <div class="container">
        <div class="card">
            <h1>Frugal Quiz</h1>
            <h2>Test your knowledge across multiple domains.</h2>

            <form action="quiz.php" method="GET">
                <div class="form-group">
                    <label for="category">Select Category</label>
                    <select name="category" id="category">
                        <option value="all">Any Category</option>
                        <option value="Science">Science</option>
                        <option value="History">History</option>
                        <option value="Tech">Technology</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="difficulty">Select Difficulty</label>
                    <select name="difficulty" id="difficulty">
                        <option value="all">Any Difficulty</option>
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>

                <button type="submit" class="btn">Start Quiz</button>
            </form>
        </div>
    </div>
</body>

</html>