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


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un site</title>
</head>
<body>
    <h1>Ajouter un nouveau site</h1>
    <form action="" method="post">
        <label>Nom du site : </label>
        <input type="text" name="nom_site" required>
        <br><br>
        <button type="submit">Ajouter</button>
    </form>
    <br>
    <a href="index.php">Retour</a>
</body>
</html>