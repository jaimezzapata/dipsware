<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {


  require 'header.php';

  if ($_SESSION['configuracion'] == 1) {

?>
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <!-- Default box -->
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Comprobantes</h1>
                <hr />
                <a class="btn bgVerde colorBlanco" id="btnagregar" onclick="mostrarform(true)">
                  <i class="fa fa-plus-circle"></i> Nuevo Comprobante
                </a>
                <a href="cliente.php" type="button" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"> Clientes</i>
                </a>
                <a href="tipopago.php" type="button" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"> Tipos de pago</i>
                </a>
                <a href="venta.php" type="button" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"> Ventas</i>
                </a>
                <a href="crearventa.php" type="button" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"> Nueva Venta</i>
                </a>
                <div class="box-tools pull-right"></div>
              </div>
              <!--box-header-->
              <!--centro-->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="
                table table-striped table-bordered table-condensed table-hover
              ">
                  <thead>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Serie/Número</th>
                    <th>Estado</th>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
              <div class="panel-body" style="height: 400px" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Nombre</label>
                    <input class="form-control" type="hidden" name="id_comp_pago" id="id_comp_pago" />
                    <input class="form-control" type="text" name="nombre" id="nombre" maxlength="50" placeholder="Nombre" required />
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-xs-12">
                    <label for="">Letra de serie</label>
                    <input class="form-control" type="text" name="letra_serie" id="letra_serie" maxlength="3" required />
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-xs-12">
                    <label for="">Serie</label>
                    <input class="form-control" type="text" name="serie_comprobante" id="serie_comprobante" maxlength="3" required />
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-xs-12">
                    <label for="">Número</label>
                    <input class="form-control" type="text" name="num_comprobante" id="num_comprobante" maxlength="7" required />
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn bgVerde colorBlanco" type="submit" id="btnGuardar">
                      <i class="fa fa-save"></i> Guardar
                    </button>

                    <button class="btn bgCafeClaro colorBlanco  " onclick="cancelarform()" type="button">
                      <i class="fa fa-arrow-circle-left"></i> Cancelar
                    </button>
                  </div>
                </form>
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
  <script src="scripts/comprobantes.js"></script>
<?php
}

ob_end_flush();
?>