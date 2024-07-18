<style>
	.burger:hover div {
		text-shadow: 0 0 4px rgba(255,250,250,0.8);
	}
</style>

<div class="burger ml-auto group transition-all hover:shadow-[inset_0_0_8px_3px_rgba(255,250,250,0.8),0_0_8px_3px_rgba(255,250,250,0.8)]" x-data
	@click="$dispatch('menu-toggle')"
>
	<div class="transition-all">Меню</div>
	<span class="transition-all group-hover:shadow-[0_0_4px_3px_rgba(255,250,250,0.5)] group-hover:before:shadow-[0_0_4px_3px_rgba(255,250,250,0.5)]  group-hover:after:shadow-[0_0_4px_3px_rgba(255,250,250,0.5)] before:transition-all  after:transition-all"></span>
</div>
