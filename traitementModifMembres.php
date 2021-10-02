<?php //même fonctionnement que traitementModifBoutique.php

            session_start();
            require("function.php");	 		
            if(!isset($_SESSION['login']) || empty($_POST)) {
                header("Location: index.php");
                die();
            }
            else {
                $bdd = connexionBDD();
                $sql = 'UPDATE utilisateurs SET nom="'.$_POST['nom'].'", age='.$_POST['age'].', mail="'.$_POST['mail'].'", prenom="'.$_POST['prenom'].'", pseudo="'.$_POST['pseudo'].'", idtypeUtilisateurs='.$_POST['idtypeUtilisateurs'].', adresse="'.$_POST['adresse'].'", codePostale='.$_POST['codePostale'].', ville="'.$_POST['ville'].'", telephone="'.$_POST['telephone'].'" WHERE id='.$_POST['id'].'';
                $query = $bdd->prepare($sql);
                $query->execute();
                $query->closeCursor();

                header("Location: gestionMembres.php");
                die();
            }



?>