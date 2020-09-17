<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');

$_POSP = 4;
$_bot = 8;

//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$periodo		=$c_periodos;
	$reporte		=$c_reporte;
	
?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
function enviapag(form){
	if (form.c_curso.value!=0){
		form.c_curso.target="self";
		form.target="_parent";
		form.action = 'InformeNotasExamen_C.php';
		form.submit(true);
	}	
}

$( document ).ready(function() {
    cambioano();
});


function cambioano(){
carga();
var ano = $("#cmb_ano").val();
var funcion=5;
var parametros = "ano="+ano+"&funcion="+funcion;

$.ajax({
	  url:'../curso/informe_apoderado/mod/lista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
			if(data!=0){
				$("#filap").html(data);
				}else{
				alert("Error al cargar");	
				
				}
		
	   }
	})
}


function carga(){
	var plantilla =$("#cmbPlantilla").val();
	$("#cc1").remove();
	$("#cc2").remove();	
	if(plantilla !=0){
		if(plantilla==1){
			traeApoderado();
		}
		else if(plantilla==2){
			traeCurso();
		}
		else if(plantilla==3){
			traeEntrevistador();
		}
		
	}
	
	
	
}

function traeApoderado(){
	$("#cc1").remove();
	$("#cc2").remove();	
	var ano = $("#cmb_ano").val();
	var funcion=1;
	var parametros = "ano="+ano+"&funcion="+funcion;
	$.ajax({
	  url:'../curso/informe_apoderado/mod/lista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
			if(data!=0){
				$("#cc1").remove();
				$("#cc2").remove();	
				$("#cmb").append(data);
				}else{
				alert("Error al cargar");	
				
				}
		
	   }
	})
}

function cargaApo(){
	
var ano = $("#cmb_ano").val();
var funcion=10;
var curso = $("#c_curso").val();
var parametros = "ano="+ano+"&funcion="+funcion+"&curso="+curso;
$.ajax({
	  url:'../curso/informe_apoderado/mod/lista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
			if(data!=0){	
				$("#cmb").append(data);
				}else{
				alert("Error al cargar");	
				
				}
		
	   }
	})
}



function traeCurso(){
	$("#cc1").remove();
	$("#cc2").remove();	
	var ano = $("#cmb_ano").val();
	var funcion=2;
	var parametros = "ano="+ano+"&funcion="+funcion;
	$.ajax({
	  url:'../curso/informe_apoderado/mod/lista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
			if(data!=0){
				$("#cc1").remove();	
				$("#cc2").remove();
				$("#cmb").append(data);
				}else{
				alert("Error al cargar");	
				
				}
	   }
	})
}

function cargaAlu(){
var ano = $("#cmb_ano").val();
var funcion=11;
var curso = $("#c_curso").val();
var parametros = "ano="+ano+"&funcion="+funcion+"&curso="+curso;
$.ajax({
	  url:'../curso/informe_apoderado/mod/lista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
			if(data!=0){	
				$("#cmb").append(data);
				}else{
				alert("Error al cargar");	
				
				}
		
	   }
	})
}




function traeEntrevistador(){
	$("#cc1").remove();
	$("#cc2").remove();	
	$("#contenido").html('');
	var ano = $("#cmb_ano").val();
	var funcion=9;
	var parametros = "ano="+ano+"&funcion="+funcion;
	$.ajax({
	  url:'../curso/informe_apoderado/mod/lista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		if(data!=0){
				$("#cmb").append(data);
				cargaPlantillaEmp();
				}else{
				alert("Error al cargar");	
				
				}
		
	   }
	})
}


function cargaPlantillaApo(){
var plantilla =$("#cmbPlantilla").val();
var funcion=7;
var curso = $("#c_curso").val();
var tipo =$("#cmbPlantilla").val();
	if(plantilla !=0){
		var parametros = "plantilla="+plantilla+"&funcion="+funcion+"&curso="+curso+"&tipo="+tipo;
		
		//alert(parametros);
		$.ajax({
	  url:'../curso/informe_apoderado/mod/lista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		if(data!=0){
//console.log(data);
$("#cc2").remove();
			$("#cmb").append(data);
				}else{
					alert("Sin plantillas asociadas");	
					$("#cc2").remove();
				
			$("#cmb").append(data);
				
				}
		
	   }
	})
		
	}
}

function cargaPlantillaEmp(){
var plantilla =$("#cmbPlantilla").val();
var funcion=8;
//var curso = $("#c_curso").val();
var tipo =$("#cmbPlantilla").val();

var parametros = "plantilla="+plantilla+"&funcion="+funcion+"&tipo="+tipo;
//alert(parametros);
		$.ajax({
	  url:'../curso/informe_apoderado/mod/lista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		if(data!=0){
//console.log(data);
//$("#cc2").remove();
			$("#cmb").append(data);
				}else{
					alert("Sin plantillas asociadas");	
					$("#cc2").remove();
				
				$("#cmb").append(data);
				
				}
		
	   }
	})

}


	
		
				
</script>
<SCRIPT language="JavaScript">
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
									
</script>
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
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><center>

<br>
</center>

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form method="post" action="printInformeEvaluacionApoderado.php" name="form" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<? 

$ob_motor = new MotorBusqueda();
$ob_motor ->ano =$ano;
$ob_motor ->perfil=$_PERFIL;
$ob_motor ->curso=$_CURSO;
$ob_motor ->usuario=$_NOMBREUSUARIO;
$ob_motor ->rdb=$institucion;
$result_curso = $ob_motor ->curso2($conn);

$result_peri = $ob_motor ->periodo($conn);

//------------------
?>
<center>
<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27">
	<table width="650" border="0" cellspacing="0" cellpadding="5" id="cmb" align="center" >
  <tr>
    <td width="97" class="textosimple">&nbsp;</td>
    <td width="4">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td class="textosimple"><font face="arial, geneva, helvetica" size=2> <strong>A&ntilde;o</strong></font></td>
    <td width="4">&nbsp;</td>
    <td><?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion."  $whe_perfil_ano ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					} ?>
                                                                                     <select name="cmb_ano" class="ddlb_x" id="cmb_ano" onChange="cambioano()" >
                                                <option value=0 selected>(Seleccione un A&ntilde;o)</option>
                                                <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
							  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							} ?>
                                              </select>
                                           
                                            <? }	?></td>
    </tr>
  
  <tr  >
    <td class="textosimple"><font face="arial, geneva, helvetica" size=2> <strong>Tipo Entrevista</strong></font></td>
    <td width="4">&nbsp;</td>
    <td width="832"><select name="cmbPlantilla" id="cmbPlantilla" onChange="carga()">
      <option value="0" >Seleccione Tipo de Plantilla</option>
      <option value="1" >Apoderado</option>
      <option value="2" >Alumno</option>
      <option value="3" >Entrevistador</option>
      
    </select></td>
    </tr>
 
 
</table><br>
<br>
<table>
 <tr>
    <td class="textosimple">&nbsp;</td>
    <td><div align="right">
      <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar">
      <? if($_PERFIL==0){?>		  
      <input name="cb_exp" type="submit" class="botonXX"  id="cb_exp" value="Exportar">
      <? }?>
      <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
    </div></td>
    </tr>
    </table>
	</td>
  </tr>
</table>	</td>
  </tr>
</table>
</center>
</form>
								 
<!-- FIN FORMULARIO DE BUSQUEDA -->								  </td>
                                </tr>
                              </table></td>
                          </tr>
                         
                         
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>