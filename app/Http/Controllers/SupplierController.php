<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
public function index(Request $request)
{
    $search = $request->query('search');

    $suppliers = Supplier::when($search, function($query, $search) {
        $query->where('com_name', 'like', "%{$search}%")
              ->orWhere('contact_name', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
    })
    ->orderBy('sup_id', 'desc') // use your PK for ordering
    ->paginate(10);

    return view('suppliers.index', compact('suppliers', 'search'));
}


    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'com_name' => 'required|string|max:150',
            'contact_name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier added successfully');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'com_name' => 'required|string|max:150',
            'contact_name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier updated successfully');
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier deleted successfully');
    }
}
