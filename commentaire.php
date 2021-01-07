<?php
session_start();

$erreur = [                                                       //tableau de gestion d'erreurs
  'commentaire' => ''
];   

if(!$_SESSION['connecte']){
  header('Location: index.php');
}
if(isset($_POST['formcommentaire'])){
  //verifie le commentaire
  if(empty($_POST['commentaire'])){
    $erreur['commentaire']='<span class="text-danger">Veuillez rentrer un commentaire.</span>';
  } else {
    try{
      $pdo = new PDO("mysql:host=localhost;dbname=livreor","root","");    //chaine de connexion
    }
    catch(PDOexception $e){
      echo $e -> getMessage();  //gestion des erreurs
      exit();
    }
    $today = date("Y-m-d H:i:s");  
    $ins = $pdo -> prepare("INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES (?, ?, ?)");   //preparation des requetes
    $ins -> execute([$_POST['commentaire'], $_SESSION['id'], $today]);
    $ins = null;
    $pdo = null;
  }
}                               
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout d'un commentaire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
  </head>
<body>
<?php
include('header.php');
?>
<main>
  <div class="container">
  <h1>Ajout d'un commentaire</h1>
  <form action="commentaire.php" method="post">
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Commentaire :</label>
    <textarea class="form-control" name="commentaire" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>
  <button type="submit" name="formcommentaire" class="btn btn-primary">Poster</button>
  </form>
  </div>
</main>
<?php    
include('footer.php');
?>
</body>
</html>