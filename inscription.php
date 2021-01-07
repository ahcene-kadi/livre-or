


<?php
session_start();

$login = $password = $repeatpassword = '';       
$erreur = [                                                       
  'login' => '',
  'password' => '',
  'repeatpassword' => '',
  'diffpassword' => '',
  'loginpris' => ''
];

if(isset($_POST['forminscription'])){
  //verifie login
  if(empty($_POST['login'])){
    $erreur['login']='<span class="text-danger">Veuillez renseigner votre login!</span>';
  } else {
    $login=$_POST['login'];
    if(!preg_match('/^\w{0,20}$/', $login)){
      $erreur['login'] = '<span class="text-danger">Votre login doit contenir entre 0 et 20 caractères!</span>';
    }
  }
  //verifie password
  if(empty($_POST['password'])){
    $erreur['password'] = '<span class="text-danger">Veuillez renseigner votre mot de passe!</span>';
  } else {
    $password=$_POST['password'];
    if(!preg_match('/^\w{5,20}$/', $password)){
      $erreur['password'] = '<span class="text-danger">Votre mot de passe doit contenir entre 5 et 20 caractères!</span>';
    }
  }
  //verifie repeatpassword
  if(empty($_POST['repeatpassword'])){
    $erreur['repeatpassword']='<span class="text-danger">Veuillez renseigner votre mot de passe!</span>';
  } else {
    $repeatpassword=$_POST['repeatpassword'];
    if(!preg_match('/^\w{5,20}$/', $repeatpassword)){
      $erreur['repeatpassword'] = '<span class="text-danger">Votre mot de passe doit contenir entre 5 et 20 caractères!</span>';
    }
  }
  //verifie passwords identiques
  if($password !== $repeatpassword){
    $erreur['diffpassword'] = '<span class="text-danger">Les mots de passe ne sont pas identiques!</span>';
  }
  if(array_filter($erreur)){            
  } else {
    try{
      $pdo = new PDO("mysql:host=localhost;dbname=livreor","root","");    
    }
    catch(PDOexception $e){
      echo $e -> getMessage();  
      exit();
    }
    $req = $pdo -> prepare("SELECT id FROM utilisateurs WHERE login = ? limit 1");   
    $req -> setFetchMode(PDO::FETCH_ASSOC);
    $req -> execute([$_POST['login']]);
    
    if($req -> rowcount() > 0){
      $erreur['loginpris'] = '<span class="text-danger">login deja utilisé</span>';
      $pdo = null;
      $req = null;
    }
    else {
      $ins = $pdo -> prepare("INSERT INTO utilisateurs (login, password) VALUES (?, ?)");   
      $pwd_hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $ins -> execute([$_POST['login'], $pwd_hashed]);
      $pdo = null;
      $req = null;
      header('Location: connexion.php');
    }
  }
}                               
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
  </head>
<body>
<?php
include('header.php');
?>
<main>
  <div class="container">
  <h1>Inscription</h1>
      <form action="inscription.php" method="post">
        <div class="form-group">
          <label for="formGroupExampleInput">Login</label>
          <input type="text" name="login" required class="form-control" id="formGroupExampleInput" placeholder="Entrez votre login">
          <?php echo $erreur['login'];
          echo $erreur['loginpris'] ?>  
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Mot de passe</label>
          <input type="password" name="password" required class="form-control" id="exampleInputPassword1" placeholder="Entrez votre mot de passe">
          <?php echo $erreur['password'];
          echo $erreur['diffpassword'] ?>  
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Confirmation du mot de passe</label>
          <input type="password" name="repeatpassword" required class="form-control" id="exampleInputPassword1" placeholder="Confirmez votre mot de passe">
          <?php echo $erreur['repeatpassword'];
          echo $erreur['diffpassword'] ?>  
        </div>
        <button type="submit" name="forminscription" class="btn btn-primary">Inscription</button>
      </form>
  </div>
</main>
<?php    
include('footer.php');
?>
</body>
</html>

