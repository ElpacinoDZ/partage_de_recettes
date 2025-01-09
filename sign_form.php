<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <h1>Créer un compte utilisateur</h1>
        <form action="sign_post.php" method="post">
        <div class="mb-3">
                <label for="full_name" class="form-label">Nom complet</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
            <div class="mb-3">
        <div>
            <label for="age" class="form-label">Quel est votre âge ?</label>
            <input type="text" class="form-control" id="age" name="age" required>
        </div>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
           
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
</body>

</html>