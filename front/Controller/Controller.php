<?php
require_once __DIR__.'/../Service/Service.php';

class Controller {
    public $service;
    public $articles;
    public $page;
    public $categories;
    public $latest;
    public $users;

    public function __construct() {
        $this->service = new Service();
    }

    public function Request() {
    	if (isset($_GET['categorie'])) {

            $categorieId = $_GET['categorie'];
            $this->articles = $this->service->getArticlesOfOneCategorie($categorieId);
            $this->categories = $this->service->getAllCategories();
            $this->latest = $this->service->getLatest();
            $this->users = $this->service->getUsers();

            return $this;

        }else {
            
            $this->articles = $this->service->getAllArticles();
            $this->categories = $this->service->getAllCategories();

            $this->latest = $this->service->getLatest();
            $this->users = $this->service->getUsers();
            

            return $this;
        }
    }

    public function getDetailsArticle($id){
        return $this->service->getDetailsArticle($id);
    }

    public function handleRequest(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
             $type = $_POST['type'];
             $c = new Controller();

             if ($type==='article') {
                 $c->saveArticle();
             }elseif ($type==='categorie') {
                $c->saveCategorie();
             }elseif ($type==='editCategorie') {
                 $c->updateCategorie();
                // echo $_POST['id'];
                // echo 'là';
             }elseif ($type==='editArticle') {
                 $c->updateArticle();
             }elseif($type==='saveUser'){
                $c->saveUser();
             }
        }    
    }

    public function saveArticle(){
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $dateCreation = $_POST['dateCreation'];
            $nomCategorie = $_POST['nomCategorie'];

            // Créez un tableau avec les données de l'article
            $data = array(
                'titre' => $titre,
                'description' => $description,
                'dateCreation' => $dateCreation,
                'nomCategorie' => $nomCategorie,
            );

            // print_r($data);
            $this->service->saveArticle($data);    
    }

    public function saveUser(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $data = array(
            'username' => $username,
            'password' => $password,
        );
        // print_r($data);
        $this->service->saveUser($data);
    }

    public function createUser(User $user) {
        $this->service->createUser($user);
    }

    public function updateUser(User $user) {
        $this->service->updateUser($user);
           
    }


    public function saveCategorie(){
        $nom = $_POST['nom'];
        $data = array(
            'nom'=>$nom
        );
        // print_r($data);
        $this->service->saveCategorie($data);
    }
    public function deleteArticle($articleId) {
        
        $this->service->deleteArticle($articleId);
    }

    public function updateArticle() {
            $id= $_POST['id'];
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $dateCreation = $_POST['dateCreation'];
            $nomCategorie = $_POST['nomCategorie'];

            // Créez un tableau avec les données de l'article
            $data = array(
                'titre' => $titre,
                'description' => $description,
                'dateCreation' => $dateCreation,
                'nomCategorie' => $nomCategorie,
            );

            // print_r($data);
            // echo $id;

            $this->service->updateArticle($data,$id);
    }

    public function updateCategorie(){
        $nom = $_POST['nom'];
        $id= $_POST['id'];
        $data = array(
            'nom'=>$nom
        );
        // print_r($data);
        $this->service->updateCategorie($data, $id);
    }

    
}
$controller = new Controller();
$controller->handleRequest();
