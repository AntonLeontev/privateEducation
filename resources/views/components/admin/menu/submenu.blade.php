@props([
	'title',
	'img' => '',
])

<li 
	class="relative flex items-center justify-between w-full px-3 py-2 cursor-pointer gap-x-10 hover:bg-primary"
	x-data="{menu: false}"
	@mouseover="menu = true"
	@mouseout="menu = false"
>
	<div class="flex items-center gap-x-1">
		<img width="25px" src="{{ $img }}" alt="">
		<div>
			{{ $title }}
		</div>
	</div>

	<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
		<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
	</svg>


	<ul class="absolute top-0 left-full bg-[#344760] rounded [&>*:nth-child(n)]:!ml-0 flex flex-col gap-y-3 whitespace-nowrap transition text-[1.2vw] shadow-md shadow-gray-800" x-show="menu">
		{{ $slot }}
	</ul>
</li>
