<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Venta{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$impuesto,$total_venta,$tipo_pago,$num_transac,$idarticulo,$cantidad,$precio_venta,$descuento){
		date_default_timezone_set('America/Lima');
		$fecha_hora = date("Y-m-d");
	$sql="INSERT INTO venta (idcliente,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_venta,tipo_pago,num_transac,estado) VALUES ('$idcliente','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_venta','$tipo_pago','$num_transac','Aceptado')";
	//return ejecutarConsulta($sql);
	 $idventanew=ejecutarConsulta_retornarID($sql);
	 $num_elementos=0;
	 $sw=true;
	 while ($num_elementos < count($idarticulo)) {

	 	$sql_detalle="INSERT INTO detalle_venta (idventa,idarticulo,cantidad,precio_venta,descuento,estado) VALUES('$idventanew','$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]','1')";

	 	ejecutarConsulta($sql_detalle) or $sw=false; 

	 	$num_elementos=$num_elementos+1;
	 }
	 return $sw;
}



public function anular($idventa){

	$sw=true; 
	$sql="UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";
 	ejecutarConsulta($sql);
 	$sql_detalle="UPDATE detalle_venta SET estado='0' WHERE idventa='$idventa'"; 	
 	ejecutarConsulta($sql_detalle) or $sw=false;

	 return $sw;

}

//implementar un metodopara mostrar los datos de unregistro a modificar
public function mostrar($idventa){
	$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE idventa='$idventa'";
	return ejecutarConsultaSimpleFila($sql);
}

public function listarDetalle($idventa){
	$sql="SELECT dv.idventa,dv.idarticulo,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal, v.total_venta, v.impuesto, dv.estado FROM detalle_venta dv INNER JOIN articulo a ON dv.idarticulo=a.idarticulo INNER JOIN venta v ON v.idventa=dv.idventa WHERE dv.idventa='$idventa'"; 
	return ejecutarConsulta($sql);
}

//listar registros
public function listar(){
	$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario ORDER BY v.idventa DESC";
	return ejecutarConsulta($sql);
}


public function ventacabecera($idventa){
	$sql= "SELECT v.idventa, v.idcliente, p.nombre AS cliente, p.direccion, p.tipo_documento, p.num_documento, p.email, p.telefono, v.idusuario, u.nombre AS usuario, v.tipo_comprobante, v.serie_comprobante, v.num_comprobante, DATE(v.fecha_hora) AS fecha, v.impuesto, v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
	return ejecutarConsulta($sql);
}

public function ventadetalles($idventa){
	$sql="SELECT a.nombre AS articulo, a.codigo, d.cantidad, d.precio_venta, d.descuento, (d.cantidad*d.precio_venta-d.descuento) AS subtotal FROM detalle_venta d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idventa='$idventa'";
         return ejecutarConsulta($sql);
}



//funcion para selecciolnar el numero de factura
public function numero_venta($tipo_comprobante){ 
		 
		    $sql="SELECT num_comprobante FROM venta WHERE tipo_comprobante='$tipo_comprobante' ORDER BY idventa DESC limit 1 ";
 			return ejecutarConsulta($sql);
		  
}
//funcion para seleccionar la serie de la factura
public function numero_serie($tipo_comprobante){
		 
		    $sql="SELECT serie_comprobante ,num_comprobante FROM venta WHERE tipo_comprobante='$tipo_comprobante' ORDER BY idventa DESC limit 1";

return ejecutarConsulta($sql);
} 

}

 ?>
