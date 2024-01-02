@extends('common::templates.html')

@section('body')
	<h1>Create a new Todo</h1>
	<h2>In {{ $bucketName }} ({{ $bucketId }})</h2>

	@include('common::partials.errors')

	<form action="{{ $storeUrl }}" method="POST" id="todos-create">
		@csrf

		<div>
			<label for="name">Name</label>
			<input type="text" name="name" id="name" value="{{ $name }}" />
		</div>

		<button type="submit" id="submit">Create</button>
	</form>
@endsection
