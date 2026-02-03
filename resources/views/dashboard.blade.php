@extends('layouts.app')

@section('title', 'Dashboard | SPB Inventory')
@section('page-title', 'Dashboard')

@section('styles')
<style>
/* -------------------------------
   DASHBOARD GRID
---------------------------------*/
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

/* -------------------------------
   SUMMARY CARDS
---------------------------------*/
.summary-card {
    background: white;
    padding: 22px;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.summary-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 26px rgba(0,0,0,0.10);
}

.summary-card h3 {
    font-size: 13px;
    font-weight: 500;
    color: #64748b;
    margin-bottom: 6px;
}

.summary-card .value {
    font-size: 28px;
    font-weight: 600;
    color: #1e3a8a;
}

/* -------------------------------
   SECTIONS
---------------------------------*/
.section {
    margin-top: 40px;
}

.section h2 {
    font-size: 18px;
    font-weight: 600;
    color: #1e3a8a;
    margin-bottom: 20px;
}

/* -------------------------------
   CHART LAYOUT
---------------------------------*/
.chart-grid {
    display: grid;
    grid-template-columns: 1fr 1.2fr; /* doughnut slightly bigger */
    gap: 20px;
}

.chart-card {
    background: white;
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
}

.chart-title {
    font-size: 14px;
    font-weight: 600;
    color: #1e3a8a;
    margin-bottom: 12px;
    text-align: center;
}

.doughnut-wrapper {
    width: 100%;
    max-width: 380px;   /* adjust: 360–420px looks good */
    height: 380px;      /* force larger chart */
    margin: 0 auto;
}
/* -------------------------------
   DARK MODE
---------------------------------*/
body.dark .summary-card,
body.dark .chart-card {
    background: #020617;
    box-shadow: none;
}

body.dark .summary-card h3,
body.dark .chart-title {
    color: #c7d2fe;
}

body.dark .summary-card .value {
    color: #93c5fd;
}

/* -------------------------------
   RESPONSIVE
---------------------------------*/
@media (max-width: 900px) {
    .chart-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<!-- SUMMARY CARDS -->
<div class="dashboard-grid">
    <div class="summary-card">
        <h3>Total Items</h3>
        <div class="value">{{ $totalItems }}</div>
    </div>

    <div class="summary-card">
        <h3>Total Suppliers</h3>
        <div class="value">{{ $totalSuppliers }}</div>
    </div>

    <div class="summary-card">
        <h3>Total Categories</h3>
        <div class="value">{{ $totalCategories }}</div>
    </div>

    <div class="summary-card">
        <h3>Total Users</h3>
        <div class="value">{{ $totalUsers }}</div>
    </div>
</div>

<!-- CHARTS -->
<div class="section">
    <h2>Inventory Statistics</h2>

    <div class="chart-grid">
        <!-- BAR CHART -->
        <div class="chart-card">
            <div class="chart-title">Items per Category</div>
            <canvas id="barChart"></canvas>
        </div>

        <!-- DOUGHNUT CHART -->
        <div class="chart-card">
            <div class="chart-title">Total Percentage per Item</div>
            <div class="doughnut-wrapper">
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// ===============================
// DATA FROM CONTROLLER
// ===============================
const categoryData = {!! $categories->map(fn($c) => ['name' => $c->name, 'count' => $c->items_count]) !!};
const allItems = {!! $allItems->map(fn($i) => ['name' => $i->name, 'quantity' => $i->quantity]) !!};

// ===============================
// BAR CHART – ITEMS PER CATEGORY
// ===============================
const barCtx = document.getElementById('barChart');
if (barCtx) {
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: categoryData.map(c => c.name),
            datasets: [{
                label: 'Number of Items',
                data: categoryData.map(c => c.count),
                borderRadius: 6,
                backgroundColor: document.body.classList.contains('dark') ? '#60a5fa' : '#1e40af'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });
}

// ===============================
// DOUGHNUT CHART – TOTAL PERCENTAGE PER ITEM
// ===============================
const doughnutLabels = allItems.map(i => i.name);
const doughnutData = allItems.map(i => i.quantity);
const totalQuantity = doughnutData.reduce((sum, val) => sum + val, 0);

const doughnutCtx = document.getElementById('doughnutChart');
if (doughnutCtx) {
    new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: doughnutLabels,
            datasets: [{
                data: doughnutData,
                backgroundColor: doughnutLabels.map((_, i) => `hsl(${i * 30 % 360}, 70%, 50%)`),
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // 🔑 allows full size
            cutout: '65%',              // slightly thicker ring
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 14
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const percentage = totalQuantity
                                ? ((value / totalQuantity) * 100).toFixed(1)
                                : 0;
                            return `${context.label}: ${percentage}% (${value} units)`;
                        }
                    }
                }
            }
        }
    });
}
</script>
@endsection
