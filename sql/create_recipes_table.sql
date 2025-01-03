CREATE TABLE recipes (
    recipe_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    recipe TEXT NOT NULL,
    author VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

<!-- filepath: /c:/wamp64/www/partage_de_recettes/src/add_recipe_form.php -->
<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/functions.php');

if (!isset($_SESSION['LOGGED_USER'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $recipe_content = trim($_POST['recipe']);
    $author = $_SESSION['LOGGED_USER']['email'];

    if (!empty($title) && !empty($recipe_content)) {
        addRecipe($title, $recipe_content, $author);
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter une recette</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Ajouter une recette</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="recipe" class="form-label">Recette</label>
                <textarea class="form-control" id="recipe" name="recipe" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter la recette</button>
        </form>
    </div>
</body>
</html>

<!-- filepath: /c:/wamp64/www/partage_de_recettes/src/delete_recipe_form.php -->
<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/functions.php');

if (!isset($_SESSION['LOGGED_USER'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $recipe_id = intval($_GET['id']);
    deleteRecipe($recipe_id);
    header('Location: index.php');
    exit();
}

function deleteRecipe($id) {
    global $mysqlClient;
    $stmt = $mysqlClient->prepare("DELETE FROM recipes WHERE recipe_id = :id");
    $stmt->execute(['id' => $id]);
}
?>