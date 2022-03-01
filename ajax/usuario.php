<?php
session_start();
require_once "../modelos/Usuario.php";

$usuario = new Usuario();

$idusuarioc = isset($_POST["idusuarioc"]) ? limpiarCadena($_POST["idusuarioc"]) : "";
$clavec = isset($_POST["clavec"]) ? limpiarCadena($_POST["clavec"]) : "";
$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$cargo = isset($_POST["cargo"]) ? limpiarCadena($_POST["cargo"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
			$imagen = $_POST["imagenactual"];
		} else {

			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {

				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
			}
		}

		//Hash SHA256 para la contraseña
		$clavehash = hash("SHA256", $clave);

		if (empty($idusuario)) {
			$rspta = $usuario->insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso']);
			echo $rspta ? "Usuario creado correctamente" : "El usuario ya se encuentra registrado en la base de datos";
		} else {
			$rspta = $usuario->editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $imagen, $_POST['permiso']);
			echo $rspta ? "Usuario actualizado correctamente" : "No se pudo actualizar el usuario, intente nuevamente";
		}
		break;


	case 'desactivar':
		$rspta = $usuario->desactivar($idusuario);
		echo $rspta ? "Usuario desactivado correctamente" : "No se pudo desactivar el usuario, intente nuevamente";
		break;

	case 'activar':
		$rspta = $usuario->activar($idusuario);
		echo $rspta ? "Usuario activado correctamente" : "No se pudo activar el usuario, intente nuevamente";
		break;

	case 'mostrar':
		$rspta = $usuario->mostrar($idusuario);
		echo json_encode($rspta);
		break;

	case 'editar_clave':
		$clavehash = hash("SHA256", $clavec);

		$rspta = $usuario->editar_clave($idusuarioc, $clavehash);
		echo $rspta ? "Contraseña actualizada correctamente" : "No se pudo actualizar la contraseña";
		break;

	case 'mostrar_clave':
		$rspta = $usuario->mostrar_clave($idusuario);
		echo json_encode($rspta);
		break;

	case 'listar':
		$rspta = $usuario->listar();
		//declaramos un array
		$data = array();


		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => ($reg->condicion) ?
					'<button class="btn bgVerde colorBlanco btn-md" onclick="mostrar(' . $reg->idusuario . ')">
				<i class="fa fa-pencil"></i></button>' . ' ' .
					'<button class="btn bgCafeClaro colorBlanco btn-md" onclick="mostrar_clave(' . $reg->idusuario . ')">
				<i class="fa fa-key"></i></button>' . ' ' .
					'<button class="btn bgVerde colorBlanco btn-md" onclick="desactivar(' . $reg->idusuario . ')">
				<i class="fa fa-close"></i></button>' :
					'<button class="btn bgVerde colorBlanco btn-md" onclick="mostrar(' . $reg->idusuario . ')">
				<i class="fa fa-pencil"></i></button>' . ' ' .
					'<button class="btn bgCafeClaro colorBlanco btn-md" onclick="mostrar_clave(' . $reg->idusuario . ')">
				<i class="fa fa-key"></i></button>' . ' ' .
					'<button class="btn bgCafeClaro colorBlanco btn-md" onclick="activar(' . $reg->idusuario . ')">
				<i class="fa fa-check-square"></i></button>',
				"1" => $reg->nombre,
				"2" => $reg->tipo_documento,
				"3" => $reg->num_documento,
				"4" => $reg->telefono,
				"5" => $reg->email,
				"6" => $reg->login,
				"7" => ($reg->condicion) ?
					'<span class="label bgVerde colorBlanco">Activo</span>' :
					'<span class="label bgCafeClaro colorBlanco">Inactivo</span>'
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

	case 'permisos':
		//obtenemos toodos los permisos de la tabla permisos
		require_once "../modelos/Permiso.php";
		$permiso = new Permiso();
		$rspta = $permiso->listar();

		//obtener permisos asigandos
		$id = $_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		//declaramos el array para almacenar todos los permisos marcados
		$valores = array();

		//almacenar permisos asigandos
		while ($per = $marcados->fetch_object()) {
			array_push($valores, $per->idpermiso);
		}

		//mostramos la lista de permisos
		while ($reg = $rspta->fetch_object()) {
			$sw = in_array($reg->idpermiso, $valores) ? 'checked' : '';
			echo '<li><input type="checkbox" ' . $sw . ' name="permiso[]" value="' . $reg->idpermiso . '">' . $reg->nombre . '</li>';
		}
		break;

	case 'verificar':
		//validar si el usuario tiene acceso al sistema
		$logina = $_POST['logina'];
		$clavea = $_POST['clavea'];

		//Hash SHA256 en la contraseña
		$clavehash = hash("SHA256", $clavea);

		$rspta = $usuario->verificar($logina, $clavehash);

		$fetch = $rspta->fetch_object();

		if (isset($fetch)) {
			# Declaramos la variables de sesion
			$_SESSION['idusuario'] = $fetch->idusuario;
			$_SESSION['nombre'] = $fetch->nombre;
			$_SESSION['imagen'] = $fetch->imagen;
			$_SESSION['login'] = $fetch->login;
			$_SESSION['cargo'] = $fetch->cargo;

			//obtenemos los permisos
			$marcados = $usuario->listarmarcados($fetch->idusuario);

			//declaramos el array para almacenar todos los permisos
			$valores = array();

			//almacenamos los permisos marcados en al array
			while ($per = $marcados->fetch_object()) {
				array_push($valores, $per->idpermiso);
			}

			//determinamos lo accesos al usuario
			in_array(1, $valores) ? $_SESSION['escritorio'] = 1 : $_SESSION['escritorio'] = 0;
			in_array(2, $valores) ? $_SESSION['almacen'] = 1 : $_SESSION['almacen'] = 0;
			in_array(3, $valores) ? $_SESSION['compras'] = 1 : $_SESSION['compras'] = 0;
			in_array(4, $valores) ? $_SESSION['ventas'] = 1 : $_SESSION['ventas'] = 0;
			in_array(5, $valores) ? $_SESSION['acceso'] = 1 : $_SESSION['acceso'] = 0;
			in_array(6, $valores) ? $_SESSION['consultac'] = 1 : $_SESSION['consultac'] = 0;
			in_array(7, $valores) ? $_SESSION['consultav'] = 1 : $_SESSION['consultav'] = 0;
			in_array(8, $valores) ? $_SESSION['configuracion'] = 1 : $_SESSION['configuracion'] = 0;
		}
		echo json_encode($fetch);

		break;

	case 'salir':
		//Limpiamos las variables de sesión   
		session_unset();
		//Destruìmos la sesión
		session_destroy();
		//Redireccionamos al login
		header("Location: ../index.php");

		break;
}
