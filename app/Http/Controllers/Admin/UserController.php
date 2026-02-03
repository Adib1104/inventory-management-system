<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('department')
            ->orderByRaw('approved_at IS NULL DESC')
            ->orderBy('name')
            ->paginate(10);


        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.users.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
            'department_id' => 'required|exists:departments,dept_id'
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'department_id' => $request->department_id
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User added');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $departments = Department::all();
        return view('admin.users.edit', compact('user', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,$id,user_id",
            'role' => 'required',
            'department_id' => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'role' => $request->role,
            'department_id' => $request->department_id
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted');
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,staff,user',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'role' => $request->role,
            'approved_at' => now(),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User approved successfully.');
    }

}
