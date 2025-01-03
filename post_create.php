<?php
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/isConnect.php');
$postData = $_POST;

if (isset($postData['title']) && isset($postData['recipe'])) 
if (isset($_SESSION['LOGGED_USER']))

{
    $title = $postData['title'];
    $recipe = $postData['recipe'];
} 
else 
{
    echo 'Les champs requis ne sont pas remplis';
    exit;
}
// Ecriture de la requête
$sqlQuery = 'INSERT INTO recipes(title, recipe, author, is_enabled) VALUES (:title, :recipe, :author, :is_enabled)';

// Préparation
$insertRecipe = $mysqlClient->prepare($sqlQuery);

// Exécution ! La recette est maintenant en base de données
$insertRecipe->execute([
    'title' => $title,
    'recipe' => $recipe,
    'author' => $_SESSION['LOGGED_USER']['email'],
    'is_enabled' => 1
]);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Création d'une recette</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
<div class="container">
    <!-- inclusion de l'entête du site -->
    <?php require_once(__DIR__ . '/header.php'); ?>
    <h1>Recette ajoutée !</h1>
    <p>Votre recette a bien été ajoutée !</p>
</body>