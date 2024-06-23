<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com-->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="{{ asset('vendor/login/style.css') }}">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Ensure proper rendering and touch zooming on mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        <!-- Hidden checkbox for flipping effect -->
        <input type="checkbox" id="flip">
        <div class="cover">
            <div class="front">
                <div class="text">
                    <!-- Link to the blog home page -->
                    <a style="text-decoration: none" href="{{ route('blog.home') }}">
                        <span class="text-1">BLOQ CODER</span>
                    </a>
                </div>
            </div>
            <div class="back">
                <!-- Backside content -->
                <div class="text">
                    <span class="text-1">Complete miles of journey <br> with one step</span>
                    <span class="text-2">Let's get started</span>
                </div>
            </div>
        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Login</div>
                    <!-- Login form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-boxes">
                            <b class="mt-3">Email</b>
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <!-- Email input field -->
                                <input name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" id="input_login_email" type="email"
                                    placeholder="Enter email address" autocomplete="email" required>
                            </div>
                            @error('email')
                                <span class="invalid-feedback my-2" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                            <div class="mt-3">
                                <b class="small">Password</b>
                                <div class="input-box">
                                    <i class="fas fa-lock"></i>
                                    <!-- Password input field -->
                                    <input name="password"
                                        class="form-control py-4 @error('password') is-invalid @enderror"
                                        id="input_login_password" type="password" placeholder="Enter password"
                                        autocomplete="current-password" required />
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                                <!-- Link to the registration page -->
                                <p>Jika belum memiliki akun silahkan <a href="{{ route('register') }}"
                                        class="register-link">Register disini!</a>
                                </p>
                                <!-- Button container -->
                                <div class="button-container">
                                    <!-- Login button -->
                                    <button class="login-button" type="submit" value="Login">Login</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
