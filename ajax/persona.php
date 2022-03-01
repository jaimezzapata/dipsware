<?php
require_once "../modelos/Persona.php";

$persona = new Persona();

$idpersona = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
$tipo_persona = isset($_POST["tipo_persona"]) ? limpiarCadena($_POST["tipo_persona"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idpersona)) {
			$rspta = $persona->insertar($tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email);
			echo $rspta ? "El Cliente/Proveedor creado correctamente" : "El Cliente/Proveedor ya existe en la base de datos";
		} else {
			$rspta = $persona->editar($idpersona, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email);
			echo $rspta ? "El Cliente/Proveedor actualizado correctamente" : "No se pudo actualizar el Cliente/Proveedor";
		}
		break;

	case 'mostrar':
		$rspta = $persona->mostrar($idpersona);
		echo json_encode($rspta);
		break;

	case 'desactivar':
		$rspta = $persona->desactivar($idpersona);
		echo $rspta ? "Cliente/Proveedor desactivada exitosamente" : "No se pudo desactivar el Cliente/Proveedor";
		break;
	case 'activar':
		$rspta = $persona->activar($idpersona);
		echo $rspta ? "Cliente/Proveedor activada exitosamente" : "No se pudo activar el Cliente/Proveedor";
		break;

	case 'listarp':
		$rspta = $persona->listarp();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => ($reg->condicion) ?
					'<button class="btn bgVerde colorBlanco btn-md" onclick="mostrar(' . $reg->idpersona . ')">
					<i class="fa fa-pencil"></i></button>' . ' ' . '
				<button class="btn bgCafe colorBlanco btn-md" onclick="desactivar(' . $reg->idpersona . ')">
					<i class="fa fa-close"></i></button>' :
					'<button class="btn bgVerde colorBlanco btn-md" onclick="mostrar(' . $reg->idpersona . ')">
					<i class="fa fa-pencil"></i></button>' . ' ' . '
				<button class="btn bgCafe colorBlanco btn-md" onclick="activar(' . $reg->idpersona . ')">
					<i class="fa fa-check"></i>
				</button>',
				"1" => $reg->nombre,
				"2" => $reg->tipo_documento,
				"3" => $reg->num_documento,
				"4" => $reg->telefono,
				"5" => $reg->email,
				"6" => ($reg->condicion) ?
					'<span class="label bgVerde colorBlanco">Activo</span>' :
					'<span class="label bgCafe colorBlanco">Inactivo</span>'
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

	case 'listarc':
		$rspta = $persona->listarc();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => ($reg->condicion) ?
					'<button class="btn bgVerde colorBlanco btn-md" onclick="mostrar(' . $reg->idpersona . ')">
					<i class="fa fa-pencil"></i></button>' . ' ' . '
				<button class="btn bgCafe colorBlanco btn-md" onclick="desactivar(' . $reg->idpersona . ')">
					<i class="fa fa-close"></i></button>' :
					'<button class="btn bgVerde colorBlanco btn-md" onclick="mostrar(' . $reg->idpersona . ')">
					<i class="fa fa-pencil"></i></button>' . ' ' . '
				<button class="btn bgCafe colorBlanco btn-md" onclick="activar(' . $reg->idpersona . ')">
					<i class="fa fa-check-square"></i>
				</button>',
				"1" => $reg->nombre,
				"2" => $reg->tipo_documento,
				"3" => $reg->num_documento,
				"4" => $reg->telefono,
				"5" => $reg->email,
				"6" => ($reg->condicion) ?
					'<span class="label bgVerde colorBlanco">Activo</span>' :
					'<span class="label bgCafe colorBlanco">Inactivo</span>'
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
