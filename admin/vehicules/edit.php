
    
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

<?php 
$css_path = "../../assets/css/style.css";
include("../../includes/header.php"); 
?>
    <div class="formulaire_vehicule">
        <div class="form_header">
            <h2><i class="fa-solid fa-car"></i> Modiifer un Véhicule</h2>
            <a href="index.php"><i class="fa-solid fa-arrow-left"></i> Retour à la liste</a>
        </div>
        <form action="" class="admin_form" method="post" enctype="multipart/form-data">
            

            <div class="form-group">
                <label>Immatriculation * </label>
                <input type="text" name="imm_vehicule" value="<?=$vehicule['ImVeh']?>" placeholder="L'immatriculation du véhicule" required>
            </div>

            <div class="form-group">
                <label>Marque * </label>
                <select name="marque_vehicule">
                    <?php if($marques) :?>
                        <?php foreach($marques as $marque):?>
                            <option value="<?= htmlspecialchars($marque['MarqId']) ?>" <?= ($marque['MarqId'] == $vehicule['MarqId']) ? 'selected' : '' ?>>
                                <?=htmlspecialchars($marque['Marqlib'])?>
                            </option>
                        <?php endforeach ?>
                    <?php endif;?>
                </select>
            </div>

            <div class="form-group">
                <label>Modèle * </label>
                <input type="text" name="modele_vehicule" value="<?=$vehicule['ModeleVeh']?>" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">    
                    <label>Couleur * </label>
                    <input type="text" name="couleur_vehicule" value = "<?=$vehicule['CoulVeh']?>" required>
                </div>

                <div class="form-group">
                    <label>Prix journalier * </label>
                    <input type="number" name="prix_jour" value="<?=htmlspecialchars($vehicule['PrixJour'])?>" required>
                </div>
            </div>
            
            
            <div class="form-row">
                <div class="form-group">
                    <label>Site de rattachement * </label>
                    <select name="site">
                        <?php if($sites) :?>
                            <?php foreach($sites as $site):?>
                                <option value="<?= htmlspecialchars($site['NumSite']) ?> " <?= ($site['NumSite'] == $vehicule['NumSite']) ? 'selected' : '' ?>>
                                    <?=htmlspecialchars($site['NomSite'])?>
                                </option>
                            <?php endforeach ?>
                        <?php endif;?>
                    </select>
                </div>
                
                <?php $statut_liste = ["Disponible", "En maintenance", "Loué", "En panne"] ?>
                    
                <div class="form-group">
                    <label>Statut actuel * </label>
                    <select name="statut">
                        <?php foreach($statut_liste as $stat): ?>
                            <?php if($vehicule['StatutVeh'] == $stat) : ?>
                                <option value="<?= $stat ?>" selected>
                                    <?= $stat ?>
                                </option>
                            <?php else: ?>
                                <option value="<?= $stat ?>"><?= $stat ?></option>
                            <?php endif; ?>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            
            <div class="form-group image-preview-container">
                <label>Image actuelle :</label>
                <?php if(!empty($vehicule['ImgVeh'])): ?>
                    <div class="img-wrapper">
                        <img class="vehicule_img_preview" src="../../assets/uploads/vehicules/<?=htmlspecialchars($vehicule['ImgVeh'])?>" alt="Image du véhicule actuel">
                    </div>
                <?php else: ?>
                    <p class="no-img-text">Aucune image enregistrée.</p>
                <?php endif; ?>
            </div>
            
            <div class="form-group">    
                <label>Entrez l'image du véhicule : </label>
                <input type="file" name="image_vehicle" accept="image/*">
            </div>
            <div class="form-row">
                <button type="submit"><i class="fa-solid fa-pencil"></i> Modifier le véhicule</button>
            </div>
        </form>
        <br>
        
    </div>    
<?php include("../../includes/footer.php");?>