<?php
$feedback = "";

// reCAPTCHA geheime sleutel
$recaptcha_secret = "6LcVQGYrAAAAAGYl-GhRdFfPALxIQgM9JrwbL3gi";

// Functie om headers te checken tegen injectie
function bevatNieuweRegels($str) {
    return preg_match("/[\r\n]/", $str);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Honeypot veld (moet leeg zijn)
    if (!empty($_POST['website'])) {
        $feedback = "❌ Bot gedetecteerd.";
    } 
    // reCAPTCHA check
    elseif (empty($_POST['g-recaptcha-response'])) {
        $feedback = "❌ Bevestig dat je geen robot bent.";
    } else {
        $recaptcha_response = $_POST['g-recaptcha-response'];
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
        $response_data = json_decode($response);

        if (!$response_data->success) {
            $feedback = "❌ reCAPTCHA-verificatie mislukt. Probeer opnieuw.";
        } else {
            // ✅ CAPTCHA geslaagd, ga verder met validatie
            $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

            // Email validatie + header injection check
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || bevatNieuweRegels($email)) {
                $feedback = "❌ Ongeldig e-mailadres.";
            } else {
                $to = "daelemans.kasper@gmail.com";
                $subject = "Nieuw bericht van $name via het contactformulier";
                $body = "Naam: $name\nE-mail: $email\n\nBericht:\n$message";

                $headers = "From: contact@steltenlopers\r\n";
                $headers .= "Reply-To: $email\r\n";

                if (mail($to, $subject, $body, $headers)) {
                    $feedback = "✅ Bericht succesvol verzonden. Bedankt, $name!";
                } else {
                    $feedback = "❌ Er is een fout opgetreden. Probeer het later opnieuw.";
                }
            }
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/d9196de2ad.js" crossorigin="anonymous"></script>
    <link rel="icon" href="images/logo.jpg" type="image/png">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>
    <header>
        <nav>
            <div>
                <a href="index.html"><img class="logo" src="images/logo.jpg" alt="logo" width="50"></a>

                <label class="burger" for="checkbox">&equiv;</label>
                <input id="checkbox" type="checkbox">

                <div class="taalswitch">
                    <a href="contact.php">NL</a>
                    <p> | </p>
                    <a href="FR-contact.php">FR</a>
                    <p> | </p>
                    <a href="EN-Contact.php">EN</a>
                </div>
            </div>


            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="deGroep.html">De groep</a></li>
                <li><a href="Kalender.html">Kalender</a></li>
                <li><a href="cultureelErfgoed.html">Cultureel Erfgoed</a></li>
                <li><a href="Historiek.html">Historiek</a></li>
                <li><a href="fotos.html">Foto's</a></li>
                <li><a id="contact" href="Contact.php">Contact</a></li>
            </ul>
        </nav>

        <div class="header width">
            <div class="head-text">
                <h1>Koninklijke Steltenlopers van Merchtem</h1>
                <h2>Hoog boven de massa, al generaties lang</h2>
            </div>
            <!-- slideshow -->
            <img class="groepsfoto" src="images/Header/header1.jpg" alt="header1">
        </div>
    </header>

    <main>
        <div class="contact-container width">
            <?php if (!empty($feedback)): ?>
                     <p class="feedback"><?= $feedback ?></p>
                <?php endif; ?>
            <h1>Contacteer ons</h1>
            contacteer ons via het contactformulier of via de telefoon. Wij proberen zo snel mogelijk te
            antwoorden op uw bericht. Voor dringende zaken kan u ons ook telefonisch bereiken.
            <div class="contact-info">
                <p><strong>Telefoon president:</strong> <a href="tel:+32476373786">+32 (0)476.37.37.86</a></p>

                <form action="" method="POST" class="contact-form">
                    <label for="name">Jouw naam:</label><br />
                    <input type="text" id="name" name="name" required /><br /><br />

                    <label for="email">Jouw Email:</label><br />
                    <input type="email" id="email" name="email" required /><br /><br />

                    <label for="message">Bericht:</label><br />
                    <textarea id="message" name="message" rows="5" required></textarea><br /><br />

                    <div class="g-recaptcha" data-sitekey="6LcVQGYrAAAAAH5sGqPEXtHCJvpX5tcMU3hGSSu8"></div>
                    <br>
                    <button class="submit" type="submit">Verstuur</button>

                </form>

                
                <div class="socials">
                    <p><strong>Sociale media:</strong></p>
                    <a href="https://www.instagram.com/steltenlopers/" target="_blank"><i
                            class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.facebook.com/Steltenlopers" target="_blank"><i
                            class="fa-brands fa-facebook"></i></a>
                </div>
                </p>
            </div>
        </div>

    </main>

    <footer>
        <div class="width">
            <section>
                <h3>Boekingen</h3>
                <p>U kan ons boeken voor uw evenement, feest of promotieactiviteit. Wij treden op in België en ver
                    daarbuiten! Geef een seintje via de <a href="Contact.php">contactpagina</a> en wij nemen zo snel
                    mogelijk contact op.</p>
            </section>

            <section>
                <h3>Immaterieel Cultureel Erfgoed</h3>
                <p>in 2019 zijn wij erkend als immaterieel, Cultureel erfgoed. Hier zijn wij tot op de dag van
                    vandaag nog heel trots op! <br><img class="CulErf" src="images/logo_inventaris_immaterieel_erfgoed.jpg" alt="img cultureel erfgoed" width="50%"></p>
            </section>

            <section>
                <h3>Koeweideblock 9, 1785 Merchten Belgium</h3>
                <p><a href="mailto:info@steltenlopersmerchtem.be">info@steltenlopersmerchtem.be</a></p>
            </section>
        </div>
        <p>&copy; 2025 Koninklijke Steltenlopers van Merchtem</p>
        <p>Website gemaakt door <a href="https://www.linkedin.com/in/kasper-daelemans-875b2b1a0" target="_blank">Kasper
                Daelemans</a></p>

    </footer>


</body>

<script src="javascript/script.js"></script>

</html>