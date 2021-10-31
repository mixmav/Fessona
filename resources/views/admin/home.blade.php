@extends('admin.master')

@section('custom-head')
@endsection

@section('content')
	<div id="top-bar">
		<h1>Admin</h1>
		<a href="/admin/logout" class="a">Logout</a>
	</div>

	<div id="main-content">
		<h1>Hey, {{ auth()->user()->name }}</h1>
		<h2 class="mt-20">Latest unapproved balloons</h2>
		
		<div id="balloons">
			@foreach ($unapproved_balloons as $unapproved_balloon)
				<div class="balloon">
					<p>Date created: <span class="text-decor bold primary">{{ $unapproved_balloon->created_at }}</span></p>
					<p class="ql-editor">{!! $unapproved_balloon->content !!}</p>

					<div class="buttons">
						<button onclick="confirmApprove(event)" data-href="/admin/approve/{{ $unapproved_balloon->id }}" class="btn"><i class="fa fa-check-circle"></i>Approve</button>
						<button onclick="confirmReject(event)" data-href="/admin/reject/{{ $unapproved_balloon->id }}" class="btn red"><i class="fa fa-trash-alt"></i>Reject</button>
					</div>
				</div>
			@endforeach
			@if (sizeof($unapproved_balloons) <= 0)
				<h3>Empty 😀</h3>
			@endif
		</div>
	</div>
@endsection

@section('custom-post-script')
	<script>
		function confirmApprove(event){
			if (confirm("Approve this balloon?")) {
				window.location.href = event.target.getAttribute('data-href');
			}
		}

		function confirmReject(event){
			if (confirm("Reject this balloon?")) {
				window.location.href = event.target.getAttribute('data-href');
			}
		}
	</script>
@endsection