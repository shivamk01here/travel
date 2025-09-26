<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Top 4 featured / highest rated hotels
        $hotels = DB::select("
            SELECT h.*, l.name AS city_name,
              (SELECT MIN(price_per_night) FROM hotel_rooms r WHERE r.hotel_id = h.id) AS min_price
            FROM hotels h
            JOIN locations l ON l.id = h.location_id
            ORDER BY h.is_featured DESC, h.avg_rating DESC
            LIMIT 4
        ");

        // Cities to show in hero (any city that has hotels)
        $cities = DB::select("
            SELECT DISTINCT l.name, l.slug
            FROM locations l
            JOIN hotels h ON h.location_id = l.id
            ORDER BY l.name ASC
        ");

        // Get all locations for autocomplete
        $allLocations = DB::select("
            SELECT DISTINCT l.name, l.slug, l.id
            FROM locations l
            ORDER BY l.name ASC
        ");

        $topTours = DB::select("SELECT * FROM tours ORDER BY rating DESC LIMIT 4");
        $latestBlogs = DB::select("SELECT * FROM blogs ORDER BY published_at DESC LIMIT 4");
        $faqs = DB::select("SELECT * FROM faqs ORDER BY id ASC");

        return view('home', compact('hotels', 'cities', 'topTours', 'latestBlogs', 'faqs', 'allLocations'));
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('q');
        $type = $request->get('type', 'hotel');
        
        if (strlen($query) < 1) {
            return response()->json([]);
        }

        $locations = DB::select("
            SELECT DISTINCT l.name, l.slug, l.id
            FROM locations l
            WHERE l.name LIKE ?
            ORDER BY 
                CASE WHEN l.name LIKE ? THEN 1 ELSE 2 END,
                l.name ASC
            LIMIT 10
        ", ['%' . $query . '%', $query . '%']);

        return response()->json($locations);
    }
}