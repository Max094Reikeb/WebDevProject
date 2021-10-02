<?php

            session_start();
            require("function.php");	 		
            if(!isset($_SESSION['login']) || empty($_POST)) { // si on est pas connecté ou que l'on a rien changé on retourne a l'accueil sinon on modifie
                header("Location: index.php");
                die();
            }
            else {
                $bdd = connexionBDD();
                $sql = 'UPDATE produit SET nom="'.$_POST['nom'].'", prix="'.$_POST['prix'].'", lien_image="'.$_POST['lien_image'].'",stock="'.$_POST['stock'].'" WHERE id='.$_POST['id'].'';
                $query = $bdd->prepare($sql);
                $query->execute();
                $query->closeCursor();

                header("Location: gestionBoutique.php");
                die();
            }



?>