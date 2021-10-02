<?php 
            session_start();
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
            $sql2 = 'SELECT id FROM utilisateurs WHERE mail = "'.$_SESSION['login'].'"'; // on prend l'id de l'user connecté
            $query2 = $dbco->prepare($sql2);
            $query2->execute();
            $Reponse2 = $query2->fetchAll();
            $query2->closeCursor();

            $sql1 = 'SELECT * FROM produitvendu WHERE idUtilisateur = "'.$Reponse2[0]['id'].'"'; //on prend les données de produit ou l'id de l'user concorde
            $query1 = $dbco->prepare($sql1);
            $query1->execute();
            $Reponse1 = $query1->fetchAll();
            $query1->closeCursor();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Mes commandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/accueil.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
  </head>
  <body>
<?php include 'menu.php'; ?>

<div class="container" style="margin-bottom: 150px;">
    <div class="row justify-content-center">
        <h1 class="text-center title-top"> Mes commandes </h1>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Numéro de commande</th>
                <th scope="col">Produit</th>
                <th scope="col">Montant</th>
                <th scope="col">Date d'achat</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                for($i=0 ; $i <= $nbElement = count($Reponse1) ; $i++) { //on affiche avec une boucle for (pour avoir le bon nombre de commande) les commandes
                    if(isset($Reponse1[$i])) { ?>
                        <tr>
                        <th scope="row"><?php echo($Reponse1[$i]['id']); ?></th>
                        <td><?php 
                        $sql = 'SELECT nom FROM produit WHERE id = "'.$Reponse1[$i]['idProduit'].'"';
                        $query = $dbco->prepare($sql);
                        $query->execute();
                        $Reponse = $query->fetchAll();
                        $query->closeCursor();
                        echo($Reponse[0]['nom']);?></td>
                        <td><?php echo($Reponse1[$i]['montant']); ?></td>
                        <td><?php echo($Reponse1[$i]['date_ajout']); ?></td>
                        </tr>
                    <?php }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
    // 
?>


<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
