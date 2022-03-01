<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {


  require 'header.php';

  if ($_SESSION['almacen'] == 1) {

?>
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Categoria</h1>
                <hr>

                <a class="btn bgVerde colorBlanco" id="btnagregar" onclick="mostrarform(true)">
                  <i class="fa fa-plus-circle"> Nueva Categoría</i>
                </a>
                <a href="articulo.php" type="button" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"> Productos</i>
                </a>
                <a href="proveedor.php" type="button" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"> Proveedores</i>
                </a>
                <a href="ingreso.php" type="button" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"> Compras</i>
                </a>

                <div class="box-tools pull-right">

                </div>
              </div>
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <div class="panel-body" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Nombre</label>
                    <input class="form-control" type="hidden" name="idcategoria" id="idcategoria">
                    <input class="form-control" type="text" name="nombre" id="nombre" maxlength="50" placeholder="Nombre" required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Descripción</label>
                    <input class="form-control" type="text" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripcion">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn bgVerde colorBlanco" type="submit" id="btnGuardar">
                      <i class="fa fa-save"></i> Guardar
                    </button>
                    <button class="btn bgCafe colorBlanco" onclick="cancelarform()" type="button">
                      <i class="fa fa-arrow-circle-left"></i> Cancelar
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script src="scripts/categoria.js"></script>
<?php
}
ob_end_flush();
?>