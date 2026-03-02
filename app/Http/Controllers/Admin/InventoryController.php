<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        $items = Inventory::latest()->get();
        return view('admin.inventory.index', compact('items'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'item_name' => 'required|string|max:255',
                'unit' => 'required|string|max:50',
                'quantity' => 'required|numeric|min:0',
                'low_alert' => 'required|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'note' => 'nullable|string'
            ]);

            $item = Inventory::create($request->all());
            \Log::info('Inventory item created', ['inventory_id' => $item->id, 'admin_id' => auth()->id()]);

            return redirect()->route('admin.inventory.index')
                ->with('success', 'Item added successfully.');
        } catch (\Exception $e) {
            \Log::error('Inventory item creation failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to add item. Please try again.');
        }
    }

    public function edit(Inventory $inventory)
    {
        return view('admin.inventory.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        try {
            $request->validate([
                'item_name' => 'required|string|max:255',
                'unit' => 'required|string|max:50',
                'quantity' => 'required|numeric|min:0',
                'low_alert' => 'required|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'note' => 'nullable|string'
            ]);

            $inventory->update($request->all());
            \Log::info('Inventory item updated', ['inventory_id' => $inventory->id, 'admin_id' => auth()->id()]);

            return redirect()->route('admin.inventory.index')
                ->with('success', 'Item updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Inventory item update failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to update item. Please try again.');
        }
    }

    public function destroy(Inventory $inventory)
    {
        try {
            $inventory->delete();
            \Log::info('Inventory item deleted', ['inventory_id' => $inventory->id, 'admin_id' => auth()->id()]);
            return redirect()->route('admin.inventory.index')
                ->with('success', 'Item deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Inventory item deletion failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to delete item. Please try again.');
        }
    }
}
