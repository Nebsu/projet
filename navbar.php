<?php
require_once "php/config.php";
require_once 'php/session.php';
$allusers = $bdd->query('SELECT * FROM users ORDER BY id DESC');
if(isset($_GET['search']) AND !empty($_GET['search'])){
  $search = htmlspecialchars($_GET['search']);
  $allusers = $bdd->query('SELECT id, username FROM users WHERE username liKE "%'.$search.'%" ORDER BY id DESC');
}

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) $sessionid = $_SESSION['id'];

$root = 'root';
?>
<!--Barre de navigation-->
<ul style="list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #333;
        ">
    <li class="admin" style="float:left;"><a href="http://projet/accueil.php">Accueil</a></li>
    <li class="admin" style="float:left;"><a href="http://projet/upload.php?user=<?= $sessionid ?>">Publier</a></li>
    <li class="admin" style="float:left;"><a href="http://projet/profilefollow.php">Followers</a></li>
<form method="get" action="search_list.php">
<!--Barre de recherche-->
    <li class="admin"><input placeholder=" Rechercher un utilisateur" 
                          style="width:500px; 
                                height:46px; 
                                position: absolute;
                                top:auto; 
                                left:50%;  
                                margin-left:-250px; " type="search" name="search" ></li>

<!--Bouton-->
    <li class="admin"><input style="width:30px; 
                                height:30px; 
                                margin-top: 8px;
                                position: absolute;
                                top:auto; 
                                left:50%; 
                                margin-left:260px; " class="btn" type="image" src="css/search.png" value=""></li>
    <li class="deco" style="float:right;"><a class="disc" href="http://projet/php/disconnect.php">Déconnexion</a></li>
  <li class="admin" style="float:right;"><a class="prof" href="http://projet/profile.php">Profil</a></li>
<!--Si l'utilisateur est admin bouton-->
  <?php
  if(isset($_SESSION['user']) AND ($_SESSION['user'] == $root)){
  ?>
  <li class="admin" style="float:right;"><a class="admin" href="http://projet/admin.php">Admin</a></li>
  <?php
  }
  ?>
</form>
</ul>
<!--CSS-->
<style type="text/css">
ul {
  width:99%;

}

li.admin a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li.deco a {
    display: block;
    color: red;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover {
    background-color: #111;
}
</style>