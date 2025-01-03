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
    <title>Supprimer la recette</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Supprimer une recette</h1>
        <p>Êtes-vous sûr de vouloir supprimer définitivement la recette "<?php echo htmlspecialchars($recipe['title']); ?>" ?</p>
        <form action="post_delete.php?id=<?php echo $getData['id']; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($recipe['recipe_id']); ?>">
            <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
            <a href="index.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>

    <!-- inclusion du bas de page du site -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>