<?php
class Service {
    private $apiUrl = 'http://localhost:9009/api/';

    public function getAllCategories() {
        $response = file_get_contents($this->apiUrl.'categories');
        $data=null;
        if ($response !== false) {
            $data = json_decode($response, true); // Convertir la réponse JSON en tableau associatif
            
        }
        return $data;
    }

    public function getLatest(){
        $response = file_get_contents($this->apiUrl.'article/latest');
        $data=null;
        if ($response !== false) {
            $data = json_decode($response, true); // Convertir la réponse JSON en tableau associatif
            
        }
        // print_r($data['titre']);
        return $data;
    }

    public function login($username, $password){
        $soapParams = array(
            'trace' => 1, // Activer le suivi des requêtes SOAP (optionnel)
            'exceptions' => 0 // Gérer les exceptions SOAP (optionnel)
        );
        $soapUrl = 'http://localhost:9009/ws/UserWs.wsld/getUser';
        $soapClient = new SoapClient($soapUrl, $soapParams);
        $response = $soapClient->getUserInfo($username, $password);
        $xmlResponse = $soapClient->__getLastResponse();
        processResponse($xmlResponse);
    }

    public function createUser(User $user) {
        $soapParams = array(
            'trace' => 1,
            'exceptions' => 0
        );

        $soapUrl = 'http://localhost:9009/ws/UserWs.wsld/getUser';
        $soapClient = new SoapClient($soapUrl, $soapParams);

        $response = $soapClient->createUser($user);

    }

    public function updateUser(User $user) {
        $soapParams = array(
            'trace' => 1,
            'exceptions' => 0
        );


        $soapClient = new SoapClient($soapUrl, $soapParams);

        $response = $soapClient->updateUser($user);

    }


    public function processResponse($xmlResponse) {
        $responseXml = new SimpleXMLElement($xmlResponse);
        $role = $responseXml->role;
        if ($role === 'editeur') {
            header('Location: editeur.php');
            exit;
        } elseif ($role === 'administrateur') {
            header('Location: admin.php');
            exit;
        } else {
            header('Location: index.php');
            exit;
        }
    }


    public function getAllArticles() {
        $response = file_get_contents($this->apiUrl.'articles');
        $data=null;
        if ($response !== false) {
            $data = json_decode($response, true); // Convertir la réponse JSON en tableau associatif
            
        }
        return $data;
    }

    public function getDetailsArticle($id){
        $response = file_get_contents($this->apiUrl.'article/'.$id);
        $data=null;
        if ($response !== false) {
            $data = json_decode($response, true); // Convertir la réponse JSON en tableau associatif
            
        }
        return $data;
    }

    public function getArticlesOfOneCategorie($id_categorie) {
        $response = file_get_contents($this->apiUrl.'categorie/'.$id_categorie.'/articles');
        $data=null;
        if ($response !== false) {
            $data = json_decode($response, true); // Convertir la réponse JSON en tableau associatif         
        }
        return $data;
    }

    public function saveArticle($data) {
        // Convertir les données en JSON
        $jsonData = json_encode($data);
        $curl = curl_init($this->apiUrl.'article');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($curl);
        
        if ($response === false) {
            echo 'Erreur lors de la sauvegarde de l\'article : ' . curl_error($curl);
        } else {
            echo 'Article sauvegardé avec succès.';
        }

        curl_close($curl);
        
        // if($response===true){
        //     echo 'ajout effectué';
        // }else{
        //     echo 'ajout non effectué';
        // }

        // Vérifier les erreurs éventuelles
        // if ($response === false) {
        //     $error = curl_error($curl);
        //     
        // }

        // Fermer la requête cURL
        curl_close($curl);
        header("Location: /teleinf/Presentation/admin.php");
        exit();
    }

    public function saveUser($data){
        $jsonData = json_encode($data);
        $curl = curl_init($this->apiUrl.'user');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
         $response = curl_exec($curl);
        
        if ($response === false) {
           echo 'ajout effectuer';
        } else {
           echo 'ajout non effectuer';

        }
        curl_close($curl);
        header("Location: /teleinf/Presentation/admin.php");
        exit();
    }

    public function getUsers(){
        $response = file_get_contents($this->apiUrl.'users');
        $data=null;
        if ($response !== false) {
            $data = json_decode($response, true); // Convertir la réponse JSON en tableau associatif
            
        }
        return $data;
    }

    public function saveCategorie($data){
        $jsonData = json_encode($data);
        $curl = curl_init($this->apiUrl.'categorie');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($curl);
        
        if ($response === false) {
            echo 'Erreur lors de la sauvegarde de la catégorie : ' . curl_error($curl);
        } else {
            echo 'Catégorie sauvegardée avec succès.';
        }
        curl_close($curl);
        header("Location: /teleinf/Presentation/admin.php");
        exit();
    }

    public function deleteArticle($articleId)
    {
        $curl = curl_init();
        $url = $this->apiUrl.'article/'.$articleId;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");

        $response = curl_exec($curl);

        print_r($response);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($httpCode == 204) {
            echo "Article supprimé avec succès.";
        } else {
            echo "Une erreur s'est produite lors de la suppression de l'article.";
        }
    }

    public function updateArticle($data, $id){
        $jsonData = json_encode($data);
        $curl = curl_init($this->apiUrl.'article/'.$id);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($curl);
        
        if ($response === false) {
            echo 'Erreur lors de la modification de l\'article : ' . curl_error($curl);
        } else {
            echo 'Article modifier avec succès.';
        }
        curl_close($curl);
        header("Location: /teleinf/Presentation/admin.php");
        exit();
    }

    public function updateCategorie($data, $id){
        $jsonData = json_encode($data);
        $curl = curl_init($this->apiUrl.'categorie/'.$id);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($curl);
        
        if ($response === false) {
            echo 'Erreur lors de la sauvegarde de la catégorie : ' . curl_error($curl);
        } else {
            echo 'Catégorie modifier avec succès.';
        }
        curl_close($curl);
        header("Location: /teleinf/Presentation/admin.php");
        exit();
    }

}
