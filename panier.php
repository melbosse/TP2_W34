<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Panier</title>

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
<?php 
    session_start();

    // Boutons //
    // Ajouter les produits au panier et validation
    if(isset($_POST['item']) && isset($_POST['ajouter'])){
        $item = $_POST['item'];
        if(!isset($_SESSION['panier'])){
            $_SESSION['panier'] = array();
        }
        // S'il n'y a pas d'items à l'intérieur
        if(!isset($_SESSION['panier'][$item])){
            $_SESSION['panier'][$item] = 0;
        }
        // Ajout de l'item au panier
        $_SESSION['panier'][$item]++;
    }

    // Supprimer un item du panier
    if(isset($_POST['item']) && (isset($_POST['supprimer']))){
        // Suppression de l'item du panier
        $item = $_POST['item'];
        if(isset($_SESSION['panier'][$item])){
            $_SESSION['panier'][$item]--;
            if($_SESSION['panier'][$item] == 0){
                unset($_SESSION['panier'][$item]);
            }
        }
    }

    // Vider le panier
    if(isset($_POST['vider'])){
        // Supression de tout le contenu
        unset($_SESSION['panier']);
        session_destroy();
    }

    // Passer la commande
    if (isset($_POST['commander']) && isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {   
        header('Location: confirmation.php');   

        // Supression de tout le contenu du panier
        unset($_SESSION['panier']);
    }

    echo "<ul>";
    $total = 0;

    if(isset($_SESSION['panier'])){
        foreach($_SESSION['panier'] as $item => $quantite){
            $total = $total + $quantite;
            echo "<li>$item - Quantité: $quantite
                <form action='panier.php' method='post'>
                    <input type='hidden' name='item' value='$item'>
                    <input type='submit' name='supprimer' value='Supprimer'>
                </form>
            </li>";
        }
        $_SESSION['qte'] = $total;
    }

    echo "<ul>";

    echo "<hr>";

    // Bouton pour vider le panier et bouton pour passer la commande
    echo "
        <form action='panier.php' method='post'>
            <input type='submit' name='vider' value='Vider le panier'>
            <input type='submit' name='commander' value='Passer la commande' style='float:right; margin: 4px 60px;'>
        </form>
        <br>
        <a href='index.php'>Retour à la page des produits</a>
    ";
?>
</body>
</html>