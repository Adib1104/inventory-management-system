@extends('layouts.app')

@section('title', 'Departments')
@section('page-title', 'Departments')

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
    <form method="GET" action="{{ route('departments.index') }}" style="display:flex;gap:8px;">
        <input type="text"
               name="search"
               value="{{ $search ?? '' }}"
               placeholder="Search department..."
               style="padding:8px 10px;border:1px solid #cbd5f5;border-radius:8px;min-width:220px;">
        <button style="background:#2563eb;color:white;padding:8px 14px;border-radius:8px;border:none;">
            Search
        </button>
    </form>

    {{-- Add Department --}}
    <a href="{{ route('departments.create') }}"
       style="background:#2563eb;color:white;padding:10px 14px;border-radius:8px;text-decoration:none;">
        + Add Department
    </a>
</div>

{{-- Departments Table --}}
<div style="overflow-x:auto;">
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="background:#f1f5f9;text-align:left;">
            <th style="padding:10px;">Department Name</th>
            <th style="padding:10px;">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($departments as $department)
            <tr style="border-bottom:1px solid #e5e7eb;">
                <td style="padding:10px;">
                    {{ $department->name }}
                </td>

                <td style="padding:10px;white-space:nowrap;">

                    {{-- Edit --}}
                    <a href="{{ route('departments.edit', $department->dept_id) }}"
                       style="color:#2563eb;font-weight:500;margin-right:10px;">
                        Edit
                    </a>

                    {{-- Delete --}}
                    <form method="POST"
                          action="{{ route('departments.destroy', $department->dept_id) }}"
                          style="display:inline;"
                          onsubmit="return confirm('Delete this department?')">
                        @csrf
                        @method('DELETE')
                        <button style="background:none;border:none;color:#dc2626;cursor:pointer;">
                            Delete
                        </button>
                    </form>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2" style="padding:14px;text-align:center;color:#6b7280;">
                    No departments found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

{{-- Pagination --}}
@if($departments->hasPages())
    <div style="margin-top:16px;">
        {{ $departments->links() }}
    </div>
@endif

@endsection
