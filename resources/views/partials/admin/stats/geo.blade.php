<div class="h-full pt-1 player__content" x-data="geo">

    <div class="relative h-full w-full bg-[#d4f1f990] transition-all"
        :class="{ '!fixed top-10 bottom-10 left-10 right-10 z-40 bg-[#d4f1f9ee] !w-auto !h-auto': fullscreen }">
        <div id="geo-chart" class="w-full h-full"></div>

        <div class="absolute bottom-0 right-0">
            <button
                class="flex items-center justify-center rounded-[10px] border border-white bg-[#6794dc] px-[10px] py-[5px]"
                @click="fullscreen = !fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" x-show="fullscreen" width="23" height="23"
                    viewBox="0 0 357 357" class="fill-white">
                    <g id="fullscreen-exit">
                        <path
                            d="M0,280.5h76.5V357h51V229.5H0V280.5z M76.5,76.5H0v51h127.5V0h-51V76.5z M229.5,357h51v-76.5H357v-51H229.5V357z M280.5,76.5V0h-51v127.5H357v-51H280.5z"
                            stroke-width="4" />
                    </g>
                </svg>

                <svg width="23" height="23" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"
                    x-show="!fullscreen">
                    <rect width="48" height="48" fill="white" fill-opacity="0.01" />
                    <path d="M33 6H42V15" stroke="white" stroke-width="4" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M42 33V42H33" stroke="white" stroke-width="4" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M15 42H6V33" stroke="white" stroke-width="4" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M6 15V6H15" stroke="white" stroke-width="4" stroke-linecap="round"
                        stroke-linejoin="round" />
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
					let countryData = [
						{id: "US", value: 650,}, 
						{id: "KZ", value: 100,}, 
						{id: "UA", value: 100,}, 
						{id: "BY", value: 50, }, 
						{id: "RU", value: 500,},
						{id: "MX", value: 250,}, 
					];


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

                    let heatRules = function(polygon) {
                        return [{
                            target: polygon.mapPolygons.template,
                            dataField: "value",
                            min: am5.color(0xff621f),
                            max: am5.color(0x661f00),
                            key: "fill"
                        }];
                    }

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

                    polygonSeries.set("heatRules", heatRules(polygonSeries));

                    polygonSeries.mapPolygons.template.states.create("hover", {
                        fill: am5.color(0x6794dc),
                    });

					let pointSeries = chart.series.push(
						am5map.MapPointSeries.new(root, {
							polygonIdField: "polygonId",
							visible: false,
						})
					);

					pointSeries.bullets.push(function() {
						return am5.Bullet.new(root, {
							sprite: am5.Label.new(root, {
								fontSize: 12,
								centerX: am5.p50,
								centerY: am5.p50,
								text: "{name}\n{value} €",
								textAlign: "center",
								oversizedBehavior: 'fit',
								populateText: true
							})
						});
					});

					polygonSeries.events.on("datavalidated", function(ev) {
						let series = ev.target;
						let labelData = [];
						series.mapPolygons.each(function(polygon) {
							let id = polygon.dataItem.get("id");
							if (polygon.dataItem.get("value")) {
								labelData.push({
									polygonId: id,
									name: polygon.dataItem.dataContext.name,
									value: polygon.dataItem.get("value")
								})
							}
						})
						pointSeries.data.setAll(labelData);
					});

					let countriesList = [
						{id: 'RU', json: am5geodata_russiaLow},
						{id: 'US', json: am5geodata_usaLow},
					];

                    let countries = {};
					let countriesPoints = {};

					for (const country of countriesList) {
						countries[country.id] = chart.series.push(am5map.MapPolygonSeries.new(root, {
							geoJSON: country.json,
							visible: false,
							fill: am5.color(0xaaaaaa),
							valueField: "value",
							calculateAggregates: true,
						}));
	
						countries[country.id].mapPolygons.template.setAll({
							tooltipText: "{name}",
							toggleKey: "active",
							textAlign: 'center',
							interactive: true,
						});
	
						countries[country.id].set("heatRules", heatRules(countries[country.id]));


						countriesPoints[country.id] = chart.series.push(
							am5map.MapPointSeries.new(root, {
								polygonIdField: "polygonId",
								visible: false,
							})
						);

						countriesPoints[country.id].bullets.push(function() {
							return am5.Bullet.new(root, {
								sprite: am5.Label.new(root, {
									fontSize: 12,
									centerX: am5.p50,
									centerY: am5.p50,
									text: "{value} €",
									textAlign: "center",
									oversizedBehavior: 'fit',
									populateText: true
								})
							});
						});

						countries[country.id].events.on("datavalidated", function(ev) {
							let series = ev.target;
							let labelData = [];
							series.mapPolygons.each(function(polygon) {
								let id = polygon.dataItem.get("id");
								if (polygon.dataItem.get("value")) {
									labelData.push({
										polygonId: id,
										name: polygon.dataItem.dataContext.name,
										value: polygon.dataItem.get("value")
									})
								}
							})
							countriesPoints[country.id].data.setAll(labelData);
						});

					}


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

					let heatLegend = chart.children.push(
						am5.HeatLegend.new(root, {
							orientation: "horizontal",
							startColor: am5.color(0xff621f),
							endColor: am5.color(0x661f00),
							stepCount: 1,
							position: 'absolute',
							y: am5.percent(100),
							centerY: am5.percent(100),
							paddingLeft: 70,
							paddingRight: 70,
							visible: false,
						})
					);

					heatLegend.startLabel.setAll({
						fontSize: 12,
						fill: heatLegend.get("startColor"),
					});

					heatLegend.endLabel.setAll({
						fontSize: 12,
						fill: heatLegend.get("endColor")
					});

					for (const key of Object.keys(countries)) {
						countries[key].mapPolygons.template.events.on("pointerover", function(ev) {
							heatLegend.showValue(ev.target.dataItem.get("value"));
						});
					}



                    polygonSeries.events.on("datavalidated", function() {
                        chart.goHome();
                    });

                    homeButton.events.on('click', function() {
                        chart.goHome();
                        homeButton.hide();
                        countries[this.activeCountry].hide();
                        countriesPoints[this.activeCountry].hide();
                        heatLegend.hide();
						this.activeCountry = null;
                        polygonSeries.show();
						pointSeries.show();
                    });

                    // Set up zooming in on clicked continent
                    polygonSeries.mapPolygons.template.events.on("click", function(ev) {
                        
						if (ev.target.dataItem.get('id') === 'RU') {
							chart.zoomToGeoPoint({longitude: 65, latitude: 62}, 5, true);
						} else if (ev.target.dataItem.get('id') === 'US') {
							chart.zoomToGeoPoint({longitude: -100, latitude: 40}, 5.5, true);
						} else {
							polygonSeries.zoomToDataItem(ev.target.dataItem);
						}

                        if (countries.hasOwnProperty(ev.target.dataItem.get('id'))) {
                            this.activeCountry = ev.target.dataItem.get('id');
                            polygonSeries.hide();
                            pointSeries.hide();
                            countries[ev.target.dataItem.get('id')].show();
                            countriesPoints[ev.target.dataItem.get('id')].show();

							heatLegend.set("startValue", countries[ev.target.dataItem.get('id')].getPrivate("valueLow"));
							heatLegend.set("endValue", countries[ev.target.dataItem.get('id')].getPrivate("valueHigh"));
                            heatLegend.show();

                            homeButton.show();
                        }
                    });


                    polygonSeries.data.setAll(countryData);

					chart.events.on('wheel', function() {
						setTimeout(() => {
							if (chart._settings.zoomLevel < 2.5) {
								pointSeries.hide();
								return;
							}

							if (polygonSeries.isHidden()) return;
							pointSeries.show();

						}, 500);
					});

                    countries['RU'].data.setAll([
						{id: 'RU-MOS',value: 15},
                        {id: 'RU-KOS',value: 15},
                        {id: 'RU-VLA',value: 10},
                        {id: 'RU-LEN',value: 8},
                        {id: 'RU-VLG',value: 25},
                        {id: 'RU-SVE',value: 21},
                        {id: 'RU-CHE',value: 17},
                        {id: 'RU-KYA',value: 3},
                        {id: 'RU-PRI',value: 5},
                        {
                            id: 'RU-YAR',
                            value: 3
                        },
                        {
                            id: 'RU-TVE',
                            value: 1
                        },
                        {
                            id: 'RU-SMO',
                            value: 32
                        },
                        {
                            id: 'RU-KLU',
                            value: 26
                        },
                        {
                            id: 'RU-TUL',
                            value: 12
                        },
                    ]);

                    countries['US'].data.setAll([{
                            id: 'US-NY',
                            value: 15
                        },
                        {
                            id: 'US-VA',
                            value: 15
                        },
                        {
                            id: 'US-NC',
                            value: 15
                        },
                        {
                            id: 'US-GA',
                            value: 10
                        },
                        {
                            id: 'US-WA',
                            value: 8
                        },
                        {
                            id: 'US-CA',
                            value: 35
                        },
                        {
                            id: 'US-',
                            value: 3
                        },
                        {
                            id: 'US-',
                            value: 1
                        },
                        {
                            id: 'US-',
                            value: 30
                        },
                        {
                            id: 'US-',
                            value: 26
                        },
                        {
                            id: 'US-',
                            value: 12
                        },
                    ]);


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
