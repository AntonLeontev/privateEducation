@vite('resources/css/app.css')

<div class="">
    <div class="">
        <div class="mb-1 text-lg">Стерео звук</div>

        <div class="flex justify-around gap-x-10">
            <div class="">
                <div class="">Для десктопа</div>


                <div class="flex flex-col items-center cursor-pointer" x-data="{}" @click="$refs.file.click()">
                    <input type="file" name="" class="hidden" x-ref="file" accept="video/*">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#009900" width="40">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                            clip-rule="evenodd" />
                    </svg>

                    <button>
                        Сменить
                    </button>
                </div>
            </div>

            <div class="">
                <div class="">Для планшета</div>

                <div class="flex flex-col items-center cursor-pointer" x-data="{}"
                    @click="$refs.file.click()">
                    <input type="file" name="" class="hidden" x-ref="file" accept="video/*">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#bb0000" width="40">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                            clip-rule="evenodd" />
                    </svg>

                    <button>
                        Загрузить
                    </button>
                </div>

            </div>

            <div class="">
                <div class="">Для телефона</div>

                <div class="flex flex-col items-center cursor-pointer" x-data="{}"
                    @click="$refs.file.click()">
                    <input type="file" name="" class="hidden" x-ref="file" accept="video/*">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#009900" width="40">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                            clip-rule="evenodd" />
                    </svg>

                    <button>
                        Сменить
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-2">
        <div class="mb-1 text-lg">Моно звук</div>

        <div class="flex justify-around gap-x-10">
            <div class="">
                <div class="">Для десктопа</div>


                <div class="flex flex-col items-center cursor-pointer" x-data="{}"
                    @click="$refs.file.click()">
                    <input type="file" name="" class="hidden" x-ref="file" accept="video/*">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#009900" width="40">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                            clip-rule="evenodd" />
                    </svg>

                    <button>
                        Сменить
                    </button>
                </div>
            </div>

            <div class="">
                <div class="">Для планшета</div>

                <div class="flex flex-col items-center cursor-pointer" x-data="{}"
                    @click="$refs.file.click()">
                    <input type="file" name="" class="hidden" x-ref="file" accept="video/*">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#bb0000" width="40">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                            clip-rule="evenodd" />
                    </svg>

                    <button>
                        Загрузить
                    </button>
                </div>

            </div>

            <div class="">
                <div class="">Для телефона</div>

                <div class="flex flex-col items-center cursor-pointer" x-data="{}"
                    @click="$refs.file.click()">
                    <input type="file" name="" class="hidden" x-ref="file" accept="video/*">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#009900" width="40">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                            clip-rule="evenodd" />
                    </svg>

                    <button>
                        Сменить
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
