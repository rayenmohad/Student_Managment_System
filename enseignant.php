<?php
// Inclure la configuration et la classe
require 'config.php';
require 'classes.php';

$enseignant = new C_Enseignant($pdo); // Instanciation de la classe
$message = "";

// Ajouter un enseignant
if (isset($_POST['addEnseignant'])) {
    $codeenseignant = $_POST['codeenseignant'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $daterecrutement = $_POST['daterecrutement'];
    $adresse = $_POST['adresse'];
    $mail = $_POST['mail'];
    $tel = $_POST['tel'];
    $codedepartement = $_POST['codedepartement'];
    $codegrade = $_POST['codegrade'];

    if (!empty($codeenseignant) && !empty($nom) && !empty($prenom)) {
        $enseignant->addEnseignant($codeenseignant, $nom, $prenom, $daterecrutement, $adresse, $mail, $tel, $codedepartement, $codegrade);
        $message = "Enseignant ajouté avec succès.";
    } else {
        $message = "Veuillez remplir tous les champs obligatoires.";
    }
}

// Supprimer un enseignant
if (isset($_POST['deleteEnseignant'])) {
    $codeenseignant = $_POST['deleteCode'];

    if (!empty($codeenseignant)) {
        $enseignant->deleteEnseignant($codeenseignant);
        $message = "Enseignant supprimé avec succès.";
    } else {
        $message = "Veuillez fournir le code de l'enseignant à supprimer.";
    }
}

// Liste des enseignants
$enseignants = $enseignant->listEnseignants();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Enseignants</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container my-5">
    <h1 class="text-center mb-4">Gestion des Enseignants</h1>

    <!-- Messages -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- Formulaire d'ajout d'un enseignant -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Ajouter un Enseignant</div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="codeenseignant" class="form-label">Code Enseignant</label>
                        <input type="text" class="form-control" id="codeenseignant" name="codeenseignant" required>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="daterecrutement" class="form-label">Date de Recrutement</label>
                        <input type="date" class="form-control" id="daterecrutement" name="daterecrutement">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="mail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="mail" name="mail">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="tel" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" id="tel" name="tel">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="codedepartement" class="form-label">Code Département</label>
                        <input type="text" class="form-control" id="codedepartement" name="codedepartement">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="codegrade" class="form-label">Code Grade</label>
                        <input type="text" class="form-control" id="codegrade" name="codegrade">
                    </div>
                </div>
                <button type="submit" name="addEnseignant" class="btn btn-success">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- Formulaire de suppression d'un enseignant -->
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">Supprimer un Enseignant</div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="deleteCode" class="form-label">Code Enseignant</label>
                    <input type="text" class="form-control" id="deleteCode" name="deleteCode" required>
                </div>
                <button type="submit" name="deleteEnseignant" class="btn btn-danger">Supprimer</button>
            </form>
        </div>
    </div>

    <!-- Liste des enseignants -->
    <div class="card">
        <div class="card-header bg-secondary text-white">Liste des Enseignants</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de Recrutement</th>
                    <th>Email</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Département</th>
                    <th>Grade</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($enseignants as $enseignant): ?>
                    <tr>
                        <td><?= htmlspecialchars($enseignant['codeenseignant']) ?></td>
                        <td><?= htmlspecialchars($enseignant['nom']) ?></td>
                        <td><?= htmlspecialchars($enseignant['prenom']) ?></td>
                        <td><?= htmlspecialchars($enseignant['daterecrutement']) ?></td>
                        <td><?= htmlspecialchars($enseignant['mail']) ?></td>
                        <td><?= htmlspecialchars($enseignant['adresse']) ?></td>
                        <td><?= htmlspecialchars($enseignant['tel']) ?></td>
                        <td><?= htmlspecialchars($enseignant['codedepartement']) ?></td>
                        <td><?= htmlspecialchars($enseignant['codegrade']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
