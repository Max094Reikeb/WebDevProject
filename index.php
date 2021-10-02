<?php 
			session_start();  //récupération des variables de session (login)
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

?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/accueil.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
  </head>
  <body>
<?php
include 'menu.php'; //afficher la navbar
?>
<div class="div_accueil">
	<div class="custom-shape-divider-bottom-1622817714">
	    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"> <! -- Le disign de la transition entre le message de bienvenue et les carousel (les petites vagues) -->
	        <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
	        <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
	        <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
	    </svg>
	</div>
	<div class="container">
		<div class="text-center text-light text_accueil">
			<h1>Bienvenue sur le site officiel de l'association étudiante La Guilde<h1><br>
			<a href="#ancreboutique"><button class="btn btn-success bg-dark"> En savoir plus</button></a>
		</div>
	</div>
</div>
<div class="row justify-content-center div_boutique" id="ancreboutique">
<div class="col-6">
	<div style="width: 80%">
	<h1 class="text-center">Notre boutique</h1><br>
	<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
		  <div class="carousel-indicators">
		    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
		    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
		    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
		  </div>
		  <div class="carousel-inner">
		  	<?php $sql =  'select * from produit'; //requête sql pour prendre les valeurs de la table produit de la bdd pour pouvoir mettre les informations que l'on veut dans le carousel
				foreach  ($dbco->query($sql) as $row) {
					if ($tamp==0) {
						?><div class="carousel-item active"><?php
					}
					else {
						?><div class="carousel-item"><?php
					}
				 ?>
					
		      <a href="boutique.php"><img src="<?php echo $row['lien_image'];?>" class="d-block w-100" alt=""></a>
		    </div>
		    <?php
		    	$tamp=$tamp+1;
				}
				$tamp=0;
            ?>
		    
		    
		  </div>
		  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
		    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		    <span class="visually-hidden">Previous</span>
		  </button>
		  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
		    <span class="carousel-control-next-icon" aria-hidden="true"></span>
		    <span class="visually-hidden">Next</span>
		  </button>
	</div>
	<br>
	<div class="text-center">
		<a href="boutique.php"><button class="btn btn-success bg-dark"> Aller vers la boutique</button></a>
	</div>
</div>
</div>

<div class="col-6" >
	<div style="width: 80%" >
	<h1 class="text-center">Nos événements à venir</h1><br>
	<div id="carouselExampleIndicators1" class="carousel slide" data-bs-ride="carousel">
		  <div class="carousel-indicators">
		    <button type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
		    <button type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide-to="1" aria-label="Slide 2"></button> <! -- carousel bootstrap -->
		    <button type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide-to="2" aria-label="Slide 3"></button>
		  </div>
		  <div class="carousel-inner">
		  <?php $sql1 =  'select * from evenements'; //requête à la base de donnée pour récupérer les informations de la table evenements
				foreach  ($dbco->query($sql1) as $row) {
					if ($tamp==0) {		
						?><div class="carousel-item active"><?php
					}
					else {
						?><div class="carousel-item"><?php
					}
				 ?>
					
		      <a href="evenements.php"><img src="<?php echo $row['lien_image'];?>" class="d-block w-100" alt=""></a>
		    </div>
		    <?php
		    	$tamp=$tamp+1;
				}
            ?>
		  </div>
		  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide="prev">
		    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		    <span class="visually-hidden">Previous</span> <! -- carousel bootstrap -->
		  </button>
		  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide="next">
		    <span class="carousel-control-next-icon" aria-hidden="true"></span>
		    <span class="visually-hidden">Next</span> 
		  </button>
	</div>
	<br>
	<div class="text-center">
		<a href="evenements.php"><button class="btn btn-success bg-dark"> Inscrivez-vous</button></a> <! -- bouton "s'inscrire" en dessous des carousel événements -->
	</div>
</div>
</div>
</div>
<?php include 'footer.php'  //afficher le bas de page ?> 

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  </body>
</html>