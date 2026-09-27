<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'badge' => '01 / STATISTIK & METODOLOGI',
                'title' => 'Pengolahan Data Penelitian',
                'description' => 'Membantu proses analisis data kuantitatif dengan berbagai metode statistik serta penyusunan interpretasi hasil secara profesional.',
                'image_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=1600&auto=format&fit=crop',
                'badge_color' => 'blue',
                'order_position' => 1,
                'is_active' => true,
            ],
            [
                'badge' => '02 / FORMAT & BEBAS PLAGIASI',
                'title' => 'Editing Dokumen Akademik',
                'description' => 'Membantu merapikan format penulisan, sitasi, daftar pustaka, dan tata bahasa sesuai pedoman institusi untuk menghasilkan dokumen yang lebih rapi dan profesional.',
                'image_url' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?q=80&w=1600&auto=format&fit=crop',
                'badge_color' => 'purple',
                'order_position' => 2,
                'is_active' => true,
            ],
            [
                'badge' => '03 / REKAYASA SISTEM INFORMATIKA',
                'title' => 'Pengembangan Website & Aplikasi',
                'description' => 'Layanan pengembangan website, aplikasi mobile, dan sistem informasi untuk kebutuhan tugas akhir, penelitian, maupun proyek lainnya.',
                'image_url' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=1600&auto=format&fit=crop',
                'badge_color' => 'emerald',
                'order_position' => 3,
                'is_active' => true,
            ],
            [
                'badge' => '04 / DESAIN PRESENTASI & MEDIA',
                'title' => 'Desain Presentasi & Media Visual',
                'description' => 'Layanan pembuatan poster akademik, presentasi PowerPoint, infografis, dan berbagai media visual dengan desain yang modern, informatif, dan menarik.',
                'image_url' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=1600&auto=format&fit=crop',
                'badge_color' => 'amber',
                'order_position' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['title' => $service['title']], $service);
        }
    }
}
