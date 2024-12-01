<?php
require 'config.php';
require 'classes.php';

$matiere = new C_Matiere($pdo);
$matieres = $matiere->listMatieres();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Liste des Matières</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Liste des Matières</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>HCPS</th>
                <th>HTDPS</th>
                <th>HTPPS</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($matieres as $m): ?>
            <tr>
                <td><?= $m['codematiere'] ?></td>
                <td><?= $m['nommatiere'] ?></td>
                <td><?= $m['nbhcps'] ?></td>
                <td><?= $m['nbhtdps'] ?></td>
                <td><?= $m['nbhtpps'] ?></td>
                <td>
                    <a href="edit_matiere.php?id=<?= $m['codematiere'] ?>" class="btn btn-warning">Modifier</a>
                    <a href="delete_matiere.php?id=<?= $m['codematiere'] ?>" class="btn btn-danger">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
