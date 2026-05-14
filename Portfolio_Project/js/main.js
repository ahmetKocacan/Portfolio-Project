document.addEventListener('DOMContentLoaded', () => {

    const themeToggle = document.getElementById('theme-toggle');
    const html = document.documentElement;
    const savedTheme = localStorage.getItem('portfolio-theme') || 'dark';
    html.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('portfolio-theme', next);
            updateThemeIcon(next);
        });
    }

    function updateThemeIcon(theme) {
        if (themeToggle) themeToggle.textContent = theme === 'dark' ? '☀️' : '🌙';
    }

    const navbar = document.querySelector('.navbar');
    const hamburger = document.getElementById('hamburger');
    const navLinks = document.getElementById('nav-links');

    window.addEventListener('scroll', () => {
        if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 50);
        updateActiveNav();
    });

    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('open');
            navLinks.classList.toggle('open');
        });
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('open');
                navLinks.classList.remove('open');
            });
        });
    }

    function updateActiveNav() {
        const sections = document.querySelectorAll('section[id]');
        const links = document.querySelectorAll('.nav-links a');
        let current = '';
        sections.forEach(sec => {
            if (window.scrollY >= sec.offsetTop - 120) current = sec.getAttribute('id');
        });
        links.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) link.classList.add('active');
        });
    }

    const track = document.querySelector('.slider-track');
    const dots = document.querySelectorAll('.slider-dot');
    const prevBtn = document.querySelector('.slider-btn.prev');
    const nextBtn = document.querySelector('.slider-btn.next');
    let currentSlide = 0;
    let autoSlide;

    function goToSlide(index) {
        const slides = document.querySelectorAll('.slide');
        if (!slides.length) return;
        currentSlide = (index + slides.length) % slides.length;
        if (track) track.style.transform = `translateX(-${currentSlide * 100}%)`;
        dots.forEach((d, i) => d.classList.toggle('active', i === currentSlide));
    }

    if (prevBtn) prevBtn.addEventListener('click', () => { goToSlide(currentSlide - 1); resetAuto(); });
    if (nextBtn) nextBtn.addEventListener('click', () => { goToSlide(currentSlide + 1); resetAuto(); });
    dots.forEach((dot, i) => dot.addEventListener('click', () => { goToSlide(i); resetAuto(); }));

    function startAuto() { autoSlide = setInterval(() => goToSlide(currentSlide + 1), 4000); }
    function resetAuto() { clearInterval(autoSlide); startAuto(); }
    goToSlide(0);
    startAuto();

    const projectsGrid = document.getElementById('projects-grid');

    function loadProjects() {
        if (!projectsGrid) return;
        projectsGrid.innerHTML = `<div class="projects-loading"><div class="spinner"></div><p>Loading projects...</p></div>`;

        fetch('backend/api_projects.php')
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    projectsGrid.innerHTML = '';
                    data.data.forEach((p, i) => {
                        const card = document.createElement('div');
                        card.className = 'project-card reveal';
                        card.style.animationDelay = `${i * 0.1}s`;
                        const imgHTML = p.image_url
                            ? `<img src="${escapeHTML(p.image_url)}" alt="${escapeHTML(p.title)}" loading="lazy">`
                            : `<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:3rem;background:var(--bg-card)">🚀</div>`;
                        const demoLink = p.demo_link ? `<a href="${escapeHTML(p.demo_link)}" target="_blank" rel="noopener" class="project-link-btn">🌐 Demo</a>` : '';
                        const repoLink = p.repo_link ? `<a href="${escapeHTML(p.repo_link)}" target="_blank" rel="noopener" class="project-link-btn">📂 Code</a>` : '';
                        const date = new Date(p.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
                        card.innerHTML = `
                            <div class="project-img-wrap">
                                ${imgHTML}
                                <div class="project-overlay">${demoLink}${repoLink}</div>
                            </div>
                            <div class="project-body">
                                <h3>${escapeHTML(p.title)}</h3>
                                <p>${escapeHTML(p.description)}</p>
                                <div class="project-footer">
                                    <span class="project-date">📅 ${date}</span>
                                    <div style="display:flex;gap:.5rem">${demoLink}${repoLink}</div>
                                </div>
                            </div>`;
                        projectsGrid.appendChild(card);
                    });
                    initScrollReveal();
                } else if (data.success) {
                    projectsGrid.innerHTML = `<p class="no-projects">No projects yet. Check back soon!</p>`;
                } else {
                    projectsGrid.innerHTML = `<p class="no-projects">Could not load projects.</p>`;
                }
            })
            .catch(() => {
                projectsGrid.innerHTML = `<p class="no-projects">⚠️ Failed to connect to the server.</p>`;
            });
    }

    loadProjects();

    const contactForm = document.getElementById('contact-form');
    const formStatus = document.getElementById('form-status');

    if (contactForm) {
        contactForm.addEventListener('submit', e => {
            e.preventDefault();
            if (!validateForm()) return;
            const submitBtn = contactForm.querySelector('#submit-btn');
            submitBtn.classList.add('loading');
            const payload = {
                name: contactForm.querySelector('#contact-name').value.trim(),
                email: contactForm.querySelector('#contact-email').value.trim(),
                message: contactForm.querySelector('#contact-message').value.trim(),
            };
            fetch('backend/api_contact.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload),
            })
            .then(res => res.json())
            .then(data => {
                showStatus(data.success ? 'success' : 'error', data.message);
                if (data.success) contactForm.reset();
            })
            .catch(() => showStatus('error', 'Network error. Please try again.'))
            .finally(() => submitBtn.classList.remove('loading'));
        });

        contactForm.querySelectorAll('.form-input, .form-textarea').forEach(field => {
            field.addEventListener('input', () => clearFieldError(field));
        });
    }

    function validateForm() {
        let valid = true;
        const nameField = document.getElementById('contact-name');
        const emailField = document.getElementById('contact-email');
        const messageField = document.getElementById('contact-message');
        if (!nameField.value.trim()) {
            setFieldError(nameField, 'Name is required.'); valid = false;
        }
        if (!emailField.value.trim()) {
            setFieldError(emailField, 'Email is required.'); valid = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailField.value.trim())) {
            setFieldError(emailField, 'Please enter a valid email.'); valid = false;
        }
        if (!messageField.value.trim() || messageField.value.trim().length < 10) {
            setFieldError(messageField, 'Message must be at least 10 characters.'); valid = false;
        }
        return valid;
    }

    function setFieldError(field, msg) {
        field.classList.add('error');
        const err = field.parentElement.querySelector('.field-error');
        if (err) { err.textContent = msg; err.classList.add('visible'); }
    }

    function clearFieldError(field) {
        field.classList.remove('error');
        const err = field.parentElement.querySelector('.field-error');
        if (err) err.classList.remove('visible');
        if (formStatus) formStatus.classList.remove('show', 'success', 'error');
    }

    function showStatus(type, msg) {
        if (!formStatus) return;
        formStatus.textContent = (type === 'success' ? '✅ ' : '❌ ') + msg;
        formStatus.className = `form-status show ${type}`;
        formStatus.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function initScrollReveal() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    }

    initScrollReveal();

    const typedEl = document.getElementById('typed-text');
    const words = ['Backend .NET Developer', 'Former Unity Developer', 'Frontend Specialist'];
    let wIdx = 0, cIdx = 0, deleting = false;

    function typeLoop() {
        if (!typedEl) return;
        const word = words[wIdx];
        if (!deleting) {
            typedEl.textContent = word.substring(0, ++cIdx);
            if (cIdx === word.length) { deleting = true; setTimeout(typeLoop, 1800); return; }
        } else {
            typedEl.textContent = word.substring(0, --cIdx);
            if (cIdx === 0) { deleting = false; wIdx = (wIdx + 1) % words.length; }
        }
        setTimeout(typeLoop, deleting ? 60 : 100);
    }

    typeLoop();

    const yearEl = document.getElementById('year');
    if (yearEl) yearEl.textContent = new Date().getFullYear();

    function escapeHTML(str) {
        if (!str) return '';
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

});
