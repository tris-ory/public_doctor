<?php
require_once 'database.php';
require_once 'Patients.php';
require_once 'Doctors.php';


class RendezVous extends Database
{
    private $db;
    public $doctor = 0;
    public $patient = 0;
    public $date;
    public $start;
    public $end;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->db = $db->getDbh();
    }

    public function insert(){
        $request = 'INSERT INTO `rendezvous` (`date`, `start_time`, `end_time`, `doctor_id`, `patient_id`)  VALUES (:date, :start_time, :end_time, :doctor_id, :patient_id)';
        $stmt = $this->db->prepare($request);
        $stmt->bindValue(':date', $this->date);
        $stmt->bindValue(':start_time', $this->start);
        $stmt->bindValue(':end_time', $this->end);
        $stmt->bindValue(':doctor_id', $this->doctor);
        $stmt->bindValue(':patient_id', $this->patient);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM `rendezvous` WHERE `id` = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteFromDoctor($id)
    {
        $stmt = $this->db->prepare('DELETE FROM `rendezvous` WHERE `doctor_id` = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteFromPatient($id)
    {
        $stmt = $this->db->prepare('DELETE FROM `rendezvous` WHERE `patient_id` = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getByDoctor($id)
    {
        $request = 'SELECT CONCAT_WS(" ",`doctors`.`lastname`, `doctors`.`firstname`) AS `doc_name`,';
        $request .= ' CONCAT_WS(" ",`patients`.`lastname`, `patients`.`firstname`) AS `pat_name`,';
        $request .= '`doctors`.`id` AS `doc_id` `patients`.`id` AS `pat_id`, `date`, `start_time`, `end_time`';
        $request .= ' FROM `rendezvous`';
        $request .= ' INNER JOIN `doctors` ON `doctors`.`id` = `doctor_id`';
        $request .= ' INNER JOIN `patients` ON `patients`.`id` = `patient_id`';
        $request .= ' WHERE `doctor_id` = :id';

        $stmt = $this->db->prepare($request);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByPatient($id)
    {
        $request = 'SELECT CONCAT_WS(" ",`doctors`.`lastname`, `doctors`.`firstname`) AS `doc_name`,';
        $request .= ' CONCAT_WS(" ",`patients`.`lastname`, `patients`.`firstname`) AS `pat_name`,';
        $request .= '`doctors`.`id` AS `doc_id` `patients`.`id` AS `pat_id`, `date`, `start_time`, `end_time`';
        $request .= ' FROM `rendezvous`';
        $request .= ' INNER JOIN `doctors` ON `doctors`.`id` = `doctor_id`';
        $request .= ' INNER JOIN `patients` ON `patients`.`id` = `patient_id`';
        $request .= ' WHERE `patient_id` = :id';

        $stmt = $this->db->prepare($request);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByDoctorAndPatient($doc_id, $pat_id)
    {
        $request = 'SELECT CONCAT_WS(" ",`doctors`.`lastname`, `doctors`.`firstname`) AS `doc_name`,';
        $request .= ' CONCAT_WS(" ",`patients`.`lastname`, `patients`.`firstname`) AS `pat_name`,';
        $request .= '`doctors`.`id` AS `doc_id` `patients`.`id` AS `pat_id`, `date`, `start_time`, `end_time`';
        $request .= ' FROM `rendezvous`';
        $request .= ' INNER JOIN `doctors` ON `doctors`.`id` = `doctor_id`';
        $request .= ' INNER JOIN `patients` ON `patients`.`id` = `patient_id`';
        $request .= ' WHERE `patient_id` = :pat AND `doctor_id` = :doc';

        $stmt = $this->db->prepare($request);
        $stmt->bindParam(':pat', $pat_id, PDO::PARAM_INT);
        $stmt->bindParam(':doc', $doc_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll(){
        $request = 'SELECT `rendezvous`.`id` AS `r_id`';
        $request .= ' CONCAT_WS(" ",`doctors`.`lastname`, `doctors`.`firstname`) AS `doc_name`,';
        $request .= ' CONCAT_WS(" ",`patients`.`lastname`, `patients`.`firstname`) AS `pat_name`,';
        $request .= '`doctors`.`id` AS `doc_id` `patients`.`id` AS `pat_id`, `date`, `start_time`, `end_time`';
        $request .= ' FROM `rendezvous`';
        $request .= ' INNER JOIN `doctors` ON `doctors`.`id` = `doctor_id`';
        $request .= ' INNER JOIN `patients` ON `patients`.`id` = `patient_id`';
        return $this->db
            ->query($request)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function doctorHasRendezVous()
    {

        $request = 'SELECT COUNT(`id`) AS result FROM `rendezvous`
        WHERE `doctor_id` = :id
        AND `date` = :date
        AND ((:start BETWEEN `start_time` AND `end_time`)
        OR (:end BETWEEN `start_time` AND `end_time`)
        OR (`start_time` BETWEEN :start2 AND :end2))';
        $stmt =  $this->db->prepare($request);
        $stmt->bindValue(':id', $this->doctor);
        $stmt->bindValue(':date', $this->date);
        $stmt->bindValue(':start', $this->start);
        $stmt->bindValue(':start2', $this->start);
        $stmt->bindValue(':end', $this->end);
        $stmt->bindValue(':end2', $this->end);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result[0] > 0;
    }

    public function patientHasRendezVous()
    {
        $request = 'SELECT COUNT(`id`) AS result FROM `rendezvous`
        WHERE `patient_id` = :id
        AND `date` = :date
        AND ((:start BETWEEN `start_time` AND `end_time`)
        OR (:end BETWEEN `start_time` AND `end_time`)
        OR (`start_time` BETWEEN :start2 AND :end2))';
        $stmt =  $this->db->prepare($request);
        $stmt->bindValue(':id', $this->patient);
        $stmt->bindValue(':date', $this->date);
        $stmt->bindValue(':start', $this->start);
        $stmt->bindValue(':start2', $this->start);
        $stmt->bindValue(':end', $this->end);
        $stmt->bindValue(':end2', $this->end);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result[0] > 0;
    }
}