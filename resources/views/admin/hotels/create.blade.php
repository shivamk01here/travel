@extends('layouts.admin')

@section('content')
<div class="flex">


    {{-- Main Content --}}
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold mb-6">Add New Hotel</h1>

        @if(session('success'))
            <div class="bg-green-200 p-4 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-200 p-4 rounded mb-4">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.hotel.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Location --}}
            <div>
                <label class="block font-medium">Location</label>
                <select name="location_id" class="w-full border rounded p-2">
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Basic Info --}}
            <div>
                <label class="block font-medium">Hotel Name</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block font-medium">Star Rating</label>
                <input type="number" name="star_rating" min="1" max="5" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block font-medium">Address</label>
                <input type="text" name="address" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block font-medium">Description</label>
                <textarea name="description" class="w-full border rounded p-2"></textarea>
            </div>
            <div>
                <label><input type="checkbox" name="is_featured"> Featured Hotel?</label>
            </div>

            {{-- Hotel Images --}}
            <div>
                <label class="block font-medium">Hotel Images (multiple)</label>
                <input type="file" name="hotel_images[]" multiple class="w-full border p-2">
            </div>

            {{-- Amenities --}}
            <div>
                <label class="block font-medium">Amenities</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($amenities as $amenity)
                        <label>
                            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}">
                            {{ $amenity->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Rooms --}}
            <div id="rooms-section">
                <h2 class="text-xl font-semibold">Rooms</h2>
                <button type="button" onclick="addRoom()" class="bg-blue-500 text-white px-3 py-1 rounded">+ Add Room</button>
            </div>

            <div>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Save Hotel</button>
            </div>
        </form>
    </div>
</div>

<script>
let roomIndex = 0;
function addRoom() {
    const roomSection = document.getElementById('rooms-section');
    const roomHtml = `
        <div class="border p-4 mt-4 space-y-2">
            <label>Room Name</label>
            <input type="text" name="rooms[${roomIndex}][name]" class="w-full border p-2">
            
            <label>Room Type</label>
            <select name="rooms[${roomIndex}][room_type_id]" class="w-full border p-2">
                @foreach($roomTypes as $rt)
                    <option value="{{ $rt->id }}">{{ $rt->label }}</option>
                @endforeach
            </select>

            <label>Description</label>
            <textarea name="rooms[${roomIndex}][description]" class="w-full border p-2"></textarea>

            <label>Price/Night</label>
            <input type="number" name="rooms[${roomIndex}][price_per_night]" class="w-full border p-2">

            <label>Max Adults</label>
            <input type="number" name="rooms[${roomIndex}][max_adults]" value="2" class="w-full border p-2">

            <label>Max Children</label>
            <input type="number" name="rooms[${roomIndex}][max_children]" value="1" class="w-full border p-2">

            <label><input type="checkbox" name="rooms[${roomIndex}][refundable]"> Refundable</label>
            <label><input type="checkbox" name="rooms[${roomIndex}][breakfast_included]"> Breakfast Included</label>

            <label>Available Inventory</label>
            <input type="number" name="rooms[${roomIndex}][available_inventory]" value="10" class="w-full border p-2">

            <label>Room Images</label>
            <input type="file" name="rooms[${roomIndex}][images][]" multiple class="w-full border p-2">
        </div>
    `;
    roomSection.insertAdjacentHTML('beforeend', roomHtml);
    roomIndex++;
}
</script>
@endsection
