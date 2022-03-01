var tabla;

//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   })
}

//funcion limpiar
function limpiar(){
	$("#id_comp_pago").val("");
	$("#nombre").val("");
	$("#letra_serie").val(""); 
	$("#serie_comprobante").val("");
	$("#num_comprobante").val(""); 
}
 
//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//cancelar form
function cancelarform(){
	limpiar();
	mostrarform(false);
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
	                title: 'Reporte de Comprobantes',
	            },
	            {	
	                extend: 'pdfHtml5',
	            	text:'<i class="fa fa-file-pdf-o"></i> PDF',
	            	titleAttr: 'Exportar a PDF',
	                title: 'Reporte de Comprobantes',

	            },
	            {
	            	extend: 'colvis',
	             	text:'<i class="fa fa-eye"></i>Seleccionar campos',
	            	titleAttr: 'Selecciona los campos a exportar',

	       		}
		],
		"ajax":
		{
			url:'../ajax/comprobantes.php?op=listar',
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

//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../ajax/comprobantes.php?op=guardaryeditar",
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
}

//funcion para mostrar los datos para editar en el formulario
function mostrar(id_comp_pago){
	$.post("../ajax/comprobantes.php?op=mostrar",{id_comp_pago : id_comp_pago},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);

			$("#nombre").val(data.nombre);
			$("#letra_serie").val(data.letra_serie);
			$("#serie_comprobante").val(data.serie_comprobante);
			$("#num_comprobante").val(data.num_comprobante);
			$("#id_comp_pago").val(data.id_comp_pago);
		})
}


//funcion para desactivar el coprobante
function desactivar(id_comp_pago){
	bootbox.confirm("¿Seguro desea desactivar este comprobante?", function(result){
		if (result) {
			$.post("../ajax/comprobantes.php?op=desactivar", {id_comp_pago : id_comp_pago}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//activar el comprobante
function activar(id_comp_pago){
	bootbox.confirm("¿Seguro desea activar este comprobante?" , function(result){
		if (result) {
			$.post("../ajax/comprobantes.php?op=activar" , {id_comp_pago : id_comp_pago}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

init();