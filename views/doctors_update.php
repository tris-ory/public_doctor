<?php
require_once '../config.php';
require_once '../models/doctors.php';
require_once '../controllers/DoctorsController.php';
require_once '../models/speciality.php';

$page_title = 'Mettre à jour la fiche médecin';
$actif = 'Médecins';
include_once 'helpers/head.php';
include_once 'helpers/header.php';



// Create a temp Speciality, call the getSpecialities method then unset the var
$s = new Speciality();
$specs = $s->getSpecialities();
unset($s);
$doc = new Doctors();
$ctrl = new DoctorsController();
// If no form sent
if (!isset($_POST['submit'])) {
    $action = 'select';
} else {
    // If we select a doctor
    if ($_POST['submit'] == 'Modifier') {
        // $action is update if $_POST['doctors'] is an id, else select
        $action = ($_POST['doctors'] > 0) ? 'update' : 'select';
        $id = $_POST['doctors'];
    }
    // If we valid the update form
    if($_POST['submit'] == 'Valider'){
        // $current is an array with all infos for the current user
        $id=$_POST['id'];
        $current = $doc->getDoctorById($_POST['id']);
        // If datas are not good we reload the form update with the errors
        if (!$ctrl->validateUpdateDoctor($current)) {
            $error = $ctrl->getErrors();
            $action = 'update';
        // If update is made, print a success message
        } else {
            $action = 'ok';
        }
    }
}
// if we haven't select the doctor
if ($action == 'select') {
    $doctors = $doc->getOnlyName($id);
} elseif($action == 'update'){
    if(!isset($current)){
        $current = $doc->getDoctorById($id);
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Hello, world!</title>
</head>
<body>
<div class="container">
    <?php if ($action == 'select'): ?>
        <form method="POST">
            <ul class="list-group">
                <?php foreach($doctors as $doctor): ?>
                <li class="list-group-item">
                    <input name="doctors" type="radio" class="form-check-input me-1" value="<?= $doctor['id'] ?>" />
                    <?= $doctor['name'] ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <input type="submit" name="submit" value="Modifier"/>
        </form>
    <?php elseif ($action == 'update'): ?>
        <form method="POST">
            <fieldset class="row">
                <legend class="col-12">&Eacute;tat civil</legend>
                <div class="col-4">
                    <label for="lastname" class="form-label">Nom&nbsp;: </label>
                    <input type="text" name="lastname" id="lastname" class="form-control"
                           placeholder="<?= $current['lastname'] ?>"/>
                    <span class="text-danger"><?= empty($error['lastname']) ? '' : $error['lastname'] ?></span>
                </div>
                <div class="col-4">
                    <label for="firstname" class="form-label">Prénom&nbsp;: </label>
                    <input type="text" name="firstname" id="firstname" class="form-control"
                           placeholder="<?= $current['firstname'] ?>"/>
                    <span class="text-danger"><?= empty($error['firstname']) ? '' : $error['firstname'] ?></span>
                </div>
            </fieldset>
            <fieldset class="row">
                <legend class="col-12">Contact&nbsp;:</legend>
                <div class="col-5">
                    <label for="address" class="form-label">Adresse&nbsp;:</label>
                    <input type="text" name="address" id="address" class="form-control"
                           placeholder="<?= $current['address'] ?>"/>
                    <span class="text-danger"><?= empty($error['address']) ? '' : $error['address'] ?></span>
                </div>
                <div class="col-2">
                    <label for="zipcode" class="form-label">Code postal&nbsp;:</label>
                    <input type="text" name="zipcode" id="zipcode" class="form-control"
                           placeholder="<?= $current['zipcode'] ?>"/>
                    <span class="text-danger"><?= empty($error['zipcode']) ? '' : $error['zipcode'] ?></span>
                </div>
                <div class="col-5">
                    <label for="city" class="form-label">Ville&nbsp;:</label>
                    <input type="text" name="city" id="city" class="form-control"
                           placeholder="<?= $current['city'] ?>"/>
                    <span class="text-danger"><?= empty($error['city']) ? '' : $error['city'] ?></span>
                </div>
                <div class="col-5">
                    <label for="phone" class="form-label">Téléphone&nbsp;:</label>
                    <input type="text" name="phone" id="phone" class="form-control"
                           placeholder="<?= $current['phone'] ?>"/>
                    <span class="text-danger"><?= empty($error['phone']) ? '' : $error['phone'] ?></span>
                </div>
                <div class="col-5">
                    <label for="mail">Adresse mail&nbsp;:</label>
                    <input type="email" name="mail" id="mail" class="form-control"
                           placeholder="<?= $current['mail'] ?>"/>
                    <span class="text-danger"><?= empty($error['mail']) ? '' : $error['mail'] ?></span>
                </div>
            </fieldset>
            <fieldset class="row">
                <div class="col-4 my-2">
                    <select name="spec_id" id="spec_id" class="form-select">
                        <option>--- Sélectionnez une spécialité ---</option>
                        <?php foreach ($specs as $spec): ?>
                            <option value=<?= $spec['id'] ?> <?= $current['spec_id'] == $spec['id'] ? 'selected' : '' ?>><?= $spec['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-1 my-2">
                    <input type="text" name="id" hidden class="form-input" value="<?= $current['doc_id']?>"/>
                </div>
            </fieldset>
            <fieldset class="row">
                <div class="col-1">
                    <input class="btn btn-primary" name="submit" type="submit" value="Valider"/>
                </div>
            </fieldset>
        </form>
    <?php elseif ($action == 'ok'): ?>
    <p class="h1">La mise à jour s'est bien déroulée</p>
    <?php endif;

include_once 'helpers/footer.php';