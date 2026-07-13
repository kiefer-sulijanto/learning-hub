<?php
require __DIR__ . '/includes/functions.php';
require_nickname();

$topic = $_GET['topic'] ?? '';
if (!in_array($topic, ['math', 'seaworld'], true)) {
    header('Location: menu.php');
    exit;
}

if ($topic === 'math') {
    $pool = load_math_questions();
} else {
    $pool = load_seaworld_questions();
}

$questions = get_random_questions($pool, 3);

$_SESSION['current_quiz'] = [
    'topic' => $topic,
    'questions' => $questions,
];

$pageTitle = $topic === 'math' ? 'Math Quiz' : 'Sea World Quiz';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="card">
    <h1><?= $topic === 'math' ? 'Math Quiz' : 'Sea World Quiz' ?></h1>
    <p class="subtitle">
        <?= $topic === 'math'
            ? 'Type the correct answer for each equation.'
            : 'Is the name below the animal correct or not correct?' ?>
    </p>

    <form method="post" action="process_quiz.php">
        <input type="hidden" name="topic" value="<?= h($topic) ?>">

        <?php foreach ($questions as $index => $q): ?>
            <div class="question-card">
                <span class="question-number">Question <?= $index + 1 ?></span>

                <?php if ($topic === 'math'): ?>
                    <?php
                    $displayEquation = preg_replace('/([0-9])([+\-])([0-9])/', '$1 $2 $3', $q['equation']);
                    ?>
                    <div class="equation-row">
                        <span class="equation"><?= h($displayEquation) ?> =</span>
                        <input type="text" name="answers[<?= $index ?>]" inputmode="numeric" placeholder="?" autocomplete="off">
                    </div>
                <?php else: ?>
                    <img class="animal-img" src="images/<?= h($q['image']) ?>" alt="Sea creature">
                    <p class="animal-name"><?= h($q['name']) ?></p>
                    <div class="tf-choice">
                        <label><input type="radio" name="answers[<?= $index ?>]" value="correct"> Correct</label>
                        <label><input type="radio" name="answers[<?= $index ?>]" value="incorrect"> Not Correct</label>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-purple btn-block">Submit Answers</button>
    </form>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
