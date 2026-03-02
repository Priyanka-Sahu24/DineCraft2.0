<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = MenuItem::query();

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $menuItems = $query->get();

        return view('customer.menu', compact('menuItems','categories'));
    }
}