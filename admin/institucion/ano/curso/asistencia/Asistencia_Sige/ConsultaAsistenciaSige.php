<?php require('../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 6;
	$cram = $_GET['mdi'];
	$_MDINAMICO = $cram;
	
	if ($_PERFIL == 1){
	   $_MDINAMICO = 1;
	}   
	
	


	$ano			=$_ANO;
	$empleado		=$_EMPLEADO;
	$sql_nro_ano="select nro_ano from ano_escolar where id_ano=$ano";
	$rs_nro_ano = pg_exec($conn,$sql_nro_ano);
	$nro_ano = pg_result($rs_nro_ano,0);
	
	
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
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=". 
		$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
	
?>

 <link rel="stylesheet" type="text/css" href="../../../../../clases/jqueryui/jquery-ui-1.8.6.custom.css">

<script type="text/javascript" src="../../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>

<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.widget.js"></script>

<script language="JavaScript" type="text/JavaScript">

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


 $(document).ready(function(){
 
 $("#cmb_curso option[value=0]").attr("selected",true);
 
 $("#cmb_mes option[value=0]").attr("selected",true);
 
 
 
 })



function cambia_mes(x)
 {
	if($('#cmb_mes').val()==0){
		alert("Seleccione Mes");
		return false;
		}
		
	if($('#cmb_curso').val()==0){
		alert("Seleccione Curso");
		 $("#cmb_mes option[value=0]").attr("selected",true);
		return false;
		}	
		
	var ano = "<?=$nro_ano?>";
	var funcion = 1;
	var id_curso = $('#cmb_curso').val();
	var parametros = "funcion="+funcion+"&ano="+ano+"&mes="+x+"&id_curso="+id_curso;
	//alert(parametros);	
  $.ajax({
		url:'tabla_calendario.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data)
			if(data==0){
				//alert("Error en la Eliminaci�n");
			}else{
				$('#carga_tabla').html(data);
				
			}
		}
	})
}

function comprueba_asistencia(x)
{
	//alert(x);	
	var mes = $('#cmb_mes').val();
	var funcion = 2;
	var nro_ano = "<?=$nro_ano?>";
	var curso = $('#cmb_curso').val();
	
	var parametros = "funcion="+funcion+"&dia="+x+"&mes="+mes+"&nro_ano="+nro_ano+"&curso="+curso;
	//alert(parametros);
	
	$.ajax({
		url:'tabla_calendario.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data)
			if(data==0){
				//alert("Error en la Eliminaci�n");
			}else{
				$('#div_codigo_sige').html(data);
				var mm = (mes<10)?"0"+mes:mes;
				var dd = (x<10)?"0"+x:x;
				$('#fcons').val(nro_ano+'-'+mm+'-'+dd);
				res_cod_sige();
				
				
			}
		}
	})
}




function res_cod_sige()
{
	
	//alert(x);	
	//var mes = $('#cmb_mes').val();
	var codigo_sige = $('#cod_sige').val();
	var id_asistencia_sige =$('#id_asistencia_sige').val()
	var rdb = "<?=$institucion?>";
	var fcons = $('#fcons').val();
	var id_curso = $('#cmb_curso').val();	
	var parametros = "codigo_sige="+codigo_sige+"&rdb="+rdb+"&fcons="+fcons+"&id_curso="+id_curso;
	<?php if($_PERFIL==0){ ?>
	//alert(parametros);
	<?php } ?>
	//alert(parametros);
	//console.log(parametros);
	 var $contenidoAjax = $('#loading').html('<p><img src="../../../../../clases/img_jquery/loading/loading3.gif" /></p>');
	 $contenidoAjax.show();
	$.ajax({
		url:'ReporteEnvioAsistenciaSige.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//alert(data)
			if(data!=0){
				
			if(data==1){
			alert('Asistencia Procesada Exitosamente'); 	
			}else if(data==2){
			alert('Asistencia Procesada con Observaciones');	
			}else if(data==3){
			alert('Asistencia Procesada con Errores');	
			}else if(data==4){
			alert('Asistencia aun no ha sido Procesada');	
			}else if(data==5){
			alert('Parametros No Corresponden');	
			}else if(data==6){
			alert('RDB NO Tiene Servicio Disponible');	
			}else if(data==7){
			alert('Convenio no tiene Asociado el RDB');	
			}else if(data==8){
			alert('Servicio NO Dsponible');	
			}else if(data==9){
			alert('Semilla de Operacion no Valida o ha Caducado. (Renovar Semilla)');	
			}else if(data==10){
			alert('Error Interno de Servicio');	
			}else{
				$('#tabla_d').html(data);
				
			$('#tabla_d').dialog({
                resizable: true,
  	            width:700,
				modal: true,
				show: "fold",
                hide: "scale",
				buttons: {
				Cerrar: function() {
				$( this ).dialog( "close" );
				}
				}
		   });
				
				
				actializa_estado(3,id_asistencia_sige);
				}
				
				actializa_estado(data,id_asistencia_sige);
				
				$contenidoAjax.hide();
				//$('#div_resul_sige').html(data);
				cambia_mes($('#cmb_mes').val());
			}else{
				
				
			}
		}
	})
}


function actializa_estado(x,y)
{

var funcion=3;

var parametros = "funcion="+funcion+"&codigo_sige="+x+"&id_asistencia_sige="+y;
	//alert(parametros);
	
	$.ajax({
		url:'tabla_calendario.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//console.log(data);
			//alert(data)
			if(data==1){
				alert("Codigo Actualizado");
			}else{
				//$('#div_codigo_sige').html(data);
				alert("Codigo Actualizado");
				//alert("Error en al Guardar");
				
			}
		}
	})
	
}

function limpiames(){
  $("#cmb_mes option[value=0]").attr("selected",true);
	$('#carga_tabla').empty();
	
}
</script>

<style type="text/css">

input[type="text"] {
border: none;
background: transparent;
color:#333333;
cursor:pointer;
}

</style>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html >
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--link href="../../../estilos.css" rel="stylesheet" type="text/css"-->
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100%" align="left" valign="top">
	   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../../../../cabecera/menu_superior.php");
			   ?>
              </td>
         </tr>
         <tr align="left" valign="top"> 
            <td height="83" colspan="3">
				   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../../../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             
										
						
								  
							 <table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td valign="top">
					            	
								   <!-- AQUI VA TODA LA PROGRAMACI�N  -->
	<br><br>				
    <FORM method=post name="frm" action="">
    
    <TABLE WIDTH=100% BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
    <td>
    <table width="90%" border="1" align="center" style="border-collapse:collapse">
    <tr class="tableindex">
    <td>ASISTENCIA SIGE</td>
    </tr>
    </table>
    <br>
   <div align="right" style="margin-right:50px"> <input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="asistencia_sige.php"></div>
    <br>
    <table width="90%" align="center">
    <tr>
    <td>
    <? // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS // 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = @pg_exec($conn,$sql_curso); ?>
				 
<select name="cmb_curso" id="cmb_curso" class="ddlb_x" onChange="limpiames();">
<option value=0 selected>(Seleccione un Curso)</option><?
  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){  
	$filan = @pg_fetch_array($resultado_query_cue,$i); 
   		        				$Curso_pal = CursoPalabra($filan['id_curso'], 1, $conn);
	if (($filan['id_curso'] == $cmb_curso) or ($filan['id_curso'] == $curso)){
	echo "<option value=".$filan['id_curso']." selected>".$Curso_pal."</option>";
		        				}else{	    
	echo "<option value=".$filan['id_curso'].">".$Curso_pal."</option>";
     }
   } ?>
</select>
    </td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    </tr>
    <tr><td>
    <select name="cmb_mes" id="cmb_mes" onChange="cambia_mes(this.value)">
    <option value="0">seleccione</option>
    <option value="1">ENERO</option>
    <option value="2">FEBRERO</option>
    <option value="3">MARZO</option>
    <option value="4">ABRIL</option>
    <option value="5">MAYO</option>
    <option value="6">JUNIO</option>
    <option value="7">JULIO</option>
    <option value="8">AGOSTO</option>
    <option value="9">SEPTIEMBRE</option>
    <option value="10">OCTUBRE</option>
    <option value="11">NOVIEMRE</option>
    <option value="12">DICIEMBRE</option>
    </select>
    <td>
    </tr>
    </table>
    <br>
    <div id="carga_tabla"></div>
    <div id="div_codigo_sige"></div>
    <div id="div_resul_sige"></div>
    <div id="loading" style="margin-left:50%"></div>
    <div id="tabla_d" title="MENSAJES DE SIGE"></div>
    <input type="hidden" id="fcons">
    </td>
    </TR>			
    </TABLE> 
    </FORM>	
									
									
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
																	
															
								  </td>
							    </tr>
							 </table>							  
							</td>  
						  </tr>
                      </table>
					 </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
		    </td>
         </tr>
       </table>
    </td>

  </tr>
</table>

</td>
    <td width="53" align="left" valign="top" height="100%" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table> 
<?
pg_close($conn);
?>
</body>
</html>
