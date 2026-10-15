# Procurement Monitoring Dashboard

**Laravel-based Web Application | Indonesia / English**

## Tentang Proyek

Procurement Monitoring Dashboard adalah aplikasi berbasis web yang dikembangkan dari awal sebagai bagian dari kegiatan Kerja Praktik (KP)/magang. Aplikasi ini dirancang untuk membantu pemantauan proses pengadaan melalui dashboard terpusat, mulai dari perencanaan pengadaan hingga monitoring kontrak, penerimaan barang, kelengkapan dokumen, dan penyerapan anggaran.

Aplikasi dikembangkan menggunakan Laravel, PHP, MySQL, Bootstrap, dan Font Awesome.

### Fitur Utama
1. Perencanaan Pengadaan

Memantau daftar proyek dan ID rencana pengajuan.

Melacak tanggal mulai, target penyelesaian, dan progres dokumen pengadaan.

2. Monitoring Kontrak Pengadaan

Memantau informasi kontrak dan nomor Purchase Order (PO).

Melacak status pelaksanaan, nilai kontrak, masa berlaku, dan frekuensi penagihan.

3. Monitoring Penerimaan Barang (Goods Receipt)

Memantau data penerimaan barang berdasarkan PO dan nomor Goods Receipt (GR).

Menampilkan nilai penerimaan dan deskripsi kondisi barang.

Menyediakan akses untuk melihat dokumen GR dalam format PDF.

Menampilkan grafik distribusi penagihan berdasarkan data GR yang tersimpan.

4. Pengelolaan Dokumen Administrasi

Mengunggah dokumen PDF yang berkaitan dengan proses pengadaan dan kontrak.

Mendukung dokumen administratif seperti TOR, RAB, SPH, BCR, SP2K, dan Perjanjian.

Menyediakan fitur preview dokumen PDF secara langsung melalui tombol akses pada tabel.

Menampilkan status apabila dokumen belum tersedia.

5. Penyerapan Anggaran dan Pelaporan

Memantau nilai kontrak, penyerapan anggaran berdasarkan Goods Receipt, dan sisa anggaran.

Menyajikan laporan bulanan.

Menampilkan grafik tren jumlah pengadaan per bulan untuk analisis tahunan.

6. Visualisasi Data Dinamis

Grafik distribusi penagihan dan tren pengadaan dihitung dari data yang tersimpan di MySQL melalui backend Laravel, sehingga visualisasi dapat mengikuti perubahan data pada database.

### Teknologi

- Laravel 12.1.1
- PHP 8.3
- MySQL
- Bootstrap
- Font Awesome

### Screenshot

*Screenshot aplikasi akan ditambahkan setelah dokumentasi visual disiapkan dan diperiksa agar tidak menampilkan informasi internal atau data sensitif.*

### Menjalankan Aplikasi

#### Persyaratan
- PHP 8.3
- Composer
- MySQL
- Node.js dan npm

#### Instalasi

1. Clone repositori:

   ```bash
   git clone <REPOSITORY_URL>
   cd <PROJECT_FOLDER>
   ```

2. Instal dependensi:

   ```bash
   composer install
   npm install
   ```

3. Siapkan file environment:

   ```bash
   cp .env.example .env
   ```

   Di Windows PowerShell, gunakan:

   ```powershell
   Copy-Item .env.example .env
   ```

4. Buat database MySQL bernama `DashboardDB_Icon`, lalu sesuaikan konfigurasi database pada `.env`.

5. Buat application key:

   ```bash
   php artisan key:generate
   ```

6. Siapkan skema database sesuai kebutuhan proyek. Jika migration sudah mencakup seluruh skema yang dibutuhkan:

   ```bash
   php artisan migrate
   ```

7. Bangun aset frontend:

   ```bash
   npm run build
   ```

8. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

   Buka alamat lokal yang ditampilkan pada terminal.

**Catatan instalasi:** Langkah di atas merupakan panduan awal. Kebutuhan data awal, file pendukung, konfigurasi tambahan, dan akun pengguna perlu diverifikasi sebelum instalasi dapat dianggap lengkap.

### Catatan Publikasi

Repositori ini ditujukan untuk dokumentasi portofolio pengembangan. Data aktual perusahaan, kredensial, dan informasi internal tidak disertakan. Publikasi source code dan materi pendukung tetap mengikuti izin serta ketentuan yang berlaku.

---

## About the Project

Procurement Monitoring Dashboard is a web-based application developed from scratch as part of an internship program. It is designed to support procurement process monitoring through a centralized dashboard, covering procurement planning, contract monitoring, goods receipt, administrative documentation, and budget absorption.

The application was developed using Laravel, PHP, MySQL, Bootstrap, and Font Awesome.

### Key Features
1. Procurement Planning

Monitor project lists and procurement plan identifiers.

Track start dates, target completion dates, and procurement document progress.

2. Procurement Contract Monitoring

Monitor contract information and Purchase Order (PO) numbers.

Track execution status, contract values, validity periods, and billing frequency.

3. Goods Receipt Monitoring

Monitor goods receipt records by PO and Goods Receipt (GR) number.

Display receipt values and descriptions of received goods.

Provide access to GR documents in PDF format.

Display billing distribution charts based on recorded GR data.

4. Administrative Document Management

Upload PDF documents associated with procurement and contracts.

Support administrative documents such as TOR, RAB, SPH, BCR, SP2K, and agreements.

Preview PDF documents directly through access buttons in data tables.

Display a status when a document is unavailable.

5. Budget Absorption and Reporting

Monitor contract values, budget absorption based on Goods Receipt records, and remaining budgets.

Present monthly reports.

Display monthly procurement volume trends for annual analysis.

6. Dynamic Data Visualization

Billing distribution and procurement trend charts are generated from data stored in MySQL through the Laravel backend, allowing visualizations to reflect database changes.

### Technology Stack

- Laravel 12.1.1
- PHP 8.3
- MySQL
- Bootstrap
- Font Awesome

### Screenshots

*Application screenshots will be added after visual documentation has been prepared and reviewed to prevent exposure of sensitive or internal information.*

### Running the Application

#### Requirements
- PHP 8.3
- Composer
- MySQL
- Node.js and npm

#### Installation

1. Clone the repository:

   ```bash
   git clone <REPOSITORY_URL>
   cd <PROJECT_FOLDER>
   ```

2. Install dependencies:

   ```bash
   composer install
   npm install
   ```

3. Create the environment file:

   ```bash
   cp .env.example .env
   ```

   On Windows PowerShell:

   ```powershell
   Copy-Item .env.example .env
   ```

4. Create a MySQL database named `DashboardDB_Icon` and configure the database connection in `.env`.

5. Generate the application key:

   ```bash
   php artisan key:generate
   ```

6. Prepare the database schema. If the migrations cover the required schema:

   ```bash
   php artisan migrate
   ```

7. Build frontend assets:

   ```bash
   npm run build
   ```

8. Start the application:

   ```bash
   php artisan serve
   ```

   Open the local address displayed in the terminal.

**Setup note:** These instructions are preliminary. Seed data, supporting files, additional configuration, and user account setup must be verified before the installation guide can be considered complete.

### Publication Note

This repository is intended to document the project as part of a development portfolio. Actual company data, credentials, and internal information are excluded. Publication of source code and supporting materials remains subject to applicable permissions and requirements.