<?php
include("../../config/db.php");

// Récupérer tous les sites
$req = $conn->query("SELECT * FROM Site");
$sites = $req->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Sites</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h1>Liste des Sites</h1>
    <a href="create.php">Ajouter un site</a>
    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Nom du Site</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if($sites): ?>
                <?php foreach($sites as $site): ?>
                    <tr>
                        <td><?= htmlspecialchars($site['NumSite']) ?></td>
                        <td><?= htmlspecialchars($site['NomSite']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $site['NumSite'] ?>">Modifier</a>
                            <a href="delete.php?id=<?= $site['NumSite'] ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Aucun site trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <a href="../vehicules/index.php">Retour à la gestion des véhicules</a>
</body>
</html>