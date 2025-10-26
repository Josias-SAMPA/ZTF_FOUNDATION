<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Departments - ZTF Foundation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('staff.css')}}">
    <link rel="stylesheet" href="{{asset('indexDepts.css')}}">
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
        <a href="#home" class="logo">
            <img src="{{asset('images/CMFI Logo.png')}}" alt="CMFI Logo">
        </a>
        <div class="hamburger" id="hamburgerMenu">
            <i class="fas fa-bars"></i> </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="{{route('home')}}" class="active">Home</a></li>
            <li><a href="{{route('about')}}" class="">About</a></li>
            <li><a href="{{route('blog')}}">Blog</a></li>
            <li><a href="{{route('contact')}}">Contact</a></li>
            <li><a href="{{route('identification.form')}}"><i class="fas fa-user"></i></a></li>

        </ul>
    </nav>
    <header>
        <div class="container">
            <h1 style="margin-top: 0;
            font-size: 2.8em;
            margin-bottom: 15px;color:#ecf0f1">Our Departments</h1>
            <p>Welcome to our "Departments" page, your gateway to understanding the diverse teams that power ZTF Foundation's success. Explore each section to learn more about the vital functions performed by our dedicated professionals.</p>
        </div>
    </header>

    <main class="container">
        <section class="departments-grid">
            @forelse ($allDepts as $dept)
            <div class="department-card">
                <div class="department-header">
                    <i class="fas fa-hands-praying department-icon"></i>
                    <h2>{{$dept->name}}</h2>
                    <span class="toggle-icon fas fa-chevron-down"></span>
                </div>
                <div class="department-content">
                    <div>
                        <p><strong>Overview:</strong> {{$dept->description}}</p>
                    </div>
                </div>
            </div>
            @empty
                <center><div class="div-msg-altern"><p class="msg-altern">Aucun Departement pour le moment</p> </div> </center>           
            @endforelse
        </section>
        <i class="fas fa-comments" style="
            position: fixed;
            bottom: 33px; /* Adjusted to be slightly higher */
            right: 30px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 2em;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.3s ease;
            z-index: 10000; /* Ensure it's above everything else */"></i>

    
    </main>
    
    <footer>
        <div class="container">
            <p>&copy; 2025 ZTF Foundation. All rights reserved.</p>
        </div>
    </footer>

    
    <script src="{{ asset('js/indexDepts.js') }}"></script>
</body>
</html>
