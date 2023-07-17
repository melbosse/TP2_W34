<?php 
    // Connexion à la base de données avec mysqli
    session_start();

    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "w34tp1";

    $connect = mysqli_connect($host, $user, $pass, $dbname);

    if(mysqli_connect_errno()){
        die("Échec de la connexion à la base de données: " . mysqli_connect_errno());
    }else{
        mysqli_set_charset($connect, "utf8");
    }

    // Connexion PDO à la base de données
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=w34tp1;charset=utf8mb4", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connexion à la base de donnée réussie!";
    }catch(PDOException $e){
        die("La connexion à la base de donnée a échouée! : " . $e->getMessage());
    }
?>