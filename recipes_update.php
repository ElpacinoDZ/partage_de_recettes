<?php
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/variables.php');


$getData = $_GET;
if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo 'Il faut un identifiant pour modifier une recette';
    exit;
}
    
$retrieveRecipeStatement = $mysqlClient->prepare('SELECT * FROM recipes WHERE recipe_id = :recipe_id');
$retrieveRecipeStatement->execute([
    'recipe_id' => $getData['id']
]);
$recipe = $retrieveRecipeStatement->fetch(PDO::FETCH_ASSOC);
if (!$recipe) {
    echo 'La recette demandée n\'existe pas';
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la recette</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Modifier une recette</h1>

        <form action="post_update.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($recipe['recipe_id']); ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Titre de la recette</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="recipe" class="form-label">Recette</label>
                <textarea class="form-control" id="recipe" name="recipe" rows="5" required><?php echo htmlspecialchars($recipe['recipe']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Modifier la recette</button>
        </form>
    </div>

    <!-- inclusion du bas de page du site -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>

