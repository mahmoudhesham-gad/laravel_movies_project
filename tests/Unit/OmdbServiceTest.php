<?php

namespace Tests\Unit;

use App\Services\OmdbService;
use Tests\TestCase;

class OmdbServiceTest extends TestCase
{
    public function test_get_movie_by_id_returns_movie_details(): void
    {
        $service = new OmdbService;
        $movie = $service->getMovieById('tt0468569');

        $this->assertNotNull($movie);
        $this->assertSame('The Dark Knight', $movie['Title']);
        $this->assertArrayHasKey('Plot', $movie);
        $this->assertArrayHasKey('Director', $movie);
        $this->assertArrayHasKey('Actors', $movie);
        $this->assertArrayHasKey('imdbRating', $movie);
    }

    public function test_search_movies_returns_results_from_real_api(): void
    {
        $service = new OmdbService;
        $result = $service->searchMovies('Batman');

        $this->assertNotEmpty($result['movies']);
        $this->assertGreaterThan(0, $result['totalResults']);
        $this->assertGreaterThan(0, $result['totalPages']);
        $this->assertEmpty($result['error']);

        $this->assertArrayHasKey('Title', $result['movies'][0]);
        $this->assertArrayHasKey('Year', $result['movies'][0]);
        $this->assertArrayHasKey('imdbID', $result['movies'][0]);
    }
}
