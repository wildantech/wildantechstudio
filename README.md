# WildanTech Studio

Website studio dan pengelolaan undangan digital berbasis Laravel, Blade, SQLite, dan Vite.

## Menjalankan lokal

```powershell
php artisan migrate
php artisan storage:link
npm run build
php artisan serve
```

Untuk memproses jadwal penghapusan otomatis selama pengembangan, jalankan di terminal kedua:

```powershell
php artisan schedule:work
```

## Retensi undangan

Undangan yang diterbitkan kedaluwarsa 30 hari sejak pertama kali diterbitkan. Halaman publik langsung berhenti tersedia setelah tanggal tersebut. Scheduler menjalankan `invitations:purge-expired` setiap hari pukul 02.00 untuk menghapus data undangan, tamu, RSVP, ucapan, dan foto sampulnya.

Di server produksi Linux, Laravel Scheduler memerlukan satu cron entry:

```cron
* * * * * cd /path/to/wildantechstudio && php artisan schedule:run >> /dev/null 2>&1
```

Perintah penghapusan dapat dijalankan manual dan aman diulang:

```powershell
php artisan invitations:purge-expired
```

## Pemeriksaan

```powershell
php artisan test --compact
npm run build
```
