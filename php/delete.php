<?php
	require_once 'config.php';
	require_once 'session.php';
	// Suprresion d'un post :
	if (isset($_GET['id']) && !empty($_GET['id'])) {
		$suppr_id = htmlspecialchars($_GET['id']);

		$suppr = $bdd->prepare('DELETE FROM posts WHERE id = ?');
		$suppr->execute(array($suppr_id));

		header('Location: accueil.php');
	}
?>