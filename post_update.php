<?php
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/isConnect.php');

// Vérification des données
$postData = $_POST;
if(!isset($postData['id'])
|| !isset($postData['title'])
|| !isset($postData['recipe'])) {
    echo 'Les champs requis ne sont pas remplis';
    exit;
}
$id = $postData['id'];
$title = $postData['title'];
$recipe = $postData['recipe'];
// Ecriture de la requête
$sqlQuery = ('UPDATE recipes SET title = :title, recipe = :recipe WHERE recipe_id = :recipe_id');


// Préparation
$updateRecipe = $mysqlClient->prepare($sqlQuery);

// Exécution ! La recette est maintenant en base de données
$updateRecipe->execute([
    'title' => $title,
    'recipe' => $recipe,
    'recipe_id' => $id,

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
    <h4>Votre recette a bien été modifié !</h4>
</body>


