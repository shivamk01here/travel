<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->query('city');
        if (!$city) abort(404, 'City is required');

        // Base where + bindings
        $where = ["l.slug = ?"];
        $binds = [$city];

        // Filters
        if ($ratingMin = $request->query('rating_min')) {
            $where[] = "h.avg_rating >= ?";
            $binds[] = (float)$ratingMin;
        }

        $priceMin = $request->query('price_min');
        $priceMax = $request->query('price_max');

        $amenities = $request->query('amenities', []); // array of amenity ids or names
        $roomTypes = $request->query('types', []);     // array of room_type codes

        $whereSql = implode(' AND ', $where);

        // Build core SQL (compute min_price with subquery)
        $sql = "
            SELECT
              h.id, h.slug, h.name, h.star_rating, h.avg_rating, h.address,
              l.name AS city_name,
              (SELECT MIN(r.price_per_night) FROM hotel_rooms r WHERE r.hotel_id = h.id) AS min_price,
              (SELECT url FROM hotel_images i WHERE i.hotel_id = h.id AND i.is_primary = 1 LIMIT 1) AS primary_image
            FROM hotels h
            JOIN locations l ON l.id = h.location_id
        ";

        // Amenity filter via EXISTS
        if (!empty($amenities)) {
            $placeholders = implode(',', array_fill(0, count($amenities), '?'));
            $sql .= "
              WHERE $whereSql
              AND EXISTS (
                SELECT 1 FROM hotel_amenities ha
                JOIN amenities a ON a.id = ha.amenity_id OR a.name = ha.amenity_id
                WHERE ha.hotel_id = h.id
                  AND (ha.amenity_id IN ($placeholders) OR a.name IN ($placeholders))
              )
            ";
            // push binds twice (ids or names)
            $binds = array_merge($binds, $amenities, $amenities);
        } else {
            $sql .= " WHERE $whereSql ";
        }

        // Room type filter via EXISTS
        if (!empty($roomTypes)) {
            $placeholders = implode(',', array_fill(0, count($roomTypes), '?'));
            $sql .= "
              AND EXISTS (
                SELECT 1
                FROM hotel_rooms r
                JOIN room_types rt ON rt.id = r.room_type_id
                WHERE r.hotel_id = h.id
                  AND rt.code IN ($placeholders)
              )
            ";
            $binds = array_merge($binds, $roomTypes);
        }

        // Price filter via HAVING (because min_price is a subquery)
        $having = [];
        if ($priceMin !== null && $priceMin !== '') {
            $having[] = "min_price >= ?";
            $binds[] = (float)$priceMin;
        }
        if ($priceMax !== null && $priceMax !== '') {
            $having[] = "min_price <= ?";
            $binds[] = (float)$priceMax;
        }
        if (!empty($having)) {
            $sql .= " HAVING " . implode(' AND ', $having);
        }

        // Sorting
        $sort = $request->query('sort', 'rating_desc');
        switch ($sort) {
            case 'price_asc':  $sql .= " ORDER BY min_price ASC "; break;
            case 'price_desc': $sql .= " ORDER BY min_price DESC "; break;
            case 'rating_asc': $sql .= " ORDER BY h.avg_rating ASC "; break;
            default:           $sql .= " ORDER BY h.avg_rating DESC "; break;
        }

        // Simple pagination (manual)
        $page = max(1, (int)$request->query('page', 1));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $sql .= " LIMIT $perPage OFFSET $offset ";

        $hotels = DB::select($sql, $binds);

        // city info
        $cityInfo = DB::selectOne("SELECT name, slug FROM locations WHERE slug = ? LIMIT 1", [$city]);

        return view('hotels.index', compact('hotels', 'cityInfo'));
    }

    public function all(Request $request)
    {
        // Optional basic filters for listing all hotels if you want
        $sort = $request->query('sort', 'rating_desc');
        $where = [];
        $binds = [];

        // Sample rating filter (optional)
        if ($ratingMin = $request->query('rating_min')) {
            $where[] = "h.avg_rating >= ?";
            $binds[] = (float)$ratingMin;
        }

        $whereSql = $where ? (" WHERE " . implode(" AND ", $where)) : "";

        // Main SQL – get all hotels, min price, city name, primary image
        $sql = "
            SELECT
                h.id, h.slug, h.name, h.star_rating, h.avg_rating, h.address,
                l.name AS city_name,
                (SELECT MIN(r.price_per_night) FROM hotel_rooms r WHERE r.hotel_id = h.id) AS min_price,
                (SELECT url FROM hotel_images i WHERE i.hotel_id = h.id AND i.is_primary = 1 LIMIT 1) AS primary_image
            FROM hotels h
            JOIN locations l ON l.id = h.location_id
            $whereSql
        ";

        // Sorting
        switch ($sort) {
            case 'price_asc':  $sql .= " ORDER BY min_price ASC "; break;
            case 'price_desc': $sql .= " ORDER BY min_price DESC "; break;
            case 'rating_asc': $sql .= " ORDER BY h.avg_rating ASC "; break;
            default:           $sql .= " ORDER BY h.avg_rating DESC "; break;
        }

        // Pagination
        $page = max(1, (int)$request->query('page', 1));
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        $sql .= " LIMIT $perPage OFFSET $offset ";

        $hotels = DB::select($sql, $binds);

        // For filter sidebars (Amenities, Room Types etc.)
        $roomTypeOptions = DB::select("SELECT code, label FROM room_types ORDER BY label");

        return view('hotels.index', [
            'hotels' => $hotels,
            'cityInfo' => null,
            'roomTypeOptions' => $roomTypeOptions,
            'allMode' => true // To help your blade customize text/filters
        ]);
    }


    public function show($slug)
    {
        $hotel = DB::selectOne("
            SELECT h.*, l.name AS city_name, l.slug AS city_slug
            FROM hotels h
            JOIN locations l ON l.id = h.location_id
            WHERE h.slug = ?
            LIMIT 1
        ", [$slug]);

        if (!$hotel) abort(404);

        $images = DB::select("SELECT url, alt FROM hotel_images WHERE hotel_id = ? ORDER BY is_primary DESC, id ASC", [$hotel->id]);

        $rooms = DB::select("
            SELECT r.*,
            (SELECT url FROM room_images ri WHERE ri.room_id = r.id AND ri.is_primary = 1 LIMIT 1) AS primary_image
            FROM hotel_rooms r
            WHERE r.hotel_id = ?
            ORDER BY r.price_per_night ASC
        ", [$hotel->id]);

        // dd($hotel, $images, $rooms);
        return view('hotels.show', compact('hotel', 'images', 'rooms'));
    }
}
