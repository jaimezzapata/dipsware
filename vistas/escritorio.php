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
    $rsptac = $consulta->totalcomprahoy();
    $regc = $rsptac->fetch_object();
    $totalc = $regc->total_compra;

    $rsptav = $consulta->totalventahoy();
    $regv = $rsptav->fetch_object();
    $totalv = $regv->total_venta;

    $rsptav = $consulta->cantidadclientes();
    $regv = $rsptav->fetch_object();
    $totalclientes = $regv->totalc;

    $rsptav = $consulta->cantidadproveedores();
    $regv = $rsptav->fetch_object();
    $totalproveedores = $regv->totalp;

    $rsptav = $consulta->cantidadusuarios();
    $regv = $rsptav->fetch_object();
    $totalusuarios = $regv->totalcu;

    $rsptav = $consulta->cantidadarticulos();
    $regv = $rsptav->fetch_object();
    $totalarticulos = $regv->totalar;

    $rsptav = $consulta->totalstock();
    $regv = $rsptav->fetch_object();
    $totalstock = $regv->totalstock;
    $cap_almacen = 3000;

    $rsptav = $consulta->cantidadcategorias();
    $regv = $rsptav->fetch_object();
    $totalcategorias = $regv->totalca;

    $rsptav = $consulta->cantidadcomprobantes();
    $regv = $rsptav->fetch_object();
    $totalcomprobantes = $regv->totalcomp;

    $rsptav = $consulta->cantidadcomprobantes();
    $regv = $rsptav->fetch_object();
    $totalcomprobantes = $regv->totalcomp;

    $rsptav = $consulta->cantidadcompras();
    $regv = $rsptav->fetch_object();
    $totalcompr = $regv->totalcompras;

    $rsptav = $consulta->cantidadventas();
    $regv = $rsptav->fetch_object();
    $totalventas = $regv->totalventas;

    //obtener valores para cargar al grafico de barras
    $compras10 = $consulta->comprasultimos_10dias();
    $fechasc = '';
    $totalesc = '';
    while ($regfechac = $compras10->fetch_object()) {
      $fechasc = $fechasc . '"' . $regfechac->fecha . '",';
      $totalesc = $totalesc . $regfechac->total . ',';
    }

    $ventas10 = $consulta->ventasultimos_10dias();
    $fechasv = '';
    $totalesv = '';
    while ($regfechav = $ventas10->fetch_object()) {
      $fechasv = $fechasv . '"' . $regfechav->fecha . '",';
      $totalesv = $totalesv . $regfechav->total . ',';
    }

    //quitamos la ultima coma
    $fechasv = substr($fechasv, 0, -1);
    $totalesv = substr($totalesv, 0, -1);
?>
    <div class="content-wrapper">
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="panel-body">

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="small-box bgVerde colorBlanco">
                    <div class="inner">
                      <h4 style="font-size: 40px;">
                        <strong><?php echo $totalcompr; ?> </strong>
                      </h4>
                      <p>Ventas</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </div>
                    <a href="venta.php" class="small-box-footer">Ventas <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="small-box bgCafe colorBlanco">
                    <div class="inner">
                      <h4 style="font-size: 40px;">
                        <strong><?php echo $totalarticulos; ?> </strong>
                      </h4>
                      <p>Productos</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-cart-plus" aria-hidden="true"></i>
                    </div>
                    <a href="articulo.php" class="small-box-footer">Productos <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="small-box bgVerde colorBlanco">
                    <div class="inner">
                      <h4 style="font-size: 40px;">
                        <strong><?php echo $totalclientes; ?> </strong>
                      </h4>
                      <p>Clientes</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-plus" aria-hidden="true"></i>
                    </div>
                    <a href="cliente.php" class="small-box-footer">Clientes <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="small-box bgCafe colorBlanco">
                    <div class="inner">
                      <h4 style="font-size: 40px;">
                        <strong><?php echo $totalcategorias; ?> </strong>
                      </h4>
                      <p>Categorías</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-certificate" aria-hidden="true"></i>
                    </div>
                    <a href="categoria.php" class="small-box-footer">Categorías <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="small-box bgVerde colorBlanco">
                    <div class="inner">
                      <h4 style="font-size: 40px;">
                        <strong><?php echo $totalventas; ?> </strong>
                      </h4>
                      <p>Compras</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </div>
                    <a href="ingreso.php" class="small-box-footer">Compras <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="small-box bgCafe colorBlanco">
                    <div class="inner">
                      <h4 style="font-size: 40px;">
                        <strong><?php echo $totalproveedores; ?> </strong>
                      </h4>
                      <p>Proveedores</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-plus" aria-hidden="true"></i>
                    </div>
                    <a href="proveedor.php" class="small-box-footer">Proveedores <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="small-box bgVerde colorBlanco">
                    <div class="inner">
                      <h4 style="font-size: 40px;">
                        <strong><?php echo $totalusuarios; ?> </strong>
                      </h4>
                      <p>Usuarios</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-user-plus" aria-hidden="true"></i>
                    </div>
                    <a href="usuario.php" class="small-box-footer">Usuarios <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="small-box bgCafe colorBlanco">
                    <div class="inner">
                      <h4 style="font-size: 40px;">
                        <strong><?php echo $totalcomprobantes; ?> </strong>
                      </h4>
                      <p>Comprobantes</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-file" aria-hidden="true"></i>
                    </div>
                    <a href="comprobantes.php" class="small-box-footer">Comprobantes de pago <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                

                <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                  <div class="small-box bgVerde colorBlanco">
                    <div class="inner">
                      <h4 style="font-size: 40px;">
                        <strong><?php echo $smoneda . ' ' . $totalc; ?> </strong>
                      </h4>
                      <p>Compras</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-cart-plus" aria-hidden="true"></i>
                    </div>
                    <a href="ingreso.php" class="small-box-footer">Compras <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>

                <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                  <div class="small-box bgCafe colorBlanco">
                    <div class="inner">
                      <h4 style="font-size: 40px;">
                        <strong><?php echo $smoneda . ' ' . $totalv; ?> </strong>
                      </h4>
                      <p>Ventas</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </div>
                    <a href="venta.php" class="small-box-footer">Ventas <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>

              </div>
              <div class="panel-body">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      Compras en los últimos 10 días
                    </div>
                    <div class="box-body">
                      <canvas id="compras" width="400" height="300"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      Ventas en los últimos 10 días
                    </div>
                    <div class="box-body">
                      <canvas id="ventas" width="400" height="300"></canvas>
                    </div>
                  </div>
                </div>
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
  <script src="../public/js/Chart.bundle.min.js"></script>
  <script src="../public/js/Chart.min.js"></script>
  <script>
    var ctx = document.getElementById("compras").getContext('2d');
    var compras = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [<?php echo $fechasc ?>],
        datasets: [{
          label: '# Compras en <?php echo $smoneda ?> de los últimos 10 dias',
          data: [<?php echo $totalesc ?>],
          backgroundColor: [
            'rgb(119, 54, 17, 0.5)',
            'rgb(182,187, 24, 0.5)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)'
          ],
          borderColor: [
            'rgb(119, 54, 17, 1)',
            'rgb(182,187, 24, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)'
          ],
          borderWidth: 2
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });

    var ctx = document.getElementById("ventas").getContext('2d');
    var ventas = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [<?php echo $fechasv ?>],
        datasets: [{
          label: '# Ventas en <?php echo $smoneda ?> de los últimos 10 días',
          data: [<?php echo $totalesv ?>],
          backgroundColor: [
            'rgb(119, 54, 17, 0.5)',
            'rgb(182,187, 24, 0.5)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgb(119, 54, 17, 1)',
            'rgb(182,187, 24, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 2
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  </script>
<?php
}

ob_end_flush();
?>