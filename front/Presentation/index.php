<?php 
require_once __DIR__.'/../Controller/Controller.php';
$controller = new Controller();
$controller->handleRequest();
$result = $controller->Request();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TéléInf</title>
    <link rel="stylesheet" href="../Assets/CSS/style.css">
</head>

<body>

    <?php include './Layout/header.php'; ?>


    <!-- Start Main content -->

    <main>
        <aside>
            <div class="content-container">
                <div class="trendin-header">
                    <h2 class="trending-title">Les Dernières Actualités de cette <span class="special-word">Semaine</span>. </h2>
                    <p> Retrouvez l'actualité sénégalaise et internationale sur <strong>TéléInf.</strong>, et toute l'information sur la politique, l'économie, la culture, les nouveautés high-tech.</p>

                </div>
            </div>

            <!-- Main article -->
            <!-- Mettre ici selon la dernière actualité en fonction de la date de publication -->

            <div class="main-article">
                <!--
                <div class="article-img">
                    <img src="../Assets/image.jpg" alt="actualite1">
                </div>
                -->
                <div class="article-content">

                    <h3 class="article-title"> <?= $result->latest['titre'] ?> </h3>
                    <p class="article-date">Publié le <?= $result->latest['dateCreation'] ?> </p>
                    <div class="article-label">
                        <p><?= $result->latest['categorie']['nom'] ?></p>
                    </div>
                    <p class="article-text">
                        <?= $result->latest['description'] ?>
                    </p>
                    <!-- Lien vers le details de l'article. On pass en paramètre les données -->
                    
                    <a href="./detailsArticle.php?id=<?= $result->latest['id']; ?>" class="article-link">Lire la suite </a>
                </div>
            </div>

        </aside>
        <section>
            <div class="headline">
                <h2>À découvrir</h2>
            </div>

            <!-- Search article by category -->
            <div class="search-bar">
                <form action="" method="post">
                    <input type="text" name="search" id="search" placeholder="Rechercher une actualité...">
                </form>
            </div>

            <!-- Listing categories -->
            <div class="list-categories">
                <ul class="categories">
                    <?php       
                        foreach ($result->categories as $row) 
                        { ?> 
                            <li><a  class="categorie" href="./actualite.php?categorie=<?= $row['id']; ?>" ><?= $row['nom']; ?></a></li>  
                        <?php
                        } 
                        
                    ?>
                </ul>
            </div>

            <!-- Listing articles secondaire (autre que derniers créer) -->
            <div class="mini-articles">


                <div class="mini-article">
                    <!--
                    <div class="article-img">
                        <img src="../Assets/image.jpg" alt="actualite1">
                    </div> -->
                    <div class="article-content">
                        <h3 class="mini-article-title"><?= $result->articles[0]['titre']  ?> </h3>
                        <p class="mini-article-date">Publié le <?= $result->articles[0]['description']  ?>  </p>
                        <div class="mini-article-label">
                            <p><?= $result->articles[0]['categorie']['nom']  ?> </p>
                        </div>
                        <a href="./detailsArticle.php" class="mini-article-link">Voir plus</a>
                    </div>
                </div>

                <div class="mini-article">
                    <!--
                    <div class="article-img">
                        <img src="../Assets/image.jpg" alt="actualite1">
                    </div>-->
                    <div class="article-content">
                        <h3 class="mini-article-title"><?= $result->articles[1]['titre']  ?> </h3>
                        <p class="mini-article-date">Publié le <?= $result->articles[1]['dateCreation']  ?>  </p>
                        <div class="mini-article-label">
                            <p><?= $result->articles[1]['categorie']['nom']  ?> </p>
                        </div>
                        <a href="./detailsArticle.php" class="mini-article-link">Voir plus</a>
                    </div>
                </div>

            </div>

            <!-- Pagination -->
            <div class="pagination">
                <ul class="pages">
                    <li><a href="#" class="page">Précedent</a></li>
                    <li><a href="#" class="page">2</a></li>
                    <li><a href="#" class="page">3</a></li>
                    <li><a href="#" class="page">...</a></li>
                    <li><a href="#" class="page">Suivant</a></li>
                </ul>
        </section>

    </main>

    <!-- End Main content -->

    <?php include './Layout/footer.php'; ?>



</body>

</html>