<?php

namespace App\Http\Controllers;

use App\Models\Laundry;
use Illuminate\Http\Request;

class LaundryController extends Controller
{
        // Menampilkan semua data laundries
        public function index()
        {
            return response()->json(Laundry::all(), 200);
        }
    
        // Menampilkan detail laundry berdasarkan ID
        public function show($id)
        {
            $laundry = Laundry::find($id);
    
            if (!$laundry) {
                return response()->json(['message' => 'Laundry tidak ditemukan'], 404);
            }
    
            return response()->json($laundry, 200);
        }
    
        // Menyimpan data laundry baru
        public function store(Request $request)
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string',
                'phone_number' => 'required|string|max:20',
                'email' => 'required|email|unique:laundries,email',
            ]);
    
            $laundry = Laundry::create($validated);
    
            return response()->json($laundry, 201);
        }
    
        // Memperbarui data laundry
        public function update(Request $request, $id)
        {
            $laundry = Laundry::find($id);
    
            if (!$laundry) {
                return response()->json(['message' => 'Laundry tidak ditemukan'], 404);
            }
    
            $validated = $request->validate([
                'name' => 'string|max:255',
                'address' => 'string',
                'phone_number' => 'string|max:20',
                'email' => 'email|unique:laundries,email,' . $id,
            ]);
    
            $laundry->update($validated);
    
            return response()->json($laundry, 200);
        }
    
        // Menghapus data laundry
        public function destroy($id)
        {
            $laundry = Laundry::find($id);
    
            if (!$laundry) {
                return response()->json(['message' => 'Laundry tidak ditemukan'], 404);
            }
    
            $laundry->delete();
    
            return response()->json(['message' => 'Hapus Laundry'], 200);
        }
}
