<?php

namespace App\Http\Controllers;

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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function translate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string',
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

        $text = $request->input('text');
        $sourceLang = $request->input('source_lang');
        $targetLang = $request->input('target_lang');

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
     * @param Request $request
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
