<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Staff;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Display all deliveries
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $deliveries = Delivery::with(['order', 'deliveryPerson.user'])
                        ->latest()
                        ->get();

        return view('admin.deliveries.index', compact('deliveries'));
    }

    /*
    |--------------------------------------------------------------------------
    | Show create form
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $orders = Order::where('order_type', 'Delivery')->get();

        $deliveryPersons = Staff::where('designation', 'delivery')
                                ->where('status', 'active')
                                ->get();

        return view('admin.deliveries.create', compact('orders', 'deliveryPersons'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store delivery
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'delivery_person_id' => 'required|exists:staff,id',
            'status' => 'required|in:assigned,picked_up,on_the_way,delivered,cancelled',
            'estimated_time' => 'nullable|date',
        ]);

        Delivery::create([
            'order_id' => $request->order_id,
            'delivery_person_id' => $request->delivery_person_id,
            'status' => $request->status,
            'estimated_time' => $request->estimated_time,
        ]);

        return redirect()->route('admin.deliveries.index')
                ->with('success', 'Delivery assigned successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Show edit form
    |--------------------------------------------------------------------------
    */
    public function edit(Delivery $delivery)
    {
        $orders = Order::where('order_type', 'Delivery')->get();

        $deliveryPersons = Staff::where('designation', 'delivery')
                                ->where('status', 'active')
                                ->get();

        return view('admin.deliveries.edit',
            compact('delivery', 'orders', 'deliveryPersons'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update delivery
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Delivery $delivery)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'delivery_person_id' => 'required|exists:staff,id',
            'status' => 'required|in:assigned,picked_up,on_the_way,delivered,cancelled',
            'estimated_time' => 'nullable|date',
        ]);

        $delivery->update([
            'order_id' => $request->order_id,
            'delivery_person_id' => $request->delivery_person_id,
            'status' => $request->status,
            'estimated_time' => $request->estimated_time,
        ]);

        return redirect()->route('admin.deliveries.index')
                ->with('success', 'Delivery updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete delivery
    |--------------------------------------------------------------------------
    */
    public function destroy(Delivery $delivery)
    {
        $delivery->delete();

        return redirect()->route('admin.deliveries.index')
                ->with('success', 'Delivery deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Update Live Location (For Map Tracking)
    |--------------------------------------------------------------------------
    */
    public function updateLocation(Request $request, Delivery $delivery)
    {
        $request->validate([
            'current_latitude' => 'required',
            'current_longitude' => 'required',
        ]);

        $delivery->update([
            'current_latitude' => $request->current_latitude,
            'current_longitude' => $request->current_longitude,
        ]);

        return response()->json(['success' => true]);
    }
}
