<div class="h-full pt-1 player__content" x-data="metrics">


    <div id="chart" class="w-full h-full"></div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('metrics', () => ({
			sales: [],
			total: null,
			ru: null,
			en: null,

            init() {
				this.$watch('stats', value => this.statsChange(value))
				this.$watch('page', value => this.pageChange(value))
            },

			statsChange(value) {
				if (value != 'metrics-sails') {
					return;
				}
				
				this.update();
			},
			pageChange(value) {
				if (this.stats != 'metrics-sails') {
					return;
				}
				
				this.update();
			},
			update() {
				axios
					.get(route('admin.metrics.sales'), {
						params: {
							content: this.page,
						}
					})
					.then(response => {
						if(this.total) {
							this.total.data.setAll(response.data);
							this.en.data.setAll(response.data);
							this.ru.data.setAll(response.data);
							return;
						}

						this.sales = response.data;
						this.render();
					})
			},
			render() {
				let root = am5.Root.new("chart");
					root.locale = am5locales_ru_RU;
	
	
					// Set themes
					// https://www.amcharts.com/docs/v5/concepts/themes/
					root.setThemes([
						am5themes_Animated.new(root)
					]);
	
					root.dateFormatter.setAll({
						dateFormat: "yyyy",
						dateFields: ["valueX"]
					});
	
					let data = this.sales;
	
	
					// Create chart
					// https://www.amcharts.com/docs/v5/charts/xy-chart/
					let chart = root.container.children.push(am5xy.XYChart.new(root, {
						paddingBottom: 50,
						focusable: true,
						panX: true,
						panY: true,
						wheelX: "panX",
						wheelY: "zoomX",
						pinchZoomX: true
					}));
	
					let easing = am5.ease.linear;
	
	
					// Create axes
					// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
					let xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
						maxDeviation: 0.1,
						groupData: false,
						baseInterval: {
							timeUnit: "day",
							count: 1
						},
						renderer: am5xy.AxisRendererX.new(root, {
	
						}),
						tooltip: am5.Tooltip.new(root, {})
					}));
	
					let yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
						maxDeviation: 0.2,
						renderer: am5xy.AxisRendererY.new(root, {})
					}));
	
	
					// Add series
					// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
					let total = chart.series.push(am5xy.LineSeries.new(root, {
						name: 'Общие продажи',
						minBulletDistance: 15,
						connect: false,
						xAxis: xAxis,
						yAxis: yAxis,
						valueYField: "sum",
						valueXField: "date",
						minDistance: 15,
						fill: am5.color(0x000000),
						stroke: am5.color(0x000000),
						tooltip: am5.Tooltip.new(root, {
							pointerOrientation: "horizontal",
							labelText: "{valueY} €"
						})
					}));
	
					total.fills.template.setAll({
						fillOpacity: 0.2,
						visible: false
					});
	
					total.strokes.template.setAll({
						strokeWidth: 2
					});
	
	
					// Set up data processor to parse string dates
					// https://www.amcharts.com/docs/v5/concepts/data/#Pre_processing_data
					total.data.processor = am5.DataProcessor.new(root, {
						dateFormat: "yyyy-MM-dd",
						dateFields: ["date"]
					});
	
					total.data.setAll(data);
	
					total.bullets.push(function() {
						let circle = am5.Circle.new(root, {
							radius: 4,
							fill: root.interfaceColors.get("background"),
							stroke: total.get("fill"),
							strokeWidth: 2
						})
	
						return am5.Bullet.new(root, {
							sprite: circle
						})
					});

					this.total = total;
	
	
					let ruSeries = chart.series.push(am5xy.LineSeries.new(root, {
						name: 'РФ',
						minBulletDistance: 15,
						connect: false,
						xAxis: xAxis,
						yAxis: yAxis,
						valueYField: "ru",
						valueXField: "date",
						minDistance: 15,
						fill: am5.color(0xff0000),
						stroke: am5.color(0xff0000),
						tooltip: am5.Tooltip.new(root, {
							pointerOrientation: "horizontal",
							labelText: "{valueY} €"
						})
					}));
	
					ruSeries.fills.template.setAll({
						fillOpacity: 0.2,
						visible: false
					});
	
					ruSeries.strokes.template.setAll({
						strokeWidth: 2,
					});
	
	
					// Set up data processor to parse string dates
					// https://www.amcharts.com/docs/v5/concepts/data/#Pre_processing_data
					ruSeries.data.processor = am5.DataProcessor.new(root, {
						dateFormat: "yyyy-MM-dd",
						dateFields: ["date"]
					});
	
					ruSeries.data.setAll(data);
	
					ruSeries.bullets.push(function() {
						let circle = am5.Circle.new(root, {
							radius: 4,
							fill: root.interfaceColors.get("background"),
							stroke: ruSeries.get("fill"),
							strokeWidth: 2
						})
	
						return am5.Bullet.new(root, {
							sprite: circle
						})
					});

					this.ru = ruSeries;
	
					let enSeries = chart.series.push(am5xy.LineSeries.new(root, {
						name: 'US',
						minBulletDistance: 15,
						connect: false,
						xAxis: xAxis,
						yAxis: yAxis,
						valueYField: "en",
						valueXField: "date",
						minDistance: 15,
						fill: am5.color(0x0000ff),
						stroke: am5.color(0x0000ff),
						tooltip: am5.Tooltip.new(root, {
							pointerOrientation: "horizontal",
							labelText: "{valueY} €"
						})
					}));
	
					enSeries.fills.template.setAll({
						fillOpacity: 0.2,
						visible: false
					});
	
					enSeries.strokes.template.setAll({
						strokeWidth: 2
					});
	
	
					// Set up data processor to parse string dates
					// https://www.amcharts.com/docs/v5/concepts/data/#Pre_processing_data
					enSeries.data.processor = am5.DataProcessor.new(root, {
						dateFormat: "yyyy-MM-dd",
						dateFields: ["date"]
					});
	
					enSeries.data.setAll(data);
	
					enSeries.bullets.push(function() {
						let circle = am5.Circle.new(root, {
							radius: 4,
							fill: root.interfaceColors.get("background"),
							stroke: enSeries.get("fill"),
							strokeWidth: 2
						})
	
						return am5.Bullet.new(root, {
							sprite: circle
						})
					});

					this.en = enSeries;
	
	
					// Add cursor
					// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
					let cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
						xAxis: xAxis,
						behavior: "none"
					}));
					cursor.lineY.set("visible", false);
	
					// add scrollbar
					chart.set("scrollbarX", am5.Scrollbar.new(root, {
						height: 5,
						minHeight: 5,
						orientation: "horizontal",
						start: 0.8,
					}));
					let scrollbarX = chart.get("scrollbarX");
					scrollbarX.thumb.setAll({
						fill: am5.color(0xe9742b),
						fillOpacity: 0.8
					});
					scrollbarX.get("background").setAll({
						fill: am5.color(0xe9742b),
						fillOpacity: 0.5,
					});
					scrollbarX.startGrip.set("scale", 0.7);
					scrollbarX.endGrip.set("scale", 0.7);
	
					let legend = chart.children.push(am5.Legend.new(root, {
						x: am5.percent(50),
						y: am5.percent(100),
						centerX: am5.percent(50),
	
					}));
					legend.data.setAll(chart.series.values);
	
	
					this.chart = chart;
					// Make stuff animate on load
					// https://www.amcharts.com/docs/v5/concepts/animations/
					this.chart.appear(1000, 100);

			},

        }))
    })
</script>
