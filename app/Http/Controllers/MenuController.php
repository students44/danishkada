<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('status', true)->get();
        
        $query = Product::where('status', true);
        
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $products = $query->with('category')->get();
        
        return view('menu.index', compact('categories', 'products'));
    }
}
