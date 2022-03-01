<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Tipopago{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($nombre,$descripcion){
	$sql="INSERT INTO tipo_pago (nombre,descripcion,estado) VALUES ('$nombre','$descripcion','1')";
	return ejecutarConsulta($sql);
}

public function editar($id_tipopago,$nombre,$descripcion){
	$sql="UPDATE tipo_pago SET nombre='$nombre',descripcion='$descripcion' 
	WHERE id_tipopago='$id_tipopago'";
	return ejecutarConsulta($sql);
}
public function desactivar($id_tipopago){
	$sql="UPDATE tipo_pago SET estado='0' WHERE id_tipopago='$id_tipopago'";
	return ejecutarConsulta($sql);
}
public function activar($id_tipopago){
	$sql="UPDATE tipo_pago SET estado='1' WHERE id_tipopago='$id_tipopago'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($id_tipopago){
	$sql="SELECT * FROM tipo_pago WHERE id_tipopago='$id_tipopago'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM tipo_pago";
	return ejecutarConsulta($sql);
}
//listar y mostrar en selct
public function select(){
	$sql="SELECT * FROM tipo_pago WHERE estado=1";
	return ejecutarConsulta($sql);
}
}
