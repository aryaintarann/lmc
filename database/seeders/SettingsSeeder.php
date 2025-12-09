<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Legian Medical Clinic'],
            ['key' => 'header_title', 'value' => 'Your Health, Our Priority'],
            ['key' => 'header_subtitle', 'value' => 'Compassionate Care, Advanced Medicine'],
            ['key' => 'about_title', 'value' => 'About Us'],
            ['key' => 'about_content', 'value' => 'Legian Medical Clinic has been a pillar of health in the community for over a decade. We combine state-of-the-art technology with compassionate care to ensure you receive the best treatment possible.'],
            ['key' => 'contact_address', 'value' => 'Jalan Legian, Bali, Indonesia'],
            ['key' => 'contact_email', 'value' => 'info@legianmedical.com'],
            ['key' => 'contact_phone', 'value' => '+62 361 123456'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
