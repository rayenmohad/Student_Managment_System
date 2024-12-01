<?php
require 'config.php';
require 'classes.php';

$matiere = new C_Matiere($pdo);
$matiereData = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['search'])) {
        // Search form submission
        if (empty($_POST['fetchCodematiere'])) {
            echo "Veuillez spécifier un code matière.";
            exit;
        }

        $codematiere = $_POST['fetchCodematiere'];
        $sql = "SELECT * FROM matiere WHERE codematiere = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$codematiere]);
        $matiereData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$matiereData) {
            echo "Aucune matière trouvée avec le code spécifié.";
        }
    } elseif (isset($_POST['update'])) {
        // Update form submission
        if (empty($_POST['codematiere'])) {
            echo "Veuillez spécifier un code matière.";
            exit;
        }

        $id = $_POST['codematiere'];
        $nom = $_POST['nom'];
        $nbhcps = $_POST['nbhcps'];
        $nbhtdps = $_POST['nbhtdps'];
        $nbhtpps = $_POST['nbhtpps'];

        $sql = "UPDATE matiere SET nommatiere = ?, nbhcps = ?, nbhtdps = ?, nbhtpps = ? WHERE codematiere = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $nbhcps, $nbhtdps, $nbhtpps, $id]);
        echo "Matière modifiée avec succès.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier une Matière</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Modifier une Matière</h2>

    <!-- Form for fetching matiere by codematiere -->
    <form method="POST">
        <div class="mb-3">
            <label for="fetchCodematiere" class="form-label">Code Matière</label>
            <input type="text" class="form-control" id="fetchCodematiere" name="fetchCodematiere" 
                   placeholder="Entrer le code matière à modifier" value="<?= $_POST['fetchCodematiere'] ?? '' ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" name="search">Rechercher</button>
    </form>

    <?php if ($matiereData): ?>
    <!-- Form for modifying the matiere -->
    <form method="POST" class="mt-4">
        <input type="hidden" name="codematiere" value="<?= $matiereData['codematiere'] ?>">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la matière</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?= $matiereData['nommatiere'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="nbhcps" class="form-label">Nombre d'heures cours</label>
            <input type="number" class="form-control" id="nbhcps" name="nbhcps" value="<?= $matiereData['nbhcps'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="nbhtdps" class="form-label">Nombre d'heures TD</label>
            <input type="number" class="form-control" id="nbhtdps" name="nbhtdps" value="<?= $matiereData['nbhtdps'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="nbhtpps" class="form-label">Nombre d'heures TP</label>
            <input type="number" class="form-control" id="nbhtpps" name="nbhtpps" value="<?= $matiereData['nbhtpps'] ?>" required>
        </div>
        <button type="submit" class="btn btn-success" name="update">Modifier</button>
    </form>
    <?php endif; ?>
</div>
</body>
</html>
