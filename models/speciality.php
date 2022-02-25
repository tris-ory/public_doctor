<?php
include_once 'database.php';

class Speciality extends Database
{
    private $db;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->db = $db->getDbh();
    }

    public function createSpeciality()
    {
        $request = 'INSERT INTO `doctors` (`name`) VALUES (:name)';
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSpecialities($id = null)
    {
        $request = 'SELECT `id`, `name` FROM `speciality`';
        if (is_null($id)) {
            $result = $this->db->query($request)->fetchAll();
        } else {
            $request .= ' WHERE `id` = :id';
            $stmt = $this->db->prepare($request);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();
        }
        return $result;
    }

    public function getSpecialityByName($name)
    {
        $stmt = $this->db->prepare('SELECT `id`, `name` FROM `speciality` WHERE `name` = :name');
        $stmt->bindValue(':name', $name);
        return $stmt->execute();
    }
}