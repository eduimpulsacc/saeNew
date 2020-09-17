<?
require('../../../../../../util/header.inc');
include('../../../../../clases/class_MotorBusqueda.php');


$institucion	= $_INSTIT;
$ano			= $_ANO;
$reporte		= $c_reporte;
$_POSP 			= 6;
$_bot 			= 8;

$ob_motor = new MotorBusqueda();
$ob_motor->rdb = $institucion;


$ob_motor ->ano =$ano;
$resultado_query_cue = $ob_motor ->curso($conn);

$rs_periodo = $ob_motor->periodo($conn);
?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../../clases/jquery-ui-1.9.2.custom/js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="../../../../../clases/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script>
<?php if($_PERFIL!=0){ ?>
 <link rel="stylesheet" type="text/css" href="../../../../../clases/jquery-ui-1.9.2.custom/css/smoothness/jquery-ui-1.9.2.custom.css">
 <?php }?>
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->


</script>
<script>



function enviapag(){
	var curso=$("#cmb_curso").val();
	var parametros = "funcion=1&id_curso="+curso;

	$.ajax({
		url:'cont_bitacora.php',
		data:parametros,
		type:'POST',
		success: function(data){
			$("#asi").html(data);
		}
	
})
}
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			  <?
			  include("../../../../../../cabecera/menu_superior.php");
			  ?>
			  
                        <!-- FIN DE COPIA DE CABECERA -->
                    
					
					</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <!-- AQUI VA EL MEN{U LATERAL -->
						 <?
						 $menu_lateral=3;
						 include("../../../../../../menus/menu_lateral.php");
						 ?>
						 
						 <!--  FIN MENU LATERAL -->
						
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  
								     <!-- COPIO LOS BOTONES PARA QUE NO ESTÉN SEPARADOS -->
								     <table width="" height="0" border="0" cellpadding="0" cellspacing="0">
                                      <tr> 
                                        <td width="" height="0" align="center" valign="top"></td></tr> 
                                    </table>
<form method ="post" action="printbitacoraAsignatura.php
"  name="form"  id="form" target="_blank" >
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
                                
<center>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="">
	<table width="100%" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="cuadro01">
	<tr>
	  <td class="cuadro01"><br>
	    Curso
	    <br></td>
	  <td class="cuadro01"><select name="cmb_curso" id="cmb_curso" class="ddlb_9_x" onChange="enviapag()" >
	    <option value=0 selected>(Seleccione Curso)</option>
	    <?
		  
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if ($fila["id_curso"]==$cmb_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
	    </select></td>
	  <td class="cuadro01">&nbsp;</td>
	  </tr>
	<tr>
	  <td class="cuadro01">Asignatura</td>
	  <td class="cuadro01"><div id="asi"><select name="cmbAsignatura" id="cmbAsignatura">
    	<option value="0">(Seleccione Asignatura)</option></select></div></td>
	  <td class="cuadro01">&nbsp;</td>
	  </tr>
	<tr>
	  <td class="cuadro01">Periodo</td>
	  <td class="cuadro01"><select name="cmb_periodo" id="cmb_periodo">
      <option value="0">(Seleccione Periodo)</option>
      
     <?php  for($p=0;$p<pg_numrows($rs_periodo);$p++){
		 $fila_periodo = pg_fetch_array($rs_periodo,$p);
		 ?>
      <option value="<?php echo $fila_periodo['id_periodo'] ?>"><?php echo $fila_periodo['nombre_periodo'] ?></option>
     <?php  }?>
	  
        </select></td>
	  <td class="cuadro01">&nbsp;</td>
	  </tr>
	<tr>
	  <td colspan="2" class="cuadro01"><input name="aluP" type="checkbox" id="aluP" value="1">
	    Listado de alumnos Participantes</td>
	  <td class="cuadro01">&nbsp;</td>
	  </tr>
	<tr>
	  <td class="cuadro01">&nbsp;</td>
	  <td class="cuadro01">&nbsp;</td>
	  <td class="cuadro01">&nbsp;</td>
	  </tr>
	<tr>
	  <td colspan="3" class="cuadro01">&nbsp;</td>
	  </tr>
	<tr>
	  <td width="107" class="textosmediano">&nbsp;</td>
	  <td width="107" class="textosmediano">&nbsp;</td>
	  <td width="592"><input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar">
	    <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver"onClick="window.location='../../Menu_Reportes_new2.php'"></td>
	  </tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>                        
		  <!-- FIN DEL CONTENIDO DEL MOTOR DE BUSQUEDA -->								  
								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>