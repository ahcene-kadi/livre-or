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

if(!$_SESSION['connecte']){
  header('Location: index.php');
}

if(isset($_POST['formprofil'])){
  //verifie login
  if(empty($_POST['login'])){
    $erreur['login'] = '<span class="text-danger">Veuillez renseigner votre login!</span><br>';
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
      $erreur['password'] = '<span class="text-danger">Votre password doit contenir entre 5 et 20 caractères!</span>';
    }
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
    $req = $pdo -> prepare("UPDATE utilisateurs SET login = ?, password = ? WHERE id = ? limit 1");   
    $req -> setFetchMode(PDO::FETCH_ASSOC);
    $pwd_hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $req -> execute([$_POST['login'], $pwd_hashed, $_SESSION['id']]);
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['password'] = $_POST['password'];
    $pdo = null;
    $req = null;
  }
}
                               
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
  </head>
<body>
<?php
include'header.php';
?>
<main>
  <div class="container">
  <h1>Profil</h1>
      <form action="profil.php" method="post">
        <div class="form-group">
          <label for="formGroupExampleInput">Login</label>
          <input type="text" name="login" required class="form-control" id="formGroupExampleInput" value=<?php echo $_SESSION['login'] ?>>
          <?php echo $erreur['login'];
          echo $erreur['loginpris'] ?>  
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Mot de passe</label>
          <input type="password" name="password" required class="form-control" id="exampleInputPassword1" value=<?php echo $_SESSION['password'] ?>>
          <?php echo $erreur['password'];
          echo $erreur['diffpassword'] ?>  
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Confirmation du mot de passe</label>
          <input type="password" name="repeatpassword" required class="form-control" id="exampleInputPassword1" value=<?php echo $_SESSION['password'] ?>>
          <?php echo $erreur['repeatpassword'];
          echo $erreur['diffpassword'] ?>  
        </div>
        <button type="submit" name="formprofil" class="btn btn-primary">Modifier mon profil</button>
      </form>
  </div>
</main>
<?php    
include'footer.php';
?>
</body>
</html>