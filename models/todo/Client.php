<?php

namespace models\todo;

use PDO;
use models\Database;

class Client{
    private $dbConnection;
    
    public function __construct(){
        $this->dbConnection = Database::getInstance()->getConnection();
    }

    public function getAllClients(){      // Показать всех пользователей
        $query = "SELECT * FROM clients";

        $statement = $this->dbConnection->query($query);

        $clients = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $clients[] = $row;
        }

        return $clients;
    }

    public function getClientById($client_id){
        $query = "SELECT * FROM clients WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$client_id]);

        $client = $statement->fetch(PDO::FETCH_ASSOC); 

        return $client ? $client : false;
    }
    
    public function create($data){
        $query = "INSERT INTO clients (full_name, identification_number, phone, email, vehicle_number, vehicle_type, vehicle_service_life, city_id, age, driving_exp, has_privileges, bonus_mapus_class) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([
            $data['full_name'],
            $data['identification_number'],
            $data['phone'],
            $data['email'],
            $data['vehicle_number'],
            $data['vehicle_type'],
            $data['vehicle_service_life'],
            $data['city_id'],
            $data['age'],
            $data['driving_exp'],
            $data['has_privileges'],
            $data['bonus_mapus_class']
        ]);

        return $this->dbConnection->lastInsertId();
    }

    public function update($client_id, $data){
        $query = "UPDATE clients SET full_name = ?, identification_number = ?, phone = ?, email = ?, vehicle_number = ?, vehicle_type = ?, vehicle_service_life = ?, city_id = ?, age = ?, driving_exp = ?, has_privileges = ?, bonus_mapus_class = ? 
        WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([
            $data['full_name'],
            $data['identification_number'],
            $data['phone'],
            $data['email'],
            $data['vehicle_number'],
            $data['vehicle_type'],
            $data['vehicle_service_life'],
            $data['city_id'],
            $data['age'],
            $data['driving_exp'],
            $data['has_privileges'],
            $data['bonus_mapus_class'],
            $client_id
        ]);
    }

    public function delete($client_id){
        $query = "DELETE FROM clients WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$client_id]);
    }

    public function search($query){
        $query = '%' . $query . '%';
        $sql = "SELECT * FROM clients 
                WHERE full_name LIKE :query 
                OR identification_number LIKE :query 
                OR phone LIKE :query 
                OR email LIKE :query 
                OR vehicle_number LIKE :query 
                OR vehicle_type LIKE :query 
                OR vehicle_service_life LIKE :query 
                OR city_id LIKE :query 
                OR age LIKE :query 
                OR driving_exp LIKE :query 
                OR has_privileges LIKE :query 
                OR bonus_mapus_class LIKE :query";
        
        $statement = $this->dbConnection->prepare($sql);
        $statement->bindParam(':query', $query, PDO::PARAM_STR);
        $statement->execute();
    
        $clients = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $clients[] = $row;
        }
    
        return $clients;
    }

    public function getCityByName($name) {
        $query = 'SELECT id FROM cities WHERE name LIKE :name LIMIT 1';
        $statement = $this->dbConnection->prepare($query);
        $statement->execute(['name' => '%' . $name . '%']);
        
        return $statement->fetchAll();
    }

    public function getCityAndAreaByCityId($city_id) {
        $query = 'SELECT cities.name AS city_name, areas.name AS area_name FROM clients
                    JOIN cities ON clients.city_id = cities.id
                    JOIN areas ON cities.area_id = areas.id
                    WHERE cities.id = :city_id';
        $statement = $this->dbConnection->prepare($query);
        $statement->execute(['city_id' => $city_id]);
        
        return $statement->fetchAll();
    }
}