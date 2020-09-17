<?php require('../../../util/header.inc');?>
<?php 

	$_POSP = 3;
	$_bot = 3;
	
	$NOMBREUSUARIO=$_USUARIO;
	$institucion	=$_INSTIT;
    
	$largoPagina=40;
	$pagOffset=$largoPagina*($pag-1);
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
	
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
		
	}else{
	
		if($nw==1){
		
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
			
		}
		
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
		
	}



?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript">
</script>

<script type="text/javascript">
 
  $(document).ready(function() {
   $('#add').click(function() {
     return !$('#select1 option:selected').remove().appendTo('#select2');
    });
   $('#remove').click(function() {
    return !$('#select2 option:selected').remove().appendTo('#select1');
   });
  });

  
  function cargarempleados(){
  var tipo = $("#select_cargo").val();
  var parametros='tipo_cargo='+tipo;
  $.ajax({
	  url:'crearselect.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  	    $("#empleados").html(data);
		   }
        })
     }


  function completoselect2(){
  var hidden_id_notifica_correo_configuracion = $("#hidden_id_notifica_correo_configuracion").val();
  var parametros='id='+hidden_id_notifica_correo_configuracion;
  $.ajax({
	  url:'completoselect2.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  	    $("#empleados_seleccionados").html(data);
		   }
        })
     }
	 
  
  function buscoconfiguracionescreadas(valor){
  var p ='funcion=1&ense='+valor;
  $.ajax({
  	  url:'controlador.php',
	  data:p,
	  type:'POST',
	  success:function(data){
		  
		  if(data!=1){
			
			$('#Configuraciones_Existentes').html("");
			$('#Configuraciones_Existentes').html(data);
			alert("Existen Configuraciones para este Nivel de Enseñanza");	

			 }else{
				 
				 $('#Configuraciones_Existentes').html("");
				 $('#Configuraciones_Existentes').html('Configuraciones Existentes : <select  id="select5" onChange="buscoregistro(this.value)" ><option value="0" >Seleccionar Configuracion</option> </select> ');
				 
				 alert("Nueva Configuración");
				 
				 }
			
			}
		})
		
	 nuevo();
	  
	  }
  
  
 function configuraciones_activas(valor){
  var p ='funcion=3&ense='+valor;
  $.ajax({
  	  url:'controlador.php',
	  data:p,
	  type:'POST',
	  success:function(data){
			  $('#tabla_configuraciones').html("");	 
		  	  $('#tabla_configuraciones').html(data);		
			}
		})
	  }


 function buscoregistro(idconfig){
  
  var tipoensenanza = $('#tipoensenanza').val();
  var parametros='tipoensenanza='+tipoensenanza+'&idconfig='+idconfig;
  
  $.ajax({
  	  url:'busco_registros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  
	  if( data != 1 ){
	  
	  $('#tabla_configuraciones').html(data);	 
	  
	  var hidden_id_notifica_correo_configuracion =$("#hidden_id_notifica_correo_configuracion").val();
	  var hidden_rbd =$("#hidden_rbd").val();
	  var hidden_tipo_ensenanza =$("#hidden_tipo_ensenanza").val();
	  
	  if($("#hidden_cargo").val()!=""){
		  var valor_cargo = $("#hidden_cargo").val();
  	      $("#select_cargo option[value="+valor_cargo+"]").attr("selected",true);
	  }else{
	     $("#select_cargo option[value=0]").attr("selected",true);
	  }
		
		  cargarempleados(); //LLamo funcion para cargar empleados en el selecc 1;
		  completoselect2(); //LLamo Funcion para Cargar los Empleados Seleccionados en esta   
	  
	  //Configuracion
	  //$("#sexo option:selected").val() //tengo la opcion seleccionada;
	  //$("#sexo option:selected").text() // tengo el texto seleccionado;
	  //$("#sexo option[value=1]").attr("selected",true); // modifico el campo seleccionado;
	  
	  if($("#hidden_nombre_configuracion").val()!=""){
		  $('#nombre_configuracion').val($("#hidden_nombre_configuracion").val());
		  }
	  
	  if($("#hidden_notifica_notas").val()==1){
	  	  		$('#checkboxnotas').attr('checked',true);
				$('#cant_notas').val($("#hidden_nro_notas").val());
				$('#nota_def').val($("#hidden_nota_deficiente").val());
		  }else{  
		  	  	$('#checkboxnotas').attr('checked',false);
		  	    $('#cant_notas').attr('disabled',false);
		  	     } 
  	  if($("#hidden_notifica_anotaciones").val()==1){
	       	     $('#checkboxAnotaciones').attr('checked',true); 
		     }else{  
		     	$('#checkboxAnotaciones').attr('checked',false); 
		     	  } 
	  $('#cant_anot').val($("#hidden_nro_anotaciones").val());
	  if($("#hidden_notifica_asistencia").val()==1){
	         $('#checkboxAsistencia').attr('checked',true);
	 		 }else{  
	 		 	$('#checkboxAsistencia').attr('checked',false);
	 		     } 

	  $('#dias_not').val($("#hidden_dias_asistencia").val());
	  
	  if($("#hidden_periodo_notificacion").val()!= ""){
		  var valor_periodo = $("#hidden_periodo_notificacion").val();
	      $("#selec_periodo option[value="+valor_periodo+"]").attr("selected",true);
	   }else{	
	   	   $("#selec_periodo option[value=0]").attr("selected",true);	
	   	    }


	  }
			
		   }
		   
        })
		
     }


	function nuevo(){
		  var tipoensenanza = $('#tipoensenanza').val();
		  var p ='funcion=2&tipoensenanza='+tipoensenanza;
		  $.ajax({
		  url:'controlador.php',
		  data:p,
		  type:'POST',
		  success:function(data){
			  $('#tabla_configuraciones').html("");
			  $('#tabla_configuraciones').html(data);
			  } 
		   })
	   	//alert("Nueva Configuración");
		$("#nombre_configuracion").val("");
		$('#checkboxnotas').attr('checked',false);
		$('#checkboxnotas').attr('disabled',false);
		$('#cant_notas').val("");
		$('#nota_def').val("");
		$('#checkboxAnotaciones').attr('checked',false);
		$('#checkboxAnotaciones').attr('disabled',false); 
		$('#cant_anot').val("");
		$('#checkboxAsistencia').attr('checked',false);
		$('#checkboxAsistencia').attr('disabled',false); 
		$('#dias_not').val("");
		$("#select5 option[value=0]").attr("selected",true);
		
		$("#selec_periodo option[value=0]").attr("selected",true);
		$("#select_cargo option[value=0]").attr("selected",true);	
		
		$("#empleados_seleccionados").html("<select multiple id='select2' class='Estilomio4'></select>");
		$("#empleados").html("<select multiple id='select1' class='Estilomio4' ></select>");
		 
		 $("# hidden_id_notifica_correo_configuracion").val(0);
		 
		 $('#Configuraciones_Existentes').html("");
		 $('#Configuraciones_Existentes').html('Configuraciones Existentes : <select  id="select5" onChange="buscoregistro(this.value)" ><option value="0" >Seleccionar Configuracion</option> </select> ');
		 
	   }


			function NO_letra(e){
				key=(document.all) ? e.keyCode : e.which;
				if (key < 48 || key > 57){
					if (key !=9 && key !=8 && key !=0){
							return false;
					}
				}
				return true;
				// onKeyPress="return NO_letra(event)"
			}//fin funcion


		function guardar(){
		
		if( $('#tipoensenanza option:selected').val()==0 ) {
					alert("Seleccionar Tipo Enseñanza"); 
					return false;
			  }
		
		if($('#select_cargo option:selected').val()==0 ){ 
					alert("Seleccionar Cargo"); 
					return false; 
				}
		
		 
		var tipoensenanza = $('#tipoensenanza').val();
		var select_cargo  = $('#select_cargo').val();
		
		var selObj = document.getElementById('select2');
		 
		 var selectedArray = "";
		 var i;
		 var count = 0;
		
		 for (i=0; i<selObj.options.length; i++) {
			   var valor = selObj.options[i].value;
			   selectedArray += selObj.options[i].value+" ";
			   count++;
			 }
		
		if(count==0){
			alert("Error : Tiene Que Asignar almenos 1 Usuario");
			return false;	
			}

		
		var checkboxnotas="";
		var cant_notas="";
		var nota_def="";
		var checkboxAsistencia="";
		var dias_not="";
		var selec_periodo="";
		var checkboxAnotaciones="";
		var cant_anot="";
		
		
		if( $("#nombre_configuracion").val() == "" ){
			  alert("Indicar Nombre para esta Configuración");
			  return false;
			}
		
		  	
		if($('#checkboxnotas').val()==1){
		  
		  if (  $('#checkboxnotas').is(':checked')  ){ 	 
			
			if( ($('#checkboxnotas').val()!="") && ($('#cant_notas').val()!="") && ($('#nota_def').val()!="") ){
					 checkboxnotas = $('#checkboxnotas').val();
					 cant_notas = $('#cant_notas').val();
					 nota_def = $('#nota_def').val(); 
				}else{ 
				     alert("Falta Ingresar los Parametros en Notificación Notas"); 
					 return;
				   }
				   
				}
			
			}


			if($('#checkboxAsistencia').val()==1){

				if (  $('#checkboxAsistencia').is(':checked')  ){ 	 

					if(  ($('#checkboxAsistencia').val()!="") && ($('#dias_not').val()!="") && ($('#selec_periodo').val()!="")  ){
						   checkboxAsistencia = $('#checkboxAsistencia').val();
						   dias_not = $('#dias_not').val();
						   selec_periodo = $('#selec_periodo').val();
					}else{
					  alert("Falta Ingresar los Parametros en Notificación Asistencia"); 
					  return;    
					}

				 }
		      
			 }
		  
		  
		  if ( $('#checkboxAnotaciones').val() == 1) {

			  if ($('#checkboxAnotaciones').is(':checked')  ){ 	 

				 if( ($('#checkboxAnotaciones').val() != "" ) && ($('#cant_anot').val() != "") ){	
					checkboxAnotaciones = $('#checkboxAnotaciones').val();
					cant_anot = $('#cant_anot').val();
				  }else{
					alert("Falta Ingresar los Parametros en Notificación Anotaciones"); 
					return;  
				  }

			  }
		   
		   }
			  
		
		var parametros='ruts='+selectedArray+'&tipoensenanza='+tipoensenanza+'&select_cargo='+select_cargo+'&checkboxnotas='+checkboxnotas+'&cant_notas='+cant_notas+'&nota_def='+nota_def+'&checkboxAsistencia='+checkboxAsistencia+'&dias_not='+dias_not+'&selec_periodo='+selec_periodo+'&checkboxAnotaciones='+checkboxAnotaciones+'&cant_anot='+cant_anot+'&id_notifica_correo_configuracion='+$('#select5').val()+'&nombre_configuracion='+$("#nombre_configuracion").val(); 
		
		//alert(parametros);
		   
			$.ajax({
				url:'proceso_confi_not_correo.php',
				data:parametros,
				type:'POST',
				success:function(data){
				//alert(data);	
					if(data==0){ 
					  alert("Datos Guardados");
					  nuevo();
					  $("#tipoensenanza option[value=0]").attr("selected",true);
					}else{
					  alert("Datos Actualizados");
					  nuevo();
					  $("#tipoensenanza option[value=0]").attr("selected",true);
					}
				// $("#buscados_encontrados").html(data);
				  }
			   })
		   

		   
		   }	
   
   
 </script>
 
 
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
<style type="text/css">
<!--

.Estilomio2 {font-size: 12px}
.Estilomio3 {
	font-size: 14px
	border: 1px solid #aaa; font-family:"Courier New";	
	margin-top:20px; 
	}

.Estilomio4 {
   width: 230px;
   height: 180px;
   border: 1px solid #aaa;
  }
  
.Estilomio5 {
   float:left;
   text-align: center;
   margin: 10px;
   width: 120px;
   height: 10px;
  }

-->

.mioa {
   display: block;
   border: 1px solid #aaa;
   text-decoration: none;
   background-color: #fafafa;
   color: #123456; 
   margin:15px; 
   margin-top:5px;
   padding:10px;
   clear:both;
   width: 120px;
   height: 13px;
 }
  
.miodiv {
   float:left;
   text-align: center;
   margin: 10px;
 }
 
</style>
 
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../Sea/cortes/b_ayuda_r.jpg','../../../Sea/cortes/b_info_r.jpg','../../../Sea/cortes/b_mapa_r.jpg','../../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../cabecera/menu_superior.php") ;?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
<td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
<td width="27%" height="363" align="left" valign="top"> 
<?
	$menu_lateral=2;	
	include("../../../menus/menu_lateral.php"); ?></td>
<td width="73%" align="left" valign="top"><table width="90%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="">
<!--FORMULARIO DE CONFIGURACION-->

<div align="center" id="buscados_encontrados" ></div>

<table width="100%" height="455"  border="1" cellpadding="1" cellspacing="1" style="border-collapse:collapse;">
<tr>
<td height="39" colspan="6" class="tableindex" >Configuraci&oacute;n de Notificaciones por Correo </td>
</tr>
<tr  >
 <td height="41" colspan="3" class="tablatit2-1" >Tipo de Ense&ntilde;anza : </td>
 
 <td width="53%" colspan="2">
 <?	$sql="SELECT DISTINCT(te.nombre_tipo),te.cod_tipo FROM 
	tipo_ense_inst AS en INNER JOIN tipo_ensenanza AS te ON te.cod_tipo = en.cod_tipo
	WHERE en.rdb = ".$_INSTIT." ORDER BY 1 ASC"; 
	$rs_tiense = @pg_exec($conn,$sql); ?>
	<select name="tipoensenanza" id="tipoensenanza" onChange="buscoconfiguracionescreadas(this.value)">
	<option value='0' selected  >Seleccionar</option>
	<?
	for($i=0;$i<@pg_numrows($rs_tiense);$i++){
	$fila_tiense = @pg_fetch_array($rs_tiense,$i); ?>
	<option  value="<?=trim($fila_tiense['cod_tipo'])?>" ><?=$fila_tiense['nombre_tipo']?></option>;
	<? 	} ?>
	</select>   
	</td>
</tr>

<tr>
 <td height="43" colspan="3" class="tablatit2-1" >Cargo : </td>
 <td colspan="2">
 <? $sql="SELECT * FROM cargos s WHERE s.tipocargo = 1"; 
	$rs_cargos = @pg_exec($conn,$sql); ?>
 <select name="select_cargo" id="select_cargo" onChange="cargarempleados()">
   <option value="0" selected >Seleccionar</option>
 <? for($i=0;$i<@pg_numrows($rs_cargos);$i++){
	$fila_cargos = @pg_fetch_array($rs_cargos,$i); 
	echo '<option  value="'.$fila_cargos['id_cargo'].'">'.$fila_cargos['nombre_cargo'].'</option>';
	} ?>
 </select>
 </td>


</tr>

<tr>
 <td colspan="6" class="tablatit2-1" >Empleado : </td>
 </tr>
 
 <tr>
 	 
 <td  colspan="3"  height="294"  class="textosimple" style="padding-left:30px;" >
  
	  <span class="Estilomio3" >Empleados a Cargo</span>
	  
	  <div id="empleados" >
	   <select multiple id="select1" name="select1" class="Estilomio4">
	  </select>
	  </div>

	  <a href="#" id="add" class="mioa">add &gt;&gt;</a> 
   
   </td>
 
 <td colspan="3"  class="textosimple" style=" padding-left:30px;" >
  
  <span class="Estilomio3">Destinatarios de Correo </span>
	
		  <div  id="empleados_seleccionados" >
		  <select multiple id="select2" name="select2" class="Estilomio4">

		  </select>
		  </div>
  
  <a href="#" id="remove" class="mioa" >&lt;&lt; remove</a>  
  
  </td>
 </tr>
</table>

    <div style="margin:15px; padding:10px;" id="Configuraciones_Existentes" >
    Configuraciones Existentes : 
      <select  id="select5" onChange="buscoregistro(this.value)" >
    <option value="0" >Seleccionar Configuracion</option>
    </select> 
    </div>

    <div style="margin:15px; padding:10px;" id="Nombre_Configuracion" >
    Nombre Configuración : <input type="text"  
    name="nombre_configuracion" id="nombre_configuracion" value="" size="45" maxlength="45" >
    </div>

<br/>

<div id="tabla_configuraciones" >

<table width="100%" height="auto" border="1" cellpadding="1" cellspacing="1" style="border-collapse:collapse;">	  
<!--INICIO-->
<tr>
  <td width="25%" height="95" rowspan="2" bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;">
  Notificaci&oacute;n por Notas  </td>
  <td width="12%" rowspan="2" bgcolor="#FFFFCC" style="padding-left: 25px;"  >
  <input name="checkboxnotas" type="checkbox" id="checkboxnotas" value="1">
  </td>
  <td colspan="2" bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;"  >Cantidad de Notas : 
    <input name="cant_notas" type="text" id="cant_notas" 
	onpaste="return false" value="" size="4" maxlength="2" onKeyPress="return NO_letra(event)" >
	</td>
  <td width="20%" rowspan="2" bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;"  >&nbsp;</td>
</tr>
<tr>
  <td colspan="2" bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;"  >Nota Deficiente : 
    <input name="nota_def" type="text" id="nota_def" 
	onpaste="return false" value="" size="4" maxlength="2" onKeyPress="return NO_letra(event)" >
  </td>
  </tr>
<!--TERMINO-->

<!--INICIO-->
<tr>
  <td rowspan="2" height="95" class="textosimple" style="padding-left: 25px;" >
  Notificaci&oacute;n por Asistencia 
  </td>
  <td rowspan="2" style="padding-left: 25px;"  >
  <input name="checkboxAsistencia" type="checkbox"  id="checkboxAsistencia" value="1" >
  </td>
  <td style="padding-left: 25px;"  colspan="2" class="textosimple">Dias a Notificar : 
    <input name="dias_not" type="text" id="dias_not" 
	onpaste="return false" value="" size="4" maxlength="2" onKeyPress="return NO_letra(event)" >
	</td>
  <td rowspan="2" class="textosimple" style="padding-left: 25px;">&nbsp;</td>
</tr>
<tr>
  <td style="padding-left: 25px;"  colspan="2" class="textosimple">Periodo : 
    <select name="selec_periodo" id="selec_periodo">
      <option value="0" selected="selected" >Seleccionar</option>
      <option value="1">Semanal</option>
      <option value="2">Quinsenal</option>
      <option value="3">Mensual</option>
    </select>
  </td>
</tr>
<!--TERMINO-->
  
<!--INICIO --> 
<tr>
  <td height="95" bgcolor="#FFFFCC"  class="textosimple" style="padding-left: 25px;" >Notificaci&oacute;n por Anotaci&oacute;nes    </td>
  <td bgcolor="#FFFFCC" style="padding-left: 25px;"  ><input name="checkboxAnotaciones" type="checkbox" id="checkboxAnotaciones" value="1"></td>
  <td  colspan="2" bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;">Cantidad Anotaci&oacute;nes : 
    <input name="cant_anot" type="text" id="cant_anot" 
	onpaste="return false" value="" size="4" maxlength="2" onKeyPress="return NO_letra(event)" >
	</td>
  <td bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;">&nbsp;</td>
</tr>
<tr>
  <td height="39" colspan="6">&nbsp;</td>
  </tr>
<!--TERMINO-->
  
  
<tr class="tablatit2-1">
<td height="59" colspan="6" align="left">

<div  style=" text-align:center; padding-top:15px;">
        <input class="botonXX" type="button" value="Guardar" onClick="guardar()">
</div>

</td>
</tr>
<tr class="tablatit2-1">
  <td colspan="6">&nbsp;</td>
</tr>
</table>   

</div>
							  

<!--FIN FORMULARIO DE CONFIGURACION-->

						          </td>
                                       </tr>
                                     </table>
								  </td>
                                </tr>
                              </table>
                         </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
