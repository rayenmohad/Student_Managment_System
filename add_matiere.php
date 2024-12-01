<?php
require 'config.php';
require 'classes.php';

$matiere = new C_Matiere($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codematiere = $_POST['codematiere'];
    $nommatiere = $_POST['nommatiere'];
    $nbhcps = $_POST['nbhcps'];
    $nbhtdps = $_POST['nbhtdps'];
    $nbhtpps = $_POST['nbhtpps']; // Corrected the variable name

    $matiere->addMatiere($codematiere, $nommatiere, $nbhcps, $nbhtdps, $nbhtpps); // Ensure correct variable
    echo "Matière ajoutée avec succès.";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une Matière</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Ajouter une Matière</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="codematiere" class="form-label">Code Matière</label>
            <input type="text" class="form-control" id="codematiere" name="codematiere" required>
        </div>
        <div class="mb-3">
            <label for="nommatiere" class="form-label">Nom de la matière</label>
            <input type="text" class="form-control" id="nommatiere" name="nommatiere" required>
        </div>
        <div class="mb-3">
            <label for="nbhcps" class="form-label">Nombre d'heures cours</label>
            <input type="text" class="form-control" id="nbhcps" name="nbhcps" required>
        </div>
        <div class="mb-3">
            <label for="nbhtdps" class="form-label">Nombre d'heures TD</label>
            <input type="text" class="form-control" id="nbhtdps" name="nbhtdps" required>
        </div>
        <div class="mb-3">
            <label for="nbhtpps" class="form-label">Nombre d'heures TP</label>
            <input type="text" class="form-control" id="nbhtpps" name="nbhtpps" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
</body>
</html>
