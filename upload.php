<?php 
	require_once 'php/config.php';
	require_once 'php/session.php';

	$edit_mode = false;
	if (isset($_GET['edit']) && !empty($_GET['edit'])) {
		$edit_mode = true;
		$edit_id = htmlspecialchars(($_GET['edit']));
		$edit_post = $bdd->prepare('SELECT * FROM posts WHERE id = ?');
		$edit_post->execute(array($edit_id));

		if ($edit_post->rowCount()==1) {
			$edit_post = $edit_post->fetch();
		} else {
			die('Erreur : l\'article n\'existe pas ...');
		}
	}

	if (isset($_POST['article_titre'], $_POST['article_contenu'])) {
		if (!empty($_POST['article_titre']) && !empty($_POST['article_contenu'])) {
			if (isset($_GET['user']) && !empty($_GET['user'])) {
			$article_titre = htmlspecialchars($_POST['article_titre']);
			$article_contenu = htmlspecialchars($_POST['article_contenu']);
			$user_id = htmlspecialchars($_GET['user']);
			if (!$edit_mode) {
				$ins = $bdd->prepare('INSERT INTO posts (title, content, date_time_publication, supprime, user_id) 
				VALUES (?, ?, NOW(), 0, ?)');
				$ins->execute(array($article_titre, $article_contenu, $user_id));
				$lastid = $bdd->lastInsertId();
				if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
				// var_dump($_FILES);
				$format = exif_imagetype($_FILES['image']['tmp_name']);
				// var_dump($format);
				if ($format==1 || $format==2 || $format==3) {
					if ($format==1) $ex = ".gif";
					else if ($format==2) $ex = ".jpg";
					else $ex = ".png";
					$chemin = 'thumbs/' .$lastid .$ex;
					move_uploaded_file($_FILES['image']['tmp_name'], $chemin);
				} else {
					$message = 'Votre image doit être au format gif, jpg ou png !';
				}}
				$message = 'Votre article a bien été posté !';
			} else {
				$update = $bdd->prepare('UPDATE posts SET title = ?, content = ?, date_time_edition = NOW() WHERE id = ?');
				$update->execute(array($article_titre, $article_contenu, $edit_id));
				$lastid = $edit_id;
				if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
				// var_dump($_FILES);
				$format = exif_imagetype($_FILES['image']['tmp_name']);
				// var_dump($format);
				if ($format==1 || $format==2 || $format==3) {
					if ($format==1) $ex = ".gif";
					else if ($format==2) $ex = ".jpg";
					else $ex = ".png";
					$chemin = 'thumbs/' .$lastid .$ex;
					move_uploaded_file($_FILES['image']['tmp_name'], $chemin);
				} else {
					$message = 'Votre image doit être au format gif, jpg ou png !';
				}}
				header('Location: http://projet/accueil.php');
				$message = 'Votre article a bien été modifié !';
			}}
			
		} else {
			$message = 'Veuillez remplir tous les champs !';
		}
	}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title> Publier / Modifier </title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/message.css">
</head>

<body>
	<?php include 'navbar.php'; ?>
	<form method="post" enctype="multipart/form-data">
		<input type="text" name="article_titre" placeholder="Titre" autofocus
			<?php if($edit_mode) { ?> value="<?= $edit_post['title'] ?>"<?php } ?> /> <br/>
		<textarea class="contenu" name="article_contenu" placeholder="Contenu" rows="17" cols="30" required><?php if($edit_mode) { ?><?= $edit_post['content'] ?>"<?php } ?></textarea>
		<h5 style="color:white;"> Cliquez ci-dessous pour poster une image : </h5>
		<input type="file" name="image" /> <br/> <br/>
		<?php if (!$edit_mode) {$s = "Publier";} else {$s = "Modifier";} ?>
		<input type="submit" value="<?= $s ?>" /> <br/>
		<input type="reset" value="Réinitialiser"/>
	</form> <br/>
	<?php 
		if (isset($message)) {echo $message;}
	?>
</body>
</html>