@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')

<form method="POST" action="{{ route('admin.users.update',$user->user_id) }}"
      style="max-width:520px;background:white;padding:20px;border-radius:12px;">
@csrf @method('PUT')

<input name="name" value="{{ $user->name }}" required
       style="width:100%;padding:10px;border:1px solid #cbd5f5;border-radius:8px;margin-bottom:12px;">

<input name="phone" value="{{ $user->phone }}"
       style="width:100%;padding:10px;border:1px solid #cbd5f5;border-radius:8px;margin-bottom:12px;">

<input name="email" value="{{ $user->email }}" required
       style="width:100%;padding:10px;border:1px solid #cbd5f5;border-radius:8px;margin-bottom:12px;">

<input name="password" type="password" placeholder="New password (optional)"
       style="width:100%;padding:10px;border:1px solid #cbd5f5;border-radius:8px;margin-bottom:12px;">

<select name="role"
        style="width:100%;padding:10px;border:1px solid #cbd5f5;border-radius:8px;margin-bottom:12px;">
    <option value="admin" @selected($user->role==='admin')>Admin</option>
    <option value="staff" @selected($user->role==='staff')>Staff</option>
    <option value="user" @selected($user->role==='user')>User</option>
</select>

<select name="department_id"
        style="width:100%;padding:10px;border:1px solid #cbd5f5;border-radius:8px;margin-bottom:16px;">
    @foreach($departments as $dept)
        <option value="{{ $dept->dept_id }}"
            @selected($dept->dept_id === $user->department_id)>
            {{ $dept->name }}
        </option>
    @endforeach
</select>

<button style="background:#2563eb;color:white;padding:10px 16px;border-radius:8px;border:none;">
    Update User
</button>

</form>
@endsection
