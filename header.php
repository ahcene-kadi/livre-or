<nav class="navbar navbar-expand-sm navbar-blue bg-white mb-2">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Accueil </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="livre-or.php">Livre d'or </a>
        </li>
        <?php 
        if(!isset($_SESSION['connecte'])){
            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="inscription.php">Inscription </a>';
            echo '</li>';
            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="connexion.php">Connexion </a>';
            echo '</li></ul>';
        }
        if(isset($_SESSION['connecte'])){
            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="profil.php">Profil </a>';
            echo '</li>';
            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="commentaire.php">Laisser un commentaire </a>';
            echo '</li></ul>';

            echo '<form action="" method="post">';
            echo '<input class="btn btn-primary" type="submit" name="deconnexion" role="button" value="Deconnexion"></input> ';
            echo '</form>';
        }
        ?>
</nav>
<?php
if(isset($_POST['deconnexion'])){
    session_destroy();
    header('Location: index.php');
}
?>