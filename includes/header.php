<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - LocAuto</title>
    <link rel="stylesheet" href="<?= $css_path ?? '../assets/css/style.css' ?>?v=1.1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>
    <header class="nav-bar">
        <div class="title">
            <h1><a style="color: white; text-decoration: none;" href="/LocAuto/admin/index.php"><span>L</span>oc<span>A</span>uto</a></h1>
        </div>
        <nav>
            <ul>
                <li><a href="/LocAuto/admin/index.php">Dashboard Admin</a></li>
                <li><a href="/LocAuto/admin/vehicules/index.php">Véhicules</a></li>
                <li><a href="/LocAuto/admin/sites/index.php">Sites</a></li>
                <li><a href="/LocAuto/admin/marques/index.php">Marques</a></li>
                <li><a href="/LocAuto/admin/reservations/index.php">Réservations</a></li>
            </ul>
        </nav>
    </header>
    <main class="main-content">