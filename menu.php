<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">      <! -- navbar bootstrap --> 
    <a class="navbar-brand" href="index.php">La Guilde</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="boutique.php">Boutique</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="evenements.php">Evénements</a>
        </li>
        <?php if(isset($_SESSION['login'])) { ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Mon Espace
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="informations.php">Mes informations</a></li>
            <li><a class="dropdown-item" href="commandes.php">Mes commandes</a></li>
            <li><a class="dropdown-item" href="reservations.php">Mes inscriptions</a></li>
          </ul>
        </li>
        <?php } ?>
        <?php if(isset($_SESSION['login'])) { //on ne le voit pas si on n'est pas connecté
                if($_SESSION['typeUtilisateurs'] == 1) { ?>
        <li class="nav-item dropdown"> 
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Espace Administrateur
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="gestionEvenements.php">Gérer les événements</a></li>
            <li><a class="dropdown-item" href="gestionBoutique.php">Gérer la boutique</a></li>
            <li><a class="dropdown-item" href="gestionMembres.php">Gérer les membres</a></li>
          </ul>
        </li>
        <?php   }
              } ?>


        
        
      </ul>
     
      <div class="d-flex">
          <?php if(!isset($_SESSION['login'])) { //si on est pas connecté on affiche le bouton connexion / inscription sinon juste deconnexion ?>
            <a class="btn btn-outline-primary" href="connexion.php">Connexion</a>
            <a class="btn btn-outline-primary" href="inscription.php" style="margin-left: 20px">Inscription</a>
          <?php } ?>
          <?php if(isset($_SESSION['login'])) { ?>
          <a class="btn btn-outline-primary" href="deconnexion.php" style="margin-left: 20px">Deconnexion</a>
          <?php } ?>
      </div>
      
    </div>
  </div>
</nav>