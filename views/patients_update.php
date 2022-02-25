<?php
require_once '../config.php';
require_once '../models/patients.php';
require_once '../controllers/PatientsController.php';

// Create a temp Speciality, call the getSpecialities method then unset the var

$pat = new Patients();
$ctrl = new PatientsController();
// If no form sent
if (!isset($_POST['submit'])) {
    $action = 'select';
} else {
    // If we select a patient
    if ($_POST['submit'] == 'Modifier') {
        // $action is update if $_POST['patients'] is an id, else select
        $action = ($_POST['patients'] > 0) ? 'update' : 'select';
        $id = $_POST['patients'];
    }
    // If we valid the update form
    if ($_POST['submit'] == 'Valider') {
        // If datas are not good we reload the form update with the errors
        if (!$ctrl->validateUpdatePatient()) {
            $error = $ctrl->getErrors();
            $action = 'update';
            // If update is made, print a success message
        } else {
            $action = 'ok';
        }
    }
}
// if we haven't select the patient
if ($action == 'select') {
    $patients = $pat->getOnlyName();
} elseif ($action == 'update') {
    if (!isset($current)) {
        $current = $pat->getPatientById($id);
    }
}

$page_title = 'Mettre à jour un patient';
$actif = 'Patients';
include_once 'helpers/head.php';
include_once 'helpers/header.php';
?>

<?php if ($action == 'select'): ?>
    <form method="POST">
        <ul class="list-group">
            <?php foreach ($patients as $patient): ?>
                <li class="list-group-item">
                    <input name="patients" type="radio" class="form-check-input me-1" value="<?= $patient['id'] ?>"/>
                    <?= $patient['name'] ?>
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
            <div class="col-1 my-2">
                <input type="text" name="id" hidden class="form-input" value="<?= $current['id'] ?>"/>
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