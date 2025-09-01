# 📚 SISTEM INFORMASI PERPUSTAKAAN

> Sistem Informasi Perpustakaan berbasis CodeIgniter 4

---

## 📋 Daftar Isi

1. [Overview](#-overview)
2. [Teknologi](#-teknologi-yang-digunakan)
3. [Instalasi](#-instalasi)
4. [API Endpoints](#-api-endpoints)
5. [User Roles](#-user-roles)
6. [Fitur Utama](#-fitur-utama)
7. [Fitur Detail](#-fitur-detail)
8. [Troubleshooting](#-troubleshooting)
9. [Development](#-development-guide)
10. [Deployment](#-deployment)
11. [Maintenance](#-maintenance)

---

## 🎯 Overview

**Perpus Berbudi** adalah sistem informasi perpustakaan berbasis web yang dikembangkan menggunakan CodeIgniter 4.
Sistem ini dirancang untuk mempermudah pengelolaan operasional perpustakaan secara digital, mulai dari manajemen buku, anggota, peminjaman, hingga absensi pengunjung.

### Target Pengguna
- **Pustakawan/Librarian**: Mengelola data buku, anggota, transaksi peminjaman, pengembalian, serta absensi pengunjung.

### Keunggulan
- Interface yang user-friendly dan responsif
- Sistem keamanan berlapis
- Laporan dan analitik yang komprehensif

---

## 🛠️ Teknologi yang Digunakan

### Backend
- **Framework**: CodeIgniter 4.x
- **Language**: PHP 7.4+
- **Database**: MySQL 5.7+ / MariaDB
- **Web Server**: Apache 2.4+ (XAMPP)

### Frontend
- **CSS Framework**: Bootstrap 5.x
- **JavaScript**: Vanilla JS + jQuery 3.x
- **Icons**: Font Awesome 6.x / Lucide Icons
- **Charts**: Chart.js / ApexCharts
- **DataTables**: Advanced table management

### Tools & Libraries
- **Email**: CodeIgniter Email Library
- **Validation**: CodeIgniter Validation
- **Security**: CodeIgniter Security & Encryption

---

## 🚀 Instalasi

### Prerequisites
- XAMPP (Apache + MySQL + PHP 7.4+)
- Web browser modern (Chrome, Firefox, Edge)
- Minimal 512MB RAM
- 1GB disk space

### Instalasi 
```bash
sebelum instalasi, pastikan XAMPP sudah terinstall dengan baik sesuai dengan perangkat yang digunakan
# 1. Clone/Download project
# - lakukan "git clone https://github.com/YoriCode11/perpus-berbudi.git" jika mengunakan terminal git
# - Atau dapat dilakukan dengan cara mendownload project dalam bentuk zip, jika download sudah selesai silahkan ekstrak file project sistem perpustakaan

# 2. Pindah ke htdocs XAMPP
# - mv perpus-berbudi C:\xampp\htdocs\  (jika menggunakan git)
# - Atau jika sebelumnya pada langkah 1 memilih melakukan download dalam bentuk zip, maka pindahkan file project ke direktori C:\xampp\htdocs

# 3. Setup database
# - Buka file project yang sudah diekstrak tersebut dan ekstrak file dump.zip ( file sql)
# - Jalankan XAMPP kemudian klik "start" Apache dan MySQL
# - Buka phpMyAdmin lewat browser dengan link : http://localhost/phpmyadmin/index.php atau dapat dilakukan dengan klik "admin pada panel XAMPP
# - Buat database 'perpusdb' atau bisa di sesuaikan dengan kebutuhan
# - Import file SQL via phpMyAdmin dan pastikan bagian "check foreignkey" di non-aktifkan

# 4. Konfigurasi environment
cp env .env
# Edit .env sesuai kebutuhan

# 5.Akses `http://localhost/perpus-smk/'

```

## ⚙️ Konfigurasi

### Environment Variables (.env)
```env
# Basic Configuration
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost/perpus-smk/'
app.indexPage = ''

# Database
database.default.hostname = localhost
database.default.database = perpusdb
database.default.username = root
database.default.password = 

# Security
encryption.key = [generate dengan php spark key:generate]

# Custom Settings
perpus.maxBooksPerMember = 3
perpus.loanDurationDays = 14
perpus.finePerDay = 1000
```

## 🔗 API Endpoints

### Authentication
```
POST /auth/login          # User login
POST /auth/logout         # User logout
POST /auth/register       # Member registration
```

### Books Management
```
GET    /books             # List all books
POST   /books             # Add new book
PUT    /books/{id}        # Update book
DELETE /books/{id}        # Delete book
GET    /books/search      # Search books
```

### Members Management
```
GET    /members           # List all members
POST   /members           # Add new member
PUT    /members/{id}      # Update member
DELETE /members/{id}      # Delete member
```

### Loans Management
```
GET    /loans            # List all loans
POST   /loans/checkout   # Checkout book
POST   /loans/return     # Return book
POST   /loans/renew      # Renew loan
GET    /loans/overdue    # Get overdue loans
```

## ✨ Fitur Utama

### 📖 Manajemen Buku
- **CRUD Buku**: Tambah, edit dan hapus data buku
- **Kategorisasi**: Organisasi buku berdasarkan kategori dan genre
- **ISBN Management**: Validasi dan tracking ISBN
- **Stock Management**: Kelola jumlah buku
  
---

<img width="800" alt="Screenshot 2025-08-31 214605" src="https://github.com/user-attachments/assets/c5f5a8a1-1452-465f-9aaa-81735275c912" />

---

<img width="800" alt="Screenshot 2025-08-31 215853" src="https://github.com/user-attachments/assets/ed2b0c69-47f2-4f88-a48a-b7155fc6fd0f" />

---

### 👥 Manajemen Anggota
- **Registrasi Anggota**: Pendaftaran anggota baru
- **Status Keanggotaan**: Monitoring status aktif/non-aktifn

---

<img width="800" alt="Screenshot 2025-09-01 014015" src="https://github.com/user-attachments/assets/044c45d0-4fc9-4678-827b-c2cdb7547ef2" />

---

### 🔄 Sistem Peminjaman
- **Checkout Books**: Proses peminjaman buku
- **Return Books**: Proses pengembalian buku

---

<img width="800" alt="Screenshot 2025-09-01 011726" src="https://github.com/user-attachments/assets/e07dae38-fd07-49c7-8570-146604ef7ef0" />

---

<img width="800" alt="Screenshot 2025-09-01 012320" src="https://github.com/user-attachments/assets/681127ea-556f-46c3-ba33-6c44b32618e6" />

---

### 👥 Sistem Absensi
- **Pencatatan Absensi**:Kehadiran pengunjung
- **Tracking Kehadiran**: Monitoring anggota yang berkunjung

---

<img width="800" alt="Screenshot 2025-09-01 013648" src="https://github.com/user-attachments/assets/a2bb2607-35eb-424d-be05-e3fd4e247f7e" />

---

### 📊 Pelaporan & Analytics
- **Dashboard Analytics**: Overview statistik perpustakaan
- **Transaction Reports**: Laporan transaksi (peminjaman dan absensi pengunjung)
- **Member Statistics**: Statistik aktivitas anggota

---

## 👤 User Roles

### 📚 Librarian/Pustakawan
**Fokus pada Operasional Perpustakaan**

**Permissions:**
- Manajemen buku dan kategori
- Proses peminjaman dan pengembalian
- Manajemen anggota
- Manajemen Absensi pengunjung

---

## 🎨 Fitur Detail

### Dashboard Analytics
- **Real-time Statistics**: Jumlah buku, anggota, peminjaman aktif
- **Quick Actions**: Shortcut untuk aksi cepat
- **Recent Activities**: Log aktivitas terbaru

### Advanced Search
- **Multi-criteria Search**: Pencarian berdasarkan judul, penulis, ISBN
- **Filter Options**: Filter berdasarkan kategori, tahun, availability
- **Sort Options**: Sorting berdasarkan berbagai parameter
- **Search History**: Riwayat pencarian user

---

## 🔧 Troubleshooting

### Common Issues

#### 1. "Page Not Found" Error
**Symptoms:** Error 404 saat akses aplikasi
**Causes:**
- .htaccess tidak ada atau salah konfigurasi
- mod_rewrite tidak aktif di Apache
- Folder struktur tidak sesuai

**Solutions:**
```bash
# Check .htaccess files
# Pastikan ada di root dan public/ folder

# Enable mod_rewrite di httpd.conf
LoadModule rewrite_module modules/mod_rewrite.so

# Restart Apache
```

#### 2. Database Connection Error
**Symptoms:** "Unable to connect to database"
**Causes:**
- MySQL service tidak jalan
- Database belum dibuat
- Kredensial database salah

**Solutions:**
```sql
-- Start MySQL di XAMPP Control Panel
-- Buat database:
CREATE DATABASE perpusdb;

-- Check credentials di .env file
```

#### 3. Blank White Page
**Symptoms:** Halaman kosong tanpa error
**Causes:**
- PHP fatal error
- Permission issue pada folder writable/
- Memory limit insufficient

**Solutions:**
```php
// Enable error display di .env
CI_ENVIRONMENT = development

// Check error log
tail -f writable/logs/log-*.php

// Fix permissions
chmod 755 writable/ -R
```

#### 4. CSS/JS Not Loading
**Symptoms:** Layout berantakan, JavaScript tidak bekerja
**Causes:**
- Base URL salah
- Asset path tidak tepat
- .htaccess blocking static files

**Solutions:**
```php
// Check baseURL di .env
app.baseURL = 'http://localhost/perpus-berbudi/'

// Check asset paths di view files
echo base_url('assets/css/style.css');
```

---

## 💻 Development Guide

### Coding Standards
- **PSR-12**: PHP coding standard
- **Camel Case**: Untuk method dan variable names
- **Pascal Case**: Untuk class names
- **Snake Case**: Untuk database columns
- **Kebab Case**: Untuk CSS classes

### Git Workflow
```bash
# Feature development
git checkout -b feature/new-feature
git add .
git commit -m "feat: add new feature"
git push origin feature/new-feature

# Bug fixes
git checkout -b fix/bug-description
git commit -m "fix: resolve specific issue"

# Release
git checkout main
git merge --no-ff feature/new-feature
git tag v1.0.0
```

## 🚀 Deployment

### Production Checklist
- [ ] Set `CI_ENVIRONMENT = production` di .env
- [ ] Generate strong encryption key
- [ ] Update database credentials
- [ ] Enable HTTPS (forceGlobalSecureRequests = true)
- [ ] Setup proper file permissions
- [ ] Configure backup schedule
- [ ] Setup monitoring dan logging
- [ ] Test all functionality
- [ ] Setup SSL certificate
- [ ] Configure firewall rules

### Server Requirements
```
PHP: 7.4+ (Recommended: 8.1+)
MySQL: 5.7+ or MariaDB 10.3+
Apache: 2.4+ with mod_rewrite
Memory: 512MB minimum (1GB recommended)
Storage: 5GB minimum
```

### Performance Optimization
```php
// Enable caching
cache.handler = 'file'
cache.ttl = 3600

// Database optimization
// Add indexes for frequent queries
ALTER TABLE books ADD INDEX idx_title (title);
ALTER TABLE loans ADD INDEX idx_member_status (member_id, status);

// Enable compression
// Add to .htaccess
AddOutputFilterByType DEFLATE text/html text/css text/js
```

---

## 🔧 Maintenance

### Regular Tasks
- **Daily**: Check error logs, monitor disk space
- **Weekly**: Database backup, update security patches
- **Monthly**: Performance review, user cleanup
- **Quarterly**: Full system audit, dependency updates

### Backup Strategy
```bash
# Database backup
mysqldump -u root -p perpus_berbudi > backup_$(date +%Y%m%d).sql

# File backup
tar -czf backup_files_$(date +%Y%m%d).tar.gz /path/to/project

# Automated backup script
# Setup cron job untuk backup otomatis
```

### Monitoring
- **Error Logs**: writable/logs/
- **Access Logs**: Apache access.log
- **Performance**: Response time monitoring
- **Security**: Failed login attempts
- **Database**: Query performance, table sizes

---

## 📞 Support & Contact

### Technical Support
- **Developer**: YoriCode11
- **GitHub**: https://github.com/YoriCode11/perpus-berbudi
  
---

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## 🙏 Acknowledgments

- **CodeIgniter Team** untuk framework yang luar biasa
- **Bootstrap Team** untuk CSS framework
- **XAMPP Team** untuk development environment
- **Community Contributors** yang telah membantu pengembangan

---

*Last updated: September 2025*
*Version: 1.0.0*
