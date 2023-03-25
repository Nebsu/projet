<?php
    session_start();
    require_once 'config.php';

    //Verification si le formulaire est complet
    if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password']))
    {
        //Suppression des balises
        $username = htmlspecialchars($_POST["username"]);
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);
        $password_confirm = htmlspecialchars($_POST["confirm_password"]);

        //Récupération des données de la base
        $check = $bdd->prepare('SELECT username, email, password FROM users WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();

        $test = $bdd->prepare('SELECT * FROM users WHERE username=?');
        $test->execute([$username]); 
        $usertest = $test->fetch();
        //Filtre de caractères
        if(preg_match('/^[a-zA-Z0-9_]+$/u', $username)) {
            if (!$usertest) {
        //Vérification si l'utilisateur existe déjà
                if($row == 0){ 
                    //Vérification si le nom d'utilisateur a la longueur requise
                    if(strlen($username) <= 30){
                        //Vérification si l'email a la longueur requise
                        if(strlen($email) <= 30){
                            if($password === $password_confirm){

                                    $cost = ['cost' => 12];
                                    $password = password_hash($password, PASSWORD_BCRYPT, $cost);
                                    
                                    //Insertion des données dans la base
                                    $insert = $bdd->prepare('INSERT INTO users(username, email, password, bannir) VALUES(:username, :email, :password, :bannir)');
                                    $insert->execute(array(
                                        'username' => $username,
                                        'email' => $email,
                                        'password' => $password,
                                        'bannir' => 0
                                    ));
                                    //Message si l'inscription est effectuée
                                    header('Location: ../signup.php?reg_err=success');
                                    //Alerte si les conditions ne sont pas respectées
                            }else{ header('Location: ../signup.php?reg_err=password');}
                        }else{ header('Location: ../signup.php?reg_err=email_length');}
                    }else{ header('Location: ../signup.php?reg_err=username_length');}
                }else{ header('Location: ../signup.php?reg_err=already');}
            } else { header('Location: ../signup.php?reg_err=username_already');}
        } else { header('Location: ../signup.php?reg_err=forbidden_characters');}
    }
    