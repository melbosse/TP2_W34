<?php 
    // Démarrer la session
    session_start();

    // Effacer les valeurs dans la session
    unset($_SESSION);

    // Détruire la session
    session_destroy();

    // Fermer la session
    session_write_close();

    // Redirige vers l'accueil
    header("Location: index.php");

    die;
?>