<?php
require_once "../modelos/Venta.php";
if (strlen(session_id()) < 1)
	session_start();

$venta = new Venta();

$idventa = isset($_POST["idventa"]) ? limpiarCadena($_POST["idventa"]) : "";
$idcliente = isset($_POST["idcliente"]) ? limpiarCadena($_POST["idcliente"]) : "";
$idusuario = $_SESSION["idusuario"];
$tipo_comprobante = isset($_POST["tipo_comprobante"]) ? limpiarCadena($_POST["tipo_comprobante"]) : "";
$serie_comprobante = isset($_POST["serie_comprobante"]) ? limpiarCadena($_POST["serie_comprobante"]) : "";
$num_comprobante = isset($_POST["num_comprobante"]) ? limpiarCadena($_POST["num_comprobante"]) : "";
$impuesto = isset($_POST["impuesto"]) ? limpiarCadena($_POST["impuesto"]) : "";
$total_venta = isset($_POST["total_venta"]) ? limpiarCadena($_POST["total_venta"]) : "";
$tipo_pago = isset($_POST["tipo_pago"]) ? limpiarCadena($_POST["tipo_pago"]) : "";
$num_transac = isset($_POST["num_transac"]) ? limpiarCadena($_POST["num_transac"]) : "";


switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idventa)) {
			$rspta = $venta->insertar($idcliente, $idusuario, $tipo_comprobante, $serie_comprobante, $num_comprobante, $impuesto, $total_venta, $tipo_pago, $num_transac, $_POST["idarticulo"], $_POST["cantidad"], $_POST["precio_venta"], $_POST["descuento"]);
			echo $rspta ? "Venta/Compra creada correctamente" : "No se pudo crear la Venta/Compra";
		}
		break;

	case 'anular':
		$rspta = $venta->anular($idventa);
		echo $rspta ? "Venta/Compra anulada correctamente" : "No se pudo anular la Venta/Compra";
		break;

	case 'mostrar':
		$rspta = $venta->mostrar($idventa);
		echo json_encode($rspta);
		break;


		//_______________________________________________________________________________________________________
		//opcion para mostrar la numeracion y la serie_comprobante de la factura
	case 'mostrar_numero':

		//mostrando el numero de factura de la tabla comprobantes
		require_once "../modelos/Comprobantes.php";
		$comprobantes = new Comprobantes();
		//$tipo_comprobante='Factura';
		$tipo_comprobante = $_REQUEST["tipo_comprobante"];
		$rspta = $comprobantes->mostrar_numero($tipo_comprobante);
		while ($reg = $rspta->fetch_object()) {
			$numero_comp = (int)$reg->num_comprobante;
		}

		$numero_venta = $numero_comp;

		//mostramos el numero de comprobante de la tabla ventas
		$rspta = $venta->numero_venta($tipo_comprobante);
		while ($regv = $rspta->fetch_object()) {
			$numero_venta = (int)$regv->num_comprobante;
		}

		$new_numero = '';

		//validamos si el numero de comprobante de la venta ya llego al limite para ir a la siguiente numeracion
		if ($numero_venta == 9999999 or empty($numero_venta)) {
			(int)$new_numero = '0000001';
			echo json_encode($new_numero);
		} elseif ($numero_venta == 9999999) {
			(int)$new_numero = '0000001';
			echo json_encode($new_numero);
		} else {
			$suma_numero = $numero_venta + 1;
			echo json_encode($suma_numero);
		}

		break;

	case 'mostrar_serie':

		//mostrando el numero de factura de la tabla comprobantes
		require_once "../modelos/Comprobantes.php";
		$comprobantes = new Comprobantes();
		//$tipo_comprobante='Factura';
		$tipo_comprobante = $_REQUEST["tipo_comprobante"];
		$rspta = $comprobantes->mostrar_serie($tipo_comprobante);
		while ($reg = $rspta->fetch_object()) {
			$serie_comp = $reg->serie_comprobante;
			$num_comp = $reg->num_comprobante;
			$letra_s = $reg->letra_serie;
		}
		$serie_com_comp = (int)$serie_comp;
		$num_com_comp = (int)$num_comp;

		//mostramos la serie de comprobante de la tabla ventas
		$rsptav = $venta->numero_serie($tipo_comprobante);
		$numeros = $serie_com_comp;
		$numeroco = $num_com_comp;

		while ($regv = $rsptav->fetch_object()) {
			$numeros = $regv->serie_comprobante;
			$numeroco = $regv->num_comprobante;
		}
		$ns = substr($numeros, -3);
		$nums = (int)$ns;
		$nuew_serie = 0;
		$numc = (int)$numeroco;
		if ($numc == 9999999 or empty($numeroco)) {
			$nuew_serie = $nums + 1;
			$serie = array(
				"letra" => $letra_s,
				"serie" => $nuew_serie
			);
			echo json_encode($serie);
		} else {
			$serie = array(
				"letra" => $letra_s,
				"serie" => $nums
			);
			echo json_encode($serie);
		}
		break;
		//opcion para mostrar la numeracion y la serie_comprobante de la boleta

		//______________________________________________________________________________________________

	case 'listarDetalle':
		require_once "../modelos/Negocio.php";
		$cnegocio = new Negocio();
		$rsptan = $cnegocio->listar();
		$regn = $rsptan->fetch_object();
		if (empty($regn)) {
			$smoneda = 'Simbolo de moneda';
		} else {
			$smoneda = $regn->simbolo;
			$nom_imp = $regn->nombre_impuesto;
		};
		//recibimos el idventa
		$id = $_GET['id'];

		$rspta = $venta->listarDetalle($id);
		$total = 0;

		echo 
		'<thead style="background-color:#A9D0F5">
			<th>Opciones</th>
			<th>Articulo</th>
			<th>Cantidad</th>
			<th>Precio Venta</th>
			<th>Descuento</th>
			<th>Subtotal</th>
       	</thead>';
		while ($reg = $rspta->fetch_object()) {
			echo 
			'<tr class="filas">
				<td></td>
				<td>' . $reg->nombre . '</td>
				<td>' . $reg->cantidad . '</td> 
				<td>' . $reg->precio_venta . '</td>
				<td>' . $reg->descuento . '</td>
				<td>' . $reg->subtotal . '</td>
			</tr>';
			$total = $total + ($reg->precio_venta * $reg->cantidad - $reg->descuento);
			$t_venta = $reg->total_venta;
			$imp = $reg->impuesto;
			$most_igv = $t_venta - $total;
		}
		echo 
		'<tfoot>
			<th>
				<span>SubTotal</span><br>
				<span id="valor_impuestoc">' . $nom_imp . ' ' . $imp . ' %</span><br>
				<span>TOTAL</span>
			</th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th>
				<span id="total">' . $smoneda . ' ' . number_format((float)$total, 2, '.', '') . '</span><br>
				<span id="most_imp">' . $smoneda . ' ' . number_format((float)$most_igv, 2, '.', '') . '</span><br>
				<span id="most_total" maxlength="4">' . $smoneda . ' ' . $t_venta . '</span>
			</th>
       	</tfoot>';
		break;


	case 'listar':
		$rspta = $venta->listar();
		$data = array();

		while ($reg = $rspta->fetch_object()) {

			if ($reg->tipo_comprobante == 'Factura') {
				$url = '../reportes/exFactura.php?id=';
			}
			if ($reg->tipo_comprobante == 'Bono') {
				$url = '../reportes/exBono.php?id=';
			}

			$data[] = array(
				"0" => (($reg->estado == 'Aceptado') ?
				'<button id="buttonExport" class="btn bgVerde colorBlanco btn-md" onclick="mostrar(' . $reg->idventa . ')">
					<i class="fa fa-eye"></i></button>' . ' ' .
				'<button class="btn bgCafe colorBlanco btn-md" onclick="anular(' . $reg->idventa . ')">
					<i class="fa fa-close"></i></button>' : 
				'<button class="btn bgVerde colorBlanco btn-md" onclick="mostrar(' . $reg->idventa . ')">
					<i class="fa fa-eye"></i>
				</button>') .
				'<a target="_blank" href="' . $url . $reg->idventa . '">
					<button class="btn bgVerde colorBlanco btn-md">
						<i class="fa fa-file"></i>
					</button>
				</a>',
				"1" => $reg->fecha,
				"2" => $reg->cliente,
				"3" => $reg->usuario,
				"4" => $reg->serie_comprobante . '-' . $reg->num_comprobante,
				"5" => $reg->total_venta,
				"6" => ($reg->estado == 'Aceptado') ?
				'<span class="label bgVerde colorBlanco">Aceptado</span>' :
				'<span class="label bgCafe colorBlanco">Anulado</span>'
			);
		}
		$results = array(
			"sEcho" => 1, //info para datatables
			"iTotalRecords" => count($data), //enviamos el total de registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;


	case 'selectCliente':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarc();
		echo '<option value="">seleccione...</option>';
		while ($reg = $rspta->fetch_object()) {

			echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
		}
		break;

	case 'cantidad_articulos':
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();
		$rsptav = $articulo->cantidadarticulos();
		//$regv=$rsptav->fetch_object();
		//$totalarticulos=$regv->totalar;
		echo json_encode($rsptav);
		break;

	case 'listarArticulos':
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();

		$rspta = $articulo->listarActivosVenta();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$btncolor = '';
			if ($reg->stock <= 10) {
				$btncolor = '<button class="btn btn-danger btn-xs">' . $reg->stock . '</button>';
			} elseif ($reg->stock > 10 && $reg->stock < 30) {
				$btncolor = '<button class="btn bgCafeClaro colorBlanco btn-xs">' . $reg->stock . '</button>';
			} elseif ($reg->stock >= 30) {
				$btncolor = '<button class="btn bgVerde colorBlanco btn-xs">' . $reg->stock . '</button>';
			}
			$data[] = array(
				"0" => 
					'<button class="btn bgVerde colorBlanco btn-xs" id="addetalle" name="addetalle" onclick="agregarDetalle(' . $reg->idarticulo . ',\'' . $reg->nombre . '\',' . $reg->precio_venta . ',' . $reg->stock . ')">
						<span class="fa fa-plus"></span> Añadir
					</button>',
				"1" => $reg->nombre,
				"2" => $reg->codigo,
				"3" => $btncolor,
				"4" => "<img src='../files/articulos/" . $reg->imagen . "' height='40px' width='40px'>"

			);
		}

		$results = array(
			"sEcho" => 1, //info para datatables
			"iTotalRecords" => count($data), //enviamos el total de registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;


	case 'selectComprobante':
		require_once "../modelos/Comprobantes.php";
		$comprobantes = new Comprobantes();

		$rspta = $comprobantes->select();
		echo '<option value="">Seleccione...</option>';
		while ($reg = $rspta->fetch_object()) {
			echo '<option value="' . $reg->nombre . '">' . $reg->nombre . '</option>';
		}
		break;

	case 'selectTipopago':
		require_once "../modelos/Tipopago.php";
		$tipopago = new Tipopago();

		$rspta = $tipopago->select();
		while ($reg = $rspta->fetch_object()) {
			echo '<option value="' . $reg->nombre . '">' . $reg->nombre . '</option>';
		}
		break;
}
