<?php 
$css_path = "../../assets/css/style.css";
include("../../includes/header.php"); 
?>
    <h1>Liste des marques</h1>
    <a href="create.php" class="btn_ajout">Ajouter une marque</a>
    <?php
        include("../../config/db.php");
        $req = $conn->query("SELECT * FROM Marque ORDER BY MarqId DESC"); //Récuperer tous les element en les triant leurs identifiants en  ordre decroissnt
        $marques = $req->fetchAll();
    ?>
    <table border="4" class="table_marques">
        <thead>
            <tr>
                <th>Logos</th>
                <th>Marques</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($marques)): ?>
                <tr>
                    <td colspan="4">Aucune marque enregistrée pour le moment</td>
                </tr>
            <?php else: ?>
                <?php foreach($marques as $marque): ?>
                    <tr>
                        <td>
                            <?php if($marque['LogoMarq']):?>
                                <img src="../../assets/uploads/logos/<?= htmlspecialchars($marque['LogoMarq'])?>" class="logo_img">
                            <?php else: ?>
                                Pas de logo
                            <?php endif;?> 
                        </td>       
                        <td><?= htmlspecialchars($marque['Marqlib']) ?></td>  
                        <td>
                            <a href="edit.php?id=<?=htmlspecialchars($marque['MarqId'])?>"><i class="fa-solid fa-pencil"></i> Modifier</a>
                            /
                            <a href="delete.php?id=<?=htmlspecialchars($marque['MarqId'])?>">
                                <i class="fa-solid fa-trash"></i> Supprimer 
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>        
        </tbody>
        
    </table>

    
<?php include("../../includes/footer.php");?>