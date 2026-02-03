<!DOCTYPE html>
<html>
<head>
    <title>Inventory Report</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            color: #000;
            margin: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .report-meta {
            text-align: center;
            font-size: 11px;
            margin-bottom: 20px;
        }

        .summary {
            margin-bottom: 15px;
        }

        .summary p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        /* IMPORTANT FOR MULTI-PAGE PDF */
        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background-color: #eaeaea;
            font-weight: bold;
            text-align: center;
        }

        td {
            vertical-align: middle;
        }

        .status-low {
            background-color: #f4c7a1;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 11px;
            display: inline-block;
        }

        .status-ok {
            background-color: #c6efce;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 11px;
            display: inline-block;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #555;
        }
    </style>
</head>
<body>

    <h2>Inventory Report</h2>

    <div class="report-meta">
        Printed on: {{ now()->format('d F Y, h:i A') }} (MYT)
    </div>

    <div class="summary">
        <strong>Report Summary</strong>
        <p>Total Number of Items: {{ $totalItems }}</p>
        <p>Number of Low Stock Items: {{ $lowStockItems->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th style="width: 30%;">Item Name</th>
                <th style="width: 25%;">Category</th>
                <th style="width: 15%;">Quantity</th>
                <th style="width: 20%;">Stock Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($items as $item)
            <tr>
                <td style="text-align: center;">
                    {{ $loop->iteration }}
                </td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category->name ?? 'N/A' }}</td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td style="text-align: center;">
                    @if($item->quantity <= 5)
                        <span class="status-low">Low Stock</span>
                    @else
                        <span class="status-ok">In Stock</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        This document is system-generated and intended for internal use only.
    </div>

</body>
</html>
