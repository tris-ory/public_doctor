<?php
include_once '../config.php';
require_once '../models/patients.php';


class PatientsController
{
    private $patients;
    private $errors;

    public function __construct()
    {
        $this->patients = new Patients();
    }

    public function validateNewPatient()
    {
        global $RX_NAME, $RX_ADDRESS, $RX_ZIP, $RX_PHONE;
        $this->errors = [];
        if (isset($_POST['submit'])) {
            if (!empty($_POST['firstname'])) {
                if (preg_match($RX_NAME, $_POST['firstname'])) {
                    $this->patients->firstname = $_POST['firstname'];
                } else {
                    $this->errors['firstname'] = "veuillez saisir un prénom valide";
                }
            } else {
                $this->errors['firstname'] = "veuillez saisir votre prénom";
            }
            if (!empty($_POST['lastname'])) {
                if (preg_match($RX_NAME, $_POST['lastname'])) {
                    $this->patients->lastname = $_POST['lastname'];
                } else {
                    $this->errors['lastname'] = "veuillez saisir un nom valide";
                }
            } else {
                $this->errors['lastname'] = "veuillez saisir votre nom";
            }
            if (!empty($_POST['address'])) {
                if (preg_match($RX_ADDRESS, $_POST['address'])) {
                    $this->patients->address = $_POST['address'];
                } else {
                    $this->errors['address'] = "veuillez saisir une adresse valide";
                }
            } else {
                $this->errors['address'] = "veuillez saisir une adresse";
            }
            if (!empty($_POST['zipcode'])) {
                if (preg_match($RX_ZIP, $_POST['zipcode'])) {
                    $this->patients->zipcode = $_POST['zipcode'];
                } else {
                    $this->errors['zipcode'] = "Veuillez saisir un code postal valide";
                }
            } else {
                $this->errors['zipcode'] = "Veuillez saisir un code postal";
            }
            if (!empty($_POST['city'])) {
                if (preg_match($RX_NAME, $_POST['city'])) {
                    $this->patients->city = $_POST['city'];
                } else {
                    $this->errors['city'] = "Veuillez saisir une ville valide";
                }
            } else {
                $this->errors['city'] = "veuillez saisir votre ville";
            }
            if (!empty($_POST['phone'])) {
                if (preg_match($RX_PHONE, $_POST['phone'])) {
                    $this->patients->phone = $_POST['phone'];
                } else {
                    $this->errors['phone'] = "Veuillez saisir un numéro téléphone valide";
                }
            } else {
                $this->errors['phone'] = "veuillez saisir votre numéro de téléphone";
            }
            if (!empty($_POST['mail'])) {
                if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                    $this->patients->mail = $_POST['mail'];
                } else {
                    $this->errors['mail'] = "Veuillez saisir une adresse email valide";
                }
            } else {
                $this->errors['mail'] = "veuillez saisir votre adresse email";
            }
            if (empty($this->errors)) {
                $result = $this->patients->createPatients();
            } else {
                $result = false;
            }
             return $result;        }
    }
    public function getErrors()
    {
        return $this->errors;
    }
    public function validateUpdatePatient(){
        global $RX_NAME, $RX_ADDRESS, $RX_ZIP, $RX_PHONE;
        $this->errors = [];
        $result = true;
        $this->patients->beginTransaction();
        $id=$_POST['id'];
        foreach ($_POST as $param => $value){
            if(!empty($value)){
                switch ($param){
                    case 'firstname':
                        if (preg_match($RX_NAME, $value)) {
                            $result = $result && $this->patients->updatePatient($id, $param, $value);
                        } else {
                            $this->errors['firstname'] = "veuillez saisir un prénom valide";
                            $result = false;
                        }
                        break;
                    case 'lastname':
                        if (preg_match($RX_NAME, $value)) {
                            $result = $result && $this->patients->updatePatient($id, $param, $value);
                        } else {
                            $this->errors['lastname'] = "veuillez saisir un nom valide";
                            $result = false;
                        }
                        break;
                    case 'address':
                        if (preg_match($RX_ADDRESS, $value)) {
                            $result = $result && $this->patients->updatePatient($id, $param, $value);
                        } else {
                            $this->errors['address'] = "veuillez saisir une adresse valide";
                            $result = false;
                        }
                        break;
                    case 'zipcode':
                        if (preg_match($RX_ZIP, $value)) {
                            $result = $result && $this->patients->updatePatient($id, $param, $value);
                        } else {
                            $this->errors['zipcode'] = "veuillez saisir un code postal valide";
                            $result = false;
                        }
                        break;
                    case 'city':
                        if (preg_match($RX_NAME, $value)) {
                            $result = $result && $this->patients->updatePatient($id, $param, $value);
                        } else {
                            $this->errors['city'] = "veuillez saisir un nom de ville valide";
                            $result = false;
                        }
                        break;
                    case 'phone':
                        if (preg_match($RX_PHONE, $value)) {
                            $result = $result && $this->patients->updatePatient($id, $param, $value);
                        } else {
                            $this->errors['phone'] = "veuillez saisir un numéro de téléphone valide";
                            $result = false;
                        }
                        break;
                    case 'mail':
                        if(filter_var($value, FILTER_VALIDATE_EMAIL)){
                            $result = $result && $this->patients->updatePatient($id, $param, $value);
                        } else {
                            $this->errors['mail'] = "veuillez saisir un mail valide";
                            $result = false;
                        }
                        break;
                    default:
                }
            }
        }

        if($result){
            $this->patients->commitTransaction();
        } else {
            $this->patients->rollbackTransaction();
        }
        return $result;

    }
    public function delPatients($ids)
    {
        $result = true;
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $exists = $this->doctors->getPatientById($id);
                if (!(empty($exists))) {
                    $result = $result && $this->doctors->delDoctor($id);
                }
            }
        } else {
            $result = $this->doctors->delDoctor($ids);
        }
    }
}