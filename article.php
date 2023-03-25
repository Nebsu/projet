<?php
	require_once 'php/config.php';
	require_once 'php/session.php';
	if (isset($_GET['id']) && !empty($_GET['id'])) {
		$get_id = htmlspecialchars($_GET['id']);
		$article = $bdd->prepare('SELECT * FROM posts WHERE id = ?');
		$article->execute(array($get_id));
		if ($article->rowCount() == 1 ) {
			$article = $article->fetch();
			$id = $article['id'];
			$titre = $article['title'];
			$contenu = $article['content'];

			$likes = $bdd->prepare('SELECT id FROM likes WHERE id_post = ?');
			$likes->execute(array($id));
			$likes = $likes->rowCount();

			$dislikes = $bdd->prepare('SELECT id FROM dislikes WHERE id_post = ?');
			$dislikes->execute(array($id));
			$dislikes = $dislikes->rowCount();
		} else {
			die('Cet article n\'existe pas');
		}
	} else {
		die('Erreur');
	}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title> Netdrip </title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/article.css">
</head>

<body>
	<?php include 'navbar.php'; ?>
	<h1 class="titre"> <?= $titre ?> </h1>
	<p class="contenu"> <?= $contenu ?> </p> <br/>
	<?php include 'php/filetype.php';
	if (image_exist($article['id'])) {
		echo "<img class=\"image\" src=\"thumbs/";
		$ext = extension($article['id']); 
		echo $article['id'].$ext."\" width=\"600\" height=\"400\" /> <br/>"; 
	} ?>
	<?php
		include 'php/youtube.php';
		$li = youtube_link($contenu); 
		if ($li!=" ") { ?>
		<iframe width="800" height="400" src="<?= $li ?>" title="YouTube video player" 
		frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
		</iframe> <br/> <br/>
	<?php } ?>
	<a class="like" href="php/likes.php?t=1&id=<?= $id ?>"><img class="like" src="css/like.png" width="50px"/> </a> 
	<span class="count"> <?= $likes ?> </span>
	<a href="php/likes.php?t=2&id=<?= $id ?>"><img class="like" src="css/dislike.png" width="50px"/></a> 
	<span class="count"> <?= $dislikes ?> </span>
</body>
</html>