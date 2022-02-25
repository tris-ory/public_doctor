<?php
require_once '../models/patients.php';
require_once '../models/RendezVous.php';
require_once '../controllers/PatientsController.php';

$pat = new Patients();
$ctrl = new PatientsController();
if (!empty($_POST['del'])) {
    $ctrl->delPatients($_POST['del']);
}
$patients = $pat->listPatients();

$page_title = 'Liste des patients';
$actif = 'Patients';
include_once 'helpers/head.php';
include_once 'helpers/header.php';
?>
    <form method="POST" class="form-check">
        <table>
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
                <th>Supprimer</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?= $patient['firstname'] ?></td>
                    <td><?= $patient['lastname'] ?></td>
                    <td><?= $patient['address'] ?></td>
                    <td><?= $patient['zipcode'] ?></td>
                    <td><?= $patient['city'] ?></td>
                    <td><?= $patient['phone'] ?></td>
                    <td><?= $patient['mail'] ?></td>
                    <td><input type="checkbox" name="del[]" value="<?= $patient['id'] ?>"</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <input type="submit" class="btn btn-primary" value="Supprimer sélectionnés"/>
    </form>
<?php
include_once 'helpers/footer.php';