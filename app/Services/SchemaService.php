<?php

namespace App\Services;

use Spatie\SchemaOrg\Schema;
use App\Models\Article;
use App\Models\Doctor;

class SchemaService
{
    public function getOrganizationSchema()
    {
        return Schema::organization()
            ->name(config('app.name', 'Lombok Medical Center'))
            ->url(url('/'))
            ->logo(url('/images/logo.png')) // Adjust path to actual logo
            ->sameAs([
                'https://www.facebook.com/lombokmedicalcenter',
                'https://www.instagram.com/lombokmedicalcenter'
            ])
            ->contactPoint(
                Schema::contactPoint()
                    ->telephone('+62-123-456-7890') // Replace with real phone
                    ->contactType('customer service')
            );
    }

    public function getMedicalClinicSchema()
    {
        return Schema::medicalClinic()
            ->name(config('app.name', 'Lombok Medical Center'))
            ->image(url('/images/clinic-facade.jpg')) // Adjust path
            ->url(url('/'))
            ->telephone('+62-123-456-7890')
            ->address(
                Schema::postalAddress()
                    ->streetAddress('Jl. Raya Mataram No. 123') // Replace with real address
                    ->addressLocality('Mataram')
                    ->addressRegion('Nusa Tenggara Barat')
                    ->postalCode('83121')
                    ->addressCountry('ID')
            )
            ->geo(
                Schema::geoCoordinates()
                    ->latitude('-8.5833') // Replace with real coordinates
                    ->longitude('116.1167')
            )
            ->openingHoursSpecification([
                Schema::openingHoursSpecification()
                    ->dayOfWeek(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'])
                    ->opens('08:00')
                    ->closes('21:00'),
                Schema::openingHoursSpecification()
                    ->dayOfWeek(['Saturday', 'Sunday'])
                    ->opens('09:00')
                    ->closes('17:00')
            ]);
    }

    public function getArticleSchema(Article $article)
    {
        return Schema::article()
            ->headline($article->title)
            ->description($article->excerpt)
            ->image($article->image ? url('storage/' . $article->image) : url('/images/default-article.jpg'))
            ->author(Schema::person()->name('LMC Team')) // Or specific author if available
            ->datePublished($article->published_at)
            ->dateModified($article->updated_at)
            ->publisher(
                Schema::organization()
                    ->name(config('app.name'))
                    ->logo(Schema::imageObject()->url(url('/images/logo.png')))
            )
            ->mainEntityOfPage(url()->current());
    }
}
