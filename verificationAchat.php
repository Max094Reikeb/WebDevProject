<?php 
            session_start();
            if (!isset($_SESSION["login"])) {
                header("Location: index.php");
                die();
            }
	 		$servname = 'localhost';
            $dbname = 'projetinfo1';
            $user = 'root';
            $pass = '';
            $tamp = 0;
            
            try{
                $dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
                $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                
            }
            
            catch(PDOException $e){
              echo "Erreur : " . $e->getMessage();
            }

            $date = date("Y-m-d"); // définition du type de date (année-mois-jour)
            if(!empty($_POST)) { //post n'est pas vide s'il on a cliquer sur le bouton acheter dans produit.php et qu'on ait pas remplis les infos correctement 

                $sql = 'UPDATE utilisateurs SET adresse="'.$_POST['adresse'].'", ville="'.$_POST['ville'].'",codePostale='.$_POST['codepostal'].',telephone="'.$_POST['phone'].'" WHERE mail="'.$_SESSION['login'].'"';
                $query = $dbco->prepare($sql); //on ajoute les données prisent dans produit.php lors de l'achat dans la bdd
                $query->execute();
                $query->closeCursor();


                $sql = 'SELECT * FROM produit WHERE id='.$_POST['id'].'';
                $query = $dbco->prepare($sql);
                $query->execute();
                $Reponse = $query->fetchAll();
                $query->closeCursor();

                $sql1 = 'SELECT * FROM utilisateurs WHERE mail="'.$_SESSION['login'].'"';
                $query1 = $dbco->prepare($sql1);
                $query1->execute();
                $Reponse1 = $query1->fetchAll();
                $query1->closeCursor();

                if($Reponse[0]['stock']>=1) { //on vérifie qu'il reste du stock
                    $sql = 'INSERT INTO produitvendu(idProduit,idUtilisateur,date_ajout,montant) VALUES ('.$_POST['id'].','.$Reponse1[0]['id'].',"'.$date.'",'.$Reponse[0]['prix'].') ';
                    $query = $dbco->prepare($sql);
                    $query->execute();
                    $query->closeCursor();

                    $stock_final = $Reponse[0]["stock"]-1;

                    $sql2 = 'UPDATE produit SET stock='.$stock_final.' WHERE id='.$_POST['id'].'';
                    $query2 = $dbco->prepare($sql2);
                    $query2->execute();
                    $query2->closeCursor();
                    $message = "Votre achat a bien été effectué";
                }
                else {
                    $message = "Nous n'avons plus le produit";
                }
            }
            else {
                header("Location: index.php");
                die();
            }
            

           


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/accueil.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    
  </head>
  <body>
<?php
include 'menu.php';
?>
<div class="container" style="margin-bottom: 120px;">
    <div class="row justify-content-center">
    <?php if(isset($message)) { ?>
    <h1 class="text-center title-top"> <?php echo($message) ?> </h1>
    <?php }
        else {
    ?>
    
    <h1 class="text-center title-top">  <?php echo($message) ?> </h1>
    <?php } ?>
    <a class="btn btn-success bg-success" style="width: 200px; margin-top:2%;" href="index.php">  <i class="fas fa-arrow-alt-circle-left"></i>  Revenir vers l'accueil</a>
    </div>
</div>

<?php include 'footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>