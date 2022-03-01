<?php
require "../config/Conexion.php";
class Consultas
{

  public function __construct()
  {
  }

  //listar registros
  public function comprasfecha($fecha_inicio, $fecha_fin)
  {
    $sql = "SELECT DATE(i.fecha_hora) as fecha, u.nombre as usuario, p.nombre as proveedor, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante, i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin'";
    return ejecutarConsulta($sql);
  }

  public function ventasfechacliente($fecha_inicio, $fecha_fin, $idcliente)
  {
    $sql = "SELECT DATE(v.fecha_hora) as fecha, u.nombre as usuario, p.nombre as cliente, v.tipo_comprobante,v.serie_comprobante, v.num_comprobante , v.total_venta, v.impuesto, v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.idcliente='$idcliente'";
    return ejecutarConsulta($sql);
  }

  public function totalcomprahoy()
  {
    $sql = "SELECT IFNULL(SUM(total_compra),0) as total_compra FROM ingreso WHERE DATE(fecha_hora)=curdate()";
    return ejecutarConsulta($sql);
  }

  public function totalventahoy()
  {
    $sql = "SELECT IFNULL(SUM(total_venta),0) as total_venta FROM venta WHERE DATE(fecha_hora)=curdate()";
    return ejecutarConsulta($sql);
  }

  public function comprasultimos_10dias()
  {
    $sql = " SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) AS fecha, SUM(total_compra) AS total FROM ingreso GROUP BY fecha_hora ORDER BY fecha_hora DESC LIMIT 0,10";
    return ejecutarConsulta($sql);
  }

  public function ventasultimos_10dias()
  {
    $sql = " SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) AS fecha, SUM(total_venta) AS total FROM venta GROUP BY fecha_hora ORDER BY fecha_hora DESC LIMIT 0,10";
    return ejecutarConsulta($sql);
  }

  public function ventasultimos_12meses()
  {
    $sql = " SELECT DATE_FORMAT(fecha_hora,'%M') AS fecha, SUM(total_venta) AS total FROM venta GROUP BY MONTH(fecha_hora) ORDER BY fecha_hora DESC LIMIT 0,12";
    return ejecutarConsulta($sql);
  }


  public function ventasultimos_12meses_grafica()
  {
    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $sql = " SELECT DATE_FORMAT(fecha_hora,'%M') AS fecha, SUM(total_venta) AS total FROM venta GROUP BY MONTH(fecha_hora) ORDER BY fecha_hora DESC LIMIT 0,12";
    $resultado = ejecutarConsulta($sql);
    foreach ($resultado as $row) {
      $mes = $output["fecha"] = $meses[date("n", strtotime($row["fecha"])) - 1];
      $p = $output["total"] = $row["total"];
      echo $grafica = "{name:'" . $mes . "', y:" . $p . "},";
    }
  }

  public function comparsultimos_12meses_grafica()
  {
    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $sql = " SELECT DATE_FORMAT(fecha_hora,'%M') AS fecha, SUM(total_compra) AS total FROM ingreso GROUP BY MONTH(fecha_hora) ORDER BY fecha_hora DESC LIMIT 0,12";
    $resultado = ejecutarConsulta($sql);
    foreach ($resultado as $row) {
      $mes = $output["fecha"] = $meses[date("n", strtotime($row["fecha"])) - 1];
      $p = $output["total"] = $row["total"];
      echo $grafica = "{name:'" . $mes . "', y:" . $p . "},";
    }
  }

  public function ventas_grafica()
  {
    $sql = "SELECT DATE(fecha_hora) AS fecha, SUM(total_venta) AS total FROM venta GROUP BY MONTH(fecha_hora) ORDER BY fecha_hora DESC LIMIT 0,12";
    return ejecutarConsulta($sql);
  }

  public function compras_grafica()
  {
    $sql = "SELECT DATE(fecha_hora) AS fecha, SUM(total_compra) AS total FROM ingreso GROUP BY MONTH(fecha_hora) ORDER BY fecha_hora DESC LIMIT 0,12";
    return ejecutarConsulta($sql);
  }

  public function cantidadclientes()
  {
    $sql = "SELECT COUNT(*) totalc FROM persona WHERE tipo_persona='Cliente'";
    return ejecutarConsulta($sql);
  }

  public function cantidadproveedores()
  {
    $sql = "SELECT COUNT(*) totalp FROM persona WHERE tipo_persona='Proveedor'";
    return ejecutarConsulta($sql);
  }

  public function cantidadarticulos()
  {
    $sql = "SELECT COUNT(*) totalar FROM articulo WHERE condicion=1";
    return ejecutarConsulta($sql);
  }
  public function totalstock()
  {
    $sql = "SELECT SUM(stock) AS totalstock FROM articulo";
    return ejecutarConsulta($sql);
  }

  public function cantidadcategorias()
  {
    $sql = "SELECT COUNT(*) totalca FROM categoria WHERE condicion=1";
    return ejecutarConsulta($sql);
  }

  public function cantidadusuarios()
  {
    $sql = "SELECT COUNT(*) totalcu FROM usuario WHERE condicion=1";
    return ejecutarConsulta($sql);
  }

  public function cantidadcomprobantes()
  {
    $sql = "SELECT COUNT(*) totalcomp FROM comp_pago WHERE condicion=1";
    return ejecutarConsulta($sql);
  }

  public function cantidadventas()
  {
    $sql = "SELECT COUNT(*) totalventas FROM ingreso WHERE estado='Aceptado'";
    return ejecutarConsulta($sql);
  }

  public function cantidadcompras()
  {
    $sql = "SELECT COUNT(*) totalcompras FROM venta WHERE estado='Aceptado'";
    return ejecutarConsulta($sql);
  }
}