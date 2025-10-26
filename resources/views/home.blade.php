<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZTF Foundation - Home</title>
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link rel="stylesheet" href="{{asset('authAction.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
</head>
<body>
    
    <div class="top-bar">
        <div class="contact-info">
            <span style="border-right: 2px solid #fffdfd;"><i class="fas fa-phone-alt"></i> +237 683 067 844</span>
            <span style="margin-left: 5px;"><i class="fas fa-envelope"></i> info@ztffoundation.com</span>
        </div>
        <div class="social-icons">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </div>

    <nav class="navbar" id="mainNavbar">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('images/CMFI Logo.png') }}" alt="Site Logo">ZTF Foundation
        </a>
        <div class="hamburger" id="hamburgerMenu">
            <i class="fas fa-bars"></i>
        </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="{{ route('home') }}" class="active">Home</a></li>
            <li><a href="{{ route('about') }}" class="">About</a></li>
            <li><a href="{{route('indexDepts')}}">Departments</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
            <li><a href="{{route('blog')}}">Blog</a></li>
            <li class="auth-buttons">
                <a href="{{ route('login') }}" class="auth-link login-link"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="{{ route('identification.form') }}" class="auth-link"><i class="fas fa-user-plus"></i> Register</a>
            </li>
        </ul>
    </nav>

    <section class="home-section" id="home">
        <div class="content" style="margin-left:-10%">
            <h2>Welcome to the <span>Zacharias Tannee Fomum <br>Foundation</span> Staff Portal</h2>
            <p>Get information about all staff, resources, and management tools.</p>
            
        </div>
    </section>

    <h1>Key Features</h1>
    <div class="features-container">
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128100;</span> <h2 class="feature-title">Centralized Profiles</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Centralized Profiles</h2>
                    <p>Securely store and access comprehensive staff profiles, including personal details, contact information, and employment history.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128193;</span> <h2 class="feature-title">Document Management</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Document Management</h2>
                    <p>Effortlessly upload, organize, and retrieve important documents like contracts, certifications, and performance reviews.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128202;</span> <h2 class="feature-title">Performance Tracking</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Performance Tracking</h2>
                    <p>Monitor staff performance with customizable metrics, set goals, and conduct regular appraisals to foster growth.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128337;</span> <h2 class="feature-title">Leave & Attendance</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Leave & Attendance</h2>
                    <p>Simplify leave requests, approvals, and attendance tracking with an intuitive interface and automated calculations.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128200;</span> <h2 class="feature-title">Reporting & Analytics</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Reporting & Analytics</h2>
                    <p>Generate insightful reports and analytics on staff data, aiding in strategic decision-making and operational efficiency.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128274;</span> <h2 class="feature-title">Secure Access Control</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Secure Access Control</h2>
                    <p>Control access to sensitive staff information with role-based permissions, ensuring data privacy and security.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <h3>ZTF Foundation</h3>
            <p>Get information about all staff, resources, and management tools.</p>
            <ul class="footer-links">
                <li><a href="{{route('home')}}">Home</a></li>
                <li><a href="{{route('indexDepts')}}">Departments</a></li>
                <li><a href="{{route('contact')}}">Contact</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
            <div class="social-icons">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <p class="copyright">&copy; 2025 Zacharias Tannee Fomum Foundation. All rights reserved.</p>
        </div>
    </footer>

    
    
    <script src="{{ asset('js/home.js') }}"></script>
</body>
</html>
