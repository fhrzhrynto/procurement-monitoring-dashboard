<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" class="link-favicon">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" class="link-favicon">
    <title>Reset Password - PLN Icon Plus</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        /* CSS same as login page — disingkat untuk contoh */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: #ffffff;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 40px 30px;
            width: 100%;
            animation: fadeIn 0.5s ease forwards;
        }

        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 25px;
        }

        .logo {
            width: 150px;
            height: 150px;
            margin-bottom: 15px;
            object-fit: contain;
        }

        .login-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
            margin-top: -40px;
            text-align: center;
        }

        .login-subtitle {
            font-size: 14px;
            color: #777;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            font-size: 14px;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            background-color: #f9f9f9;
            color: #333;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
            background-color: #fff;
            outline: none;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #4e73df;
            color: white;
            box-shadow: 0 4px 10px rgba(78, 115, 223, 0.25);
        }

        .btn-primary:hover {
            background-color: #3a5ccc;
            box-shadow: 0 6px 15px rgba(78, 115, 223, 0.35);
            transform: translateY(-2px);
        }

        .invalid-feedback {
            color: #ea4335;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .register-link a {
            color: #4e73df;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-card">
            <div class="logo-container">
                <img src="{{ asset('img/PLNIcon.png') }}" class="logo">
                <h1 class="login-title">{{ __('Reset Password') }}</h1>
                <p class="login-subtitle">Enter your email to receive reset instructions</p>
            </div>

            @if (session('status'))
                <div class="mb-4 p-3 text-sm text-green-800 bg-green-100 rounded-lg" role="alert" style="margin-bottom: 20px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}"
                        placeholder="Email Address"
                        required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ __('Send Password Reset Link') }}
                </button>
            </form>

            <div class="register-link">
                <a href="{{ route('login') }}"><i class="fas fa-arrow-left mr-1"></i> Back to Login</a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>
