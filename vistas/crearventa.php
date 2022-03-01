<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {


  require 'header.php';

  if ($_SESSION['ventas'] == 1) {
    require_once "../modelos/Negocio.php";
    $cnegocio = new Negocio();
    $rsptan = $cnegocio->listar();
    $regn = $rsptan->fetch_object();
    if (empty($regn)) {
      $smoneda = '';
      $tipo_impuesto = '';
      $nombrenegocio = 'Configurar datos de su Empresa';
    } else {
      $smoneda = $regn->simbolo;
      $tipo_impuesto = $regn->nombre_impuesto;
      $nombrenegocio = $regn->nombre;
    };
?>
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="row">
          <div class="col-md-6">
            <div class="box box-info">
              <div class="box-header with-border">
                <h1 class="box-title">Ventas</h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!--box-header-->
              <!--centro-->
              <div class="panel-body" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-12 col-md-8 col-xs-12">
                    <label for="">Cliente(*):</label>
                    <input class="form-control" type="hidden" name="idventa" id="idventa">
                    <div class="input-group">
                      <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true" required>
                      </select>
                      <span class="input-group-btn">
                        <button class="btn bgVerde colorBlanco" type="button" onclick="agregarCliente()">
                          <i class="fa fa-plus-circle"></i> Crear cliente
                        </button>
                      </span>
                    </div>
                  </div>
                  <div class="form-group col-lg-6 col-md-4 col-xs-6">
                    <label for="">Comprobante(*):</label>
                    <select onchange="ShowComprobante()" name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" data-Live-search="true" required>
                    </select>
                  </div>

                  <div class="form-group col-lg-6 col-md-4 col-xs-6">
                    <label for="">Serie: </label>
                    <input class="form-control" type="text" name="serie_comprobante" id="serie_comprobante" maxlength="7" readonly required>
                  </div>

                  <div class="form-group col-lg-4 col-md-4 col-xs-6">
                    <label for="">Número: </label>
                    <input class="form-control" type="text" name="num_comprobante" id="num_comprobante" maxlength="10" readonly required>
                  </div>

                  <div class="form-group col-lg-4 col-md-4 col-xs-6">
                    <label for="">Aplicar Impuesto: </label>
                    <div class="input-group">
                      <span class="input-group-addon bgVerde">
                        <input class="flat-red" type="checkbox" name="aplicar_impuesto" id="aplicar_impuesto">
                      </span>
                      <input class="form-control" type="text" name="impuesto" id="impuesto" readonly>
                    </div>
                    <!-- /input-group -->
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label for="">Tipo de pago(*):</label>
                    <select onchange="ShowTipopago()" name="tipo_pago" id="tipo_pago" class="form-control selectpicker" data-live-search="true" required>
                    </select>
                  </div>
                  <div id="t_pago" class="form-group col-lg-4 col-md-4 col-xs-12">
                    <label for="">N° Operación: </label>
                    <input class="form-control" type="text" name="num_transac" id="num_transac" maxlength="45">
                  </div>
                  <div class="form-group  col-lg-12 col-md-12 col-xs-12">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover text-center">
                      <thead class="bgVerde">
                        <th class="">Eliminar</th>
                        <th class="col-xs-6">Producto</th>
                        <th class="col-xs-1">Cantidad</th>
                        <th class="col-xs-1">Precio</th>
                        <th class="col-xs-1">Descuento</th>
                        <th class="col-xs-1">Subtotal</th>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                    <div style="height: 31px; border: #ffff 1px solid;">
                      <label> SubTotal</label>
                      <span id="total" class="pull-right badge bgVerde">
                        <label><?php echo $smoneda; ?> 0.00</label>
                      </span>
                    </div>
                    <div style="height: 31px; border: #ffff 1px solid;">
                      <label id="valor_impuesto"><?php echo $tipo_impuesto; ?> 0.00</label>
                      <span id="most_imp" class="pull-right badge bgVerde">
                        <label for=""><?php echo $smoneda; ?> 0.00</label>
                      </span>
                    </div>
                    <div style="height: 31px; border: #ffff 1px solid;">
                      <label> TOTAL</label>
                      <span id="most_total" class="pull-right badge bgVerde">
                        <label for=""><?php echo $smoneda; ?> 0.00</label>
                      </span>
                    </div>
                    <div style="background-color:#773611ff; color:#fff; height: 31px; border: #ffff 1px solid;">
                      <label> Cant. pagado</label>
                      <input type="hidden" step="0.01" name="total_venta" id="total_venta">
                      <input class="pull-right colorCafe" onchange="modificarSubtotales()" style="width: 80px; height: 31px;" type="number" step="0.01" name="tpagado" id="tpagado">
                    </div>
                    <div style="background-color:#773611ff; color:#fff; height: 31px; border: #ffff 1px solid;">
                      <label> Cambio</label>
                      <span id="vuelto" class="pull-right badge bgVerde">
                        <label class="colorCafe" for=""><?php echo $smoneda; ?> 0.00</label>
                      </span>
                    </div>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn bgVerde colorBlanco" type="submit" id="btnGuardar">
                      <i class="fa fa-save"></i> Guardar
                    </button>
                    <a href="venta.php">
                      <button class="btn bgCafeClaro colorBlanco" type="button" id="btnCancelar">
                        <i class="fa fa-arrow-circle-left"></i> Cancelar
                      </button>
                    </a>
                  </div>
                </form>
              </div>
              <!--fin centro-->
            </div>
          </div>

          <div class="col-md-6">
            <div class="box box-warning">
              <div class="panel-body" id="formularioregistros">
                <div class="box-header with-border">
                  <h1 class="box-title">Seleccione un Producto</h1>
                  <div class="box-tools pull-right">
                  </div>
                </div>
                <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opción</th>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                  </thead>
                  <tbody agregarDetalle()>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box -->

      </section>
      <!-- /.content -->
    </div>





    <!--modal para agregar nuevo cliente-->
    <div class="modal fade" id="Modalcliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Nuevo cliente</h4>
          </div>
          <div class="modal-body">
            <form action="" name="formulariocliente" id="formulariocliente" method="POST">
              <div class="form-group col-lg-6 col-md-6 col-xs-12">
                <label for="">Nombre</label>
                <input class="form-control" type="hidden" name="idpersona" id="idpersona">
                <input class="form-control" type="hidden" name="tipo_persona" id="tipo_persona" value="Cliente">
                <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre del cliente" required>
              </div>
              <div class="form-group col-lg-6 col-md-6 col-xs-12">
                <label for="">Tipo Dcumento</label>
                <select class="form-control select-picker" name="tipo_documento" id="tipo_documento" required>
                  <option value="">SELECCIONE</option>
                  <option value="DNI">PASAPORTE</option>
                  <option value="RUC">RUT</option>
                  <option value="CEDULA">CEDULA</option>
                </select>
              </div>
              <div class="form-group col-lg-6 col-md-6 col-xs-12">
                <label for="">Número Documento</label>
                <input class="form-control" type="text" name="num_documento" id="num_documento" maxlength="20" placeholder="Número de Documento">
              </div>
              <div class="form-group col-lg-6 col-md-6 col-xs-12">
                <label for="">Direccion</label>
                <input class="form-control" type="text" name="direccion" id="direccion" maxlength="70" placeholder="Direccion">
              </div>
              <div class="form-group col-lg-6 col-md-6 col-xs-12">
                <label for="">Telefono</label>
                <input class="form-control" type="text" name="telefono" id="telefono" maxlength="20" placeholder="Número de Telefono">
              </div>
              <div class="form-group col-lg-6 col-md-6 col-xs-12">
                <label for="">Email</label>
                <input class="form-control" type="email" name="email" id="email" maxlength="50" placeholder="Email">
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button class="btn bgVerde colorBlanco" type="submit" id="btnGuardar">
                  <i class="fa fa-save"></i> Guardar
                </button>
                <button class="btn bgCafeClaro colorBlanco" type="button" data-dismiss="modal">
                  <i class="fa fa-arrow-circle-left"></i> Cancelar
                </button>
              </div>
            </form>

          </div>
          <div class="form-group col-lg-12 col-md-12 col-xs-12">

          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>

  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script src="scripts/crearventa.js"></script>
<?php
}

ob_end_flush();
?>