<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $departments = Department::withCount('users')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('departments.index', compact('departments', 'search'));
    }


    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'location' => 'nullable|string|max:150',
        ]);

        Department::create($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully');
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'location' => 'nullable|string|max:150',
        ]);

        $department = Department::findOrFail($id);
        $department->update($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully');
    }

    public function destroy($id)
    {
        Department::findOrFail($id)->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully');
    }
}
