<?php
require 'config.php'; // Include database configuration
require 'classes.php'; // Include the C_Etudiant class

$etudiant = new C_Etudiant($pdo);
$message = '';

// Check if the codeetudiant parameter is set in the URL
if (isset($_GET['codeetudiant'])) {
    $codeetudiant = $_GET['codeetudiant'];
    
    // Get the student details
    $etudiantDetails = $etudiant->getEtudiantByCode($codeetudiant);
    
    if (!$etudiantDetails) {
        $message = "L'étudiant avec ce code n'existe pas.";
    }
}

// Handle form submission for updating student details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_etudiant'])) {
    $codeetudiant = $_POST['codeetudiant'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $datenaiss = $_POST['datenaiss'];
    $codeclasse = $_POST['codeclasse'];
    $numinscri = $_POST['numinscri'];
    $adresse = $_POST['adresse'];
    $mail_etud = $_POST['mail_etud'];
    $tel_etud = $_POST['tel_etud'];

    $etudiant->updateEtudiant($codeetudiant, $nom, $prenom, $datenaiss, $codeclasse, $numinscri, $adresse, $mail_etud, $tel_etud);
    $message = "Étudiant mis à jour avec succès.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <h1 class="text-center mb-4">Modifier l'Étudiant</h1>

        <!-- Message de succès -->
        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Formulaire de modification d'un étudiant -->
        <form action="" method="POST" class="card p-4 shadow mb-5">
            <h2>Modifier l'étudiant</h2>

            <div class="mb-3">
                <label for="codeetudiant" class="form-label">Code Étudiant</label>
                <input type="text" id="codeetudiant" name="codeetudiant" class="form-control" value="<?= htmlspecialchars($etudiantDetails['codeetudiant']) ?>" readonly required>
            </div>
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($etudiantDetails['nom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" id="prenom" name="prenom" class="form-control" value="<?= htmlspecialchars($etudiantDetails['prenom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="datenaiss" class="form-label">Date de Naissance</label>
                <input type="date" id="datenaiss" name="datenaiss" class="form-control" value="<?= htmlspecialchars($etudiantDetails['datenaiss']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="codeclasse" class="form-label">Code Classe</label>
                <input type="text" id="codeclasse" name="codeclasse" class="form-control" value="<?= htmlspecialchars($etudiantDetails['codeclasse']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="numinscri" class="form-label">Numéro d'Inscription</label>
                <input type="text" id="numinscri" name="numinscri" class="form-control" value="<?= htmlspecialchars($etudiantDetails['numinscri']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" id="adresse" name="adresse" class="form-control" value="<?= htmlspecialchars($etudiantDetails['adresse']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="mail_etud" class="form-label">Email</label>
                <input type="email" id="mail_etud" name="mail_etud" class="form-control" value="<?= htmlspecialchars($etudiantDetails['mail_etud']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="tel_etud" class="form-label">Numéro de Téléphone</label>
                <input type="text" id="tel_etud" name="tel_etud" class="form-control" value="<?= htmlspecialchars($etudiantDetails['tel_etud']) ?>" required>
            </div>
            <button type="submit" name="update_etudiant" class="btn btn-primary w-100">Mettre à jour</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
