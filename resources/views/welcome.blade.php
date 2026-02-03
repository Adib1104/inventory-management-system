<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SPB Inventory Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* ===== Animated Background ===== */
        .bg {
            position: fixed;
            inset: 0;
            background: linear-gradient(120deg, #e0e7ff, #f8fafc, #e0e7ff);
            background-size: 300% 300%;
            animation: bgMove 22s ease infinite;
            z-index: 0;
        }

        @keyframes bgMove {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* ===== Spinning Rings ===== */
        .spin-wrapper {
            position: fixed;
            width: 580px;
            height: 580px;
            top: -220px;
            right: -220px;
            z-index: 2;
            pointer-events: none;
        }

        .spin-wrapper.opposite {
            top: auto;
            right: auto;
            bottom: -220px;
            left: -220px;
        }

        /* OUTER RING — VERY THICK & SLOW */
        .ring-outer {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 14px solid rgba(37, 99, 235, 0.25);
            border-top-color: rgba(37, 99, 235, 0.85);
            animation: spinSlow 60s linear infinite;
        }

        /* MIDDLE RING — THICK & REVERSE */
        .ring-middle {
            position: absolute;
            inset: 85px;
            border-radius: 50%;
            border: 10px solid rgba(37, 99, 235, 0.35);
            border-right-color: rgba(37, 99, 235, 0.95);
            animation: spinReverse 28s linear infinite;
        }

        /* INNER RING — THICK & FAST */
        .ring-inner {
            position: absolute;
            inset: 175px;
            border-radius: 50%;
            border: 6px solid rgba(37, 99, 235, 0.45);
            border-bottom-color: rgba(37, 99, 235, 1);
            animation: spinFast 14s linear infinite;
        }

        @keyframes spinSlow {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        @keyframes spinReverse {
            from { transform: rotate(360deg); }
            to   { transform: rotate(0deg); }
        }

        @keyframes spinFast {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        /* ===== Main Card ===== */
        .container {
            position: relative;
            z-index: 10;
            background: #ffffff;
            padding: 50px 60px;
            border-radius: 14px;
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.18);
            text-align: center;
            max-width: 460px;
            width: 100%;
        }

        h1 {
            font-size: 24px;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 12px;
        }

        p {
            font-size: 14px;
            color: #475569;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .btn-login {
            display: inline-block;
            padding: 12px 44px;
            background-color: #1e40af;
            color: #ffffff;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .btn-login:hover {
            background-color: #1e3a8a;
            transform: translateY(-2px);
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #64748b;
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                animation: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="bg"></div>

    <!-- Top-right spinning rings -->
    <div class="spin-wrapper">
        <div class="ring-outer"></div>
        <div class="ring-middle"></div>
        <div class="ring-inner"></div>
    </div>

    <!-- Bottom-left spinning rings -->
    <div class="spin-wrapper opposite">
        <div class="ring-outer"></div>
        <div class="ring-middle"></div>
        <div class="ring-inner"></div>
    </div>

    <div class="container">
        <h1>SPB Inventory Management System</h1>
        <p>
            Structured internal platform for managing inventory, assets,
            suppliers, and borrowing operations.
        </p>

        <a href="{{ route('login') }}" class="btn-login">Login</a>

        <div class="footer">
            © {{ date('Y') }} SPB Inventory Management System
        </div>
    </div>

</body>
</html>
