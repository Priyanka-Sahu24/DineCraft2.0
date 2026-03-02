<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MenuItemController extends Controller
{
    // ==============================
    // Display all menu items
    // ==============================
    public function index(Request $request)
    {
        $menuItems = MenuItem::with('category');
        if ($request->filled('search')) {
            $search = $request->search;
            $menuItems->where(function($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhereHas('category', function($q) use ($search) {
                          $q->where('name', 'like', "%$search%");
                      });
            });
        }
        $menuItems = $menuItems->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.menu-items.index', compact('menuItems'));
    }

    public function bulkAction(Request $request)
    {
        $action = $request->input('bulk_action');
        $ids = $request->input('menu_item_ids', []);
        if (empty($ids) || !$action) {
            return back()->with('error', 'No menu items selected or action missing.');
        }
        if ($action === 'delete') {
            MenuItem::whereIn('id', $ids)->delete();
            return back()->with('success', 'Selected menu items deleted.');
        } elseif ($action === 'activate') {
            MenuItem::whereIn('id', $ids)->update(['is_available' => 1]);
            return back()->with('success', 'Selected menu items activated.');
        } elseif ($action === 'deactivate') {
            MenuItem::whereIn('id', $ids)->update(['is_available' => 0]);
            return back()->with('success', 'Selected menu items deactivated.');
        }
        return back()->with('error', 'Invalid bulk action.');
    }

    // ==============================
    // Show create form
    // ==============================
    public function create()
    {
        $categories = Category::where('status', 1)->get();

        return view('admin.menu-items.create', compact('categories'));
    }

    // ==============================
    // Store new menu item
    // ==============================
    public function store(Request $request)
    {
        try {
            $request->validate([
                'category_id'     => 'required|exists:categories,id',
                'name'            => 'required|string|max:255',
                'description'     => 'nullable|string',
                'price'           => 'required|numeric|min:0',
                'preparation_time'=> 'nullable|integer|min:1',
                'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'is_available'    => 'required|boolean',
            ]);

            $menuItem = new MenuItem();
            $menuItem->category_id      = $request->category_id;
            $menuItem->name             = $request->name;
            $menuItem->description      = $request->description;
            $menuItem->price            = $request->price;
            $menuItem->preparation_time = $request->preparation_time;
            $menuItem->is_available     = $request->is_available;

            if ($request->hasFile('image')) {
                $menuItem->image = $request->file('image')->store('menu', 'public');
            }

            $menuItem->save();
            \Log::info('Menu item created', ['menu_item_id' => $menuItem->id, 'admin_id' => auth()->id()]);
            return redirect()
                ->route('admin.menu-items.index')
                ->with('success', 'Menu item added successfully.');
        } catch (\Exception $e) {
            \Log::error('Menu item creation failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to add menu item. Please try again.');
        }
    }

    // ==============================
    // Show edit form
    // ==============================
    public function edit(MenuItem $menuItem)
    {
        $categories = Category::where('status', 1)->get();

        return view('admin.menu-items.edit', compact('menuItem', 'categories'));
    }

    // ==============================
    // Update menu item
    // ==============================
    public function update(Request $request, MenuItem $menuItem)
    {
        try {
            $request->validate([
                'category_id'     => 'required|exists:categories,id',
                'name'            => 'required|string|max:255',
                'description'     => 'nullable|string',
                'price'           => 'required|numeric|min:0',
                'preparation_time'=> 'nullable|integer|min:1',
                'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'is_available'    => 'required|boolean',
            ]);

            $menuItem->category_id      = $request->category_id;
            $menuItem->name             = $request->name;
            $menuItem->description      = $request->description;
            $menuItem->price            = $request->price;
            $menuItem->preparation_time = $request->preparation_time;
            $menuItem->is_available     = $request->is_available;

            if ($request->hasFile('image')) {
                if ($menuItem->image && Storage::disk('public')->exists($menuItem->image)) {
                    Storage::disk('public')->delete($menuItem->image);
                }
                $menuItem->image = $request->file('image')->store('menu', 'public');
            }

            $menuItem->save();
            \Log::info('Menu item updated', ['menu_item_id' => $menuItem->id, 'admin_id' => auth()->id()]);
            return redirect()
                ->route('admin.menu-items.index')
                ->with('success', 'Menu item updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Menu item update failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to update menu item. Please try again.');
        }
    }

    // ==============================
    // Delete menu item
    // ==============================
    public function destroy(MenuItem $menuItem)
    {
        try {
            if ($menuItem->image && Storage::disk('public')->exists($menuItem->image)) {
                Storage::disk('public')->delete($menuItem->image);
            }
            $menuItem->delete();
            \Log::info('Menu item deleted', ['menu_item_id' => $menuItem->id, 'admin_id' => auth()->id()]);
            return redirect()
                ->route('admin.menu-items.index')
                ->with('success', 'Menu item deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Menu item deletion failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to delete menu item. Please try again.');
        }
    }

    // ==============================
    // Toggle menu item availability (AJAX)
    // ==============================
    public function toggleAvailability(Request $request, $id)
    {
        try {
            $menuItem = MenuItem::findOrFail($id);
            $menuItem->is_available = $request->is_available ? 1 : 0;
            $menuItem->save();
            \Log::info('Menu item availability toggled', ['menu_item_id' => $menuItem->id, 'admin_id' => auth()->id(), 'is_available' => $menuItem->is_available]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Menu item availability toggle failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return response()->json(['success' => false], 500);
        }
    }
}
