@extends('errors.master')

@section('custom-head')
	<link rel="stylesheet" type="text/css" href="{{mix('/css/app.css')}}">
@endsection

@section('content')
	<h1>503, service unavailable</h1>
	<p>(probably means that I'm making changes to the site)</p>
	<p>🍄</p>
@endsection