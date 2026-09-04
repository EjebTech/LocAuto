<?php
    include("../../config/db.php");
    if (isset($_GET['id']) && !empty($_GET['id'])) { 
        $id = $_GET['id'];
        
        //recuperation du logo
        $req = $conn->prepare("SELECT LogoMarq FROM Marque WHERE MarqId = ?");
        $req->execute([$id]);
        $marque = $req->fetch();
        
        if($marque){
            //Suppression de l'image si elle existe
            if(!empty($marque['LogoMarq'])){
                $chemin_image = "../../assets/uploads/logos/" . $marque['LogoMarq'];
                if(file_exists($chemin_image)){
                    unlink($chemin_image);
                }
            }

            //Suppression du logo
            $del_logo = $conn->prepare("DELETE FROM Marque WHERE MarqId=?");
            $del_logo->execute([$id]);
            
            header("Location: index.php");
            exit;
        }
    
    }
    ?>