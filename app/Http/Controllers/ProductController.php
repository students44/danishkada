<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('status', true)
            ->where('slug', $slug)
            ->with(['category', 'options', 'addons', 'reviews.user'])
            ->firstOrFail();
            
        // Calculate average rating
        $averageRating = $product->reviews()->avg('rating') ?? 5.0; // Default to 5.0 if no reviews
            
        // Get related products
        $relatedProducts = Product::where('status', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
            
        return view('menu.show', compact('product', 'averageRating', 'relatedProducts'));
    }
}
