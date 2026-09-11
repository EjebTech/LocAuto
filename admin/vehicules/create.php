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

        //Envoi de l'image
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $immat = trim($_POST['imm_vehicule']);
            $couleur_vehicule = trim($_POST['couleur_vehicule']);
            $prix = trim($_POST['prix_jour']);
            $marque_vehicule = $_POST['marque_vehicule'];
            $modele = $_POST['modele_vehicule'];
            $new_name = null;

            if(isset($_FILES['image_vehicle']) && $_FILES['image_vehicle']['error'] == 0){
                $img_file_name = $_FILES['image_vehicle']['name'];
                $img_file_ext = strtolower(pathinfo($img_file_name, PATHINFO_EXTENSION));
                $img_tmp_name = $_FILES['image_vehicle']['tmp_name'];
                $new_name = uniqid('Vehicule_') . '.' . $img_file_ext;
                
                
                $extensions_autorisees = ['jpg','png', 'webp', 'jpeg'];
                if(in_array($img_file_ext, $extensions_autorisees)){
                    if(move_uploaded_file($img_tmp_name, "../../assets/uploads/vehicules/" . $new_name)){
                        echo "Fichier envoyé avec succès";
                    }
                }else{
                    echo "Seuls les extensions 'jpg, jpeg, webp et png' sont autorisées";
                }
                
            }

            $req2 = $conn->prepare("INSERT INTO Vehicule VALUES(NULL,?,?,?,?,?,?,?,?)");
            $req2->execute([$new_name, $immat, $modele, $couleur_vehicule, 'Disponible', $prix, $marque_vehicule, ]);
            if($req2){
                header("Location: index.php");
            }
        }
    ?>


    <form action="" method="post" enctype="multipart/form-data">
        <label>Entrez l'image du véhicule : </label>
        <input type="file" name="image_vehicle" action="image/*">
        <br><br>

        <label>Immatriculation : </label>
        <input type="text" name="imm_vehicule" placeholder="L'immatriculation du véhicule" required>
        <br><br>

        <label>Modèle : </label>
        <input type="text" name="modele_vehicule" required>
        <br><br>

        <label>Couleur : </label>
        <input type="text" name="couleur_vehicule" required>
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