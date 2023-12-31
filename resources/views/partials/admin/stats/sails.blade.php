<div class="h-full pt-1 player__content" x-data="sails">

    <form class="flex justify-between" x-ref="form">
        <select 
			class="bg-transparent border cursor-pointer rounded-none px-1 py-2 text-[16px] font-bold focus:outline-none" 
			name="period"
			x-model="period"
			@change="changePeriod" 
			x-ref="select"
		>
            <option class="text-black" value="today">За сегодня на {{ now()->format('H:i') }}</option>
            <option class="text-black" value="yesterday">За вчера</option>
            <option class="text-black" value="week">За эту неделю</option>
            <option class="text-black" value="month">За этот месяц</option>
            <option class="text-black" value="quarter">За этот квартал</option>
            <option class="text-black" value="year">За этот год</option>
            <option class="text-black" value="custom">За произвольный период</option>
        </select>

		<label class="w-min text-[14px] flex gap-x-1 items-center">
			<input 
				name="start" 
				type="date" 
				class="px-2 py-1 bg-transparent border border-t-0 rounded-none border-x-0 focus:outline-none disabled:text-[#bbb] disabled:border-[#bbb]" 
				:disabled="period !== 'custom'"
				x-ref="start"
				@change="changePeriod"
			>
		</label>

		<span class="flex items-center" :class="period !== 'custom' && 'text-[#bbb]'">-</span>

		<label class="w-min text-[14px] flex gap-x-1 items-center">
			<input 
				name="end" 
				type="date" 
				class="px-2 py-1 bg-transparent border border-t-0 rounded-none border-x-0 focus:outline-none disabled:text-[#bbb] disabled:border-[#bbb]"
				:disabled="period !== 'custom'" 
				x-ref="end"
				@change="changePeriod"
			>
		</label>
    </form>

    <div class="flex flex-col justify-center w-full h-[calc(100%-37px)] py-1">
        <div>

            <div class="flex items-center justify-center">

                <div class="flex items-center justify-around w-full">
                    <div class="relative">
                        {{-- <div class="mb-1 text-center">Сумма продаж</div> --}}
                        <div class="bg-gradient-to-r from-[#4f60ca] to-transparent font-bold flex items-center justify-center p-6 text-[4vw] min-w-[150px]">
							<span x-text="ru + en"></span>
							<span x-show="stats === 'sails'">&nbsp;€</span>
                        </div>
                        <div class="absolute -right-[15px] top-0 bottom-0 w-[10px]">
                            <div class="transition-all duration-500 bg-primary"
                                :style="'height: ' + getPercent(ru) + '%;'"></div>
                            <div class="transition-all duration-500 bg-white"
                                :style="'height: ' + getPercent(en) + '%;'"></div>

                            <div class="absolute left-[15px] top-0 font-[600] flex w-max items-center gap-x-1">
                                <span class="">RU:</span>
                                <span class="text-[20px]" x-text="ru"></span>
								<span x-show="stats === 'sails'">&nbsp;€</span>
                            </div>
                            <div class="absolute bottom-0 font-[600] left-[15px] flex w-max items-center gap-x-1">
                                <span>US:</span>
                                <span class="text-[20px]" x-text="en"></span>
								<span x-show="stats === 'sails'">&nbsp;€</span>
                            </div>
                        </div>

                    </div>


                </div>
            </div>

        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sails', () => ({
                period: 'today',
                en: null,
                ru: null,

                init() {
					this.update();
					this.$watch('stats', value => {
						this.update();
					});
					this.$watch('page', value => {
						this.update();
					});
					this.$watch('fragment', value => {
						this.update();
					});
                },
                changePeriod() {
                    this.period = this.$refs.select.value;

					if (this.period === 'custom' &&
						(this.$refs.start.value === '' || this.$refs.end.value === '')) {
						return;
					}

					this.update();
					this.$dispatch('period-change', {
						period: this.period,
						start: this.$refs.start.value,
						end: this.$refs.end.value,
						content: this.page,
					})
                },
                getPercent(value) {
                    return Math.round(value * 100 / (this.ru + this.en));
                },
				update() {
					if (this.stats !== 'views' && this.stats !== 'sails' && this.stats !== 'pres') return;

					let url;
					if (this.stats === 'sails') url = route('admin.sales');
					if (this.stats === 'views') url = route('admin.views');
					if (this.stats === 'pres') url = route('admin.pres');

					axios
						.get(url, {
							params: {
								fragment: this.fragment,
								period: this.period,
								start: this.$refs.start.value,
								end: this.$refs.end.value,
								content: this.page,
							},
						})
						.then(response => {
							this.en = response.data.en;
							this.ru = response.data.ru;
						})
				},
            }))
        })
    </script>
</div>
