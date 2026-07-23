# Office Inventory Request System

Aplikasi web pengelolaan permintaan (peminjaman) barang inventaris kantor dengan dua peran: **Admin** dan **Employee**.

## Teknologi
- Laravel 13
- MySQL
- Blade + Tailwind CSS (via CDN)
- Alpine.js (modal konfirmasi & toast)

## Fitur

### Admin
- Dashboard (statistik: total barang, total request, pending, approved hari ini)
- Kelola Barang (tambah, edit, hapus, cari, filter kategori)
- Kelola Request: **Approve** (stok berkurang) / **Reject**
- Konfirmasi **Pengembalian** barang (stok bertambah kembali)
- Kelola Users
- Riwayat request
- Profile

### Employee
- Registrasi mandiri (role otomatis `employee`)
- Dashboard (statistik request pribadi)
- Daftar Barang
- Buat Request (pinjam barang)
- Ajukan **Pengembalian** barang yang sudah disetujui
- Riwayat request pribadi
- Profile

## Alur Request & Pengembalian
1. Employee membuat request → status **Pending**
2. Admin **Approve** → stok berkurang → status **Approved** (atau **Reject** → **Rejected**)
3. Employee klik **Kembalikan** → status **Menunggu Retur**
4. Admin **Konfirmasi Retur** → stok bertambah kembali → status **Dikembalikan**

## Instalasi

```bash
# 1. Install dependency
composer install

# 2. Salin file environment & generate app key
cp .env.example .env
php artisan key:generate

# 3. Sesuaikan konfigurasi database di .env
#    DB_DATABASE=office_inventory
#    DB_USERNAME=root
#    DB_PASSWORD=

# 4. Buat database (MySQL), lalu jalankan migrasi + seeder
php artisan migrate:fresh --seed

# 5. Jalankan aplikasi
php artisan serve
```

Buka `http://127.0.0.1:8000`.

## Akun Login

Seeder hanya membuat **satu akun Admin**. Akun Employee dibuat sendiri melalui halaman **Register**.

| Peran | Email               | Password   |
|-------|---------------------|------------|
| Admin | admin@example.com   | `password` |

> Untuk masuk sebagai Employee, daftar terlebih dahulu di halaman **Register** (`/register`).

## Struktur Database

### users
`id`, `name`, `email`, `password`, `role` (admin/employee)

### items
`id`, `name`, `category`, `stock`, `minimum_stock`, `location`

### requests
`id`, `user_id`, `item_id`, `quantity`, `purpose`, `status`
(pending/approved/rejected/return_requested/returned), `approved_by`, `approved_at`,
`return_requested_at`, `returned_at`, `returned_by`
