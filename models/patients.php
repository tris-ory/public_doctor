<?php
include '../config.php';
include_once 'database.php';

class Patients extends Database
{
    private $db;
    public $firstname = "";
    public $lastname = "";
    public $address = "";
    public $zipcode = "";
    public $city = "";
    public $phone = "";
    public $phone2 = "";
    public $mail = "";

    public function __construct()
    {
        $db = Database::getInstance();
        $this->db = $db->getDbh();
    }

    public function createPatient()
    {
        $request = 'INSERT INTO `patients` (firstname, lastname, address,city, zipcode, phone,mail) 
                    VALUES (:firstname, :lastname, :address, :city,:zipcode, :phone,:mail)';
        $statement = $this->db->prepare($request);
        $statement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $statement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $statement->bindValue(':address', $this->address, PDO::PARAM_STR);
        $statement->bindValue(':zipcode', $this->zipcode, PDO::PARAM_STR);
        $statement->bindValue(':city', $this->city, PDO::PARAM_STR);
        $statement->bindValue(':phone', $this->phone, PDO::PARAM_STR);
        $statement->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        return $statement->execute();
    }

    public function getPatientById($id){
        $request = 'SELECT `id`, `firstname`, `lastname`, `address`, `city`, `zipcode`, `phone`, `mail` FROM `patients`';

        $request .= ' WHERE `id` = :id';
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listPatients()
    {
        $request = 'SELECT `id`, `firstname`, `lastname`, `address`, `city`, `zipcode`, `phone`, `mail` FROM `patients`';
        return $this->db->query($request)->fetchAll(PDO::FETCH_ASSOC);


    }

    public function updatePatient($id, $field, $value){
        $request ='UPDATE `patients` SET';
        // Use of switch for filter the parameters whe can edit
        switch($field){
            case 'firstname':
                $request .= ' `firstname`=:param';
                break;
            case 'lastname':
                $request .= ' `lastname`=:param';
                break;
            case 'address':
                $request .= ' `address`=:param';
                break;
            case 'zipcode':
                $request .= ' `zipcode`=:param';
                break;
            case 'city':
                $request .= ' `city`=:param';
                break;
            case 'phone':
                $request .= ' `phone`=:param';
                break;
            case 'mail':
                $request .= ' `mail`=:param';
                break;
            default:
                $request = false;
        }
        if($request){
            $request .= ' WHERE `id` = :id';
            $stmt = $this->db->prepare($request);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':param', $value);
            return $stmt->execute();
        }
    }

    public function getOnlyName(){
        $stmt = $this->db->query('SELECT `id`, CONCAT_WS(" ",UPPER(`lastname`), `firstname`) as `name` FROM `patients`');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllNames(){
        $request = 'SELECT `id`, CONCAT_WS(" ", UPPER(`lastname`), `firstname`) AS `name` FROM `patients`';
        return $this->db
            ->query($request)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function beginTransaction()
    {
        $this->db->beginTransaction();
    }
    public function rollbackTransaction()
    {
        $this->db->rollBack();
        return $this->db->errorInfo();
    }
    public function commitTransaction()
    {
        $this->db->commit();
    }
}