<?php
// Définir le type de contenu de la réponse comme JSON
header('Content-Type: application/json');

// Récupérer les données du formulaire
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

// Vérifier que tous les champs sont remplis
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo json_encode([
        'success' => false,
        'message' => 'Veuillez remplir tous les champs du formulaire.'
    ]);
    exit;
}

// Vérifier que l'email est valide
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Veuillez fournir une adresse email valide.'
    ]);
    exit;
}

// Adresse email de destination (où vous voulez recevoir les messages)
$to = 'romaricgnininvi5@gmail.com';

// Construire le contenu de l'email
$email_content = "Nom: $name\n";
$email_content .= "Email: $email\n\n";
$email_content .= "Message:\n$message\n";

// Construire les en-têtes de l'email
$email_headers = "From: $name <$email>\n";
$email_headers .= "Reply-To: $email";

// Envoyer l'email
$mail_sent = mail($to, $subject, $email_content, $email_headers);

// Vérifier si l'email a été envoyé avec succès
if ($mail_sent) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Une erreur s\'est produite lors de l\'envoi du message. Veuillez réessayer.'
    ]);
}
?>