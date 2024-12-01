<?php
require 'config.php'; 
require 'classes.php'; 

$stat = new C_Stat($pdo);
$absences = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dateD = $_POST['dateD'];
    $dateF = $_POST['dateF'];
    $classe = $_POST['classe'] ?? '';
    $nomEtudiant = $_POST['nomEtudiant'] ?? '';
    $prenomEtudiant = $_POST['prenomEtudiant'] ?? '';

    if (!empty($dateD) && !empty($dateF)) {
        // Call the method with the provided filters
        $absences = $stat->Liste_absences_par_etudiant($dateD, $dateF, $classe, $nomEtudiant, $prenomEtudiant);

        if (empty($absences)) {
            $error = "Aucune absence trouvée pour les critères sélectionnés.";
        }
    } else {
        $error = "Veuillez sélectionner une période de date valide.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absences des Étudiants</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Liste des Absences des Étudiants</h2>

    <!-- Formulaire pour sélectionner la période et les critères -->
    <form method="POST" class="mb-4">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="dateD" class="form-label">Date Début</label>
                <input type="date" id="dateD" name="dateD" class="form-control" required value="<?= htmlspecialchars($_POST['dateD'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label for="dateF" class="form-label">Date Fin</label>
                <input type="date" id="dateF" name="dateF" class="form-control" required value="<?= htmlspecialchars($_POST['dateF'] ?? '') ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="classe" class="form-label">Classe</label>
                <input type="text" id="classe" name="classe" class="form-control" placeholder="Ex : 2CS" value="<?= htmlspecialchars($_POST['classe'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label for="nomEtudiant" class="form-label">Nom Étudiant</label>
                <input type="text" id="nomEtudiant" name="nomEtudiant" class="form-control" placeholder="Ex : Gharbi" value="<?= htmlspecialchars($_POST['nomEtudiant'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label for="prenomEtudiant" class="form-label">Prénom Étudiant</label>
                <input type="text" id="prenomEtudiant" name="prenomEtudiant" class="form-control" placeholder="Ex : Adnen" value="<?= htmlspecialchars($_POST['prenomEtudiant'] ?? '') ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Afficher</button>
            </div>
        </div>
    </form>

    <!-- Affichage des erreurs -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Tableau des absences -->
    <?php if (!empty($absences)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom Étudiant</th>
                    <th>Prénom Étudiant</th>
                    <th>Classe</th>
                    <th>Matière</th>
                    <th>Nombre d'Absences</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($absences as $absence): ?>
                    <tr>
                        <td><?= htmlspecialchars($absence['nomEtudiant']) ?></td>
                        <td><?= htmlspecialchars($absence['prenom']) ?></td>
                        <td><?= htmlspecialchars($absence['nomclasse']) ?></td>
                        <td><?= htmlspecialchars($absence['nommatiere']) ?></td>
                        <td><?= htmlspecialchars($absence['nbAbsences']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune absence trouvée pour les critères sélectionnés.</p>
    <?php endif; ?>
</div>
</body>
</html>
