@extends('layouts.admin.index')

@section('title', 'Seo')

@section('content')
    <div class="w-full" x-data="seo">
		<header class="my-3 header">
			<div class="container container-header">
				<span class="!mb-0 mr-10 player__title__bg">
					Seo
				</span>
				<x-admin.menu-button />
			</div>
		</header>
	</div>
    
	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('seo', () => ({
				
			}))
		})
	</script>

@endsection

@section('modals')
    @include('partials.admin.modal')

    @include('partials.admin.menu')

@endsection

@section('body-scripts')

@endsection
