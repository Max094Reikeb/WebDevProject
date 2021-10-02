<?php //page ou on effectue l'inscription à un événement
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
            if(!empty($_POST)) {
                $sql =  'select * from produit';
                foreach  ($dbco->query($sql) as $row) {
                    if(isset($_POST[$row['id']])) { //on récupère l'id de l'événement sur celui ou on a cliqué pour pouvoir récupérer ses infos (via l'id)
                        $query = $dbco->prepare('SELECT * FROM evenements WHERE id='.$row['id']);
                        $query->execute();
                        $Reponse = $query->fetchAll();
                        $query->closeCursor();
                    }
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
    <title>Evénements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/accueil.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/addons/cleave-phone.fr.min.js"></script>
  </head>
  <body>
<?php
include 'menu.php';
?>
<div class="container" style="margin-bottom: 120px;">
<form action="verificationInscription.php" method="POST">
    <div class="row justify-content-center">
    <h1 class="text-center title-top"> L'événement </h1>
        <div class="col text-center">
            
            <img src="<?php echo($Reponse[0]['lien_image']) ?>" height="400" style="width: 450px"> <!-- on affiche les données de l'événement-->
            <ul class="" style="margin-top: 30px; list-style: none;">
                <li name="nom">Nom : <?php echo($Reponse[0]['nom']) ?></li><br>
                <li name="prix">Prix : <?php echo($Reponse[0]['prix']) ?>€</li>
            </ul>
            
        </div>
        <div class="col text-left">
                    <div class="form-floating mb-3">
                        <input placeholder="Adresse" type="text" class="form-control form-input" id="adresse" name="adresse" required>
                        <label for="nom" class="form-label">Adresse de facturation</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input placeholder="Votre ville" type="text" class="form-control form-input" id="ville" name="ville" required>
                        <label for="prenom" class="form-label">Ville</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input placeholder="Votre code postale" type="text" class="form-control form-input" id="codepostal" min="13" max="110" name="codepostal" required>
                        <label for="age" class="form-label">Code postale</label>
                    </div>
                    <div class="mb-3 input-group form-input">
                        <span class="input-group-text" id="basic-addon1"><i class="fab fa-cc-mastercard"></i></span>
                        <input placeholder="Numéro de carte bancaire" type="text" class="form-control input-bankcard" id="carte" name="carte"  required>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="tel" class="form-control form-input input-phone" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Votre Email" name="phone" required>
                        <label for="exampleInputEmail1" class="form-label">Téléphone</label>
                    </div>
                    <input value="<?php echo($Reponse[0]['id']) ?>" name="id" style="display: none;">
        </div>
        </div>
    <div class="text-center">
    <button type="submit" class="btn btn-success bg-success" style="width: 150px; margin-top:2%;" name="<?php echo($Reponse[0]['id']) ?>"> S'inscrire </button>
    </div>
    </form>
</div>

<?php include 'footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script>
var cleave = new Cleave('.input-phone', { //bootstrap pour faire des numéros de téléphone correct
    phone: true,
    phoneRegionCode: 'fr'
});

var cleave = new Cleave('.input-bankcard', { //bootstrap pour faire des numéros de carte banquaire corrects
    creditCard: true,
    onCreditCardTypeChanged: function (type) {
    }
});
</script>
</body>
</html>