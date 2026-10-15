<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" class="link-favicon">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" class="link-favicon">
    <title>Login - PLN Icon Plus</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
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
            margin-right: -5px;
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
        
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .form-check-input {
            margin-right: 8px;
        }
        
        .form-check-label {
            font-size: 14px;
            color: #555;
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
        
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }
        
        .divider-line {
            flex-grow: 1;
            height: 1px;
            background-color: #e0e0e0;
        }
        
        .divider-text {
            padding: 0 15px;
            color: #777;
            font-size: 14px;
        }
        
        .social-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .btn-social {
            flex: 1;
            padding: 12px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-google {
            background-color: #ea4335;
        }
        
        .btn-google:hover {
            background-color: #d33426;
        }
        
        .btn-facebook {
            background-color: #3b5998;
        }
        
        .btn-facebook:hover {
            background-color: #2d4373;
        }
        
        .icon {
            margin-right: 8px;
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
        
        .forgot-link {
            text-align: right;
            margin-bottom: 20px;
        }
        
        .forgot-link a {
            color: #4e73df;
            font-size: 14px;
            text-decoration: none;
        }
        
        .forgot-link a:hover {
            text-decoration: underline;
        }
        
        .invalid-feedback {
            color: #ea4335;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-card {
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-card">
            <div class="logo-container">
                <h1 class="login-title">{{ __('Hello Users') }}</h1>
                <p class="login-subtitle">Enter your credentials to access your account</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <input 
                        id="email" 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="Email Address" 
                        required 
                        autocomplete="email" 
                        autofocus>
                    
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <input 
                        id="password" 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        name="password" 
                        placeholder="Password" 
                        required 
                        autocomplete="current-password">
                    
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="form-check">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        name="remember" 
                        id="remember" 
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                {{-- Forgot Password --}}
                <div class="forgot-link">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>

                @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


            </form>
        </div>
    </div>

    {{-- Optional: jQuery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>