<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        include("../../config/db.php");
        $req = $conn->query("SELECT * FROM Marque");
        $marques = $req->fetchAll();

        if($_SERVER['REQUEST_METHOD'] === $_POST ){
            $immat = $_POST['imm_vehicule'];
            
            
        }
    ?>


    <form action="" method="post" enctype="multipart/form-data">
        <label>Entrez l'image du véhicule : </label>
        <input type="file" action="image/*">
        <br><br>

        <label>Immatriculation : </label>
        <input type="text" name="imm_vehicule" placeholder="L'immatriculation du véhicule" required>
        <br><br>

        <label>Modèle : </label>
        <input type="text" name="modele_vehicule" required>
        <br><br>

        <label>Couleur : </label>
        <input type="text" required>
        <br><br>

        <label>Prix journalier : </label>
        <input type="number" name="prix_jour" required>
        <br><br>

        <label>Marque : </label>
        <select name="marque_vehicule">
            <?php if($marques) :?>
                <?php foreach($marques as $marque):?>
                    <option value="<?= htmlspecialchars($marque['MarqId']) ?>"><?=htmlspecialchars($marque['Marqlib'])?></option>
                <?php endforeach ?>
            <?php endif;?>
        </select>
        <br><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>