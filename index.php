<?php
require __DIR__ . '/includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = sanitize_nickname($_POST['nickname'] ?? '');
    if ($nickname === '') {
        $error = 'Please type a nickname before starting!';
    } else {
        session_unset();
        $_SESSION['nickname'] = $nickname;
        $_SESSION['overall_points'] = 0;
        header('Location: menu.php');
        exit;
    }
}

$pageTitle = 'Welcome';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="card">
    <h1>Welcome to Learning Hub</h1>
    <p class="subtitle">Type your nickname to start playing Math &amp; Sea World quizzes.</p>

    <?php if ($error !== ''): ?>
        <div class="error-msg"><?= h($error) ?></div>
    <?php endif; ?>

    <form method="post" action="index.php">
        <div class="form-group">
            <label for="nickname">Your Nickname</label>
            <input type="text" id="nickname" name="nickname" maxlength="30" placeholder="e.g. Adam" autocomplete="off" required>
        </div>
        <button type="submit" class="btn btn-purple btn-block">Start Game</button>
    </form>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
