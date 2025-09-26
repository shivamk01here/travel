<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CartController extends Controller
{
    protected function getOrCreateCartId(string $sessionId)
    {
        $cart = DB::selectOne("SELECT id FROM carts WHERE session_id = ? LIMIT 1", [$sessionId]);
        if ($cart) return $cart->id;

        DB::insert("INSERT INTO carts (session_id, created_at, updated_at) VALUES (?, NOW(), NOW())", [$sessionId]);
        return DB::getPdo()->lastInsertId();
    }

    public function addHotelRoom(Request $request)
    {
        $request->validate([
            'room_id'   => 'required|integer',
            'check_in'  => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'adults'    => 'required|integer|min:1',
            'children'  => 'nullable|integer|min:0',
        ]);

        $room = DB::selectOne("
            SELECT r.*, h.name AS hotel_name
            FROM hotel_rooms r
            JOIN hotels h ON h.id = r.hotel_id
            WHERE r.id = ?
            LIMIT 1
        ", [$request->room_id]);

        if (!$room) abort(404, 'Room not found');

        $nights = Carbon::parse($request->check_in)->diffInDays(Carbon::parse($request->check_out));
        if ($nights <= 0) return back()->with('error', 'Minimum 1 night');

        $base = $room->price_per_night * $nights;

        $fee = DB::selectOne("SELECT percent, fixed FROM service_fees WHERE service = 'hotel' LIMIT 1");
        $svcPercent = $fee ? (float)$fee->percent : 0;
        $svcFixed   = $fee ? (float)$fee->fixed : 0;

        $serviceFee = round(($base * $svcPercent / 100) + $svcFixed, 2);
        $total = $base + $serviceFee;

        $meta = [
            'check_in'  => $request->check_in,
            'check_out' => $request->check_out,
            'nights'    => $nights,
            'adults'    => (int)$request->adults,
            'children'  => (int)$request->children,
            'refundable'=> (bool)$room->refundable,
            'breakfast' => (bool)$room->breakfast_included,
            'service_fee_percent' => $svcPercent,
            'service_fee_fixed'   => $svcFixed,
        ];

        $sessionId = $request->session()->getId();
        $cartId = $this->getOrCreateCartId($sessionId);

        DB::insert("
            INSERT INTO cart_items (cart_id, item_type, item_id, name, meta, qty, unit_price, total_price, created_at)
            VALUES (?, 'hotel_room', ?, ?, ?, 1, ?, ?, NOW())
        ", [
            $cartId,
            $room->id,
            $room->hotel_name . ' - ' . $room->name,
            json_encode($meta),
            $base,
            $total
        ]);

        return redirect()->route('cart.show')->with('success', 'Room added to cart');
    }

    public function show(Request $request)
{
    $sessionId = $request->session()->getId();
    $cart = DB::selectOne("SELECT id FROM carts WHERE session_id = ? LIMIT 1", [$sessionId]);
    $items = [];

    if ($cart) {
        $rawItems = DB::select("SELECT * FROM cart_items WHERE cart_id = ? ORDER BY id DESC", [$cart->id]);

        foreach ($rawItems as $item) {
            $item->meta = $item->meta ? json_decode($item->meta, true) : [];

            // Prepare detailed display for each item type
            switch ($item->item_type) {
                case 'hotel_room':
                    $item->display_name = $item->name;
                    $item->details = [
                        'Check-in' => $item->meta['check_in'] ?? '',
                        'Check-out' => $item->meta['check_out'] ?? '',
                        'Nights' => $item->meta['nights'] ?? '',
                        'Adults' => $item->meta['adults'] ?? '',
                        'Children' => $item->meta['children'] ?? '',
                        'Breakfast' => ($item->meta['breakfast'] ?? false) ? 'Yes' : 'No',
                        'Refundable' => ($item->meta['refundable'] ?? false) ? 'Yes' : 'No',
                        'Service Fee %' => $item->meta['service_fee_percent'] ?? 0,
                        'Service Fee Fixed' => $item->meta['service_fee_fixed'] ?? 0,
                    ];
                    break;

                case 'tour':
                    $item->display_name = $item->name;
                    $item->details = [
                        'Adults' => $item->meta['adults'] ?? 0,
                        'Children' => $item->meta['children'] ?? 0,
                        'Total Passengers' => ($item->meta['adults'] ?? 0) + ($item->meta['children'] ?? 0),
                        'Service Fee %' => $item->meta['service_fee_percent'] ?? 0,
                        'Service Fee Fixed' => $item->meta['service_fee_fixed'] ?? 0,
                    ];
                    break;

                case 'flight':
                    $item->display_name = $item->name;
                    $item->details = [
                        'From' => $item->meta['from'] ?? '',
                        'To' => $item->meta['to'] ?? '',
                        'Departure' => $item->meta['departure'] ?? '',
                        'Arrival' => $item->meta['arrival'] ?? '',
                        'Adults' => $item->meta['adults'] ?? 0,
                        'Children' => $item->meta['children'] ?? 0,
                        'Cabin Class' => $item->meta['cabin_class'] ?? 'Economy',
                        'Service Fee %' => $item->meta['service_fee_percent'] ?? 0,
                        'Service Fee Fixed' => $item->meta['service_fee_fixed'] ?? 0,
                    ];
                    break;
            }

            $items[] = $item;
        }
    }

    // dd($items);

    return view('cart.show', compact('items'));
}



    public function remove($id)
    {
        DB::delete("DELETE FROM cart_items WHERE id = ?", [$id]);
        return redirect()->route('cart.show')->with('success', 'Item removed from cart');
    }


    public function addFlight(Request $request)
    {
        $request->validate([
            'flight_id' => 'required|integer',
            'adults'    => 'required|integer|min:1',
            'children'  => 'nullable|integer|min:0',
        ]);

        $flight = DB::selectOne("
            SELECT f.*, sl.name AS source_name, dl.name AS dest_name
            FROM flights f
            JOIN locations sl ON sl.id = f.source_location_id
            JOIN locations dl ON dl.id = f.destination_location_id
            WHERE f.id = ? LIMIT 1
        ", [$request->flight_id]);

        if (!$flight) abort(404, 'Flight not found');

        $totalPassengers = $request->adults + ($request->children ?? 0);
        $base = $flight->price * $totalPassengers;

        $fee = DB::selectOne("SELECT percent, fixed FROM service_fees WHERE service = 'flight' LIMIT 1");
        $svcPercent = $fee ? (float)$fee->percent : 0;
        $svcFixed   = $fee ? (float)$fee->fixed : 0;
        $serviceFee = round(($base * $svcPercent / 100) + $svcFixed, 2);
        $total = $base + $serviceFee;

        $meta = [
            'from'      => $flight->source_name,
            'to'        => $flight->dest_name,
            'departure' => $flight->departure_time,
            'arrival'   => $flight->arrival_time,
            'airline'   => $flight->airline,
            'flight_no' => $flight->flight_number,
            'adults'    => (int)$request->adults,
            'children'  => (int)($request->children ?? 0),
            'service_fee_percent'=>$svcPercent,
            'service_fee_fixed'=>$svcFixed
        ];

        $sessionId = $request->session()->getId();
        $cartId = $this->getOrCreateCartId($sessionId);

        DB::insert("
            INSERT INTO cart_items (cart_id, item_type, item_id, name, meta, qty, unit_price, total_price, created_at)
            VALUES (?, 'flight', ?, ?, ?, 1, ?, ?, NOW())
        ", [
            $cartId,
            $flight->id,
            $flight->airline . ' ' . $flight->flight_number,
            json_encode($meta),
            $base,
            $total
        ]);

        return redirect()->route('cart.show')->with('success', 'Flight added to cart');
    }


    public function addTour(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|integer',
            'adults'  => 'required|integer|min:1',
            'children'=> 'nullable|integer|min:0',
        ]);

        $tour = DB::selectOne("SELECT * FROM tours WHERE id = ? LIMIT 1", [$request->tour_id]);
        if (!$tour) abort(404, 'Tour not found');

        $totalPassengers = $request->adults + ($request->children ?? 0);
        $base = $tour->price * $totalPassengers;

        $fee = DB::selectOne("SELECT percent, fixed FROM service_fees WHERE service = 'tour' LIMIT 1");
        $svcPercent = $fee ? (float)$fee->percent : 0;
        $svcFixed   = $fee ? (float)$fee->fixed : 0;
        $serviceFee = round(($base * $svcPercent / 100) + $svcFixed, 2);
        $total = $base + $serviceFee;

        $meta = [
            'adults' => (int)$request->adults,
            'children' => (int)($request->children ?? 0),
            'service_fee_percent' => $svcPercent,
            'service_fee_fixed'   => $svcFixed,
        ];

        $sessionId = $request->session()->getId();
        $cartId = $this->getOrCreateCartId($sessionId);

        DB::insert("
            INSERT INTO cart_items (cart_id, item_type, item_id, name, meta, qty, unit_price, total_price, created_at)
            VALUES (?, 'tour', ?, ?, ?, 1, ?, ?, NOW())
        ", [
            $cartId,
            $tour->id,
            $tour->name,
            json_encode($meta),
            $base,
            $total
        ]);

        return redirect()->route('cart.show')->with('success', 'Tour added to cart');
    }
    
}
