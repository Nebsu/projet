<?php 
    require_once 'php/config.php';
    require_once 'php/session.php';
    if (isset($_SESSION['id']) && !empty($_SESSION['id'])) $sessionid = $_SESSION['id'];
    $articles = $bdd->query('SELECT * FROM posts WHERE user_id = "'.$sessionid.'" ORDER BY date_time_publication DESC');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title> Profil </title>
    <link rel="stylesheet" href="css/myprofile.css">
</head>
<body>
    <?php include "navbar.php" ?>
<!--Barre de navigation latérale-->
    <div class="sidenav">
    <a href="profile.php">Profil</a>
    <a href="profilefollow.php"> Abonnements </a>
    <a class="disconnect" href="php/disconnect.php"> Déconnexion </a>
    </div>
<!--Informations-->
    <div class="main" style="margin-left:15%">
        <h1> Bonjour <?= $_SESSION['user'] ?> ! </h1>
        <p>Pseudo : <?php echo $_SESSION['user']; ?></p>
        <p>Email : <?php echo $_SESSION['email']; ?></p>
        <hr>
        <h2> Posts </h2>
    </div> 
    <div class="content" style="margin-left:15%">
    <?php include 'php/filetype.php'; include 'php/youtube.php';
        while($a = $articles->fetch()) { ?>
            <a class="titre" href="article.php?id=<?= $a['id'] ?>"><?= $a['title'] ?></a> <br/>
            <?php if (image_exist($a['id'])) { ?>
                <a href="article.php?id=<?= $a['id'] ?>"> 
                <?php echo "<img src=\"thumbs/";
                $ext = extension($a['id']); 
                echo $a['id'].$ext."\" width=\"400\" height=\"250\" /> <br/>";  ?> </a>
            <?php } ?>
            <?php
            $yt = youtube_link($a['content']); 
            if ($yt!=" ") { ?>
                <iframe width="400" height="250" src="<?= $yt ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen> </iframe> <br/>
            <?php } ?>
            <?php $userid = $a['user_id'];
            $names = $bdd->query('SELECT username FROM users WHERE id = "'.$userid.'"');
            $pseudo = $names->fetch(); ?>
            <a class="pseudo" href="profileuser.php?username=<?= $pseudo['username'] ?>&id=<?= $userid ?>\">Posté par <?= $pseudo['username'] ?></a> &emsp; 
            <span style="color:white;"><?= $a['date_time_edition'] ?></span> <br/>
            <?php if ($a['user_id']==$sessionid) { ?>
                <a class="button" href="upload.php?user=<?= $sessionid ?>&edit=<?= $a['id'] ?>"> Modifier </a> | 
            <?php } ?>
            <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) $root = $_SESSION['user'];
            if ($a['user_id']==$sessionid || $root=="root") { ?>
                <a class="button" href="php/delete.php?id=<?= $a['id'] ?>"> Supprimer </a> 
            <?php } ?> <br/> <br/>
        <?php } ?>
    </div>

</body>
</html>