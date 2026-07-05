<?php
require __DIR__ . '/includes/functions.php';
require_nickname();

$sort = $_GET['sort'] ?? 'score';
if (!in_array($sort, ['name', 'score'], true)) {
    $sort = 'score';
}

$data = load_leaderboard();
$sorted = sort_leaderboard($data, $sort);

$pageTitle = 'Leaderboard';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="card">
    <h1>Leaderboard</h1>
    <p class="subtitle">Total points earned across all games ever played.</p>

    <div class="sort-links">
        <a href="leaderboard.php?sort=name" class="btn btn-blue <?= $sort === 'name' ? 'active' : '' ?>">Sort by Name (A-Z)</a>
        <a href="leaderboard.php?sort=score" class="btn btn-orange <?= $sort === 'score' ? 'active' : '' ?>">Sort by Score (High-Low)</a>
    </div>

    <?php if (empty($sorted)): ?>
        <p class="empty-note">No scores yet &mdash; be the first to finish a game!</p>
    <?php else: ?>
        <table class="leaderboard">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nickname</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                <?php $rank = 1; ?>
                <?php foreach ($sorted as $nickname => $points): ?>
                    <tr class="<?= ($sort === 'score' && $rank === 1) ? 'rank-1' : '' ?>">
                        <td><span class="rank-badge"><?= $rank ?></span></td>
                        <td><?= h((string)$nickname) ?></td>
                        <td><?= (int)$points ?></td>
                    </tr>
                    <?php $rank++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="btn-grid" style="margin-top:24px;">
        <a href="menu.php" class="btn btn-purple">Return</a>
    </div>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
