var tabla;

//funcion que se ejecuta al inicio
function init(){
   	mostrar_impuesto();
   	nombre_impuesto();
	listarArticulos();
	$("#t_pago").hide();

   	$("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   });

    $("#formulariocliente").on("submit",function(e){
   	agregarCliente(e);
   });

   //cargamos los items al select cliente
   $.post("../ajax/venta.php?op=selectCliente", function(r){
   	$("#idcliente").html(r);
   	$('#idcliente').selectpicker('refresh'); 
   });

   //cargamos los items al celect comprobantes
   $.post("../ajax/venta.php?op=selectComprobante", function(c){ 
   	   	//alert(c);
   	$("#tipo_comprobante").val("Ticket");
   	$("#tipo_comprobante").html(c);
   	$("#tipo_comprobante").selectpicker('refresh');

   });

   //cargamos los items al celect tipo de pago
   $.post("../ajax/venta.php?op=selectTipopago", function(c){ 
   	$("#tipo_pago").html(c);
   	$("#tipo_pago").selectpicker('refresh');
   });


}
 
//funcion limpiar
function limpiar(){
	$("#idventa").val("");
	$("#idcliente").val("");
	$("#cliente").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$("#impuesto").val("");
	$("#total_venta").val("");
	$(".filas").remove();
	$("#total").html("0");
	$("#tpagado").val("");
	//marcamos el primer tipo_documento
	$("#tipo_comprobante").selectpicker('refresh');
	$("#idcliente").selectpicker('refresh');

	$("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#idpersona").val("");
	$("#Modalcliente").modal('hide');

}
//__________________________________________________________________________
//mostramos el num_comprobante de la fatura

function ShowComprobante(){
	mostrar_impuesto();
	var tipo_comprobante = $("#tipo_comprobante").val();
			if(tipo_comprobante.length==0){
				$("#serie_comprobante").val("");
				$("#num_comprobante").val("");
			}else{
		    serie_comp();
			numero_comp();
			}
	}

function ShowTipopago(){
	var t_pago=$("#tipo_pago").val();
	if (t_pago=='Pago en efectivo' || t_pago=='Efectivo') {
		$("#t_pago").hide();
		$("#num_transac").val("");
	}else{
		$("#t_pago").show();
		$("#num_transac").val("");
	}
	 
}

//mostramos la serie del comprobante
function serie_comp(){
	var tipo_comprobante = $("#tipo_comprobante").val();

	$.post("../ajax/venta.php?op=mostrar_serie",{tipo_comprobante : tipo_comprobante},
		function(data,status)
		{
			data=JSON.parse(data);
			//alert(data.letra);
			$("#serie_comprobante").val(data.letra + ('000' + data.serie).slice(-3) ); // "0001"

		});
}

//mostramos el numero de comprobante
function numero_comp(){
	var tipo_comprobante = $("#tipo_comprobante").val();
	$.ajax({
	url: '../ajax/venta.php?op=mostrar_numero',
	data:{tipo_comprobante:tipo_comprobante},
	type:'get',
	dataType:'json',
	success: function(d){
			 num_comp=d;
	$("#num_comprobante").val( ('0000000' + num_comp).slice(-7) ); // "0001"
	$("#nFacturas").html( ('0000000' + num_comp).slice(-7) ); // "0001"
	}
	});
}


//mostramos el impuesto
no_aplica=0;
function mostrar_impuesto(){

	$.ajax({
	url: '../ajax/negocio.php?op=mostrar_impuesto',
	type:'get',
	dataType:'json',
	success: function(i){
		 impuesto=i;
		 sin_imp=0;
		 var checkbox=document.querySelector('#aplicar_impuesto');
		 checkbox.addEventListener('change', verificarEstado, false);
		 function verificarEstado(e){
		 if (e.target.checked) {
		 	$("#impuesto").val(impuesto);
		 	no_aplica=impuesto;
		 	calcularTotales();
		 	nombre_impuesto();
		 	
		 }else{
		 	$("#impuesto").val(sin_imp);
		 	no_aplica=0;
		 	calcularTotales();
		 	nombre_impuesto();
		 }
		}

	}

	});
}


//declaramos variables necesarias para trabajar con las compras y sus detalles
var cont=0;
var detalles=0;
$("#btnGuardar").hide();

//_______________________________________________________________________________________________


function listarArticulos(){
	tabla=$('#tblarticulos').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		buttons: [

		],
		"ajax":
		{
			url:'../ajax/venta.php?op=listarArticulos',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":10,//paginacion
		"order":[[0,"desc"]]//ordenar (columna, orden)
	}).DataTable();
//alert( 'Rows '+tabla.rows( '.selected' ).count()+' are selected' );
	 borrar_filas();
}
//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     //$("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../ajax/venta.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		bootbox.alert(datos);
     		mostrarform(false);
     	}
     });
init();
     limpiar();
     listarArticulos();
}

//funcion para desactivar
function anular(idventa){
	bootbox.confirm("¿Seguro desea anular esta venta?", function(result){
		if (result) {
			$.post("../ajax/venta.php?op=anular", {idventa : idventa}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload(); 
			});
		}
	})
}


function agregarDetalle(idarticulo,articulo,precio_venta,cantidad){
	var stock=cantidad;
	var numero_cantidad=1;
	var descuento=0;

	if (idarticulo!="") {
		var subtotal=cantidad*precio_venta;
		var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td class=""><button type="button" id="del" class="btn btn-danger btn-xs del" onclick="eliminarDetalle('+cont+')"><i class="fa fa-times"></i></button></td>'+
        '<td class="col-xs-6"><input style="width : 70px;" type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+
        '<td class="col-xs-1"><input style="width : 70px;" type="number" min="1" max="'+stock+'" onchange="ver_stock(this.value,'+stock+')" name="cantidad[]" id="cantidad[]" value="'+numero_cantidad+'"></td>'+
        '<td class="col-xs-1"><input style="width : 70px;" type="number" min="1" step="0.01" onchange="modificarSubtotales()" name="precio_venta[]" id="precio_venta[]" value="'+precio_venta+'"></td>'+
        '<td class="col-xs-1"><input style="width : 70px;" type="number" min="0" step="0.01" onchange="modificarSubtotales()" name="descuento[]" value="'+descuento+'"></td>'+
        '<td class="col-xs-1"><span id="subtotal'+cont+'" name="subtotal">'+subtotal+'</span></td>'+
		'</tr>';
		
		var product = null;
		var shelf = null;
		var status = null;
        
		cont++;
		detalles++;
		$('#detalles').append(fila);
		modificarSubtotales();
		

	}else{
		bootbox.alert("Error al ingresar el detalle, revisar las datos del articulo ");
	}

}




//borrar filas del datables
function borrar_filas(){
	     var index=-1;
    $('#tblarticulos tbody').on('click','#addetalle', function () {
 
        if ( index === -1 ) {
        	//alert(index);
			//selected.push( id );
        	$(this).prop("disabled",true);
			//$(this).remove().draw( false );

        } else {
        	//alert(index);
            //selected.splice( index, 1 );
        	$(this).prop("disabled",false);
        	//$(this).prop("disabled",true);
			//$(this).remove().draw( false );
        }
    } );

}

//esta funcion valida la cantidad a vender con el stock
function ver_stock(valor,cantidad){
	//alert(cantidad);
	var msj='La cantidad supera al stock actual';
	valor = parseInt(valor);
	if (valor>cantidad) {
		bootbox.alert(valor+' '+msj+' '+cantidad);
		 $("#btnGuardar").hide();
	}else{
	$("#btnGuardar").show();
	 modificarSubtotales();
         }

        }

function modificarSubtotales(){
	var cant=document.getElementsByName("cantidad[]");
	var prev=document.getElementsByName("precio_venta[]");
	var desc=document.getElementsByName("descuento[]");
	var sub=document.getElementsByName("subtotal");


	for (var i = 0; i < cant.length; i++) {
		var inpV=cant[i];
		var inpP=prev[i];
		var inpS=sub[i];
		var des=desc[i];


		inpS.value=(inpV.value*inpP.value)-des.value;
		document.getElementsByName("subtotal")[i].innerHTML=inpS.value.toFixed(2);
	}

	calcularTotales();
}

function calcularTotales(){

	var sub = document.getElementsByName("subtotal");
	var total=0.0;
	var simbolo="";

	for (var i = 0; i < sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
		var igv=total*(no_aplica/100);
		var total_monto=total+igv;
		var igv_dec=igv.toFixed(2);

	}
	$.ajax({
url: '../ajax/negocio.php?op=mostrar_simbolo',
type:'get',
dataType:'json', 
success: function(sim){
	 simbolo=sim;
	 $("#total").html(simbolo +' '+ total.toFixed(2)); 
	 $("#total_venta").val(total_monto.toFixed(2));

	 $("#most_total").html(simbolo + total_monto.toFixed(2));
	 $("#most_imp").html(simbolo + igv_dec);
	 var tpagado=$("#tpagado").val();
	 var totalvuelto=0;
	 
	if (tpagado>0) {
			totalvuelto=tpagado-total_monto;
	 		$("#vuelto").html(simbolo +' '+ totalvuelto.toFixed(2));

	}else{
			totalvuelto=0.0;
	 		$("#vuelto").html(simbolo +' '+ totalvuelto.toFixed(2));

	}
	 	
	 
	evaluar();
}

	});
	
}
function nombre_impuesto(){
$.ajax({
url: '../ajax/negocio.php?op=nombre_impuesto',
type:'get',
dataType:'json',
success: function(n){
	 nomp=n;
	 var valor_impuesto=no_aplica;
	 $("#valor_impuesto").html(nomp+' '+ valor_impuesto +"%");
	 	
	}

	});}

function evaluar(){  

	if (detalles>0) 
	{
		$("#btnGuardar").show();
	}
	else
	{
		$("#btnGuardar").hide();
		cont=0;
	}
}

function eliminarDetalle(indice){

$("#fila"+indice).remove();
calcularTotales();
detalles=detalles-1;

}


//funcion para guardar nuevo cliente
function agregarCliente(e){
	 $("#Modalcliente").modal('show');
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardarcliente").prop("disabled",true);
     var formData=new FormData($("#formulariocliente")[0]);

     $.ajax({
     	url: "../ajax/persona.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		bootbox.alert(datos);
     		mostrarform(false);
     		tabla.ajax.reload();
     	}
     });

     limpiar();
location.reload(true);
}

init();