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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un site</title>
</head>
<body>
    <h1>Modifier le site</h1>
    <form action="" method="post">
        <label>Nom du site : </label>
        <input type="text" name="nom_site" value="<?= htmlspecialchars($site['NomSite']) ?>" required>
        <br><br>
        <button type="submit">Modifier</button>
    </form>
    <br>
    <a href="index.php">Retour</a>
</body>
</html>