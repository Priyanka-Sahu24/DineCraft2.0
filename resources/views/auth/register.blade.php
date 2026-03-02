<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DiningCraft | Register</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .logo-img { max-width: 60px; margin-bottom: 18px; }
        .input-group-password { position: relative; }
        .toggle-password { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #aaa; }
        .input-group-password input { padding-right: 38px; }
        .terms-label { font-size: 13px; color: #555; }
    </style>
</head>
<body>

<div class="auth-wrapper">

    <!-- LEFT BRAND SECTION -->
    <div class="brand-section text-center">
        <img src="https://img.icons8.com/color/96/restaurant.png" alt="Logo" class="logo-img">
        <h1 class="brand-title">
            DiningCraft Smart Restaurant Management System
        </h1>
        <p class="brand-tagline">
            Managing Dining Experience with Elegance and Technology
        </p>
    </div>

    <!-- RIGHT REGISTER SECTION -->
    <div class="form-section">

        <div class="auth-card">
            <h2>Create Account</h2>
            <p class="sub-text">Join DineCraft today</p>

            @if ($errors->any())
                <div class="error-box">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/register">
                @csrf


                <div class="input-group">
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="input-group-password">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePassword('password', this)"><i class="bi bi-eye"></i></span>
                </div>
                <div class="input-group-password">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                    <span class="toggle-password" onclick="togglePassword('password_confirmation', this)"><i class="bi bi-eye"></i></span>
                </div>


                <div class="input-group">
                    <input type="text" name="phone" placeholder="Phone Number" required>
                </div>
                <div class="input-group">
                    <textarea name="address" placeholder="Full Address" required></textarea>
                </div>
                <div class="input-group">
                    <select name="role" class="form-select" required>
                        <option value="customer">Register as Customer</option>
                        <option value="staff">Register as Staff</option>
                    </select>
                </div>
                <div class="input-group d-flex align-items-center">
                    <input type="checkbox" name="terms" id="terms" required style="width:auto; margin-right:8px;">
                    <label for="terms" class="terms-label">I agree to the <a href="#" target="_blank">Terms & Conditions</a></label>
                </div>


                <button type="submit" class="auth-btn" style="font-size:17px; font-weight:600; letter-spacing:1px;">
                    <i class="bi bi-person-plus me-2"></i> Register
                </button>

                <p class="switch-text">
                    Already have an account?
                    <a href="/login">Login</a>
                </p>

            </form>
        </div>

    </div>

</div>

<script>
function togglePassword(id, el) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
        el.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
        input.type = 'password';
        el.innerHTML = '<i class="bi bi-eye"></i>';
    }
}
</script>
</body>
</html>