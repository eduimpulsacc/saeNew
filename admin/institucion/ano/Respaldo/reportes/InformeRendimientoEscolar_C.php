<?
require('../../../../util/header.inc'); 
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$reporte		= $c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	
	
	
?>
<script type="text/javascript" language="javascript">
/*function exportar(form){
				document.form.valor.value=1;
				if (form.cmb_curso.value!=0){
					if(form.cmb_periodos.value!=0){
							form.target="_blank";
							var curso 		= document.form.cmb_curso.value;
							var periodos	= document.form.cmb_periodos.value;
							document.form.action='printInformeRendimientoCritico_C.php?cmb_curso='+curso+'&cmb_periodos='+periodos;
							document.form.submit(true);
					}else{
							alert("Seleccione Periodo.");
							document.form.cmb_periodos.focus();
					}
				}else{
					alert("Seleccione Curso.");
					document.form.cmb_curso.focus();
				}
			}*/
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
</style>
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
                      <td width="73%" align="left" valign="top"><br>
                        <br>
                    
                      <br><!-- INICIO FORMULARIO DE BUSQUEDA -->
<form action="printInformeRendimientoEscolar_C.php" method="post" name="form" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<? 
	$ob_motor = new MotorBusqueda();
	$ob_motor ->ano=$ano;
	$resultado_query_cue = $ob_motor ->curso($conn);
?>
<center>
<table width="686" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="674">
	<table width="684" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="680" class="tableindex">Buscador Avanzado </span></td>
  </tr>
  <tr>
    <td height="27">
	<table width="684" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="526" class="cuadro01">Buscar por Tipo de ense&ntilde;anza
      <select name="tipo_ensenanza" class="ddlb_x">
	     <option value="1">Todos los tipos de enseñanza</option>
        <?
		 for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
             $fila    = @pg_fetch_array($resultado_query_cue,$i);
	         $filanex = @pg_fetch_array($resultado_query_cue,$i+1); 
	         $tipo_ensenanza = $fila['ensenanza'];
	         $tipo_ensenanzanex = $filanex['ensenanza'];
	 	  
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
			    ?>
			    <option value="<?=$tipo_ensenanza ?>"><?=$nombre_tipo_ensenanza ?></option>
			    <?
			 }
		  }	
		?>
      </select>    </td>
    
    <td width="21">&nbsp;</td>
    <td width="54" valign="top">
      <div align="center">
		<input name="cb_ok" class="botonXX"  type="submit" value="Buscar">        
      </div></td>
	<? if($PERFIL==0){?>
    <td width="83" align="center" valign="top">
      
        <div align="center">
          <input name="cb_exp" class="botonXX"  type="submit" value="Exportar">
          <input name="cb_ok2" class="botonXX"  type="button" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
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
</center>
</form>
 
 
<!-- FIN FORMULARIO DE BUSQUEDA -->					  
					  
					  
					  
					  
					  
					  
                      <br></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
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