<?php
require_once '../config.php';
require_once '../models/RendezVous.php';

class RendezVousController
{
    private $rdv;
    private $errors;

    public function __construct(){
        $this->rdv = new RendezVous();
    }

    public function deleteRdv($arr){
        foreach ($arr as $v){
            $this->rdv->delete($v);
        }
    }

    public function getErrors(){
        return $this->errors;
    }

    private function validDate($date){
        // Date is valid if after now
        global $date_format;
        $ts = strtotime($date);
        $year = date('Y', $ts);
        $now = date($date_format);
        $result = $ts >= $now;
        // And if the week day is not saturday or sunday
        $result = $result && date('N',$ts) < 6;
        // And is not a public holiday
        $result = $result && !in_array(date($date_format, $ts), $this->getClosedDay($year));
        return $result;
    }

    private function validTime($time){
        global $hours;
            $time = strtotime($time);
            $result = ($time >= $hours['morning_open'] && $time <= $hours['morning_close']);
            $result = $result || ($time >= $hours['afternoon_open'] && $time <= $hours['afternoon_close']);
            return $result;
    }

    private function getClosedDay($year = null){
        global $date_format;
        if(is_null($year)){
            $easter_day = date('j', easter_date());
            $easter_month = date('n', easter_date());
            $easter_year = date('Y', easter_date());
        } else {
            $easter_day = date('j', easter_date($year));
            $easter_month = date('n', easter_date($year));
            $easter_year = date('Y', easter_date($year));
        }
        return [
            'first_day' => date($date_format, mktime(0,0,0,1,1,$easter_year)),
            'easter_monday' => date($date_format, mktime(0,0,0,$easter_month, $easter_day + 1, $easter_year)),
            'ascent' => date($date_format, mktime(0, 0, 0, $easter_month, $easter_day + 39, $easter_year )),
            'pentecost_monday' => date($date_format, mktime(0, 0, 0, $easter_month, $easter_day + 50, $easter_year)),
            'workers_day' => date($date_format, mktime(0,0,0,5,1,$easter_year)),
            'national_day' => date($date_format, mktime(0, 0, 0, 7, 14, $easter_year)),
            'assumption' => date($date_format, mktime(0, 0, 0, 8, 15, $easter_year)),
            'christmas' => date($date_format, mktime(0, 0, 0, 12, 25, $easter_year))
        ];
    }

    public function validateRdv(){
        // 1st, test if doctor & patient exist
        if(empty($_POST['doc'])){
            $this->errors['doc'] = 'Veuillez choisir un médecin';
        } elseif (!filter_var($_POST['doc'],FILTER_VALIDATE_INT)){
            $this->errors['doc'] = 'Veuillez choisir un médecin valide';
        } else {
            $this->rdv->doctor = $_POST['doc'];
        }
        if(empty($_POST['pat'])){
            $this->errors['pat'] = 'Veuillez choisir un patient';
        } elseif(!filter_var($_POST['pat'], FILTER_VALIDATE_INT)){
            $this->errors['pat'] = 'Veuillez choisir un patient valide';
        } else {
            $this->rdv->patient = $_POST['pat'];
        }
        // then test if $_POST date is a valid date
        if(empty($_POST['date'])){
            $this->errors['date'] = 'Veuillez rentrer une date';
        } elseif (!$this->validDate($_POST['date'])){
            $this->errors['date'] = 'Veuillez rentrer une date valide';
        } else {
            $this->rdv->date = $_POST['date'];
        }
        // Then the hours
        if (empty($_POST['start'])) {
            $this->errors['start'] = 'Veuillez renseigner une heure';
        } elseif (!$this->validTime($_POST['start'])) {
            $this->errors['start'] = 'Veuillez renseigner une heure valide';
        } else {
            $this->rdv->start = $_POST['start'];
        }
        if (empty($_POST['end'])) {
            $this->errors['start'] = 'Veuillez renseigner une heure';
        } elseif (!$this->validTime($_POST['end']) || strtotime($_POST['start']) > strtotime($_POST['end'])) {
            $this->errors['end'] = 'Veuillez renseigner une heure valide';
        } else {
            $this->rdv->end = $_POST['end'];
        }
        // Now verify
        if (empty($this->errors)) {
            if ($this->rdv->doctorHasRendezVous()) {
                $errors['doc_already_rdv'] = 'Le médecin a déjà un rendez-vous';
            }
            if ($this->rdv->patientHasRendezVous()) {
                $errors['pat_already_rdv'] = 'Le patient a déjà un rendez-vous';
            }
        }
        if (empty($this->errors)) {
            $result = $this->rdv->insert();
        } else {
            $result = false;
        }
        return $result;
    }
}