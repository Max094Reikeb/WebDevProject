<?php //même fonctionnement que traitementModifBoutique.php

            session_start();
            require("function.php");	 		
            if(!isset($_SESSION['login']) || empty($_POST)) {
                header("Location: index.php");
                die();
            }
            else {
                $bdd = connexionBDD();
                $sql = 'UPDATE evenements SET nom="'.$_POST['nom'].'", prix="'.$_POST['prix'].'", dateDebut="'.$_POST['dateDebut'].'", lien_image="'.$_POST['lien_image'].'", description="'.$_POST['description'].'", lieu="'.$_POST['lieu'].'", dateFin="'.$_POST['dateFin'].'", nombreParticipants="'.$_POST['nombreParticipants'].'", placesRestantes="'.$_POST['placesRestantes'].'", dateLimiteInscription="'.$_POST['dateLimiteInscription'].'" WHERE id='.$_POST['id'].'';
                $query = $bdd->prepare($sql);
                $query->execute();
                $query->closeCursor();

                header("Location: gestionEvenements.php");
                die();
            }



?>