<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | SPB Inventory</title>
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
            max-width: 440px;
            border-radius: 14px;
            box-shadow: 0 14px 40px rgba(0,0,0,0.18);
        }

        h1 {
            font-size: 22px;
            color: #1e3a8a;
            margin-bottom: 6px;
        }

        p {
            font-size: 14px;
            color: #475569;
            margin-bottom: 26px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            font-size: 13px;
            color: #334155;
            display: block;
            margin-bottom: 6px;
        }

        input, select {
            width: 100%;
            padding: 11px;
            border-radius: 6px;
            border: 1px solid #cbd5f5;
            font-size: 14px;
        }

        input:focus, select:focus {
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
            margin-bottom: 8px;
        }
    </style>
</head>
<body>

<div class="card">
    <h1>Create Account</h1>
    <p>SPB Inventory Management System</p>

    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="error">{{ $error }}</div>
        @endforeach
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" value="{{ old('phone') }}" required>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label>Department</label>
            <select name="department_id" required>
                <option value="">-- Select Department --</option>
                @foreach($departments as $department)
                    <option value="{{ $department->dept_id }}"
                        {{ old('department_id') == $department->dept_id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button class="btn">Register</button>
    </form>

    <div class="links">
        Already have an account?
        <a href="{{ route('login') }}">Login</a>
    </div>
</div>

</body>
</html>
