@extends('common::templates.html')

@section('body')
	<h1>Register</h1>

	@include('common::partials.errors')

	<form action="/register" method="POST" id="logins-creat">
		@csrf

		<div>
			<label for="name">Name</label>
			<input type="text" name="name" id="name" value="{{ old('name') }}"/>
		</div>

		<div>
			<label for="email">Email</label>
			<input type="email" name="email" id="email" value="{{ old('email') }}"/>
		</div>

		<div>
			<label for="password">Password</label>
			<input
				type="password"
				name="password"
				id="password"
				value="{{ old('password') }}"
			/>
		</div>

		<div>
			<label for="password_confirmation">Password Confirmation</label>
			<input
				type="password"
				name="password_confirmation"
				id="password_confirmation"
				value="{{ old('password_confirmation') }}"
			/>
		</div>

		<button type="submit" id="submit">Register</button>
	</form>
@endsection
