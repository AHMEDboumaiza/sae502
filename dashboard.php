<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html?error=Veuillez vous connecter.");
    exit;
}

echo "<h1>Bienvenue sur la page admin, " . htmlspecialchars($_SESSION['email']) . " !</h1>";
echo '<a href="logout.php">Déconnexion</a>';
?>
