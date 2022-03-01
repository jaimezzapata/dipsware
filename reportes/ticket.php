
<?php 
//activamos almacenamiento en el buffer
ob_start();
if (strlen(session_id())<1) 
  session_start();

if (!isset($_SESSION['nombre'])) {
  echo "debe ingresar al sistema correctamente para vosualizar el reporte";
}else{

if ($_SESSION['ventas']==1) {

// incluimos la clase venta
require_once "../modelos/Venta.php"; 

$venta = new Venta();

//en el objeto $rspta obtenemos los valores devueltos del metodo ventacabecera del modelo
$rspta = $venta->ventacabecera($_GET["id"]);

$reg=$rspta->fetch_object();

//datos de la empresa
require_once "../modelos/Negocio.php";
$cnegocio = new Negocio();
$rsptan = $cnegocio->listar();
$regn=$rsptan->fetch_object();
$empresa = $regn->nombre;
$ndocumento = $regn->ndocumento;
$documento = $regn->documento;
$direccion = $regn->direccion; 
$telefono = $regn->telefono;
$email = $regn->email;
$pais = $regn->pais;
$ciudad = $regn->ciudad;

 

//include "fpdf/fpdf.php";
include('../fpdf181/fpdf.php');
$pdf = new FPDF($orientation='P',$unit='mm', array(58,350));
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);    //Letra Arial, negrita (Bold), tam. 20
$textypos = 5;
$pdf->setY(2); 
$pdf->setX(2);
$pdf->Cell(54,$textypos, utf8_decode($empresa) ,0,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->setY(6); 
$pdf->setX(2);
$pdf->Cell(54,$textypos, utf8_decode($ndocumento.": ".$documento) ,0,0,'C');
$pdf->setY(9); 
$pdf->setX(2);
$pdf->Cell(54,$textypos,utf8_decode("Direc: ".$direccion),0,0,'C');
$pdf->setY(12); 
$pdf->setX(2);
$pdf->Cell(54,$textypos,utf8_decode("Telf: ".$telefono),0,0,'C');
$pdf->setY(15); 
$pdf->setX(2);
$pdf->Cell(54,$textypos,utf8_decode($ciudad),0,0,'C');
$pdf->setY(22); 
$pdf->setX(2);
$pdf->Cell(54,$textypos, utf8_decode("Fecha: ".$reg->fecha));
$pdf->SetFont('Arial','',8);
$pdf->setY(25); 
$pdf->setX(2);
$pdf->Cell(54,$textypos, utf8_decode("Cliente: ".$reg->cliente));
$pdf->setY(28); 
$pdf->setX(2);
$pdf->Cell(54,$textypos, utf8_decode("Atendió: ".$_SESSION['nombre']));
$pdf->setY(34); 
$pdf->setX(2);
$pdf->Cell(54,$textypos, utf8_decode("FOLIO: ".$reg->serie_comprobante." - ".$reg->num_comprobante));
$pdf->SetFont('Arial','',8);    //Letra Arial, negrita (Bold), tam. 20
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(54,$textypos,'---------------------VENTA------------------------');
$total =0;
    $rsptad = $venta->ventadetalles($_GET["id"]);
    $cantidad=0;
    while ($regd = $rsptad->fetch_object()) {
$venta=utf8_decode(substr($regd->articulo,0,100)).'. Cant.'.utf8_decode($regd->cantidad).'X Pre.'.utf8_decode($regd->precio_venta).'='.utf8_decode($regd->subtotal);

while (!(strlen($venta)=='')) { 
    $subcadena = substr($venta, 0, 40);
    $pdf->SetFont('Arial','',8);
    $pdf->Ln();
    $pdf->setX(2);  
    $pdf->Cell(54,3,$subcadena,0,0,'C'); 
    $venta= substr($venta,40); 
} 

$cantidad+=$regd->cantidad;


     } 
$pdf->setX(2);
$pdf->Cell(54,$textypos+10,utf8_decode("TOTAL: ") );
$pdf->setX(25);
$pdf->Cell(2,$textypos+10,"$ ".number_format($reg->total_venta,2,".",","),0,0,"R");
$pdf->setX(2);
$pdf->Cell(54,$textypos+20, utf8_decode('N° de articulos: '.$cantidad));
$pdf->setX(2);
$pdf->Cell(54,$textypos+30, utf8_decode('GRACIAS POR SU COMPRA '),0,0,'C');
/*$pdf->SetFont('Arial','',8);  
$pdf->setX(2);
$pdf->Cell(40,$textypos+16,utf8_decode($ciudad.' - '.$pais),0,0,'C');*/
$pdf->output();



  }else{
echo "No tiene permiso para visuali



ar el reporte";
}

}


ob_end_flush();
  ?>
