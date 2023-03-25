<?php
require_once 'php/config.php';
require_once 'php/session.php';
$usernameb = $_SESSION['user'];
$followers = $bdd->query('SELECT follower, follower_id FROM follow WHERE following="'.$usernameb.'"');
$following = $bdd->query('SELECT following, following_id FROM follow WHERE follower="'.$usernameb.'"');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title> Followers </title>
    <link rel="stylesheet" href="css/styleb.css">
</head>
<body>
    <?php include "navbar.php" ?>
<!--Barre de navigation latérale-->
    <div class="sidenav">
        <a href="profile.php">Profil</a>
        <a href="profilefollow.php"> Abonnements </a>
        <a class="disconnect" href="php/disconnect.php"> Déconnexion </a>
    </div>
<!--Main-->
    <div class="main" style="margin-left:15%">
    <h1> Abonnés </h1>
    <?php
    while($usernameb=$followers->fetch()){
    ?>
        <a class="link" href="profileuser.php?username=<?php echo $usernameb['follower']; ?>&id=<?= $usernameb['follower_id']?>"><?php echo $usernameb['follower']; ?></a>
        <?php if(isset($_SESSION['user'])) { ?>
                <a class="message" href="message.php?username=<?= $usernameb['follower'] ?>"><p> Envoyer un message</p></a>
        <?php } ?>
        <br>
    <?php } ?>
    <hr>

    <h1> Abonnements </h1>
    <?php
    while($usernameb=$following->fetch()){
    ?>
        <a class="link" href="profileuser.php?username=<?php echo $usernameb['following']; ?>&id=<?= $usernameb['following_id']?>"><?php echo $usernameb['following']; ?></a>
        <?php if(isset($_SESSION['user'])) { ?>
            <a class="message" href="message.php?username=<?= $usernameb['following'] ?>"><p> Envoyer un message</p></a>
        <?php } ?>
        <br>
    <?php
      }
    ?>
    </div>
</body>
</html>