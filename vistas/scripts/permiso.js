var tabla;

//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();

}


//funcion mostrar formulario
function mostrarform(flag){
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").hide();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").show();
		$("#btnGuardar").show();
		$("#btnagregar").hide();
	}
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
	                title: 'Reporte de Permisos',
	            },
	            {	
	                extend: 'pdfHtml5',
	            	text:'<i class="fa fa-file-pdf-o"></i> PDF',
	            	titleAttr: 'Exportar a PDF',
	                title: 'Reporte de Permisos',

	            }
		],
		"ajax":
		{
			url:'../ajax/permiso.php?op=listar',
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


init();