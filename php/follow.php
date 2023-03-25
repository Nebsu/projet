<?php
    session_start();
    require_once 'config.php';
    $followname = $_GET['username'];
    $followid = $_GET['id'];

    if($followname != $_SESSION['user']){
        $alr = $bdd->prepare('SELECT * FROM follow WHERE follower = ? AND following = ? AND follower_id = ? AND following_id = ?');
        $alr->execute(array($_SESSION['user'],$followname,$_SESSION['id'],$followid));
        $alr = $alr->rowCount();
//Cas si pas abonné
        if($alr == 0){
            $addfollow = $bdd->prepare('INSERT INTO follow(follower,following,follower_id,following_id) VALUES(?,?,?,?)');
            $addfollow->execute(array($_SESSION['user'],$followname, $_SESSION['id'], $followid));
//Cas si deja abonné
        }elseif($alr == 1){
            $deletefollow = $bdd->prepare('DELETE FROM follow WHERE follower = ? AND following = ? AND follower_id = ? AND following_id = ?');
            $deletefollow->execute(array($_SESSION['user'], $followname, $_SESSION['id'], $followid));
        }
    }

    header('Location:'.$_SERVER['HTTP_REFERER']);
?>