<? session_start(); 
	$ano=$_ANO;
require "../../Class/Membrete.php";	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Creacion de Menu</title>
<link rel="stylesheet" type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css">
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>
<script type="text/javascript">

$(document).ready(function() {
	
	$( "#crea_menu" ).tabs({
	
   });
    $( "input:submit,input:button", "#crea_menu" ).button();
   cargatabla();
});

	function cargatabla(){
	var parametros = "funcion=1";
	//alert(parametros);
		$.ajax({
		  url:'mod/Crear_Menu/cont_crea_menu.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#table_items').html(data);
						
							$("input:submit,input:button", "#table_items" ).button();
						}
				     }
		         })
	          } // fin funcion cargartabla
		
	
			  
	function Busca_Menu(id_menu){
	
var parametros = "funcion=2&id_menu="+id_menu;
	//alert(parametros);
	 $.ajax({
		   url:'mod/Crear_Menu/cont_crea_menu.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data!=0){
                   //alert("Datos Encontrados");
				    $('#respuestabuscamenu').html(data);	
						var _id_menu = $('#_id_menu').val();
						var _nivel=$('#_nivel').val();
						$("#cmbNIVEL option[value="+_nivel+"]").attr("selected",true);
						$('#txtMENU').val($('#_menu').val());
						$('#txtURLMENU').val($('#_url').val());
						$('#txtORDENMENU').val($('#_orden').val());
						
						if($('#_ck_ingreso').val()==1){
							$('#ck_ingreso').attr('checked', true);	
							}
							if($('#_ck_modifica').val()==1){
							$('#ck_modifica').attr('checked', true);	
							}
							if($('#_ck_elimina').val()==1){
							$('#ck_elimina').attr('checked', true);	
							}
							if($('#_ck_ver').val()==1){
							$('#ck_ver').attr('checked', true);	
							}
												
						$('#txtMENU').focus();
$('#boton_modificar').html('<br><input name="Modificar" type="button" onClick="modifica_menu()" value="Modificar" />');
				  $("input:submit,input:button", "#cuerpo_creaMenu" ).button();
				  }else{
		           alert("Error al Cargar Datos");				  
				  }
		      }
		  })	
	}
	
	function guardar_menu(){
		
		if($('#txtMENU').val()==""){
			alert("Escriba Nombre de Menu");
			$('#txtMENU').focus();
			return false;
		  }
		  
		  if($('#txtURLMENU').val()==""){
			alert("Escriba URL");
			$('#txtURLMENU').focus();
			return false;
		  }
		  
		   if($('#cmbNIVEL').val()==0){
			alert("Sleccione Nivel");
			return false;
		  }
		  if($('#txtORDENMENU').val()==""){
			alert("Escriba Orden del Menu");
			$('#txtORDENMENU').focus();
			return false;
		  }
		  
	if ($('#ck_ingreso').is(':checked')){
		var ck_ingreso=1;
	} else {
		var ck_ingreso=0;
	}
	if ($('#ck_modifica').is(':checked')){
		var ck_modifica=1;
	} else {
		var ck_modifica=0;
	}
	if ($('#ck_elimina').is(':checked')){
		var ck_elimina=1;
	} else {
		var ck_elimina=0;
	}
	if ($('#ck_ver').is(':checked')){
		var ck_ver=1;
	} else {
		var ck_ver=0;
	}
			 
var parametros = "funcion=3&nombre_menu="+$("#txtMENU").val()+"&url="+$("#txtURLMENU").val()+"&nivel="+$("#cmbNIVEL").val()+"&orden_menu="+$("#txtORDENMENU").val()+"&ck_ingreso="+ck_ingreso+"&ck_modifica="+ck_modifica+"&ck_elimina="+ck_elimina+"&ck_ver="+ck_ver;
		// alert(parametros);
		 $.ajax({
		   url:'mod/Crear_Menu/cont_crea_menu.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
			//	alert(data);
				  if(data==1){
                   alert("Datos Guardados");
				   
				     $("#txtMENU").val("");
				   $("#txtURLMENU").val("");
				   $("#cmbNIVEL option[value=0]").attr("selected",true);
				   $("#txtORDENMENU").val("");
				   
				   $("#ck_ingreso").attr('checked', false);
				   $("#ck_modifica").attr('checked', false);
				   $("#ck_elimina").attr('checked', false);
				   $("#ck_ver").attr('checked', false);
				   
				   cargatabla();
				  }else{
		           alert("Error al Guardar Datos");				  
				  }
		      }
		  })
		}	
		
		
		function modifica_menu(id_menu){
		
		if($('#txtMENU').val()==""){
			alert("Escriba Nombre de Menu");
			return false;
		  }
		  
		  if($('#txtURLMENU').val()==""){
			alert("Escriba URL");
			return false;
		  }
		  
		   if($('#cmbNIVEL').val()==0){
			alert("Sleccione Nivel");
			return false;
		  }
		  if($('#txtORDENMENU').val()==""){
			alert("Escriba Orden del Menu");
			return false;
		  }
		  
	if ($('#ck_ingreso').is(':checked')){
		var ck_ingreso=1;
	} else {
		var ck_ingreso=0;
	}
	if ($('#ck_modifica').is(':checked')){
		var ck_modifica=1;
	} else {
		var ck_modifica=0;
	}
	if ($('#ck_elimina').is(':checked')){
		var ck_elimina=1;
	} else {
		var ck_elimina=0;
	}
	if ($('#ck_ver').is(':checked')){
		var ck_ver=1;
	} else {
		var ck_ver=0;
	}
	
	var _id_menu=$('#_id_menu').val();
			 
var parametros = "funcion=4&nombre_menu="+$("#txtMENU").val()+"&url="+$("#txtURLMENU").val()+"&nivel="+$("#cmbNIVEL").val()+"&orden_menu="+$("#txtORDENMENU").val()+"&ck_ingreso="+ck_ingreso+"&ck_modifica="+ck_modifica+"&ck_elimina="+ck_elimina+"&ck_ver="+ck_ver+"&id_menu="+_id_menu;

	//alert(parametros);
		 $.ajax({
		   url:'mod/Crear_Menu/cont_crea_menu.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data==1){
                   alert("Datos Modificados");
				   cargatabla();
				   
				   $("#txtMENU").val("");
				   $("#txtURLMENU").val("");
				   $("#cmbNIVEL option[value=0]").attr("selected",true);
				   $("#txtORDENMENU").val("");
				   
				   $("#ck_ingreso").attr('checked', false);
				   $("#ck_modifica").attr('checked', false);
				   $("#ck_elimina").attr('checked', false);
				   $("#ck_ver").attr('checked', false);
				   
		$('#boton_modificar').html('<br><input name="guarda_menu" id="guarda_menu" type="button" onClick="guardar_menu()" value="Guardar" />');
				  $("input:submit,input:button", "#cuerpo_creaMenu" ).button();		   
				   
				  }else{
		           alert("Error al Guardar Datos");				  
				  }
		      }
		  })
		}		
		
		function EliminarMenu(id_menu){
	
var parametros = "funcion=5&id_menu="+id_menu;

			if(!confirm("Seguro que desea Eliminar??")) { 
			return false;
			}else{
	
	 $.ajax({
		   url:'mod/Crear_Menu/cont_crea_menu.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data==1){
                 alert("Datos Eliminados");
				 cargatabla();
				  }else{
		           alert("Error al Cargar Datos");				  
				  }
		      }
		 
		  })	
		}
	}
	
	
	function guardar_menu_categoria(){
		
		if($('#selectMenu').val()==0){
			alert("Seleccione Menu");
			$('#selectMenu').focus();
			return false;
		  }
		  
		  if($('#txtCATEGORIA').val()==""){
			alert("Escriba Categoria");
			$('#txtCATEGORIA').focus();
			return false;
		  }
		  
		   if($('#cmbNIVELCAT').val()==0){
			alert("Sleccione Nivel");
			$('#cmbNIVELCAT').focus();
			return false;
		  }
		  if($('#txtURLCATEGORIA').val()==""){
			alert("Escriba URL ");
			$('#txtURLCATEGORIA').focus();
			return false;
		  }
		   if($('#txtORDENCATEGORIA').val()==""){
			alert("Escriba Orden de la Categoria");
			$('#txtORDENCATEGORIA').focus();
			return false;
		  }
		  
	if ($('#ck_ingresoC').is(':checked')){
		var ck_ingresoC=1;
	} else {
		var ck_ingresoC=0;
	}
	if ($('#ck_modificaC').is(':checked')){
		var ck_modificaC=1;
	} else {
		var ck_modificaC=0;
	}
	if ($('#ck_eliminaC').is(':checked')){
		var ck_eliminaC=1;
	} else {
		var ck_eliminaC=0;
	}
	if ($('#ck_verC').is(':checked')){
		var ck_verC=1;
	} else {
		var ck_verC=0;
	}
			 
var parametros = "funcion=6&id_Menu="+$("#selectMenu").val()+"&categoria="+$("#txtCATEGORIA").val()+"&nivel="+$("#cmbNIVELCAT").val()+"&url_cat="+$("#txtURLCATEGORIA").val()+"&orden_cat="+$("#txtORDENCATEGORIA").val()+"&ck_ingresoC="+ck_ingresoC+"&ck_modificaC="+ck_modificaC+"&ck_eliminaC="+ck_eliminaC+"&ck_verC="+ck_verC;

		 //alert(parametros);
		 
		 $.ajax({
		   url:'mod/Crear_Menu/cont_crea_menu.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data==1){
                   alert("Datos Guardados");
				   
				    $("#selectMenu option[value=0]").attr("selected",true);
				   $("#cmbNIVELCAT option[value=0]").attr("selected",true);
				   $("#txtCATEGORIA").val("")
				   $("#txtURLCATEGORIA").val("");
				   $("#cmbNIVEL option[value=0]").attr("selected",true);
				   $("#txtORDENCATEGORIA").val("");
				   $("#ck_ingresoC").attr('checked', false);
				   $("#ck_modificaC").attr('checked', false);
				   $("#ck_eliminaC").attr('checked', false);
				   $("#ck_verC").attr('checked', false);
				   cargatabla2();
				   
				  }else{
		           alert("Error al Guardar Datos");				  
				  }
		      }
		  })
		}	
		
	function Busca_Menu_categoria(id_categoria){
	
var parametros = "funcion=8&id_categoria="+id_categoria;
	//alert(parametros);
	
	 $.ajax({
		   url:'mod/Crear_Menu/cont_crea_menu.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data!=0){
                  // alert("Datos Encontrados");
				    $('#respuestabuscamenu_categoria').html(data);	
						var _menu_categoria = $('#_menu_categoria').val();
						var _nivelC=$('#_nivelC').val();
						//var _id_categoria=$('#_menu_categoria').val();
						
						
						$("#selectMenu option[value="+_menu_categoria+"]").attr("selected",true);
						$("#cmbNIVELCAT option[value="+_nivelC+"]").attr("selected",true);
						
						$('#txtCATEGORIA').val($('#_categoriaC').val());
						$('#txtURLCATEGORIA').val($('#_urlC').val());
						$('#txtORDENCATEGORIA').val($('#_id_categoria').val());
						
						if($('#_ck_ingresoC').val()==1){
							$('#ck_ingresoC').attr('checked', true);	
							}
							if($('#_ck_modificaC').val()==1){
							$('#ck_modificaC').attr('checked', true);	
							}
							if($('#_ck_eliminaC').val()==1){
							$('#ck_eliminaC').attr('checked', true);	
							}
							if($('#_ck_verC').val()==1){
							$('#ck_verC').attr('checked', true);	
							}
												
						$('#txtCATEGORIA').focus();
$('#boton_modificar_categoria').html('<br><input name="Modificar" type="button" onClick="modifica_menu_categoria()" value="Modificar" />');
				  $("input:submit,input:button", "#cuerpo_creaMenu" ).button();
				  }else{
		           alert("Error al Cargar Datos");				  
				  }
		      }
		  })	
	}
	
	
	
	function cargatabla2(){
	var parametros = "funcion=7";
	//alert(parametros);
		$.ajax({
		  url:'mod/Crear_Menu/cont_crea_menu.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#carga_categoria').html(data);
					/*	$("#flex2").flexigrid({
								width : 700,
								height : 280
						});*/
						
						
							$("input:submit,input:button", "#carga_categoria" ).button();
						}
				     }
		         })
	          } // fin funcion cargartabla
		
		
	function reseteo2(){
	
   $('#tabla_menu')[0].reset();
       var fun="mmenu";
	       var parametros = "funcion="+fun;
		   var selec = "select_categoria";
		   //alert(parametros);
		
		$.ajax({
		  url:'mod/Crear_Menu/cont_crea_menu.php',
		  
		  data:parametros,
		  type:'POST',
			success:function(data){
			//alert(data);
                if(data==0){
				  alert("No se Encontraron Datos");
				 // $('#cmb_funcion').html(0);
				  // $("#cmb_funcion option[value=0]").attr("selected",true); 
				}else{
				$('#'+selec+'').html(data);
				//$( "input:submit,input:button,a,button", "#mapaConcept" ).button();
				cargatabla2();
				  }
		        }
		     })
	$('#boton_modificar_categoria').html('<br><input type="button" name="guarda_menu" id="guarda_menu" value="Guardar"  title="Guardar Categoria" onclick="guardar_menu_categoria()"/>');	
	$("input:submit,input:button", "#cuerpo_creaMenu" ).button();
	}
	
	
	function modifica_menu_categoria(id_categoria){
		
		if($('#selectMenu').val()==0){
			alert("Seleccione Menu");
			$('#selectMenu').focus();
			return false;
		  }
		  
		  if($('#txtCATEGORIA').val()==""){
			alert("Escriba Categoria");
			$('#txtCATEGORIA').focus();
			return false;
		  }
		  
		   if($('#cmbNIVELCAT').val()==0){
			alert("Sleccione Nivel");
			$('#cmbNIVELCAT').focus();
			return false;
		  }
		  if($('#txtURLCATEGORIA').val()==""){
			alert("Escriba URL ");
			$('#txtURLCATEGORIA').focus();
			return false;
		  }
		   if($('#txtORDENCATEGORIA').val()==""){
			alert("Escriba Orden de la Categoria");
			$('#txtORDENCATEGORIA').focus();
			return false;
		  }
		  
	if ($('#ck_ingresoC').is(':checked')){
		var ck_ingresoC=1;
	} else {
		var ck_ingresoC=0;
	}
	if ($('#ck_modificaC').is(':checked')){
		var ck_modificaC=1;
	} else {
		var ck_modificaC=0;
	}
	if ($('#ck_eliminaC').is(':checked')){
		var ck_eliminaC=1;
	} else {
		var ck_eliminaC=0;
	}
	if ($('#ck_verC').is(':checked')){
		var ck_verC=1;
	} else {
		var ck_verC=0;
	}
	
	var i_id_categoria=$('#_id_categoria').val();
			 
var parametros = "funcion=9&id_Menu="+$("#selectMenu").val()+"&categoria="+$("#txtCATEGORIA").val()+"&nivel="+$("#cmbNIVELCAT").val()+"&url_cat="+$("#txtURLCATEGORIA").val()+"&orden_cat="+$("#txtORDENCATEGORIA").val()+"&ck_ingresoC="+ck_ingresoC+"&ck_modificaC="+ck_modificaC+"&ck_eliminaC="+ck_eliminaC+"&ck_verC="+ck_verC+"&i_id_categoria="+i_id_categoria;
	//alert(parametros);
	
		 $.ajax({
		   url:'mod/Crear_Menu/cont_crea_menu.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data==1){
                   alert("Datos Modificados");
				   cargatabla2();
				   $("#selectMenu option[value=0]").attr("selected",true);
				   $("#cmbNIVELCAT option[value=0]").attr("selected",true);
				   
				   $("#txtCATEGORIA").val("")
				   $("#txtURLCATEGORIA").val("");
				   $("#cmbNIVEL option[value=0]").attr("selected",true);
				   $("#txtORDENCATEGORIA").val("");
				   
				   
				   
				   $("#ck_ingresoC").attr('checked', false);
				   $("#ck_modificaC").attr('checked', false);
				   $("#ck_eliminaC").attr('checked', false);
				   $("#ck_verC").attr('checked', false);
				   
		$('#boton_modificar_categoria').html('<br><input name="guarda_menu" id="guarda_menu" type="button" onClick="guardar_menu_categoria()" value="Guardar" />');
				  $("input:submit,input:button", "#cuerpo_creaMenu" ).button();		   
				   
				  }else{
		           alert("Error al Guardar Datos");				  
				  }
		      }
		  })
		}		
		
		function EliminarMenu_Categoria(id_categoria){
	
var parametros = "funcion=10&id_categoria="+id_categoria;
	//alert(parametros);

			if(!confirm("Seguro que desea Eliminar??")) { 
			return false;
			}else{
	
	 $.ajax({
		   url:'mod/Crear_Menu/cont_crea_menu.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data==1){
                 alert("Datos Eliminados");
				 cargatabla2();
				  }else{
		           alert("Error al Eliminar Datos");				  
				  }
		      }
		 
		  })	
		}
	}
	
	function reseteo(){
   $('#tabla_menu')[0].reset();
	/*$('#bottoncontrol').html('<br><input name="creardoc" type="button" onClick="cargardatos(0)" value="Crear" class="botonXX"/>');	*/
	}
	
	
	function reseteo3(){
   $('#tabla_menu')[0].reset();
	
	 var fun="mmenu_item";
	       var parametros = "funcion="+fun;
		   var selec = "selectItem";
		//  alert(parametros);
		
		$.ajax({
		  url:'mod/Crear_Menu/cont_crea_menu.php',
		  
		  data:parametros,
		  type:'POST',
			success:function(data){
			//alert(data);
                if(data==0){
				  alert("No se Encontraron Datos");
				 // $('#cmb_funcion').html(0);
				  // $("#cmb_funcion option[value=0]").attr("selected",true); 
				}else{
				$('#'+selec+'').html(data);
				//$( "input:submit,input:button,a,button", "#mapaConcept" ).button();
				cargatabla3();
				  }
		        }
		     })
	/*$('#boton_modificar_categoria').html('<br><input type="button" name="guarda_menu" id="guarda_menu" value="Guardar"  title="Guardar Categoria" onclick="guardar_menu_categoria()"/>');	
	$("input:submit,input:button", "#cuerpo_creaMenu" ).button();*/
	}
	
	
	function carga_categoria(id_menu){
		
		var fun="selectCat";
	var parametros = "funcion="+fun+"&id_menu="+id_menu;
	 var selec = "select_Categoria_Item";				  
		//alert(parametros);
		
	$.ajax({
		  url:'mod/Crear_Menu/cont_crea_menu.php',
		  
		  data:parametros,
		  type:'POST',
			success:function(data){
			//alert(data);
                if(data==0){
				  alert("No se Encontraron Datos");
				 // $('#cmb_funcion').html(0);
				  // $("#cmb_funcion option[value=0]").attr("selected",true); 
				}else{
				$('#'+selec+'').html(data);
				//$( "input:submit,input:button,a,button", "#mapaConcept" ).button();
				//cargatabla3();
				  }
		        }
		     })	
         }
		 
		 
		 function guardar_menu_item(){
			 
		if($('#selectMenuItem').val()==0){
			alert("Seleccione Menu");
			$('#selectMenuItem').focus();
			return false;
		  }
		  
		  if($('#selectCategoria').val()==0){
			alert("Seleccione Categoria");
			$('#selectCategoria').focus();
			return false;
		  }
		  
		  if($('#txtITEM').val()==""){
			alert("Escriba Nombre Item");
			$('#txtITEM').focus();
			return false;
		  }
		  
		   if($('#cmbNIVEL_ITEM').val()==0){
			alert("Sleccione Nivel");
			$('#cmbNIVEL_ITEM').focus();
			return false;
		  }
		  if($('#txtURLITEM').val()==""){
			alert("Escriba URL ");
			$('#txtURLITEM').focus();
			return false;
		  }
		   if($('#txtORDENITEM').val()==""){
			alert("Escriba Orden del Item");
			$('#txtORDENITEM').focus();
			return false;
		  }
		  
	if ($('#ck_ingresoI').is(':checked')){
		var ck_ingresoI=1;
	} else {
		var ck_ingresoI=0;
	}
	if ($('#ck_modificaI').is(':checked')){
		var ck_modificaI=1;
	} else {
		var ck_modificaI=0;
	}
	if ($('#ck_eliminaI').is(':checked')){
		var ck_eliminaI=1;
	} else {
		var ck_eliminaI=0;
	}
	if ($('#ck_verI').is(':checked')){
		var ck_verI=1;
	} else {
		var ck_verI=0;
	}
		
		
	var parametros = "funcion=11&id_Menu="+$("#selectMenuItem").val()+"&categoria="+$("#selectCategoria").val()+"&nombre_item="+$("#txtITEM").val()+"&nivel="+$("#cmbNIVEL_ITEM").val()+"&url_item="+$("#txtURLITEM").val()+"&orden_Item="+$("#txtORDENITEM").val()+"&ck_ingresoI="+ck_ingresoI+"&ck_modificaI="+ck_modificaI+"&ck_eliminaI="+ck_eliminaI+"&ck_verI="+ck_verI;
	//alert(parametros);
	
		 $.ajax({
		   url:'mod/Crear_Menu/cont_crea_menu.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data==1){
                   alert("Datos Guardados");
				   cargatabla3();
				   $("#selectMenuItem option[value=0]").attr("selected",true);
				   $("#selectCategoria option[value=0]").attr("selected",true);
				   
				   $("#txtITEM").val("")
				   $("#txtURLITEM").val("");
				   $("#cmbNIVEL_ITEM option[value=0]").attr("selected",true);
				   $("#txtORDENITEM").val("");
				   
				   
				   $("#ck_ingresoI").attr('checked', false);
				   $("#ck_modificaI").attr('checked', false);
				   $("#ck_eliminaI").attr('checked', false);
				   $("#ck_verI").attr('checked', false);
				   
		//$('#boton_modificar_Item').html('<br><input name="guarda_menu_item" id="guarda_menu_item" type="button" onClick="guardar_menu_item()" value="Guardar" />');
				  //$("input:submit,input:button", "#cuerpo_creaMenu" ).button();		   
				   
				  }else{
		           alert("Error al Guardar Datos");				  
				  }
		      }
		  })	
       }
		 
	
	function cargatabla3(){
	var parametros = "funcion=12";
	//alert(parametros);
		$.ajax({
		  url:'mod/Crear_Menu/cont_crea_menu.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#carga_item').html(data);
					/*	$("#flex2").flexigrid({
								width : 700,
								height : 280
						});*/
						
							$("input:submit,input:button", "#Item" ).button();
						}
				     }
		         })
	          } // fin funcion cargartabla		  
			  
			  
			  
		function Busca_Menu_item(id_item){
	
	//	alert(id_item);
	
	
var parametros = "funcion=13&id_item="+id_item;
	//alert(parametros);
	
	 $.ajax({
		   url:'mod/Crear_Menu/cont_crea_menu.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data!=0){
                  // alert("Datos Encontrados");
				    $('#respuestabuscamenu_item').html(data);	
						var _menu_categoriaI = $('#_menu_categoriaI').val();
						var _nivelI=$('#_nivelI').val();
						//var _id_categoria=$('#_menu_categoria').val();
						$("#selectMenuItem option[value="+_menu_categoriaI+"]").attr("selected",true);
						$("#selectCategoria option[value="+_nivelI+"]").attr("selected",true);
						carga_categoria(_menu_categoriaI);
						$("#cmbNIVEL_ITEM option[value="+_nivelI+"]").attr("selected",true);
						
						
						$('#txtITEM').val($('#_categoriaI').val());
						$('#txtURLITEM').val($('#_urlI').val());
						$('#txtORDENITEM').val($('#_id_categoriaI').val());
						$('#txtORDENITEM').val($('#_id_categoriaI').val());
						
						
						//_nombre_categoriaI
						
						if($('#_ck_ingresoI').val()==1){
							$('#ck_ingresoI').attr('checked', true);	
							}
							if($('#_ck_modificaI').val()==1){
							$('#ck_modificaI').attr('checked', true);	
							}
							if($('#_ck_eliminaI').val()==1){
							$('#ck_eliminaI').attr('checked', true);	
							}
							if($('#_ck_verI').val()==1){
							$('#ck_verI').attr('checked', true);	
							}
												
						$('#txtCATEGORIA').focus();
$('#boton_modificar_item').html('<br><input name="Modificar" type="button" onClick="modifica_menu_categoria()" value="Modificar" />');
				  $("input:submit,input:button", "#cuerpo_creaMenu" ).button();
				  }else{
		           alert("Error al Cargar Datos");				  
				  }
		      }
		  })	
	}	  
	
	
	function EliminarMenu_item(id_item){
	
var parametros = "funcion=14&id_item="+id_item;
	//alert(parametros);

			if(!confirm("Seguro que desea Eliminar??")) { 
			return false;
			}else{
	
	 $.ajax({
		   url:'mod/Crear_Menu/cont_crea_menu.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data==1){
                 alert("Datos Eliminados");
				 cargatabla3();
				  }else{
		           alert("Error al Eliminar Datos");				  
				  }
		      }
		 
		  })	
		}
	}
	
			  
</script>

<style type="text/css">
.color_fondo{ background-image:url(jquery-ui-1.8.17.custom/css/redmond/images/ui-bg_gloss-wave_55_5c9ccc_500x100.png); }
#cuerpo_creaMenu{ margin:10px; }
#crea_menu{ margin-top:15px; margin-bottom:15px; }
.box{
background: #fff;
vertical-align:top;
background-position:top;
margin-top:15px;
}
</style>
</head>
<body>
  <div id="cuerpo_creaMenu">	
  <div id="tabs-1">
        <h3>CREACION DE MENU</h3>
        </div>
  <div id="crea_menu">
        <ul>
            <li><a href="#menu"  onclick="reseteo()">MENU</a></li>
            <li><a href="#categoria" onclick="reseteo2()">CATEGORIA</a></li>
            <li><a href="#Item" onclick="reseteo3()">ITEM</a></li>
        </ul>
        
        <form id="tabla_menu" >
        <div  id="menu" class="box">
<table width="650" border="0" align="center" cellpadding="3" cellspacing="0">
<tr>
<td><div align="left">Nombre Men&uacute; &nbsp;&nbsp;</div></td>
<td><div align="left">
<input name="txtMENU" type="text" id="txtMENU" size="30"  maxlength="50"/>
</div></td>
<td><div align="left">&nbsp; URL </div></td>
<td><input type="text" name="txtURLMENU" id="txtURLMENU"  size="30"/></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td><div align="left">Nivel </div></td>
<td><select name="cmbNIVEL" id="cmbNIVEL">
<option value="0">Selecccionar</option>
<option value="1">Admin</option>
<option value="2">Cliente</option>
</select></td>
<td>Orden</td>
<td><input name="txtORDENMENU" type="text" id="txtORDENMENU" size="5" maxlength="2" /></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td><div align="left">Permisos</div></td>
<td><input name="ck_ingreso" type="checkbox" id="ck_ingreso"  value="1"/>
I 
<input name="ck_modifica" type="checkbox" id="ck_modifica" value="1"  />
M 
<input name="ck_elimina" type="checkbox" id="ck_elimina" value="1"/>
E 
<input name="ck_ver" type="checkbox" id="ck_ver" value="1"/>
V</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>
<br />
<div id="boton_modificar" style="margin-left:16%;">
<input type="button" name="guarda_menu" id="guarda_menu" value="Guardar"  title="Guardar Menu" onclick="guardar_menu()"/> </div>
<br><br>
<div id="table_items" align="center"></div>
<div id="respuestabuscamenu" align="center"></div>
</div>

<div id="categoria" class="box">
    <table width="800" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr>
    <td>Men&uacute;&nbsp;</td>
    <td><div id="select_categoria">
      <label>Seleccionar Curso:</label>
    </div></td>
    <td>&nbsp;</td>
    <td>Nombre</td>
    <td><input type="text" name="txtCATEGORIA"  id="txtCATEGORIA" maxlength="50"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td>Nivel</td>
    <td><select name="cmbNIVELCAT" id="cmbNIVELCAT">
    <option value="0">Seleccionar</option>
    <option value="1">Admin</option>
    <option value="2">Cliente</option>
    </select></td>
    <td>&nbsp;</td>
    <td>URL </td>
    <td><input name="txtURLCATEGORIA" type="text" id="txtURLCATEGORIA"  size="30"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;</td>
    <td>&nbsp;</td>
    <td>Orden&nbsp;</td>
    <td><input name="txtORDENCATEGORIA" type="text" id="txtORDENCATEGORIA" size="5" maxlength="2" />&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <br>
    <td><div align="left">Permisos</div></td>
    <td><input name="ck_ingresoC" type="checkbox" id="ck_ingresoC" value="1" />
    I
    <input name="ck_modificaC" type="checkbox" id="ck_modificaC" value="1" />
    M
    <input name="ck_eliminaC" type="checkbox" id="ck_eliminaC" value="1" />
    E
    <input name="ck_verC" type="checkbox" id="ck_verC" value="1" />
    V</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    </table>
    <br />
<div id="boton_modificar_categoria" style="margin-left:16%;">
<input type="button" name="guarda_menu" id="guarda_menu" value="Guardar"  title="Guardar Categoria" onclick="guardar_menu_categoria()"/></div>
<br><br>
<div id="carga_categoria" align="center">
</div>
<div id="respuestabuscamenu_categoria" align="center"></div>
</div>

<div id="Item">

<table width="800" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr>
    <td>Men&uacute;&nbsp;</td>
    <td>
   <div id="selectItem">
   <label>Seleccione:</label>
   </div>
    </td>
    <td>&nbsp;</td>
    <td>Categoria&nbsp;</td>
    <td>
    <div id="select_Categoria_Item">
    <select name="cmbCat" id="cmbCat">
    <option value="0">Seleccionar:</option>
    </select>
    </div>
   </td>
    <td>&nbsp;</td>
    <td>Nombre Item &nbsp;</td>
    <td><input type="text" name="txtITEM"  id="txtITEM" maxlength="50"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td>URL</td>
    <td><input name="txtURLITEM" type="text" id="txtURLITEM" size="30"/></td>
    <td>&nbsp;</td>
    <td>Nivel</td>
    <td><select name="cmbNIVEL_ITEM" id="cmbNIVEL_ITEM">
    <option value="0">Seleccionar</option>
    <option value="1">Admin</option>
    <option value="2">Cliente</option>
    </select></td>
    <td>&nbsp;</td>
    <td>Orden</td>
    <td><input name="txtORDENITEM" type="text" id="txtORDENITEM" size="5" maxlength="2" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td><div align="left">Permisos</div></td>
    <td><input name="ck_ingresoI" type="checkbox" id="ck_ingresoI" value="1" checked="checked" />
    I
    <input name="ck_modificaI" type="checkbox" id="ck_modificaI" value="1" checked="checked" />
    M
    <input name="ck_eliminaI" type="checkbox" id="ck_eliminaI" value="1" checked="checked" />
    E
    <input name="ck_verI" type="checkbox" id="ck_verI" value="1" checked="checked" />
    V</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    </table>
    <br>
    
    <div id="boton_modificar_Item" style="margin-left:7%;">
<input type="button" name="guarda_menu_item" id="guarda_menu_item" value="Guardar"  title="Guardar Item Menu" onclick="guardar_menu_item()"/></div>
<br><br>
<div id="carga_item"></div>
<br />
<div id="respuestabuscamenu_item" align="center"></div>


</div>
 </form>
  </div>
  
  
 
 </div> 
 
 
</body>
</html>