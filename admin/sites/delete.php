<?php
include("../../config/db.php");

if(isset($_GET['id']) && !empty($_GET['id'])){
    $num_site = $_GET['id'];

    $req = $conn->prepare("DELETE FROM Site WHERE NumSite = ?");
    $req->execute([$num_site]);
}

header("Location: index.php");
exit;