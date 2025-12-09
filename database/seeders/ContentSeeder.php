<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Services
        \App\Models\Service::create([
            'title' => 'Emergency Care',
            'description' => '24/7 rapid response team ready to handle any medical emergencies.',
            'icon' => 'bi-activity'
        ]);
        \App\Models\Service::create([
            'title' => 'Pharmacy',
            'description' => 'Fully stocked in-house pharmacy with prescription and OTC medications.',
            'icon' => 'bi-capsule'
        ]);

        // Doctors
        \App\Models\Doctor::create([
            'name' => 'Dr. Sarah Johnson',
            'specialty' => 'General Practitioner',
            'bio' => '15+ years of experience in family medicine.',
            'image' => 'https://placehold.co/120x120'
        ]);
        \App\Models\Doctor::create([
            'name' => 'Dr. Mark Lee',
            'specialty' => 'Pediatrician',
            'bio' => 'Specialist in child healthcare and development.',
            'image' => 'https://placehold.co/120x120'
        ]);

        // Articles
        \App\Models\Article::create([
            'title' => '5 Tips for a Healthy Heart',
            'published_at' => '2024-08-12',
            'excerpt' => 'Discover simple lifestyle changes that can significantly improve your heart health and longevity.',
            'content' => 'Full content here...',
            'image' => 'https://placehold.co/600x400?text=Heart+Health'
        ]);
        \App\Models\Article::create([
            'title' => 'Boosting Your Immune System',
            'published_at' => '2024-07-28',
            'excerpt' => 'Learn how your body fights off infections and what you can do to support your natural defenses.',
            'content' => 'Full content here...',
            'image' => 'https://placehold.co/600x400?text=Immune+System'
        ]);
        \App\Models\Article::create([
            'title' => 'Importance of Regular Checkups',
            'published_at' => '2024-06-15',
            'excerpt' => 'Why you shouldn\'t skip your annual physical and what early detection means for your health.',
            'content' => 'Full content here...',
            'image' => 'https://placehold.co/600x400?text=Regular+Checkups'
        ]);
        \App\Models\Article::create([
            'title' => 'Understanding Mental Health',
            'published_at' => '2024-05-10',
            'excerpt' => 'Breaking the stigma around mental health and knowing when to seek professional help.',
            'content' => 'Full content here...',
            'image' => 'https://placehold.co/600x400?text=Mental+Health'
        ]);
        \App\Models\Article::create([
            'title' => 'Nutrition 101: A Balanced Diet',
            'published_at' => '2024-04-22',
            'excerpt' => 'The fundamentals of good nutrition and how to build a diet that fuels your body effectively.',
            'content' => 'Full content here...',
            'image' => 'https://placehold.co/600x400?text=Nutrition'
        ]);
    }
}
