<?php 
require_once "../modelos/Articulo.php";

$articulo=new Articulo();

$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':

	if (!file_exists($_FILES['imagen']['tmp_name'])|| !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
		$imagen=$_POST["imagenactual"];
	}else{
		$ext=explode(".", $_FILES["imagen"]["name"]);
		if ($_FILES['imagen']['type']=="image/jpg" || $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png") {
			$imagen=round(microtime(true)).'.'. end($ext);
			move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/".$imagen);
		}
	}
	if (empty($idarticulo)) {
		$rspta=$articulo->insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
		echo $rspta ? "Producto registrados correctamente" : "El producto ya existe, intente nuevamente";
	}else{
         $rspta=$articulo->editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
		echo $rspta ? "Producto editado correctamente" : "No se pudo editar el producto";
	}
		break;
	

	case 'desactivar':
		$rspta=$articulo->desactivar($idarticulo);
		echo $rspta ? "Producto desactivado correctamente" : "El Producto no se pudo desactivar";
		break;
	case 'activar':
		$rspta=$articulo->activar($idarticulo);
		echo $rspta ? "Producto activado correctamente" : "El Producto no se pudo sactivar";
		break;
	
	case 'mostrar':
		$rspta=$articulo->mostrar($idarticulo);
		echo json_encode($rspta);
		break;


    case 'listar':
		$rspta=$articulo->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
				"0"=>($reg->condicion)?
				'<button class="btn bgVerde colorBlanco btn-md" onclick="mostrar('.$reg->idarticulo.')">
					<i class="fa fa-pencil"></i>
				</button>'.' '.'
				<button class="btn bgCafe colorBlanco btn-md" onclick="desactivar('.$reg->idarticulo.')">
					<i class="fa fa-close"></i>
				</button>':
				'<button class="btn bgVerde colorBlanco btn-md" onclick="mostrar('.$reg->idarticulo.')">
					<i class="fa fa-pencil"></i>
				</button>'.' '.
				'<button class="btn bgCafe colorBlanco btn-md" onclick="activar('.$reg->idarticulo.')">
					<i class="fa fa-check-square"></i>
				</button>',
				"1"=>$reg->nombre,
				"2"=>$reg->categoria,
				"3"=>$reg->codigo,
				"4"=>$reg->stock,
				"5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>",
				"6"=>$reg->descripcion,
				"7"=>($reg->condicion)?
				'<span class="label bgVerde colorlanco">Activado</span>':
				'<span class="label bgCafe colorBlanco">Desactivado</span>'
            );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		case 'selectCategoria':
			require_once "../modelos/Categoria.php";
			$categoria=new Categoria();

			$rspta=$categoria->select();
			echo '<option value="0">seleccione...</option>';
			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->idcategoria.'>'.$reg->nombre.'</option>';
			}
			break;
}
 ?>