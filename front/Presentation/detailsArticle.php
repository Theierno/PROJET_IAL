<?php 
require_once __DIR__.'/../Controller/Controller.php';
include './Layout/header.php'; 
$articleId = $_GET['id'];
$controller = new Controller();
$result = $controller->getDetailsArticle($articleId);
// print_r($result);

?>

<!-- Main content -->
<main>
    <div class="details-headline">
        <h2>
            <?= $result['titre'] ?>
        </h2>

        <p>Publié le <?= $result['dateCreation'] ?> </p>
        <div class="details-article-label">
            <p><?= $result['categorie']['nom'] ?></p>
        </div>

        <p class="details-article-text">
            <?= $result['description'] ?>

        </p>

    </div>
</main>

<?php include './Layout/footer.php'; ?>