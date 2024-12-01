<?php
require 'config.php'; // Inclure la configuration de la base de données
require 'classes.php'; // Inclure la classe C_Etudiant

$etudiant = new C_Etudiant($pdo);
$message = '';

// Ajouter un étudiant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_etudiant'])) {
    $codeetudiant = $_POST['codeetudiant'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $datenaiss = $_POST['datenaiss'];
    $codeclasse = $_POST['codeclasse'];
    $numinscri = $_POST['numinscri'];
    $adresse = $_POST['adresse'];
    $mail_etud = $_POST['mail_etud'];
    $tel_etud = $_POST['tel_etud'];

    $etudiant->addEtudiant($codeetudiant, $nom, $prenom, $datenaiss, $codeclasse, $numinscri, $adresse, $mail_etud, $tel_etud);
    $message = "Étudiant ajouté avec succès.";
}

// Supprimer un étudiant
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $codeetudiant = $_GET['delete'];
    $etudiant->deleteEtudiant($codeetudiant);
    $message = "Étudiant supprimé avec succès.";
}

// Lister tous les étudiants
$etudiants = $etudiant->listEtudiants();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <h1 class="text-center mb-4">Gestion des Étudiants</h1>

        <!-- Message de succès -->
        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Formulaire d'ajout d'un étudiant -->
        <form action="" method="POST" class="card p-4 shadow mb-5">
            <h2>Ajouter un étudiant</h2>
            <div class="mb-3">
                <label for="codeetudiant" class="form-label">Code Étudiant</label>
                <input type="text" id="codeetudiant" name="codeetudiant" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" id="nom" name="nom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" id="prenom" name="prenom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="datenaiss" class="form-label">Date de Naissance</label>
                <input type="date" id="datenaiss" name="datenaiss" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="codeclasse" class="form-label">Code Classe</label>
                <input type="text" id="codeclasse" name="codeclasse" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="numinscri" class="form-label">Numéro d'Inscription</label>
                <input type="text" id="numinscri" name="numinscri" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" id="adresse" name="adresse" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="mail_etud" class="form-label">Email</label>
                <input type="email" id="mail_etud" name="mail_etud" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tel_etud" class="form-label">Numéro de Téléphone</label>
                <input type="text" id="tel_etud" name="tel_etud" class="form-control" required>
            </div>
            <button type="submit" name="add_etudiant" class="btn btn-primary w-100">Ajouter</button>
        </form>

        <!-- Liste des étudiants -->
        <h2 class="mb-4">Liste des Étudiants</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Code Étudiant</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de Naissance</th>
                    <th>Code Classe</th>
                    <th>Numéro d'Inscription</th>
                    <th>Adresse</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($etudiants as $etudiant): ?>
                    <tr>
                        <td><?= htmlspecialchars($etudiant['codeetudiant']) ?></td>
                        <td><?= htmlspecialchars($etudiant['nom']) ?></td>
                        <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
                        <td><?= htmlspecialchars($etudiant['datenaiss']) ?></td>
                        <td><?= htmlspecialchars($etudiant['codeclasse']) ?></td>
                        <td><?= htmlspecialchars($etudiant['numinscri']) ?></td>
                        <td><?= htmlspecialchars($etudiant['adresse']) ?></td>
                        <td><?= htmlspecialchars($etudiant['mail_etud']) ?></td>
                        <td><?= htmlspecialchars($etudiant['tel_etud']) ?></td>
                        <td>
                            <a href="update_etudiant.php?codeetudiant=<?= htmlspecialchars($etudiant['codeetudiant']) ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="?delete=<?= htmlspecialchars($etudiant['codeetudiant']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
