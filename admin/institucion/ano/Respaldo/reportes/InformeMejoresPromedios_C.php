<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$tipo_ensenanza	=$tipo_ensenanza;
	$reporte		= $c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
<!--
function enviapag2(form){
        if( document.form.tipo_ensenanza.value!=0){
                form.target="_blank";
				var ensenanza= document.form.tipo_ensenanza.value;
				document.form.action='printInformeMejoresPromedios_C.php?tipo_ensenanza'+ensenanza;
                document.form.submit(true);
       }else{
	   alert("Debe Seleccionar Tipo de Enseñanza.");
	   }
}
/*function enviapag(form){
	if(document.form.tipo_ensenanza.value !=0){
		document.form.action='printInformeMejoresPromedios_C.php';
		document.form.submit(true);
		}else{
		alert("Debe Seleccionar Tipo De Enseñanza.")
		}
}
*/

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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
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
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->


  <center>
  
<form name="form" action="printInformeMejoresPromedios_C.php"  target="_blank" method="post">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<? 
	$ob_motor = new MotorBusqueda();
	$ob_motor ->ano =$ano;
	$resultado_query_cue = $ob_motor ->curso($conn);
	
?>
<table width="709" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%">
	  <table width="100%" height="43" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701"  class="tableindex">Buscador Avanzado</td>
  </tr>
  <tr>
    <td height="27">
	<table width="701" border="0" cellspacing="0" cellpadding="0">
  <tr class="cuadro01">
    <td width="151">Tipo de Ense&ntilde;anza </td>
    <td width="415">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="tipo_ensenanza" class="ddlb_x">
		  <option value=0 selected>Seleccione tipo de enseñanza</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
					 $fila    = @pg_fetch_array($resultado_query_cue,$i);
					 $filanex = @pg_fetch_array($resultado_query_cue,$i+1); 
					 $tipo_ensenanza = $fila['ensenanza'];
					 $tipo_ensenanzanex = $filanex['ensenanza'];
				  
				     if ($tipo_ensenanza > 309){
				  
						 if ($tipo_ensenanza==$tipo_ensenanzanex){
							// no muestro aun el promedio
							// y sigo acumulando
						 }else{
							// muestro el promedio y luego limpio las variables
							// busco el nombre de tipo de ensenanza
							$sql_te = "select * from tipo_ensenanza where cod_tipo = '$tipo_ensenanza'";
							$res_te = @pg_Exec($conn,$sql_te);
							$fila_te = pg_fetch_array($res_te,0);
							$nombre_tipo_ensenanza = $fila_te['nombre_tipo'];
							if ($tipo_ensenanza > 300){
								?>
								<option value="<?=$tipo_ensenanza ?>" <? if ($tipo_triplexxx==$tipo_ensenanza){ ?> selected="selected" <? } ?> ><?=$nombre_tipo_ensenanza ?> - <?=$tipo_ensenanza ?></option>
								<?
							} 	
						 }
					 }	 
				  }	
		  ?>
        </select>
	    </font>	  </div></td>
   
    <td width="135">
      <div align="center">
        <input name="cb_ok" class="botonXX"  type= "submit"  value="Buscar" >
        </div></td>
	<? if($_PERFIL==0){?>
    <td width="135"><div align="center">
      <input name="exportar" class="botonXX"  type= "button"  value="Exportar" onClick="enviapag2(this.form)">
    </div></td>
  	<td width="135"><div align="center">
  	  <input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
	  </div></td>
  	<? }?>
  </tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</form>
<span class="Estilo2">*Para Visualizar correctamente este informe, debe de haber generado la promoci&oacute;n para los cuarto medios.</span> <br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
</center>


                                  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
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