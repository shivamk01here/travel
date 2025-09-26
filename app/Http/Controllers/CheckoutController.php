<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected function getCartItems($sessionId)
    {
        $cart = DB::selectOne("SELECT id FROM carts WHERE session_id = ? LIMIT 1", [$sessionId]);
        if (!$cart) return [];
        return DB::select("SELECT * FROM cart_items WHERE cart_id = ? ORDER BY id DESC", [$cart->id]);
    }

    public function show(Request $request)
    {
        // if (!Auth::check()) {
        //     return redirect()->route('login');
        // }

        $sessionId = $request->session()->getId();
        $items = $this->getCartItems($sessionId);

        $grandTotal = 0;
        foreach ($items as $item) {
            $item->meta = json_decode($item->meta, true) ?? [];
            $grandTotal += $item->total_price;
        }

        return view('checkout.show', compact('items', 'grandTotal'));
    }

    public function process(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first to checkout.');
        }
        
        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:300',
            'payment_method' => 'required|in:cod,online',
            'coupon' => 'nullable|string|max:20',
        ]);

        $sessionId = $request->session()->getId();
        $cart = DB::selectOne("SELECT id FROM carts WHERE session_id = ? LIMIT 1", [$sessionId]);
        if (!$cart) return back()->with('error', 'Cart is empty.');

        $items = DB::select("SELECT * FROM cart_items WHERE cart_id = ?", [$cart->id]);

        // Simple coupon logic
        $discount = 0;
        if($request->coupon === 'TRAVELEASY10') {
            $discount = 0.10; // 10% off
        }

        $grandTotal = 0;
        foreach($items as $item) {
            $grandTotal += $item->total_price;
        }

        $finalTotal = $grandTotal - ($grandTotal * $discount);

        $orderId = DB::table('orders')->insertGetId([
            'user_id' => Auth::id(),
            'total' => $grandTotal,
            'discount' => $grandTotal * $discount,
            'final_total' => $finalTotal,
            'coupon' => $request->coupon,
            'payment_method' => $request->payment_method,
            'status' => 'completed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        foreach ($items as $item) {
            DB::table('order_items')->insert([
                'order_id' => $orderId,
                'item_type' => $item->item_type,
                'item_id' => $item->item_id,
                'name' => $item->name,
                'meta' => json_encode(json_decode($item->meta)),
                'qty' => $item->qty,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total_price,
                'created_at' => now(),
            ]);
        }
        
        // Clear cart after order
        DB::delete("DELETE FROM cart_items WHERE cart_id = ?", [$cart->id]);
        

        return view('checkout.success', [
            'items' => $items,
            'grandTotal' => $grandTotal,
            'discount' => $discount * 100,
            'finalTotal' => $finalTotal
        ]);
    }
}
