<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query();
        if ($request->filled('search')) {
            $categories->where('name', 'like', '%' . $request->search . '%');
        }
        $categories = $categories->withCount('menuItems')->orderBy('id', 'desc')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function toggleStatus(Category $category)
    {
        $category->status = !$category->status;
        $category->save();
        return back()->with('success', 'Category status updated.');
    }

    public function bulkAction(Request $request)
    {
        $action = $request->input('bulk_action');
        $ids = $request->input('category_ids', []);
        if (empty($ids) || !$action) {
            return back()->with('error', 'No categories selected or action missing.');
        }
        if ($action === 'delete') {
            Category::whereIn('id', $ids)->delete();
            return back()->with('success', 'Selected categories deleted.');
        } elseif ($action === 'activate') {
            Category::whereIn('id', $ids)->update(['status' => 1]);
            return back()->with('success', 'Selected categories activated.');
        } elseif ($action === 'deactivate') {
            Category::whereIn('id', $ids)->update(['status' => 0]);
            return back()->with('success', 'Selected categories deactivated.');
        }
        return back()->with('error', 'Invalid bulk action.');
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'=>'required|unique:categories,name',
                'status'=>'required'
            ]);
            $category = Category::create($request->all());
            \Log::info('Category created', ['category_id' => $category->id, 'admin_id' => auth()->id()]);
            return redirect()->route('admin.categories.index')->with('success','Category added successfully.');
        } catch (\Exception $e) {
            \Log::error('Category creation failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to add category. Please try again.');
        }
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        try {
            $request->validate([
                'name'=>"required|unique:categories,name,$category->id",
                'status'=>'required'
            ]);
            $category->update($request->all());
            \Log::info('Category updated', ['category_id' => $category->id, 'admin_id' => auth()->id()]);
            return redirect()->route('admin.categories.index')->with('success','Category updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Category update failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to update category. Please try again.');
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            \Log::info('Category deleted', ['category_id' => $category->id, 'admin_id' => auth()->id()]);
            return redirect()->route('admin.categories.index')->with('success','Category deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Category deletion failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to delete category. Please try again.');
        }
    }
}
