# 🚀 K3 Web Management System

> Modern Web Management System built with PHP Native, structured for scalability, collaboration, and real-world deployment.

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.x-blue?logo=php">
  <img src="https://img.shields.io/badge/Composer-Dependency_Manager-brown?logo=composer">
  <img src="https://img.shields.io/badge/Status-Active-success">
  <img src="https://img.shields.io/badge/Maintained-Yes-brightgreen">
  <img src="https://img.shields.io/badge/License-MIT-lightgrey">
</p>


------------------------------------------------------------------------

## 📌 Overview

K3 Web Management System adalah aplikasi berbasis web untuk mengelola
data akademik seperti admin, dosen, dan mahasiswa.

Dirancang menggunakan pendekatan modular untuk memudahkan: -
Maintenance - Scalability - Team collaboration

------------------------------------------------------------------------

## ✨ Features

-   🔐 Authentication System (Login & Logout)
-   👨‍💼 Admin Management
-   👨‍🏫 Dosen Management
-   🎓 Mahasiswa Management
-   📂 Modular File Structure
-   📧 Email Integration (PHPMailer)

------------------------------------------------------------------------

## 🧠 Tech Stack

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-Dependency_Manager-885630?logo=composer&logoColor=white)
![PHPMailer](https://img.shields.io/badge/PHPMailer-Email-6C3483)
![XAMPP](https://img.shields.io/badge/XAMPP-Server-FB7A24?logo=apache&logoColor=white)
![Laragon](https://img.shields.io/badge/Laragon-Server-0E83CD)
![Git](https://img.shields.io/badge/Git-Version_Control-F05032?logo=git&logoColor=white)
![GitHub](https://img.shields.io/badge/GitHub-Repository-181717?logo=github&logoColor=white)

------------------------------------------------------------------------

## 📸 Preview

## 📸 Dashboard Preview

<p align="center"><b>👨‍💼 Admin</b></p>
<p align="center">
  <img src="assets/img/dashboardadmin.png" width="80%">
</p>

<p align="center"><b>👨‍🏫 Dosen</b></p>
<p align="center">
  <img src="assets/img/dashboarddosen.png" width="80%">
</p>

<p align="center"><b>🎓 Mahasiswa</b></p>
<p align="center">
  <img src="assets/img/dashboardmhs.png" width="80%">
</p>

### 🔐 Login Page
<p align="center">
  <img src="assets/img/login.png" width="80%">
</p>

------------------------------------------------------------------------

## 🏗️ Project Structure

    kel-3/
    ├── admin/
    ├── assets/
    ├── auth/
    ├── config/
    ├── database/
    ├── dosen/
    ├── mahasiswa/
    ├── pages/
    ├── upload/
    ├── vendor/
    ├── .env
    ├── .gitignore
    ├── composer.json
    ├── composer.lock
    └── index.php

------------------------------------------------------------------------

## ⚙️ Installation

### 1. Clone Repository

    git clone https://github.com/Dani0601/kel-3.git
    cd kel-3

### 2. Install Dependencies

    composer install

### 3. Setup Environment

    cp .env.example .env

Edit file `.env`:

    MAIL_USERNAME=your_email
    MAIL_PASSWORD=your_password

### 4. Run Application

    http://localhost/kel-3

------------------------------------------------------------------------

## 🔒 Security Best Practices

-   Jangan commit `.env`
-   Jangan commit `/vendor`
-   Gunakan `.env` untuk kredensial
-   Gunakan `composer.lock` untuk konsistensi dependency

------------------------------------------------------------------------

## 🔁 Development Workflow

    git pull
    composer install

Update dependency:

    composer update
    git commit -m "Update dependencies"

------------------------------------------------------------------------

## ⚠️ Troubleshooting

### Composer not recognized

    composer -V

### Vendor missing

    composer install

### Email not working

-   Cek `.env`
-   Gunakan App Password Gmail

------------------------------------------------------------------------

## 📈 Future Improvements

-   Migrasi ke Laravel
-   REST API Implementation
-   UI/UX Enhancement
-   Role-based access control

------------------------------------------------------------------------

## 👨‍💻 Team

- **Dani Hidayat** — Developer  
  🔗 https://github.com/Dani0601  

- **Naula Alfiyatul Fauziyyah** — Developer  
  🔗 https://github.com/naulla  

- **Alfiah Lutfi Sabilah** — Developer  
  🔗 https://github.com/alfiahlutfi  

---

## 🤝 Contributors

<p align="center">
  <a href="https://github.com/Dani0601/kel-3/graphs/contributors">
    <img src="https://contrib.rocks/image?repo=Dani0601/kel-3" />
  </a>
</p>

---

## 📊 Contributor Stats

<p align="center">
  <img src="https://img.shields.io/github/contributors/Dani0601/kel-3?color=blue">
  <img src="https://img.shields.io/github/commit-activity/m/Dani0601/kel-3">
  <img src="https://img.shields.io/github/last-commit/Dani0601/kel-3">
</p>


------------------------------------------------------------------------

## ⭐ Portfolio Highlights

Project ini menunjukkan: - Dependency management dengan Composer -
Environment configuration (.env) - Modular architecture - Git
collaboration workflow

------------------------------------------------------------------------

## 📜 License

MIT License
