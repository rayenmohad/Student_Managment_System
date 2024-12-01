<?php
class C_Matiere {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addMatiere($codeMatiere, $nommatiere, $nbhcps, $nbhtdps, $nbhtpps) {
        // Check if the codematiere already exists
        $checkSql = "SELECT codematiere FROM matiere WHERE codematiere = ?";
        $checkStmt = $this->pdo->prepare($checkSql);
        $checkStmt->execute([$codeMatiere]);
    
        if ($checkStmt->rowCount() > 0) {
            throw new Exception("Matière with code '$codeMatiere' already exists.");
        }
    
        // Insert the new record
        $sql = "INSERT INTO matiere (codematiere, nommatiere, nbhcps, nbhtdps, nbhtpps) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codeMatiere, $nommatiere, $nbhcps, $nbhtdps, $nbhtpps]);
    }
    
    public function listMatieres() {
        $sql = "SELECT * FROM matiere";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteMatiere($code) {
        $sql = "DELETE FROM matiere WHERE codematiere = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$code]);
    }
}

class C_Enseignant {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addEnseignant($codeenseignant, $nom, $prenom, $daterecrutement, $adresse, $mail, $tel, $codedepartement, $codegrade) {
        $sql = "INSERT INTO enseignant (codeenseignant, nom, prenom, daterecrutement, adresse, mail, tel, codedepartement, codegrade) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codeenseignant, $nom, $prenom, $daterecrutement, $adresse, $mail, $tel, $codedepartement, $codegrade]);
    }
    

    public function listEnseignants() {
        $sql = "SELECT * FROM enseignant";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteEnseignant($code) {
        $sql = "DELETE FROM enseignant WHERE codeenseignant = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$code]);
    }
}

class C_Etudiant {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addEtudiant($codeetudiant, $nom, $prenom, $datenaiss, $codeclasse, $numinscri, $adresse, $mail_etud, $_tel_etud) {
        // Requête SQL pour insérer un étudiant
        $sql = "INSERT INTO etudiant (codeetudiant, nom, prenom, datenaiss, codeclasse, numinscri, adresse, mail_etud, tel_etud) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        
        // Exécution de la requête avec les paramètres
        $stmt->execute([$codeetudiant, $nom, $prenom, $datenaiss, $codeclasse, $numinscri, $adresse, $mail_etud, $_tel_etud]);
    }
    

    public function listEtudiants() {
        $sql = "SELECT * FROM etudiant";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteEtudiant($code) {
        $sql = "DELETE FROM etudiant WHERE codeetudiant = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$code]);
    }

    public function getEtudiantByCode($codeetudiant) {
        // Prepare SQL query
        $sql = "SELECT * FROM etudiant WHERE codeetudiant = :codeetudiant";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':codeetudiant', $codeetudiant, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the result
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateEtudiant($codeetudiant, $nom, $prenom, $datenaiss, $codeclasse, $numinscri, $adresse, $mail_etud, $tel_etud) {
        $sql = "UPDATE etudiant SET 
                nom = ?, 
                prenom = ?, 
                datenaiss = ?, 
                codeclasse = ?, 
                numinscri = ?, 
                adresse = ?, 
                mail_etud = ?, 
                tel_etud = ? 
                WHERE codeetudiant = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $datenaiss, $codeclasse, $numinscri, $adresse, $mail_etud, $tel_etud, $codeetudiant]);
    }

}


class C_Stat {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function Liste_absence_etudient_parMatiere($codeetudiant, $nommatiere, $dated, $datef) {
        $sql = "SELECT CONCAT(e.nom, ' ', e.prenom) AS nomenseignant, 
                       CONCAT(et.nom, ' ', et.prenom) AS nometudiant, 
                       fa.datejour, 
                       s.nomseance,
                       m.nommatiere AS nommatiere
                FROM ligneficheabsence lfa
                JOIN ficheabsence fa ON lfa.codefiche = fa.codefiche
                JOIN enseignant e ON fa.codeenseignant = e.codeenseignant
                JOIN ficheabsenceseance fas ON fa.codefiche = fas.codefiche
                JOIN seance s ON fas.codeseance = s.codeseance
                JOIN etudiant et ON lfa.codeetudiant = et.codeetudiant
                JOIN matiere m ON fa.codematiere = m.codematiere
                WHERE lfa.codeetudiant = ? 
                  AND m.nommatiere = ? 
                  AND fa.datejour BETWEEN ? AND ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codeetudiant, $nommatiere, $dated, $datef]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function Liste_absences_par_etudiant($dateD, $dateF, $classe = '', $nomEtudiant = '', $prenomEtudiant = '') {
        $sql = "SELECT 
                    e.nom AS nomEtudiant, 
                    e.prenom, 
                    c.nomclasse, 
                    m.nommatiere, 
                    COUNT(lfa.codeetudiant) AS nbAbsences
                FROM ligneficheabsence lfa
                JOIN ficheabsence fa ON lfa.codefiche = fa.codefiche
                JOIN etudiant e ON lfa.codeetudiant = e.codeetudiant
                JOIN matiere m ON fa.codematiere = m.codematiere
                JOIN classe c ON e.codeclasse = c.codeclasse
                WHERE fa.datejour BETWEEN ? AND ?";
    
        $params = [$dateD, $dateF];
    
        if (!empty($classe)) {
            $sql .= " AND c.nomclasse = ?";
            $params[] = $classe;
        }
        if (!empty($nomEtudiant)) {
            $sql .= " AND e.nom = ?";
            $params[] = $nomEtudiant;
        }
        if (!empty($prenomEtudiant)) {
            $sql .= " AND e.prenom = ?";
            $params[] = $prenomEtudiant;
        }
    
        $sql .= " GROUP BY e.nom, e.prenom, c.nomclasse, m.nommatiere
                  ORDER BY e.nom, e.prenom, m.nommatiere";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    
}









?>