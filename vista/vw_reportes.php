<?php

class vw_reportes {

	public static function fallas_semanales($week, $year){

		$year = 2016;
		// $i = 33;
		$weeks = array();
		for ($i=1; $i <= count(45); $i++) { 

			//Por cada semana
			$week_array = getStartAndEndDate($i,$year);
			$fecha_inicio = $week_array[week_start];
			$fecha_termino = $week_array[week_end];
			$alarmas_ac_semanales = vm_grafico_reportes::traer_fallas_semanales($fecha_inicio,$fecha_termino);
			$cantidad_alarmas = count($alarmas_ac_semanales);

			// print_r(count($alarmas_ac_semanales));
			array_push($weeks, $cantidad_alarmas);
			// $i++;

		}
		print_r($weeks[33]);

    }

    public static function grafico_semanal(){
    	$year = 2016;
        $weeks = array(0);
        for ($i=1; $i <= 54; $i++) { 
            $week_array = getStartAndEndDate($i,$year);
            $alarmas_ac_semanales = vm_grafico_reportes::traer_fallas_semanales($week_array[week_start],$week_array[week_end]);
            $cantidad_alarmas = count($alarmas_ac_semanales);
            array_push($weeks, $cantidad_alarmas);
        }
        ?>
        <script>
        var chart = AmCharts.makeChart("chartdiv_semanal", {
            "type": "serial",
            "theme": "dark",
            "marginRight":30,
            // "legend": {
            //     "equalWidths": false,
            //     "periodValueText": "total: [[value.sum]]",
            //     "position": "top",
            //     "valueAlign": "left",
            //     "valueWidth": 100
            // },
            "dataProvider": [
            <?php
            for ($i=getWeekNumber()-10; $i <= getWeekNumber(); $i++) { 
            echo'{
                "week": "W'.$i.'",
                "alarmas": '.$weeks[$i].',
                "lineColor": "#f67918",
                },';
            }?>
            ],
            
            // "valueAxes": [{
            //     "stackType": "regular",
            //     "gridAlpha": 0.07,
            //     "position": "left",
            //     "title": "Traffic incidents"
            // }],
            "graphs": [{
                "balloonText": "[[value]]",
                "fillAlphas": 0.9,
                "hidden": false,
                "lineAlpha": 0.4,
                "title": "Alarmas",
                "valueField": "alarmas",
                "fillColorsField": "lineColor",
            }],
            "plotAreaBorderAlpha": 0,
            "marginTop": 10,
            "marginLeft": 0,
            "marginBottom": 0,
            // "chartScrollbar": {},
            "chartCursor": {
                "cursorAlpha": 0
            },
            "categoryField": "week",
            "categoryAxis": {
                "startOnAxis": true,
                "axisColor": "#DADADA",
                "gridAlpha": 0.07,
                // "title": "Year",
                // "guides": [{
                //     category: "2001",
                //     toCategory: "2003",
                //     lineColor: "#CC0000",
                //     lineAlpha: 1,
                //     fillAlpha: 0.2,
                //     fillColor: "#CC0000",
                //     dashLength: 2,
                //     inside: true,
                //     labelRotation: 90,
                //     label: "fines for speeding increased"
                // }, {
                //     category: "2007",
                //     lineColor: "#CC0000",
                //     lineAlpha: 1,
                //     dashLength: 2,
                //     inside: true,
                //     labelRotation: 90,
                //     label: "motorcycle fee introduced"
                // }]
            },
            "export": {
                "enabled": true
            }
        });
        </script>
    <?php
    }

    public static function grafico_pie(){
        ?>
        <script>
            var chart;
            var legend;

            var chartData = [
                {
                    "country": "Lithuania",
                    "value": 260
                },
                {
                    "country": "Ireland",
                    "value": 201
                },
                {
                    "country": "Germany",
                    "value": 65
                },
                {
                    "country": "Australia",
                    "value": 39
                },
                {
                    "country": "UK",
                    "value": 19
                },
                {
                    "country": "Latvia",
                    "value": 10
                }
            ];

            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData;
                chart.titleField = "country";
                chart.valueField = "value";
                chart.outlineColor = "#FFFFFF";
                chart.outlineAlpha = 0.3;
                chart.outlineThickness = 1;
                chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
                // this makes the chart 3D
                chart.depth3D = 15;
                chart.angle = 30;

                // WRITE
                chart.write("chartdiv_pie");
            });
        </script>
    <?php
    }

    public static function grafico_bar(){
        ?>
        <!--script>
            var chart;

            var chartData = [
                {
                    "year": 2005,
                    "income": 23.5,
                    "expenses": 18.1
                },
                {
                    "year": 2006,
                    "income": 26.2,
                    "expenses": 22.8
                },
                {
                    "year": 2007,
                    "income": 30.1,
                    "expenses": 23.9
                },
                {
                    "year": 2008,
                    "income": 29.5,
                    "expenses": 25.1
                },
                {
                    "year": 2009,
                    "income": 24.6,
                    "expenses": 25
                }
            ];


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "year";
                chart.startDuration = 1;
                chart.plotAreaBorderColor = "#DADADA";
                chart.plotAreaBorderAlpha = 1;
                // this single line makes the chart a bar chart
                chart.rotate = true;

                // AXES
                // Category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridPosition = "start";
                categoryAxis.gridAlpha = 0.1;
                categoryAxis.axisAlpha = 0;

                // Value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.gridAlpha = 0.1;
                valueAxis.position = "top";
                chart.addValueAxis(valueAxis);

                // GRAPHS
                // first graph
                var graph1 = new AmCharts.AmGraph();
                graph1.type = "column";
                graph1.title = "Income";
                graph1.valueField = "income";
                graph1.balloonText = "Income:[[value]]";
                graph1.lineAlpha = 0;
                graph1.fillColors = "#ADD981";
                graph1.fillAlphas = 1;
                chart.addGraph(graph1);

                // second graph
                var graph2 = new AmCharts.AmGraph();
                graph2.type = "column";
                graph2.title = "Expenses";
                graph2.valueField = "expenses";
                graph2.balloonText = "Expenses:[[value]]";
                graph2.lineAlpha = 0;
                graph2.fillColors = "#81acd9";
                graph2.fillAlphas = 1;
                chart.addGraph(graph2);

                // LEGEND
                // var legend = new AmCharts.AmLegend();
                // chart.addLegend(legend);

                chart.creditsPosition = "top-right";

                // WRITE
                chart.write("chartdiv_bar");
            });
        </script-->
    <?php
    }

    public static function alarmas_diferentes($week,$year){
        //Por cada semana
        $week_date = getStartAndEndDate($week,$year);
        $fecha_inicio = $week_date[week_start];
        $fecha_termino = $week_date[week_end];
        $alarmas_ac_semanales = vm_grafico_reportes::traer_fallas_semanales($fecha_inicio,$fecha_termino);
        $array_sitio = array();
        $array_fecha = array();
        $array_texto = array();
        foreach ($alarmas_ac_semanales as $alarma) {
            array_push($array_sitio,$alarma['SITIO']);
            array_push($array_fecha,$alarma['INICIO']);
            array_push($array_texto,$alarma['TEXTO']);
        }
        $cantidad_alarmas = count($array_texto);
        
        $sitios = array();
        $fechas = array();
        $texto = array();

        //Segunda+ Alarmas
        for ($i=0; $i < $cantidad_alarmas; $i++) {
            $date = (strtotime($array_fecha[$i]) - strtotime($array_fecha[$i-1]))/60;
            if ($array_sitio[$i] == $array_sitio[$i-1] && $array_sitio[$i] == $array_sitio[$i+1] && $date <= 5) {   //Si el sitio es el mismo que el anterior
                echo '';
            } else {
                array_push($sitios,$array_sitio[$i]);
                array_push($fechas,$array_fecha[$i]);
                array_push($texto,$array_texto[$i]);
            }
        }
        $cantidad_alarmas = count($sitios);
        // print_r($cantidad_alarmas);

        ?>
        <table class="table table-responsive project-list" id="table_reportes">
            <thead>
                <tr>
                    <td class="col-sm-1"></td>
                    <td class="col-sm-2">Sitio</td>
                    <td class="col-sm-3">Fecha Inicio</td>
                    <td class="col-sm-4">Fecha Término</td>
                    <td class="col-sm-2">Autonomía</td>
                </tr>
            </thead>
            <tbody>

            <?php
                $j = 1;
                for ($i=0; $i < $cantidad_alarmas; $i++) { 
                    
                    if ($texto[$i] == "OML FAULT" && $sitios[$i] == $sitios[$i-1] && $texto[$i-1] != "OML FAULT") {
                        $auto = (strtotime($fechas[$i]) - strtotime($fechas[$i-1]))/60;
                        $autonomia = $auto."' min.";
                        echo '  <tr>
                                <td class="col-sm-1">'.$j.'</td>
                                <td class="col-sm-2">'.$sitios[$i].'</td>
                                <td class="col-sm-3">'.$fechas[$i-1].'</td>
                                <td class="col-sm-4">'.$fechas[$i].'</td>
                                <td class="col-sm-2">'.$autonomia.'</td>
                            </tr>';
                        $j++;
                    } 
                }
            ?>
            </tbody>
        </table>

        <?php
    }

    public static function tabla_autonomía(){
        ?>
        
    <?php
    }














}