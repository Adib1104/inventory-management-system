@extends('layouts.app')

@section('title', 'Categories')
@section('page-title', 'Categories')

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
    <form method="GET" action="{{ route('categories.index') }}" style="display:flex;gap:8px;">
        <input type="text"
               name="search"
               value="{{ $search ?? '' }}"
               placeholder="Search category..."
               style="padding:8px 10px;border:1px solid #cbd5f5;border-radius:8px;min-width:220px;">
        <button style="background:#2563eb;color:white;padding:8px 14px;border-radius:8px;border:none;">
            Search
        </button>
    </form>

    {{-- Add Category --}}
    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
        <a href="{{ route('categories.create') }}"
           style="background:#2563eb;color:white;padding:10px 14px;border-radius:8px;text-decoration:none;">
            + Add Category
        </a>
    @endif
</div>

{{-- Categories Table --}}
<div style="overflow-x:auto;">
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="background:#f1f5f9;text-align:left;">
            <th style="padding:10px;">Name</th>
            <th style="padding:10px;">Created</th>

            @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                <th style="padding:10px;">Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
            <tr style="border-bottom:1px solid #e5e7eb;">
                <td style="padding:10px;">{{ $category->name }}</td>
                <td style="padding:10px;">
                    {{ $category->created_at->format('d M Y') }}
                </td>

                @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                <td style="padding:10px;white-space:nowrap;">
                    <a href="{{ route('categories.edit', $category) }}"
                       style="color:#2563eb;font-weight:500;margin-right:10px;">
                        Edit
                    </a>

                    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                        <form method="POST"
                              action="{{ route('categories.destroy', $category) }}"
                              style="display:inline;"
                              onsubmit="return confirm('Delete this category?')">
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
                <td colspan="3" style="padding:14px;text-align:center;color:#6b7280;">
                    No categories found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

{{-- Pagination --}}
@if($categories->hasPages())
<div style="margin-top:16px;display:flex;justify-content:center;gap:6px;flex-wrap:wrap;">
    {{-- Previous Page Link --}}
    @if ($categories->onFirstPage())
        <span style="padding:6px 12px;border-radius:6px;background:#e5e7eb;color:#9ca3af;">&laquo;</span>
    @else
        <a href="{{ $categories->previousPageUrl() }}" style="padding:6px 12px;border-radius:6px;background:#2563eb;color:white;text-decoration:none;">&laquo;</a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($categories->links()->elements[0] as $page => $url)
        @if ($page == $categories->currentPage())
            <span style="padding:6px 12px;border-radius:6px;background:#1e40af;color:white;font-weight:600;">{{ $page }}</span>
        @else
            <a href="{{ $url }}" style="padding:6px 12px;border-radius:6px;background:#f1f5f9;color:#1e40af;text-decoration:none;">{{ $page }}</a>
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($categories->hasMorePages())
        <a href="{{ $categories->nextPageUrl() }}" style="padding:6px 12px;border-radius:6px;background:#2563eb;color:white;text-decoration:none;">&raquo;</a>
    @else
        <span style="padding:6px 12px;border-radius:6px;background:#e5e7eb;color:#9ca3af;">&raquo;</span>
    @endif
</div>
@endif

@endsection
