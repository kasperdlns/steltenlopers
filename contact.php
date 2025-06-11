<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    $to = "daelemans.kasper@gmail.com";
    $subject = "New message from $name via contact form";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

    // Pas hier je From-header aan naar een bestaand mailadres op je domein
    $headers = "From: contact@jouwdomein.be\r\n";  // Vervang 'jouwdomein.be' door je echte domein
    $headers .= "Reply-To: $email\r\n";

    if (mail($to, $subject, $body, $headers)) {
        echo "Thanks for reaching out, $name! Your message has been sent.";
    } else {
        echo "Oops, something went wrong. Please try again.";
    }
} else {
    echo "Invalid request method.";
}

?>