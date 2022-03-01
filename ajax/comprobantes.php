<?php 
require_once "../modelos/Comprobantes.php";

$comprobantes=new Comprobantes();

$id_comp_pago=isset($_POST["id_comp_pago"])? limpiarCadena($_POST["id_comp_pago"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$letra_serie=isset($_POST["letra_serie"])? limpiarCadena($_POST["letra_serie"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($id_comp_pago)) {
		$rspta=$comprobantes->insertar($nombre,$letra_serie,$serie_comprobante,$num_comprobante);
		echo $rspta ? "Comprobante creado correctamente" : "El comprobante ya existe en la base de datos";
	}else{
         $rspta=$comprobantes->editar($id_comp_pago,$nombre,$letra_serie,$serie_comprobante,$num_comprobante);
		echo $rspta ? "Comprobante actualizado correctamente" : "No se pudo actualizar el comprobante";
	}
		break;
	

	case 'desactivar':
		$rspta=$comprobantes->desactivar($id_comp_pago);
		echo $rspta ? "Comprobante desactivado correctamente" : "No se pudo desactivar el comprobante";
		break;
	case 'activar':
		$rspta=$comprobantes->activar($id_comp_pago);
		echo $rspta ? "Comprobante activado correctamente" : "No se pudo activar el comprobante";
		break;
	
	case 'mostrar':
		$rspta=$comprobantes->mostrar($id_comp_pago);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$comprobantes->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>($reg->condicion)?
			'<button class="btn bgVerde colorBlanco btn-md" onclick="mostrar('.$reg->id_comp_pago.')">
			<i class="fa fa-pencil"></i></button>'.' '
			.'<button class="btn bgCafeClaro colorBlanco btn-md" onclick="desactivar('.$reg->id_comp_pago.')">
			<i class="fa fa-close"></i></button>':
			'<button class="btn bgVerde colorBlanco btn-md" onclick="mostrar('.$reg->id_comp_pago.')">
			<i class="fa fa-pencil"></i></button>'.' '
			.'<button class="btn bgCafeClaro colorBlanco btn-md" onclick="activar('.$reg->id_comp_pago.')">
			<i class="fa fa-check-square"></i></button>',
            "1"=>$reg->nombre,
            "2"=>$reg->letra_serie.$reg->serie_comprobante.'-'.$reg->num_comprobante,
            "3"=>($reg->condicion)?
			'<span class="label bgVerde colorBlanco">Activo</span>':
			'<span class="label bgCafe colorBlanco">Inactivo</span>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;
}
