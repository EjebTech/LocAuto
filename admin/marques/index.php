<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h1>Liste des marques</h1>
    
    <?php
        include("../../config/db.php");
        $req = $conn->query("SELECT * FROM Marque ORDER BY MarqId DESC"); //Récuperer tous les element en les triant leurs identifiants en  ordre decroissnt
        $marques = $req->fetchAll();
    ?>
    <table border="3">
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
                            <a href="edit.php?id=<?=htmlspecialchars($marque['MarqId'])?>">Modifier</a>
                            ou
                            <a href="delete.php?id=<?=htmlspecialchars($marque['MarqId'])?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>        
        </tbody>
        
    </table>

    <a href="create.php">Ajouter un véhicule</a>
</body>
</html>