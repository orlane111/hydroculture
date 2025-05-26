<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HYDROCULTURE - Culture Hydroponique Moderne</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
            --dark-color: #34495e;
            --light-color: #ecf0f1;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            overflow-x: hidden;
        }

        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .primary_header {
            padding: 1.5rem 0;
            text-align: center;
            animation: fadeInDown 0.8s ease;
        }

        .title {
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            transition: var(--transition);
        }

        .title:hover {
            transform: scale(1.02);
        }

        .secondary_header {
            padding: 1rem 0;
            background-color: white;
        }

        #menu ul {
            display: flex;
            justify-content: center;
            list-style: none;
            flex-wrap: wrap;
        }

        #menu li {
            margin: 0 1.2rem;
            position: relative;
        }

        #menu a {
            color: var(--dark-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.5rem 0;
            display: block;
            transition: var(--transition);
        }

        #menu a:hover {
            color: var(--primary-color);
        }

        #menu a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary-color);
            transition: var(--transition);
        }

        #menu a:hover::after {
            width: 100%;
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
            .title {
                font-size: 2rem;
            }

            #menu ul {
                flex-direction: column;
                align-items: center;
            }

            #menu li {
                margin: 0.5rem 0;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="primary_header">
            <h1 class="title">HYDROCULTURE</h1>
        </div>
        <nav class="secondary_header" id="menu">
            <ul>
                <li><a href="../indexA.php" class="nav-link"><i class="fas fa-home"></i> ACCUEIL</a></li>
                <li><a href="produit.php" class="nav-link"><i class="fas fa-seedling"></i> PRODUIT</a></li>
                <li><a href="../tutoriel.php" class="nav-link"><i class="fas fa-book-open"></i> TUTORIEL</a></li>
                <li><a href="../contact.php" class="nav-link"><i class="fas fa-envelope"></i> CONTACT</a></li>
                <li><a href="../profil.php" class="nav-link"><i class="fas fa-user"></i> PROFIL</a></li>
            </ul>
        </nav>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation au survol des liens
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                link.addEventListener('mouseenter', () => {
                    link.style.animation = 'pulse 0.5s ease';
                });

                link.addEventListener('mouseleave', () => {
                    link.style.animation = '';
                });
            });

            // Animation du titre au chargement
            const title = document.querySelector('.title');
            setTimeout(() => {
                title.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    title.style.transform = 'scale(1)';
                }, 300);
            }, 1000);
        });
    </script>
</body>
</html>