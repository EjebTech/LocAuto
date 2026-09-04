<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

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







    <h1>Ajouter une marque</h1>
    <form action="create.php" method="POST" enctype="multipart/form-data">
        <label>Nom : </label><input type="text" name="nom_marque"  placeholder="Entrez le nom de la marque">
        <br>
        <input type="file" name="image_file" accept="image/*">
        <button type="submit">Ajouter</button>
    </form>

    <a href="index.php"><-Retour</a>
</body>
</html>