<?php
    include("../../config/db.php");
    if(isset($_GET['id']) && !empty($_GET['id'])){
        $immat_veh = $_GET['id'];

        //recuperer l'image puis la supprimer
        $req = $conn->prepare("SELECT ImgVeh FROM Vehicule WHERE ImVeh=?");
        $req->execute([$immat_veh]);
        $image_vehicule = $req->fetch();


        if(!empty($image_vehicule['ImgVeh'])){
            $chemin_image = "../../assets/uploads/vehicules/" . $image_vehicule['ImgVeh'];
            if(file_exists($chemin_image)){
                unlink($chemin_image);
            }


            
        }

        //Suppression du vehicule
        $req2 = $conn->prepare("DELETE FROM Vehicule WHERE ImVeh=?");
        $req2->execute([$immat_veh]);
        header("Location: index.php"); 
        exit;

        
    }else{
        header("Location: index.php"); 
        exit;
    }

?>