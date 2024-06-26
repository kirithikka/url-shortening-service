<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Services\UrlService;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class UrlController extends Controller
{
    public function __construct(private UrlService $urlService)
    {
    }

    /**
     * Encode the original url to short url
     */
    public function encode(Request $request) {
        try {
            $request->validate(['url' => 'required|url']);
            
            return $this->urlService->encode($request->url);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Decode the short url to original url
     */
    public function decode(Request $request) {
        
    }
}
