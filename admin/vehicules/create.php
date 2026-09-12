
    
    
    <?php
        include("../../config/db.php");
        $req = $conn->query("SELECT * FROM Marque");
        $marques = $req->fetchAll();
        $req2=$conn->query("SELECT * FROM Site");
        $sites = $req2->fetchAll();

        //Envoi de l'image
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $immat = trim($_POST['imm_vehicule']);
            $couleur_vehicule = trim($_POST['couleur_vehicule']);
            $prix = trim($_POST['prix_jour']);
            $marque_vehicule = $_POST['marque_vehicule'];
            $modele = $_POST['modele_vehicule'];
            $new_name = null;
            $site = $_POST['site'];
            $statut = $_POST['statut'];

            if(isset($_FILES['image_vehicle']) && $_FILES['image_vehicle']['error'] == 0){
                $img_file_name = $_FILES['image_vehicle']['name'];
                $img_file_ext = strtolower(pathinfo($img_file_name, PATHINFO_EXTENSION));
                $img_tmp_name = $_FILES['image_vehicle']['tmp_name'];
                $new_name = uniqid('Vehicule_') . '.' . $img_file_ext;
                
                
                $extensions_autorisees = ['jpg','png', 'webp', 'jpeg'];
                if(in_array($img_file_ext, $extensions_autorisees)){
                    move_uploaded_file($img_tmp_name, "../../assets/uploads/vehicules/" . $new_name);
                     
                }else{
                    echo "Seuls les extensions 'jpg, jpeg, webp et png' sont autorisées";
                }
                
            }

            $req4 = $conn->prepare("INSERT INTO Vehicule (ImgVeh, Imveh, ModeleVeh, CoulVeh, StatutVeh, PrixJour, MarqId, NumSite) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $req4->execute([$new_name, $immat, $modele, $couleur_vehicule, $statut, $prix, $marque_vehicule, $site]);
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
            <h2><i class="fa-solid fa-car"></i> Ajouter un Véhicule</h2>
            <a href="index.php"><i class="fa-solid fa-arrow-left"></i> Retour à la liste</a>
        </div>
        <form action="" class="admin_form" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Immatriculation *</label>
                <input type="text" name="imm_vehicule" placeholder="Ex: AA059AA" required>
            </div>

            <div class="form-group">
                <label>Modèle du véhicule * </label>
                <input type="text" name="modele_vehicule" placeholder="Ex: Rav4, SUV 3008, Corolla, Sorento..." required>
            </div>

            <div class="form-group">
                <label>Couleur * </label>
                <input type="text" name="couleur_vehicule" required>
            </div>
            
            <div class="form-row">   
                <div class="form-group">
                    <label>Marque *</label>
                    <select name="marque_vehicule">
                        <option value="">--Veuillez selectionner une marque--</option>
                        <?php if($marques) :?>
                            <?php foreach($marques as $marque):?>
                                <option value="<?= htmlspecialchars($marque['MarqId']) ?>"><?=htmlspecialchars($marque['Marqlib'])?></option>
                            <?php endforeach ?>
                        <?php endif;?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Site d'attachement *</label>
                    <select name="site">
                        <?php if($sites) :?>
                            <option value="">--Veuillez selectionner un site--</option>
                            <?php foreach($sites as $site):?>
                                <option value="<?= htmlspecialchars($site['NumSite']) ?>"><?=htmlspecialchars($site['NomSite'])?></option>
                            <?php endforeach ?>
                        <?php endif;?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Prix journalier (FCFA / Jour) * </label>
                    <input type="number" name="prix_jour"  required>
                </div>
                <div class="form-group">
                    <label>Statut initial * </label>
                    <select name="statut">
                        <option value="Disponible" selected>Disponible</option>
                        <option value="loue">En location</option>
                        <option value="En maintenance">En maintenance</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Photo du véhicule </label>
                <input type="file" name="image_vehicle" accept="image/*">
            </div>
            <p>NB : Formats acceptés : png, jpeg, jpg, webp</p>

            <div class="form-row">    
                <button type="submit"><i class="fa-solid fa-floppy-disk"></i> Enregistrer le véhicule</button>
                <button type="reset"><i class="fa-solid fa-rotate-left"></i> Réinitialiser</button>
            </div>

        </form>
        
    </div>
<?php include("../../includes/footer.php");?>