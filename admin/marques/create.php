
<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
    $nom_marque = trim($_POST['nom_marque']);
    $new_name = null;

    include("../../config/db.php");
    if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0){
        $file_name = $_FILES['image_file']['name'];  //récuperer le nom du fichier
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION)); //Récuperer l'extension du fichier
        $tmp_name = $_FILES['image_file']['tmp_name']; // le nom temporaire du fichier
        $new_name = uniqid('logo_') . '.' . $file_extension;

        $extensions_autorisees = ['jpg','png', 'webp', 'jpeg'];
        if(in_array($file_extension, $extensions_autorisees)){
            if(move_uploaded_file($tmp_name, "../../assets/uploads/logos/" . $new_name)){
                echo "Fichier envoyé avec succès";
            }
        }else{
            echo "Seuls les extensions 'jpg, jpeg, webp et png' sont autorisées";
        }
    }

    if(!empty($nom_marque)){
        $sql = "INSERT INTO Marque Values(NULL,?,?)";
        $req = $conn->prepare($sql);
        $exec = $req->execute([$nom_marque, $new_name]);
        header("Location: index.php");
    }else{
        echo "<p> Veuillez saisir un nom de marque </p>";
    }
}
?>




<?php 
$css_path = "../../assets/css/style.css";
include("../../includes/header.php"); 
?>

<div class="formulaire_vehicule">
    <div class="form_header">
        <h2><i class="fa-solid fa-car"></i> Ajouter une Marque</h2>
        <a href="index.php"><i class="fa-solid fa-arrow-left"></i> Retour à la liste</a>
    </div>
    <form action="create.php"  class="admin_form" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nom : </label><input type="text" name="nom_marque"  placeholder="Entrez le nom de la marque">
        </div>
        <div class="form-group">
            <input type="file" name="image_file" accept="image/*">
        </div>
        <div class="form-row">
            <button type="submit"><i class="fa-solid fa-floppy-disk"></i> Enregistrer la marque</button>
                <button type="reset"><i class="fa-solid fa-rotate-left"></i> Réinitialiser</button>
        </div>
    </form>
</div>
<?php include("../../includes/footer.php");  ?>