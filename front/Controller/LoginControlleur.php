<?php
require_once __DIR__.'/../Service/Service.php';

class LoginControlleur{
	public $service;

    public function __construct() {
        $this->service = new Service();
    }


	public function waitingConnection(){
        // Vérification si l'utilisateur est déjà connecté, le rediriger vers la page protégée
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            header('Location: admin.php');
            exit;
        }

        // Vérification des données de connexion lors de la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $this->service->login($username, $password);
        }
    }

}

   ?>