<?php 
    // Connexion requise à la base de données
    require_once("inc/db.php");

//    var_dump($_SESSION);
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
    <title>Connexion</title>
    
    <!-- MENU DE NAVIGATION -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="membres.php">Membres <span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="connexion.php">Connexion <span class="sr-only"></span></a>
                </li>
            </ul>
        </div>
    </nav>
</head>

<body>
<?php if(!isset($_SESSION["estConnecte"])){ ?>
        <!-- FORMULAIRE DE CONNEXION -->
        <div id='form' class='text-center'>
            <h1>Connexion</h1>
            <form name='frmConnecter' action='membres.php' method='post' onsubmit='return validation()'>
                <p>
                    <label for='nom'>Nom d'utilisateur: </label>
                    <input type='text' name='unom' id='unom'>
                </p>
                <p>
                    <label for='mdp'>Mot de passe: </label>
                    <input type='password' name='umdp' id='umdp'>
                </p>
                <p>
                    <input type='submit' value='Se connecter' id='btnConnecter'>
                </p>
            </form>
        </div>
        <!-- VALIDATION DE CONNEXION -->
        <script>
            function validation(){
                var id = document.frmConnecter.unom.value;
                var pass = document.frmConnecter.umdp.value;

                if(id.length == "" && pass.length == ""){
                    alert("Le nom d'utilisateur et le mot de passe ne peuvent pas être vide.");
                    return false;
                }else{
                    if(id.length == ""){
                        alert("Le nom d'utilisateur est vide.")
                        return false;
                    }
                    if(pass.length == ""){
                    alert("Le mot de passe est vide.")
                    return false;
                    }
                }
            }
        </script>
<?php
    }else if(isset($_SESSION["estConnecte"])){
        echo '<br><h2 class="text-center">Bonjour ' . $_SESSION['usager'] . ' !</h2>';
        echo "<br><a href='deconnexion.php'>Déconnexion</a>";
    } 
?>
</body>
</html>