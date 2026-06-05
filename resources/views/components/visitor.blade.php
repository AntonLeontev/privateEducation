<div class="mb-2" @visitors-update.window="reset" x-data="{
    show: false,
    deviceIcons: {
        desktop: '{{ Vite::asset('resources/images/devices/desktop.svg') }}',
        mobile: '{{ Vite::asset('resources/images/devices/mobile.svg') }}',
        tablet: '{{ Vite::asset('resources/images/devices/tablet.svg') }}',
    },

    reset() {
        this.disposeAllCharts()
        this.show = false
    },
    toggle() {
        this.show = !this.show
        if (this.show) {
            this.$nextTick(() => this.renderAllCharts())
        } else {
            this.disposeAllCharts()
        }
    },
    chartId(kind, fragmentId) {
        return `visit-chart-${kind}-${visit.id}-${fragmentId}`
    },
    renderAllCharts() {
        if (!visit.fragments?.length) {
            return
        }
        for (const fragment of visit.fragments) {
            this.renderFragmentCharts(fragment)
        }
    },
    renderFragmentCharts(fragment) {
        if (typeof window.renderSecondTimelineChart !== 'function') {
            return
        }
        const chartOptions = {
            variant: 'compact',
            durationSeconds: fragment.duration_seconds ?? 0,
        }
        window.renderSecondTimelineChart(
            this.chartId('active', fragment.fragment_id),
            fragment.active_timeline ?? [],
            chartOptions
        )
        window.renderSecondTimelineChart(
            this.chartId('passive', fragment.fragment_id),
            fragment.passive_timeline ?? [],
            chartOptions
        )
    },
    disposeAllCharts() {
        if (!visit.fragments?.length || typeof window.disposeSecondTimelineChart !== 'function') {
            return
        }
        for (const fragment of visit.fragments) {
            window.disposeSecondTimelineChart(this.chartId('active', fragment.fragment_id))
            window.disposeSecondTimelineChart(this.chartId('passive', fragment.fragment_id))
        }
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
    <div class="flex gap-x-2 px-2 py-3 rounded-xl opacity-60 transition cursor-pointer bg-white/20 hover:opacity-100"
         :class="show && '!opacity-100'" @click="toggle">
        <div class="w-[22%] shrink-0 grow-0 overflow-hidden truncate text-secondary"
             :title="visit.visitor?.email"
             x-text="visit.visitor?.email ?? 'Незарегистрированный'"></div>
        <div class="flex w-[20%] items-center justify-center gap-2 text-secondary" title="Страна">
            <span class="fi" :class="flagClass(visit.visitor?.country_code)" x-show="visit.visitor?.country_code" x-cloak></span>
            <span x-text="visit.visitor?.country?.name ?? visit.visitor?.country_name ?? '—'"></span>
        </div>
        <div class="flex w-[14%] items-center justify-center gap-2 text-secondary" title="Устройство">
            <img class="w-5 h-5" :src="deviceIcon(visit.visitor?.device_type)" x-show="deviceIcon(visit.visitor?.device_type)"
                 x-cloak>
            <span x-text="visit.visitor?.device_type ?? '—'"></span>
        </div>
        <div class="w-[12%] text-center text-secondary" title="Порядковый номер визита" x-text="visit.visit_number ?? '—'"></div>
        <div class="w-[22%] text-center text-secondary" title="Дата визита" x-text="visit.started_at ?? '—'"></div>
        <div class="flex w-[5%] cursor-pointer justify-center text-center">
            <svg class="w-6 h-6 transition duration-500 text-secondary" :class="show && 'rotate-180'"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
    </div>
    <div class="grid grid-rows-[0fr] overflow-hidden transition-[grid-template-rows] duration-500"
         :class="show && 'grid-rows-[1fr]'">
        <div class="overflow-hidden px-5 w-full">
            <div class="overflow-hidden mt-2 mb-2 rounded-xl bg-white/20">
                <div class="p-4 text-secondary">
                    <div class="flex flex-wrap gap-6">
                        <div class="min-w-[220px]">
                            <div class="text-sm opacity-60">UTM</div>
                            <div class="text-sm" x-text="visit.utm?.source ?? '—'"></div>
                            <div class="text-sm" x-text="visit.utm?.medium ?? '—'"></div>
                            <div class="text-sm" x-text="visit.utm?.campaign ?? '—'"></div>
                        </div>
                        <div class="min-w-[260px]">
                            <div class="text-sm opacity-60">Источник перехода</div>
                            <div class="text-sm break-all" x-text="visit.referrer ?? '—'"></div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="text-sm opacity-60">Время просмотров по фрагментам</div>
                        <div class="mt-2">
                            <template x-if="visit.fragments?.length">
                                <div class="grid gap-2">
                                    <template x-for="fragment in visit.fragments" :key="visit.id + '-' + fragment.fragment_id">
                                        <div class="flex flex-row flex-wrap items-center gap-x-4 gap-y-2 px-3 py-2 rounded-lg bg-white/10 lg:flex-nowrap">
                                            <div class="text-sm font-bold shrink-0" x-text="'Фрагмент №' + fragment.fragment_id"></div>
                                            <div class="text-sm shrink-0" x-text="'Активный просмотр: ' + formatSeconds(fragment.active_seconds)"></div>
                                            <div class="text-sm shrink-0" x-text="'Пассивный просмотр: ' + formatSeconds(fragment.passive_seconds)"></div>
                                            <div class="flex flex-1 gap-3 min-w-0 basis-full lg:basis-auto">
                                                <div class="flex-1 min-w-[120px] h-14 rounded bg-black/20 overflow-visible" :id="chartId('active', fragment.fragment_id)"></div>
                                                <div class="flex-1 min-w-[120px] h-14 rounded bg-black/20 overflow-visible" :id="chartId('passive', fragment.fragment_id)"></div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!visit.fragments?.length">
                                <div class="text-sm text-secondary">Нет данных по просмотрам.</div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
