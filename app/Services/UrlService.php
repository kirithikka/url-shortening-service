<?php

namespace App\Services;

use App\Models\Url;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class UrlService
{
    /**
     * Encode the original url to short url
     */
    public function encode(string $originalUrl) {
        // check if the encoded url is cached
        if ($shortUrl = Cache::get($originalUrl)) {
            return response()->json(['short_url' => $this->getFullShortUrl($shortUrl)], 200);
        }

        // short url is not cached. So, fetch it from the DB
        $urlMapping = Url::where('original_url', $originalUrl)->first();
        if ($urlMapping) {
            return response()->json(['short_url' => $this->getFullShortUrl($shortUrl)], 200);
        }

        // the url mapping not present in the DB. So, create and cache it
        $shortUrl = Str::random(6); // 6 characters after the domain name
        $mapping = Url::create([
            'original_url' => $originalUrl,
            'short_url' => $shortUrl,
        ]);

        Cache::put($originalUrl, $mapping['short_url']);
         
        return response()->json(['short_url' => $this->getFullShortUrl($shortUrl)], 200);
    }

    /**
     * Decode the short url to original url
     */
    public function decode(string $shortUrl) {
        $shortUrl = $this->getShortUrlWithoutDomainName($shortUrl);

        // check if the decoded url is cached
        if ($originalUrl = Cache::get($shortUrl)) {
            return response()->json(['original_url' => $originalUrl], 200);
        }

        // original url is not cached. So, fetch it from the DB
        $urlMapping = Url::where('short_url', $shortUrl)->first();
        if ($urlMapping) {
            // cache and return the original url
            Cache::put($shortUrl, $urlMapping->original_url);

            return response()->json(['original_url' => $urlMapping->original_url], 200);
        }

        // the short url is not present in the DB too.
        return response()->json(['error' => 'The short url is invalid'], 404);
    }

    /**
     * Get short url with domain name
     */
    public function getFullShortUrl($shortUrl)
    {
        return config('url_shortening_service.domain_name') . '/' . $shortUrl;
    }

    /**
     * Get short url without domain name
     */
    public function getShortUrlWithoutDomainName($shortUrl)
    {
        return str_replace(config('url_shortening_service.domain_name') . '/', '', $shortUrl);
    }
}