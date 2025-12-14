<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create('/articles')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create('/services')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create('/doctors')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create('/contact')->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        // Add Articles
        Article::whereNotNull('published_at')->each(function (Article $article) use ($sitemap) {
            $sitemap->add(
                Url::create("/articles/{$article->id}")
                    ->setLastModificationDate($article->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.7)
            );
        });

        // Add Services (Assuming route is /services/{id} or handled via query params? LMC seems to be single page mostly but has detail pages?)
        // Wait, looking at routes:
        // Route::get('/', [LandingController::class, 'index'])
        // Route::get('/articles', [LandingController::class, 'articles'])
        // Route::get('/articles/{id}', [LandingController::class, 'show'])
        // Services/Doctors don't have detail URLs in routes/web.php I reviewed earlier!
        // They are just sections on landing page.
        // So I should NOT add individual doctor/service URLs if they don't exist.

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully at public/sitemap.xml');
    }
}
