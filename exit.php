<?php
require __DIR__ . '/includes/functions.php';
require_nickname();

$nickname = $_SESSION['nickname'];
$gamePoints = (int)($_SESSION['overall_points'] ?? 0);

if (empty($_SESSION['recorded'])) {
    update_leaderboard($nickname, $gamePoints);
    $_SESSION['recorded'] = true;
}

$pageTitle = 'Game Over';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="card">
    <h1>Thanks for playing, <?= h($nickname) ?></h1>
    <p class="subtitle">Your score has been saved to the leaderboard.</p>

    <div class="stats-grid" style="grid-template-columns: 1fr;">
        <div class="stat-box stat-points">
            <span class="stat-value"><?= $gamePoints ?></span>
            <span class="stat-label">Points This Game</span>
        </div>
    </div>

    <div class="btn-grid">
        <a href="leaderboard.php" class="btn btn-yellow">Leaderboard</a>
        <a href="new_game.php" class="btn btn-purple">Start New Game</a>
    </div>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
