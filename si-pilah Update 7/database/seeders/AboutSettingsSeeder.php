<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutSetting;

class AboutSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // === HERO ===
            ['section' => 'hero', 'key' => 'badge', 'value' => 'SI-PILAH', 'order' => 1],
            ['section' => 'hero', 'key' => 'subtitle', 'value' => 'Platform pengelolaan sampah terpadu', 'order' => 2],
            ['section' => 'hero', 'key' => 'title', 'value' => 'Solusi mutakhir untuk pengelolaan sampah yang terintegrasi', 'order' => 3],
            ['section' => 'hero', 'key' => 'description', 'value' => 'Mengubah cara masyarakat mengelola sampah melalui teknologi digital, edukasi, dan kolaborasi komunitas.', 'order' => 4],

            // === VISI ===
            ['section' => 'visi', 'key' => 'title', 'value' => 'Visi SI-Pilah', 'order' => 1],
            ['section' => 'visi', 'key' => 'description', 'value' => 'Menjadikan kota yang bersih dan berkelanjutan melalui pengelolaan sampah yang efisien, cerdas, dan berdampak nyata bagi masyarakat dan lingkungan.', 'order' => 2],

            // === STRATEGI ===
            ['section' => 'strategi', 'key' => 'title', 'value' => 'Strategi Kami', 'order' => 1],
            ['section' => 'strategi', 'key' => 'description', 'value' => 'Mengintegrasikan teknologi digital dengan partisipasi masyarakat untuk menciptakan ekosistem pengelolaan sampah yang inklusif dan terukur.', 'order' => 2],

            // === SEJARAH ===
            ['section' => 'sejarah', 'key' => 'item_1_year', 'value' => '2023', 'order' => 1],
            ['section' => 'sejarah', 'key' => 'item_1_title', 'value' => 'Ide Awal', 'order' => 2],
            ['section' => 'sejarah', 'key' => 'item_1_desc', 'value' => 'Lahir dari keprihatinan terhadap masalah sampah perkotaan. Tim kecil mulai merancang solusi digital untuk pengelolaan sampah.', 'order' => 3],
            ['section' => 'sejarah', 'key' => 'item_2_year', 'value' => '2024', 'order' => 4],
            ['section' => 'sejarah', 'key' => 'item_2_title', 'value' => 'Pengembangan Platform', 'order' => 5],
            ['section' => 'sejarah', 'key' => 'item_2_desc', 'value' => 'Platform SI-Pilah dikembangkan dengan fitur pencatatan sampah, tracking setoran, dan sistem reward berbasis poin.', 'order' => 6],
            ['section' => 'sejarah', 'key' => 'item_3_year', 'value' => '2025', 'order' => 7],
            ['section' => 'sejarah', 'key' => 'item_3_title', 'value' => 'Peluncuran & Kemitraan', 'order' => 8],
            ['section' => 'sejarah', 'key' => 'item_3_desc', 'value' => 'SI-Pilah resmi diluncurkan dan menjalin kemitraan dengan bank sampah serta pemerintah daerah untuk memperluas jangkauan.', 'order' => 9],
            ['section' => 'sejarah', 'key' => 'item_4_year', 'value' => '2026 — Sekarang', 'order' => 10],
            ['section' => 'sejarah', 'key' => 'item_4_title', 'value' => 'Ekspansi Nasional', 'order' => 11],
            ['section' => 'sejarah', 'key' => 'item_4_desc', 'value' => 'Integrasi dengan energi surya kota, fitur kontribusi energi bersih, dan edukasi digital tentang pengelolaan sampah berkelanjutan.', 'order' => 12],

            // === TEAM ===
            ['section' => 'team', 'key' => 'description', 'value' => 'Kami adalah tim yang berdedikasi tinggi dalam menciptakan solusi inovatif untuk pengelolaan sampah yang berkelanjutan di Indonesia.', 'order' => 0],
            ['section' => 'team', 'key' => 'member_1_name', 'value' => 'Muhammad Fauzan', 'order' => 1],
            ['section' => 'team', 'key' => 'member_1_role', 'value' => 'Chief Executive Officer', 'order' => 2],
            ['section' => 'team', 'key' => 'member_2_name', 'value' => 'Sari Ratna Ramadhani', 'order' => 3],
            ['section' => 'team', 'key' => 'member_2_role', 'value' => 'Chief Operating Officer', 'order' => 4],
            ['section' => 'team', 'key' => 'member_3_name', 'value' => 'Rizky Sandi Pratama', 'order' => 5],
            ['section' => 'team', 'key' => 'member_3_role', 'value' => 'Chief Technology Officer', 'order' => 6],
            ['section' => 'team', 'key' => 'member_4_name', 'value' => 'Anneta Kusnawati Ramadhani', 'order' => 7],
            ['section' => 'team', 'key' => 'member_4_role', 'value' => 'Chief Marketing Officer', 'order' => 8],
            ['section' => 'team', 'key' => 'member_5_name', 'value' => 'Revita Dharma Ali', 'order' => 9],
            ['section' => 'team', 'key' => 'member_5_role', 'value' => 'Head of Operations', 'order' => 10],
            ['section' => 'team', 'key' => 'member_6_name', 'value' => 'Muhammad Ardian', 'order' => 11],
            ['section' => 'team', 'key' => 'member_6_role', 'value' => 'Lead Developer', 'order' => 12],
            ['section' => 'team', 'key' => 'member_7_name', 'value' => 'Satriyo Sakti Prabudi', 'order' => 13],
            ['section' => 'team', 'key' => 'member_7_role', 'value' => 'UI/UX Designer', 'order' => 14],

            // === LAYANAN ===
            ['section' => 'layanan', 'key' => 'item_1_title', 'value' => 'Waste Management Consulting', 'order' => 1],
            ['section' => 'layanan', 'key' => 'item_1_desc', 'value' => 'Layanan konsultasi profesional untuk pengelolaan sampah yang efisien dan ramah lingkungan, mulai dari perencanaan hingga implementasi.', 'order' => 2],
            ['section' => 'layanan', 'key' => 'item_2_title', 'value' => 'Waste Collection Services', 'order' => 3],
            ['section' => 'layanan', 'key' => 'item_2_desc', 'value' => 'Layanan pengumpulan sampah terpilah dari rumah ke rumah dengan jadwal teratur dan sistem pelacakan digital.', 'order' => 4],
            ['section' => 'layanan', 'key' => 'item_3_title', 'value' => 'Responsible Recycling', 'order' => 5],
            ['section' => 'layanan', 'key' => 'item_3_desc', 'value' => 'Program daur ulang bertanggung jawab yang memastikan setiap material sampah diproses secara optimal dan berkelanjutan.', 'order' => 6],
            ['section' => 'layanan', 'key' => 'item_4_title', 'value' => 'Digital Waste Tracking', 'order' => 7],
            ['section' => 'layanan', 'key' => 'item_4_desc', 'value' => 'Platform digital untuk memantau dan melacak kontribusi pengelolaan sampah Anda secara real-time dengan analitik terperinci.', 'order' => 8],
        ];

        foreach ($defaults as $item) {
            AboutSetting::updateOrCreate(
                ['section' => $item['section'], 'key' => $item['key']],
                ['value' => $item['value'], 'order' => $item['order']]
            );
        }
    }
}
