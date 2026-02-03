@extends('layouts.app')

@section('title', 'Inventory Report | SPB Inventory')
@section('page-title', 'Inventory Report')

@section('styles')
<style>
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .card {
        background: #fff;
        padding: 22px;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.12);
    }

    .card h3 {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .card .value {
        font-size: 26px;
        font-weight: 600;
        color: #1e3a8a;
    }

    .section {
        margin-top: 40px;
    }

    .section h2 {
        font-size: 18px;
        color: #1e3a8a;
        margin-bottom: 16px;
        font-weight: 600;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }

    th, td {
        padding: 14px;
        font-size: 14px;
        text-align: left;
    }

    th {
        background: #e0e7ff;
        color: #1e3a8a;
        font-weight: 600;
    }

    tr:not(:last-child) {
        border-bottom: 1px solid #e5e7eb;
    }

    tr:hover {
        background: #f1f5f9;
    }

    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
        transition: background 0.3s, color 0.3s;
    }

    .badge-warning {
        background: #fee2e2;
        color: #b91c1c;
    }

    .badge-success {
        background: #dcfce7;
        color: #15803d;
    }

    /* DARK MODE */
    body.dark .card {
        background: #1e293b !important;
        color: #e5e7eb;
    }

    body.dark table {
        background: #1e293b !important;
        color: #e5e7eb;
    }

    body.dark th {
        background: #111827 !important;
        color: #e5e7eb;
    }

    body.dark tr:hover {
        background: #374151 !important;
    }

    body.dark .badge-success {
        background: #15803d33 !important;
        color: #dcfce7 !important;
    }

    body.dark .badge-warning {
        background: #b91c1c33 !important;
        color: #fee2e2 !important;
    }

</style>
@endsection

@section('content')

<!-- SUMMARY CARDS -->
<div class="grid">
    <div class="card">
        <h3>Total Items</h3>
        <div class="value">{{ $totalItems }}</div>
    </div>

    <div class="card">
        <h3>Low Stock Items</h3>
        <div class="value">{{ $lowStockItems->count() }}</div>
    </div>
</div>

<!-- DOWNLOAD PDF -->
<div class="section">
    <a href="{{ route('admin.reports.inventory.pdf') }}"
       style="background:#3b82f6; color:white; padding:10px 16px; border-radius:8px; text-decoration:none;">
        Download PDF
    </a>
</div>

<!-- INVENTORY TABLE -->
<div class="section">
    <h2>Inventory List</h2>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name ?? '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        @if($item->quantity <= 5)
                            <span class="badge badge-warning">Low</span>
                        @else
                            <span class="badge badge-success">In Stock</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:#6b7280;">No inventory records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
