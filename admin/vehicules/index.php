<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php
        include("../../config/db.php");
        $req = $conn->query("SELECT * FROM Vehicule");
        $vehicules = $req->fetchAll();

    ?>
    
    <table border="3">
        <thead>
            <tr>
                <th>Immatriculation</th>
                <th>Visuel</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Couleur</th>
                <th>Statut</th>
                <th>Prix journalier</th>
                <th>Site</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($vehicules)): ?>
                <tr>
                    <td colspan="8">Aucun véhicule enregistré pour le moment</td>
                </tr>
            <?php else: ?>
                <?php foreach($vehicules as $vehicule):?>
                    <tr>
                        <td>
                            <?php if(!$vehicule['ImgVeh']): ?>
                                Aucune image
                            <?php else:?>
                                <img src="../../assets/uploads/vehicules/<?=htmlspecialchars($vehicule['ImgVeh'])?>" class="vehicule_img">
                            <?php endif;?>      
                        </td>
                        <td><?= htmlspecialchars($vehicule['Imveh']) ?></td>
                        <td></td>
                        <td><?= htmlspecialchars($vehicule['ModeleVeh']) ?></td>
                        <td><?= htmlspecialchars($vehicule['CoulVeh']) ?></td>
                        <td><?= htmlspecialchars($vehicule['StatutVeh']) ?></td>
                        <td><?= htmlspecialchars($vehicule['PrixJour']) ?></td>
                        <td></td>
                    </tr>
                <?php endforeach ?>
            <?php endif;?>
        </tbody>
    </table>
</body>
</html>