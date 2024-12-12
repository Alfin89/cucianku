<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan semua pesanan
    public function index()
    {
        return response()->json(Order::with('user')->get(), 200);
    }

    // Menampilkan detail pesanan
    public function show($id)
    {
        $order = Order::with('user')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order, 200);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'laundry_type' => 'required|string',
            'status' => 'in:pending,processing,completed,cancelled',
            'total_price' => 'required|numeric',
            'pickup_date' => 'required|date',
        ]);
    
        $order = Order::create($validated);
        return response()->json($order, 201);
    }

    // Mengupdate pesanan
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $validated = $request->validate([
            'laundry_type' => 'string',
            'status' => 'in:pending,processing,completed,cancelled',
            'total_price' => 'numeric',
            'pickup_date' => 'date',
            'delivery_date' => 'date|nullable',
        ]);

        $order->update($validated);

        return response()->json($order, 200);
    }

    // Menghapus pesanan
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted'], 200);
    }
}
