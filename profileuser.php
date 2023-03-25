<?php 
    require_once 'php/config.php';
    require_once 'php/session.php';
    if(isset($_GET['username']) && isset($_GET['id'])){
        $getusername = $_GET['username'];
        $getid = $_GET['id'];
        $check = $bdd->prepare('SELECT * FROM users WHERE username = ?');
        $check->execute(array($getusername));
        $user = $check->fetch();
    }
    if (isset($_SESSION['id']) && !empty($_SESSION['id'])) $sessionid = $_SESSION['id'];
    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) $pseudo = $_SESSION['user'];
    $articles = $bdd->query('SELECT * FROM posts WHERE user_id = "'.$getid.'" ORDER BY date_time_publication DESC');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
        <meta charset="utf-8">
        <title> Profil </title>
        <link rel="stylesheet" href="css/myprofile.css">
</head>
    <body>
        <?php include "navbar.php"; ?>
            <h1 class="profile"><?php echo $user['username']; ?>

        <!--Bouton follow-->
        <?php
        if(isset($_SESSION['user']) AND ($_SESSION['user'] != $getusername)){
            $isfollowing = $bdd->prepare('SELECT * FROM follow WHERE follower = ? AND following = ? 
                AND follower_id = ? AND following_id = ?');
            $isfollowing->execute(array($_SESSION['user'], $getusername, $_SESSION['id'], $getid));
            $isfollowing = $isfollowing->rowCount();
            if($isfollowing == 1){
        ?>
           <a class="followbutton" href="php/follow.php?username=<?= $getusername; ?>&id=<?= $getid; ?>"><p> Se désabonner </p></a>
        <?php
        }else{ 
        ?>
            <a class="followbutton" href="php/follow.php?username=<?= $getusername; ?>&id=<?= $getid; ?>"><p> S'abonner </p></a>
        <?php
            }
        }
        ?>
        </h1>
        <hr>
        <br />
        <!--Récupération du nombre de following-->
        <?php
            if(isset($_SESSION['user'])){
                $followcount = $bdd->prepare('SELECT COUNT(*) AS nb FROM follow WHERE follower = ?'); 
                $followcount->execute(array($getusername));
                $data = $followcount->fetch();
            }
        ?>
        <!--Récupération du nombre de follower-->
        <?php
            if(isset($_SESSION['user'])){
                $followercount = $bdd->prepare('SELECT COUNT(*) AS nbb FROM follow WHERE following = ?'); 
                $followercount->execute(array($getusername));
                $datab = $followercount->fetch();
            }
        ?>
        <div class="main" style="margin-left:14.5%">
            <?php echo $data['nb']; ?> Following
            <span id="followers"> <?php echo $datab['nbb']; ?> Followers </span>
        <!--Bouton Message-->
        <?php
            if(isset($_SESSION['user']) AND ($_SESSION['user'] != $getusername)){ ?>
                <a class="message" href="message.php?username=<?php echo $getusername; ?>"><p> Envoyer un message </p></a>
                </div> <br/>
            <?php } ?>
        <hr> 
        <div class="content">
        <h2> Posts </h2>
        <?php include 'php/filetype.php'; include 'php/youtube.php';
        while($a = $articles->fetch()) { ?>
            <a class="titre" href="article.php?id=<?= $a['id'] ?>"><?= $a['title'] ?></a> <br/>
            <?php if (image_exist($a['id'])) { ?>
                <a href="article.php?id=<?= $a['id'] ?>"> 
                <?php echo "<img src=\"thumbs/";
                $ext = extension($a['id']); 
                echo $a['id'].$ext."\" width=\"400\" height=\"250\" /> <br/>";  ?> </a>
            <?php }  
            $yt = youtube_link($a['content']); 
            if ($yt!=" ") { ?>
                <iframe width="400" height="250" src="<?= $yt ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen> </iframe> <br/>
            <?php } ?>
            <?php $userid = $a['user_id'];
            $names = $bdd->query('SELECT username FROM users WHERE id = "'.$userid.'"');
            $pseudo = $names->fetch(); ?>
            <a class="pseudo" href="profileuser.php?username=<?= $pseudo['username'] ?>&id=<?= $userid ?>\">Posté par <?= $pseudo['username'] ?></a> &emsp; 
            <span style="color:white"> <?= $a['date_time_edition'] ?> </span><br/>
            <?php  if ($a['user_id']==$sessionid) {  ?>
                <a class="button" href="upload.php?user=<?= $sessionid ?>&edit=<?= $a['id'] ?>"> Modifier </a> | 
            <?php } ?>
            <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) $root = $_SESSION['user'];
                  if ($a['user_id']==$sessionid || $root=="root") { ?>
                <a class="button" href="php/delete.php?id=<?= $a['id'] ?>"> Supprimer </a> <br/> <br/> 
            <?php }} ?> 

   
        </div>
    </body>
</html>