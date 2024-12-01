<?php
require 'config.php';
require 'classes.php';

$matiere = new C_Matiere($pdo);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $matiere->deleteMatiere($id);
    echo "Matière supprimée avec succès.";
} 
?>
