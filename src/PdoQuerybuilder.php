<?php

namespace Otto;

use PDO;

trait PdoQueryBuilder
{
    protected $pdo;
    protected $config;

    public function getRecordPerPage() {
        $this->config = require __DIR__ . '/../config/database.config.php';
        return $this->config['noofrecordsperpage']; 
    }

    public function setPdoObject(){
        $this->pdo = $this->pdoBuilder->pdo;
    }

    public function fetchRecords(){    
        $query = 'SELECT db.director_id as id, db.business_id as bid, d.occupation, d.first_name, d.last_name, b.name, b.registered_address, 
        b.registration_number FROM director_businesses as db 
        JOIN directors as d ON (db.director_id = d.id)
        JOIN businesses as b ON (db.business_id = b.id)';

        return $this->executePrepareStatement($query);
    }

    public function fetchDirectorRecords(){
        $query = 'SELECT d.id, d.first_name, d.last_name, d.occupation, d.date_of_birth 
        FROM directors as d';

        return $this->executePrepareStatement($query);
    }

    public function fetchSingleDirectorRecord($did){
        $query = 'SELECT d.id, d.first_name, d.last_name, d.occupation, d.date_of_birth 
        FROM directors as d
        WHERE id = :id';

        return $this->executePrepareStatement($query, $did);    
    }

    public function fetchBusinessRecords(){
        $query = 'SELECT b.id, b.name, b.registered_address, b.registration_date, b.registration_number 
        FROM businesses as b';
        
        return $this->executePrepareStatement($query);    
    }

    public function fetchSingleBusinessRecord($bid){
        $query = 'SELECT b.id, b.name, b.registered_address, b.registration_date, b.registration_number 
        FROM businesses as b
        WHERE id = :id';

        return $this->executePrepareStatement($query, $bid);    
    }

    public function fetchBusinessesRegisteredInYear($year){
        if(isset($year)){
            $query = 'SELECT b.id, b.name, b.registered_address, b.registration_date, b.registration_number 
                FROM businesses as b
                WHERE YEAR(b.registration_date) = :id';

            return $this->executePrepareStatement($query, $year);
        }
    }

    public function fetchLast100Records(){
        $query = 'SELECT d.id, d.first_name, d.last_name, d.occupation, d.date_of_birth 
        FROM directors as d ORDER BY id DESC LIMIT 100';

        return $this->executePrepareStatement($query);    
    }

    public function fetchBusinessNameWithDirectorFullName(){
        $query = 'SELECT d.first_name, d.last_name, b.name
        FROM director_businesses as db 
        JOIN directors as d ON (db.director_id = d.id)
        JOIN businesses as b ON (db.business_id = b.id)';

        return $this->executePrepareStatement($query);    
    }

    public function executePrepareStatement($query, $id = ''){
        if(isset($query) && !empty($query) && $query != ''){
            try {
                $st = $this->pdo->prepare($query);
                if($id != ''){
                    // Bind the parameter ':id' with the provided value ($id)
                    $st->bindParam(':id', $id, PDO::PARAM_INT);
                }
                $st->execute();
    
                return $returnArr = $st->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return [];
            }
        }
    }
}