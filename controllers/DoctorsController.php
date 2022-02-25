<?php
include_once '../config.php';
require_once '../models/doctors.php';

class DoctorsController
{
    private $doctors;
    private $errors;

    public function __construct()
    {
        $this->doctors = new Doctors();
    }

    public function delDoctors($ids)
    {
        $result = true;
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $exists = $this->doctors->getDoctorById($id);
                if (!(empty($exists))) {
                    $result = $result && $this->doctors->delDoctor($id);
                }
            }
        } else {
            $result = $this->doctors->delDoctor($ids);
        }
    }

    public function validateNewDoctor()
    {
        global $RX_NAME, $RX_ADDRESS, $RX_ZIP, $RX_PHONE;
        $this->errors = [];
        if (isset($_POST['submit'])) {
            if (!empty($_POST['firstname'])) {
                if (preg_match($RX_NAME, $_POST['firstname'])) {
                    $this->doctors->firstname = $_POST['firstname'];
                } else {
                    $this->errors['firstname'] = "veuillez saisir un prénom valide";
                }
            } else {
                $this->errors['firstname'] = "veuillez saisir votre prénom";
            }
            if (!empty($_POST['lastname'])) {
                if (preg_match($RX_NAME, $_POST['lastname'])) {
                    $this->doctors->lastname = $_POST['lastname'];
                } else {
                    $this->errors['lastname'] = "veuillez saisir un nom valide";
                }
            } else {
                $this->errors['lastname'] = "veuillez saisir votre nom";
            }
            if (!empty($_POST['address'])) {
                if (preg_match($RX_ADDRESS, $_POST['address'])) {
                    $this->doctors->address = $_POST['address'];
                } else {
                    $this->errors['address'] = "veuillez saisir une adresse valide";
                }
            } else {
                $this->errors['address'] = "veuillez saisir une adresse";
            }
            if (!empty($_POST['zipcode'])) {
                if (preg_match($RX_ZIP, $_POST['zipcode'])) {
                    $this->doctors->zipcode = $_POST['zipcode'];
                } else {
                    $this->errors['zipcode'] = "Veuillez saisir un code postal valide";
                }
            } else {
                $this->errors['zipcode'] = "Veuillez saisir un code postal";
            }
            if (!empty($_POST['city'])) {
                if (preg_match($RX_NAME, $_POST['city'])) {
                    $this->doctors->city = $_POST['city'];
                } else {
                    $this->errors['city'] = "Veuillez saisir une ville valide";
                }
            } else {
                $this->errors['city'] = "veuillez saisir votre ville";
            }
            if (!empty($_POST['phone'])) {
                if (preg_match($RX_PHONE, $_POST['phone'])) {
                    $this->doctors->phone = $_POST['phone'];
                } else {
                    $this->errors['phone'] = "Veuillez saisir un numéro téléphone valide";
                }
            } else {
                $this->errors['phone'] = "veuillez saisir votre numéro de téléphone";
            }
            if (!empty($_POST['mail'])) {
                if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                    $this->doctors->mail = $_POST['mail'];
                } else {
                    $this->errors['mail'] = "Veuillez saisir une adresse email valide";
                }
            } else {
                $this->errors['mail'] = "veuillez saisir votre adresse email";
            }
            if (!empty($_POST['spec_id'])) {
                if (filter_var($_POST['spec_id'], FILTER_VALIDATE_INT)) {
                    $this->doctors->spec_id = $_POST['spec_id'];
                } else {
                    $this->errors['spec_id'] = "Veuillez choisir une spécialité valide";
                }
            } else {
                $this->errors['spec_id'] = "veuillez choisir une spécialité";
            }
            if (empty($this->errors)) {
                $result = $this->doctors->createDoctors();
            } else {
                $result = false;
            }
            return $result;
        }
    }

    public function validateUpdateDoctor($doc){
        global $RX_NAME, $RX_ADDRESS, $RX_ZIP, $RX_PHONE;
        $this->errors = [];
        if (!empty($_POST['firstname'])) {
            if (preg_match($RX_NAME, $_POST['firstname'])) {
                $this->doctors->firstname = $_POST['firstname'];
            } else {
                $this->errors['firstname'] = "veuillez saisir un prénom valide";
            }
        } else {
            $this->doctors->firstname = $doc['firstname'];
        }
        if (!empty($_POST['lastname'])) {
            if (preg_match($RX_NAME, $_POST['lastname'])) {
                $this->doctors->lastname = $_POST['lastname'];
            } else {
                $this->errors->lastname = "veuillez saisir un nom valide";
            }
        } else {
            $this->doctors->lastname = $doc['lastname'];
        }
        if (!empty($_POST['address'])) {
            if (preg_match($RX_ADDRESS, $_POST['address'])) {
                $this->doctors->address = $_POST['address'];
            } else {
                $this->errors->address = "veuillez saisir une adresse valide";
            }
        } else {
            $this->doctors->address = $doc['address'];
        }
        if (!empty($_POST['zipcode'])) {
            if (preg_match($RX_ZIP, $_POST['zipcode'])) {
                $this->doctors->zipcode = $_POST['zipcode'];
            } else {
                $this->errors['zipcode'] = "Veuillez saisir un code postal valide";
            }
        } else {
            $this->doctors->zipcode = $doc['zipcode'];
        }
        if (!empty($_POST['city'])) {
            if (preg_match($RX_NAME, $_POST['city'])) {
                $this->doctors->city = $_POST['city'];
            } else {
                $this->errors['city'] = "Veuillez saisir une ville valide";
            }
        } else {
            $this->doctors->city = $doc['city'];
        }
        if (!empty($_POST['phone'])) {
            if (preg_match($RX_PHONE, $_POST['phone'])) {
                $this->doctors->phone = $_POST['phone'];
            } else {
                $this->errors['phone'] = "Veuillez saisir un numéro téléphone valide";
            }
        } else {
            $this->doctors->phone = $doc['phone'];
        }
        if (!empty($_POST['mail'])) {
            if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $this->doctors->mail = $_POST['mail'];
            } else {
                $this->errors['mail'] = "Veuillez saisir une adresse email valide";
            }
        } else {
            $this->doctors->mail = $doc['mail'];
        }
        if (!empty($_POST['spec_id'])) {
            if (filter_var($_POST['spec_id'], FILTER_VALIDATE_INT)) {
                $this->doctors->spec_id = $_POST['spec_id'];
            } else {
                $this->errors['spec_id'] = "Veuillez choisir une spécialité valide";
            }
        } else {
            $this->doctors->spec_id = $doc['spec_id'];
        }
        if (empty($this->errors)) {
            $result = $this->doctors->updateDoctors();
        } else {
            $result = false;
        }
        return $result;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}