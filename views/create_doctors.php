<?php
include_once '../config.php';
include_once '../models/doctors.php';
include_once '../controllers/DoctorsController.php';
include_once '../models/speciality.php';

// Create a temp Speciality, call the getSpecialities method then unset the var
$s = new Speciality();
$specs = $s->getSpecialities();
unset($s);

if (!empty($_POST)) {
    $ctrl = new DoctorsController();
    $ctrl->validateNewDoctor();
    $error = $ctrl->getErrors();
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
            <legend col="col-12">Contact&nbsp;:</legend>
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
                <input type="mail" name="mail" id="mail" class="form-control"/>
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
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>
</html>