<!-- Page membres.php qui permet à l'utilisateur authentifié d'avoir un accès restreint -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Membres</title>
    
    <!-- MENU DE NAVIGATION -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="membres.php">Membres <span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php">Connexion <span class="sr-only"></span></a>
                </li>
            </ul>
        </div>
    </nav>
</head>

<?php 
    require_once("inc/db.php");

    //var_dump($_SESSION);

    if(!isset($_SESSION["estConnecte"])){

        // Récupération de l'information du form
        if(isset($_POST['unom']) && isset($_POST['umdp'])){
            $username = trim($_POST['unom']);
            $password = trim($_POST['umdp']);    

            // Vérifications de sécurité
            // Prevent sql injection
            $username = stripslashes($username);
            $password = stripslashes($password);

            // Htmlentities prevent script execution
            $username = htmlentities($username);
            $password = htmlentities($password);

            $username = mysqli_real_escape_string($connect, $username);
            $password = mysqli_real_escape_string($connect, $password);

            // Vérification dans la BD si c'est exact
            $query = "SELECT * FROM utilisateurs WHERE unom='$username' and umdp='$password'";

            $resultat = mysqli_query($connect, $query);

            $rangee = mysqli_fetch_array($resultat, MYSQLI_ASSOC);
            $compteur = mysqli_num_rows($resultat);

        if($compteur == 1){
            $_SESSION['estConnecte'] = true;
            $_SESSION['usager'] = $username;
            $_SESSION['level'] = $rangee['level'];
        }else{
            echo "<br><br>
            <h2 style='color:red;'>
                <center> Connexion échouée: nom d'utilisateur ou mot de passe invalide. </center>
            </h2>
            <br><br>
            <a href='connexion.php'>Retour</a>";
        }
    }else{
        header("Location:index.php");
    }
}

// Validation de la création d'un produit
    if(isset($_POST['creer'])){
        try {
            $sql = "INSERT INTO produits (code, titre, description, prix, image) VALUES (:code, :titre, :description, :prix, :image)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'code' => $_POST['code'],
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'prix' => $_POST['prix'],
                'image' => $_POST['image'],
            ]);
            echo "<br><p class='text-center'>Le produit a bien été ajouté!</p>";
        }catch(PDOException $e){
            echo "<br><p class='text-center'>Une erreur est survenue, le produit n'a pas été ajouté.<br></p>" . $e->getMessage();
        }
        unset($stmt);
        unset($pdo);
    }

// Validation de la modification d'un produit
    if(isset($_POST['mettreajour'])){
        try {
            $sql = "UPDATE produits SET code = :code, titre = :titre, description = :description, prix = :prix, image = :image WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id", $_POST['id']);
            $stmt->bindValue(":code", $_POST['code']);
            $stmt->bindValue(":titre", $_POST['titre']);
            $stmt->bindValue(":description", $_POST['description']);
            $stmt->bindValue(":prix", $_POST['prix']);
            $stmt->bindValue(":image", $_POST['image']);
            $stmt->execute();
            echo "<br><p class='text-center'>Le produit a bien été mis à jour!</p>";
        } catch (PDOException $e) {
            echo "<br><p class='text-center'>Le ID du produit n'a pas été trouvé, veuillez réessayer. <br></p>" . $e->getMessage();
        }
        unset($stmt);
        unset($pdo);
    }

// Validation de la suppression d'un produit
    if(isset($_POST['effacer'])){
        
        $id = $_POST['id'];
        $sql = "SELECT * FROM produits WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $resultat = $stmt->fetch();

        if($resultat){
            $sql = "DELETE FROM produits WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id", $_POST['id']);
            $stmt->execute();
            echo "<br><p class='text-center'>Le produit a été supprimé de la base de données!</p>";
        } else {
            echo "<br><p class='text-center'>Le ID du produit n'a pas été trouvé, veuillez réessayer. <br></p>";
        }
        unset($resultat);
        unset($stmt);
        unset($pdo);
    }

// Si l'utilisateur est connecté, il peut voir le contenu de la page

if(isset($_SESSION["estConnecte"])){ ?>
<body>
    <br><br>
    <h1 class="text-center">La page des membres</h1>
    <br><br>

 <!-- Créer un produit -->
 <section>
    <div class="row">
        <div class="col-4 text-center">
            <h5>Créer un nouveau produit</h5>
            <form class="form" action="membres.php" method="post">
                <label for="nom">Nom:</label>
                <input type="text" id="titre" name="titre" required>
                <br><br>
                <label for="code">Code:</label>
                <input type="text" id="code" name="code" required>
                <br><br>
                <label for="prix">Prix:</label>
                <input type="text" id="prix" name="prix" required>
                <br><br>
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required>
                <br><br>
                <label for="image">Image:</label>
                <input type="text" id="image" name="image" required>
                <br><br>
                <input type="submit" value="Créer" name="creer">
                <br><br>
            </form>
            <br><br>
        </div>
        <!-- Mettre à jour un produit -->
        <div class="col-4 text-center">
            <h5>Mettre à jour un produit</h5>
            <form class="form" action="membres.php" method="post">
                <label for="id">ID:</label>
                <input type="text" id="id" name="id" required>
                <br><br>
                <label for="nom">Nom:</label>
                <input type="text" id="titre" name="titre" required>
                <br><br>
                <label for="code">Code:</label>
                <input type="text" id="code" name="code" required>
                <br><br>
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required>
                <br><br>
                <label for="prix">Prix:</label>
                <input type="text" id="prix" name="prix" required>
                <br><br>
                <label for="image">Image:</label>
                <input type="text" id="image" name="image" required>
                <br><br>
                <input type="submit" value="Mettre à jour" name="mettreajour">
            </form>
            <br><br>
        </div>
        <!-- Effacer un produit -->
        <div class="col-4 text-center">
            <h5>Effacer un produit</h5>
            <form class="form" action="membres.php" method="post">
                <label for="id">ID:</label>
                <input type="text" id="id" name="id" required>
                <br><br>
                <input type="submit" name="effacer" value="Effacer">
            </form>
        </div>
    </div>
</section>
</body>

<?php } ?>

</html>