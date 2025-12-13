<?php

namespace App\Services;

class InternalLinkService
{
    /**
     * Dictionary of keywords and their target URLs.
     * In a real app, this could come from a database.
     */
    protected $links = [
        'Blepharoplasty' => '/services/blepharoplasty',
        'Kantung Mata' => '/services/blepharoplasty',
        'Facelift' => '/services/facelift',
        'Tarik Benang' => '/services/threadlift',
        'Dokter Bedah' => '/doctors',
        'Konsultasi' => '/contact',
    ];

    /**
     * Auto-link keywords in the content.
     * only links the first occurrence of each keyword to avoid spammy look.
     *
     * @param string $content
     * @return string
     */
    public function linkKeywords(string $content): string
    {
        foreach ($this->links as $keyword => $url) {
            // Regex to find the keyword (case-insensitive) ensuring it's not already inside a link tag or attribute
            // This is a simplified regex. For robust HTML parsing, DOMDocument is better, but heavy.
            // We use a safe approximation: match word boundary, not inside <a> tag? 
            // Parsing HTML with regex is fragile. 
            // For now, let's use a simple replacement that attempts to avoid replacing inside HTML attributes.

            $pattern = '/(?!(?:[^<]+>|[^>]+<\/a>))\b(' . preg_quote($keyword, '/') . ')\b/i';

            // Limit to 1 replacement
            $content = preg_replace($pattern, '<a href="' . url($url) . '" class="text-primary fw-bold text-decoration-none">$1</a>', $content, 1);
        }

        return $content;
    }
}
