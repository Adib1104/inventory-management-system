<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $totalUsers = User::where('role', '!=', 'supplier')->count();

        // Fetch categories with item counts for bar chart
        $categories = Category::withCount('items')->get();

        // Fetch all items for doughnut chart (total percentage per item)
        $allItems = Item::select('name', 'quantity')->get();

        return view('dashboard', [
            'totalItems' => $totalItems,
            'totalCategories' => $totalCategories,
            'totalSuppliers' => $totalSuppliers,
            'totalUsers' => $totalUsers,
            'categories' => $categories,
            'allItems' => $allItems // pass all items to view
        ]);
    }
}
