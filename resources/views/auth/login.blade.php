<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DineCraft | Login</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <style>
        .login-card {
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            background: #fff;
            border-radius: 18px;
            padding: 40px 32px 32px 32px;
            margin: 0 auto;
            transition: box-shadow 0.3s;
        }
        .login-card:hover {
            box-shadow: 0 16px 40px 0 rgba(31, 38, 135, 0.18);
        }
        .login-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }
        .login-logo img {
            height: 48px;
            margin-right: 12px;
        }
        .brand-title {
            font-size: 2.2rem;
            font-family: 'Pacifico', cursive;
            color: #ff7a00;
            margin-bottom: 8px;
        }
        .brand-tagline {
            font-size: 1.1rem;
            color: #ff9f43;
            font-weight: 400;
            margin-bottom: 32px;
        }
        .input-label {
            font-size: 0.98rem;
            color: #444;
            margin-bottom: 6px;
            font-weight: 500;
        }
        .forgot-link {
            display: block;
            text-align: right;
            margin-bottom: 18px;
            font-size: 0.95rem;
        }
        .forgot-link a {
            color: #ff7a00;
            text-decoration: none;
        }
        .forgot-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <!-- Left Branding Section -->
    <div class="brand-section" style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
        <div class="brand-title" style="color:#ff7a00; text-shadow:0 2px 12px #fff, 0 1px 6px rgba(0,0,0,0.10); font-size:2.7rem; text-align:center; margin-bottom:18px; font-family:'Pacifico',cursive;">
            DineCraft
        </div>
        <div class="brand-tagline" style="color:#fff; text-shadow:0 2px 8px rgba(0,0,0,0.18); font-weight:600; text-align:center;">
            Smart Restaurant Management System<br>
            <span style="font-size:1.08rem; color:#fff; font-weight:400; text-shadow:0 1px 6px rgba(0,0,0,0.22); display:block; margin-top:8px;">Managing Dining Experience with Elegance and Technology</span>
        </div>
    </div>
    <!-- Right Login Section -->
    <div class="login-section">
        <div class="login-card">
            <h2 style="color:#222; font-size:1.7rem; font-weight:600; margin-bottom:8px;">Welcome Back</h2>
            <p class="sub-text" style="margin-bottom:18px;">Sign in to your account</p>
            @if(session('error'))
                <p class="error-message">{{ session('error') }}</p>
            @endif
            <form method="POST" action="/login" autocomplete="on">
                @csrf
                <div class="input-group">
                    <label class="input-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required autofocus>
                </div>
                <div class="input-group">
                    <label class="input-label" for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <!-- Forgot Password link removed -->
                <button type="submit" class="login-btn">Login</button>
                <p class="register-text" style="margin-top:18px;">
                    New to DineCraft? <a href="/register">Create Account</a>
                </p>
            </form>
        </div>
    </div>
</div>

</body>
</html>