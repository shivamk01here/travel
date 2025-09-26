<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function profile(){
        return view('profile.profile');
    }

    public function index()
    {
        $userId = Auth::id();

        // Get all orders from orders table
        $orders = DB::select("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC", [$userId]);

        return view('profile.orders.index', compact('orders'));
    }

    // Show single order details
    public function show($id)
    {
        $userId = Auth::id();

        $order = DB::selectOne("SELECT * FROM orders WHERE id = ? AND user_id = ?", [$id, $userId]);
        if (!$order) abort(404);

        $items = DB::select("SELECT * FROM order_items WHERE order_id = ?", [$id]);

        foreach ($items as $item) {
            $item->meta = json_decode($item->meta, true) ?? [];
        }

        return view('profile.orders.show', compact('order', 'items'));
    }
}
