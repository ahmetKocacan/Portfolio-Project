<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio | Backend .NET Developer</title>
    <meta name="description" content="Backend .NET Developer with a background in Unity game development and frontend engineering. Building robust, scalable server-side systems.">
    <meta name="keywords" content="portfolio, backend developer, .NET, C#, ASP.NET Core, Unity, game development, frontend">
    <meta name="author" content="My Portfolio">
    <meta property="og:title" content="My Portfolio | Backend .NET Developer">
    <meta property="og:description" content="Backend .NET Developer with roots in Unity and Frontend development.">
    <meta property="og:type" content="website">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<nav class="navbar" id="navbar" role="navigation" aria-label="Main navigation">
    <div class="container nav-inner">
        <a href="#hero" class="nav-logo" aria-label="Portfolio Home">Port<span>folio</span></a>
        <ul class="nav-links" id="nav-links" role="list">
            <li><a href="#hero" class="active">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#projects">Projects</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <div class="nav-actions">
            <button id="theme-toggle" aria-label="Toggle dark/light mode" title="Toggle theme">☀️</button>
            <a href="login.php" class="btn btn-outline" style="padding:.5rem 1rem;font-size:.85rem" aria-label="Admin login">Admin</a>
            <button class="hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<section id="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="dot"></span>
                Open to new opportunities
            </div>
            <h1 class="hero-heading">
                Hi, I'm<br>
                <span class="gradient-text">Ahmet Kocacan</span>
            </h1>
            <p class="hero-role"><span id="typed-text"></span><span class="cursor" aria-hidden="true">|</span></p>
            <p class="hero-subtext">
                I specialize in building scalable, high-performance backend systems with .NET and C#. With a diverse background spanning Unity game development and frontend engineering, I bring a full-picture perspective to every system I architect.
            </p>
            <div class="hero-actions">
                <a href="#projects" class="btn btn-primary" id="view-projects-btn">🚀 View My Work</a>
                <a href="#contact" class="btn btn-outline" id="contact-me-btn">✉️ Contact Me</a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <span class="num">3+</span>
                    <span class="lbl">Years of Experience</span>
                </div>
                <div class="hero-stat">
                    <span class="num">3</span>
                    <span class="lbl">Domains Mastered</span>
                </div>
                <div class="hero-stat">
                    <span class="num">10+</span>
                    <span class="lbl">Technologies</span>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-scroll" aria-hidden="true">
        <span>Scroll</span>
        <div class="scroll-arrow"></div>
    </div>
</section>

<section id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-image-wrap reveal">
                <div class="about-image-frame">
                    <div class="slider-container" aria-label="Career journey slider" role="region">
                        <div class="slider-track">
                            <div class="slide">
                                <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?q=80&w=800&auto=format&fit=crop" alt="Backend server infrastructure" loading="lazy">
                                <div class="slide-caption"><h4>Backend Architecture</h4></div>
                            </div>
                            <div class="slide">
                                <img src="https://images.unsplash.com/photo-1556438064-2d7646166914?q=80&w=800&auto=format&fit=crop" alt="Unity game development" loading="lazy">
                                <div class="slide-caption"><h4>Unity Game Development</h4></div>
                            </div>
                            <div class="slide">
                                <img src="https://images.unsplash.com/photo-1547658719-da2b51169166?q=80&w=800&auto=format&fit=crop" alt="Frontend development" loading="lazy">
                                <div class="slide-caption"><h4>Frontend Engineering</h4></div>
                            </div>
                        </div>
                        <button class="slider-btn prev" id="slider-prev" aria-label="Previous slide">&#8249;</button>
                        <button class="slider-btn next" id="slider-next" aria-label="Next slide">&#8250;</button>
                    </div>
                </div>
                <div class="slider-controls" role="tablist" aria-label="Slider navigation">
                    <button class="slider-dot active" data-index="0" aria-label="Slide 1" role="tab"></button>
                    <button class="slider-dot" data-index="1" aria-label="Slide 2" role="tab"></button>
                    <button class="slider-dot" data-index="2" aria-label="Slide 3" role="tab"></button>
                </div>
                <div class="about-float-card" aria-label="Experience stat">
                    <div class="value">3+</div>
                    <div class="label">Years Experience</div>
                </div>
            </div>

            <div class="about-text reveal">
                <span class="section-label">✨ About Me</span>
                <h2 class="section-title">From pixels to <span>packets</span> — a full journey</h2>
                <p style="color:var(--text-secondary);margin-bottom:1.25rem;line-height:1.9">
                    My development career started on the frontend, building responsive and interactive web experiences. During that chapter, I contributed to commercial projects like <a href="https://musichool.co/tr/" target="_blank" rel="noopener" style="color:var(--accent);text-decoration:none;font-weight:600">Musichool</a>, an online music education platform.
                </p>
                <p style="color:var(--text-secondary);margin-bottom:1.25rem;line-height:1.9">
                    Hungry for deeper challenges, I shifted into Unity game development — learning real-time systems, physics engines, C# scripting, and performance optimization under strict constraints.
                </p>
                <p style="color:var(--text-secondary);margin-bottom:2rem;line-height:1.9">
                    Today, I work as a Backend .NET Developer, designing and building APIs, microservices, and data-driven systems. My cross-domain experience gives me a unique perspective — I understand the UI, the game loop, and the server layer all at once.
                </p>

                <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem;color:var(--text-secondary)">CURRENT STACK</h3>
                <div class="skills-grid">
                    <div class="skill-tag"><span class="skill-icon">⚙️</span> C# / .NET</div>
                    <div class="skill-tag"><span class="skill-icon">🌐</span> ASP.NET Core</div>
                    <div class="skill-tag"><span class="skill-icon">🗄️</span> SQL Server / MySQL</div>
                    <div class="skill-tag"><span class="skill-icon">🔌</span> RESTful APIs</div>
                </div>

                <h3 style="font-size:1rem;font-weight:700;margin:1.5rem 0 1rem;color:var(--text-muted)">PAST EXPERIENCE</h3>
                <div class="skills-grid">
                    <div class="skill-tag" style="opacity:.75"><span class="skill-icon">🎮</span> Unity (C#)</div>
                    <div class="skill-tag" style="opacity:.75"><span class="skill-icon">🎯</span> Game Systems Design</div>
                    <div class="skill-tag" style="opacity:.75"><span class="skill-icon">🎨</span> HTML5 / CSS3</div>
                    <div class="skill-tag" style="opacity:.75"><span class="skill-icon">⚡</span> JavaScript (ES6+)</div>
                    <div class="skill-tag" style="opacity:.75"><span class="skill-icon">🐘</span> PHP</div>
                    <div class="skill-tag" style="opacity:.75"><span class="skill-icon">🔄</span> AJAX / Fetch API</div>
                </div>

                <a href="#contact" class="btn btn-primary" style="margin-top:2rem;display:inline-flex" id="hire-me-btn">💼 Hire Me</a>
            </div>
        </div>
    </div>
</section>

<section id="projects">
    <div class="container">
        <div class="projects-header">
            <div>
                <span class="section-label">🚀 My Work</span>
                <h2 class="section-title">Featured <span>Projects</span></h2>
            </div>
            <p class="section-subtitle" style="text-align:right">Dynamically loaded from the database via AJAX.</p>
        </div>
        <div class="projects-grid" id="projects-grid" role="list" aria-label="Projects list">
            <div class="projects-loading">
                <div class="spinner" aria-hidden="true"></div>
                <p>Loading projects...</p>
            </div>
        </div>
    </div>
</section>

<section id="contact">
    <div class="container">
        <div class="contact-grid">
            <div class="reveal">
                <span class="section-label">✉️ Get In Touch</span>
                <h2 class="section-title">Let's <span>Talk</span></h2>
                <p style="color:var(--text-secondary);line-height:1.9;margin-bottom:2rem">
                    Have a backend project, an interesting challenge, or just want to connect? I'd love to hear from you.
                </p>
                <div class="contact-links">
                    <a href="mailto:ahmetkocacan6@gmail.com" class="contact-link-item" id="email-link">
                        <span class="link-icon">📧</span>
                        <span>ahmetkocacan6@gmail.com</span>
                    </a>
                    <a href="https://github.com/KarlAsmond" target="_blank" rel="noopener" class="contact-link-item" id="github-link">
                        <span class="link-icon">🐙</span>
                        <span>github.com/KarlAsmond</span>
                    </a>
                    <a href="https://www.linkedin.com/in/ahmet-kocacan-0735462b4/" target="_blank" rel="noopener" class="contact-link-item" id="linkedin-link">
                        <span class="link-icon">💼</span>
                        <span>linkedin.com/in/ahmet-kocacan-0735462b4/</span>
                    </a>
                </div>
            </div>
            <div class="contact-form-wrap reveal">
                <div id="form-status" class="form-status" role="alert" aria-live="polite"></div>
                <form id="contact-form" novalidate aria-label="Contact form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact-name" class="form-label">Your Name *</label>
                            <input type="text" id="contact-name" name="name" class="form-input" placeholder="John Doe" required autocomplete="name" maxlength="100">
                            <span class="field-error" id="name-error" role="alert"></span>
                        </div>
                        <div class="form-group">
                            <label for="contact-email" class="form-label">Email Address *</label>
                            <input type="email" id="contact-email" name="email" class="form-input" placeholder="john@example.com" required autocomplete="email" maxlength="150">
                            <span class="field-error" id="email-error" role="alert"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact-message" class="form-label">Message *</label>
                        <textarea id="contact-message" name="message" class="form-textarea" placeholder="Tell me about your project..." required minlength="10"></textarea>
                        <span class="field-error" id="message-error" role="alert"></span>
                    </div>
                    <button type="submit" id="submit-btn" class="btn btn-primary btn-submit">
                        <span class="btn-text">🚀 Send Message</span>
                        <span class="btn-loader">⏳ Sending...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<footer role="contentinfo">
    <div class="container">
        <div class="footer-inner">
            <div class="footer-logo">Port<span>folio</span></div>
            <nav class="footer-links" aria-label="Footer navigation">
                <a href="#hero">Home</a>
                <a href="#about">About</a>
                <a href="#projects">Projects</a>
                <a href="#contact">Contact</a>
                <a href="login.php">Admin</a>
            </nav>
        </div>
        <p class="footer-copy">
            &copy; <span id="year"></span> Portfolio. Built with HTML5, CSS3, JavaScript, PHP &amp; MySQL.
        </p>
    </div>
</footer>

<script src="js/main.js"></script>
</body>
</html>
