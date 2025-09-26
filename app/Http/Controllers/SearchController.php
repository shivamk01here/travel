<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function cities(Request $request)
    {
        $q = trim($request->query('q', ''));
        $type = $request->query('type', 'hotel'); // future: tour/flight

        if ($q === '') return response()->json([]);

        // Only locations that actually have hotels (for now)
        $rows = DB::select("
            SELECT l.name, l.slug
            FROM locations l
            WHERE EXISTS (SELECT 1 FROM hotels h WHERE h.location_id = l.id)
              AND l.name LIKE ?
            ORDER BY l.name
            LIMIT 10
        ", ["{$q}%"]);

        return response()->json($rows);
    }
}
