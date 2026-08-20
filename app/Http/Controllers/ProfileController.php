<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('profile.orders', compact('orders'));
    }

    public function showOrder($orderNumber)
    {
        $order = Order::where('user_id', Auth::id())->where('order_number', $orderNumber)->with('items.product')->firstOrFail();
        return view('profile.order_details', compact('order'));
    }
}
