<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use App\Models\Product;

class MoodController extends Controller
{
    // Show all moods
    public function index()
    {
        $moods = Mood::all();

        return view('frontend.mood-shop', compact('moods'));
    }

    // Show products of selected mood
    public function products(Mood $mood)
    {
        $products = Product::with('category', 'brand')
                            ->where('mood_id', $mood->id)
                            ->latest()
                            ->paginate(12);

        return view('frontend.mood-products', compact('products', 'mood'));
    }
}