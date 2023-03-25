<?php 
    require_once 'php/config.php';
    require_once 'php/session.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title> Recherche </title>
    <link rel="stylesheet" href="css/styleb.css">
</head>
<body>    
    <?php include 'navbar.php'; ?>
    <section class="display">
    <h1> Utilisateur trouvés : </h1>
<!--Liste des utilisateurs-->
  <?php
    if($allusers->rowCount() >0){
      while($user = $allusers->fetch()){
        ?>
        <hr>
        <a class="link" href="profileuser.php?username=<?php echo $user['username']; ?>&id=<?php echo $user['id']; ?>"><?php echo $user['username']; ?></a>
        <?php
      }
    }else{
      ?>
      <p> Aucun utilisateur trouvé </p>
      <?php
    }
  ?>
  <hr>
</section>
</body>
</html>