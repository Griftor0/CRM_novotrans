<?php

namespace controllers\todo;

use models\todo\Client;

class ClientController {
    private $returnPath = '/crm/todo/clients';
    private $clientModel;

    public function __construct()
    {
        $this->clientModel = new Client();
    }

    public function displayIndex(){
        $clients = $this->clientModel->getAllClients();
        
        include 'app/crm/todo/сlients/index.php';
    }

    public function searchClient(){
        $query = isset($_POST['query']) ? $_POST['query'] : '';

        $clients = $this->clientModel->search($query);
        include 'app/crm/todo/сlients/search.php';
    }
    

    public function showCreateForm(){
        include 'app/crm/todo/сlients/create.php';
    }
    
    public function createClient(){
        if(!$this->validateInput(['full_name', 'identification_number', 'phone', 'vehicle_number'])){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }
        $city = $this->clientModel->getCityByName($_POST['city_name']);
        $city_id = $city ? $city[0]['id'] : null;
        $data = [
            'full_name' => trim(htmlspecialchars($_POST['full_name'])),
            'identification_number' => trim(htmlspecialchars($_POST['identification_number'])),
            'phone' => trim(htmlspecialchars($_POST['phone'])),
            'email' => !empty($_POST['email']) ? trim(htmlspecialchars($_POST['email'])) : null,
            'vehicle_number' => trim(htmlspecialchars($_POST['vehicle_number'])),
            'vehicle_type' => !empty($_POST['vehicle_type']) ? trim(htmlspecialchars($_POST['vehicle_type'])) : null,
            'vehicle_service_life' => !empty($_POST['vehicle_service_life']) ? intval($_POST['vehicle_service_life']) : null,
            'city_id' => $city_id,
            'age' => !empty($_POST['age']) ? trim(htmlspecialchars($_POST['age'])) : null,
            'driving_exp' => !empty($_POST['driving_exp']) ? trim(htmlspecialchars($_POST['driving_exp'])) : null,
            'has_privileges' => !empty($_POST['has_privileges']) ? $_POST['has_privileges'] : null,
            'bonus_mapus_class' => !empty($_POST['bonus_mapus_class']) ? trim(htmlspecialchars($_POST['bonus_mapus_class'])) : null
        ];

        $this->clientModel->create($data);

        header("Location: $this->returnPath");
    }

    public function showEditForm($params){
        $client = $this->clientModel->getClientById($params['id']);

        include 'app/crm/todo/сlients/edit.php';
    }
    
    public function updateClient(){
        if(!$this->validateInput(['full_name', 'identification_number', 'phone', 'vehicle_number'])){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }
    
        $data = [
            'full_name' => trim(htmlspecialchars($_POST['full_name'])),
            'identification_number' => trim(htmlspecialchars($_POST['identification_number'])),
            'phone' => trim(htmlspecialchars($_POST['phone'])),
            'email' => !empty($_POST['email']) ? trim(htmlspecialchars($_POST['email'])) : null,
            'vehicle_number' => trim(htmlspecialchars($_POST['vehicle_number'])),
            'vehicle_type' => !empty($_POST['vehicle_type']) ? trim(htmlspecialchars($_POST['vehicle_type'])) : null,
            'vehicle_service_life' => !empty($_POST['vehicle_service_life']) ? intval($_POST['vehicle_service_life']) : null,
            'city_id' => !empty($_POST['city_id']) ? trim(htmlspecialchars($_POST['city_id'])) : null,
            'age' => !empty($_POST['age']) ? trim(htmlspecialchars($_POST['age'])) : null,
            'driving_exp' => !empty($_POST['driving_exp']) ? trim(htmlspecialchars($_POST['driving_exp'])) : null,
            'has_privileges' => !empty($_POST['has_privileges']) ? $_POST['has_privileges'] : null,
            'bonus_mapus_class' => !empty($_POST['bonus_mapus_class']) ? trim(htmlspecialchars($_POST['bonus_mapus_class'])) : null
        ];

        $this->clientModel->update($_POST['id'], $data);

        header("Location: $this->returnPath");
    }

    public function deleteClient($params){
        $this->clientModel->delete($params['id']);

        header("Location: $this->returnPath");
    }

    private function validateInput($fields){
        foreach($fields as $field){
            if(!isset($_POST[$field]) || empty(trim($_POST[$field]))){
                return false;
            }
        }
        return true;
    }
}