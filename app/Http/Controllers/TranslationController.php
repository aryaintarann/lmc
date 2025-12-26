<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranslateRequest;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TranslationController extends Controller
{
    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Translate text via AJAX
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function translate(TranslateRequest $request)
    {
        $validated = $request->validated();

        $text = $validated['text'];
        $sourceLang = $validated['source_lang'];
        $targetLang = $validated['target_lang'];

        try {
            $translated = $this->translationService->translate($text, $sourceLang, $targetLang);

            return response()->json([
                'success' => true,
                'original' => $text,
                'translated' => $translated,
                'source_lang' => $sourceLang,
                'target_lang' => $targetLang,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Translation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Translate multiple texts via AJAX (batch)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function translateBatch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'texts' => 'required|array',
            'texts.*' => 'required|string',
            'source_lang' => 'required|string|in:en,id',
            'target_lang' => 'required|string|in:en,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $texts = $request->input('texts');
        $sourceLang = $request->input('source_lang');
        $targetLang = $request->input('target_lang');

        try {
            $translations = $this->translationService->translateBatch($texts, $sourceLang, $targetLang);

            return response()->json([
                'success' => true,
                'translations' => $translations,
                'source_lang' => $sourceLang,
                'target_lang' => $targetLang,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Batch translation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
