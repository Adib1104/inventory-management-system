<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display all items (ALL users)
     */
    public function index(Request $request)
    {
        $search     = $request->query('search');
        $sort       = $request->query('sort', 'name');      // default sort column
        $direction  = $request->query('direction', 'asc');  // default direction

        // Allowed sortable columns (security)
        $allowedSorts = ['name', 'category_id', 'quantity'];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'name';
        }

        $items = Item::with(['category', 'suppliers'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhereHas('category', fn ($q) =>
                            $q->where('name', 'like', "%{$search}%"))
                      ->orWhereHas('suppliers', fn ($q) =>
                            $q->where('com_name', 'like', "%{$search}%"));
            })
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString(); // keeps search & sort during pagination

        return view('items.index', compact(
            'items', 'search', 'sort', 'direction'
        ));
    }

    /**
     * Show create item form (Admin & Staff only)
     */
    public function create()
    {
        $this->authorizeStaff();

        $categories = Category::orderBy('name')->get();
        $suppliers  = Supplier::orderBy('com_name')->get();

        return view('items.create', compact('categories', 'suppliers'));
    }

    /**
     * Store new item (Admin & Staff only)
     */
    public function store(Request $request)
    {
        $this->authorizeStaff();

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'quantity'       => 'required|integer|min:0',
            'category_id'    => 'required|exists:categories,category_id',
            'supplier_ids'   => 'nullable|array',
            'supplier_ids.*' => 'exists:suppliers,sup_id',
        ]);

        $item = Item::create($request->only(
            'name', 'description', 'quantity', 'category_id'
        ));

        if (!empty($validated['supplier_ids'])) {
            $item->suppliers()->attach($validated['supplier_ids']);
        }

        return redirect()
            ->route('items.index')
            ->with('success', 'Item created successfully.');
    }

    /**
     * Show edit form (Admin & Staff only)
     */
    public function edit(Item $item)
    {
        $this->authorizeStaff();

        $categories = Category::orderBy('name')->get();
        $suppliers  = Supplier::orderBy('com_name')->get();

        return view('items.edit', compact('item', 'categories', 'suppliers'));
    }

    /**
     * Update item (Admin & Staff only)
     */
    public function update(Request $request, Item $item)
    {
        $this->authorizeStaff();

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,category_id',
            'quantity'       => 'required|integer|min:0',
            'supplier_ids'   => 'nullable|array',
            'supplier_ids.*' => 'exists:suppliers,sup_id',
        ]);

        $item->update($request->only(
            'name', 'category_id', 'quantity'
        ));

        $item->suppliers()->sync($validated['supplier_ids'] ?? []);

        return redirect()
            ->route('items.index')
            ->with('success', 'Item updated successfully.');
    }

    /**
     * Delete item (Admin only)
     */
    public function destroy(Item $item)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isStaff()) {
            abort(403, 'Only admin and staff can delete items.');
        }

        $item->delete(); // soft delete

        return redirect()
            ->route('items.index')
        ->with('success', 'Item removed from inventory. Booking records are preserved.');
    }


    /**
     * Helper function for staff/admin authorization
     */
    private function authorizeStaff()
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isStaff()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
