<div class="w-full h-[800px]">
	<div class="w-1/2 h-[300px]" id="chart"></div>

    <script>
		document.addEventListener('DOMContentLoaded', () => {

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
	
			let data = @json($sales);
	
	
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


			let ruSeries = chart.series.push(am5xy.LineSeries.new(root, {
				name: 'Продажи РФ',
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

			let enSeries = chart.series.push(am5xy.LineSeries.new(root, {
				name: 'Продажи US',
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

	
	
			// Make stuff animate on load
			// https://www.amcharts.com/docs/v5/concepts/animations/
			chart.appear(1000, 100);
		})
    </script>
</div>
