# RING NETWORK - Website Perusahaan Telekomunikasi & Admin Panel

Website resmi perusahaan telekomunikasi **Ring Network** yang modern, responsif, dan dinamis, dibangun dengan nuansa warna **Biru Muda (Sky/Cyan)**, **Oren**, dan **Kuning**, dilengkapi dengan integrasi logo resmi Ring Network (*Connect • Secure • Empower*).

---

## 🚀 Akses Cepat

- **Website Publik**: [http://localhost/website_ringnet/](http://localhost/website_ringnet/)
- **Panel Pengelola / Admin**: [http://localhost/website_ringnet/admin/](http://localhost/website_ringnet/admin/)
  - **Username**: `admin`
  - **Password**: `admin123`

---

## 🌟 Fitur Utama Website

### 1. Desain & Visual Modern
- Palet warna: **Biru Muda / Electric Sky**, **Vibrant Orange**, dan **Golden Yellow**.
- Menggunakan logo resmi Ring Network (`assets/images/logo.png` & `assets/images/logo.jpg`).
- Gaya *Glassmorphism*, cyber grid glow, floating card effects, dan responsive mobile drawer navigation.

### 2. Bidang Usaha & Layanan Terintegrasi
1. **Penjualan Internet (ISP)**: Internet Broadband & Dedicated 100% Fiber Optic simetris 1:1, bebas FUP.
2. **Pemasangan Jaringan Internet**: Penarikan kabel LAN/FO, splicing core fiber optic, router Mikrotik & UniFi Mesh.
3. **Pemasangan CCTV & Smart AI**: IP Camera 4K ColorVu (malam berwarna), deteksi gerak AI, live view via smartphone 24 jam.
4. **Setup & Maintenance Server**: Instalasi rak server, virtualisasi Proxmox VE / VMware ESXi, backup otomatis, dan kontrak maintenance.

### 3. Paket Layanan Utama Internet (Home & Residential)
- **Kategori Home**:
  - *Ring Home Starter* (50 Mbps) - Rp 150.000 /bulan - FUP: Unlimited (100% Bebas FUP)
  - *Ring Home Family* (75 Mbps) - Rp 175.000 /bulan - FUP: Unlimited (100% Bebas FUP) - *Terpopuler*
  - *Ring Home Ultra* (100 Mbps) - Rp 200.000 /bulan - FUP: Unlimited (100% Bebas FUP)
  - *Ring Home Sultan* (200 Mbps) - Rp 325.000 /bulan - FUP: Unlimited (100% Bebas FUP) - *Sultan Priority*
- **Kategori Residential** (Cluster / Komplek Perumahan / Villa):
  - *Ring Resident Silver* (50 Mbps) - Rp 500.000 /bulan - FUP: Dedicated Rasio 1:1 Tanpa FUP
  - *Ring Resident Gold* (100 Mbps) - Rp 1.000.000 /bulan - FUP: Dedicated Rasio 1:1 Tanpa FUP - *Paling Laris*
  - *Ring Resident Platinum* (200 Mbps) - Rp 2.000.000 /bulan - FUP: Dedicated Rasio 1:1 Tanpa FUP
  - *Ring Resident Fiber Max* (300 Mbps) - Rp 3.000.000 /bulan - FUP: Dedicated Rasio 1:1 Tanpa FUP
- Dilengkapi **Kalkulator Kebutuhan Kecepatan** interaktif (Smart Speed Estimator) dan **Cek Area Jangkauan Fiber**.

---

## 🛠️ Fitur Panel Admin / Pengelola

Akses: `http://localhost/website_ringnet/admin/`

1. **Kelola Dropdown Taskbar (`menus.php`)**:
   - Memungkinkan admin menambah, mengedit, mengurutkan, dan menghapus item dropdown pada navbar taskbar secara mandiri.
   - Setiap penambahan menu baru langsung muncul secara otomatis di dropdown **"Layanan"** taskbar website utama.
   - Pengaturan: Judul Menu, URL Tujuan (Anchor / Page), Ikon FontAwesome, Deskripsi Singkat, Badge (Promo/Hot/Pro), dan Status Aktif.

2. **Kelola Paket Internet (`packages.php`)**:
   - Menambah & mengubah paket internet untuk kategori **Home** dan **Residential**.
   - Kolom **Kecepatan (Speed)** dan **Kebijakan FUP** dapat didefinisikan secara bebas sesuai kebutuhan perusahaan.
   - Pengaturan harga, siklus tagihan, benefit poin per baris, dan penanda kartu populer (Card Glow).

3. **Kelola Layanan Usaha (`services.php`)**:
   - Mengatur layanan utama perusahaan dengan opsi otomatis: *"Tampilkan otomatis di dropdown Layanan taskbar"*.

4. **Pesanan & Survey Masuk (`inquiries.php`)**:
   - Menampung seluruh data pemesanan atau permintaan pasang baru dari formulir website.
   - Dilengkapi tombol 1-klik untuk langsung membalas pelanggan via **WhatsApp**.
   - Pelacakan status: *Baru*, *Dihubungi*, *Survey*, dan *Selesai*.

5. **Cek Jangkauan Area (`coverage.php`)**:
   - Menambah, mengubah, dan mengelola wilayah/perumahan yang terjangkau tiang ODP Fiber Optic.
   - Status dapat diset: *Tersedia (Ready ODP)*, *Perluasan (Tahap Pengerjaan)*, atau *Penuh*.
   - Terintegrasi langsung dengan modal popup "Cek Area Jangkauan" pada website utama.

6. **Pengaturan Website (`settings.php`)**:
   - Ganti nomor WhatsApp gateway, nomor telepon hotline NOC, email, alamat kantor, dan ganti kata sandi admin.

---

## 📁 Struktur Direktori

```
website_ringnet/
├── admin/                     # Modul Admin Panel
│   ├── includes/              # Header & footer admin
│   ├── auth_check.php         # Proteksi sesi login
│   ├── index.php              # Dashboard overview
│   ├── inquiries.php          # Manajemen pesanan masuk
│   ├── login.php              # Halaman login modern
│   ├── logout.php             # Logout session
│   ├── menus.php              # Dropdown Taskbar Builder
│   ├── packages.php           # Manajemen Paket Home & Residential (Speed & FUP)
│   ├── services.php           # Manajemen Layanan & Integrasi Taskbar
│   └── settings.php           # Pengaturan profil & kata sandi
├── api/
│   └── submit_inquiry.php     # API pemrosesan formulir pesanan & WhatsApp redirect
├── assets/
│   ├── css/style.css          # Styling kustom modern & tema warna
│   ├── js/main.js             # Skrip interaktif (kalkulator speed, tab switcher, modal)
│   └── images/                # Logo resmi Ring Network (JPG & PNG transparan)
├── config/
│   ├── db.php                 # Koneksi PDO SQLite & migrasi otomatis
│   └── helper.php             # Fungsi pembantu, formatting, & session
├── data/
│   └── ringnet.sqlite         # Database mandiri bawaan (Plug & Play)
├── includes/
│   ├── header.php             # Taskbar sticky glass dengan dynamic dropdown
│   ├── footer.php             # Footer modern & tombol WhatsApp floating
│   └── modal-order.php        # Modal booking survey & cek area
├── index.php                  # Halaman utama Ring Network
└── README.md                  # Dokumentasi proyek
```

---

*Dikembangkan untuk Ring Network — Connect • Secure • Empower.*
