<?php
require_once '../models/doctors.php';
require_once '../models/RendezVous.php';
require_once '../controllers/DoctorsController.php';

$doc = new Doctors();
$ctrl = new DoctorsController();
if (!empty($_POST['del'])) {
    $ctrl->delDoctors($_POST['del']);
}
$doctors = $doc->listDoctors();

$page_title = 'Liste des médecins';
$actif = 'Médecins';
include_once 'helpers/head.php';
include_once 'helpers/header.php';
?>
    <form method="POST" class="form-check">
        <table class="table table-stripped">
            <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Code postal</th>
                <th>Ville</th>
                <th>Téléphone</th>
                <th>Mail</th>
                <th>Spécialité</th>
                <th>Supprimer&nbsp;?</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($doctors as $doctor): ?>
                <tr>
                    <td><?= $doctor['firstname'] ?></td>
                    <td><?= $doctor['lastname'] ?></td>
                    <td><?= $doctor['address'] ?></td>
                    <td><?= $doctor['zipcode'] ?></td>
                    <td><?= $doctor['city'] ?></td>
                    <td><?= $doctor['phone'] ?></td>
                    <td><?= $doctor['mail'] ?></td>
                    <td><?= $doctor['spec'] ?></td>
                    <td><input class="form-check-input" type="checkbox" name="del[]" value="<?= $doctor['doc_id'] ?>"/>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <input type="submit" class="btn btn-primary" value="Supprimer sélectionnés"/>
    </form>
<?php
include_once 'helpers/footer.php';