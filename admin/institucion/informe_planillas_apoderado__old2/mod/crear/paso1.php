<?php require('../../../../../util/header.inc');
$institucion=$_INSTIT;
$_POSP = 4;
$_bot = 7;

	 	$sqlEns="select distinct tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo from  tipo_ense_inst inner join tipo_ensenanza on tipo_ense_inst.cod_tipo=tipo_ensenanza.cod_tipo where tipo_ense_inst.rdb='".$institucion."' and tipo_ense_inst.estado=0 or tipo_ense_inst.estado=1";
		$resultEns=pg_Exec($conn,$sqlEns);
			if (!$resultEns) {
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlEns);
			}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

function guardaNuevo(){
	var funcion =1;
	var formulario = $("#frm").serialize();
	var ense = $("#cmbEns").val();
	
	//invocar carga listado
			$.ajax({
				url:"con_crear.php",
				data:"funcion="+funcion+"&formulario="+formulario+"&ense="+ense,
				type:'POST',
				success:function(data){
				//$('#alcurso').html(data);
				//console.log(data);
				if(data>0){
					window.location.href = "paso2.php?id_plantilla="+data;
				}
		  }
		});  

	
	
}

</script>	
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
			<?   //include("../../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
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
					  <table><tr><td><?
					  	 $menu_lateral=2;
						 include("../../../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%"><tr><td valign="top">
							<form  method="post" id="frm">
                              <table width="76%" border="0" align="center">
							  <tr><td colspan="2" class="fondo">1ro.- 
        Datos Plantilla</font></td></tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">1.-
                                        Seleccione tipo de ense&ntilde;anza
                                  </font>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="8%">&nbsp;</td>
                                  <td width="92%"><select name="cmbEns" id="cmbEns">
                                        <option value="0" selected>Seleccione Tipo de Ense&ntilde;anza</option>
                                        <?php
		  
		  for($cEns=0 ; $cEns<pg_numrows($resultEns) ; $cEns++){
			  $filaEns=pg_fetch_array($resultEns,$cEns);
			  echo "<option value=".$filaEns['cod_tipo'].">".$filaEns['nombre_tipo']."</option>";	
		  }//fin for
		  
		  ?>
                                      </select></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">2.-
                                        Seleccione a qu&eacute; grado(s) aplica este informe
&nbsp; <font size="2" face="Arial, Helvetica, sans-serif"><font size="1">Ed. Parvularia: SC=</font><font size="1" face="Arial, Helvetica, sans-serif"> 1&ordm; A&Ntilde;O, NMME= 2&ordm; A&Ntilde;O, NMMA= 3&ordm; A&Ntilde;O, 1NT= 4&ordm; A&Ntilde;O, 2NT= 5&ordm; A&Ntilde;O. Educaci&oacute;n de adultos grados 9</font><font size="2" face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif">&ordm;</font></font><font size="1" face="Arial, Helvetica, sans-serif"> a 12</font><font size="2" face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif">&ordm;</font></font><font size="1" face="Arial, Helvetica, sans-serif">. Educaci&oacute;n especial grados 13</font><font size="2" face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif">&ordm;</font></font><font size="1" face="Arial, Helvetica, sans-serif"> a 15</font><font size="2" face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif">&ordm;</font></font></font></font>. </td>
                                </tr>
                                <?php if($creada!=1){?>
                                <tr>
                                  <td width="8%">&nbsp;</td>
                                  <td colspan="2" class="textosesion"><table width="100%" border="0">
                                    <tr class="textosesion">
                                        <td><input name="grado1" type="checkbox" id="grado1" value="1">
                            PRIMER A&Ntilde;O</td>
                                        <td><input name="grado2" type="checkbox" id="grado2" value="1">
                            SEGUNDO A&Ntilde;O </td>
                                        <td><input name="grado3" type="checkbox" id="grado3" value="1">
                            TERCER A&Ntilde;O </td>
                                        <td><input name="grado4" type="checkbox" id="grado4" value="1">
                            CUARTO A&Ntilde;O </td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="grado5" type="checkbox" id="grado5" value="1">
                            QUINTO A&Ntilde;O</td>
                                        <td><input name="grado6" type="checkbox" id="grado6" value="1">
                            SEXTO A&Ntilde;O</td>
                                        <td><input name="grado7" type="checkbox" id="grado7" value="1">
                            SEPTIMO A&Ntilde;O</td>
                                        <td><input name="grado8" type="checkbox" id="grado8" value="1">
                            OCTAVO A&Ntilde;O</td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="grado9" type="checkbox" id="grado9" value="1">
                            NOVENO A&Ntilde;O</td>
                                        <td><input name="grado10" type="checkbox" id="grado10" value="1">
                            DECIMO A&Ntilde;O</td>
                                        <td><input name="grado11" type="checkbox" id="grado11" value="1">
                            UNDECIMO A&Ntilde;O</td>
                                        <td><input name="grado12" type="checkbox" id="grado12" value="1">
                            DUODECIMO A&Ntilde;O</td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="grado13" type="checkbox" id="grado13" value="1">
                            DECIMO TERCER A&Ntilde;O</td>
                                        <td><input name="grado14" type="checkbox" id="grado14" value="1">
                            DECIMO CUARTO A&Ntilde;O</td>
                                        <td><input name="grado15" type="checkbox" id="grado15" value="1">
                            DECIMO QUINTO A&Ntilde;O</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                  </table></td>
                                </tr>
                                
                                <?php } else{?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                                <?php }?>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">3.- Asigne un nombre a la nueva Plantilla de Informe</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td  class="textosesion"><input name="nombre_informe" type="text" id="nombre_informe" size="50" maxlength="50">
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
                                  <td colspan="2" class="cuadro01">4.- Encabezados</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td  class="textosesion">
								  T&iacute;tulo Informe :
                                  </td>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td  class="textosesion"><input name="titulo" type="text" id="titulo" size="30" maxlength="100"></td>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td  class="textosesion">Texto                                    </td>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td  class="textosesion"><textarea name="descripcion" cols="50" rows="4" id="descripcion"></textarea></td>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><?php if (($creada!=1) and ($eliminar!=1)){?>
                                      <input class="botonXX"  type="button" name="Submit" value="GUARDAR" onClick="guardaNuevo()">
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
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
