<?php

namespace App\Http\Controllers;

use App\Models\FavoriteMovie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteMovieController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favoriteMovies()->get();
        return view('favorites.index', ['favorites' => $favorites]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_title' => 'required|string|max:255',
            'image_url' => 'required|string',
        ]);

        Auth::user()->favoriteMovies()->create([
            'movie_title' => $validated['movie_title'],
            'image_url' => $validated['image_url'],
        ]);

        return back()->with('success', 'Movie added to favorites!');
    }

    public function destroy(FavoriteMovie $favoriteMovie)
    {
        $favoriteMovie->delete();
        return back()->with('success', 'Movie removed from favorites.');
    }
}