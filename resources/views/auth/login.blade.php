<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Login - Pasig BMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #0038A8;
            --primary-foreground: #ffffff;
            --danger: #dc3545;
            --background: #f8f9fa;
            --foreground: #212529;
            --muted-foreground: #6c757d;
            --border: #dee2e6;
        }

        body {
            background-color: var(--background);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            padding: 1rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 448px;
        }

        .header-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .icon-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background-color: var(--primary);
            margin-bottom: 1rem;
        }

        .icon-circle i {
            font-size: 2rem;
            color: var(--primary-foreground);
        }

        .header-section h1 {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--foreground);
            margin-bottom: 0.25rem;
        }

        .header-section p {
            color: var(--muted-foreground);
            margin: 0;
        }

        .login-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .card-header h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--foreground);
        }

        .card-header p {
            font-size: 0.875rem;
            color: var(--muted-foreground);
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--foreground);
        }

        .form-control {
            width: 100%;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border: 1px solid var(--border);
            border-radius: 0.375rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.1);
        }

        .error-message {
            font-size: 0.875rem;
            color: var(--danger);
            margin-top: 0.25rem;
        }

        .success-message {
            padding: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .forgot-link {
            font-size: 0.875rem;
            color: var(--primary);
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
            cursor: pointer;
        }

        .checkbox-group label {
            font-size: 0.875rem;
            margin: 0;
            cursor: pointer;
        }

        .btn-primary {
            width: 100%;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--primary-foreground);
            background-color: var(--primary);
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary:hover:not(:disabled) {
            background-color: #002980;
        }

        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .footer-text {
            text-align: center;
            font-size: 0.875rem;
            margin-top: 1rem;
        }

        .footer-text span {
            color: var(--muted-foreground);
        }

        .footer-text a {
            font-weight: 500;
            color: var(--danger);
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="header-section">
            <div class="icon-circle">
                <i class="bi bi-building"></i>
            </div>
            <h1>Barangay Management System</h1>
            <p>Resident Portal</p>
        </div>

        <div class="login-card">
            <div class="card-header">
                <h2>Resident Login</h2>
                <p>Enter your credentials to access resident services</p>
            </div>
            <div class="card-body">
                @if(session('status'))
                    <div class="success-message">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email') }}"
                            autocomplete="username"
                            autofocus
                            required
                        >
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="label-row">
                            <label for="password" class="form-label">Password</label>
                            {{-- @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                            @endif --}}
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control @error('password') is-invalid @enderror"
                            autocomplete="current-password"
                            required
                        >
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn-primary">
                        Log in
                    </button>

                    <div class="footer-text">
                        <span>Are you an admin? </span>
                        <a href="{{ route('admin.login') }}">Admin Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
