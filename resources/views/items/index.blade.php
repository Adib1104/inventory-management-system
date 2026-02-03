@extends('layouts.app')

@section('title', 'Items')
@section('page-title', 'Items')

@php
    function sortLink($label, $column, $sort, $direction) {
        $dir = ($sort === $column && $direction === 'asc') ? 'desc' : 'asc';
        $arrow = $sort === $column ? ($direction === 'asc' ? ' ▲' : ' ▼') : '';
        $query = array_merge(
            request()->except('sort', 'direction'),
            ['sort' => $column, 'direction' => $dir]
        );

        return '<a href="?'.http_build_query($query).'"
                   style="color:#1e3a8a;font-weight:600;text-decoration:none;">'
                .$label.$arrow.'</a>';
    }
@endphp

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
    <form method="GET" action="{{ route('items.index') }}" style="display:flex;gap:8px;">
        <input type="text"
               name="search"
               value="{{ $search ?? '' }}"
               placeholder="Search item, category or supplier..."
               style="padding:8px 10px;border:1px solid #cbd5f5;border-radius:8px;min-width:220px;">
        <button style="background:#2563eb;color:white;padding:8px 14px;border-radius:8px;border:none;">
            Search
        </button>
    </form>

    {{-- Add Item --}}
    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
        <a href="{{ route('items.create') }}"
           style="background:#2563eb;color:white;padding:10px 14px;border-radius:8px;text-decoration:none;">
            + Add Item
        </a>
    @endif
</div>

{{-- Items Table --}}
<div style="overflow-x:auto;">
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="background:#f1f5f9;text-align:left;">
            <th style="padding:10px;">{!! sortLink('Name', 'name', $sort, $direction) !!}</th>
            <th style="padding:10px;">{!! sortLink('Category', 'category_id', $sort, $direction) !!}</th>
            <th style="padding:10px;">Supplier(s)</th>
            <th style="padding:10px;">{!! sortLink('Quantity', 'quantity', $sort, $direction) !!}</th>
            <th style="padding:10px;">Status</th>

            @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                <th style="padding:10px;">Action</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @forelse($items as $item)
            <tr style="border-bottom:1px solid #e5e7eb;">
                <td style="padding:10px;">{{ $item->name }}</td>
                <td style="padding:10px;">{{ $item->category->name ?? '-' }}</td>
                <td style="padding:10px;">
                    {{ $item->suppliers->pluck('com_name')->join(', ') ?: '-' }}
                </td>
                <td style="padding:10px;">{{ $item->quantity }}</td>
                <td style="padding:10px;">
                    @if($item->quantity <= 5)
                        <span style="background:#fef3c7;color:#92400e;padding:4px 8px;border-radius:999px;font-size:12px;">
                            Low Stock
                        </span>
                    @else
                        <span style="background:#dcfce7;color:#166534;padding:4px 8px;border-radius:999px;font-size:12px;">
                            Available
                        </span>
                    @endif
                </td>

                @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                <td style="padding:10px;white-space:nowrap;">
                    <a href="{{ route('items.edit', $item) }}"
                       style="color:#2563eb;font-weight:500;margin-right:10px;">
                        Edit
                    </a>

                    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                        <form method="POST"
                              action="{{ route('items.destroy', $item) }}"
                              style="display:inline;"
                              onsubmit="return confirm('Delete this item?')">
                            @csrf
                            @method('DELETE')
                            <button style="background:none;border:none;color:#dc2626;cursor:pointer;">
                                Delete
                            </button>
                        </form>
                    @endif
                </td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="6" style="padding:14px;text-align:center;color:#6b7280;">
                    No items found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

{{-- Pagination --}}
@if($items->hasPages())
<div style="margin-top:16px;display:flex;justify-content:center;gap:6px;flex-wrap:wrap;">
    {{-- Previous Page Link --}}
    @if ($items->onFirstPage())
        <span style="padding:6px 12px;border-radius:6px;background:#e5e7eb;color:#9ca3af;">&laquo;</span>
    @else
        <a href="{{ $items->previousPageUrl() }}" style="padding:6px 12px;border-radius:6px;background:#2563eb;color:white;text-decoration:none;">&laquo;</a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($items->links()->elements[0] as $page => $url)
        @if ($page == $items->currentPage())
            <span style="padding:6px 12px;border-radius:6px;background:#1e40af;color:white;font-weight:600;">{{ $page }}</span>
        @else
            <a href="{{ $url }}" style="padding:6px 12px;border-radius:6px;background:#f1f5f9;color:#1e40af;text-decoration:none;">{{ $page }}</a>
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($items->hasMorePages())
        <a href="{{ $items->nextPageUrl() }}" style="padding:6px 12px;border-radius:6px;background:#2563eb;color:white;text-decoration:none;">&raquo;</a>
    @else
        <span style="padding:6px 12px;border-radius:6px;background:#e5e7eb;color:#9ca3af;">&raquo;</span>
    @endif
</div>
@endif

@endsection
