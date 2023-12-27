@extends('common::templates.html')

@section('body')
	<h1>Create a new Bucket</h1>

	@include('common::partials.errors')

	<form action="{{ $storeUrl }}" method="POST">
		@csrf

		<div>
			<label for="name">Name</label>
			<input type="text" name="name" id="name" value="{{ $name }}" />
		</div>

		<button type="submit" id="submit">Create</button>
	</form>
@endsection
