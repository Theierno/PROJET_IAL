<?php 
include './Layout/adminHeader.php'; 
require_once __DIR__.'/../Controller/Controller.php';
$controller = new Controller();
$controller->handleRequest();
$result = $controller->Request();
// print_r($result->users);
?>


<main>
    <section class="admin-panel">
        <h2>Panneau d'administration</h2>



        <div class="admin-selector">
            <label for="admin-select">Choisissez une section:</label>
            <select id="admin-select" class="admin-selector">
                <option value="adminUser">Admin User</option>
                <option value="adminCategories">Admin Categories</option>
                <option value="adminArticle">Admin Article</option>
            </select>
        </div>

         <div id="myModalAdd" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="modalFormAdd" method="POST" action="../Controller/Controller.php">
                    <!-- The form fields will be dynamically added here -->
                </form>
            </div>
        </div>

        <!-- The Edit Modal -->
        <div id="myModalEdit" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="modalFormEdit" method="POST" action="../Controller/Controller.php">
                    <!-- The form fields will be dynamically added here -->
                </form>
            </div>
        </div>



        <!-- Section Admin User -->
        <div id="adminUser" class="admin-section">
            <h3>Gestion des utilisateurs</h3>
            <table class="admin-table">
                <!-- Table Header -->
                <tr>
                    <th>Nom d'utilisateur</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td>admin</td>
                    <td>admin</td>
                    <td>
                        <button class="admin-button edit" data-entity="user" data-id="1">Modifier</button>
                    </td>
                </tr>

                 <?php
                    foreach($result->users as $row)
                    { ?>
                        <tr>
                            <td> <?= $row['username'] ?> </td>
                            <td> editeur </td>
                            <td>
                                <button class="admin-button edit" data-id="<?= $row['id'] ?>">Modifier</button>
                                <button class="admin-button delete">Supprimer</button>
                                <button class="modal-button jeton" onclick="toggleJeton()">Générer jeton</button>
                            </td>
                        </tr>
                 <?php  }

                ?>

                
            </table>

            <h3>Jetons d'authentification</h3>
            <div class="jeton"id="jetonSection" style="display:none;">
                <table class="admin-table">
                <!-- Table Header -->
                <tr>
                    <th>user</th>
                    <th>Jetons</th>
                    <th>Actions</th>
                </tr>

                <!-- Table Data -->
                <!-- You should fetch data from your database and populate this table -->
                <tr>
                    <td><?= $result->users[0]['username'] ?></td>
                    <td><?= $result->users[0]['token'] ?></td>
                    <td>
                        <button class="admin-button delete">Supprimer</button>
                    </td>
                </tr>
            </table>
            </div>
    
            <button class="admin-button add">Ajouter un utilisateur</button>

        </div>

        <!-- Section Admin Categories -->
        <div id="adminCategories" class="admin-section" style="display: none;">
            <h3>Gestion des catégories</h3>
            <table class="admin-table">
                <!-- Table Header -->
                <tr>
                    <th>Nom de la catégorie</th>
                    <th>Actions</th>
                </tr>

                <!-- Table Data -->
                <!-- You should fetch data from your database and populate this table -->

                <?php
                    foreach($result->categories as $row)
                    { ?>
                        <tr>
                            <td> <?= $row['nom'] ?> </td>
                            <td>
                                <button class="admin-button edit" data-entity="category" data-id="<?= $row['id'] ?>">Modifier</button>
                                <button class="admin-button delete">Supprimer</button>
                            </td>
                        </tr>
                 <?php  }

                ?>
                
                

            </table>
            <button class="admin-button add">Ajouter une catégorie</button>
        </div>

        <!-- Section Admin Article -->
        <div id="adminArticle" class="admin-section" style="display: none;">
            <h3>Gestion des articles</h3>
            <table class="admin-table">
                <!-- Table Header -->
                <tr>
                    <th>Titre de l'article</th>
                    <th>Actions</th>
                    <th>Catégorie</th>
                    <th>Contenu</th>
                </tr>

                <!-- Table Data -->
                <!-- You should fetch data from your database and populate this table -->
                <?php
                    foreach($result->articles as $row)
                    { ?>
                        <tr>
                            <td> <?= $row['titre'] ?> </td>
                            <td> <?= $row['description'] ?> </td>
                            <td> <?= $row['categorie']['nom'] ?> </td>
                            <td>
                                <button class="admin-button edit" data-description="<?= $row['description'] ?>" data-titre="<?= $row['titre'] ?>" data-entity="article" data-id="<?= $row['id'] ?>">Modifier</button>
                                <form method="POST" action="../Controller/ControllerDelete.php">
                                <button class="admin-button-supp delete" name="id" value="<?= $row['id'] ?>" data-id="<?= $row['id'] ?>">Supprimer</button>
                                    
                                </form>
                            </td>
                        </tr>
                 <?php  }

                ?>
            </table>
            <button class="admin-button add">Ajouter un article</button>
        </div>



    </section>
</main>

<?php include './Layout/footer.php'; ?>
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        const adminSelect = document.getElementById('admin-select');
        const adminUser = document.getElementById('adminUser');
        const adminCategories = document.getElementById('adminCategories');

        adminSelect.addEventListener('change', (event) => {
            switch (event.target.value) {
                case 'adminUser':
                    adminUser.style.display = 'block';
                    adminCategories.style.display = 'none';
                    adminArticle.style.display = 'none';
                    break;
                case 'adminCategories':
                    adminUser.style.display = 'none';
                    adminCategories.style.display = 'block';
                    adminArticle.style.display = 'none';
                    break;
                case 'adminArticle':
                    adminUser.style.display = 'none';
                    adminCategories.style.display = 'none';
                    adminArticle.style.display = 'block';
                    break;
            }

        });
    });
</script>
<script>
    // Get the modal
    var modal = document.getElementById("myModalAdd");
    var modalEdit = document.getElementById("myModalEdit");
    var currentID;


    // Get the button that opens the modal
    var btns = document.getElementsByClassName("admin-button");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    for (var i = 0; i < btns.length; i++) {
        btns[i].onclick = function() {
            var btnType = this.innerHTML;
            var form = document.getElementById("modalFormAdd");
            form.innerHTML = ''; // Reset the form

            if (btnType == 'Ajouter un utilisateur') {
                // Add user fields
                form.innerHTML += '<h3">Ajout utilisateur</h3><br>';
                form.innerHTML += '<label class="modal-label" for="username">Nom d\'utilisateur:</label><br>';
                form.innerHTML += '<input  class="modal-input" type="text" id="username" name="username" placeholder="Saisir le nom d\'utilisateur"><br>';
                form.innerHTML += '<input  class="modal-input" type="hidden" name="type" value="saveUser" ><br>';
                form.innerHTML += '<label class="modal-label" for="pwd">Mot de passe:</label><br>';
                form.innerHTML += '<input class="modal-input" type="password" id="pwd" name="password"  placeholder="Saisir le mot de passe"><br>';
                form.innerHTML += '<label class="modal-label" for="type">Type:</label><br>';
                form.innerHTML += '<div>     <select class="modal-selector" id="type" name="types">     <option value="admin">Admin</option><option value="editeur">Éditeur</option>     </select><br></div>';
                form.innerHTML += '<div id="tokenBlock" class="modal-tokenBlock"></div>'; 
                form.innerHTML += '<button type="submit" class="modal-submit" id="addUser">Ajouter</button>';
            } else if (btnType == 'Ajouter une catégorie') {
                // Add category fields
                form.innerHTML += '<h3">Ajout catégories</h3><br>';
                
                form.innerHTML += '<label class="modal-label" for="category">Nom de la catégorie:</label><br>';
                form.innerHTML += '<input class="modal-input" type="text" id="category" name="nom"><br>';
                form.innerHTML += '<input type="hidden" id="type" name="type" value="categorie"> '
                form.innerHTML += '<button type="submit" class="modal-submit" id="addCategory">Ajouter</button>';
 

            } else if (btnType == 'Ajouter un article') {
                // Add article fields
                form.innerHTML += '<h3">Ajout articles</h3><br>';

                form.innerHTML += '<label class="modal-label" for="title">Titre:</label><br>';
                form.innerHTML += '<input class="modal-input" type="text" id="title" name="titre"><br>';
                form.innerHTML += '<label class="modal-label for="date">Date:</label><br>';
                form.innerHTML += '<input class="modal-input" type="date" id="dateCreation" name="dateCreation" value="" ><br>';
                form.innerHTML += '<label class="modal-label for="content">Contenu:</label><br>';
                form.innerHTML += '<textarea class="modal-textarea" id="content" name="description"></textarea><br>';
                form.innerHTML += '<label class="modal-label for="category">Catégories:</label><br>';
                form.innerHTML += '<input type="hidden" id="type" name="type" value="article"> '
                form.innerHTML += '<select class="modal-selector" id="category" name="nomCategorie"><?php foreach ($result->categories as $row) {
                 ?> <option value="<?= $row['nom'] ?>"><?= $row['nom'] ?></option> <?php } ?></select><br>';
                form.innerHTML += '<button type="submit" class="modal-submit" id="addArticles">Ajouter</button>';
            }


            modal.style.display = "block";
        }
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modalEdit.style.display = "none";
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modalEdit.style.display = "none";
            modal.style.display = "none";
        }
    }
     let editButtons = document.querySelectorAll('.edit');

    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            let entity = this.getAttribute('data-entity');
            let id = this.getAttribute('data-id');
            let titre = this.getAttribute('data-titre');
            let description = this.getAttribute('data-description');

            // Call a function to open the modal and load the entity details
            openModal(entity, id,titre,description);
        });
    });

    //Modal form for modify
    function openModal(entity, id,titre,description) {
    modalEdit.style.display = "block";
    // Open the modal
        currentID = id;

    // Get the form element
    var form = document.getElementById("modalFormEdit");
    form.innerHTML = ''; // Reset the form

    // Load the entity details based on the entity type
    switch(entity) {
        case 'user':
            // Load user details
            form.innerHTML += '<h3">Modifier utilisateur</h3><br>';
            form.innerHTML += '<label class="modal-label" for="username">Nouveau Nom d\'utilisateur:</label><br>';
            form.innerHTML += '<input  class="modal-input" type="text" id="username" name="username" placeholder="Saisir le nom d\'utilisateur"><br>';
            form.innerHTML += '<label class="modal-label" for="pwd">Nouveau Mot de passe:</label><br>';
            form.innerHTML += '<input class="modal-input" type="password" id="pwd" name="pwd"  placeholder="Saisir le mot de passe"><br>';
            form.innerHTML += '<label class="modal-label" for="type">Type:</label><br>';
            form.innerHTML += '<div>     <select class="modal-selector" id="type" name="type">     <option value="admin">Admin</option><option value="editeur">Éditeur</option>     </select><br></div>';
            form.innerHTML += '<div id="tokenBlock" class="modal-tokenBlock"></div>';
            form.innerHTML += '<button class="modal-submit" id="editUser">Modifier</button>';
            break;
        case 'category':
            // Load category details
            form.innerHTML += '<h3">Modifier catégories</h3><br>';
            form.innerHTML += '<label class="modal-label" for="category">Nouveau Nom de la catégorie:</label><br>';
            form.innerHTML += '<input type="hidden" id="type" name="type" value="editCategorie">';
            form.innerHTML += '<input type="hidden" id="type" name="id" value="' + currentID + '">';
            form.innerHTML += '<input class="modal-input" type="text" id="nom" name="nom"><br>';
            form.innerHTML += '<button type="submit" class="modal-submit" id="editCategory">Modifier</button>';
            break;
        case 'article':
            // Load article details
            form.innerHTML += '<h3">Modifier articles</h3><br>';
            form.innerHTML += '<label class="modal-label" for="title">Nouveau Titre:</label><br>';
            form.innerHTML += '<input class="modal-input" type="text" id="titre" name="titre" value="'+ titre +'"><br>';
            form.innerHTML += '<label class="modal-label for="date">Date de modification :</label><br>';
            form.innerHTML += '<input class="modal-input" type="date" id="dateCreation" name="dateCreation" value="" ><br>';
            form.innerHTML += '<input type="hidden" id="type" name="id" value="' + currentID + '">';

            form.innerHTML += '<label class="modal-label for="content">Nouveau Contenu:</label><br>';
            form.innerHTML += '<textarea class="modal-textarea" id="content" name="description" value="'+ description +'"></textarea><br>';
            form.innerHTML += '<label class="modal-label for="category">Catégories affiliée :</label><br>';
            form.innerHTML += '<input type="hidden" id="type" name="type" value="editArticle">';

            form.innerHTML += '<select class="modal-selector" id="category" name="nomCategorie"><?php foreach ($result->categories as $row) {
                 ?> <option value="<?= $row['nom'] ?>"><?= $row['nom'] ?></option> <?php } ?></select><br>';
            form.innerHTML += '<button  class="modal-submit" id="editArticles">Modifier</button>';
            break;
    }

}
function toggleJeton() {
  var jetonSection = document.getElementById("jetonSection");
  jetonSection.style.display = (jetonSection.style.display === "none") ? "block" : "none";
}
// Sélectionner tous les boutons "Supprimer"
const deleteButtons = document.querySelectorAll('.admin-button-supp.delete');

console.log(deleteButtons);
// Ajouter un gestionnaire d'événement pour chaque bouton "Supprimer"
deleteButtons.forEach(button => {
  button.addEventListener('click', () => {
    // Récupérer l'ID de l'article à supprimer depuis l'attribut data-id
    const articleId = button.getAttribute('data-id');

    // Envoyer la requête DELETE
    fetch(`http://localhost:9009/api/article/${articleId}`, {
      method: 'DELETE'
    })
    .then(response => {
      // Vérifier le statut de la réponse
      if (response.ok) {
        // Article supprimé avec succès
        // Actualiser la page ou effectuer une autre action
        location.reload(); // Exemple : actualiser la page
      } else {
        // Gérer les erreurs
        console.error('Erreur lors de la suppression de l\'article');
      }
    })
    .catch(error => {
      // Gérer les erreurs de la requête
      console.error('Erreur lors de la requête DELETE', error);
    });
  });
});

</script>
</body>

</html>