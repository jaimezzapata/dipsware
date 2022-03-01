<?php
require_once "../modelos/Categoria.php";

$categoria = new Categoria();

$idcategoria = isset($_POST["idcategoria"]) ? limpiarCadena($_POST["idcategoria"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idcategoria)) {
			$rspta = $categoria->insertar($nombre, $descripcion);
			echo $rspta ? "Categoría creada exitosamente" : "La categoría ya existe, intente nuevamente";
		} else {
			$rspta = $categoria->editar($idcategoria, $nombre, $descripcion);
			echo $rspta ? "Categoría editada exitosamente" : "No se pudo editar la categoría, intente nuevamente";
		}
		break;

	case 'desactivar':
		$rspta = $categoria->desactivar($idcategoria);
		echo $rspta ? "Categoría desactivada exitosamente" : "No se pudo desactivar la categoría";
		break;
	case 'activar':
		$rspta = $categoria->activar($idcategoria);
		echo $rspta ? "Categoría activada exitosamente" : "No se pudo activar la categoría";
		break;

	case 'mostrar':
		$rspta = $categoria->mostrar($idcategoria);
		echo json_encode($rspta);
		break;

	case 'listar':
		$rspta = $categoria->listar();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => ($reg->condicion) ?
					'<button class="btn bgVerde colorBlanco btn-md" onclick="mostrar(' . $reg->idcategoria . ')">
					<i class="fa fa-pencil"></i></button>' . ' ' . '
				<button class="btn bgCafe colorBlanco btn-md" onclick="desactivar(' . $reg->idcategoria . ')">
					<i class="fa fa-close"></i></button>' :
					'<button class="btn bgVerde colorBlanco btn-md" onclick="mostrar(' . $reg->idcategoria . ')">
					<i class="fa fa-pencil"></i></button>' . ' ' . '
				<button class="btn bgCafe colorBlanco btn-md" onclick="activar(' . $reg->idcategoria . ')">
					<i class="fa fa-check-square"></i>
				</button>',
				"1" => $reg->nombre,
				"2" => $reg->descripcion,
				"3" => ($reg->condicion) ?
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
