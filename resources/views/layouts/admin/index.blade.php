<!DOCTYPE html>
<html lang="ru">
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="robots" content="index, follow">
  <title>@yield('title')</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width">
  <style>@import url('https://fonts.googleapis.com/css2?family=Tinos:wght@400;700&display=swap');</style>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;500&display=swap" rel="stylesheet">

  <style>
	[x-cloak] {display: none;}
  </style>

  @vite(['resources/css/tailwind.css', 'resources/css/admin.css', 'resources/js/app.js'])
</head>
<body class="page page--index">
<div id="panel"></div>
<div class="main main--index">
  
	@include('partials.admin.header')

	@yield('content')
</div>


	@yield('modals')
	@yield('body-scripts')




{{-- <script src="/js/vendorb164.js?v=1674558313"></script>
<script src="/js/mainb164.js?v=1674558313"></script> --}}
</body>

</html>
