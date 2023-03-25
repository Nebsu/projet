<?php
	require_once 'php/config.php';
	require_once 'php/session.php';
	if (isset($_SESSION['id']) && !empty($_SESSION['id'])) $sessionid = $_SESSION['id'];
	if (isset($_SESSION['user']) && !empty($_SESSION['user'])) $pseudo = $_SESSION['user'];
	$follow= $bdd->query('SELECT following_id FROM follow WHERE follower = "'.$pseudo.'"');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title> Netdrip </title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/accueil.css">
</head>

<body>
<?php include 'navbar.php'; include 'php/youtube.php'; ?>
<br/> <br/>
<table width="100%">
<!--Affichage des posts-->
<?php include 'php/filetype.php'; $i = 0; 
	while($f = $follow->fetch()) {
	$articles = $bdd->query('SELECT * FROM posts WHERE user_id = "'.$f['following_id'].'" ORDER BY date_time_publication DESC');
	while($a = $articles->fetch()) { 
	if ($i%3==0) echo "<tr>"; ?>
	<td class="post">
	<!--Titre-->
	<a class="titre" href="article.php?id=<?= $a['id'] ?>"><?= $a['title'] ?></a> <br/>
	<!--Affichage de l'image-->
	<?php if (image_exist($a['id'])) { ?>
		<a href="article.php?id=<?= $a['id'] ?>"> 
		<?php echo "<img src=\"thumbs/";
		$ext = extension($a['id']); 
		echo $a['id'].$ext."\" width=\"400\" height=\"250\" /> <br/>";	?> </a>

	<?php } ?>
	<?php
	$yt = youtube_link($a['content']); 
	if ($yt!=" ") { ?>
		<iframe width="400" height="250" src="<?= $yt ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen> </iframe> <br/>
	<?php } ?>
	<!--Affichage du nom d'utilisateur et date-->
	<?php $userid = $a['user_id'];
	$names = $bdd->query('SELECT username FROM users WHERE id = "'.$userid.'"');
	$pseudo = $names->fetch(); ?>
	<a class="pseudo" href="profileuser.php?username=<?= $pseudo['username'] ?>&id=<?= $userid ?>\">Posté par <?= $pseudo['username'] ?></a> &emsp; 
	<?= $a['date_time_edition'] ?> <br/>
	<!--Bouton Modifier-->
	<?php if ($a['user_id']==$sessionid) { ?>
	<a class="button" href="upload.php?user=<?= $sessionid ?>&edit=<?= $a['id'] ?>"> Modifier </a> | 
	<?php } ?>
	<!--Bouton Supprimer-->
	<?php 	if (isset($_SESSION['user']) && !empty($_SESSION['user'])) $root = $_SESSION['user'];
	if ($a['user_id']==$sessionid || $root=="root") { ?>
	<a class="button" href="php/delete.php?id=<?= $a['id'] ?>"> Supprimer </a> 
	<?php } ?> <br/> <br/>
	<?php if (($i+1)%3==0) echo "</tr>";
	$i++; ?>
	</td>
<?php }}?> 
</table>
</body>
</html>