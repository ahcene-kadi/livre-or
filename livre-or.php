<?php
session_start();

try{
    $pdo = new PDO("mysql:host=localhost;dbname=livreor","root","");    //chaine de connexion
  }
  catch(PDOexception $e){
    echo $e -> getMessage();  //gestion des erreurs
  }

  $req = $pdo -> prepare("SELECT commentaire, DATE_FORMAT(date, '%d/%m/%Y') as date, login FROM commentaires INNER JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id ORDER BY commentaires.id DESC");   //preparation des requetes
  $req -> setFetchMode(PDO::FETCH_ASSOC);
  $req -> execute();
  ?>
  <!DOCTYPE html>
  <html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <?php
  include ('header.php');
  ?>
  <main class = "ml-3">
    <h1>Livre d'or</h1>
    <h4>Commentaires</h4>
    <table class="table">
  <?php
  while($tab = $req -> fetch()){
      echo '<tr><td>posté le '.$tab['date'].' par '.$tab['login'].': <br>'.$tab['commentaire'].'</td><tr>';
    }                             
  $pdo = null;
  $req = null;
  ?>
    </table>
  </main>
  <?php    
  include'footer.php';
  ?>
  </body>