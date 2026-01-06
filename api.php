<?php
header('Content-Type: application/json');

$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$difficulty = isset($_GET['difficulty']) ? $_GET['difficulty'] : 'all';

$jsonData = file_get_contents('data/questions.json');
$questions = json_decode($jsonData, true);

$filteredQuestions = array_filter($questions, function($q) use ($category, $difficulty) {
    $catMatch = ($category === 'all' || strtolower($q['category']) === strtolower($category));
    $diffMatch = ($difficulty === 'all' || strtolower($q['difficulty']) === strtolower($difficulty));
    return $catMatch && $diffMatch;
});

// Re-index array
$filteredQuestions = array_values($filteredQuestions);

// Shuffle and limit (optional, but good for a quiz)
shuffle($filteredQuestions);
$filteredQuestions = array_slice($filteredQuestions, 0, 10);

echo json_encode($filteredQuestions);
?>
