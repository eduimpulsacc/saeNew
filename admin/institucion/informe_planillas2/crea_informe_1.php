<?php require('../../../util/header.inc');
$institucion=$_INSTIT;
$_POSP = 4;
$_bot = 7;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script>
function Confirmacion(form){
		var pla=form.hiddenPlantilla.value;
		if(confirm('¿ESTA SEGURO DE ELIMINAR ESTOS DATOS?') == false){ return; };
			//window.location='procesoPlantilla.php?plantilla=pla&eliminar=1'
			form.action='procesoPlantilla.php?eliminar=1';
			form.submit(true);
		};
function Modifica(form){
		form.target='_parent';
		form.action='modificarPlantilla.php';
		//form.action='seteaPlantilla.php?plantilla=<? echo $plantilla;?>&caso=3';
		form.submit(true);
}

function agregaReg(form){
		form.target='_parent';
		form.action='../plantillaModifica/agregarRegistrosPlantilla.php';
		//form.action='seteaPlantilla.php?plantilla=<? echo $plantilla;?>&caso=3';
		form.submit(true);
}

</script>	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> <td>
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			<?   //include("../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
					<?   include("../../../cabecera/menu_superior.php");?>
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
					  <table><tr><td><?
					  	 $menu_lateral=2;
						 include("../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%"><tr><td valign="top">
							<form action="procesoPlantilla.php" method="post">
                              <table width="76%" border="0" align="center">
							  <tr><td colspan="2" class="fondo">1ro.- 
        Datos Plantilla</font></td></tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">1.-
                                        <?php if($creada!=1){
        echo "Seleccione el Tipo de Ense&ntilde;anza al que aplicar&aacute; este informe.";
		}else{
		echo "Tipo de Ense&ntilde;anza al que aplicar&aacute; este informe:";
		}
		?>
                                  </font>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="8%">&nbsp;</td>
                                  <td width="92%"><?php 
	 	$sqlEns="select distinct tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo from  tipo_ense_inst inner join tipo_ensenanza on tipo_ense_inst.cod_tipo=tipo_ensenanza.cod_tipo where tipo_ense_inst.rdb='".$institucion."' and tipo_ense_inst.estado=0 or tipo_ense_inst.estado=1";
		$resultEns=pg_Exec($conn,$sqlEns);
			if (!$resultEns) {
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlEns);
			}

	 ?>
                                      <?php if($creada!=1){?>
                                      <select name="cmbEns" id="cmbEns">
                                        <option value="0" selected>Seleccione Tipo de Ense&ntilde;anza</option>
                                        <?php
		  
		  for($cEns=0 ; $cEns<pg_numrows($resultEns) ; $cEns++){
			  $filaEns=pg_fetch_array($resultEns,$cEns);
			  echo "<option value=".$filaEns['cod_tipo'].">".$filaEns['nombre_tipo']."</option>";	
		  }//fin for
		  
		  ?>
                                      </select>
                                      <?php }else{ //fin if($creada!=1)
				$sqlTraeEns="select nombre_tipo from tipo_ensenanza inner join informe_plantilla on tipo_ensenanza.cod_tipo=informe_plantilla.tipo_ensenanza where informe_plantilla.id_plantilla=".$plantilla;
				$resultTraeEns=pg_Exec($conn,$sqlTraeEns);
					if (!$resultTraeEns) {
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$sqlTraeEns);
					}

				$filaTraeEns=@pg_fetch_array($resultTraeEns,0);
				echo "<font size=2 face=Arial, Helvetica, sans-serif>";
				echo $filaTraeEns['nombre_tipo'];
				echo "</font>";
			}
			?>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">2.-
                                        <?php 
	  if($creada!=1){
	  echo "Seleccione grados a los que aplica esta Plantilla de Informe.";
	  }else{
	  echo "Grados a los que aplica esta Plantilla de Informe:";
	  }
	  ?>
&nbsp; <font size="2" face="Arial, Helvetica, sans-serif"><font size="1">Ed. Parvularia: SC=</font><font size="1" face="Arial, Helvetica, sans-serif"> 1&ordm; A&Ntilde;O, NMME= 2&ordm; A&Ntilde;O, NMMA= 3&ordm; A&Ntilde;O, 1NT= 4&ordm; A&Ntilde;O, 2NT= 5&ordm; A&Ntilde;O</font></font></font></td>
                                </tr>
                                <?php if($creada!=1){?>
                                <tr>
                                  <td width="8%">&nbsp;</td>
                                  <td colspan="2" class="textosesion"><table width="100%" border="0">
                                    <tr class="textosesion">
                                        <td><input name="pa" type="checkbox" id="pa" value="1">
                            PRIMER A&Ntilde;O</td>
                                        <td><input name="sa" type="checkbox" id="sa" value="1">
                            SEGUNDO A&Ntilde;O </td>
                                        <td><input name="ta" type="checkbox" id="ta" value="1">
                            TERCER A&Ntilde;O </td>
                                        <td><input name="cu" type="checkbox" id="cu" value="1">
                            CUARTO A&Ntilde;O </td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="qu" type="checkbox" id="qu" value="1">
                            QUINTO A&Ntilde;O</td>
                                        <td><input name="sx" type="checkbox" id="sx" value="1">
                            SEXTO A&Ntilde;O</td>
                                        <td><input name="sp" type="checkbox" id="sp" value="1">
                            SEPTIMO A&Ntilde;O</td>
                                        <td><input name="oc" type="checkbox" id="oc" value="1">
                            OCTAVO A&Ntilde;O</td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="nv" type="checkbox" id="nv" value="1">
                            NOVENO A&Ntilde;O</td>
                                        <td><input name="dc" type="checkbox" id="dc" value="1">
                            DECIMO A&Ntilde;O</td>
                                        <td><input name="un" type="checkbox" id="un" value="1">
                            UNDECIMO A&Ntilde;O</td>
                                        <td><input name="duo" type="checkbox" id="duo" value="1">
                            DUODECIMO A&Ntilde;O</td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="tre" type="checkbox" id="tre" value="1">
                            DECIMO TERCER A&Ntilde;O</td>
                                        <td><input name="cat" type="checkbox" id="cat" value="1">
                            DECIMO CUARTO A&Ntilde;O</td>
                                        <td><input name="quince" type="checkbox" id="quince" value="1">
                            DECIMO QUINTO A&Ntilde;O</td>
                                        <td><input name="diezseis" type="checkbox" id="diezseis" value="1">
DECIMO SEXTO A&Ntilde;O</td>
                                      </tr>
                <tr class="textosesion">
                                        <td><input name="diecisiete" type="checkbox" id="diecisiete" value="1">
                            DECIMO SEPTIMO A&Ntilde;O</td>
                                        <td><input name="dieciocho" type="checkbox" id="dieciocho" value="1">
                            DECIMO OCTAVO A&Ntilde;O</td>
                                        <td><input name="diecinueve" type="checkbox" id="diecinueve" value="1">
                            DECIMO NOVENO A&Ntilde;O</td>
                                        <td><input name="veinte" type="checkbox" id="veinte" value="1">
VIG&Eacute;SIMO A&Ntilde;O</td>
                                      </tr>
                 <tr class="textosesion">
                                        <td><input name="veintiuno" type="checkbox" id="veintiuno" value="1">
                            VIG&Eacute;SIMO PRIMER A&Ntilde;O</td>
                                        <td><input name="veintidos" type="checkbox" id="veintidos" value="1">
                            VIG&Eacute;SIMO SEGUNDO A&Ntilde;O</td>
                                        <td><input name="veintitres" type="checkbox" id="veintitres" value="1">
                            VIG&Eacute;SIMO TERCER A&Ntilde;O</td>
                                        <td><input name="veinticuatro" type="checkbox" id="veinticuatro" value="1">
                                          VIG&Eacute;SIMO CUARTO  A&Ntilde;O</td>
                                      </tr>    <tr class="textosesion">
                                        <td><input name="veinticinco" type="checkbox" id="veinticinco" value="1">
VIG&Eacute;SIMO  QUINTO A&Ntilde;O</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>                                               </table></td>
                                </tr>
                                
                                <?php } else{?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">
                                    <?php 
		$sqlTraeGrados="SELECT * FROM informe_plantilla WHERE id_plantilla=".$plantilla;
		$resultGrados=pg_Exec($conn, $sqlTraeGrados);
			if (!$resultGrados) {
				error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$sqlTraeGrados);
			}
		for($countGr=0 ; $countGr<pg_numrows($resultGrados) ; $countGr++){
			$filaGr=pg_fetch_array($resultGrados);
			if ($filaGr['pa']==1) echo "PRIMERO   ";
			if ($filaGr['sa']==1) echo "SEGUNDO   ";
			if ($filaGr['ta']==1) echo "TERCERO   ";
			if ($filaGr['cu']==1) echo "CUARTO   ";
			if ($filaGr['qu']==1) echo "QUINTO   ";
			if ($filaGr['sx']==1) echo "SEXTO  ";
			if ($filaGr['sp']==1) echo "SEPTIMO   ";
			if ($filaGr['oc']==1) echo "OCTAVO   ";
			if ($filaGr['nc']==1) echo "NOVENO   ";
			if ($filaGr['dc']==1) echo "DECIMO   ";
			if ($filaGr['un']==1) echo "UNDECIMO   ";
			if ($filaGr['tre']==1) echo "DECIMO TERCER   ";
			if ($filaGr['duo']==1) echo "DUODECIMO   ";
			if ($filaGr['cat']==1) echo "DECIMO CUARTO   ";
			if ($filaGr['quince']==1) echo "DECIMO QUINTO   ";
			if ($filaGr['diezseis']==1) echo "DECIMO SEXTO   ";
		} ?>
                                  </font>&nbsp;</td>
                                </tr>
                                <?php }?>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">3.-
                                        <?php 
	  if($creada!=1){
	  echo "Asigne un nombre a la nueva Plantilla de Informe.";
	  }else{
	  echo "Nombre de la nueva Plantilla de Informe:";
	  }
	  ?>
                                  </font> &nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td  class="textosesion">
                                    <?php if($creada!=1){
		echo "Nombre:";?>
                                    <input name="txtNombrePla" type="text" id="txtNombrePla" size="50" maxlength="50">
                                    <?php }else{
				$sqlTraeNombre="select nombre, orientacion from informe_plantilla where id_plantilla=".$plantilla;
				$resultTraeNombre=pg_Exec($conn, $sqlTraeNombre);
				if (!$resultTraeNombre) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$sqlTraeNombre);
				}
				$filaTraeNombre=pg_fetch_array($resultTraeNombre,0);
				echo "<font size=2 face=Arial, Helvetica, sans-serif>";
				echo $filaTraeNombre['nombre'];
				echo "</font>";
	  		} ?>
                                  </font></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <!--    <tr> 
      <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">4.- 
	  <?php 
		// echo "FORMATO DE IMPRESION";
	  ?>
	  </font></td>
    </tr>
     <tr> 
      <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">
	  <?php // if($creada!=1){?>
	          VERTICAL 
        <input type="radio" name="orientacion" value="0">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	  HORIZONTAL 
        <input type="radio" name="orientacion" value="1">
		<?php /*}else{
		if($filaTraeNombre['orientacion']==1) $impresion="HORIZONTAL";
		if($filaTraeNombre['orientacion']==0) $impresion="VERTICAL";
		}
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $impresion;*/
		 ?>
        </font></td>
    </tr>
	<TR><TD>&nbsp;</TD></TR> -->
                                <tr>
                                  <td colspan="2" class="cuadro01">4.- Asigne </font> &nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td  class="textosesion">
                                    <?php if($creada!=1){?>
									T&iacute;tulo Informe Educacional:
                                    <input name="txtNombreTitulo1" type="text" id="txtNombreTitulo1" size="30" maxlength="100">
                                    <br>
                                    T&iacute;tulo Informe Desarrollo Personal y Social:
                                    <input name="txtNombreTitulo2" type="text" id="txtNombreTitulo2" size="30" maxlength="100">
                                    <?php }else{
				$sqlTraeTitulo="select titulo_informe1, titulo_informe2 from informe_plantilla where id_plantilla=".$plantilla;
				$resultTraeTitulo=pg_Exec($conn, $sqlTraeTitulo);
				if (!$resultTraeTitulo) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$sqlTraeTitulo);
				}
				$filaTraeTitulo=pg_fetch_array($resultTraeTitulo,0);	
					echo "Reporte &nbsp;&nbsp;3: ".$filaTraeTitulo['titulo_informe1']."<br>";	
					echo "Reporte 18: ".$filaTraeTitulo['titulo_informe2'];	
			} ?>
                                  </font></td>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">5.- Tipo</td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="textosesion"><input name="tipo_planilla" type="radio" id="tipo_planilla0" value="0" checked="CHECKED">
                                    Informe de Personalidad <input name="tipo_planilla" type="radio" id="tipo_planilla1" value="1" >
                                    Informe Diagn&oacute;stico</td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><?php if (($creada!=1) and ($eliminar!=1)){?>
                                      <input class="botonXX"  type="submit" name="Submit" value="GUARDAR">
                                      <?php }elseif(($creada==1) and ($eliminar==1)){?>
                                      <input type="hidden" name="hiddenPlantilla" value="<?php echo $plantilla?>">
                                      <input class="botonXX"  type="button" name="eliminar" value="ELIMINAR" onClick="Confirmacion(this.form)">
                                      <input class="botonXX"  type="button" name="cancelar" value="VOLVER" onClick="history.back()">
                                      <input class="botonXX"  type="button" name="cancelar" value="MODIFICAR" onClick="Modifica(this.form)">
                                      <input class="botonXX"  type="button" name="cancelar" value="AGREGAR REGISTROS" onClick="agregaReg(this.form)">
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2">&nbsp;</TD>
                                </tr>
                                <tr>
                                  <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">NOTA:</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">ELIMINAR: Permite eliminar la plantilla actual.</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">VOLVER : Vuelve al listado de Plantillas creadas.</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">MODIFICAR : Permite Modificar el texto de registros creados en la Plantilla actual.</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">AGREGAR REGISTROS : Permite Agregar AREAS, SUBAREAS E ITEMES a la Plantilla actual, tambi&eacute;n permite eliminar elementos de la Plantilla.</font></td>
                                </tr>
                                <?php }else{
			echo "<font size=2 face=Arial, Helvetica, sans-serif><STRONG>";
	  		echo "Estos datos han sido grabados siga con el paso Nro. 2";
			echo "</strong></font>";
	  		}
	  ?>
                              </table>
                            </form></td></tr></table>                         </td>

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
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
