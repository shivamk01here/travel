<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlightController extends Controller
{
    // Autocomplete (for both source & destination)
    public function search(Request $request)
    {
        $term = $request->get('term', '');
        $results = DB::select("SELECT id, name FROM locations WHERE name LIKE ? LIMIT 10", ["%$term%"]);

        return response()->json($results);
    }

    // List flights source → destination
    public function index($source, $destination)
    {
        $src = DB::selectOne("SELECT * FROM locations WHERE name = ?", [$source]);
        $dest = DB::selectOne("SELECT * FROM locations WHERE name = ?", [$destination]);

        if (!$src || !$dest) {
            abort(404, 'City not found');
        }

        $flights = DB::select("
            SELECT f.*, s.name as source_name, d.name as destination_name 
            FROM flights f
            JOIN locations s ON f.source_location_id = s.id
            JOIN locations d ON f.destination_location_id = d.id
            WHERE f.source_location_id = ? AND f.destination_location_id = ?
            ORDER BY f.price ASC
        ", [$src->id, $dest->id]);

        return view('flights.index', compact('src', 'dest', 'flights'));
    }

    // Show flight details
    public function show($id)
    {
        $flight = DB::selectOne("
            SELECT f.*, s.name as source_name, d.name as destination_name
            FROM flights f
            JOIN locations s ON f.source_location_id = s.id
            JOIN locations d ON f.destination_location_id = d.id
            WHERE f.id = ?
        ", [$id]);

        if (!$flight) {
            abort(404, 'Flight not found');
        }

        $details = DB::selectOne("SELECT * FROM flight_details WHERE flight_id = ?", [$id]);

        return view('flights.show', compact('flight', 'details'));
    }

    public function all(Request $request)
    {
        // Get all flights, join source and destination city names
        $flights = DB::select("
            SELECT f.*, s.name as source_name, d.name as destination_name
            FROM flights f
            JOIN locations s ON f.source_location_id = s.id
            JOIN locations d ON f.destination_location_id = d.id
            ORDER BY f.price ASC
        ");

        return view('flights.all', [ 'flights' => $flights ]);
    }

}
