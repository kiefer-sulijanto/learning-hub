<?php
require __DIR__ . '/includes/functions.php';
require_nickname();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['current_quiz'])) {
    header('Location: menu.php');
    exit;
}

$quiz = $_SESSION['current_quiz'];
$topic = $quiz['topic'];
$questions = $quiz['questions'];
$submittedAnswers = $_POST['answers'] ?? [];

$correctCount = 0;
$incorrectCount = 0;

foreach ($questions as $index => $q) {
    $userAnswer = trim((string)($submittedAnswers[$index] ?? ''));

    if ($topic === 'math') {
        $isCorrect = $userAnswer !== '' && is_numeric($userAnswer) && (int)$userAnswer === (int)$q['answer'];
    } else {
        $isCorrect = $userAnswer === $q['correct'];
    }

    if ($isCorrect) {
        $correctCount++;
    } else {
        $incorrectCount++;
    }
}

$quizPoints = calculate_points($correctCount, $incorrectCount);
$_SESSION['overall_points'] = (int)($_SESSION['overall_points'] ?? 0) + $quizPoints;

$_SESSION['last_quiz'] = [
    'topic' => $topic,
    'correct' => $correctCount,
    'incorrect' => $incorrectCount,
    'points' => $quizPoints,
];

unset($_SESSION['current_quiz']);

header('Location: result.php');
exit;
