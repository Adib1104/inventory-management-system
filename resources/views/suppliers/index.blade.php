@extends('layouts.app')

@section('title', 'Suppliers')
@section('page-title', 'Suppliers')

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
    <form method="GET" action="{{ route('suppliers.index') }}" style="display:flex;gap:8px;">
        <input type="text"
               name="search"
               value="{{ $search ?? '' }}"
               placeholder="Search company or contact..."
               style="padding:8px 10px;border:1px solid #cbd5f5;border-radius:8px;min-width:220px;">
        <button style="background:#2563eb;color:white;padding:8px 14px;border-radius:8px;border:none;">
            Search
        </button>
    </form>

    {{-- Add Supplier --}}
    <a href="{{ route('suppliers.create') }}"
       style="background:#2563eb;color:white;padding:10px 14px;border-radius:8px;text-decoration:none;">
        + Add Supplier
    </a>
</div>

{{-- Suppliers Table --}}
<div style="overflow-x:auto;">
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="background:#f1f5f9;text-align:left;">
            <th style="padding:10px;">Company Name</th>
            <th style="padding:10px;">Contact Name</th>
            <th style="padding:10px;">Phone</th>
            <th style="padding:10px;">Email</th>
            <th style="padding:10px;">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($suppliers as $supplier)
            <tr style="border-bottom:1px solid #e5e7eb;">
                <td style="padding:10px;">{{ $supplier->com_name }}</td>
                <td style="padding:10px;">{{ $supplier->contact_name ?? '-' }}</td>
                <td style="padding:10px;">{{ $supplier->phone ?? '-' }}</td>
                <td style="padding:10px;">{{ $supplier->email ?? '-' }}</td>
                <td style="padding:10px;white-space:nowrap;">
                    <a href="{{ route('suppliers.edit', $supplier->sup_id) }}"
                       style="color:#2563eb;font-weight:500;margin-right:10px;">
                        Edit
                    </a>

                    <form method="POST"
                          action="{{ route('suppliers.destroy', $supplier->sup_id) }}"
                          style="display:inline;"
                          onsubmit="return confirm('Delete this supplier?')">
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
                <td colspan="5" style="padding:14px;text-align:center;color:#6b7280;">
                    No suppliers found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

{{-- Pagination --}}
@if($suppliers->hasPages())
<div style="margin-top:16px;display:flex;justify-content:center;gap:6px;flex-wrap:wrap;">
    {{-- Previous Page Link --}}
    @if ($suppliers->onFirstPage())
        <span style="padding:6px 12px;border-radius:6px;background:#e5e7eb;color:#9ca3af;">&laquo;</span>
    @else
        <a href="{{ $suppliers->previousPageUrl() }}" style="padding:6px 12px;border-radius:6px;background:#2563eb;color:white;text-decoration:none;">&laquo;</a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($suppliers->links()->elements[0] as $page => $url)
        @if ($page == $suppliers->currentPage())
            <span style="padding:6px 12px;border-radius:6px;background:#1e40af;color:white;font-weight:600;">{{ $page }}</span>
        @else
            <a href="{{ $url }}" style="padding:6px 12px;border-radius:6px;background:#f1f5f9;color:#1e40af;text-decoration:none;">{{ $page }}</a>
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($suppliers->hasMorePages())
        <a href="{{ $suppliers->nextPageUrl() }}" style="padding:6px 12px;border-radius:6px;background:#2563eb;color:white;text-decoration:none;">&raquo;</a>
    @else
        <span style="padding:6px 12px;border-radius:6px;background:#e5e7eb;color:#9ca3af;">&raquo;</span>
    @endif
</div>
@endif

@endsection
