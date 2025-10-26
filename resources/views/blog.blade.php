<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('blog.css')}}">
</head>
<body>
    <header class="header">
        <div class="container header-content">
            <div class="header-logo-container">
                <a href="{{route('home')}}" class="header-logo">
                    <img src="{{ asset('images/CMFI Logo.png') }}" alt="Site Logo">
                    ZTF Foundation
                </a>
            </div>
            <nav class="nav-desktop">
                <div class="nav-desktop-links">
                    <a href="{{route('home')}}" class="nav-link">Home</a>
                    <a href="{{route('about')}}" class="nav-link">About</a>
                    <a href="{{route('blog')}}" class="nav-link active">Blog</a>
                    <a href="{{route('contact')}}" class="nav-link">Contact</a>
                </div>
            </nav>
            <div class="mobile-menu-container">
                <button type="button" class="mobile-menu-toggle" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open menu</span>
                    <svg class="icon-svg icon-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="icon-svg icon-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="mobile-menu" id="mobile-menu">
            <div class="container">
                <a href="{{route('home')}}" class="mobile-nav-link">Home</a>
                <a href="{{route('about')}}" class="mobile-nav-link">About</a>
                <a href="{{route('blog')}}" class="mobile-nav-link">Blog</a>
                <a href="{{route('contact')}}" class="mobile-nav-link">Contact</a>
            </div>
        </div>
    </header>

    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Our Blog</h1>
            <p class="hero-subtitle">Stay updated with the latest news, insights, and stories from ZTF Foundation.</p>
        </div>
    </section>

    <main class="blog-main">
        <div class="container">
            <div class="blog-grid">
                <!-- Featured Post -->
                <article class="blog-post featured-post">
                    <div class="post-image">
                        <img src="{{ asset('images/IMG-20250827-WA0014.jpg') }}" alt="Featured post image">
                        <div class="post-category">Featured</div>
                    </div>
                    <div class="post-content">
                        <h2 class="post-title">
                            <a href="#">Empowering Communities Through Education and Support</a>
                        </h2>
                        <div class="post-meta">
                            <span class="post-date">September 27, 2025</span>
                            <span class="post-author">By Admin</span>
                        </div>
                        <p class="post-excerpt">
                            Discover how ZTF Foundation is making a difference in communities across Cameroon through innovative educational programs and sustainable development initiatives.
                        </p>
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </article>

                <!-- Regular Posts Grid -->
                <div class="regular-posts">
                    <article class="blog-post">
                        <div class="post-image">
                            <img src="{{ asset('images/IMG-20250827-WA0018.jpg') }}" alt="Blog post image">
                            <div class="post-category">News</div>
                        </div>
                        <div class="post-content">
                            <h3 class="post-title">
                                <a href="#">Latest Updates from Our Community Projects</a>
                            </h3>
                            <div class="post-meta">
                                <span class="post-date">September 27, 2025</span>
                                <span class="post-author">By Team Member</span>
                            </div>
                            <p class="post-excerpt">
                                Stay updated with our latest community initiatives and success stories from the field.
                            </p>
                            <a href="#" class="read-more">Read More</a>
                        </div>
                    </article>
                    <article class="blog-post">
                        <div class="post-image">
                            <img src="{{ asset('images/IMG-20250827-WA0018.jpg') }}" alt="Blog post image">
                            <div class="post-category">News</div>
                        </div>
                        <div class="post-content">
                            <h3 class="post-title">
                                <a href="#">Latest Updates from Our Community Projects</a>
                            </h3>
                            <div class="post-meta">
                                <span class="post-date">September 27, 2025</span>
                                <span class="post-author">By Team Member</span>
                            </div>
                            <p class="post-excerpt">
                                Stay updated with our latest community initiatives and success stories from the field.
                            </p>
                            <a href="#" class="read-more">Read More</a>
                        </div>
                    </article>
                </div>
                
            </div>

            <!-- Blog Sidebar -->
            <aside class="blog-sidebar">
                <div class="sidebar-widget search-widget">
                    <h3>Search Posts</h3>
                    <form class="search-form">
                        <input type="search" placeholder="Search...">
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.39zM11 18a7 7 0 1 1 7-7 7 7 0 0 1-7 7z"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="sidebar-widget categories-widget">
                    <h3>Categories</h3>
                    <ul>
                        <li><a href="#">Education <span>(12)</span></a></li>
                        <li><a href="#">Community <span>(8)</span></a></li>
                        <li><a href="#">Events <span>(5)</span></a></li>
                        <li><a href="#">News <span>(10)</span></a></li>
                        <li><a href="#">Stories <span>(7)</span></a></li>
                    </ul>
                </div>

                <div class="sidebar-widget recent-posts-widget">
                    <h3>Recent Posts</h3>
                    <div class="recent-posts">
                        <div class="recent-post">
                            <img src="{{ asset('images/IMG-20250827-WA0015.jpg') }}" alt="Recent post image">
                            <div class="recent-post-content">
                                <h4><a href="#">Recent Community Achievement</a></h4>
                                <span class="post-date">September 27, 2025</span>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="sidebar-widget tags-widget">
                    <h3>Tags</h3>
                    <div class="tags-cloud">
                        <a href="#" class="tag">Education</a>
                        <a href="#" class="tag">Community</a>
                        <a href="#" class="tag">Support</a>
                        <a href="#" class="tag">Development</a>
                        <a href="#" class="tag">Events</a>
                        <a href="#" class="tag">Charity</a>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <footer class="footer">
        <div class="container footer-content">
            <div class="footer-copyright">
                <p>&copy; {{ date('Y') }} ZTF Foundation. All rights reserved.</p>
            </div>
            <div class="footer-links">
                <a href="{{route('home')}}">Home</a>
                <a href="{{route('about')}}">About</a>
                <a href="{{route('blog')}}">Blog</a>
                <a href="{{route('contact')}}">Contact</a>
            </div>
            <div class="social-icons">
                <a href="#" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h2V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4V13.5z"/>
                    </svg>
                </a>
                <a href="#" aria-label="Twitter">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                    </svg>
                </a>
                <a href="#" aria-label="LinkedIn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/>
                    </svg>
                </a>
            </div>
        </div>
    </footer>

    

    <!-- Fixed Bottom Pagination -->
    <div class="pagination-container">
        <div class="pagination">
            <a href="#" class="pagination-link">&laquo; Previous</a>
            <a href="#" class="pagination-link active">1</a>
            <a href="#" class="pagination-link">2</a>
            <a href="#" class="pagination-link">3</a>
            <a href="#" class="pagination-link">Next &raquo;</a>
        </div>
    </div>
    <script src="{{ asset('js/blog.js') }}"></script>
</body>
</html>

