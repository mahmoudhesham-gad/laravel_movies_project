<?php

namespace App\Http\Controllers;

use App\Services\OmdbService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(private OmdbService $omdb)
    {
    }

    public function index()
    {
        $data = $this->omdb->getIndexData();
        return view('movies.index', $data);
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $type = $request->input('type', '');
        $page = (int) $request->input('page', 1);

        $results = $this->omdb->searchMovies($query, $type, $page);

        return view('movies.search', [
            'query' => $query,
            'type' => $type,
            'page' => $page,
            'movies' => $results['movies'],
            'totalResults' => $results['totalResults'],
            'totalPages' => $results['totalPages'],
            'error' => $results['error'],
        ]);
    }
}
