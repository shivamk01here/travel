<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function create()
    {
        $locations = DB::table('locations')->get();
        $amenities = DB::table('amenities')->get();
        $roomTypes = DB::table('room_types')->get();

        return view('admin.hotels.create', compact('locations', 'amenities', 'roomTypes'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Insert Hotel
            $hotelId = DB::table('hotels')->insertGetId([
                'location_id' => $request->location_id,
                'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . time(),
                'name' => $request->name,
                'star_rating' => $request->star_rating,
                'avg_rating' => $request->avg_rating ?? 0,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'description' => $request->description,
                'is_featured' => $request->is_featured ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Upload Hotel Images
            if ($request->hasFile('hotel_images')) {
                foreach ($request->file('hotel_images') as $index => $file) {
                    $path = $file->store('hotel_images', 'public');
                    DB::table('hotel_images')->insert([
                        'hotel_id' => $hotelId,
                        'url' => $path,
                        'alt' => $request->name . ' image ' . ($index + 1),
                        'is_primary' => $index == 0 ? 1 : 0,
                    ]);
                }
            }

            // Insert Amenities
            if ($request->has('amenities')) {
                foreach ($request->amenities as $amenityId) {
                    DB::table('hotel_amenities')->insert([
                        'hotel_id' => $hotelId,
                        'amenity_id' => $amenityId,
                    ]);
                }
            }

            // Insert Rooms
            if ($request->has('rooms')) {
                foreach ($request->rooms as $room) {
                    $roomId = DB::table('hotel_rooms')->insertGetId([
                        'hotel_id' => $hotelId,
                        'room_type_id' => $room['room_type_id'],
                        'name' => $room['name'],
                        'description' => $room['description'],
                        'price_per_night' => $room['price_per_night'],
                        'max_adults' => $room['max_adults'],
                        'max_children' => $room['max_children'],
                        'refundable' => isset($room['refundable']) ? 1 : 0,
                        'breakfast_included' => isset($room['breakfast_included']) ? 1 : 0,
                        'available_inventory' => $room['available_inventory'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Upload Room Images
                    if (isset($room['images'])) {
                        foreach ($room['images'] as $i => $file) {
                            $path = $file->store('room_images', 'public');
                            DB::table('room_images')->insert([
                                'room_id' => $roomId,
                                'url' => $path,
                                'alt' => $room['name'] . ' image ' . ($i + 1),
                                'is_primary' => $i == 0 ? 1 : 0,
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.hotel.create')->with('success', 'Hotel added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
