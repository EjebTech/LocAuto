<?php
include("../../config/db.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nom_site = trim($_POST['nom_site']);

    if(!empty($nom_site)){
        $req = $conn->prepare("INSERT INTO Site (NomSite) VALUES (?)");
        $req->execute([$nom_site]);

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
        <h2><i class="fa-solid fa-car"></i> Ajouter un site</h2>
        <a href="index.php"><i class="fa-solid fa-arrow-left"></i> Retour à la liste</a>
    </div>
    <form action="create.php"  class="admin_form" method="POST" >
        <div class="form-group">
            <label>Nom : </label><input type="text" name="nom_site"  placeholder="Entrez le nom du site">
        </div>
        <div class="form-row">
            <button type="submit"><i class="fa-solid fa-floppy-disk"></i> Enregistrer le site</button>
                <button type="reset"><i class="fa-solid fa-rotate-left"></i> Réinitialiser</button>
        </div>
    </form>
</div>
    
<?php include("../../includes/footer.php");  ?>     