# Dokumentasi Sistem Pengurusan Inventori (Inventory Management System)

Dokumen ini memberikan penerangan menyeluruh mengenai struktur kod, fungsi, dan alur kerja aplikasi Sistem Pengurusan Inventori ini yang dibina menggunakan rangka kerja **Laravel**.

## 1. Ringkasan Projek
Aplikasi ini adalah sistem untuk menguruskan inventori barang dan membenarkan pengguna untuk membuat tempahan (booking) barang. Ia mempunyai sistem kawalan akses berasaskan peranan (Role-Based Access Control) yang membezakan antara Pengguna Biasa, Staf, dan Pentadbir (Admin).

---

## 2. Struktur Pangkalan Data & Model (`app/Models`)

Aplikasi ini menggunakan model-model berikut untuk berinteraksi dengan pangkalan data:

### **User (`User.php`)**
- Mewakili pengguna sistem.
- **Atribut Utama**: `name`, `email`, `role`, `department_id`, `approved_at`.
- **Peranan (Role)**:
  - `user`: Pengguna biasa (boleh buat tempahan).
  - `staff`: Boleh mengurus inventori dan meluluskan tempahan.
  - `admin`: Akses penuh, termasuk pengurusan pengguna.
- **Logik Penting**: Pengguna baru mungkin memerlukan kelulusan (`approved_at`) sebelum boleh log masuk atau menggunakan sistem sepenuhnya.

### **Item (`Item.php`)**
- Mewakili barang dalam inventori.
- **Atribut Utama**: `name`, `quantity` (stok semasa), `category_id`, `supplier_id`.
- Stok akan ditolak secara automatik apabila tempahan diluluskan.

### **Booking (`Booking.php`)**
- Mewakili permohonan tempahan barang oleh pengguna.
- **Status**: `pending`, `approved`, `rejected`.
- **Relasi**:
  - `items()`: Senarai barang dalam tempahan ini (melalui `BookingItem`).
  - `user()`: Pemohon.
  - `approver()`: Staf/Admin yang meluluskan.

### **BookingItem (`BookingItem.php`)**
- Jadual pivot/detail untuk menyimpan barang spesifik dan kuantiti bagi setiap tempahan.

### **Lain-lain**
- **Category**, **Supplier**, **Department**: Jadual rujukan (master data) untuk mengkategorikan barang dan pengguna.

---

## 3. Alur Kerja Utama & Logik (`app/Http/Controllers`)

### **Authentication (`AuthController`)**
- Menguruskan Login, Register, dan Logout.
- Menggunakan *Middleware* untuk memastikan hanya pengguna yang sah boleh akses.

### **Pengurusan Tempahan (`BookingController`)**
1.  **Permohonan (User)**:
    - Pengguna memilih barang dan kuantiti.
    - Sistem mencipta rekod `Booking` dengan status `pending`.
2.  **Kelulusan (Staff/Admin)**:
    - Admin menyemak senarai tempahan.
    - Apabila butang **Approve** ditekan:
        - Sistem menyemak baki stok (`Item->quantity`).
        - Jika stok mencukupi, stok ditolak (`decrement`).
        - Status tempahan ditukar kepada `approved`.
    - Jika **Reject**: Status ditukar kepada `rejected` dan stok tidak disentuh.

### **Pengurusan Inventori (`ItemController`)**
- CRUD (Create, Read, Update, Delete) untuk barang.
- Hanya boleh diakses oleh **Admin** dan **Staff**.

### **Laporan (`InventoryReportController`)**
- Menjana laporan inventori untuk pemantauan stok.
- Mempunyai fungsi eksport ke PDF.

### **Pengurusan Pengguna (`Admin\UserController`)**
- Khusus untuk **Admin**.
- Membolehkan admin meluluskan pendaftaran pengguna baru (`approve`).

---

## 4. Laluan (Routes - `routes/web.php`)

Sistem menggunakan *Middleware* untuk mengawal akses ke laluan tertentu:

| Kumpulan Laluan | Akses | Fungsi |
| :--- | :--- | :--- |
| **Public** | Semua | Halaman utama (`/`), Login, Register |
| **Authenticated** | Semua User (Log Masuk) | Dashboard, Lihat & Buat Tempahan (`/bookings`) |
| **Staff & Admin** | `role:staff,admin` | Urus Barang (`/items`), Luluskan Tempahan, Master Data (Kategori, Pembekal), Laporan |
| **Admin Only** | `role:admin` | Urus Pengguna (`/admin/users`), Luluskan Pengguna |

---

## 5. Kesimpulan
Kod ini dibina dengan struktur MVC (Model-View-Controller) yang kemas. Logik perniagaan utama terletak pada `BookingController` (transaksi stok) dan pengasingan hak akses dilakukan melalui Middleware dan pengecekan peranan dalam Controller.
