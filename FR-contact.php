<?php
$feedback = "";

// Fonction pour vérifier l’injection d’en-têtes
function contientDesSautsDeLigne($str) {
    return preg_match("/[\r\n]/", $str);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Champ honeypot (doit être vide)
    if (!empty($_POST['website'])) {
        $feedback = "❌ Bot détecté.";
    } else {
        // Validation reCAPTCHA
        $captcha = $_POST['g-recaptcha-response'] ?? '';
        $secretKey = "JOUW_SECRET_KEY_HIER";  // <-- Remplace par ta secret key

        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
        $responseKeys = json_decode($response, true);

        if (intval($responseKeys["success"]) !== 1) {
            $feedback = "❌ Veuillez valider le captcha.";
        } else {
            $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

            // Validation de l'email + injection d’en-tête
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || contientDesSautsDeLigne($email)) {
                $feedback = "❌ Adresse e-mail invalide.";
            } else {
                $to = "daelemans.kasper@gmail.com";
                $subject = "Nouveau message de $name via le formulaire de contact";
                $body = "Nom : $name\nE-mail : $email\n\nMessage :\n$message";

                $headers = "From: contact@steltenlopers\r\n";
                $headers .= "Reply-To: $email\r\n";

                if (mail($to, $subject, $body, $headers)) {
                    $feedback = "✅ Message envoyé avec succès. Merci, $name !";
                } else {
                    $feedback = "❌ Une erreur s'est produite. Veuillez réessayer plus tard.";
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://kit.fontawesome.com/d9196de2ad.js" crossorigin="anonymous"></script>
    <link rel="icon" href="images/logo.jpg" type="image/png" />
    
    <!-- reCAPTCHA script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <header>
        <nav>
            <div>
                <a href="FR-index.html"><img class="logo" src="images/logo.jpg" alt="logo" width="50" /></a>

                <label class="burger" for="checkbox">&equiv;</label>
                <input id="checkbox" type="checkbox" />

                <div class="taalswitch">
                    <a href="Contact.php">NL</a>
                    <p> | </p>
                    <a href="FR-contact.php">FR</a>
                    <p> | </p>
                    <a href="EN-Contact.php">EN</a>
                </div>
            </div>

            <ul>
                <li><a href="FR-index.html">Accueil</a></li>
                <li><a href="FR-groupe.html">Le groupe</a></li>
                <li><a href="FR-calendrier.html">Calendrier</a></li>
                <li><a href="FR-patrimoineCulturel.html">Patrimoine culturel</a></li>
                <li><a href="FR-historique.html">Historique</a></li>
                <li><a href="FR-photos.html">Photos</a></li>
                <li><a id="contact" href="FR-contact.php">Contact</a></li>
            </ul>
        </nav>

        <div class="header width">
            <div class="head-text">
                <h1>Les Echassiers Royaux de Merchtem</h1>
                <h2>Au-dessus de la foule, depuis des générations</h2>
            </div>
            <img class="groepsfoto" src="images/Header/header1.jpg" alt="header1" />
        </div>
    </header>

    <main>
        <div class="contact-container width">
            <?php if (!empty($feedback)): ?>
                <p class="feedback"><?= $feedback ?></p>
            <?php endif; ?>

            <h1>Contactez-nous</h1>
            Contactez-nous via le formulaire ou par téléphone. Nous essayons de répondre à votre message aussi rapidement que possible. En cas d'urgence, vous pouvez également nous appeler.
            
            <div class="contact-info">
                <p><strong>Téléphone du président :</strong> <a href="tel:+32476373786">+32 (0)476.37.37.86</a></p>

                <form action="" method="POST" class="contact-form">
                    <label for="name">Votre nom :</label><br />
                    <input type="text" id="name" name="name" required /><br /><br />

                    <label for="email">Votre e-mail :</label><br />
                    <input type="email" id="email" name="email" required /><br /><br />

                    <label for="message">Message :</label><br />
                    <textarea id="message" name="message" rows="5" required></textarea><br /><br />

                    <!-- Honeypot field (hidden) -->
                    <input type="text" name="website" style="display:none" />

                    <!-- reCAPTCHA widget -->
                    <div class="g-recaptcha" data-sitekey="6LcVQGYrAAAAAH5sGqPEXtHCJvpX5tcMU3hGSSu8"></div><br>

                    <button class="submit" type="submit">Envoyer</button>
                </form>

                <div class="socials">
                    <p><strong>Réseaux sociaux :</strong></p>
                    <a href="https://www.instagram.com/steltenlopers/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.facebook.com/Steltenlopers" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="width">
            <section>
                <h3>Réservations</h3>
                <p>Vous pouvez nous réserver pour vos événements, fêtes ou activités promotionnelles. Nous nous produisons en Belgique et bien au-delà ! Contactez-nous via la <a href="Contact.php">page de contact</a> et nous vous répondrons au plus vite.</p>
            </section>

            <section>
                <h3>Patrimoine Culturel Immatériel</h3>
                <p>En 2019, nous avons été reconnus comme patrimoine culturel immatériel. Nous en sommes toujours très fiers ! <br />
                    <img class="CulErf" src="images/logo_inventaris_immaterieel_erfgoed.jpg" alt="img patrimoine culturel" width="50%" />
                </p>
            </section>

            <section>
                <h3>Koeweideblock 9, 1785 Merchtem, Belgique</h3>
                <p><a href="mailto:info@steltenlopersmerchtem.be">info@steltenlopersmerchtem.be</a></p>
            </section>
        </div>
        <p>&copy; 2025 Les Echassiers Royaux de Merchtem</p>
        <p>Site web créé par <a href="https://www.linkedin.com/in/kasper-daelemans-875b2b1a0" target="_blank">Kasper Daelemans</a></p>
    </footer>

    <script src="javascript/script.js"></script>
</body>

</html>
