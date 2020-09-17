<?
	session_start();
	if(isset($_ANO_)){
	$ano=$_ANO_;
	}else{
	$ano=$_ANO;
	}
	$institucion = $_INSTIT;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="../../../admin/clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" src="../../../admin/clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../admin/clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../admin/clases/jqueryui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../../../admin/clases/jqueryui/jquery.ui.core.js"></script>
<title>P.M.E.==== EMPRESAS</title>

<script>
$(document).ready(function() {
	
   CargaListado();

   
});
function CargaListado(){
	var dato="Listado";
	var parametros = "funcion="+dato;
	//alert(parametros);
	$.ajax({
		url:'mod/empresas/cont_empresas.php',
		data: parametros,
		type:'POST',	
			success:function(data){
				//alert(data);
				if(data==0){
					alert("Datos Vacios");
				}else{
					$('#cargar_listado').html(data);
				}
			}
	});
}

function IngresoDatos(){
	$('#cargar_listado').hide();
	$('#carga_datos').show();
	var dato="Ingreso";
	var parametros = "funcion="+dato;
 
	$.ajax({
		url:'mod/empresas/cont_empresas.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data!=0){
					$('#carga_datos').html(data);
					$('#modifica').hide();
					$('#guarda').show();
				}
			}
		
	});
}
function MostrarListado(){
	$('#cargar_listado').show();
	$('#carga_datos').hide();	
}
function MostrarTabla(){
	$('#cargar_listado').hide();
	$('#carga_datos').show();	
}

function Valida_Datos(){
	if($('#txtRUT').val()==""){
		alert("Digite RUT");
		$('#txtRUT').focus();
		return false;	
	}
	if($('#txtDIG').val()==""){
		alert("Digite digito verificador");
		$('#txtDIG').focus();
		return false;	
	}
	if($('#txtFOLIO').val()==""){
		alert("Digite folio de empresa");
		$('#txtFOLIO').focus();
		return false;	
	}
	if($('#txtRAZON').val()==""){
		alert("Digite Nombre de la empresa");
		$('#txtRAZON').focus();
		return false;	
	}
	if($('#txtDIREC').val()==""){
		alert("Digite direccion");
		$('#txtDIREC').focus();
		return false;	
	}
	if($('#txtMAIL').val()==""){
		alert("Digite e-mail");
		$('#txtMAIL').focus();
		return false;	
	}
	if($('#txtFONO').val()==""){
		alert("Digite telefono");
		$('#txtFONO').focus();
		return false;	
	}
	if($('#txtFAX').val()==""){
		alert("Digite fax");
		$('#txtFAX').focus();
		return false;	
	}
	if($('#txtCONTACTO').val()==""){
		alert("Digite persona de contacto");
		$('#txtCONTACTO').focus();
		return false;	
	}
	if($('#txtGIRO').val()==""){
		alert("Digite giro de la empresa");
		$('#txtGIRO').focus();
		return false;	
	}	
}
function GuardarDatos(){
	var valida 		= Valida_Datos();
	if(valida==false){
		return false;
	}	
	var rdb			= <?=$_INSTIT;?>;
	var rut 		= $('#txtRUT').val();
	var dig 		= $('#txtDIG').val();
	var razon		= $('#txtRAZON').val();
	var folio		= $('#txtFOLIO').val();
	var direccion 	= $('#txtDIREC').val();
	var fono 		= $('#txtFONO').val();
	var fax 		= $('#txtFAX').val();
	var contacto 	= $('#txtCONTACTO').val();
	var giro 		= $('#txtGIRO').val();
	var mail 		= $('#txtMAIL').val();
	var pagina 		= "Guardar";
	
	var parametros 	= 'funcion='+pagina+'&rut='+rut+'&dig='+dig+'&direccion='+direccion+'&fono='+fono+'&fax='+fax+'&contacto='+contacto+'&giro='+giro+'&folio='+folio+'&rdb='+rdb+'&razon='+razon+"&mail="+mail;
	//alert(parametros);
	$.ajax({
		url:'mod/empresas/cont_empresas.php',
		data:parametros,
		type:'POST',
			success:function(data){
				//alert(data);
				if(data==1){
					alert("DATOS GUARDADOS");	
				}else{
					alert("ERROR AL GUARDAR");
				}
			}
	});
	MostrarListado();
	CargaListado();
							
}

function Elimina(rdb,rut){
	var dato = "Eliminar";
	var parametros ='funcion='+dato+'&rdb='+rdb+'&rut='+rut;
	
	$.ajax({
		url:'mod/empresas/cont_empresas.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data==1){
					alert("DATO ELIMINADO");	
				}else{
					alert("ERROR DE ELIMINACION");
				}
			}
	})
	CargaListado();
}

function Modificar(rdb,rut){
	IngresoDatos();
	var dato = "Modificar";
	var parametros ='funcion='+dato+'&rdb='+rdb+'&rut='+rut;	
	//alert(parametros);
	$.ajax({
		url:'mod/empresas/cont_empresas.php',
		data:parametros,
		type:'POST',
			success:function(data){
				$('#modifica_datos').html(data);
				$('#guarda').hide();
				$('#modifica').show();
				$('#txtRUT').val($('#_txtRUT').val());
				$('#txtDIG').val($('#_txtDIG').val());
				$('#txtRAZON').val($('#_txtRAZON').val());
				$('#txtDIREC').val($('#_txtDIREC').val());
				$('#txtMAIL').val($('#_txtMAIL').val());
				$('#txtFOLIO').val($('#_txtFOLIO').val());
				$('#txtFONO').val($('#_txtFONO').val());
				$('#txtFAX').val($('#_txtFAX').val());
				$('#txtCONTACTO').val($('#_txtCONTACTO').val());
				$('#txtGIRO').val($('#_txtGIRO').val());
				
			}
	})
	
}

function ModificarDatos(){
	var valida 		= Valida_Datos();
	if(valida==false){
		return false;
	}
	var rdb			= <?=$_INSTIT;?>;	
	var rut 		= $('#txtRUT').val();
	var folio 		= $('#txtFOLIO').val();
	var razon 		= $('#txtRAZON').val();
	var mail 		= $('#txtMAIL').val();
	var direc 		= $('#txtDIREC').val();
	var fax	 		= $('#txtFAX').val();
	var fono 		= $('#txtFONO').val();
	var contacto 	= $('#txtCONTACTO').val();
	var giro 		= $('#txtGIRO').val();
	var dato		= "Actualizar";
	
	var parametros ="funcion="+dato+"&folio="+folio+"&razon="+razon+"&direccion="+direc+"&fax="+fax+"&fono="+fono+"&contacto="+contacto+"&giro="+giro+"&rdb="+rdb+"&rut="+rut;
//	alert(parametros);
	$.ajax({
		url:"mod/empresas/cont_empresas.php",
		data:parametros,
		type:'POST',
			success:function(data){
				//alert(data);
				
				if(data==1){
					alert("DATOS MODIFICADOS");
					
				}else{
					alert("ERROR EN MODIFICACION");
				}
				MostrarListado()
				CargaListado();
			}
		
		
	})
	
}

function Archivo(rdb,rut){
	var dato = "Imagen";
	var parametros = "funcion="+dato+"&rdb="+rdb+"&rut="+rut;
	//alert(parametros);
	$.ajax({
		url:"mod/empresas/cont_empresas.php",
		data:parametros,
		type:"POST",
			success:function(data){
				$('#carga_imagen').html(data);
				$('#carga_imagen').dialog({ 
								  autoOpen:true,
								  width:700,
								  height:700,
								  modal:true,
                                  buttons: {
                                   'IMPRIMIR': function(){     									
								   					window.print();                        
												},
								  }
											

								
								})
			}
	})
}

</script>

</head>

<body>
<div id="cargar_listado"></div>
<div id="carga_datos"></div>
<DIV id="modifica_datos"></DIV>
<div id="carga_imagen"></div>
</body>
</html>
