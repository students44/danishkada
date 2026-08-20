<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', true)->get();
        $popularProducts = Product::where('status', true)->where('is_popular', true)->take(8)->get();
        $featuredProducts = Product::where('status', true)->where('is_featured', true)->take(4)->get();
        
        return view('home', compact('categories', 'popularProducts', 'featuredProducts'));
    }
}
