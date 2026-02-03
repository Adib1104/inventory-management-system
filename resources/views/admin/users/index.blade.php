@extends('layouts.app')

@section('title', 'Users')
@section('page-title', 'Users')

@section('content')

{{-- Success Message --}}
@if(session('success'))
    <div style="background:#dcfce7;color:#166534;padding:12px;border-radius:8px;margin-bottom:16px;">
        {{ session('success') }}
    </div>
@endif

{{-- Top Actions --}}
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;gap:10px;flex-wrap:wrap;">

    {{-- Search --}}
    <form method="GET" action="{{ route('admin.users.index') }}" style="display:flex;gap:8px;">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Search name or email..."
               style="padding:8px 10px;border:1px solid #cbd5f5;border-radius:8px;min-width:220px;">
        <button style="background:#2563eb;color:white;padding:8px 14px;border-radius:8px;border:none;">
            Search
        </button>
    </form>

    {{-- Add User --}}
    <a href="{{ route('admin.users.create') }}"
       style="background:#2563eb;color:white;padding:10px 14px;border-radius:8px;text-decoration:none;">
        + New User
    </a>
</div>

{{-- Users Table --}}
<div style="overflow-x:auto;">
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="background:#f1f5f9;text-align:left;">
            <th style="padding:10px;">Name</th>
            <th style="padding:10px;">Email</th>
            <th style="padding:10px;">Status</th>
            <th style="padding:10px;">Role</th>
            <th style="padding:10px;">Department</th>
            <th style="padding:10px;">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr style="border-bottom:1px solid #e5e7eb;">
                <td style="padding:10px;">{{ $user->name }}</td>
                <td style="padding:10px;">{{ $user->email }}</td>

                {{-- Status --}}
                <td style="padding:10px;">
                    @if(!$user->approved_at)
                        <span style="background:#fef3c7;color:#92400e;padding:4px 8px;border-radius:999px;font-size:13px;">
                            Pending
                        </span>
                    @else
                        <span style="background:#dcfce7;color:#166534;padding:4px 8px;border-radius:999px;font-size:13px;">
                            Approved
                        </span>
                    @endif
                </td>

                {{-- Role --}}
                <td style="padding:10px;">
                    @if(!$user->approved_at)
                        <span style="color:#6b7280;font-size:13px;">Not assigned</span>
                    @elseif($user->role === 'admin')
                        <span style="background:#fee2e2;color:#991b1b;padding:4px 8px;border-radius:999px;font-size:13px;">
                            Admin
                        </span>
                    @elseif($user->role === 'staff')
                        <span style="background:#dcfce7;color:#166534;padding:4px 8px;border-radius:999px;font-size:13px;">
                            Staff
                        </span>
                    @else
                        <span style="background:#e0f2fe;color:#0369a1;padding:4px 8px;border-radius:999px;font-size:13px;">
                            User
                        </span>
                    @endif
                </td>

                {{-- Department --}}
                <td style="padding:10px;">
                    {{ $user->department->name ?? '-' }}
                </td>

                {{-- Actions --}}
                <td style="padding:10px;white-space:nowrap;">
                    @if(!$user->approved_at)
                        {{-- Approve user --}}
                        <form method="POST"
                              action="{{ route('admin.users.approve', $user->user_id) }}"
                              style="display:flex;gap:6px;align-items:center;">
                            @csrf

                            <select name="role"
                                    required
                                    style="padding:6px;border:1px solid #cbd5f5;border-radius:6px;">
                                <option value="">Select role</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                                <option value="user">User</option>
                            </select>

                            <button type="submit"
                                    style="background:#16a34a;color:white;padding:6px 10px;border-radius:6px;border:none;">
                                Approve
                            </button>
                        </form>
                    @else
                        {{-- Normal actions --}}
                        <a href="{{ route('admin.users.edit', $user->user_id) }}"
                           style="color:#2563eb;font-weight:500;margin-right:10px;">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('admin.users.destroy', $user->user_id) }}"
                              style="display:inline;"
                              onsubmit="return confirm('Delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button style="background:none;border:none;color:#dc2626;font-weight:500;cursor:pointer;">
                                Delete
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="padding:14px;text-align:center;color:#6b7280;">
                    No users found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

{{-- Pagination --}}
@if($users->hasPages())
    <div style="margin-top:16px;">
        {{ $users->links() }}
    </div>
@endif

@endsection
