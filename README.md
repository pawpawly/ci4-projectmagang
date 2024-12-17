# Project Magang - CodeIgniter 4

Proyek ini dikembangkan selama masa magang di **DISBUDPORAPAR bidang kebudayaan**. Website ini dibuat menggunakan **CodeIgniter 4** sebagai framework backend dan **Tailwind CSS** untuk desain antarmuka.

---

## 📋 Fitur Utama
- Menampilkan paginasi item dengan format seperti **"Showing 1 to 10 of 97 results"**.
- Desain antarmuka responsif menggunakan **Tailwind CSS**.
- Struktur kode bersih dan modular menggunakan **CodeIgniter 4**.

---

## 🚀 Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek secara lokal:

### Prasyarat
- **PHP** >= 7.4
- **Composer**
- **Web Server** (Apache/Nginx)

### Langkah Instalasi
1. **Clone repositori**:
   ```bash
   git clone https://github.com/pawpawly/ci4-projectmagang.git
   ```

2. **Masuk ke direktori proyek**:
   ```bash
   cd ci4-projectmagang
   ```

3. **Install dependencies** menggunakan Composer:
   ```bash
   composer install
   ```

4. **Update dependencies**:
   ```bash
   composer update
   ```

5. **Generate application key**:
   ```bash
   php spark key:generate
   ```

6. **Buat database baru**:
   ```bash
   php spark db:create museum_db
   ```

7. **Edit konfigurasi database** di file `.env`:
   ```plaintext
   #--------------------------------------------------------------------
   # DATABASE
   #--------------------------------------------------------------------
   database.default.hostname = localhost
   database.default.database = museum_db
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   database.default.port = 3306
   ```

8. **Jalankan migrasi database**:
   ```bash
   php spark migrate
   ```

9. **Tambahkan data awal dengan seeder**:
   ```bash
   php spark db:seed UserSeeder
   ```
   **Username**: `superadminn`  
   **Password**: `1`

10. **Sistem informasi siap digunakan**.
    
    Akses halaman login di:
    ```
    http://localhost:8080/login
    ```

---

## 📂 Struktur Direktori
Berikut adalah struktur utama proyek:

```
ci4-projectmagang/
├── app/                   # Direktori utama aplikasi
│   ├── Controllers/       # Controller utama
│   ├── Models/            # Model untuk database
│   ├── Views/             # Template dan view frontend
│   └── Config/            # Konfigurasi aplikasi
├── public/                # Aset publik (CSS, JS, dll)
├── writable/              # Direktori writable (cache, logs, dll)
├── .env                   # File konfigurasi environment
├── composer.json          # Dependencies composer
└── README.md              # Dokumentasi proyek
```

---

## 🎨 Teknologi yang Digunakan
- **Backend**: CodeIgniter 4
- **Frontend**: Tailwind CSS
- **Database**: MySQL
- **Tools**: Composer, Git

---

## 🛠 Pengembangan Selanjutnya
Berikut adalah beberapa fitur yang akan dikembangkan di masa mendatang:
- [ ] Fitur autentikasi pengguna (Login & Register)
- [ ] CRUD data kebudayaan
- [ ] Validasi form input
- [ ] Dokumentasi API (jika diperlukan)

---

## 👥 Tim Pengembang
| Nama                 | Role              | Sosial Media                                      |
|----------------------|-------------------|--------------------------------------------------|
| [Nama Anda]          | [Role Anda]       | [IG](#) | [Discord](#) | [GitHub](#)          |
| [Nama Rekan]         | [Role Rekan]      | [IG](#) | [Discord](#) | [GitHub](#)          |

---

## 📧 Kontak
Jika ada pertanyaan atau masukan terkait proyek ini, silakan hubungi:

- **Nama**: Yusuf Habib Wijoyo  
- **Email**: [Masukkan email Anda]  
- **GitHub**: [https://github.com/pawpawly](https://github.com/pawpawly)

---

## ⭐ Dukungan
Jika proyek ini membantu Anda, silakan berikan **Star** ⭐ di repositori ini. Terima kasih atas dukungan Anda!

---

**Lisensi**: Proyek ini dilisensikan di bawah [MIT License](LICENSE).
