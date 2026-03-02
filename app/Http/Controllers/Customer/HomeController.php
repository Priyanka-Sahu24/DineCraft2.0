<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;

class HomeController extends Controller
{
    public function index()
    {

    $categories = Category::all();
    $popularItems = MenuItem::take(6)->get();

    return view('customer.home',
        compact('categories','popularItems'));
}
}
