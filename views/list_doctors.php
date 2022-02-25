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
                    <td><input class="form-check-input" type="checkbox" name="del[]" value="<?= $doctor['doc_id'] ?>"/></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <input type="submit" class="btn btn-primary" value="Supprimer sélectionnés" />
    </form>
</div>
</body>

