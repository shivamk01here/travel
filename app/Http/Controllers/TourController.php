<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    public function all(Request $request)
    {
        // Optional: Add search/filter/sort here if needed
        $tours = DB::select("SELECT t.*, l.name as city_name FROM tours t JOIN locations l ON l.id = t.location_id ORDER BY t.id DESC");

        return view('tours.all', ['tours'=>$tours]);
    }

    //for ajax 
    public function search(Request $request)
    {
        $term = $request->get('term', '');
        $results = DB::select("SELECT id, name FROM locations WHERE name LIKE ? LIMIT 10", ["%$term%"]);

        return response()->json($results);
    }

    // List all tours for a city
    public function index(Request $request)
    {
        $city = $request->get('city', '');
        $location = DB::selectOne("SELECT * FROM locations WHERE name = ?", [$city]);
        if (!$location) {
            abort(404, 'City not found');
        }

        $tours = DB::select("SELECT * FROM tours WHERE location_id = ?", [$location->id]);

        return view('tours.index', compact('location', 'tours'));
    }

    public function show($id)
    {
        $tour = DB::selectOne("SELECT * FROM tours WHERE id = ?", [$id]);
        if (!$tour) {
            abort(404, 'Tour not found');
        }

        $images = DB::select("SELECT * FROM tour_images WHERE tour_id = ?", [$id]);
// dd($images, $tour);
        // Pass the tour and images to the view if neede
        return view('tours.show', compact('tour', 'images'));
    }
}
