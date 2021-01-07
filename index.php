<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
include ('header.php');
?>
<main>    
<?php
if(isset($_SESSION['connecte'])){
    echo '<h1 class="row justify-content-center">Bienvenue dans notre livre d\'or  '.$_SESSION['login'].'.</h1>';
}
else {
    echo '<h1 class="row justify-content-center">Connectez-vous pour laisser un commentaire !';
}
?>
</main>
<?php    
include ('footer.php');
?>
</body>