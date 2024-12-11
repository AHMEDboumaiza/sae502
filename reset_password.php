<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'email et le nouveau mot de passe
    $email = $_POST["email"];
    $new_password = $_POST["password"];

    // Validation simple du mot de passe (facultatif)
    if (strlen($new_password) < 8) {
        die("Le mot de passe doit contenir au moins 8 caractères.");
    }

    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "", "sae502");

    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    // Mettre à jour le mot de passe sans hachage
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_password, $email);

    if ($stmt->execute()) {
        echo "Mot de passe réinitialisé avec succès. Vous pouvez maintenant <a href='index.html'>vous connecter</a>.";
    } else {
        echo "Erreur lors de la réinitialisation du mot de passe.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
</head>
<body>
    <form method="POST">
        <!-- Champ caché pour envoyer l'email -->
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
        <label for="password">Nouveau mot de passe :</label>
        <input type="password" name="password" placeholder="Nouveau mot de passe" required>
        <button type="submit">Réinitialiser</button>
    </form>
</body>
</html>
