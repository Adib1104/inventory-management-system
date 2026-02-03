@extends('layouts.app')

@section('title', 'Add User')
@section('page-title', 'Add User')

@section('content')

<form method="POST" action="{{ route('admin.users.store') }}"
      style="max-width:520px;background:white;padding:20px;border-radius:12px;">
@csrf

<input name="name" placeholder="Name" required
       style="width:100%;padding:10px;border:1px solid #cbd5f5;border-radius:8px;margin-bottom:12px;">

<input name="phone" placeholder="Phone"
       style="width:100%;padding:10px;border:1px solid #cbd5f5;border-radius:8px;margin-bottom:12px;">

<input name="email" type="email" placeholder="Email" required
       style="width:100%;padding:10px;border:1px solid #cbd5f5;border-radius:8px;margin-bottom:12px;">

<input name="password" type="password" placeholder="Password" required
       style="width:100%;padding:10px;border:1px solid #cbd5f5;border-radius:8px;margin-bottom:12px;">

<select name="role"
        style="width:100%;padding:10px;border:1px solid #cbd5f5;border-radius:8px;margin-bottom:12px;">
    <option value="admin">Admin</option>
    <option value="staff">Staff</option>
    <option value="user">User</option>
</select>

<select name="department_id" required
        style="width:100%;padding:10px;border:1px solid #cbd5f5;border-radius:8px;margin-bottom:16px;">
    @foreach($departments as $dept)
        <option value="{{ $dept->dept_id }}">{{ $dept->name }}</option>
    @endforeach
</select>

<button style="background:#2563eb;color:white;padding:10px 16px;border-radius:8px;border:none;">
    Save User
</button>

</form>
@endsection
