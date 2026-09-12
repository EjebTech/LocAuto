<?php 
$css_path = "../../assets/css/style.css";
include("../../includes/header.php"); 
?>
    <h1>Liste des véhicules</h1>
    <a href="create.php" class="btn_ajout">Ajouter un véhicule</a>
    <?php
        include("../../config/db.php");
        $req = $conn->query("SELECT v.*, m.Marqlib, s.NomSite FROM Vehicule v JOIN Marque m ON v.MarqId = m.MarqId JOIN Site s ON v.NumSite = s.NumSite");
        $vehiculesXmarquesXsites = $req->fetchAll();
        
    ?>
    
    <table border="4">
        <thead>
            <tr>
                <th>Visuel</th>
                <th>Immatriculation</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Couleur</th>
                <th>Statut</th>
                <th>Prix journalier</th>
                <th>Site</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($vehiculesXmarquesXsites)): ?>
                <tr>
                    <td colspan="9">Aucun véhicule enregistré pour le moment</td>
                </tr>
            <?php else: ?>
                <?php foreach($vehiculesXmarquesXsites as $vehicule):?>
                    <tr>
                        <td>
                            <?php if(!$vehicule['ImgVeh']): ?>
                                Aucune image
                            <?php else:?>
                                <img src="../../assets/uploads/vehicules/<?=htmlspecialchars($vehicule['ImgVeh'])?>" class="vehicule_img">
                            <?php endif;?>      
                        </td>
                        <td><?= htmlspecialchars($vehicule['ImVeh']) ?></td>
                        <td><?= htmlspecialchars($vehicule['Marqlib']) ?></td>
                        <td><?= htmlspecialchars($vehicule['ModeleVeh']) ?></td>
                        <td><?= htmlspecialchars($vehicule['CoulVeh']) ?></td>
                        <td><?= htmlspecialchars($vehicule['StatutVeh']) ?></td>
                        <td><?= htmlspecialchars($vehicule['PrixJour']) ?> FCFA</td>
                        <td><?= htmlspecialchars($vehicule['NomSite']) ?></td>
                        <td>
                            <a href="edit.php?id=<?=$vehicule['ImVeh']?>"><i class="fa-solid fa-pencil"></i> Modifier</a>
                            /
                            <a href="delete.php?id=<?=$vehicule['ImVeh']?>"><i class="fa-solid fa-trash"></i> Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif;?>
        </tbody>
    </table>
<?php include("../../includes/footer.php");?>