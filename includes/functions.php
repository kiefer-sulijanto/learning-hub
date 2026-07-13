<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('DATA_DIR', __DIR__ . '/../data/');
define('MATH_FILE', DATA_DIR . 'math_questions.txt');
define('SEAWORLD_FILE', DATA_DIR . 'seaworld_questions.txt');
define('LEADERBOARD_FILE', DATA_DIR . 'leaderboard.txt');

/**
 * Load the math question pool.
 * Each line: equation|answer
 * @return array<int, array{equation:string, answer:int}>
 */
function load_math_questions(): array {
    $questions = [];
    if (!file_exists(MATH_FILE)) {
        return $questions;
    }
    $lines = file(MATH_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = explode('|', trim($line));
        if (count($parts) !== 2) {
            continue;
        }
        $questions[] = [
            'equation' => $parts[0],
            'answer' => (int)$parts[1],
        ];
    }
    return $questions;
}

/**
 * Load the sea world question pool.
 * Each line: image|displayed_name|correct_or_incorrect
 * @return array<int, array{image:string, name:string, correct:string}>
 */
function load_seaworld_questions(): array {
    $questions = [];
    if (!file_exists(SEAWORLD_FILE)) {
        return $questions;
    }
    $lines = file(SEAWORLD_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = explode('|', trim($line));
        if (count($parts) !== 3) {
            continue;
        }
        $questions[] = [
            'image' => $parts[0],
            'name' => $parts[1],
            'correct' => strtolower(trim($parts[2])) === 'correct' ? 'correct' : 'incorrect',
        ];
    }
    return $questions;
}

/**
 * Pick n random, non-repeating questions from a pool.
 */
function get_random_questions(array $pool, int $n = 3): array {
    if (count($pool) <= $n) {
        $selected = $pool;
        shuffle($selected);
        return $selected;
    }
    $keys = array_rand($pool, $n);
    if (!is_array($keys)) {
        $keys = [$keys];
    }
    $selected = [];
    foreach ($keys as $key) {
        $selected[] = $pool[$key];
    }
    shuffle($selected);
    return $selected;
}

/**
 * Quiz scoring: correct answers worth 3, incorrect cost 2.
 */
function calculate_points(int $correct, int $incorrect): int {
    return ($correct * 3) - ($incorrect * 2);
}

/**
 * Load the leaderboard file into ['nickname' => totalpoints, ...]
 */
function load_leaderboard(): array {
    $data = [];
    if (!file_exists(LEADERBOARD_FILE)) {
        return $data;
    }
    $lines = file(LEADERBOARD_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = explode('|', trim($line));
        if (count($parts) !== 2) {
            continue;
        }
        $data[$parts[0]] = (int)$parts[1];
    }
    return $data;
}

/**
 * Overwrite leaderboard.txt from an associative array.
 */
function save_leaderboard(array $data): void {
    $lines = [];
    foreach ($data as $nickname => $points) {
        $lines[] = $nickname . '|' . $points;
    }
    file_put_contents(LEADERBOARD_FILE, implode(PHP_EOL, $lines) . PHP_EOL, LOCK_EX);
}

/**
 * Add points to an existing leaderboard entry, or create a new one.
 */
function update_leaderboard(string $nickname, int $pointsToAdd): void {
    $data = load_leaderboard();
    if (isset($data[$nickname])) {
        $data[$nickname] += $pointsToAdd;
    } else {
        $data[$nickname] = $pointsToAdd;
    }
    save_leaderboard($data);
}

/**
 * Sort the leaderboard: 'name' = A-Z, 'score' = highest first.
 */
function sort_leaderboard(array $data, string $by): array {
    if ($by === 'name') {
        uksort($data, 'strcasecmp');
    } else {
        arsort($data, SORT_NUMERIC);
    }
    return $data;
}

/**
 * Trim / strip tags from a raw nickname input. The pipe character is removed
 * because it is the delimiter used in the pipe-delimited data files (a
 * nickname containing "|" would corrupt its own leaderboard.txt record).
 */
function sanitize_nickname(string $nickname): string {
    $nickname = str_replace(['|', "\r", "\n"], '', $nickname);
    $nickname = trim(strip_tags($nickname));
    return mb_substr($nickname, 0, 30);
}

function h(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function require_nickname(string $redirectTo = 'index.php'): void {
    if (empty($_SESSION['nickname'])) {
        header('Location: ' . $redirectTo);
        exit;
    }
}
