@extends('layout.outer.master')

@section('title')
	Online Forms
@stop

@section('content')
<a href="{{ URL::route('sessions.create') }}"><button class="btn btn-lg btn-warning"> Sign in</button></a>
@stop