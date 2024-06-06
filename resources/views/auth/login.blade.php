<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    /* Global Styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f2f2f2;
    }

    /* Login Container Styles */
    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    /* Login Card Styles */
    .login-card {
      background-color: white;
      display: flex;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      width: 70%;

      max-width: 900px;
    }

    /* Login Form Styles */
    .login-form {
      flex: 1;
      padding: 40px;
      height: 340px;
    }

    .login-form h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    .login-form input {
      width: 100%;
      padding: 12px 10px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .login-form button {
      background-color: #4CAF50;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
    }

    .login-form button:hover {
      background-color: #45a049;
    }
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('assets/images/background.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }
    /* Image Styles */
    .login-image {
      flex: 1;
      background-image: url('assets/images/photo-logo.jpg');
      background-size: cover;
      background-position: center;
      border-radius: 0 10px 10px 0;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
      .login-card {
        flex-direction: column;
        width: 90%;
      }

      .login-image {
        height: 300px;
        border-radius: 10px 10px 0 0;
      }
    }
  </style>
</head>
<body> <h1 style="color:red;padding-left:430px;">Welcome To Dashboard</h1>
  <div class="login-container">
    <div class="login-card">
      <div class="login-form">
       
        <h2>Login</h2>
        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="row mb-3">
              <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>


              <div class="col-md-6">
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          
          <div class="row mb-3">
              <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

              <div class="col-md-6">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="row mb-3">
              <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                      <label class="form-check-label" for="remember">
                          {{ __('Remember Me') }}
                      </label>
                  </div>
              </div>
          </div>

          <div class="row mb-0">
              <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                      {{ __('Login') }}
                  </button>

                  @if (Route::has('password.request'))
                      <a class="btn btn-link" href="{{ route('password.request') }}">
                          {{ __('Forgot Your Password?') }}
                      </a>
                  @endif
              </div>
          </div>
      </form>
      </div>
      <div class="login-image"></div>
    </div>
  </div>
</body>
</html>