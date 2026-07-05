<?php
$pageTitle = $pageTitle ?? 'Learning Hub';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= h($pageTitle) ?> - Learning Hub</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Nunito:wght@500;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="page">
    <header class="site-header">
        <a href="menu.php" class="logo">Learning Hub</a>
        <?php if (!empty($_SESSION['nickname'])): ?>
        <div class="header-status">
            <span class="pill"><?= h($_SESSION['nickname']) ?></span>
            <span class="pill pill-score"><?= (int)($_SESSION['overall_points'] ?? 0) ?> pts</span>
        </div>
        <?php endif; ?>
    </header>
    <main class="container">
