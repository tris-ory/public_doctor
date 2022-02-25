<?php
require_once '../config.php';
require_once '../models/doctors.php';
require_once '../controllers/DoctorsController.php';
require_once '../models/speciality.php';


// Create a temp Speciality, call the getSpecialities method then unset the var
$s = new Speciality();
$specs = $s->getSpecialities();
unset($s);

if (!empty($_POST)) {
    $ctrl = new DoctorsController();
    $ctrl->validateNewDoctor();
    $error = $ctrl->getErrors();
}

$page_title = 'Enregistrer un nouveau médecin';
$actif = 'Médecins';
include_once 'helpers/head.php';
include_once 'helpers/header.php';

?>
    <form method="POST" class="container">
        <fieldset class="row">
            <legend class="col-12">&Eacute;tat civil</legend>
            <div class="col-4">
                <label for="lastname" class="form-label">Nom&nbsp;: </label>
                <input type="text" name="lastname" id="lastname" class="form-control"/>
                <span class="text-danger"><?= empty($error['lastname']) ? '' : $error['lastname'] ?></span>
            </div>
            <div class="col-4">
                <label for="firstname" class="form-label">Prénom&nbsp;: </label>
                <input type="text" name="firstname" id="firstname" class="form-control"/>
                <span class="text-danger"><?= empty($error['firstname']) ? '' : $error['firstname'] ?></span>
            </div>
        </fieldset>
        <fieldset class="row">
            <legend class="col-12">Contact&nbsp;:</legend>
            <div class="col-5">
                <label for="address" class="form-label">Adresse&nbsp;:</label>
                <input type="text" name="address" id="address" class="form-control"/>
                <span class="text-danger"><?= empty($error['address']) ? '' : $error['address'] ?></span>
            </div>
            <div class="col-2">
                <label for="zipcode" class="form-label">Code postal&nbsp;:</label>
                <input type="text" name="zipcode" id="zipcode" class="form-control"/>
                <span class="text-danger"><?= empty($error['zipcode']) ? '' : $error['zipcode'] ?></span>
            </div>
            <div class="col-5">
                <label for="city" class="form-label">Ville&nbsp;:</label>
                <input type="text" name="city" id="city" class="form-control"/>
                <span class="text-danger"><?= empty($error['city']) ? '' : $error['city'] ?></span>
            </div>
            <div class="col-5">
                <label for="phone" class="form-label">Téléphone&nbsp;:</label>
                <input type="text" name="phone" id="phone" class="form-control"/>
                <span class="text-danger"><?= empty($error['phone']) ? '' : $error['phone'] ?></span>
            </div>
            <div class="col-5">
                <label for="phone2" class="form-label">Téléphone alternatif&nbsp;:</label>
                <input type="text" name="phone2" id="phone2" class="form-control"/>
                <span class="text-danger"><?= empty($error['phone2']) ? '' : $error['phone2'] ?></span>
            </div>
            <div class="col-5">
                <label for="mail">Adresse mail&nbsp;:</label>
                <input type="email" name="mail" id="mail" class="form-control"/>
                <span class="text-danger"><?= empty($error['mail']) ? '' : $error['mail'] ?></span>
            </div>
        </fieldset>
        <fieldset class="row">
            <div class="col-4 my-2">
                <select name="spec_id" id="spec_id" class="form-select">
                    <option selected>--- Sélectionnez une spécialité ---</option>
                    <?php foreach ($specs as $spec): ?>
                        <option value=<?= $spec['id'] ?>><?= $spec['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </fieldset>
        <fieldset class="row">
            <div class="col-1">
                <input class="btn btn-primary" name="submit" type="submit" value="Envoyer"/>
            </div>
        </fieldset>
    </form>
<?php
include_once 'helpers/footer.php';