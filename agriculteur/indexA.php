<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HydroCulture | Agriculture Innovante</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #00a86b;
            --primary-dark: #007a4d;
            --secondary: #2c3e50;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --accent: #e67e22;
            --text: #333;
            --text-light: #777;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--text);
            background-color: #f9f9f9;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            overflow: hidden;
        }

        

       
        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('../images/image_index/ag.jpeg') center/cover no-repeat;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 0 2rem;
        }

        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-content p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2rem;
        }

        .btn {
            display: inline-block;
            background-color: var(--accent);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
            background-color: #d35400;
        }

        /* Main Content */
        .main-content {
            padding: 4rem 2rem;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .article-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .article-card h2 {
            color: var(--primary);
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            position: relative;
            padding-bottom: 10px;
        }

        .article-card h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary);
        }

        .article-card p {
            margin-bottom: 1rem;
            color: var(--text-light);
        }

        .article-card ul {
            margin: 1.5rem 0;
            padding-left: 1.5rem;
        }

        .article-card li {
            margin-bottom: 0.8rem;
            position: relative;
        }

        .article-card li::before {
            content: '•';
            color: var(--primary);
            font-weight: bold;
            position: absolute;
            left: -1rem;
        }

        /* Sidebar */
        .sidebar {
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .sidebar-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .sidebar-card h3 {
            color: var(--primary);
            margin-bottom: 1rem;
            font-size: 1.3rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .sidebar-card ul {
            list-style: none;
        }

        .sidebar-card li {
            padding: 0.8rem 0;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .sidebar-card li:last-child {
            border-bottom: none;
        }

        .sidebar-card li:hover {
            color: var(--primary);
            transform: translateX(5px);
        }

        .sidebar-card a {
            color: inherit;
            text-decoration: none;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
            padding: 0 2rem 4rem;
        }

        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .product-img {
            height: 200px;
            overflow: hidden;
        }

        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-img img {
            transform: scale(1.1);
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-info h3 {
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .product-info p {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        /* Banner */
        .banner {
            display: flex;
            margin: 3rem 2rem;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .banner-half {
            flex: 1;
            padding: 3rem;
            text-align: center;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .banner-left {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }

        .banner-right {
            background: linear-gradient(135deg, var(--secondary), var(--dark));
        }

        /* Social Proof */
        .social-proof {
            display: flex;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 2rem;
        }

        .social-icon {
            margin: 0 1.5rem;
            transition: all 0.3s ease;
        }

        .social-icon img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            transform: scale(1.1) rotate(5deg);
        }

        /* Footer */
        footer {
            background-color: var(--secondary);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .footer-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .copyright {
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            font-size: 0.9rem;
            color: rgba(255,255,255,0.7);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .main-content {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                position: static;
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                padding: 1rem;
            }
            
            nav ul {
                margin-top: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            nav li {
                margin: 0.5rem 1rem;
            }
            
            .hero-content h1 {
                font-size: 2.2rem;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
            
            .banner {
                flex-direction: column;
            }
            
            .sidebar {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .hero {
                height: 50vh;
            }
            
            .hero-content h1 {
                font-size: 1.8rem;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .social-proof {
                flex-wrap: wrap;
            }
            
            .social-icon {
                margin: 0.5rem;
            }
        }
    </style>
</head>
<body>
<?php 
    include('en_teteA.php');
?>

    <section class="hero">
        <div class="hero-content">
            <h1>L'avenir de l'agriculture urbaine</h1>
            <p>Découvrez notre méthode innovante de culture hydroponique pour des plantes plus saines et une production plus efficace</p>
            <a href="Tutoriel.php" class="btn">Découvrir nos solutions</a>
        </div>
    </section>

    <div class="container">
        <div class="main-content">
            <main>
                <article class="article-card">
                    <h2>L'hydroculture révolutionnaire</h2>
                    <p>L'hydroculture, également connue sous le nom de culture hydroponique, est une méthode de culture des plantes qui gagne en popularité, notamment pour les plantes d'intérieur. Cette technique offre de nombreux avantages par rapport à la culture traditionnelle en terre.</p>
                    <p>Principe de base : les racines sont directement en contact avec l'eau contenant les nutriments. L'arrosage est contrôlé et souvent automatisé. Pas besoin de sol : cela réduit les maladies liées à la terre.</p>
                    
                    <h3 style="margin-top: 2rem; color: var(--accent);">Les avantages clés</h3>
                    <ul>
                        <li>Croissance plus rapide des plantes</li>
                        <li>Moins de consommation d'eau qu'en culture traditionnelle</li>
                        <li>Meilleur contrôle des nutriments et du pH</li>
                        <li>Moins d'insectes et de maladies du sol</li>
                    </ul>
                </article>

                <article class="article-card">
                    <h2>Notre approche innovante</h2>
                    <p>Nous combinons les dernières technologies avec des méthodes éprouvées pour vous offrir des solutions de culture optimales :</p>
                    
                    <div style="display: flex; align-items: center; margin: 2rem 0;">
                        <div style="flex: 1; padding-right: 2rem;">
                            <h3 style="color: var(--primary); margin-bottom: 1rem;">Systèmes automatisés</h3>
                            <p>Nos systèmes intelligents gèrent automatiquement l'arrosage, les nutriments et l'éclairage pour des résultats optimaux.</p>
                        </div>
                        <div style="flex: 1;">
                            <img src="../images/image_index/ag.jpeg" alt="Système hydroponique" style="width: 100%; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        </div>
                    </div>
                </article>
            </main>

            <aside class="sidebar">
                <div class="sidebar-card">
                    <h3>Nos dernières actualités</h3>
                    <ul>
                        <li><a target="_blank" href="https://hydropotager.com/hydroponie-pour-les-debutants#Les_10_plantes_les_plus_faciles_a_cultiver_en_hydroponie_pour_les_debutants">Les 10 plantes idéales pour débuter</a></li>
                        <li><a target="_blank" href="https://formations.lessourciers.com/inscription-formation-microferme-hydroponie/?utm_source=chatgpt.com">Atelier hydroponie du mois</a></li>
                        <li><a target="_blank" href="https://inhydro.in/hydroponics-in-2025-emerging-trends-shaping-the-future-of-farming-2/?utm_source=chatgpt.com">Nouveaux systèmes disponibles</a></li>
                        <li><a target="_blank" href="#">Témoignages de nos clients</a></li>
                        <li><a target="_blank" href="https://hydropotager.com/hydroponie">Guide des nutriments</a></li>
                    </ul>
                </div>

                <div class="sidebar-card">
                    <h3>Conseils pratiques</h3>
                    <ul>
                        <li><a target="_blank" href="https://www.hydroponique.fr/ph-controle-et-regulation-en-hydroponie/?utm_source=chatgpt.com">Maintenir le pH optimal</a></li>
                        <li><a target="_blank" href="https://www.cultureindoor.com/fr/content/30-les-conseils-controle-de-l-eau#:~:text=La%20solution%20nutritive%20et%20l,correctement%20les%20macronutriments%20et%20micronutriments.">Changer l'eau efficacement</a></li>
                        <li><a target="_blank" href="https://www.croquepousse.com/substrat-culture-hydroponique/#:~:text=Il%20existe%20diff%C3%A9rents%20types%20de,pour%20citer%20les%20plus%20populaires.">Choix des substrats</a></li>
                        <li><a target="_blank" href="https://www.croquepousse.com/temperature-eau-hydroponie/">Contrôler la température</a></li>
                        <li><a target="_blank" href="https://hydroponicsystems.eu/fr/comment-eviter-les-maladies-des-plantes/">Prévenir les maladies</a></li>
                    </ul>
                </div>
            </aside>
        </div>

        <div class="products-grid">
            <div class="product-card">
                <div class="product-img">
                    <img src="../images/image_index/auber.jpg" alt="Aubergines">
                </div>
                <div class="product-info">
                    <h3>Culture des aubergines</h3>
                    <p>Aubergines avec un feuillage spectaculaire et des fruits colorés, idéales pour votre potager hydroponique.</p>
                    <a href="#" class="btn" style="padding: 0.5rem 1rem; font-size: 0.8rem;">En savoir plus</a>
                </div>
            </div>

            <div class="product-card">
                <div class="product-img">
                    <img src="../images/image_index/cit.jpg" alt="Citronnier">
                </div>
                <div class="product-info">
                    <h3>Culture du citron</h3>
                    <p>Cultivez des citrons sans terre avec notre système hydroponique spécial agrumes.</p>
                    <a href="#" class="btn" style="padding: 0.5rem 1rem; font-size: 0.8rem;">En savoir plus</a>
                </div>
            </div>

            <div class="product-card">
                <div class="product-img">
                    <img src="../images/image_index/piment (2).jpg" alt="Piments">
                </div>
                <div class="product-info">
                    <h3>Culture de piments</h3>
                    <p>La culture hydroponique des piments permet une production abondante toute l'année.</p>
                    <a href="#" class="btn" style="padding: 0.5rem 1rem; font-size: 0.8rem;">En savoir plus</a>
                </div>
            </div>

            <div class="product-card">
                <div class="product-img">
                    <img src="../images/image_index/to.jpg" alt="Tomates">
                </div>
                <div class="product-info">
                    <h3>Culture des tomates</h3>
                    <p>Profitez de tomates fraîches toute l'année grâce à notre système hydroponique spécial tomates.</p>
                    <a href="#" class="btn" style="padding: 0.5rem 1rem; font-size: 0.8rem;">En savoir plus</a>
                </div>
            </div>
        </div>

        <div class="banner">
            <div class="banner-half banner-left">
                DES RACINES DANS L'EAU
            </div>
            <div class="banner-half banner-right">
                DES FRUITS EN OR
            </div>
        </div>
    </div>

    <div class="social-proof">
        <div class="social-icon">
            <img src="../images/image_index/fle.webp" alt="Fleurs">
        </div>
        <div class="social-icon">
            <img src="../images/image_index/ch.jpg" alt="Choux">
        </div>
        <div class="social-icon">
            <img src="../images/image_index/cul.jpg" alt="Culture">
        </div>
        <div class="social-icon">
            <img src="../images/image_index/hu.jpg" alt="Herbes">
        </div>
    </div>

    <footer>
        <div class="container footer-content">
            <div class="logo" style="font-size: 2rem; margin-bottom: 1rem;">Hydro<span>Culture</span></div>
            <p>Innovation et durabilité au service de l'agriculture urbaine</p>
            <div class="copyright">
                <p>Copyright © Pigier Côte d'Ivoire 2024 - Tous droits réservés</p>
            </div>
        </div>
    </footer>
</body>
</html>