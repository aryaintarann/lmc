<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\Setting;

class MockTranslationSeeder extends Seeder
{
    public function run()
    {
        $dictionary = [
            'Legian Medical Clinic' => 'Klinik Medis Legian',
            'Your Health, Our Priority' => 'Kesehatan Anda, Prioritas Kami',
            'Compassionate Care, Advanced Medicine' => 'Perawatan Penuh Kasih, Pengobatan Canggih',
            'About Us' => 'Tentang Kami',
            'Legian Medical Clinic has been a pillar of health in the community for over a decade. We combine state-of-the-art technology with compassionate care to ensure you receive the best treatment possible.' => 'Klinik Medis Legian telah menjadi pilar kesehatan masyarakat selama lebih dari satu dekade. Kami menggabungkan teknologi terkini dengan perawatan penuh kasih.',
            'Jalan Legian, Bali, Indonesia' => 'Jalan Legian, Bali, Indonesia',
            'Emergency Care' => 'Layanan Darurat',
            '24/7 rapid response team ready to handle any medical emergencies.' => 'Tim respon cepat 24/7 siap menangani darurat medis.',
            'Pharmacy' => 'Apotek',
            'Fully stocked in-house pharmacy with prescription and OTC medications.' => 'Apotek lengkap dengan resep dan obat bebas.',
            'General Practitioner' => 'Dokter Umum',
            '15+ years of experience in family medicine.' => 'Pengalaman 15+ tahun dalam kedokteran keluarga.',
            'Pediatrician' => 'Dokter Anak',
            'Specialist in child healthcare and development.' => 'Spesialis kesehatan dan tumbuh kembang anak.',
            '5 Tips for a Healthy Heart' => '5 Tips Jantung Sehat',
            'Discover simple lifestyle changes that can significantly improve your heart health and longevity.' => 'Temukan perubahan gaya hidup sederhana untuk kesehatan jantung.',
            'Full content here...' => 'Konten lengkap di sini...',
        ];

        // Settings
        $settings = Setting::all();
        foreach ($settings as $setting) {
            $en = $setting->getTranslation('value', 'en');
            if ($en) {
                // Use dictionary or fallback to [ID] prefix
                $id = $dictionary[$en] ?? '[ID] ' . $en;

                // Manual overrides for specific keys
                if ($setting->key === 'header_btn_text')
                    $id = 'Buat Janji';

                $setting->setTranslation('value', 'id', $id);
                $setting->save();
            }
        }

        // Articles
        foreach (Article::all() as $article) {
            $titleEn = $article->getTranslation('title', 'en');
            $excerptEn = $article->getTranslation('excerpt', 'en');

            $article->setTranslation('title', 'id', $dictionary[$titleEn] ?? '[ID] ' . $titleEn);
            $article->setTranslation('excerpt', 'id', $dictionary[$excerptEn] ?? '[ID] ' . $excerptEn);
            $article->setTranslation('content', 'id', 'Konten artikel dalam Bahasa Indonesia...');
            $article->save();
        }

        // Services
        foreach (Service::all() as $service) {
            $titleEn = $service->getTranslation('title', 'en');
            $descEn = $service->getTranslation('description', 'en');

            $service->setTranslation('title', 'id', $dictionary[$titleEn] ?? '[ID] ' . $titleEn);
            $service->setTranslation('description', 'id', $dictionary[$descEn] ?? '[ID] ' . $descEn);
            $service->save();
        }

        // Doctors
        foreach (Doctor::all() as $doctor) {
            $specEn = $doctor->getTranslation('specialty', 'en');
            $bioEn = $doctor->getTranslation('bio', 'en');

            $doctor->setTranslation('specialty', 'id', $dictionary[$specEn] ?? '[ID] ' . $specEn);
            if ($bioEn) {
                $doctor->setTranslation('bio', 'id', $dictionary[$bioEn] ?? '[ID] ' . $bioEn);
            }
            $doctor->save();
        }
    }
}
