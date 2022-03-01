<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {

  require 'header.php';
  if ($_SESSION['compras'] == 1) {
?>
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Proveedor</h1>
                <hr>

                <a class="btn bgVerde colorBlanco" id="btnagregar" onclick="mostrarform(true)">
                  <i class="fa fa-plus-circle"> Nuevo Proveedor</i></a>

                <a href="categoria.php" type="button" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"> Categorías</i>
                </a>
                <a href="articulo.php" type="button" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"> Productos</i>
                </a>
                <a href="ingreso.php" type="button" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"> Compras</i>
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
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Número</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <div class="panel-body" style="height: 400px;" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Nombre: (*)</label>
                    <input class="form-control" type="hidden" name="idpersona" id="idpersona">
                    <input class="form-control" type="hidden" name="tipo_persona" id="tipo_persona" value="Proveedor">
                    <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre del proveedor" required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Tipo Dcumento: (*)</label>
                    <select class="form-control select-picker" name="tipo_documento" id="tipo_documento" required>
                      <option value="">SELECCIONE</option>
                      <option value="NIT">NIT</option>
                      <option value="CEDULA">CÉDULA</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Número Documento: (*)</label>
                    <input class="form-control" type="text" name="num_documento" id="num_documento" maxlength="20" placeholder="Número de Documento">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Dirección: ()</label>
                    <input class="form-control" type="text" name="direccion" id="direccion" maxlength="70" placeholder="Direccion">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Teléfono: ()</label>
                    <input class="form-control" type="text" name="telefono" id="telefono" maxlength="20" placeholder="Número de Telefono">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Email: ()</label>
                    <input class="form-control" type="email" name="email" id="email" maxlength="50" placeholder="Email">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn bgVerde colorBlanco" type="submit" id="btnGuardar">
                      <i class="fa fa-save"></i> Guardar
                    </button>
                    <button class="btn bgCafeClaro colorBlanco" onclick="cancelarform()" type="button">
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
  <script src="scripts/proveedor.js"></script>
<?php
}

ob_end_flush();
?>