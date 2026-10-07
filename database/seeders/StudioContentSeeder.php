<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;

class StudioContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->services() as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }

        foreach ($this->projects() as $project) {
            Project::updateOrCreate(['slug' => $project['slug']], $project);
        }
    }

    private function services(): array
    {
        return [
            [
                'title' => 'Undangan digital',
                'slug' => 'undangan-digital',
                'summary' => 'Undangan web yang personal, mudah dibagikan, dan siap mengelola RSVP.',
                'description' => 'Halaman acara, tautan tamu personal, pengiriman satu per satu melalui WhatsApp, RSVP, dan ucapan dalam satu alur.',
                'category' => 'Produk WildanTech',
                'icon' => 'spark',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Aplikasi web dan dashboard',
                'slug' => 'aplikasi-web-dashboard',
                'summary' => 'Aplikasi operasional dan dashboard yang mengikuti alur kerja pengguna.',
                'description' => 'Pengembangan aplikasi administrasi, pencatatan, pelaporan, dan visualisasi data untuk kebutuhan yang terdefinisi.',
                'category' => 'Pengembangan',
                'icon' => 'code',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Prototipe IoT',
                'slug' => 'prototipe-iot',
                'summary' => 'Eksperimen perangkat sensor, mikrokontroler, dan pengiriman data.',
                'description' => 'Perancangan dan pengujian prototipe berbasis ESP32, ESP8266, sensor, dan pencatatan data sesuai kebutuhan proyek.',
                'category' => 'Perangkat',
                'icon' => 'cpu',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Otomasi dan homelab',
                'slug' => 'otomasi-homelab',
                'summary' => 'Eksplorasi server Linux ARM, CasaOS, dan Home Assistant.',
                'description' => 'Pengalaman eksperimen menyiapkan layanan lokal dan otomasi rumah pada perangkat STB berbasis ARM.',
                'category' => 'Eksplorasi',
                'icon' => 'server',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];
    }

    private function projects(): array
    {
        return [
            [
                'title' => 'SIMONTA',
                'slug' => 'simonta-monitoring-hara-tanah',
                'category' => 'Proyek skripsi',
                'summary' => 'Sistem monitoring hara tanah portabel dengan IoT dan Web SIG.',
                'description' => 'Menggabungkan ESP32 Wrover, sensor NPK, GPS, penyimpanan offline, dan visualisasi spasial untuk menyajikan rekomendasi pemupukan di Kecamatan Sapuran, Wonosobo.',
                'technology_stack' => ['C/C++', 'ESP32 Wrover', 'Sensor NPK', 'GPS', 'Web SIG'],
                'cover_image' => 'images/projects/simonta-hasil-analisis.jpeg',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Aplikasi Manajemen Pondok Pesantren',
                'slug' => 'manajemen-pondok-pesantren',
                'category' => 'Magang Kominfo · Semester 6',
                'summary' => 'Dashboard administrasi dengan modul pengelolaan data pondok pesantren.',
                'description' => 'Membangun aplikasi untuk membantu administrasi santri, ustadz, wali santri, kelas, kitab, jadwal, asrama, pembayaran, perizinan, kehadiran, dan nilai.',
                'technology_stack' => ['Web', 'Dashboard admin', 'Manajemen data'],
                'cover_image' => 'images/projects/kominfo-admin-preview.jpg',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Presensi RFID SPPG',
                'slug' => 'presensi-rfid-sppg',
                'category' => 'Magang · Semester 7',
                'summary' => 'Presensi berbasis kartu RFID dengan dashboard operasional.',
                'description' => 'Mengembangkan presensi memakai RFID dan ESP8266, Google Sheets sebagai penyimpanan, serta dashboard untuk log, rekap durasi, pencatatan manual, dan ekspor laporan.',
                'technology_stack' => ['RFID', 'ESP8266', 'Google Sheets', 'Dashboard web'],
                'cover_image' => 'images/projects/sppg-dashboard-preview.jpg',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Presensi dan Pelaporan Outlet',
                'slug' => 'presensi-pelaporan-outlet',
                'category' => 'Proyek mandiri',
                'summary' => 'Aplikasi Android untuk presensi lokasi dan pelaporan operasional.',
                'description' => 'Membuat aplikasi Kotlin dengan pencatatan presensi berbasis lokasi dan alur laporan yang terhubung ke Google Apps Script serta Sheets.',
                'technology_stack' => ['Kotlin', 'Android Native', 'Google Apps Script', 'Google Sheets'],
                'cover_image' => 'images/projects/outlet-app-full.jpg',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Homelab STB berbasis ARM',
                'slug' => 'homelab-stb-arm',
                'category' => 'Eksperimen pribadi',
                'summary' => 'Menyiapkan Linux ARM dan Home Assistant pada STB HGP.',
                'description' => 'Mencoba Armbian dan CasaOS pada STB HGP, lalu menggunakannya untuk memasang Home Assistant sebagai server otomasi rumah.',
                'technology_stack' => ['STB HGP', 'Armbian', 'Linux ARM', 'CasaOS', 'Home Assistant'],
                'cover_image' => null,
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 5,
            ],
        ];
    }
}
