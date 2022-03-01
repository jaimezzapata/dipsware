<?php
require_once "../modelos/Tipopago.php";

$tipopago = new Tipopago();

$idtipopago = isset($_POST["idtipopago"]) ? limpiarCadena($_POST["idtipopago"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idtipopago)) {
			$rspta = $tipopago->insertar($nombre, $descripcion);
			echo $rspta ? "Tipo de pago creado correctamente" : "No se pudo crear el tipo de pago";
		} else {
			$rspta = $tipopago->editar($idtipopago, $nombre, $descripcion);
			echo $rspta ? "Tipo de pago actualizado correctamente" : "No se pudo actualizar el tipo de pago";
		}
		break;

	case 'desactivar':
		$rspta = $tipopago->desactivar($idtipopago);
		echo $rspta ? "Tipo de pago desactivado correctamente" : "No se pudo desactivar el tipo de pago";
		break;
	case 'activar':
		$rspta = $tipopago->activar($idtipopago);
		echo $rspta ? "Tipo de pago activado correctamente" : "No se pudo activar el tipo de pago";
		break;

	case 'mostrar':
		$rspta = $tipopago->mostrar($idtipopago);
		echo json_encode($rspta);
		break;

	case 'listar':
		$rspta = $tipopago->listar();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => $reg->nombre,
				"1" => $reg->descripcion
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
}
