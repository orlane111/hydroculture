<?php
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $sujet = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $texte = htmlspecialchars(trim($_POST['message'] ?? ''));

    if ($nom && $email && $sujet && $texte) {
        $to = 'nguessamiensa137@gmail.com';
        $subject = "[Hydroculture225] Nouveau message de contact : $sujet";
        $body = "Nom : $nom\nEmail : $email\nTéléphone : $phone\nSujet : $sujet\n\nMessage :\n$texte";
        $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";
        if (mail($to, $subject, $body, $headers)) {
            $message = '<div class="contact-success">Votre message a bien été envoyé. Merci de nous avoir contactés !</div>';
        } else {
            $message = '<div class="contact-error">Erreur lors de l\'envoi du message. Veuillez réessayer plus tard.</div>';
        }
    } else {
        $message = '<div class="contact-error">Veuillez remplir tous les champs obligatoires.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous | Hydroculture225</title>
    <link rel="stylesheet" href="../commun_files/contact.css">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .contact-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.1em;
        }
        .contact-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.1em;
        }
        .contact-form form {
            margin-top: 10px;
        }
        .contact-form .btn-submit {
            background: linear-gradient(90deg, #2ecc71 0%, #27ae60 100%);
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            box-shadow: 0 2px 8px rgba(46,204,113,0.08);
        }
        .contact-form .btn-submit:hover {
            background: linear-gradient(90deg, #27ae60 0%, #2ecc71 100%);
        }
        .contact-form input, .contact-form textarea, .contact-form select {
            font-size: 1em;
            border: 1.5px solid #e0e0e0;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 15px;
            width: 100%;
            background: #f8f9fa;
            transition: border 0.2s;
        }
        .contact-form input:focus, .contact-form textarea:focus, .contact-form select:focus {
            border-color: #2ecc71;
            outline: none;
        }
        .contact-form label {
            font-weight: 500;
            color: #212121;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<?php 
    include('en_teteA.php');
?>
    <header>
        <div class="container">
            
            
            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <!-- Bannière -->


    <!-- Section principale de contact -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-container">
                <!-- Informations de contact -->
                <div class="contact-info">
                    <h3>Informations de contact</h3>
                    <div class="info-item">
                        <div class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="text">
                            <h4>Notre adresse</h4>
                            <p>PIGIER Côte d'Ivoire, Plateau</p>
                            <p>Abidjan, Côte d'Ivoire</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="text">
                            <h4>Téléphone</h4>
                            <p>+225 07 XX XX XX XX</p>
                            <p>+225 05 XX XX XX XX</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="text">
                            <h4>Email</h4>
                            <p>contact@hydroculture225.ci</p>
                            <p>info@hydroculture225.ci</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="text">
                            <h4>Heures d'ouverture</h4>
                            <p>Lun - Ven: 8h00 - 18h00</p>
                            <p>Sam: 9h00 - 15h00</p>
                        </div>
                    </div>
                    
                    <div class="social-links">
                        <h4>Suivez-nous</h4>
                        <div class="social-icons">
                            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Formulaire de contact -->
                <div class="contact-form">
                    <h3>Envoyez-nous un message</h3>
                    <?php echo $message; ?>
                    <form id="contactForm" method="post" action="">
                        <div class="form-group">
                            <label for="name">Nom complet</label>
                            <input type="text" id="name" name="name" placeholder="Votre nom" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Votre email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="phone">Téléphone</label>
                            <input type="tel" id="phone" name="phone" placeholder="Votre numéro de téléphone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="subject">Sujet</label>
                            <select id="subject" name="subject" required>
                                <option value="" disabled <?php if (!isset($_POST['subject'])) echo 'selected'; ?>>Choisissez un sujet</option>
                                <option value="information" <?php if (isset($_POST['subject']) && $_POST['subject'] == 'information') echo 'selected'; ?>>Demande d'information</option>
                                <option value="devis" <?php if (isset($_POST['subject']) && $_POST['subject'] == 'devis') echo 'selected'; ?>>Demande de devis</option>
                                <option value="conseil" <?php if (isset($_POST['subject']) && $_POST['subject'] == 'conseil') echo 'selected'; ?>>Conseil technique</option>
                                <option value="partenariat" <?php if (isset($_POST['subject']) && $_POST['subject'] == 'partenariat') echo 'selected'; ?>>Proposition de partenariat</option>
                                <option value="autre" <?php if (isset($_POST['subject']) && $_POST['subject'] == 'autre') echo 'selected'; ?>>Autre</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" placeholder="Votre message" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?></textarea>
                        </div>
                        <button type="submit" class="btn-submit">Envoyer le message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Section carte -->
    <section class="map-section">
        <div class="container">
            <h3>Nous trouver</h3>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.4479259622307!2d-4.0273212!3d5.3260262!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfc1edd22999d9f7%3A0x5f3dad9adbb3fb9e!2sPIGIER%20C%C3%B4te%20d&#39;Ivoire!5e0!3m2!1sfr!2sci!4v1651234567890!5m2!1sfr!2sci" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Section FAQ -->
    <section class="faq-section">
        <div class="container">
            <h3>Questions fréquentes</h3>
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Qu'est-ce que l'hydroculture ?</h4>
                        <span class="faq-toggle"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>L'hydroculture est une méthode de culture des plantes sans sol, où les racines sont immergées dans une solution nutritive. Cette technique permet une croissance plus rapide et plus saine des plantes tout en économisant l'eau et l'espace.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Quels sont les avantages de l'hydroculture ?</h4>
                        <span class="faq-toggle"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>L'hydroculture offre de nombreux avantages : économie d'eau (jusqu'à 90% par rapport à l'agriculture traditionnelle), croissance plus rapide des plantes, rendements plus élevés, moins de maladies et parasites, et possibilité de cultiver dans des espaces urbains ou restreints.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Proposez-vous des formations en hydroculture ?</h4>
                        <span class="faq-toggle"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>Oui, Hydroculture225 propose des formations complètes pour les particuliers et les professionnels. Nos programmes couvrent les bases de l'hydroculture, la mise en place de systèmes, la gestion des nutriments et l'optimisation des rendements. Contactez-nous pour plus d'informations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pied de page -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <h2>Hydro<span>culture225</span></h2>
                    <p>Solutions innovantes d'agriculture hydroponique en Côte d'Ivoire</p>
                </div>
                <div class="footer-links">
                    <h3>Liens rapides</h3>
                    <ul>
                        <li><a href="index.html">Accueil</a></li>
                        <li><a href="services.html">Nos Services</a></li>
                        <li><a href="products.html">Produits</a></li>
                        <li><a href="about.html">À propos</a></li>
                        <li><a href="contact.html">Contact</a></li>
                        <li><a href="blog.html">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-newsletter">
                    <h3>Newsletter</h3>
                    <p>Inscrivez-vous pour recevoir nos conseils et actualités sur l'hydroculture</p>
                    <form>
                        <input type="email" placeholder="Votre email">
                        <button type="submit">S'inscrire</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Hydroculture225. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Script pour le menu mobile
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('nav').classList.toggle('active');
        });

        // Script pour les FAQ
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                faqItem.classList.toggle('active');
                
                const icon = question.querySelector('.faq-toggle i');
                if (faqItem.classList.contains('active')) {
                    icon.classList.replace('fa-plus', 'fa-minus');
                } else {
                    icon.classList.replace('fa-minus', 'fa-plus');
                }
            });
        });
    </script>
</body>
</html>