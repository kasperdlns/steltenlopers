<?php
$feedback = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $feedback = "Invalid email address.";
    } else {
        $to = "daelemans.kasper@gmail.com";
        $subject = "New message from $name via the contact form";
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        $headers = "From: contact@steltenlopers\r\n";
        $headers .= "Reply-To: $email\r\n";

        if (mail($to, $subject, $body, $headers)) {
            $feedback = "✅ Message sent successfully. Thank you, $name!";
        } else {
            $feedback = "❌ An error occurred. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://kit.fontawesome.com/d9196de2ad.js" crossorigin="anonymous"></script>
    <link rel="icon" href="images/logo.jpg" type="image/png" />
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
                    <a href="EN-contact.php">EN</a>
                </div>
            </div>

            <ul>
                <li><a href="EN-index.html">Home</a></li>
                <li><a href="EN-groupe.html">The Group</a></li>
                <li><a href="EN-calender.html">Calendar</a></li>
                <li><a href="EN-CultHer.html">Cultural Heritage</a></li>
                <li><a href="EN-history.html">History</a></li>
                <li><a href="EN-photos.html">Photos</a></li>
                <li><a id="contact" href="EN-Contact.php">Contact</a></li>
            </ul>
        </nav>

        <div class="header width">
            <div class="head-text">
                <h1>The Royal Stilt Walkers of Merchtem</h1>
                <h2>Above the crowd, for generations</h2>
            </div>
            <img class="groepsfoto" src="images/Header/header1.jpg" alt="header1" />
        </div>
    </header>

    <main>
        <div class="contact-container width">
            <?php if (!empty($feedback)): ?>
                <p class="feedback"><?= $feedback ?></p>
            <?php endif; ?>

            <h1>Contact Us</h1>
            Contact us via the form or by phone. We try to respond to your message as soon as possible. In case of emergency, you can also call us.

            <div class="contact-info">
                <p><strong>President's phone number:</strong> <a href="tel:+32476373786">+32 (0)476.37.37.86</a></p>

                <form action="" method="POST" class="contact-form">
                    <label for="name">Your name:</label><br />
                    <input type="text" id="name" name="name" required /><br /><br />

                    <label for="email">Your email:</label><br />
                    <input type="email" id="email" name="email" required /><br /><br />

                    <label for="message">Message:</label><br />
                    <textarea id="message" name="message" rows="5" required></textarea><br /><br />

                    <button class="submit" type="submit">Send</button>
                </form>

                <div class="socials">
                    <p><strong>Social media:</strong></p>
                    <a href="https://www.instagram.com/steltenlopers/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.facebook.com/Steltenlopers" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="width">
            <section>
                <h3>Bookings</h3>
                <p>You can book us for your events, parties, or promotional activities. We perform in Belgium and far beyond! Contact us via the <a href="Contact.php">contact page</a> and we’ll get back to you as soon as possible.</p>
            </section>

            <section>
                <h3>Intangible Cultural Heritage</h3>
                <p>In 2019, we were officially recognized as intangible cultural heritage. We are still very proud of that! <br />
                    <img class="CulErf" src="images/logo_inventaris_immaterieel_erfgoed.jpg" alt="cultural heritage image" width="50%" />
                </p>
            </section>

            <section>
                <h3>Koeweideblock 9, 1785 Merchtem, Belgium</h3>
                <p><a href="mailto:info@steltenlopersmerchtem.be">info@steltenlopersmerchtem.be</a></p>
            </section>
        </div>
        <p>&copy; 2025 The Royal Stilt Walkers of Merchtem</p>
        <p>Website created by <a href="https://www.linkedin.com/in/kasper-daelemans-875b2b1a0" target="_blank">Kasper Daelemans</a></p>
    </footer>

    <script src="javascript/script.js"></script>
</body>

</html>
