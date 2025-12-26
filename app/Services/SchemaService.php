<?php

namespace App\Services;

use App\Models\Article;
use Spatie\SchemaOrg\Schema;

class SchemaService
{
    public function getOrganizationSchema()
    {
        return Schema::organization()
            ->name(config('app.name', 'Legian Medical Clinic'))
            ->url(url('/'))
            ->logo(url('/images/logo.png')) // Adjust path to actual logo
            ->contactPoint(
                Schema::contactPoint()
                    ->telephone('+62-123-456-7890') // Replace with real phone
                    ->contactType('customer service')
            );
    }

    public function getMedicalClinicSchema()
    {
        return Schema::medicalClinic()
            ->name(config('app.name', 'Legian Medical Clinic'))
            ->image(url('/images/clinic-facade.jpg')) // Adjust path
            ->url(url('/'))
            ->telephone('(0361)758503')
            ->address(
                Schema::postalAddress()
                    ->streetAddress('Jl. Benesari') // Replace with real address
                    ->addressLocality('Legian')
                    ->addressRegion('Bali')
                    ->postalCode('80361')
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
                    ->opens(new \DateTime('08:00'))
                    ->closes(new \DateTime('21:00')),
                Schema::openingHoursSpecification()
                    ->dayOfWeek(['Saturday', 'Sunday'])
                    ->opens(new \DateTime('09:00'))
                    ->closes(new \DateTime('17:00')),
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
