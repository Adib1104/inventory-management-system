<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>@yield('title', 'SPB Inventory')</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
/* -------------------------------
   GLOBAL STYLES
---------------------------------*/
body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: #f1f5f9;
    color: #1e293b;
    display: flex;
    transition: background 0.3s, color 0.3s;
}

/* -------------------------------
   SIDEBAR
---------------------------------*/
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 230px;
    height: 100vh;
    background: #1e40af;
    color: white;
    padding: 20px 10px 20px 20px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    transition: width 0.3s ease;
    z-index: 1000;
}

.sidebar h1 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 30px;
}

.nav {
    flex: 1;
}

.nav a {
    color: #e0e7ff;
    text-decoration: none;
    padding: 12px 14px;
    border-radius: 8px;
    font-size: 14px;
    margin-bottom: 6px;
    display: block;
}

.nav a:hover,
.nav a.active {
    background: #1d4ed8;
}

#sidebarToggle {
    background: #3b82f6;
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    border-radius: 8px;
    margin-bottom: 20px;
}

.sidebar.collapsed {
    width: 60px;
}

.sidebar.collapsed h1,
.sidebar.collapsed .nav a {
    display: none;
}

/* -------------------------------
   MAIN CONTENT
---------------------------------*/
.main {
    margin-left: 230px;
    padding: 20px 30px;
    width: 100%;
    transition: margin-left 0.3s ease;
}

.main.collapsed {
    margin-left: 60px;
}

/* -------------------------------
   NAVBAR
---------------------------------*/
.navbar {
    background: white;
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-radius: 12px;
    margin-bottom: 20px;
}

.navbar h2 {
    font-size: 18px;
    font-weight: 600;
    color: #1e3a8a;
}

/* -------------------------------
   THEME TOGGLE
---------------------------------*/
.theme-toggle {
    background: #e5e7eb;
    border: none;
    padding: 6px 12px;
    border-radius: 999px;
    cursor: pointer;
}

/* -------------------------------
   DARK MODE
---------------------------------*/
body.dark {
    background: #0f172a;
    color: #e5e7eb;
}

body.dark .navbar {
    background: #020617;
}

body.dark .sidebar {
    background: #020617;
}

body.dark .nav a:hover,
body.dark .nav a.active {
    background: #1e293b;
}

/* -------------------------------
   NAVBAR ACTION BUTTONS
---------------------------------*/
.nav-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}

/* THEME TOGGLE BUTTON */
.theme-toggle {
    background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
    color: #1e3a8a;
    border: none;
    padding: 8px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.25s ease;
}

.theme-toggle:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
}

/* LOGOUT BUTTON */
.logout-btn {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.25s ease;
}

.logout-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
}

/* DARK MODE BUTTON COLORS */
body.dark .theme-toggle {
    background: linear-gradient(135deg, #334155, #1e293b);
    color: #e5e7eb;
}

/* -------------------------------
   TABLE DARK MODE FIX
---------------------------------*/
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

/* DARK MODE TABLE */
body.dark table {
    background: #020617;
    color: #e5e7eb;
}

body.dark th {
    background: #020617;
    color: #c7d2fe;
    border-bottom: 1px solid #334155;
}

body.dark td {
    border-bottom: 1px solid #334155;
}

/* TABLE ROW HOVER */
tr:hover {
    background: #f1f5f9;
}

body.dark tr:hover {
    background: #1e293b;
}

body.dark .card,
body.dark .chart-card,
body.dark .summary-card {
    background: #020617;
    box-shadow: none;
}

</style>

@yield('styles')
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <button id="sidebarToggle">&#9776;</button>
    <h1>SPB Inventory</h1>

    <div class="nav">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('items.index') }}">Items</a>
        <a href="{{ route('bookings.index') }}">Bookings</a>

        @if(Auth::user()->isAdminOrStaff())
            <a href="{{ route('suppliers.index') }}">Suppliers</a>
            <a href="{{ route('categories.index') }}">Categories</a>
            <a href="{{ route('departments.index') }}">Departments</a>
            <a href="{{ route('admin.reports.inventory') }}">Reports</a>
        @endif

        @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.users.index') }}">Users</a>
        @endif
    </div>
</div>

<!-- MAIN -->
<div class="main">
    <div class="navbar">
        <h2>@yield('page-title')</h2>

        <div class="nav-actions">
            <button id="themeToggle" class="theme-toggle"> Dark</button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>

        </div>
    </div>

    @yield('content')
</div>

<script>
const sidebar = document.querySelector('.sidebar');
const main = document.querySelector('.main');
const toggle = document.getElementById('sidebarToggle');
const themeToggle = document.getElementById('themeToggle');

toggle.onclick = () => {
    sidebar.classList.toggle('collapsed');
    main.classList.toggle('collapsed');
};

if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark');
    themeToggle.textContent = ' Light';
}

themeToggle.onclick = () => {
    document.body.classList.toggle('dark');
    const dark = document.body.classList.contains('dark');
    localStorage.setItem('theme', dark ? 'dark' : 'light');
    themeToggle.textContent = dark ? ' Light' : ' Dark';
};
</script>

{{--  THIS IS THE KEY LINE FOR CHARTS --}}
@yield('scripts')

</body>
</html>
