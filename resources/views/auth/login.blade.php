<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | SPB Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            height: 100vh;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(120deg, #e0e7ff, #f8fafc);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: #ffffff;
            padding: 45px 50px;
            width: 100%;
            max-width: 420px;
            border-radius: 14px;
            box-shadow: 0 14px 40px rgba(0,0,0,0.18);
        }

        h1 {
            font-size: 22px;
            color: #1e3a8a;
            margin-bottom: 8px;
        }

        p {
            font-size: 14px;
            color: #475569;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            font-size: 13px;
            color: #334155;
            display: block;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 11px;
            border-radius: 6px;
            border: 1px solid #cbd5f5;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
        }

        .btn {
            width: 100%;
            margin-top: 10px;
            padding: 12px;
            background: #1e40af;
            border: none;
            color: white;
            font-size: 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn:hover {
            background: #1e3a8a;
        }

        .links {
            margin-top: 18px;
            text-align: center;
            font-size: 13px;
        }

        .links a {
            color: #2563eb;
            text-decoration: none;
        }

        .error {
            font-size: 13px;
            color: #dc2626;
            margin-bottom: 12px;
        }

        .success {
            font-size: 13px;
            color: #16a34a;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>

<div class="card">
    <h1>SPB Inventory</h1>
    <p>Sign in to your account</p>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button class="btn">Login</button>
    </form>

    <div class="links">
        Don’t have an account?
        <a href="{{ route('register') }}">Register</a>
    </div>
</div>

</body>
</html>
