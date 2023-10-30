<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<meta http-equiv="content-type" content="text/html;charset=UTF-8">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="robots" content="index, follow">
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tinos:wght@400;700&display=swap');
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;500&display=swap" rel="stylesheet">

	<style>
        [x-cloak] {display: none; !important}
    </style>

	@routes
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/scss/app.scss'])

	<!-- The Perfect Scrollbar JS files --><script src="/js/perfectScroll/perfect-scrollbar.js"></script>
</head>

<body class="page page--index">
	@include('partials.app.header')
	
    @yield('content')

	<script>
		if (document.querySelector(".content-block")) {
			new PerfectScrollbar(".content-block", {
				wheelSpeed: 1.2,
				wheelPropagation: true,
				minScrollbarLength: 100,
			});
		}
	</script>
</body>

</html>
