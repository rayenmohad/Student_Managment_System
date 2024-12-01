<?php
// Inclure la configuration et la classe
require 'config.php';
require 'classes.php';

$etudiant = new C_Stat($pdo); // Instanciation de la classe
$resultats = []; // Initialisation des résultats
$message = "";

// Récupérer la liste des matières pour le formulaire
$matiereStmt = $pdo->query("SELECT nommatiere FROM matiere");
$matieres = $matiereStmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $codeetudiant = $_POST['codeetudiant'];
    $nommatiere = $_POST['nommatiere'] ?? '';
    $datedebut = $_POST['datedebut'];
    $datefin = $_POST['datefin'];

    // Vérifier que toutes les données sont présentes
    if (!empty($codeetudiant) && !empty($nommatiere) && !empty($datedebut) && !empty($datefin)) {
        // Appeler la fonction
        $resultats = $etudiant->Liste_absence_etudient_parMatiere($codeetudiant, $nommatiere, $datedebut, $datefin);
        if (empty($resultats)) {
            $message = "Aucune absence trouvée pour ces critères.";
        }
    } else {
        $message = "Veuillez remplir tous les champs du formulaire.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste d'Absences</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container my-5">
        <h1 class="text-center mb-4">Consulter les absences d'un étudiant</h1>

        <!-- Formulaire -->
        <form action="" method="POST" class="card p-4 shadow">
            <div class="mb-3">
                <label for="codeetudiant" class="form-label">Code Étudiant</label>
                <input type="text" id="codeetudiant" name="codeetudiant" 
                       class="form-control" value="<?= htmlspecialchars($_POST['codeetudiant'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="nommatiere" class="form-label">Matière</label>
                <select id="nommatiere" name="nommatiere" class="form-select" required>
                    <option value="">-- Sélectionnez une matière --</option>
                    <?php foreach ($matieres as $matiere): ?>
                        <option value="<?= htmlspecialchars($matiere['nommatiere']) ?>" 
                            <?= isset($_POST['nommatiere']) && $_POST['nommatiere'] === $matiere['nommatiere'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($matiere['nommatiere']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="datedebut" class="form-label">Date Début</label>
                <input type="date" id="datedebut" name="datedebut" 
                       class="form-control" value="<?= htmlspecialchars($_POST['datedebut'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="datefin" class="form-label">Date Fin</label>
                <input type="date" id="datefin" name="datefin" 
                       class="form-control" value="<?= htmlspecialchars($_POST['datefin'] ?? '') ?>" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Rechercher</button>
        </form>

        <!-- Affichage des messages -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-warning mt-4"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Affichage des résultats -->
        <?php if (!empty($resultats)): ?>
            <h2 class="mt-5">Liste des absences</h2>
            <table class="table table-bordered table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Nom Étudiant</th>
                        <th>Nom Enseignant</th>
                        <th>Date d'Absence</th>
                        <th>Type de Séance</th>
                        <th>Matière</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultats as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nometudiant']) ?></td>
                            <td><?= htmlspecialchars($row['nomenseignant']) ?></td>
                            <td><?= htmlspecialchars($row['datejour']) ?></td>
                            <td><?= htmlspecialchars($row['nomseance']) ?></td>
                            <td><?= htmlspecialchars($row['nommatiere']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
