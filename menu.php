<?php
require __DIR__ . '/includes/functions.php';
require_nickname();

$pageTitle = 'Choose a Quiz';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="card">
    <h1>Hey, <?= h($_SESSION['nickname']) ?></h1>
    <p class="subtitle">Pick a quiz topic below. You can play as many quizzes as you like!</p>

    <div class="btn-grid">
        <a href="quiz.php?topic=math" class="btn btn-blue">Math Quiz</a>
        <a href="quiz.php?topic=seaworld" class="btn btn-green">Sea World Quiz</a>
        <a href="leaderboard.php" class="btn btn-yellow">Leaderboard</a>
        <a href="exit.php" class="btn btn-red">Exit</a>
    </div>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
