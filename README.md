# Learning Hub

A colorful quiz web app for kids, built with plain PHP. Players enter a nickname, pick a topic, answer a quick 3-question quiz, and rack up points on a shared leaderboard.

## Features

- **Math Quiz** — equations covering addition, subtraction, multiplication, and division; every quiz always includes at least one addition and one subtraction question
- **Sea World Quiz** — a sea-animal image is shown with a name below it, and the player says whether the name is correct
- 3 random, non-repeating questions per quiz, drawn from a larger question pool per topic
- Scoring: `(correct × 3) − (incorrect × 2)` points per quiz
- Running total for the current game, plus a cumulative all-time leaderboard across every game played
- Leaderboard sortable by nickname (A–Z) or by score (highest first)
- No database — questions and scores are stored in simple pipe-delimited text files

## Running it locally

**With MAMP / XAMPP:**
1. Copy (or symlink) this folder into your MAMP/XAMPP `htdocs` directory
2. Start Apache from the MAMP/XAMPP app
3. Open `http://localhost:8080/<folder-name>/index.php` in your browser (port depends on your MAMP config)

**With PHP's built-in server:**
```bash
php -S localhost:8000
```
Then open `http://localhost:8000/index.php`.

## Project structure

```
index.php                 Nickname entry screen
menu.php                  Topic menu (Math / Sea World / Leaderboard / Exit)
quiz.php                  Renders a random 3-question quiz for the chosen topic
process_quiz.php          Grades submitted answers, updates the running score
result.php                Shows the quiz result and current-game overall points
leaderboard.php           All-time leaderboard, sortable by name or score
exit.php                  End-of-game summary; saves points to the leaderboard
new_game.php               Clears the session so a new game can start
includes/                 Shared helper functions and page layout
css/style.css              Styling
data/                     Question pools and leaderboard data (text files)
images/                   Original SVG sea-animal icons
```
