@extends('layouts.app')

@section('title', 'New Booking')
@section('page-title', 'New Booking')

@section('content')

@if ($errors->any())
    <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:16px;">
        <ul style="margin:0;padding-left:18px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('bookings.store') }}">
    @csrf

    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#f1f5f9;text-align:left;">
                    <th style="padding:10px;">Select</th>
                    <th style="padding:10px;">Item</th>
                    <th style="padding:10px;">Available</th>
                    <th style="padding:10px;">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                    <tr style="border-bottom:1px solid #e5e7eb;">
                        <td style="padding:10px;">
                            <input type="checkbox"
                                   onchange="toggleQty({{ $index }})">
                        </td>
                        <td style="padding:10px;">{{ $item->name }}</td>
                        <td style="padding:10px;">{{ $item->quantity }}</td>
                        <td style="padding:10px;">
                            <input type="hidden"
                                   name="items[{{ $index }}][item_id]"
                                   value="{{ $item->item_id }}"
                                   disabled>

                            <input type="number"
                                   name="items[{{ $index }}][quantity]"
                                   min="1"
                                   max="{{ $item->quantity }}"
                                   disabled
                                   style="width:80px;padding:6px;border:1px solid #cbd5f5;border-radius:6px;">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px;display:flex;gap:10px;">
        <button type="submit"
                style="background:#2563eb;color:white;padding:10px 16px;border-radius:8px;border:none;">
            Submit Booking
        </button>

        <a href="{{ route('bookings.index') }}"
           style="background:#e5e7eb;color:#111827;padding:10px 16px;border-radius:8px;text-decoration:none;">
            Cancel
        </a>
    </div>
</form>

<script>
function toggleQty(index) {
    const itemId = document.querySelector(`input[name="items[${index}][item_id]"]`);
    const qty = document.querySelector(`input[name="items[${index}][quantity]"]`);

    itemId.disabled = !itemId.disabled;
    qty.disabled = !qty.disabled;

    if (!qty.disabled) qty.focus();
}
</script>

@endsection
