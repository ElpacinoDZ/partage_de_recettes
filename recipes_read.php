<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');

// Vérification de l'identifiant de la recette
$getData = $_GET;
if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo 'Il faut un identifiant valide pour afficher une recette';
    exit;
}

// Récupération de la recette et des commentaires
$retrieveRecipeStatementWithCommentsAndRating = $mysqlClient->prepare(
    'SELECT r.title, r.recipe, r.author, c.comment, c.rating , c.date ,u.full_name
    FROM recipes r
    LEFT JOIN comments c ON r.recipe_id = c.recipe_id
    LEFT JOIN users u ON c.user_id = u.user_id
    WHERE r.recipe_id = :id');
$retrieveRecipeStatementWithCommentsAndRating->execute([
    'id' => $getData['id'],
]);
$recipeWithComments = $retrieveRecipeStatementWithCommentsAndRating->fetchAll(PDO::FETCH_ASSOC);

if (empty($recipeWithComments)) {
    echo 'La recette demandée n\'existe pas';
    exit;
}

$recipe = [
    'title' => $recipeWithComments[0]['title'] ?? '',
    'recipe' => $recipeWithComments[0]['recipe'] ?? '',
    'author' => $recipeWithComments[0]['author'] ?? '',
    'comments' => []
];
$totalRating = 0;
$ratingCount=0;

foreach ($recipeWithComments as $row) {
    if (!empty($row['comment'])) {
        $recipe['comments'][] = [
            'comment' => $row['comment'],
            'full_name' => $row['full_name'],
            'rating' => $row['rating'],
            'date' => $row['date']
        ];
        if (!empty($row['rating'])) {
            $totalRating += $row['rating'];
            $ratingCount++;
        }
    }
}
$averageRating = $ratingCount > 0 ? number_format($totalRating / $ratingCount,2) : 'N/A';
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - <?php echo htmlspecialchars($recipe['title']); ?></title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <style>
        .star-rating {
            direction: rtl;
            display: inline-block;
            padding: 20px;
        }
        .star-rating input[type="radio"] {
            display: none;
        }
        .star-rating label {
            color: #bbb;
            font-size: 18px;
            padding: 0;
            cursor: pointer;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -ms-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }
        .star-rating label:hover, .star-rating label:hover ~ label, .star-rating input[type="radio"]:checked ~ label {
            color:rgb(4, 78, 237);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>
        <div class="row">
            <article class="col">
                <p><?php echo nl2br(htmlspecialchars($recipe['recipe'])); ?></p>
            </article>
            
                <p><i>Par <?php echo htmlspecialchars($recipe['author']); ?></i></p>
           
        </div>

        <h2>Commentaires</h2>
        <?php if (empty($recipe['comments'])): ?>
            <p>Aucun commentaire</p>
        <?php else: ?>
            <ul>
                <?php foreach ($recipe['comments'] as $comment): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($comment['full_name']); ?>:</strong>
                        <?php echo htmlspecialchars($comment['comment']); ?>
                    </li>
                    <?php echo htmlspecialchars($comment['date']); ?>
                <?php endforeach; ?>
               
            </ul>
        <?php endif; ?>
    </div>
    <div class="container">
        <h1>Ajouter un commentaire</h1>

        <form action="post_comment.php" method="post">
            <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
            <div class="mb-3">
                <label for="comment" class="form-label">Votre commentaire</label>
                <textarea class="form-control" id="comment" name="comment" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                
                <div class="star-rating" id="rating">
                    <input type="radio" id="star5" name="rating" value="5" required>
                    <label for="star5" title="5 étoiles">&#9733;</label>
                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4" title="4 étoiles">&#9733;</label>
                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3" title="3 étoiles">&#9733;</label>
                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2" title="2 étoiles">&#9733;</label>
                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1" title="1 étoile">&#9733;</label>
                </div>
                <div>
                <h6>Note moyenne : <?php echo $averageRating; ?></h6>
                </div>
                
            </div>
            <button type="submit" class="btn btn-primary">Ajouter le commentaire</button>
        </form>
    </div>

    <!-- inclusion du bas de page du site -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>