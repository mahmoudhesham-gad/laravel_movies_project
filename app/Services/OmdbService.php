<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OmdbService
{
    private string $apiKey;
    private string $baseUrl = 'https://www.omdbapi.com/';

    public function __construct()
    {
        $this->apiKey = config('services.omdb.key');
    }

    public function searchMovies(string $query, string $type = '', int $page = 1): array
    {
        $out = ['movies' => [], 'totalResults' => 0, 'totalPages' => 0, 'error' => ''];

        if (empty($query)) {
            return $out;
        }

        $url = $this->baseUrl . '?s=' . urlencode($query)
             . '&page=' . $page
             . '&apikey=' . $this->apiKey;

        if (!empty($type)) {
            $url .= '&type=' . urlencode($type);
        }

        $data = $this->fetch($url);

        if (!$data || ($data['Response'] ?? '') !== 'True') {
            $out['error'] = $data['Error'] ?? 'No results found.';
            return $out;
        }

        $out['totalResults'] = (int) ($data['totalResults'] ?? 0);
        $out['totalPages'] = (int) ceil($out['totalResults'] / 10);
        $out['movies'] = $data['Search'] ?? [];

        return $out;
    }

    public function getMovieById(string $imdbId): ?array
    {
        $url = $this->baseUrl . '?i=' . urlencode($imdbId) . '&plot=full&apikey=' . $this->apiKey;
        $data = $this->fetch($url);

        return ($data && ($data['Response'] ?? '') === 'True') ? $data : null;
    }

    public function getIndexData(): array
    {
        $queries = ['Batman', 'Avengers', 'Star Wars', 'John Wick', 'Interstellar', 'Inception'];
        $randomQuery = $queries[array_rand($queries)];

        $trending = $this->searchMovies($randomQuery, 'movie', 1);
        $movies = $trending['movies'] ?? [];

        $featured = null;
        if (!empty($movies)) {
            $featured = $this->getMovieById($movies[0]['imdbID']);
        }

        return [
            'hasFeatured' => !empty($featured),
            'featured' => $featured,
            'trendingMovies' => array_slice($movies, 1, 8),
            'randomQuery' => $randomQuery,
        ];
    }

    private function fetch(string $url): ?array
    {
        try {
            $response = Http::timeout(10)
                ->withOptions([
                    'verify' => false,
                ])
                ->get($url);

            return $response->json();
        } catch (\Exception $e) {
            return null;
        }
    }
}
