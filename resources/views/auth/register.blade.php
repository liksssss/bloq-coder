<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com-->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
                    <div class="title">Register Pengunjung</div>
                    <!-- Register form -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="input-boxes">
                            <b class="mt-3">Name</b>
                            <div class="input-box">
                                <i class="fas fa-user"></i>
                                <!-- Name input field -->
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus
                                    placeholder="Enter name" required>
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <b class="mt-3">Email</b>
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <!-- Email input field -->
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email"
                                    placeholder="Enter email address" required>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="mt-3">
                                <b class="mt-3">Password</b>
                                <div class="input-box">
                                    <i class="fas fa-lock"></i>
                                    <!-- Password input field -->
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" placeholder="Enter password">
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <b class="mt-3">Confirm Password</b>
                                <div class="input-box">
                                    <i class="fas fa-lock"></i>
                                    <!-- Confirm password input field -->
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="Confirm password" required>
                                </div>
                                <!-- Hidden role input -->
                                <input type="hidden" name="role" value="Pengunjung">
                                <!-- Link to the login page -->
                                <p>Jika Sudah Punya Akun <a href="{{ route('login') }}" class="login-link">Login
                                        disini!</a>
                                </p>
                                <!-- Button container -->
                                <div class="button-container">
                                    <!-- Register button -->
                                    <button class="login-button" type="submit">Register</button>
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
