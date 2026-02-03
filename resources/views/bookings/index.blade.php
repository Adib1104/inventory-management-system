@extends('layouts.app')

@section('title', 'Bookings')
@section('page-title', 'Bookings')

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
    <form method="GET" action="{{ route('bookings.index') }}" style="display:flex;gap:8px;">
        <input
            type="text"
            name="search"
            value="{{ $search ?? '' }}"
            placeholder="Search user or status..."
            style="padding:8px 10px;border:1px solid #cbd5f5;border-radius:8px;min-width:220px;"
        >
        <button style="background:#2563eb;color:white;padding:8px 14px;border-radius:8px;border:none;">
            Search
        </button>
    </form>

    {{-- Add Booking (User Only) --}}
    @if(auth()->user()->role === 'user')
        <a
            href="{{ route('bookings.create') }}"
            style="background:#2563eb;color:white;padding:10px 14px;border-radius:8px;text-decoration:none;"
        >
            + New Booking
        </a>
    @endif
</div>

{{-- Bookings Table --}}
<div style="overflow-x:auto;">
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="background:#f1f5f9;text-align:left;">
            <th style="padding:10px;">Booking ID</th>
            <th style="padding:10px;">User</th>
            <th style="padding:10px;">Requested At</th>
            <th style="padding:10px;">Approved At</th>
            <th style="padding:10px;">Approved By</th>
            <th style="padding:10px;">Status</th>
            <th style="padding:10px;">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($bookings as $booking)
            <tr style="border-bottom:1px solid #e5e7eb;">

                {{-- Booking ID --}}
                <td style="padding:10px;">
                    {{ $booking->booking_id }}
                </td>

                {{-- User --}}
                <td style="padding:10px;">
                    {{ optional($booking->user)->name ?? '-' }}
                </td>

                {{-- Requested At --}}
                <td style="padding:10px;">
                    {{ $booking->requested_at?->format('d M Y, h:i A') ?? '-' }}
                </td>

                {{-- Approved At --}}
                <td style="padding:10px;">
                    {{ $booking->approved_at?->format('d M Y, h:i A') ?? '-' }}
                </td>

                {{-- Approved By --}}
                <td style="padding:10px;">
                    {{ optional($booking->approver)->name ?? '-' }}
                </td>

                {{-- Status --}}
                <td style="padding:10px;">
                    @if($booking->status === 'pending')
                        <span style="background:#fef3c7;color:#92400e;padding:4px 8px;border-radius:999px;font-size:13px;">
                            Pending
                        </span>
                    @elseif($booking->status === 'approved')
                        <span style="background:#dcfce7;color:#166534;padding:4px 8px;border-radius:999px;font-size:13px;">
                            Approved
                        </span>
                    @else
                        <span style="background:#fee2e2;color:#991b1b;padding:4px 8px;border-radius:999px;font-size:13px;">
                            Rejected
                        </span>
                    @endif
                </td>

                {{-- Actions --}}
                <td style="padding:10px;white-space:nowrap;">

                    {{-- View --}}
                    <a
                        href="{{ route('bookings.show', $booking->booking_id) }}"
                        style="color:#2563eb;font-weight:500;margin-right:10px;"
                    >
                        View
                    </a>

                    {{-- Admin / Staff Actions --}}
                    @if(auth()->user()->role !== 'user' && $booking->status === 'pending')

                        <form
                            method="POST"
                            action="{{ route('bookings.approve', $booking->booking_id) }}"
                            style="display:inline;"
                        >
                            @csrf
                            <button
                                style="background:none;border:none;color:#16a34a;font-weight:500;cursor:pointer;margin-right:8px;"
                            >
                                Approve
                            </button>
                        </form>

                        <form
                            method="POST"
                            action="{{ route('bookings.reject', $booking->booking_id) }}"
                            style="display:inline;"
                            onsubmit="return confirm('Reject this booking?')"
                        >
                            @csrf
                            <button
                                style="background:none;border:none;color:#dc2626;font-weight:500;cursor:pointer;"
                            >
                                Reject
                            </button>
                        </form>

                    @endif

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="padding:14px;text-align:center;color:#6b7280;">
                    No bookings found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

{{-- Pagination --}}
@if($bookings->hasPages())
    <div style="margin-top:16px;">
        {{ $bookings->links() }}
    </div>
@endif

@endsection
