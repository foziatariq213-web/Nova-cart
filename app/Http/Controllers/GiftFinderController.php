<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class GiftFinderController extends Controller
{
    // Show Gift Finder page
    public function index()
    {
        return view('frontend.gift-finder');
    }

    // Search matching gifts
    public function search(Request $request)
    {
        $products = Product::with('category', 'brand');

        if ($request->gift_for) {
            $products->where('gift_for', $request->gift_for);
        }

        if ($request->occasion) {
            $products->where('occasion', $request->occasion);
        }

        $products = $products->latest()->paginate(12);

        return view('frontend.gift-results', compact('products'));
    }
}