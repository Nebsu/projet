<?php
require_once 'php/config.php';
require_once 'php/session.php';
if (!isset($_SESSION['id']) || $_SESSION['id']!=1) { // vérifie si l'utilisateur est admin
	exit('Accès refusé');
}
$membres = $bdd->query('SELECT * FROM users ORDER BY id DESC');
$posts = $bdd->query('SELECT * FROM posts ORDER BY id DESC');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title> QG Admin </title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/accueil.css">
</head>

<body>
<?php include 'navbar.php' ?>
	<h1> Gestion des utilisateurs </h1>
	<ul class='admin'>
		<!-- Administration des membres -->
		<?php while($m = $membres->fetch()) { ?>
			<li> ID = <?= $m['id'] ?>&emsp;&emsp;&emsp; <?= $m['username'] ?>
				<?php if($m['bannir']==0) { ?> 			
				&emsp;&emsp;&emsp; <a style="color:red;" class='admin' href="admin.php?type=membre&bannir=<?= $m['username'] ?> "> Bannir </a> 
				<?php } ?>
			</li>
		<?php } ?>
	</ul> <br/>
	
	<h1> Gestion des publications </h1>
	<ul class='admin'>
		<!-- Administration des publications -->
		<?php while($p = $posts->fetch()) { ?>
			<li> <?= $p['id'] ?> : <?= $p['title'] ?>
				<?php if($p['supprime']==0) { ?>
				- <a style="color:red;" class='admin' href="admin.php?type=post&supprime=<?= $p['id'] ?> "> Supprimer </a>
				<?php } ?>
			</li>
		<?php } ?>
	</ul> <br/> <br/>
	<?php
	// Détection bannisement membre
	if (isset($_GET['type']) && $_GET['type']=='membre') {
		if (isset($_GET['bannir']) && !empty($_GET['bannir'])) {
			$user = $_GET['bannir'];
			$req = $bdd->prepare('DELETE FROM users WHERE username=?');
			$req->execute(array($user));
			$deletefollow = $bdd->prepare('DELETE FROM follow WHERE follower = ?');
            $deletefollow->execute(array($user));
			$deletefollowb = $bdd->prepare('DELETE FROM follow WHERE  following = ?');
            $deletefollowb->execute(array($user));
		} // Détection suppression de post
	} else if (isset($_GET['type']) && $_GET['type']=='post') {
		if (isset($_GET['supprime']) && !empty($_GET['supprime'])) {
			$supprime = (int) $_GET['supprime'];
			$req = $bdd->prepare('DELETE FROM posts WHERE id = ?');
			$req->execute(array($supprime));
		}
	}
	?>
</body>
</html>