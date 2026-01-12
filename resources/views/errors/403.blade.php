<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Forbidden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .error-container {
            text-align: center;
            color: white;
            padding: 2rem;
        }
        .error-code {
            font-size: 8rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 1rem;
            text-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .error-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .error-message {
            font-size: 1.125rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        .btn-home {
            background: white;
            color: #667eea;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            color: #764ba2;
        }
        .icon-shield {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <i class="bi bi-shield-lock icon-shield"></i>
        <div class="error-code">403</div>
        <div class="error-title">Access Forbidden</div>
        <div class="error-message">
            {{ $exception->getMessage() ?: 'You do not have permission to access this resource.' }}
        </div>
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('dashboard') }}" class="btn-home">
                    <i class="bi bi-house-door me-2"></i>Go to Dashboard
                </a>
            @else
                <a href="{{ route('resident.dashboard') }}" class="btn-home">
                    <i class="bi bi-house-door me-2"></i>Go to Dashboard
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn-home">
                <i class="bi bi-box-arrow-in-right me-2"></i>Go to Login
            </a>
        @endauth
    </div>
</body>
</html>
