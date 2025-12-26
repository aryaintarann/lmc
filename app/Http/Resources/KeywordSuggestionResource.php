<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KeywordSuggestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Wrapper for non-model data
        return [
            'topic' => $this->resource['topic'],
            'id' => [
                'suggestions' => $this->resource['suggestionsID'],
                'titles' => $this->resource['titlesID'],
            ],
            'en' => [
                'suggestions' => $this->resource['suggestionsEN'],
                'titles' => $this->resource['titlesEN'],
            ],
        ];
    }
}
