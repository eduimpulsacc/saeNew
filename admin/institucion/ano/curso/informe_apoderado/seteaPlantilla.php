<?php require('../../../../../util/header.inc');?>

<?php 
	if ($ano){
		$_ANO=$ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
	  	};
	}
	if ($curso){
		$_CURSO=$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
	  	};
	}
	
	if ($periodo){
		$_PERIODO=$periodo;
		if(!session_is_registered('_PERIODO')){
			session_register('_PERIODO');
	  	};
	}

//echo $_MENU."--".$_CATEGORIA."---".$_ITEM;
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$periodo		=$_PERIODO;	
	$_POSP          = 5;
	
	$_bot           = 5;
	if (trim($_url)=="") $_url=0;
	//imprime_array($_SESSION);

?>


 <?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../index.php";
		 </script>

<? } ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar   </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
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

$( document ).ready(function() {
    cambioano();
});


function cambioano(){
carga();
var ano = $("#cmb_ano").val();
var funcion=5;
var parametros = "ano="+ano+"&funcion="+funcion;

$.ajax({
	  url:'mod/lista.php',
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
	var ano = $("#cmb_ano").val();
	var funcion=1;
	var parametros = "ano="+ano+"&funcion="+funcion;
	$.ajax({
	  url:'mod/lista.php',
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
var funcion=4;
var curso = $("#c_curso").val();
var parametros = "ano="+ano+"&funcion="+funcion+"&curso="+curso;
$.ajax({
	  url:'mod/lista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
			if(data!=0){	
				$("#contenido").html(data);
				}else{
				alert("Error al cargar");	
				
				}
		
	   }
	})
}



function traeCurso(){
	var ano = $("#cmb_ano").val();
	var funcion=2;
	var parametros = "ano="+ano+"&funcion="+funcion;
	$.ajax({
	  url:'mod/lista.php',
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
var funcion=6;
var curso = $("#c_curso").val();
var parametros = "ano="+ano+"&funcion="+funcion+"&curso="+curso;
$.ajax({
	  url:'mod/lista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
			if(data!=0){	
				$("#contenido").html(data);
				}else{
				alert("Error al cargar");	
				
				}
		
	   }
	})
}




function traeEntrevistador(){
	$("#cc1").remove();	
	$("#contenido").html('');
	var ano = $("#cmb_ano").val();
	var funcion=3;
	var parametros = "ano="+ano+"&funcion="+funcion;
	$.ajax({
	  url:'mod/lista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		if(data!=0){
				$("#contenido").html(data);
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
var periodo =$("#periodo").val();



	if(plantilla !=0){
		var parametros = "plantilla="+plantilla+"&funcion="+funcion+"&curso="+curso+"&tipo="+tipo+"&periodo="+periodo;
		
		//alert(parametros);
		$.ajax({
	  url:'mod/lista.php',
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
				
				$("#contenido").html('');
				
				}
		
	   }
	})
		
	}
}

function cargaPlantillaEmp(){
var plantilla =$("#cmbPlantilla").val();
var funcion=8;
var curso = $("#c_curso").val();
var tipo =$("#cmbPlantilla").val();

var parametros = "plantilla="+plantilla+"&funcion="+funcion+"&tipo="+tipo;
//alert(parametros);
		$.ajax({
	  url:'mod/lista.php',
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
				
				$("#contenido").html('');
				
				}
		
	   }
	})

}

function pp(){
	var periodo =$("#periodo").val();
$("#t_per").val(periodo);
}

function idp(){
	var planilla =$("#tip").val();
$("#t_plan").val(planilla);
}


function aEvaluar(rut){
	var periodo =$("#periodo").val();
	var planilla = $("#t_plan").val();
	var tipo = $("#cmbPlantilla").val();
	var cmb_ano = $("#cmb_ano").val();
	
	
	if(periodo!=0 && planilla!=0)
	{
	location.href='mod/evaluar.php?periodo='+periodo+'&rut='+rut+'&planilla='+planilla+"&tipo="+tipo+"&cmb_ano="+cmb_ano;}
	else{
	alert("Seleccione todos los campos");
	}
}



</script>
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>

	


</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> <td>
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			<?   //include("../../../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
					<?   include("../../../../../cabecera/menu_superior.php");?>
					</td></tr></table>
					
					</td>
                  
                  </tr>
               
					<!-- FIN DE COPIA DE CABECERA -->
                 
                </table></td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table><tr><td><? $menu_lateral="3_1";?><?
					  
						 include("../../../../../menus/menu_lateral.php");
						 
						 
						 ?>
						 
						 
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%">
                              <tr>
                                <td valign="top"><table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
                                  <TR height=15>
                                    <TD width="600"><table border=0 cellspacing=1 cellpadding=1 id="cmb">
                                      <tr>
                                        <td align=left><font face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> </font> </td>
                                        <td><font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
                                        <td><font face="arial, geneva, helvetica" size=2> <strong>
                                          <?php  
                                                                               
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													
													echo trim($fila['nombre_instit']);
												}
											}
										?>
                                        </strong> </font> </td>
                                      </tr>
                                      <tr>
                                        <td align=left><font face="arial, geneva, helvetica" size=2> <strong>A&Ntilde;O ESCOLAR</strong> </font> </td>
                                        <td><font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
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
                                           
                                            <? }	?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td align=left><font face="arial, geneva, helvetica" size=2><strong>PERIODO</strong></font></td>
                                        <td><font face="arial, geneva, helvetica" size=2><strong>:</strong></font></td>
                                        <td><div id="filap"></div></td>
                                      </tr>
                                      <tr>
                                        <td align=left><font face="arial, geneva, helvetica" size=2> <strong>TIPO PLANTILLA</strong></font></td>
                                        <td><font face="arial, geneva, helvetica" size=2> <strong>:</strong></font></td>
                                        <td><select name="cmbPlantilla" id="cmbPlantilla" onChange="carga()">
                                    <option value="0" >Seleccione Tipo de Plantilla</option>
                                     <option value="1" >Apoderado</option>
                                      <option value="2" >Alumno</option>
                                       <option value="3" >Entrevistador</option>
                                 
                                  </select></td>
                                      </tr>
                                      
                                    </table></TD>
                                  </TR>
								  
                                  <tr>
                                    <td>
                                    <form id="frm">
 <input name="t_per" type="hidden" id="t_per">                                   
 <input name="t_plan" type="hidden" id="t_plan">
<div id="contenido"></div>
</form>
                                    </td>
                                  </tr>
                                  
                                  
                                  
 
                                </table></td>
                              </tr></table>                         </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>