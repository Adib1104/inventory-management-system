<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class InventoryReportController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();
        $lowStockItems = Item::where('quantity', '<=', 5)->get();
        $items = Item::all();

        return view('reports.inventory', compact(
            'totalItems',
            'lowStockItems',
            'items'
        ));
    }

    public function pdf()
    {
        $totalItems = Item::count();
        $lowStockItems = Item::where('quantity', '<=', 5)->get();
        $items = Item::all();

        $pdf = Pdf::loadView('reports.inventory_pdf', compact(
            'totalItems',
            'lowStockItems',
            'items'
        ));

        return $pdf->download('inventory-report.pdf');
    }
}
