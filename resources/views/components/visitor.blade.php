<div class="mb-2" @visitors-update.window="reset" x-data="{
    show: false,
    loading: false,
    details: null,
    deviceIcons: {
        desktop: '{{ Vite::asset('resources/images/devices/desktop.svg') }}',
        mobile: '{{ Vite::asset('resources/images/devices/mobile.svg') }}',
        tablet: '{{ Vite::asset('resources/images/devices/tablet.svg') }}',
    },

    reset() {
        this.show = false
        this.loading = false
        this.details = null
    },
    toggle() {
        this.show = !this.show

        if (this.show && !this.details) {
            this.loadDetails()
        }
    },
    loadDetails() {
        this.loading = true

        axios
            .get(route('admin.visitors.show', visitor.id))
            .then(response => {
                this.details = response.data
            })
            .catch(error => {
                alert('Ошибка. Перезагрузите страницу')
            })
            .finally(() => {
                this.loading = false
            })
    },
    formatSeconds(seconds) {
        if (seconds === null || seconds === undefined) {
            return '0:00'
        }

        const totalSeconds = Number(seconds)
        const hours = Math.floor(totalSeconds / 3600)
        const minutes = Math.floor((totalSeconds % 3600) / 60)
        const secs = totalSeconds % 60
        const padded = String(secs).padStart(2, '0')

        if (hours > 0) {
            return `${hours}:${String(minutes).padStart(2, '0')}:${padded}`
        }

        return `${minutes}:${padded}`
    },
    flagClass(code) {
        if (!code) {
            return ''
        }

        return `fi fi-${String(code).toLowerCase()}`
    },
    deviceIcon(type) {
        if (!type) {
            return null
        }

        return this.deviceIcons[type] ?? this.deviceIcons.desktop
    },
}">
    <div class="flex cursor-pointer gap-x-2 rounded-xl bg-white/20 px-2 py-3 opacity-60 transition hover:opacity-100"
         :class="show && '!opacity-100'" @click="toggle">
        <div class="w-[20%] shrink-0 grow-0 overflow-hidden truncate text-secondary" :title="visitor.email"
             x-text="visitor.email ?? 'Незарегистрированный'"></div>
        <div class="flex w-[18%] items-center justify-center gap-2 text-secondary" title="Страна">
            <span class="fi" :class="flagClass(visitor.country_code)" x-show="visitor.country_code" x-cloak></span>
            <span x-text="visitor.country?.name ?? visitor.country_name ?? '—'"></span>
        </div>
        <div class="flex w-[12%] items-center justify-center gap-2 text-secondary" title="Устройство">
            <img class="h-5 w-5" :src="deviceIcon(visitor.device_type)" x-show="deviceIcon(visitor.device_type)"
                 x-cloak>
            <span x-text="visitor.device_type ?? '—'"></span>
        </div>
        <div class="w-[18%] text-center text-secondary" title="Первый визит" x-text="visitor.first_visit_at ?? '—'">
        </div>
        <div class="w-[10%] text-center text-secondary" title="Всего визитов" x-text="visitor.visits_count ?? 0"></div>
        <div class="w-[18%] text-center text-secondary" title="Последний визит" x-text="visitor.last_visit_at ?? '—'">
        </div>
        <div class="w-[20%] truncate text-center text-secondary" title="Referrer" x-text="visitor.referrer_last ?? '—'">
        </div>
        <div class="flex w-[5%] cursor-pointer justify-center text-center">
            <svg class="h-6 w-6 text-secondary transition duration-500" :class="show && 'rotate-180'"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
    </div>
    <div class="grid grid-rows-[0fr] overflow-hidden transition-[grid-template-rows] duration-500"
         :class="show && 'grid-rows-[1fr]'">
        <div class="w-full overflow-hidden px-5">
            <div class="mb-2 mt-2 overflow-hidden rounded-xl bg-white/20">
                <div class="p-4 text-secondary">
                    <div class="flex flex-wrap gap-6">
                        <div class="min-w-[220px]">
                            <div class="text-sm opacity-60">UTM (первый визит)</div>
                            <div class="text-sm" x-text="visitor.utm_first?.source ?? '—'"></div>
                            <div class="text-sm" x-text="visitor.utm_first?.medium ?? '—'"></div>
                            <div class="text-sm" x-text="visitor.utm_first?.campaign ?? '—'"></div>
                        </div>
                        <div class="min-w-[220px]">
                            <div class="text-sm opacity-60">UTM (последний визит)</div>
                            <div class="text-sm" x-text="visitor.utm_last?.source ?? '—'"></div>
                            <div class="text-sm" x-text="visitor.utm_last?.medium ?? '—'"></div>
                            <div class="text-sm" x-text="visitor.utm_last?.campaign ?? '—'"></div>
                        </div>
                        <div class="min-w-[260px]">
                            <div class="text-sm opacity-60">Источник перехода</div>
                            <div class="break-all text-sm" x-text="visitor.referrer_first ?? '—'"></div>
                            <div class="break-all text-sm" x-text="visitor.referrer_last ?? '—'"></div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="flex items-center gap-2 text-sm opacity-60">
                            <span>Время просмотров по фрагментам</span>
                            <span class="loading loading-dots loading-sm" x-show="loading" x-cloak></span>
                        </div>
                        <div class="mt-2">
                            <template x-if="details?.fragments?.length">
                                <div class="grid gap-2">
                                    <template x-for="fragment in details.fragments">
                                        <div class="flex justify-between rounded-lg bg-white/10 px-3 py-2">
                                            <div class="text-sm" x-text="'Фрагмент №' + fragment.fragment_id"></div>
                                            <div class="flex gap-6 text-sm">
                                                <div x-text="'Актив: ' + formatSeconds(fragment.active_seconds)"></div>
                                                <div x-text="'Пассив: ' + formatSeconds(fragment.passive_seconds)">
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="details && (!details.fragments || details.fragments.length === 0)">
                                <div class="text-sm text-secondary">Нет данных по просмотрам.</div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
