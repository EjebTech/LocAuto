<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h1>Modification des véhicules</h1>
    <?php
        include("../../config/db.php");
        
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $immat_veh = $_GET['id'];
            
            //Récupere le vehicule, la marque, et le site
            $req = $conn->prepare("SELECT * FROM Vehicule WHERE ImVeh = ?");
            $req->execute([$immat_veh]);
            $vehicule = $req->fetch();
            
            $req2 = $conn->query("SELECT * FROM Marque ");
            $marques = $req2->fetchAll();

            $req3 = $conn->query("SELECT * FROM Site ");
            $sites = $req3->fetchAll();
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $couleur_vehicule = trim($_POST['couleur_vehicule']);
            $prix = trim($_POST['prix_jour']);
            $marque_vehicule = $_POST['marque_vehicule'];
            $modele = $_POST['modele_vehicule'];
            $statut = $_POST['statut'];
            $site_vehicule = $_POST['site'];
            //L'image du vehicule
            $new_image_name = $vehicule['ImgVeh'];
            if(isset($_FILES['image_vehicle']) && $_FILES['image_vehicle']['error'] === 0){
                $old_image = $vehicule['ImgVeh'];
                $new_image_extension = strtolower(pathinfo($_FILES['image_vehicle']['name'], PATHINFO_EXTENSION));
                $extensions_autorisees = ['jpg','png', 'webp', 'jpeg'];
                $chemin_image = "../../assets/uploads/vehicules/" . $old_image;

                $new_image_name = uniqid("vehicule_") . "." . $new_image_extension;
                if(in_array($new_image_extension,$extensions_autorisees)){
                    move_uploaded_file($_FILES['image_vehicle']['tmp_name'], "../../assets/uploads/vehicules/" . $new_image_name);
                    if(file_exists($chemin_image)){
                        unlink($chemin_image);
                    }
                }

            }

            //modifier
            $req4 = $conn->prepare("UPDATE Vehicule SET ImgVeh=?, ModeleVeh=?, CoulVeh=?, StatutVeh=?, PrixJour=?, MarqId=?, NumSite=? WHERE ImVeh=?");
            $req4->execute([$new_image_name, $modele, $couleur_vehicule, $statut, $prix, $marque_vehicule, $site_vehicule, $immat_veh]);
            if($req4){
                header("Location: index.php");
                exit;
            }
        }
    ?>


    <form action="" method="post" enctype="multipart/form-data">
        <label>Image actuelle : </label>
        <?php if(!empty($new_image_name)): ?>
            <img class="vehicule_img" src="../../assets/uploads/vehicules/<?=htmlspecialchars($new_image_name)?>" alt="Image du véhicule actuel">
        <?php endif;?>
        <br><br>

        <label>Entrez l'image du véhicule : </label>
        <input type="file" name="image_vehicle" accept="image/*">
        <br><br>

        <label>Immatriculation : </label>
        <input type="text" name="imm_vehicule" value="<?=$vehicule['ImVeh']?>" placeholder="L'immatriculation du véhicule" required>
        <br><br>

        <label>Modèle : </label>
        <input type="text" name="modele_vehicule" value="<?=$vehicule['ModeleVeh']?>" required>
        <br><br>

        <label>Couleur : </label>
        <input type="text" name="couleur_vehicule" value = "<?=$vehicule['CoulVeh']?>" required>
        <br><br>

        <label>Prix journalier : </label>
        <input type="number" name="prix_jour" value="<?=htmlspecialchars($vehicule['PrixJour'])?>" required>
        <br><br>

        <label>Marque : </label>
        <select name="marque_vehicule">
            <?php if($marques) :?>
                <?php foreach($marques as $marque):?>
                    <option value="<?= htmlspecialchars($marque['MarqId']) ?>" <?= ($marque['MarqId'] == $vehicule['MarqId']) ? 'selected' : '' ?>>
                        <?=htmlspecialchars($marque['Marqlib'])?>
                    </option>
                <?php endforeach ?>
            <?php endif;?>
        </select>
        <br><br>

        <label>Site : </label>
        <select name="site">
            <?php if($sites) :?>
                <?php foreach($sites as $site):?>
                    <option value="<?= htmlspecialchars($site['NumSite']) ?> " <?= ($site['NumSite'] == $vehicule['NumSite']) ? 'selected' : '' ?>>
                        <?=htmlspecialchars($site['NomSite'])?>
                    </option>
                <?php endforeach ?>
            <?php endif;?>
        </select>
        <br><br>
        
        <?php $statut_liste = ["Disponible", "En maintenance", "Reservé", "En service", "En panne"] ?>
        <label>Statut : </label>
        <br>
        <?php foreach($statut_liste as $stat): ?>
            <?php if($vehicule['StatutVeh'] == $stat) : ?>
                <?= $stat ?><input type="radio" name="statut" value="<?= $stat ?>" checked>
            <?php else: ?>
                <?= $stat ?><input type="radio" name="statut" value="<?= $stat ?>">
            <?php endif; ?>
        <?php endforeach;?>
        
        <br><br>
        <button type="submit">Modifier</button>
    </form>
    <br>
    <a href="index.php">Retour</a>
</body>
</html>