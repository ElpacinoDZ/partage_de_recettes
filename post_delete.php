<?php
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/isConnect.php');


// Vérification des données
$postData = $_POST;
if(!isset($postData['id'])) {
    echo 'Il faut un identifiant pour supprimer une recette';
    exit;
}
$id = $postData['id'];


// Ecriture de la requête
$sqlQuery = ('DELETE FROM recipes WHERE recipe_id = :recipe_id');
// Préparation
$deleteRecipe = $mysqlClient->prepare($sqlQuery);
$deleteRecipe->execute([
    'recipe_id' => $id
])or die(print_r($mysqlClient->errorInfo()));



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
    <h1>La recette a bien été supprimée !</h1>
    <p></p>
    <a type="submit" href="index.php"  class="btn btn-primary">Retour à l'accueil</a>
</body>