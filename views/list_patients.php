<?php
require_once '../models/patients.php';
$pat = new Patients();
$patients = $pat->listPatients();
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
    <form method="POST"  class="form-check">
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
        <input type="submit" class="btn btn-primary" value="Supprimer sélectionnés" />
    </form>
