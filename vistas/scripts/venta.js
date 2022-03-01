var tabla;

//funcion que se ejecuta al inicio
function init(){


   listar();

}
 

//funcion listar
function listar(){
	tabla=$('#tbllistado').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		buttons: [
	            {
	                extend: 'excelHtml5',
	            	text:'<i class="fa fa-file-excel-o"></i> Excel',
	            	titleAttr: 'Exportar a Excel',
	                title: 'Reporte de Ventas',
	            },
	            {	
	                extend: 'pdfHtml5',
	            	text:'<i class="fa fa-file-pdf-o"></i> PDF',
	            	titleAttr: 'Exportar a PDF',
	                title: 'Reporte de Ventas',

	            },
	            {
	            	extend: 'colvis',
	             	text:'<i class="fa fa-eye"></i>Seleccionar campos',
	            	titleAttr: 'Selecciona los campos a exportar',

	       		}
		],
		"ajax":
		{
			url:'../ajax/venta.php?op=listar',
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
}


function mostrar(idventa){
	 $("#getCodeModal").modal('show');
	$.post("../ajax/venta.php?op=mostrar",{idventa : idventa},
		function(data,status)
		{
			data=JSON.parse(data);
			//mostrarform(true);

			$("#cliente").val(data.cliente);
			$("#tipo_comprobantem").val(data.tipo_comprobante);
			$("#serie_comprobantem").val(data.serie_comprobante);
			$("#num_comprobantem").val(data.num_comprobante);
			$("#fecha_horam").val(data.fecha);
			$("#impuestom").val(data.impuesto);
			$("#idventam").val(data.idventa);
			
			//ocultar y mostrar los botones
		});
	$.post("../ajax/venta.php?op=listarDetalle&id="+idventa,function(r){
		$("#detallesm").html(r);
	});

}
//funcion para desactivar
function anular(idventa){
	bootbox.confirm("¿Esta seguro de anular esta venta?", function(result){
		if (result) {
			$.post("../ajax/venta.php?op=anular", {idventa : idventa}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}



init();