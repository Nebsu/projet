<?php
require_once 'php/config.php';
require_once 'php/session.php';

//Insersion du message dans la base de donnée
if(isset($_GET['username']) AND !empty($_GET['username'])){
    $getname=$_GET['username'];
    $getuser=$bdd->prepare('SELECT * FROM users WHERE username = ?');
    $getuser->execute(array($getname));
    if($getuser->rowCount()>0){
        //Verification si un message a été ecrit
        if(isset($_POST['send']) AND !empty($_POST['message'])){
            $message = htmlspecialchars($_POST['message']);
            $insertMessage = $bdd->prepare('INSERT INTO message(message, destinataire, expediteur)VALUE(?,?,?)');
            $insertMessage->execute(array($message, $getname, $_SESSION['user']));
        }
    }else{
        echo "Aucun utilisateur trouvé";
    }
}else{
    echo "Aucun utilisateur trouvé";
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title> Messages </title>
    <link rel="stylesheet" type="text/css" href="css/message.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <!--Affichage des messages-->
    <h1>Chat</h1>
    <div id="chatBox">
    <?php
    $getMess = $bdd->prepare('SELECT * FROM message WHERE expediteur = ? AND destinataire = ? OR expediteur = ? 
        AND destinataire = ? ORDER by id DESC LIMIT 100');
    $getMess->execute(array($_SESSION['user'], $getname, $getname, $_SESSION['user']));
        while($message=$getMess->fetch()){
            if($message['destinataire'] == $_SESSION['user']) { ?>
            <p>[<?php echo $message['date_envoi'];?>] <strong><?php echo $message['expediteur']?></strong> : <?= $message['message']; ?>
            <?php } elseif ($message['destinataire'] == $getname) { ?>
            <p>[<?php echo $message['date_envoi'];?>] <strong><?php echo $message['expediteur']?></strong> : <?= $message['message']; ?>
            <?php 
            }
        } ?>
    </div> <br/>

  <!--Zone de texte + bouton-->
    <form id="text" method ="POST" action="">
        <textarea class="message" name="message" placeholder="Envoyer un message"></textarea>
        <br/>
        <input id="send" value="Envoyer" type="submit" name="send">
    </form>

</body>
</html>