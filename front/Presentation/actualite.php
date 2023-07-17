<?php 
include './Layout/header.php'; 
require_once __DIR__.'/../Controller/Controller.php';

$controller = new Controller();
$controller->handleRequest();
$result = $controller->Request();

// print_r($result->articles);

?>

<main>
    <aside class="actu-aside">
        <div class="content-container">
            <div class="trendin-header">
                <h2 class="trending-title">Toutes les actualités</h2>
                <p>Retrouvez toutes les actualités sénégalaises et internationales sur <strong>TéléInf.</strong>.</p>
            </div>
        </div>

        <!-- Categories -->
        <div class="actu-list-categories">
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

        <!-- Section d'articles -->
        <section class="actu-container">
            <?php 
             if (empty($result->articles)) { ?>
                    <div class="actu-main-article">
                    <div class="article-content">
                        <h3 class="article-title">Aucun article disponible pour cette catégorie</h3>
                        
                    </div>
                    </div>       
        <?php    }else {
            foreach ($result->articles as $row) 
                { ?>
                    <div class="actu-main-article">
                    <div class="article-content">
                        <h3 class="article-title"><?= $row['titre']; ?></h3>
                        <p class="article-date">Publié le <?= $row['dateCreation']; ?></p>
                        <div class="article-label">
                            <p><?= $row['categorie']['nom'] ?></p>
                        </div>
                        <p class="article-text">
                            <?= $row['description'] ?>
                        </p>
                        <a href="./detailsArticle.php?id=<?= $row['id']; ?>" class="article-link">Lire la suite </a>
                    </div>
                    </div>
                     
                <?php
                }
            }
             ?>
            <!-- Article 1 -->
            

            
        </section>
        <!-- Pagination -->
        <div class="pagination">
            <ul class="pages">
                <li><a href="#" class="page">Précedent</a></li>
                <li><a href="#" class="page">2</a></li>
                <li><a href="#" class="page">3</a></li>
                <li><a href="#" class="page">...</a></li>
                <li><a href="#" class="page">Suivant</a></li>
            </ul>
        </div>

    </aside>
</main>

<?php include './Layout/footer.php'; ?>