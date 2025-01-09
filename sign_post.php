<?php
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');


$postData = $_POST;

if (empty($postData['full_name']) && empty($postData['email'])
||empty($postData['password'])) 
{
    echo 'Les champs requis ne sont pas remplis';
    exit;
}

$full_name = $postData['full_name'];
$password = $postData['password'];
$email = $postData['email'];
$age = $postData['age'];

// Vérification de l'existance de l'utilisateur
$checkUserQuery = 'SELECT COUNT(*) FROM users WHERE email = :email AND full_name = :full_name AND password = :password AND age = :age';
$checkUserstatement = $mysqlClient->prepare($checkUserQuery);
$checkUserstatement->execute([
    'full_name' => $full_name,
    'email' => $email,
    'password' => $password, 
    'age' => $age
]);
$UserExists = $checkUserstatement->fetchColumn();

if ($UserExists > 0){
    echo 'L\'utilisateur existe déjà';
    exit;
}
//hashage du mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


// Ecriture de la requête
$sqlQuery = 'INSERT INTO users(full_name, email, password, age) VALUES (:full_name, :email, :password, :age)';

// Préparation
$createUser = $mysqlClient->prepare($sqlQuery);
// Exécution ! La recette est maintenant en base de données
$createUser->execute([
    'full_name' => $full_name,
    'email' => $email,
    'password' => $password, 
    'age' => $age
]);


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte crée</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Votre compte a bien été crée <?php echo htmlspecialchars($full_name)?></h1>
        <div>
            <p><strong><?php echo htmlspecialchars($email); ?>  </strong></p>
        </div>
        <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
    </div>
</body>
</html>
