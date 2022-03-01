<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {


  require 'header.php';

  if ($_SESSION['ventas'] == 1) {

?>
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Ventas</h1>
                <hr>

                <a href="crearventa.php?op=new" class="btn bgVerde colorBlanco">
                  <i class="fa fa-plus"></i> Nueva Venta
                </a>

                <a href="ventasfechacliente.php" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"></i> Ventas por Cliente
                </a> 
                <a href="graficosv.php" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"></i> Gráfico de ventas
                </a>

                <a href="cliente.php" type="button" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"> Clientes</i>
                </a>
                <a href="comprobantes.php" type="button" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"> Comprobantes</i>
                </a>
                <a href="tipopago.php" type="button" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"> Tipos de pago</i>
                </a>

                <div class="box-tools pull-right">

                </div>
              </div>
              <!--box-header-->
              <!--centro-->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Número</th>
                    <th>Total Venta</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Número</th>
                    <th>Total Venta</th>
                    <th>Estado</th>
                  </tfoot>
                </table>
              </div>
              <!--fin centro-->
            </div>
          </div>
        </div>
        <!-- /.box -->

      </section>
      <!-- /.content -->
    </div>

    <!--Modal-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 65% !important;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Seleccione un Articulo</h4>
          </div>
          <div class="modal-body">
            <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
              <thead>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Precio Venta</th>
                <th>Imagen</th>
              </thead>
              <tbody>

              </tbody>
              <tfoot>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Precio Venta</th>
                <th>Imagen</th>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button class="btn btn-default" type="button" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!--modal para ver la venta-->
    <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 65% !important;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Vista de la venta</h4>
          </div>
          <div class="modal-body">
            <div class="form-group col-lg-8 col-md-8 col-xs-12">
              <label for="">Cliente(*):</label>
              <input class="form-control" type="hidden" name="idventam" id="idventam">
              <input class="form-control" type="text" name="cliente" id="cliente" maxlength="7" readonly>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label>Fecha(*):</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control pull-right" type="text" name="fecha_horam" id="fecha_horam" readonly>
              </div>
              <!-- /.input group -->
            </div>
            <div class="form-group col-lg-4 col-md-4 col-xs-6">
              <label for="">Comprobante(*):</label>
              <input class="form-control" type="text" name="tipo_comprobantem" id="tipo_comprobantem" maxlength="7" readonly>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-xs-6">
              <label for="">Serie: </label>
              <input class="form-control" type="text" name="serie_comprobantem" id="serie_comprobantem" maxlength="7" readonly>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-xs-6">
              <label for="">Número: </label>
              <input class="form-control" type="text" name="num_comprobantem" id="num_comprobantem" maxlength="10" readonly>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-xs-6">
              <label for="">Impuesto: </label>
              <div class="input-group">
                <input class="form-control" type="text" name="impuestom" id="impuestom" readonly>
                <span class="input-group-addon">%</span>
              </div>
              <!-- /input-group -->
            </div>
            <div class="form-group col-lg-12 col-md-12 col-xs-12">
              <table id="detallesm" class="table table-striped table-bordered table-condensed table-hover">
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
          <div class="form-group col-lg-12 col-md-12 col-xs-12">

          </div>
          <div class="modal-footer">
            <button class="btn bgVerde colorBlanco" type="button" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>



    <!-- fin Modal-->
  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script src="scripts/venta.js"></script>
<?php
}

ob_end_flush();
?>