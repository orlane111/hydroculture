<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutoriel Hydroculture - Guide Complet</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
            --dark-color: #34495e;
            --light-color: #f8f9fa;
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: var(--light-color);
            overflow-x: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 3rem 1rem;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: fadeInDown 0.8s ease;
        }
        
        .header h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .main-content {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 3rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            opacity: 0;
            transform: translateY(20px);
        }
        
        .section.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .section:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .section-img {
            flex: 1;
            padding: 1rem;
        }
        
        .section-content {
            flex: 1;
            padding: 1rem;
        }
        
        .section:nth-child(even) .section-img {
            order: 2;
        }
        
        .section:nth-child(even) .section-content {
            order: 1;
        }
        
        .responsive-img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }
        
        .responsive-img:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .section h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-family: 'Poppins', sans-serif;
            position: relative;
            padding-bottom: 10px;
        }
        
        .section h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 3px;
            background: var(--secondary-color);
        }
        
        p {
            margin-bottom: 1rem;
        }
        
        .video-link {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 1rem;
            transition: var(--transition);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .video-link:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        
        .video-link i {
            margin-right: 8px;
        }
        
        .step-list {
            margin: 1.5rem 0;
            padding-left: 1.5rem;
        }
        
        .step-list li {
            margin-bottom: 0.8rem;
            position: relative;
        }
        
        .step-list li::before {
            content: '→';
            color: var(--primary-color);
            font-weight: bold;
            position: absolute;
            left: -1.5rem;
        }
        
        .footer {
            background-color: var(--dark-color);
            color: green;
            padding: 1.5rem;
            text-align: center;
            margin-top: 2rem;
        }
        
        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .section {
                flex-direction: column;
            }
            
            .section:nth-child(even) .section-img,
            .section:nth-child(even) .section-content {
                order: initial;
            }
            
            .section-img, .section-content {
                padding: 1rem 0;
                width: 100%;
            }
            
            .header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
<?php 
    include('en_teteA.php');
?>
    <!-- ======= En-tête ======= 
    <header class="header">
        <h1>Découvrez les bases de l'hydroponie</h1>
        <p>Apprenez à cultiver sans sol avec nos tutoriels vidéo complets et faciles à suivre</p>
    </header>-->

    <!-- ======= Section principale ======= -->
    <main class="main-content">

        <!-- === Section : Introduction à l'hydroculture === -->
        <section class="section" id="introduction">
            <div class="section-img">
                <img src="../images/image_tuto/image1.jpg" alt="Introduction à l'hydroculture" class="responsive-img">
            </div>
            <div class="section-content">
                <h2>Introduction à l'Hydroculture</h2>
                <p>L'hydroculture est une méthode innovante de culture des plantes sans sol, utilisant une solution nutritive riche en minéraux essentiels. Cette technique permet une croissance plus rapide, une meilleure utilisation de l'eau et un contrôle précis des nutriments.</p>
                
                <a href="https://www.youtube.com/watch?v=tvPit0mT1LA" target="_blank" class="video-link">
                    <i class="fas fa-play"></i> Regarder la vidéo introductive
                </a>
            </div>
        </section>

        <!-- === Section : Fabrication du système === -->
        <section class="section" id="fabrication">
            <div class="section-content">
                <h2>Fabrication du Système Hydroponique</h2>
                <p>Créez votre propre système hydroponique avec ce guide étape par étape :</p>
                
                <ul class="step-list">
                    <li><strong>Choix du Type de Système :</strong> NFT (Nutrient Film Technique), DWC (Deep Water Culture), Goutte-à-goutte ou Ebb & Flow</li>
                    <li><strong>Matériel nécessaire :</strong> Conteneurs, pompe à eau, nutriments hydroponiques, pH-mètre, substrat</li>
                    <li><strong>Étapes de fabrication :</strong> Assemblage des composants, installation du système d'irrigation</li>
                </ul>
                
                <a href="https://www.youtube.com/watch?v=60Blb7i-tcQ" target="_blank" class="video-link">
                    <i class="fas fa-tools"></i> Tutoriel système NFT
                </a>
            </div>
            <div class="section-img">
                <img src="../images/image_tuto/image2.jpg" alt="Fabrication du système hydroponique" class="responsive-img">
            </div>
        </section>

        <!-- === Section : Gestion et entretien === -->
        <section class="section" id="maintenance">
            <div class="section-img">
                <img src="../images/image_tuto/image3.jpg" alt="Gestion et entretien du système hydroponique" class="responsive-img">
            </div>
            <div class="section-content">
                <h2>Gestion et Entretien</h2>
                <p>Pour maintenir un système hydroponique performant et des plantes en bonne santé :</p>
                
                <ul class="step-list">
                    <li><strong>pH :</strong> Maintenir entre 5.5 et 6.5 pour une absorption optimale</li>
                    <li><strong>CE :</strong> Mesurer régulièrement pour ajuster la concentration nutritive</li>
                    <li><strong>Renouvellement :</strong> Toutes les 1 à 2 semaines selon le système</li>
                    <li><strong>Contrôle :</strong> Température idéale entre 18°C et 24°C</li>
                </ul>
                
                <a href="https://www.youtube.com/watch?v=JKCKvMEyqXQ" target="_blank" class="video-link">
                    <i class="fas fa-clipboard-check"></i> Tutoriel gestion & entretien
                </a>
            </div>
        </section>

        <!-- === Section : Nettoyage du système === -->
        <section class="section" id="cleaning">
            <div class="section-content">
                <h2>Nettoyage du Système Hydroponique</h2>
                <p>Un nettoyage régulier prévient les maladies et prolonge la durée de vie de votre système :</p>
                
                <ul class="step-list">
                    <li>Débrancher et vider complètement le système</li>
                    <li>Nettoyer soigneusement tous les composants</li>
                    <li>Désinfecter avec une solution appropriée</li>
                    <li>Rincer abondamment à l'eau claire</li>
                    <li>Inspecter et remplacer les pièces endommagées</li>
                </ul>
                
                <a href="https://www.youtube.com/watch?v=Fl1ATU6ZmA0" target="_blank" class="video-link">
                    <i class="fas fa-broom"></i> Tutoriel nettoyage Dutch Bucket
                </a>
            </div>
            <div class="section-img">
                <img src="../images/image_tuto/image4.jpg" alt="Nettoyage du système hydroponique" class="responsive-img">
            </div>
        </section>

    </main>

    <!-- ======= Pied de page ======= -->

<footer class="secondary_header footer">
    <div class="copyright">&copy;2025 - <strong>Hydro Culture</strong></div>
    <p style="margin-top: 0.5rem; font-size: 0.9rem;">
            <a href="#" style="color: var(--primary-color); text-decoration: none;">Mentions légales</a> | 
            <a href="#" style="color: var(--primary-color); text-decoration: none;">Contact</a>
    </p>
</footer>


    <script>
        // Animation au défilement
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.section');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });
            
            sections.forEach(section => {
                observer.observe(section);
            });
            
            // Animation des liens vidéo
            const videoLinks = document.querySelectorAll('.video-link');
            videoLinks.forEach(link => {
                link.addEventListener('mouseenter', () => {
                    link.style.animation = 'pulse 0.5s ease';
                });
                
                link.addEventListener('mouseleave', () => {
                    link.style.animation = '';
                });
            });
        });
    </script>
</body>
</html>