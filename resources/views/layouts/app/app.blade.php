<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title')</title>
	<meta name="description" content="@yield('description')">

	@yield('css')

	<style>
        [x-cloak] {display: none; !important}
    </style>

	@routes
    @vite(['resources/js/app.js', 'resources/js/index.js'])
</head>
<body>

	@yield('content')

</body>
</html>

