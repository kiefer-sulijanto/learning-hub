<?php
require __DIR__ . '/includes/functions.php';
require_nickname();

if (empty($_SESSION['last_quiz'])) {
    header('Location: menu.php');
    exit;
}

$last = $_SESSION['last_quiz'];
$topicLabel = $last['topic'] === 'math' ? 'Math Quiz' : 'Sea World Quiz';

$pageTitle = 'Quiz Result';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="card">
    <h1><?= h($topicLabel) ?> Complete!</h1>
    <p class="subtitle">Nice work, <?= h($_SESSION['nickname']) ?>! Here's how you did:</p>

    <div class="stats-grid">
        <div class="stat-box stat-correct">
            <span class="stat-value"><?= (int)$last['correct'] ?></span>
            <span class="stat-label">Correct</span>
        </div>
        <div class="stat-box stat-incorrect">
            <span class="stat-value"><?= (int)$last['incorrect'] ?></span>
            <span class="stat-label">Incorrect</span>
        </div>
        <div class="stat-box stat-points">
            <span class="stat-value"><?= (int)$last['points'] ?></span>
            <span class="stat-label">Points This Quiz</span>
        </div>
        <div class="stat-box stat-overall">
            <span class="stat-value"><?= (int)($_SESSION['overall_points'] ?? 0) ?></span>
            <span class="stat-label">Overall Points</span>
        </div>
    </div>

    <div class="btn-grid">
        <a href="quiz.php?topic=math" class="btn btn-blue">Math Quiz</a>
        <a href="quiz.php?topic=seaworld" class="btn btn-green">Sea World Quiz</a>
        <a href="leaderboard.php" class="btn btn-yellow">Leaderboard</a>
        <a href="exit.php" class="btn btn-red">Exit</a>
    </div>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
