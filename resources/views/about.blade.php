<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ã€ propos de la ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('about.css')}}">
</head>

<body>
    <header class="header">
        <div class="container header-content">
            <div class="header-logo-container">
                <a href="{{route('home')}}" class="header-logo">ZTF Foundation</a>
            </div>
            <nav class="nav-desktop">
                <div class="nav-desktop-links">
                    <a href="{{route('home')}}" class="nav-link active">Accueil</a>
                    <a href="{{route('identification.form')}}" class="nav-link">Inscription Personnel</a>
                    <a href="{{route('login')}}" class="nav-link">Annuaire du Personnel</a>
                </div>
            </nav>
            <div class="mobile-menu-container">
                <button type="button" class="mobile-menu-toggle" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="icon-svg icon-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="icon-svg icon-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="mobile-menu" id="mobile-menu">
            <div class="container">
                <a href="{{route('home')}}" class="mobile-nav-link">Accueil</a>
                <a href="{{route('identification.form')}}" class="mobile-nav-link">Inscription Personnel</a>
            </div>
        </div>
    </header>

    <section class="hero-section section-padding">
        <div class="relative z-10">
            <h1 class="hero-title">Ã€ propos du Portail du Personnel ZTF Foundation</h1>
            <p class="hero-subtitle">
                Ce portail est votre centre nÃ©vralgique pour tout le personnel de la ZTF Foundation. AccÃ©dez aux ressources, connectez-vous avec vos collÃ¨gues et gÃ©rez votre parcours professionnel au sein de notre organisation.
            </p>
            <a href="registration_form.php" class="cta-button">S'inscrire comme Personnel</a>
        </div>
    </section>

    <section class="about-section section-padding">
        <h2 class="about-title">Notre Engagement envers le Personnel</h2>
        <p class="about-text">
            Ã€ la ZTF Foundation, nous comprenons que notre succÃ¨s dans l'autonomisation des communautÃ©s dÃ©coule directement du dÃ©vouement et du bien-Ãªtre de notre personnel. Ce portail est conÃ§u pour optimiser les opÃ©rations internes, amÃ©liorer la communication et fournir une plateforme complÃ¨te pour chaque membre de l'Ã©quipe. Nous croyons en la crÃ©ation d'un environnement favorable oÃ¹ le personnel peut s'Ã©panouir, accÃ©der aux informations essentielles et contribuer efficacement Ã  notre mission commune.
        </p>
    </section>

    <section class="values-section section-padding">
        <h2 class="values-section-title" style="text-align: center;">Principes du Portail</h2>
        <div class="values-grid">
            <div class="value-card">
                <svg class="value-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4ZM12 6C10.34 6 9 7.34 9 9C9 10.66 10.34 12 12 12C13.66 12 15 10.66 15 9C15 7.34 13.66 6 12 6ZM12 14C9.33 14 4 15.34 4 18V19H20V18C20 15.34 14.67 14 12 14Z"></path></svg>
                <h3 class="value-title">Autonomisation du Personnel</h3>
                <p class="value-description">Nous fournissons des outils et des ressources intuitifs pour aider chaque membre du personnel Ã  gÃ©rer ses informations, accÃ©der aux documents pertinents et suivre son Ã©volution professionnelle au sein de la Fondation.</p>
            </div>
            <div class="value-card">
                <svg class="value-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2L1 12H4V21H20V12H23L12 2ZM12 6.12L18.39 12H16V21H13V15H11V21H8V12H5.61L12 6.12Z"></path></svg>
                <h3 class="value-title">EfficacitÃ© & Organisation</h3>
                <p class="value-description">Ce portail est conÃ§u pour simplifier les processus internes, de l'inscription du personnel Ã  la gestion de l'annuaire, garantissant un accÃ¨s facile aux donnÃ©es organisationnelles essentielles.</p>
            </div>
            <div class="value-card">
                <svg class="value-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4ZM12 7C10.34 7 9 8.34 9 10C9 11.66 10.34 13 12 13C13.66 13 15 11.66 15 10C15 8.34 13.66 7 12 7ZM12 15C9.33 15 4 16.34 4 19V20H20V19C20 16.34 14.67 15 12 15Z"></path></svg>
                <h3 class="value-title">SÃ©curisÃ© & ConnectÃ©</h3>
                <p class="value-description">Nous priorisons la sÃ©curitÃ© des donnÃ©es du personnel et fournissons un environnement connectÃ© oÃ¹ les membres de l'Ã©quipe peuvent trouver des informations de contact et interagir professionnellement.</p>
            </div>
        </div>
    </section>

    <section class="bottom-cta-section section-padding">
        <h2 class="bottom-cta-title">PrÃªt Ã  Vous Connecter et Ã  Contribuer ?</h2>
        <p class="bottom-cta-text">
            Le Portail du Personnel ZTF Foundation est conÃ§u pour vous. Que vous vous inscriviez en tant que nouveau membre de l'Ã©quipe ou que vous souhaitiez explorer notre annuaire complet du personnel, votre parcours commence ici.
        </p>
        <div class="bottom-cta-buttons">
            <a href="{{route('identification.form')}}" class="cta-button">S'inscrire maintenant</a>
            <a href="{{route('login')}}" class="cta-button">Explorer l'Annuaire</a>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-copyright">
                <p>&copy; <?php echo date("Y"); ?> ZTF Foundation. Tous droits rÃ©servÃ©s.</p>
            </div>
            <div class="footer-links">
                <a href="{{route('home')}}">Accueil</a>
                <a href="{{route('identification.form')}}">Inscription</a>
                <a href="#">Annuaire</a>
            </div>
            <div class="social-icons">
                <a href="#" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M14 13.5H16.5L17 10.5H14V8.5C14 7.83 14 7.5 14.5 7.5H17V4.75C16.337 4.673 15.573 4.625 14.768 4.625C11.91 4.625 10 6.463 10 9.125V10.5H7V13.5H10V22H13V13.5H14Z"></path></svg>
                </a>
                <a href="#" aria-label="Twitter">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22.46 6C21.64 6.37 20.76 6.62 19.86 6.78C20.8 6.21 21.54 5.23 21.88 4.05C20.92 4.62 19.88 5.04 18.78 5.28C17.92 4.35 16.64 3.75 15.22 3.75C12.56 3.75 10.33 6 10.33 8.66C10.33 9.04 10.37 9.4 10.45 9.76C6.73 9.57 3.58 7.8 1.48 4.9C1.09 5.56 0.87 6.3 0.87 7.08C0.87 8.78 1.76 10.27 3.16 11.13C2.36 11.1 1.62 10.88 0.98 10.5L0.98 10.53C0.98 12.44 2.33 14.07 4.14 14.44C3.81 14.54 3.46 14.59 3.1 14.59C2.86 14.59 2.62 14.57 2.38 14.52C2.89 16.09 4.34 17.26 6.09 17.29C4.76 18.33 3.11 18.98 1.35 18.98C1.06 18.98 0.78 18.96 0.5 18.92C2.21 20.07 4.35 20.75 6.64 20.75C15.21 20.75 19.95 13.55 19.95 7.42C19.95 7.22 19.95 7.02 19.93 6.82C20.86 6.17 21.72 5.4 22.46 4.5Z"></path></svg>
                </a>
                <a href="#" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2ZM12 11.5C10.62 11.5 9.5 10.38 9.5 9C9.5 7.62 10.62 6.5 12 6.5C13.38 6.5 14.5 7.62 14.5 9C14.5 10.38 13.38 11.5 12 11.5Z"></path></svg>
                </a>
            </div>
        </div>
    </footer>

    
    <script src="{{ asset('js/about.js') }}"></script>
</body>
</html>
