<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php
        include("../../config/db.php");
        

        //Récuperer le nom de la marque
        if (isset($_GET['id']) && !empty($_GET['id'])) { 
            $id = $_GET['id'];
            $req = $conn->prepare("SELECT * FROM Marque WHERE MarqId=?");
            $req->execute([$_GET['id']]);
            $marque = $req->fetch();
            if(!$marque){
                header("Location: index.php");
                exit;
            }

        }else {
            header("Location: index.php");
            exit;
        }

        //Changer le logo (si souhaité)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_marque=$_POST['nom_marque'];
            $logo_final = $marque['LogoMarq']; //nom de l'ancien logo
            
            $extensions_autorisees = ['jpg','png', 'webp', 'jpeg'];
            $chemin_logo = "../../assets/uploads/logos/" . $logo_final; //chemin de l'ancien logo
            if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0){
                $file_extension = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION)); //extension
                if(in_array($file_extension, $extensions_autorisees)){
                    $nouveau_nom = uniqid("logo_") . ".". $file_extension;
                    move_uploaded_file($_FILES['image_file']['tmp_name'], "../../assets/uploads/logos/" . $nouveau_nom);
                    if(file_exists($chemin_logo)){
                        unlink($chemin_logo);
                    }
                    $logo_final = $nouveau_nom;
                    
                }
            }
        


            $req = $conn->prepare("UPDATE Marque SET Marqlib=?, LogoMarq=? WHERE MarqId=?");
            $req->execute([$nom_marque, $logo_final, $id]);
            header("Location: index.php");
            exit;
        }

    ?>

    <h1>Modifier une marque</h1>

    <form method="POST" enctype="multipart/form-data">
        <label>Nom : </label><input type="text" name="nom_marque" value="<?= htmlspecialchars($marque['Marqlib']) ?>" placeholder="Entrez le nom de la marque">
        <br><br>
        <label>Logo actuel :</label><br>
        <?php if (!empty($marque['LogoMarq'])): ?>
            <img class="logo_img" src="../../assets/uploads/logos/<?= htmlspecialchars($marque['LogoMarq']) ?>" alt="Logo actuel">
        <?php else: ?>
            <p>Pas de logo actuellement</p>
        <?php endif; ?>
        <br>
        <label>Changer le logo (optionnel) : </label>
        <br><br>
        <input type="file" name="image_file" accept="image/*">
        <br>
        <button type="submit">Enregistrer les modifications</button>
        <a href="index.php">Annuler</a>
    </form>
</body>
</html>