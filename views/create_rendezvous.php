<?php
include_once '../config.php';
include_once '../models/RendezVous.php';
include_once '../models/doctors.php';
include_once '../models/patients.php';

include_once '../controllers/RendezVousController.php';

$page_title = 'Créer un rendez-vous';
$actif = 'Rendez-vous';

$ctrl = new RendezVousController();
$doc = new Doctors();
$pat = new Patients();

$doctors = $doc->getAllNames();
$patients = $pat->getAllNames();
$error = [];

if (!empty($_POST)){
    if(!$ctrl->validateRdv()){
        $error=$ctrl->getErrors();
    }
}
include_once 'helpers/head.php';
include_once 'helpers/header.php';
if (empty($_POST) || !empty($error)):
    var_dump($_POST);
?>
<form method="POST">
    <select name="doc" class="form-select mx-3 my-3">
        <option selected>--- Médecin ---</option>
        <?php foreach ($doctors as $doctor): ?>
        <option value="<?= $doctor['id'] ?>"><?= $doctor['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <p class="text-danger"><?= empty($error['doc']) ? '' : $error['doc'] ?></p>
    <select name="pat" class="form-select">
        <option selected>--- Patient ---</option>
        <?php foreach ($patients as $patient): ?>
            <option value="<?= $patient['id'] ?>"><?= $patient['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <p class="text-danger"><?= empty($error['pat']) ? '' : $error['pat'] ?></p>
    <label for="date">Date</label>
    <input type="date" class="form-input" name="date" />
    <p class="text-danger"><?= empty($error['date']) ? '' : $error['date'] ?></p>
    <label for="start">Heure de début</label>
    <input type="time" class="form-input" name="start" />
    <p class="text-danger"><?= empty($error['start']) ? '' : $error['start'] ?></p>
    <label for="end">Heure de fin</label>
    <input type="time" class="form-input" name="end" />
    <p class="text-danger"><?= empty($error['end']) ? '' : $error['end'] ?></p>
    <p class="text-danger"><?= empty($error['doc_already_rdv']) ? '' : $error['doc_already_rdv'] ?></p>
    <p class="text-danger"><?= empty($error['pat_already_rdv']) ? '' : $error['pat_already_rdv'] ?></p>

    <input type="submit" value="Créer" />
</form>

<?php
else:
?>
    <p class="h1">Votre ajout a réussi</p>
<?php
endif;
include_once 'helpers/footer.php';