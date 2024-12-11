<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "", "sae502");

    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    // Vérifier si l'email existe dans la base de données
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Créer le lien de réinitialisation
        $reset_link = "http://localhost/sae502/reset_password.php?email=" . urlencode($email);

        // Envoi de l'email via PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'test.user94400@gmail.com'; // Remplacez par votre email Gmail
            $mail->Password = 'ulry paha sbyr gewr'; // Remplacez par le mot de passe d'application Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('test.user94400@gmail.com', 'Mot de passe oublié - SAE502');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Réinitialisation de votre mot de passe';
            $mail->Body = "
                <p>Bonjour,</p>
                <p>Cliquez sur le lien ci-dessous pour réinitialiser votre mot de passe :</p>
                <p><a href='$reset_link'>$reset_link</a></p>
            ";

            $mail->send();
            echo "Un email de réinitialisation a été envoyé à l'adresse $email.";
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
        }
    } else {
        echo "Aucun compte trouvé avec cet email.";
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
    <title>Mot de passe oublié</title>
</head>
<body>
    <form method="POST">
        <label for="email">Adresse email :</label>
        <input type="email" name="email" id="email" placeholder="Saisissez votre email" required>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
