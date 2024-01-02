@extends('common::templates.html')

@section('body')
	<h1>Login</h1>

	@include('common::partials.errors')

	<form action="/login" method="POST" id="logins-creat">
		@csrf

		<div>
			<label for="email">Email</label>
			<input type="text" name="email" id="email" value="{{ old('email') }}" />
		</div>

		<div>
			<label for="password">Password</label>
			<input type="password" name="password" id="password" value="{{ old('password') }}" />
		</div>

		<button type="submit" id="submit">Login</button>
	</form>
@endsection
