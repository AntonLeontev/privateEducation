<div class="" x-show="!(lang === 'en' && selectedFragment.id === 9)">
    <div class="">
        <div class="mb-1 text-lg">Стерео звук</div>

        <div class="flex justify-around gap-x-10">
            <div class="">
                <div class="">Для ноутбука</div>


                <x-admin.upload-media-input device="notebook" sound="stereo" />
            </div>

            <div class="">
                <div class="">Для планшета</div>

                <x-admin.upload-media-input device="tablet" sound="stereo" />

            </div>

            <div class="">
                <div class="">Для телефона</div>

                <x-admin.upload-media-input device="mobile" sound="stereo" />
            </div>
        </div>
    </div>

    <div class="pt-2">
        <div class="mb-1 text-lg">Моно звук</div>

        <div class="flex justify-around gap-x-10">
            <div class="">
                <div class="">Для ноутбука</div>


                <x-admin.upload-media-input device="notebook" sound="mono" />
            </div>

            <div class="">
                <div class="">Для планшета</div>

                <x-admin.upload-media-input device="tablet" sound="mono" />

            </div>

            <div class="">
                <div class="">Для телефона</div>

                <x-admin.upload-media-input device="mobile" sound="mono" />
            </div>
        </div>

    </div>

	<div class="fixed top-0 bottom-0 left-0 right-0 z-50 flex items-center justify-center" style="display: none" x-show="progressbar">
		<div class="flex flex-col justify-center w-1/2 p-5 shadow-xl bg-[#918a8a] gap-y-1 rounded-xl border">
			<div class="text-lg text-center">Загрузка</div>
			<div class="relative w-full bg-white h-[40px] rounded-xl overflow-hidden">
				<div class="absolute top-0 bottom-0 left-0 bg-[#e9752c]" :style="'width: ' + (progress * 100) + '%'"></div>
			</div>
		</div>
	</div>
</div>
