<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="{{ asset('blog_assets/css/login.css') }}">
</head>
<body>
	<div class="login-container">
		<form action="{{ route('login') }}" method="POST" class="form-login">
			@csrf
			<ul class="login-nav">
				<li class="login-nav__item active">
					<a href="#">Sign In</a>
				</li>
				{{-- <li class="login-nav__item">
					<a href="#">Sign Up</a>
				</li> --}}
			</ul>
			<label for="username" class="login__label">
				{{ __('E-Mail Address') }}
			</label>
			<input class="login__input form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" id="username" type="text" name="username" value="{{ old('username') }}" required autofocus/>
			@if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
			<label for="password" class="login__label">
				{{ __('Password') }}
			</label>
			<input class="login__input form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" type="password" name="password" required/>
			@if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
			<label for="login-sign-up" class="login__label--checkbox">
				<input type="checkbox" class="login__input--checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
				Keep me Signed in
			</label>
			<button class="login__submit" type="submit">{{ __('Login') }}</button>
		</form>
		<a href="{{ route('password.request') }}" class="login__forgot"  style="margin-top: 1.5rem;">{{ __('Forgot Your Password?') }}</a>
		<a href="{{ route('register') }}" title="" class="login__forgot" style="margin-top: 1.5rem;">Don't have an account? Sign up</a>
		
	</div>
</body>
</html>