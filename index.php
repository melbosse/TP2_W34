<?php 
    // Connexion requise à la base de données
    require_once('inc/db.php');

    // Afficher la liste des produits avec une requête
    $query = 'SELECT * from produits';
    $resultats = mysqli_query($connect, $query);
    $produits = mysqli_fetch_all($resultats, MYSQLI_ASSOC);
    mysqli_free_result($resultats);
    mysqli_close($connect);

    //var_dump($_SESSION);

    $nb_item_panier = 0;
    if(isset($_SESSION['panier']) && isset($_SESSION['qte'])){
        $nb_item_panier = $_SESSION['qte'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Accueil</title>

    <!-- MENU DE NAVIGATION -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="membres.php">Membres <span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php">Connexion <span class="sr-only"></span></a>
                </li>
            </ul>
        </div>
    </nav>
</head>

<body>
    <div class="container-fluid">
        <!-- RANGÉE TITRE -->
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Accueil</h1>
            </div>
        </div>
        <!-- AFFICHAGE DU NOMBRE DE PRODUITS DANS LE PANIER -->
        <div class="row" style="margin:5px">
            <a href="panier.php" style="color:black">
                <h2>Panier (<?php echo $nb_item_panier; ?>)</h2>
            </a>
        </div>
        <br>
        <!-- RANGÉE PRODUITS -->
        <div class="row">
            <div class="col-12">
                <!-- PRODUITS -->
                <?php foreach($produits as $produit) : ?>
                    <div class="card border-dark mb-3">
                        <div class="card-header bg-light">
                            <?php echo $produit['titre']; ?>
                        </div>
                        <div class="card-body">
                            <div class="contrainer-fluid">
                                <div class="row">
                                    <div class="col-6">
                                        <img width="200px" height="200px" src=<?php echo $produit['image']; ?>/>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-text"><?php echo $produit['description']; ?></p>
                                        <small> Prix : <?php echo $produit['prix'] . "$"; ?></small>
                                    </div>
                                </div>
                                <div>
                                    <!-- AFFICHAGE DU BOUTON AJOUTER AU PANIER -->
                                    <form action="panier.php" method="post">
                                        <input type="hidden" name="item" value="<?php echo $produit['titre']; ?>">
                                        <input type="submit" name="ajouter" value="Ajouter au panier" style="float:right">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- FIN RANGÉE PRODUITS -->
    </div>
</body>
</html>