<?php
include_once '../config.php';
include_once '../models/RendezVous.php';
include_once '../controllers/RendezVousController.php';

$rdv = new RendezVous();
$list = $rdv->getAll();

$page_title = 'Afficher les rendez-vous';
$actif = 'Rendez-vous';
include_once 'helpers/head.php';
include_once 'helpers/header.php';

?>
    <form method="POST">
        <table class="table">
            <thead>
            <tr>
                <th>Médecin</th>
                <th>Patient</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Fin</th>
                <th>Supprimer</th>
            </tr>
            </thead>
            <?php
            foreach ($list as $item):
                ?>
                <tr>
                    <td><?= $item['doc_name'] ?></td>
                    <td><?= $item['pat_name'] ?></td>
                    <td><?= date('d/m/Y', $item['date']) ?></td>
                    <td><?= date('H:i', $item['start_time']) ?></td>
                    <td><?= date('H:i', $item['end_time']) ?></td>
                    <td><input type="checkbox" value="<?= $item['id'] ?>" name="del[]"/></td>
                </tr>
            <?php
            endforeach;
            ?>
        </table>
        <input type="submit" value="Supprimer" name="delete"/>
    </form>
<?php
include_once 'helpers/footer.php';