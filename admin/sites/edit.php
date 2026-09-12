<?php
include("../../config/db.php");

if(isset($_GET['id']) && !empty($_GET['id'])){
    $num_site = $_GET['id'];

    $req = $conn->prepare("SELECT * FROM Site WHERE NumSite = ?");
    $req->execute([$num_site]);
    $site = $req->fetch();

    if(!$site){
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nom_site = trim($_POST['nom_site']);

    if(!empty($nom_site)){
        $req2 = $conn->prepare("UPDATE Site SET NomSite = ? WHERE NumSite = ?");
        $req2->execute([$nom_site, $num_site]);

        header("Location: index.php");
        exit;
    }
}
?>

<?php 
$css_path = "../../assets/css/style.css";
include("../../includes/header.php"); 
?>
    <<div class="formulaire_vehicule">
        <form method="POST" class="admin_form" enctype="multipart/form-data">
            <div class="form_header">
                <h2><i class="fa-solid fa-car"></i> Modiifer un site</h2>
                <a href="index.php"><i class="fa-solid fa-arrow-left"></i> Retour à la liste</a>
            </div>

            <div class="form-group">
                <label>Nom : </label><input type="text" name="nom_site" value="<?= htmlspecialchars($site['NomSite']) ?>" >
            </div>

            
            <div class="form-row">    
                <button type="submit"><i class="fa-solid fa-pencil"></i> Modifier le site</button>
            </div>
        </form>
    </div>
<?php include("../../includes/footer.php");  ?>