@props([
	'stats',
	'page',
	'title' => '',
	'fragment' => 'all',
])

<li 
	class="flex items-center w-full px-3 py-2 cursor-pointer gap-x-1 hover:bg-primary" 
	@click="submenu = false; $dispatch(
		'state-change', 
		{
			stats: '{{ $stats }}', 
			page: '{{ $page }}', 
			fragment: '{{ $fragment }}',
			title: '{{ $title }}',
		}
	)"
>
	{{ $slot }}
</li>
