<!DOCTYPE html>
<html lang="fr">
 <head>
   <meta charset="utf-8">
   <link rel="stylesheet" type="text/css" href="css/indexs.css" />
   <title> S'inscrire </title>
 </head>
    <body>
    <?php
        //Messages d'erreur
        if(isset($_GET['reg_err']))
        {
            $err = htmlspecialchars($_GET['reg_err']);

            switch($err)
            {
                case 'username_already':
                    ?>
                    <div class="error">
                        <strong>Erreur : <strong> Ce nom d'utilisateur existe déjà
                    </div>
                    <?php
                    break;    
                case 'success':
                    ?>
                    <div class="success">
                        <strong>Succès : <strong>Votre compte a bien été enregistré 
                    </div>
                    <?php
                    break;
                case 'password':
                    ?>
                    <div class="error">
                        <strong>Erreur : <strong>Les deux mots de passe sont différents
                    </div>
                    <?php
                    break;    
                case 'email':
                    ?>
                    <div class="error">
                        <strong>Erreur : <strong>Adresse email invalide
                    </div>
                    <?php
                    break;
                case 'email_length':
                    ?>
                    <div class="email_length">
                        <strong>Erreur : <strong>Votre adresse email est trop longue
                    </div>
                    <?php
                    break;
                case 'username_length':
                    ?>
                    <div class="error">
                        <strong>Erreur : <strong>Votre nom d'utilisateur est trop long
                    </div>
                    <?php
                    break;
                case 'already':
                    ?>
                    <div class="error">
                        <strong>Erreur : <strong>Ce compte existe déjà
                    </div>
                    <?php
                    break;
                case 'incomplete':
                    ?>
                    <div class="error">
                        <strong>Erreur : <strong>Veuillez remplir tous les champs
                    </div>
                    <?php
                    break;
                case 'forbidden_characters':
                    ?>
                    <div class="error">
                        <strong>Erreur : <strong>Veuillez utiliser des caractères valides
                    </div>
                    <?php
                    break;
            

            }
        }
    ?>

            <div class="case">
            <form action="php/signup_data.php" method="post">
            <h1 style="color:white;"> Netdrip </h1>
                <div class="entry">
                    <input type="text" name="username" placeholder="Nom d'utilisateur" autocomplete="off" required="required">
                </div>
                <div class="entry">
                    <input type="email" name="email" placeholder="Email" autocomplete="off" required="required">
                </div>
                <div class="entry">
                    <input type="password" name="password" placeholder="Mot de passe" autocomplete="off" required="required">
                </div>
                <div class="entry">
                    <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" autocomplete="off">
                </div>
                <div class="entry">
                    <input class="myButton" type="submit" value="S'inscrire">
                </div>
            </form>
            </div>
            <div class="button_back"><a href="index.php">Se connecter</a></div>
    </body>
</html>