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
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Producto</h1>
                <hr>
                <a class="btn bgVerde colorBlanco " onclick="mostrarform(true)" id="btnagregar">
                  <i class="fa fa-plus-circle"> Agregar Producto</i>
                </a>

                <a href="categoria.php" type="button" class="btn bgVerde colorBlanco">
                  <i class="fa fa-circle"> Categorías</i>
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
                    <th>Categoría</th>
                    <th>Código</th>
                    <th>Stock</th>
                    <th>Imágen</th>
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
                    <label for="">Nombre(*):</label>
                    <input class="form-control" type="hidden" name="idarticulo" id="idarticulo">
                    <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Categoría(*):</label>
                    <select name="idcategoria" id="idcategoria" class="form-control selectpicker" data-Live-search="true" required></select>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Cantidad</label>
                    <input class="form-control" type="number" name="stock" id="stock" placeholder="0" readonly>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Descripción</label>
                    <input class="form-control" type="text" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripcion">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Imágen:</label>
                    <input class="form-control" type="file" name="imagen" id="imagen">
                    <input type="hidden" name="imagenactual" id="imagenactual">
                    <img src="" alt="" width="150px" height="120" id="imagenmuestra">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Código:</label>
                    <input class="form-control" type="text" name="codigo" id="codigo" placeholder="codigo del prodcuto" required>
                    <button class="btn bgVerde colorBlanco" type="button" onclick="generarbarcode()"><i class="fa fa-save"></i> Generar</button>
                    <button class="btn bgCafeClaro colorBlanco" type="button" onclick="imprimir()"><i class="fa fa-arrow-circle-down"></i> Imprimir</button>
                    <div id="print">
                      <svg id="barcode"></svg>
                    </div>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn bgVerde colorBlanco" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                    <button class="btn bgCafeClaro colorBlanco" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
  require 'footer.php'
  ?>
  <script src="../public/js/JsBarcode.all.min.js"></script>
  <script src="../public/js/jquery.PrintArea.js"></script>
  <script src="scripts/articulo.js"></script>

<?php
}

ob_end_flush();
?>