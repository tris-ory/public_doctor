<?php
include_once 'database.php';
include_once 'RendezVous.php';

class Doctors extends Database
{
    private $db;
    public $id = "";
    public $firstname = "";
    public $lastname = "";
    public $address = "";
    public $zipcode = "";
    public $city = "";
    public $phone = "";
    public $phone2 = "";
    public $mail = "";
    public $spec_id = "";

    public function __construct()
    {
        $db = Database::getInstance();
        $this->db = $db->getDbh();
    }

    /**
     *
     * @return bool
     * This method try to insert a new doctor, then return if it work or not
     */
    public function createDoctors()
    {
        $request = 'INSERT INTO doctors (firstname, lastname, address,city, zipcode, phone,mail,spec_id) 
                    VALUES (:firstname, :lastname, :address, :city,:zipcode, :phone,:mail,:spec_id)';
        $statement = $this->db->prepare($request);
        $statement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $statement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $statement->bindValue(':address', $this->address, PDO::PARAM_STR);
        $statement->bindValue(':zipcode', $this->zipcode, PDO::PARAM_STR);
        $statement->bindValue(':city', $this->city, PDO::PARAM_STR);
        $statement->bindValue(':phone', $this->phone, PDO::PARAM_STR);
        $statement->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $statement->bindValue(':spec_id', $this->spec_id, PDO::PARAM_INT);
        return $statement->execute();
    }

    /**
     * @param mixed $id
     * @return array
     * return the doctor with the id $id if not null, the list of all doctors else
     */
    public function getDoctorById($id){
        $request = 'SELECT `doctors`.`id` AS `doc_id`, `firstname`, `lastname`, `address`, `city`, `zipcode`, `phone`,';
        $request .= ' `mail`, `speciality`.`name` AS `spec`, `spec_id`';
        $request .=' FROM `doctors` JOIN `speciality` ON `spec_id` = `speciality`.`id`';
        $request .= ' WHERE `doctors`.`id` = :id';
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listDoctors()
    {
            $request = 'SELECT `doctors`.`id` AS `doc_id`, `firstname`, `lastname`, `address`, `city`, `zipcode`, `phone`, `mail`, `speciality`.`name` AS `spec`, `spec_id` FROM `doctors`JOIN `speciality` ON `spec_id` = `speciality`.`id`';
            return $this->db
                ->query($request)
                ->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * @param $spec
     * @return array
     * Return all doctors with the $spec speciality
     */
    public function getBySpeciality($spec)
    {
        $request = 'SELECT `id`, `firstname`, `lastname`, `address`, `zipcode`, `city`, `phone`, `mail`, `spec_id` FROM `doctors` WHERE `spec_id` = :spec';
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':spec', $spec, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @param $id
     * @return bool
     * Deletes all rdv for the doctor $id, then delete the doctor
     */
    public function delDoctor($id)
    {
        $rdv = new RendezVous();
        $result = $rdv->deleteFromDoctor($id);
        if ($result) {
            $request = 'DELETE FROM `doctors` WHERE `id` = :id';
            $stmt = $this->db->prepare($request);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();
        }
        return $result;
    }

    public function getOnlyName($id){
        $request = 'SELECT `id`, CONCAT_WS(" ", UPPER(`lastname`), `firstname`) AS `name` FROM `doctors` WHERE `id` = :id';
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function getAllNames(){
        $request = 'SELECT `id`, CONCAT_WS(" ", UPPER(`lastname`), `firstname`) AS `name` FROM `doctors`';
        return $this->db
            ->query($request)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateDoctors(){
        $request = 'UPDATE `doctors` SET';
        $request .= ' `lastname` = :lastname,';
        $request .= ' `firstname` = :firstname,';
        $request .= ' `address` = :address,';
        $request .= ' `zipcode` = :zipcode,';
        $request .= ' `city` = :city,';
        $request .= ' `mail` = :mail,';
        $request .= ' `spec_id` = :spec_id';
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $stmt->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $stmt->bindValue(':address', $this->address, PDO::PARAM_STR);
        $stmt->bindValue(':zipcode', $this->zipcode, PDO::PARAM_STR);
        $stmt->bindValue(':city', $this->city, PDO::PARAM_STR);
        $stmt->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $stmt->bindValue(':spec_id', $this->spec_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}