# 📘 CBT - Computer-Based Test

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![Platform](https://img.shields.io/badge/platform-PC%20%26%20Mobile-green.svg)
![Version](https://img.shields.io/badge/version-1.0.0-brightgreen.svg)

### Deskripsi Singkat
Aplikasi **CBT** (Computer-Based Test) dikembangkan untuk memudahkan pelaksanaan ujian berbasis komputer di lingkungan pendidikan, khususnya untuk Sekolah Menengah Kejuruan (SMK). Dengan menghadirkan fitur keamanan yang lebih baik dibandingkan aplikasi e-learning biasa, aplikasi ini mencegah siswa mengakses tab lain saat ujian berlangsung dan memastikan validitas hasil ujian. Berbeda dengan *Exambrowser* yang memerlukan konfigurasi rumit, aplikasi ini hadir dengan antarmuka yang mudah digunakan dan kompatibilitas lintas platform (PC & Mobile).

> Solusi CBT untuk ujian yang lebih aman, efisien, dan terjangkau.

---

## ✨ Fitur Utama
- **Keamanan Ujian**: Mencegah kecurangan dengan fitur kontrol akses.
- **Kompatibilitas**: Dapat diakses dari perangkat mobile maupun PC.
- **Antarmuka Intuitif**: Mudah digunakan oleh guru dan siswa.
- **Laporan Detail**: Rekapitulasi hasil ujian dan analisis.

---

## 📋 Spesifikasi Aplikasi

### 👨‍🏫 Admin
- **Login**: Mengamankan akses admin ke aplikasi.
- **Master Data**:
  - **Data Peserta**: Mengelola data siswa.
  - **Data Soal**: Membuat, mengedit, dan mengimpor soal.
  - **Data Token Ujian**: Menyediakan akses ujian dengan token.
  - **Data Ujian**: Mengatur jadwal dan pelaksanaan ujian.
- **Laporan**:
  - Laporan Data Peserta.
  - Laporan Hasil Ujian.
  - Export Data Soal.
- **Pengaturan**:
  - Informasi Sekolah (Logo, Nama Sekolah, dll).
  - Jurusan, Kelas, dan Guru.

### 👨‍🏫 Guru
- **Login**: Akses ke fitur khusus guru.
- **Master Data**:
  - Mengelola Data Peserta.
  - Membuat dan Mengelola Soal.
  - Data Token Ujian.
  - Data Ujian.
- **Laporan**:
  - Laporan Peserta dan Hasil Ujian.
  - Export Soal.

### 👨‍🎓 Peserta
- **Ujian**: Mengikuti ujian dengan akses token yang diberikan.

---

## 🛠️ Cara Instalasi

1. **Clone Repository**: 
    ```bash
    git clone https://github.com/andretantri/cbt.git
    ```
2. **Masuk ke Direktori Proyek**:
    ```bash
    cd cbt
    ```
3. **Install Dependencies**:
    ```bash
    php artisan serve
    ```
4. **Jalankan Aplikasi**:
    ```bash
    localhost:8000
    ```

---

> **Catatan**: Aplikasi ini masih dalam tahap pengembangan dan akan terus diperbarui untuk menambahkan fitur-fitur baru.
