# Ahmet Kocacan - Professional Portfolio

A dynamic, full-stack personal portfolio website designed to showcase my journey from Frontend and Unity Game Development to my current specialization in Backend .NET Architecture. This project demonstrates proficiency in both client-side interactions and secure server-side logic using PHP and MySQL.

---

## 🚀 Key Features

### Frontend (Client-Side)
- **Modern UI/UX:** Premium, glassmorphism-inspired design with a responsive CSS Grid & Flexbox layout.
- **Dynamic Theming:** Built-in Dark/Light mode toggle with `localStorage` preference saving.
- **Interactive Elements:** Smooth scroll reveals, dynamic typing animations, and a custom image slider.
- **AJAX Integration:** Asynchronous project loading and contact form submissions without page reloads.
- **Responsive Design:** Fully optimized for mobile, tablet, and desktop viewing.

### Backend (Server-Side)
- **Secure Admin Panel:** Protected dashboard to manage projects and view messages, utilizing PHP sessions and bcrypt password hashing.
- **RESTful APIs:** Custom PHP endpoints (`api_projects.php`, `api_contact.php`) that serve JSON data to the frontend.
- **Database Integration:** PDO (PHP Data Objects) implementation with prepared statements to prevent SQL injection attacks.
- **Server-Side Validation:** Robust validation and sanitization for contact form inputs.

---

## 🛠️ Technology Stack

- **Frontend:** HTML5, CSS3 (Vanilla), JavaScript (ES6+)
- **Backend:** PHP 8+
- **Database:** MySQL / MariaDB
- **Architecture:** Client-Server model with AJAX communication

---

## 📁 Project Structure

```text
Portfolio_Project/
├── index.php                 # Main public portfolio page
├── login.php                 # Secure login page for the admin panel
├── admin.php                 # Admin dashboard (protected)
├── database.sql              # Database schema and initial data dump
├── README.md                 # Project documentation
├── css/
│   └── style.css             # Main stylesheet (themes, layouts, animations)
├── js/
│   └── main.js               # Frontend logic (AJAX, slider, theme toggle)
├── backend/
│   ├── db.php                # PDO Database connection configuration
│   ├── api_projects.php      # API endpoint serving project data
│   └── api_contact.php       # API endpoint handling contact submissions
└── photos/
    └── profile.png           # Profile image asset
```

---

## ⚙️ Setup & Installation (Local Development)

To run this project locally, you will need a local web server environment like **XAMPP**, **WAMP**, or **Laragon**.

### 1. Database Setup
1. Open phpMyAdmin (`http://localhost/phpmyadmin`).
2. Create a new database named `portfolio_db` (Collation: `utf8mb4_general_ci`).
3. Import the `database.sql` file into this new database.

### 2. Configure Database Connection
1. Open `backend/db.php`.
2. Ensure the credentials match your local setup:
   ```php
   $host    = '127.0.0.1';
   $db      = 'portfolio_db';
   $user    = 'root';
   $pass    = ''; // Leave empty for default XAMPP
   ```

### 3. Run the Project
1. Place the entire `Portfolio_Project` folder inside your web server's root directory (`htdocs` for XAMPP, `www` for WAMP).
2. Open your browser and navigate to: `http://localhost/Portfolio_Project/`.

---

## ☁️ Deployment Notes (InfinityFree / Shared Hosting)

When deploying to a production server like InfinityFree:
1. Upload the contents of this folder directly into the `htdocs/` directory.
2. Delete any default `index2.html` files provided by the host.
3. Update `backend/db.php` with the production database credentials (Hostname, Username, Password, and strict DB Name).
4. Import `database.sql` using the host's phpMyAdmin. **Note:** You may need to remove `CREATE DATABASE` and `USE` statements from the top of the `.sql` file if your host restricts database creation via scripts.

---

## 🔐 Admin Credentials

A default administrator account is created when the database is imported.

- **URL:** `/login.php`
- **Username:** `admin`
- **Password:** `password`

*Note: For production environments, it is highly recommended to change this password immediately by generating a new bcrypt hash.*

---

## 👨‍💻 Author

**Ahmet Kocacan**
- **Role:** Backend .NET Developer
- **GitHub:** [ahmetKocacan](https://github.com/ahmetKocacan)
- **LinkedIn:** [Ahmet Kocacan](https://www.linkedin.com/in/ahmet-kocacan-0735462b4/)
