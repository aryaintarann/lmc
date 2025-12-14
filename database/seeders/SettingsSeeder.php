<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\Contact;
use App\Models\Header;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Header
        Header::updateOrCreate(
            ['id' => 1],
            [
                'title' => [
                    'id' => 'Kesehatan Anda, Prioritas Kami',
                    'en' => 'Your Health, Our Priority',
                ],
                'tagline' => [
                    'id' => 'Perawatan dengan Kasih Sayang, Medis yang Canggih',
                    'en' => 'Compassionate Care, Advanced Medicine',
                ],
                'logo' => null,
            ]
        );

        // Seed Contact
        Contact::updateOrCreate(
            ['id' => 1],
            [
                'phone' => '+62 361 123456',
                'email' => 'info@legianmedical.com',
                'address' => [
                    'id' => 'Jalan Legian No. 123, Bali, Indonesia',
                    'en' => 'Jalan Legian No. 123, Bali, Indonesia',
                ],
                'whatsapp' => '+62 812 3456 7890',
                'maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.7378807478916!2d115.16858931478!3d-8.718041693787434!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd246b9a74a84e9%3A0x3e47575e7c3e2c5!2sLegian%2C%20Kuta%2C%20Badung%20Regency%2C%20Bali!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'facebook' => 'https://facebook.com/legianmedicalclinic',
                'instagram' => 'https://instagram.com/legianmedicalclinic',
            ]
        );

        // Seed About
        About::updateOrCreate(
            ['id' => 1],
            [
                'title' => [
                    'id' => 'Tentang Kami',
                    'en' => 'About Us',
                ],
                'description' => [
                    'id' => 'Legian Medical Clinic telah menjadi pilar kesehatan di komunitas selama lebih dari satu dekade. Kami menggabungkan teknologi mutakhir dengan perawatan penuh kasih untuk memastikan Anda mendapatkan perawatan terbaik yang mungkin.',
                    'en' => 'Legian Medical Clinic has been a pillar of health in the community for over a decade. We combine state-of-the-art technology with compassionate care to ensure you receive the best treatment possible.',
                ],
                'vision' => [
                    'id' => 'Menjadi klinik medis terkemuka yang memberikan pelayanan kesehatan berkualitas tinggi dengan sentuhan personal.',
                    'en' => 'To become a leading medical clinic providing high-quality healthcare with a personal touch.',
                ],
                'mission' => [
                    'id' => 'Memberikan layanan kesehatan yang komprehensif, terjangkau, dan mudah diakses oleh semua lapisan masyarakat.',
                    'en' => 'To provide comprehensive, affordable, and accessible healthcare services to all segments of society.',
                ],
                'image' => null,
            ]
        );
    }
}
