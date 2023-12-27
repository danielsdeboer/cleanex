@extends('common::templates.html')

@section('body')
	<h1>Hello World</h1>

	<a href="{{ route('buckets::index') }}">Todos</a>
@endsection
