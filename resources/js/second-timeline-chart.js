import * as am5 from '@amcharts/amcharts5';
import * as am5xy from '@amcharts/amcharts5/xy';
import am5themes_Animated from '@amcharts/amcharts5/themes/Animated';

const chartRoots = new Map();

const COMPACT_LINE_COLOR = 0xe8e4df;
const COMPACT_FILL_TOP = 0xffffff;
const COMPACT_GRID_COLOR = 0x8a8278;
const COMPACT_AXIS_LABEL_COLOR = 0xffffff;

/**
 * @param {string|{title?: string, variant?: 'compact'|'detail', durationSeconds?: number}} third
 * @returns {{title: string, variant: 'compact'|'detail', durationSeconds: number}}
 */
function normalizeOptions(third) {
    if (typeof third === 'string') {
        return { title: third, variant: 'detail', durationSeconds: 0 };
    }

    const opts = third ?? {};

    return {
        title: opts.title ?? '',
        variant: opts.variant === 'detail' ? 'detail' : 'compact',
        durationSeconds: Number(opts.durationSeconds ?? 0),
    };
}

function formatTimelineSeconds(totalSeconds) {
    const total = Number(totalSeconds);
    const hours = Math.floor(total / 3600);
    const minutes = Math.floor((total % 3600) / 60);
    const secs = total % 60;
    const padded = String(secs).padStart(2, "0");

    if (hours > 0) {
        return `${hours}:${String(minutes).padStart(2, "0")}:${padded}`;
    }

    return `${minutes}:${padded}`;
}

/**
 * @param {Array<{second_index?: number, hit_count?: number}>} points
 * @param {number} durationSeconds
 */
export function buildDenseTimeline(points, durationSeconds) {
    const length = resolveTimelineLength(points, durationSeconds);
    if (length <= 0) {
        return { data: [], length: 0 };
    }

    const map = new Map();
    for (const point of points ?? []) {
        const second = Number(point.second_index ?? point.second);
        map.set(second, Number(point.hit_count ?? point.hits ?? 0));
    }

    const data = [];
    for (let second = 0; second < length; second++) {
        data.push({
            second,
            hits: map.get(second) ?? 0,
            timeLabel: formatTimelineSeconds(second),
        });
    }

    return { data, length };
}

/**
 * @param {Array<{second_index?: number}>} points
 * @param {number} durationSeconds
 */
function resolveTimelineLength(points, durationSeconds) {
    const duration = Number(durationSeconds) || 0;
    if (duration > 0) {
        return duration;
    }

    if (!points?.length) {
        return 0;
    }

    const maxSecond = Math.max(
        ...points.map((point) => Number(point.second_index ?? point.second ?? 0))
    );

    return maxSecond + 1;
}

function showEmptyState(el) {
    el.innerHTML =
        '<div class="flex justify-center items-center h-full text-xs opacity-60">Нет данных</div>';
}

const TIMELINE_TOOLTIP_TEXT =
    'Время: {timeLabel}\nПросмотров: {valueY.formatNumber("#.")}';

function createTimelineTooltip(root) {
    const tooltip = am5.Tooltip.new(root, {
        labelText: TIMELINE_TOOLTIP_TEXT,
    });
    tooltip.get('background')?.setAll({
        fill: am5.color(0x1a1a1a),
        fillOpacity: 0.92,
        stroke: am5.color(0x666666),
    });
    tooltip.label.setAll({
        fill: am5.color(0xffffff),
        fontSize: 12,
    });

    return tooltip;
}

function attachChartCursor(chart, root, xAxis, series) {
    const cursor = chart.set(
        'cursor',
        am5xy.XYCursor.new(root, {
            behavior: 'none',
            xAxis,
            snapToSeries: [series],
        })
    );
    cursor.lineY.set('visible', false);
    cursor.lineX.setAll({
        strokeOpacity: 0.35,
        stroke: am5.color(COMPACT_GRID_COLOR),
    });

    return cursor;
}

/**
 * @param {string} containerId
 * @param {Array<{second_index: number, hit_count: number}>} points
 * @param {string|object} [options]
 */
export function renderSecondTimelineChart(containerId, points, options = '') {
    disposeSecondTimelineChart(containerId);

    const el = document.getElementById(containerId);
    if (!el) {
        return null;
    }

    const { title, variant, durationSeconds } = normalizeOptions(options);
    const { data, length } = buildDenseTimeline(points, durationSeconds);

    if (length <= 0) {
        showEmptyState(el);

        return null;
    }

    el.innerHTML = '';

    const root = am5.Root.new(containerId);
    if (variant === 'detail') {
        root.setThemes([am5themes_Animated.new(root)]);
    }

    if (variant === 'compact') {
        return renderCompactChart(root, containerId, data, length);
    }

    return renderDetailChart(root, containerId, data, title, length);
}

function renderCompactChart(root, containerId, chartData, length) {
    const chart = root.container.children.push(
        am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            wheelX: 'none',
            wheelY: 'none',
            paddingLeft: 0,
            paddingRight: 0,
            paddingTop: 0,
            paddingBottom: 16,
        })
    );

    const xRenderer = am5xy.AxisRendererX.new(root, {
        minGridDistance: 40,
    });
    xRenderer.labels.template.setAll({
        visible: true,
        fontSize: 11,
        fontWeight: '600',
        fill: am5.color(COMPACT_AXIS_LABEL_COLOR),
        fillOpacity: 1,
    });
    xRenderer.labels.template.adapters.add('text', (text, target) => {
        const value = target.dataItem?.get('value');
        if (value == null || Number.isNaN(Number(value))) {
            return '';
        }

        return String(Math.round(Number(value) / 60));
    });
    xRenderer.grid.template.setAll({
        stroke: am5.color(COMPACT_GRID_COLOR),
        strokeOpacity: 0.2,
    });

    const xAxis = chart.xAxes.push(
        am5xy.ValueAxis.new(root, {
            renderer: xRenderer,
            min: 0,
            max: Math.max(0, length - 1),
            strictMinMax: true,
            interval: 60,
        }),
    );

    const yRenderer = am5xy.AxisRendererY.new(root, {});
    yRenderer.labels.template.set('visible', false);
    yRenderer.grid.template.set('visible', false);

    const yAxis = chart.yAxes.push(
        am5xy.ValueAxis.new(root, {
            renderer: yRenderer,
            min: 0,
            extraMax: 0.15,
        })
    );

    const tooltip = createTimelineTooltip(root);

    const series = chart.series.push(
        am5xy.SmoothedXLineSeries.new(root, {
            xAxis,
            yAxis,
            valueYField: 'hits',
            valueXField: 'second',
            tension: 0.7,
            tooltip,
        })
    );

    series.strokes.template.setAll({
        strokeWidth: 1.5,
        stroke: am5.color(COMPACT_LINE_COLOR),
        interactive: true,
    });

    attachChartCursor(chart, root, xAxis, series);

    series.fills.template.setAll({
        visible: true,
        fillOpacity: 0.35,
        fill: am5.color(COMPACT_FILL_TOP),
    });

    series.fills.template.set(
        'fillGradient',
        am5.LinearGradient.new(root, {
            rotation: 90,
            stops: [
                { color: am5.color(COMPACT_FILL_TOP), opacity: 0.45 },
                { color: am5.color(COMPACT_FILL_TOP), opacity: 0 },
            ],
        })
    );

    series.data.setAll(chartData);
    chartRoots.set(containerId, root);

    return root;
}

function renderDetailChart(root, containerId, chartData, title, length) {
    const chart = root.container.children.push(
        am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            wheelX: 'none',
            wheelY: 'none',
            layout: root.verticalLayout,
        })
    );

    if (title) {
        chart.children.unshift(
            am5.Label.new(root, {
                text: title,
                fontSize: 12,
                fill: am5.color(0x666666),
                paddingBottom: 4,
            })
        );
    }

    const xAxis = chart.xAxes.push(
        am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererX.new(root, {}),
            min: 0,
            max: Math.max(0, length - 1),
            strictMinMax: length > 0,
            tooltip: am5.Tooltip.new(root, {}),
        })
    );
    xAxis.children.push(
        am5.Label.new(root, {
            text: 'Секунда',
            x: am5.p50,
            centerX: am5.p50,
        })
    );

    const yAxis = chart.yAxes.push(
        am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererY.new(root, {}),
            min: 0,
            extraMax: 0.1,
        })
    );
    yAxis.children.unshift(
        am5.Label.new(root, {
            text: 'hit_count',
            rotation: -90,
            y: am5.p50,
            centerX: am5.p50,
        })
    );

    const tooltip = createTimelineTooltip(root);

    const series = chart.series.push(
        am5xy.ColumnSeries.new(root, {
            xAxis,
            yAxis,
            valueYField: 'hits',
            valueXField: 'second',
            tooltip,
        })
    );

    series.columns.template.setAll({
        width: am5.percent(90),
        interactive: true,
    });

    attachChartCursor(chart, root, xAxis, series);

    series.data.setAll(chartData);
    series.appear(500);
    chart.appear(500, 100);

    chartRoots.set(containerId, root);

    return root;
}

export function disposeSecondTimelineChart(containerId) {
    const existing = chartRoots.get(containerId);
    if (existing) {
        existing.dispose();
        chartRoots.delete(containerId);
    }
}

window.renderSecondTimelineChart = renderSecondTimelineChart;
window.disposeSecondTimelineChart = disposeSecondTimelineChart;
