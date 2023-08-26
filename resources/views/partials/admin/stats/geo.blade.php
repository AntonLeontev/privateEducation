<div class="h-full pt-1 player__content" x-data="geo">

    <div 
		class="relative w-full h-full bg-[#d4f1f990] transition-all"
		:class="{ '!fixed top-10 bottom-10 left-10 right-10 z-40 bg-[#d4f1f9ee] !w-auto !h-auto': fullscreen }"
	>
        <div id="geo-chart" class="w-full h-full"></div>
		
		<div class="absolute bottom-0 right-0 h-[25px]">
			<button class="w-[25px] h-[25px] flex justify-center items-center" @click="fullscreen=false" x-show="fullscreen">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
					x="0px" y="0px" width="23" height="23" viewBox="0 0 357 357"
					style="enable-background:new 0 0 357 357;" xml:space="preserve">
					<g>
						<g id="fullscreen-exit">
							<path
								d="M0,280.5h76.5V357h51V229.5H0V280.5z M76.5,76.5H0v51h127.5V0h-51V76.5z M229.5,357h51v-76.5H357v-51H229.5V357z M280.5,76.5V0h-51v127.5H357v-51H280.5z" />
						</g>
					</g>
	
				</svg>
			</button>

			<button class="w-[25px] h-[25px] flex justify-center items-center" @click="fullscreen=true" x-show="!fullscreen">
				<svg width="23" height="23" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect width="48" height="48" fill="white" fill-opacity="0.01"/>
					<path d="M33 6H42V15" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M42 33V42H33" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M15 42H6V33" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M6 15V6H15" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</button>

		</div>
    </div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('geo', () => ({
            activeCountry: null,
            fullscreen: false,
            sales: [],

            init() {
                // this.$watch('stats', value => this.statsChange(value))
                // this.$watch('page', value => this.pageChange(value))

                document.addEventListener('DOMContentLoaded', () => {
                    let root = am5.Root.new("geo-chart");
                    root.locale = am5locales_ru_RU;
                    root.setThemes([am5themes_Animated.new(root)]);

                    let chart = root.container.children.push(
                        am5map.MapChart.new(root, {
                            projection: am5map.geoMercator(),
                            zoomStep: 1.5,
                            minZoomLevel: 1.5,
                            maxZoomLevel: 9,
                            homeZoomLevel: 2,
                            maxPanOut: 0.4,
                            wheelSensitivity: 1.7
                        })
                    );

                    let polygonSeries = chart.series.push(
                        am5map.MapPolygonSeries.new(root, {
                            geoJSON: am5geodata_worldLow,
                            geodataNames: am5geodata_lang_RU,
                            exclude: ["AQ"],
                            fill: am5.color(0xaaaaaa),
                            valueField: "value",
                            calculateAggregates: true,
                        })
                    );

                    polygonSeries.mapPolygons.template.setAll({
                        // tooltipText: "{name} {id}",
                        interactive: true
                    });

                    polygonSeries.set("heatRules", [{
                        target: polygonSeries.mapPolygons.template,
                        dataField: "value",
                        min: am5.color(0xff621f),
                        max: am5.color(0x661f00),
                        key: "fill"
                    }]);

                    polygonSeries.mapPolygons.template.states.create("hover", {
                        fill: am5.color(0x677935)
                    });


                    let countries = {};

                    countries['US'] = chart.series.push(am5map.MapPolygonSeries.new(root, {
                        geoJSON: am5geodata_usaLow,
                        exclude: [],
                        visible: false,
                    }));

                    countries['US'].mapPolygons.template.setAll({
                        tooltipText: "{name} {id}",
                        toggleKey: "active",
                        interactive: true
                    });

                    countries['RU'] = chart.series.push(am5map.MapPolygonSeries.new(root, {
                        geoJSON: am5geodata_russiaLow,
                        visible: false,
                    }));

                    countries['RU'].mapPolygons.template.setAll({
                        tooltipText: "{name} {id}",
                        toggleKey: "active",
                        interactive: true
                    });

                    let homeButton = chart.children.push(am5.Button.new(root, {
                        paddingTop: 5,
                        paddingBottom: 5,
                        x: am5.percent(100),
                        centerX: am5.percent(100),
                        opacity: 0,
                        interactiveChildren: false,
                        icon: am5.Graphics.new(root, {
                            svgPath: "M8.925 7.013v-5.1L0 10.838l8.925 8.925V14.535c6.375 0 10.838 2.04 14.025 6.503C21.675 14.663 17.85 8.288 8.925 7.013z",
                            fill: am5.color(0xffffff),
                        })
                    }));



                    polygonSeries.events.on("datavalidated", function() {
                        chart.goHome();
                    });

                    homeButton.events.on('click', function() {
                        chart.goHome();
                        homeButton.hide();
                        countries[this.activeCountry].hide();
                        polygonSeries.show();
                    });

                    // Set up zooming in on clicked continent
                    polygonSeries.mapPolygons.template.events.on("click", function(ev) {
                        polygonSeries.zoomToDataItem(ev.target.dataItem);

                        if (countries.hasOwnProperty(ev.target.dataItem.get(
                            'id'))) {
                            this.activeCountry = ev.target.dataItem.get('id');
                            polygonSeries.hide();
                            countries[ev.target.dataItem.get('id')].show();
                            homeButton.show();
                        }
                    });


                    polygonSeries.data.setAll([{
                        id: "US",
                        value: 65,
                    }, {
                        id: "KZ",
                        value: 10,
                    }, {
                        id: "UA",
                        value: 10,
                    }, {
                        id: "BY",
                        value: 5,
                    }, {
                        id: "RU",
                        value: 50,
                    }, {
                        id: "MX",
                        value: 25,
                    }, ]);


                    chart.appear(1000, 100);
                });
            },

            statsChange(value) {
                if (value != 'geo') {
                    return;
                }

                this.update();
            },
            pageChange(value) {
                if (this.stats != 'geo') {
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
                        if (this.total) {
                            this.total.data.setAll(response.data);
                            this.en.data.setAll(response.data);
                            this.ru.data.setAll(response.data);
                            return;
                        }

                        this.sales = response.data;
                        this.render();
                    })
            },
            render() {},

        }))
    })
</script>
