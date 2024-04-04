<!doctype html>
<html lang="en">
  <head>
  	<title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet"
          href=
"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet"
          href=
"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity=
"sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



	</head>
    @section('content')
	<body>
    <img src="{{ asset('assets/images/iit-logo.png') }}" class="logo">
		<p class="nmpc">MSU-IIT ENERGY<br>MANAGEMENT SYSTEM</p>
	<!--	
		<div class="title-container">
			<img src="images\nmpc-logo.png" class="logo">
			<div class="nmpc">
				<p>MSU-IIT</p> 
				<p>NATIONAL MULTI-PURPOSE</p>
				<p>COOPERATIVE</p>
			</div>
			</div>-->
		
	
	
		<svg class="yellow" xmlns="http://www.w3.org/2000/svg" width="1203" height="202" viewBox="0 0 1203 202" fill="none">
			<path d="M0 0C0 0 553.527 96.2186 906 58C1037.62 43.729 1240 0 1240 0V202H0V0Z" fill="#FFF84E"/>
		  </svg>
		  
		  <svg class="red" xmlns="http://www.w3.org/2000/svg" width="1920" height="488" viewBox="0 0 1920 488" fill="none">
			<path d="M0 6.00001C0 6.00001 258.634 -7.11384 423.5 6.00001C552.08 16.2276 623.749 28.5903 750.5 52.5C977.706 95.3592 1093.51 170.499 1321.5 209C1443.78 229.65 1513 246.602 1637 245C1748.4 243.561 1920 209 1920 209V528H0V6.00001Z" fill="#941E1E"/>
		  </svg>
		  
		  
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				
			</div>
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
		      	<div class="icon d-flex align-items-center justify-content-center">
		      		<span class="fa fa-user"></span>
		      	</div>
		      	<h3 class="text-center mb-4">{{ __('Login') }}</h3>

                  <form method="POST" action="{{ route('login') }}">
                        @csrf

		      		<div class="form-group">
		      			<input type="email" id="email" class="form-control rounded-left @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="off" autofocus>
                          @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
		      		</div>

					  <div class="form-group d-flex position-relative">
    <input type="password" id="password" class="form-control rounded-left @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
    <i class="bi bi-eye-slash toggle-password-icon" id="togglePassword"></i>
    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary rounded submit px-3"  onclick="showSuccessAlert()">{{ __('Log In') }}</button>
	            </div>
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
	            		<label class="checkbox-wrap checkbox-primary">Remember Me
									  <input type="checkbox" checked>
									  <!-- <span class="checkmark"></span> -->
									</label>
								</div>
								<div class="w-50 text-md-right">
									  @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
								</div>
	            </div>
	          </form>
	        </div>
				</div>
			</div>
		</div>
	</section>
	

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/popper.js') }}"></script>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', () => {
    
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

    
        togglePassword.classList.toggle('bi-eye');
    });
</script>

<script>
    function showSuccessAlert() {
        Swal.fire({
            icon: 'success',
            title: 'Login Successful',
            text: 'Welcome!',
            showConfirmButton: false,
            timer: 1500 // Set the timer for the alert to automatically close after 1.5 seconds
        });
    }
</script>

	</body>
</html>
