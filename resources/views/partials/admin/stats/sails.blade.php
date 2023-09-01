<div class="h-full pt-1 player__content" x-data="sails">

    <form class="flex justify-between" x-ref="form">
        <select 
			class="bg-transparent border cursor-pointer rounded-none px-1 py-2 text-[16px]" 
			name="period"
			x-model="period"
			@change="changePeriod" 
			x-ref="select"
		>
            <option value="today">За сегодня на {{ now()->format('H:i') }}</option>
            <option value="yesterday">За вчера</option>
            <option value="week">За эту неделю</option>
            <option value="month">За этот месяц</option>
            <option value="quarter">За этот квартал</option>
            <option value="year">За этот год</option>
            <option value="custom">За произвольный период</option>
        </select>

		<label class="w-min text-[14px] flex gap-x-1 items-center" x-show="period === 'custom'" x-transition x-cloak>
			<input 
				name="start" 
				type="date" 
				class="px-2 py-1 bg-transparent border border-t-0 rounded-none border-x-0 focus:outline-none" 
				x-ref="start"
				@change="changePeriod"
			>
		</label>

		<span class="flex items-center" x-show="period === 'custom'" x-transition x-cloak>-</span>

		<label class="w-min text-[14px] flex gap-x-1 items-center" x-show="period === 'custom'" x-transition x-cloak>
			<input 
				name="end" 
				type="date" 
				class="px-2 py-1 bg-transparent border border-t-0 rounded-none border-x-0 focus:outline-none" 
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
                        <div class="mb-1 text-center">Сумма продаж</div>
                        <div class="bg-secondary flex items-center justify-center p-6 text-[4vw]"
                            x-text="ru + en + ' €'">

                        </div>
                        <div class="absolute -right-[15px] bottom-0 top-[22.4px] w-[10px]">
                            <div class="bg-[#aa0000] transition-all duration-500"
                                :style="'height: ' + getPercent(ru) + '%;'"></div>
                            <div class="bg-[#0000aa] transition-all duration-500"
                                :style="'height: ' + getPercent(en) + '%;'"></div>

                            <div class="absolute left-[15px] top-0 flex w-max items-center gap-x-1">
                                <span>RU:</span>
                                <span class="text-[20px]" x-text="ru + ' €'"></span>
                            </div>
                            <div class="absolute bottom-0 left-[15px] flex w-max items-center gap-x-1">
                                <span>US:</span>
                                <span class="text-[20px]" x-text="en + ' €'"></span>
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
					this.$watch('page', value => {
						if (this.stats != 'sails') return;

						this.update();
					});
					this.$watch('fragment', value => {
						if (this.stats != 'sails') return;

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
					if (this.stats !== 'views' && this.stats !== 'sails') return;

					let url;
					if (this.stats === 'sails') url = route('admin.sales');
					if (this.stats === 'views') url = route('admin.views');

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
