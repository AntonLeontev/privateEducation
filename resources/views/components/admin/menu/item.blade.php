@props([
	'image' => null,
	'title',
])


<li class="relative" x-data="{submenu: false}" @mouseover="submenu = true" @mouseout="submenu = false">
	<div class="flex items-center py-2 cursor-pointer gap-x-1">
		@if (!empty($image))
			<img width="25px" src="{{ $image }}" alt="">
		@endif
		<span class="text-[#344760] text-[1.2vw] font-[500]" :class="submenu && '!text-primary'">{{ $title }}</span>
	</div>
	
	<ul 
		class="absolute bg-[#344760] rounded top-[calc(1.2vw+1rem)] [&>*:nth-child(n)]:!ml-0 flex flex-col gap-y-3 whitespace-nowrap transition text-[1.2vw] overflow-hidden shadow-md shadow-gray-800"
		x-show="submenu"
		style="display: none"
	>
		{{ $slot }}
	</ul>
</li>
