@extends('layouts.app')

@section('title', 'Booking Details')
@section('page-title', 'Booking Details')

@section('content')

{{-- Booking Info --}}
<div style="background:#f8fafc;padding:16px;border-radius:8px;margin-bottom:16px;">
    <p><strong>Booking ID:</strong> #{{ $booking->booking_id }}</p>
    <p><strong>User:</strong> {{ $booking->user->name }}</p>
    <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
    <p><strong>Requested At:</strong> {{ $booking->requested_at->format('d M Y, h:i A') }}</p>

    @if($booking->approved_at)
        <p><strong>Processed At:</strong> {{ $booking->approved_at->format('d M Y, h:i A') }}</p>
    @endif

    @if($booking->remarks)
        <p><strong>Remarks:</strong> {{ $booking->remarks }}</p>
    @endif
</div>

{{-- Items Table --}}
<div style="overflow-x:auto;">
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="background:#f1f5f9;text-align:left;">
            <th style="padding:10px;">Item</th>
            <th style="padding:10px;">Quantity</th>
        </tr>
    </thead>
    <tbody>
        @foreach($booking->items as $row)
            <tr style="border-bottom:1px solid #e5e7eb;">
                <td style="padding:10px;">{{ $row->item->name }}</td>
                <td style="padding:10px;">{{ $row->quantity }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>

{{-- Actions --}}
<div style="margin-top:16px;display:flex;gap:10px;flex-wrap:wrap;">

    <a href="{{ route('bookings.index') }}"
       style="background:#e5e7eb;color:#111827;padding:10px 16px;border-radius:8px;text-decoration:none;">
        Back
    </a>

    @if(auth()->user()->role !== 'user' && $booking->status === 'pending')

        <form method="POST" action="{{ route('bookings.approve', $booking->booking_id) }}">
            @csrf
            <button style="background:#16a34a;color:white;padding:10px 16px;border-radius:8px;border:none;">
                Approve
            </button>
        </form>

        <form method="POST"
              action="{{ route('bookings.reject', $booking->booking_id) }}"
              onsubmit="return confirm('Reject this booking?')">
            @csrf
            <button style="background:#dc2626;color:white;padding:10px 16px;border-radius:8px;border:none;">
                Reject
            </button>
        </form>

    @endif
</div>

@endsection
