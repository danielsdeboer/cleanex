@php
	/** @var \Application\Todos\Core\Entities\BucketList $buckets */
@endphp

@extends('common::templates.html')

@section('body')
	<h1>Todo Buckets</h1>

	<ul>
		@forelse($buckets as $bucket)
			<li>
				<strong>{{ $bucket->getName() }}</strong>
				<a href="{{ route('todos::buckets.show', $bucket->getId()) }}">
					({{ $bucket->getId() }})
				</a>
			</li>
		@empty
			<li>No todo buckets found.</li>
		@endforelse
	</ul>

	<a href="{{ $createRoute }}">Create a new bucket</a>
@endsection
