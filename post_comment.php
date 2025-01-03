<?php

require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');


/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$postData = $_POST;

if (
    !isset($postData['comment']) ||
    !isset($postData['recipe_id']) ||
    !is_numeric($postData['recipe_id'])||
    !isset($postData['rating'])

) {
    echo('Le commentaire ne peut pas être vide.');
    return;
}
// On récupère le commentaire et l'id de la recette
$comment = trim(strip_tags($postData['comment']));
$recipe_id = $postData['recipe_id'];


// On écrit la requête
$sqlQuery ='INSERT INTO comments (comment,recipe_id , user_id, rating) VALUES (:comment,:recipe_id , :user_id, :rating)';
// On prépare la requête
$sqlstatement = $mysqlClient->prepare($sqlQuery);
$sqlstatement->execute([
    'comment' => $postData['comment'],
    'recipe_id' => $postData['recipe_id'],
    'user_id' => $_SESSION['LOGGED_USER']['user_id'],
    'rating' => $postData['rating']

]);





?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commentaire</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Commentaire ajouté</h1>
        <div>
            <p><strong><?php echo htmlspecialchars($comment); ?>  </strong></p>
        </div>
            
        
        <p>Votre commentaire et note ont bien été pris en compte. Merci pour votre contribution !</p>
        <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
    </div>
</body>
</html>