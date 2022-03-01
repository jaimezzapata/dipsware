<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {


  require 'header.php';

  if ($_SESSION['escritorio'] == 1) {
    require_once "../modelos/Negocio.php";
    $cnegocio = new Negocio();
    $rsptan = $cnegocio->listar();
    $regn = $rsptan->fetch_object();
    $nombrenegocio = $regn->nombre;
    $smoneda = $regn->simbolo;
    $logo = $regn->logo;

    require_once "../modelos/Consultas.php";
    $consulta = new Consultas();
?>
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">
                  <button type='button' id="buttonExport" class="btn bgVerde colorBlanco">
                    <i class="fa fa-print" aria-hidden="true"></i> Imprimir
                  </button>
                </h1>
                <div class="box-tools pull-right">

                </div>
              </div>
              <div class="panel-body">
                <!--GRAFICA COMPRAS-->
                <div class="row">

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <div class="box box-warning box-solid">
                      <div class="box-header">
                        <i class="fa fa-th"></i>
                        <h3 class="box-title">Gráfico de Compras</h3>
                      </div>
                      <div class="box-body border-radius-none nuevoGraficoVentas">
                        <div class="chart" id="line-chart-compras" style="height: 250px;"></div>
                      </div>
                    </div>
                    <!--fin box-->
                  </div>
                  <!--col-sm-->

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <div class="box box-success box-solid">
                      <div class="box-header">
                        <i class="fa fa-th"></i>
                        <h3 class="box-title">Gráfico de Ventas</h3>
                      </div>
                      <div class="box-body border-radius-none nuevoGraficoVentas">
                        <div class="chart" id="line-chart-ventas" style="height: 250px;"></div>
                      </div>
                    </div>
                    <!--fin box-->
                  </div>
                  <!--col-sm-->





                  <div class="form-group col-lg-6 col-md-6 col-xs-12">

                    <div class="box box-primary">
                      <div class="box-header with-border">
                        Resume de compras del año <?php echo date("Y"); ?>
                      </div>
                      <div class="box-body">

                        <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

                      </div>
                      <!--fin box-body-->
                    </div>
                    <!--fin box-->
                  </div>
                  <!--col-sm-->


                  <!--GRAFICA VENTAS-->
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">

                    <div class="box box-primary">
                      <div class="box-header with-border">
                        Resume de ventas del año <?php echo date("Y"); ?>
                      </div>
                      <div class="box-body">
                        <!--GRAFICA-->
                        <div id="container_ventas" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

                      </div>
                      <!--fin box-body-->
                    </div>
                    <!--fin box-->
                  </div>
                  <!--col-sm-->

                </div>
                <!--fin row-->
              </div>
              <!--fin centro-->
            </div>
          </div>
        </div>
        <!-- /.box -->

      </section>
      <!-- /.content -->
    </div>
  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script src="../public/js/highcharts.js"></script>
  <script src="../public/js/exporting.js"></script>
  <script src="../public/js/raphael.min.js"></script>
  <script src="../public/js/morris.min.js"></script>


  <script>
    //grafico de compras  
    var line = new Morris.Line({

      element: 'line-chart-compras',
      resize: true,
      data: [
        <?php
        $compras_grafica = $consulta->compras_grafica();
        //recorro el array y lo imprimo
        foreach ($compras_grafica as $row) {
          $mes = $output["fecha"] = $row["fecha"];
          $p = $output["total"] = $row["total"];

          echo $grafica = "{y:'" . $mes . "', compras:" . $p . "},";
        }

        ?>
      ],
      xkey: 'y',
      ykeys: ['compras'],
      labels: ['compras'],
      lineColors: ['#FFA833'],
      lineWidth: 1,
      hideHover: 'auto',
      gridTextFamily: 'Open Sans',


    });

    //grafico de ventas  
    var line = new Morris.Line({

      element: 'line-chart-ventas',
      resize: true,
      data: [
        <?php
        $ventas_grafica = $consulta->ventas_grafica();
        //recorro el array y lo imprimo
        foreach ($ventas_grafica as $row) {
          $mes = $output["fecha"] = $row["fecha"];
          $p = $output["total"] = $row["total"];

          echo $grafica = "{y:'" . $mes . "', ventas:" . $p . "},";
        }

        ?>
      ],
      xkey: 'y',
      ykeys: ['ventas'],
      labels: ['Series A'],
      lineColors: ['#12C51A'],
      lineWidth: 1,
      hideHover: 'auto',
      gridTextFamily: 'Open Sans',


    });
  </script>

  <script type="text/javascript">
    /*GRAFICA COMPRAS*/
    $(document).ready(function() {

      //Highcharts.chart('container', {

      var chart = new Highcharts.Chart({
        //$('#container').highcharts({

        chart: {

          renderTo: 'container',
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
        },

        exporting: {
          url: 'http://export.highcharts.com/',
          enabled: false

        },

        title: {
          text: ''
        },
        tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
          pie: {
            showInLegend: true,
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
              enabled: true,
              format: '<b>{point.name}</b>: {point.percentage:.1f} %',
              style: {
                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',

                fontSize: '20px'
              }
            }
          }
        },
        legend: {
          symbolWidth: 12,
          symbolHeight: 18,
          padding: 0,
          margin: 15,
          symbolPadding: 5,
          itemDistance: 40,
          itemStyle: {
            "fontSize": "17px",
            "fontWeight": "normal"
          }
        },

        series: [

          {
            name: 'Brands',
            colorByPoint: true,
            data: [


              <?php echo $datos_grafica = $consulta->comparsultimos_12meses_grafica(); ?>

            ]

          }
        ],

        exporting: {
          enabled: false
        }

      });


    });



    /*GRAFICA VENTAS*/
    $(document).ready(function() {

      //Highcharts.chart('container', {

      var chart = new Highcharts.Chart({
        //$('#container').highcharts({

        chart: {

          renderTo: 'container_ventas',
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
        },

        exporting: {
          url: 'http://export.highcharts.com/',
          enabled: false

        },

        title: {
          text: ''
        },
        tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
          pie: {
            showInLegend: true,
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
              enabled: true,
              format: '<b>{point.name}</b>: {point.percentage:.1f} %',
              style: {
                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',

                fontSize: '20px'
              }
            }
          }
        },
        legend: {
          symbolWidth: 12,
          symbolHeight: 18,
          padding: 0,
          margin: 15,
          symbolPadding: 5,
          itemDistance: 40,
          itemStyle: {
            "fontSize": "17px",
            "fontWeight": "normal"
          }
        },

        series: [{
          name: 'Brands',
          colorByPoint: true,
          data: [
            <?php echo $datos_grafica = $consulta->ventasultimos_12meses_grafica(); ?>
          ]
        }],


        exporting: {
          enabled: false
        }

      });



      //si se le da click al boton entonces se envia la imagen al archivo PDF por ajax
      $('#buttonExport').click(function() {


        //alert("clic");
        printHTML()
        document.addEventListener("DOMContentLoaded", function(event) {
          printHTML();
        });


      });
    });



    function printHTML() {
      if (window.print) {
        window.print();
      }
    }
  </script>

<?php
}

ob_end_flush();
?>