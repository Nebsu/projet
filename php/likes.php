<?php
require_once 'config.php';
require_once 'session.php';

if (isset($_GET['t'], $_GET['id']) && (!empty($_GET['t']) && !empty($_GET['id']))) {
	$getid = (int) $_GET['id'];
	$gett = (int) $_GET['t'];
	if (isset($_SESSION['id']) && !empty($_SESSION['id'])) $sessionid = $_SESSION['id'] ; 
	$check = $bdd->prepare('SELECT id FROM posts WHERE id = ?');
	$check->execute(array($getid));
	if ($check->rowCount()==1) {
		if ($gett==1) {
			$check_like = $bdd->prepare('SELECT id FROM likes WHERE id_post = ? AND id_user = ?');
			$check_like->execute(array($getid, $sessionid));
			$del = $bdd->prepare('DELETE FROM dislikes WHERE id_post= ? AND id_user = ?');
			$del->execute(array($getid, $sessionid));
			if ($check_like->rowCount()==1) {
				$del = $bdd->prepare('DELETE FROM likes WHERE id_post = ? AND id_user = ?');
				$del->execute(array($getid, $sessionid));
			} else {
				$ins = $bdd->prepare('INSERT INTO likes (id_post, id_user) VALUES (?, ?)');
				$ins->execute(array($getid, $sessionid));
			}
		} else if($gett==2) {
			$check_like = $bdd->prepare('SELECT id FROM dislikes WHERE id_post = ? AND id_user = ?');
			$check_like->execute(array($getid, $sessionid));
			$del = $bdd->prepare('DELETE FROM likes WHERE id_post= ? AND id_user = ?');
			$del->execute(array($getid, $sessionid));
			if ($check_like->rowCount()==1) {
				$del = $bdd->prepare('DELETE FROM dislikes WHERE id_post = ? AND id_user = ?');
				$del->execute(array($getid, $sessionid));
			} else {
				$ins = $bdd->prepare('INSERT INTO dislikes (id_post, id_user) VALUES (?, ?)');
				$ins->execute(array($getid, $sessionid));
			}
		}
		header('Location: http://projet/article.php?id='.$getid);
	} else {
		exit('Erreur fatale. <a href="accueil.php"> Revenir à l\'accueil </a>');
	}
} else {
	exit('Erreur fatale. <a href="accueil.php"> Revenir à l\'accueil </a>');
}
?>