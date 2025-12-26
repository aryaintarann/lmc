<?php

namespace App\Services;

class TitleGeneratorService
{
    protected array $bannedWords = [
        'video',
        'youtube',
        'mp3',
        'download',
        'gambar',
        'image',
        'pics',
        'band',
        'lyrics',
        'chord',
        'lirik',
        'kord',
        'lagu',
        'meaning',
        'pronunciation',
        'definition',
        'arti',
        'maksud',
        'pengucapan',
        'translate',
        'terjemahan',
        'wallpaper',
        'hot',
        'sex',
    ];

    /**
     * Generate optimized titles from keywords.
     *
     * @param array $keywords
     * @param string $lang
     * @return array
     */
    public function generate(array $keywords, string $lang): array
    {
        $titles = [];

        foreach ($keywords as $k) {
            if ($this->isBanned($k)) {
                continue;
            }

            $wordCount = str_word_count($k);

            // Strategy 1: Real Long-Tail Queries (>= 4 Words)
            if ($wordCount >= 4) {
                $titles[] = ucwords($k);
                continue;
            }

            // Strategy 2: Question keywords (>= 3 Words)
            $isQuestion = preg_match('/^(apa|kenapa|bagaimana|siapa|kapan|how|why|what|when|who|cara|tips|is|are|can|does)/i', $k);
            if ($wordCount >= 3 && $isQuestion) {
                $titles[] = ucwords($k);
                continue;
            }

            // Strategy 3: Short but valuable keywords (3 words) -> Use Template
            if ($wordCount == 3) {
                $baseKeyword = ucwords($k);
                if ($lang === 'en') {
                    $titles[] = "Complete Guide: $baseKeyword";
                    $titles[] = "All You Need to Know About $baseKeyword";
                } else {
                    $titles[] = "Panduan Lengkap: $baseKeyword";
                    $titles[] = "Fakta Penting Tentang $baseKeyword";
                }
            }
        }

        // Remove duplicates and limit
        return array_slice(array_unique($titles), 0, 8);
    }

    protected function isBanned(string $keyword): bool
    {
        foreach ($this->bannedWords as $bad) {
            if (stripos($keyword, $bad) !== false) {
                return true;
            }
        }
        return false;
    }
}
