<?php

class ControllerDelete {
	 private $apiUrl = 'http://localhost:9009/api/';
	public function delete(){
		$id=$_POST['id'];
		$curl = curl_init($this->apiUrl.'article/'.$id);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
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

}
$controller = new ControllerDelete();
$controller->delete();