<? 	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$periodo		=$c_periodos;
	$curso			=$c_curso;
	$subsector		=$c_alumno;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	$sw				=0;
	
	foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   }
   
   foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   } 
	$meses=array("","","","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
	
	//año escolar
  		$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
		$result_ano =@pg_Exec($conn,$sql_ano);
		$fila_ano = @pg_fetch_array($result_ano,0);
		$nro_ano = $fila_ano['nro_ano'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<SCRIPT language="JavaScript">
	function enviapag2(form){
			form.target="_blank";
			var curso 		= document.form.cmb_curso.value;
			var subsector 	= document.form.subsector.value;
			document.form.action='printInformeResumenHorasPlanificacionCurricular_C.php?cmb_curso='+curso+'&cmb_subsector='+subsector;
			document.form.submit(true);
	}
	function enviapag(form){
		if (form.cmb_curso.value!=0){
			form.cmb_curso.target="self";
			window.location= 'InformeResumenHorasPlanificacionCurricular_C.php?cmb_curso=' + document.form.cmb_curso.value;
		}	
	}			
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
			
			
</script>


<script language="JavaScript" type="text/JavaScript">
<!--
function calcula(){ 
    var operando1 = document.calc.programadas.value 
    var operando2 = document.calc.realizadas.value 
    var result = eval(operando1 - operando2) 
    document.calc.norealizadas.value = result 
	} 

function calculatotal(operacion){ 
    var operando1 = parseFloat(document.calc.realizadas.value )
    var operando2 = (document.calc.norealizadas.value )
    var result = eval(operando1+operacion+operando2) 
    document.calc.totalclases.value = result 
	
	
} 

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"><table width="100%"><tr><td><?
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
								  <table width="" height="0" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="0" align="center" valign="top"> 
      
	  <?
						include("../../../../cabecera/menu_inferior.php");
						?>
  
  
</table>
<!-- FIN CODIGO DE BOTONES -->
<!-- INICIO FORMULARIO DE BUSQUEDA -->
<form method "post" action="<? echo $PHP_SELF ?>"  name="form">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<? 
//------------------

$ob_motor = new MotorBusqueda();

$ob_motor ->ano = $ano;
$resultado_query_cue = $ob_motor ->curso($conn);

/* $ob_motor ->ano = $ano;
$result_peri = $ob_motor ->periodo($conn); */

if($cmb_curso!=0){
	$ob_motor ->curso =$cmb_curso;
	$resultado_sub = $ob_motor ->Subsector($conn);
}
//------------------
?>
<center>
<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="" height="56" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" height="11" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="572" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="66" class="textosimple">Curso</td>
    <td colspan="2">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso" class="ddlb_9_x" onChange="enviapag(this.form);">
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
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";		  }
          } ?>
        </select>
	    </font>	  </div></td>
    <td width="44" class="textosimple">&nbsp;</td>
    <td width="157">&nbsp;</td>
    <td width="66"><div align="right">
      <!--input name="cb_ok" class="botonX" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' type= "submit"  value="Buscar"-->
    </div></td>
  </tr>
  <tr>
    <td class="textosimple">Subsector</td>
    <td colspan="2">
	<div align="left">
	  		
      <select name="cmb_subsector" class="ddlb_9_x">
		<option value=0 selected>(Todos los Subsectores)</option>
		<?
		
		for($i=0 ; $i < @pg_numrows($resultado_sub) ; $i++){
			$fila = @pg_fetch_array($resultado_sub,$i);?>
			<?
			if ($fila["id_ramo"] == $cmb_subsector){
			   ?>
			   <option value="<? echo $fila["id_ramo"]; ?>" selected><? echo ucwords(strtolower($fila["nombre"]));?></option>
			   <?
			}else{
			   ?>
			   <option value="<? echo $fila["id_ramo"]; ?>"><? echo ucwords(strtolower($fila["nombre"]));?></option>
			   <?
			}
			?>	   
			
			
			<?
		}
		?>
      </select>
    </div>	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">Mes</td>
    <td colspan="2"><select name="mes" >
      <option value="0">--Seleccione--</option>
      <?php  for($z=3;$z<12;$z++)
													  {
													  	
															$selected="";
															if($z==$mes)
															$selected="selected";
													  ?>
      <option value="<?php echo $z ?>" <?php echo $selected ?>><?php echo $meses[$z] ?></option>
      <?
														}
														
														?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td width="89"><input name="cb_ok" type="submit" class="botonXX"  id="cb_ok"  value="Buscar"></td>
	
    <td width="150"></td>
    
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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

 
 								  								  
								<form method "post" action="../reportes/printInformeResumenHorasPlanificacionCurricular_C.php"  name="form3" target="_blank"><table width="550" border="0" align="center">
                                <tr>
                                  <td>
                <div align="center">
                  <input name="institucion" type="hidden" id="institucion" value="<?php echo $institucion ?>">
                  <input name="cmb_curso" type="hidden" id="textfield" value="<?php echo $cmb_curso ?>">
                  <input name="cmb_subsector" type="hidden" id="cmb_subsector" value="<?php echo $cmb_subsector ?>">
                  <input type="hidden" name="mes" id="textfield2" value="<?php echo $mes ?>">
      <input name="nro_ano" type="hidden" value="<? echo $nro_ano ?>">
                  <input type="submit" class="botonXX" value="Exportar">
                </div> </td>
                                </tr>
                              </table>
              </form> 
                           
                              <br>
                              <br>
                              <?php if ($cmb_curso!=0 and $cmb_subsector!=0 and $mes!=0)
                              {
							  
							  	//busco si tiene cosas
								$sql_bus_hora="select * from res_hora_plancurri_$nro_ano where id_curso=$cmb_curso and id_subsector=$cmb_subsector and mes=$mes";
								$res_hora=@pg_exec($conn,$sql_bus_hora);
								
								if(@pg_numrows($res_hora)==0)
								{
									$tip=0;
									$txt="Ingresar";
									
								}
								else
								{
									$tip=1;
									$txt="Actualizar";
									$fila_hora = pg_fetch_array($res_hora,0);
									$programadas= $fila_hora['horas_programadas'];
									$realizadas= $fila_hora['horas_realizadas'];
									$norealizadas= $fila_hora['horas_no_realizadas'];
									
								}
							  ?>
                              <form name="calc" action="AltaHoras.php" method="post" TARGET="_self">
                              <table width="572" border="0" align="center">
  <tr class="tableindex">
    <td colspan="2"><div align="center">
      <input name="institucion2" type="hidden" id="institucion2" value="<?php echo $institucion ?>">
      <input name="cmb_curso" type="hidden" id="textfield" value="<?php echo $cmb_curso ?>">
      <input name="cmb_subsector" type="hidden" id="cmb_subsector" value="<?php echo $cmb_subsector ?>">
      <input type="hidden" name="tip" id="tip" value="<?php echo $tip ?>">
      <input type="hidden" name="mes" id="textfield2" value="<?php echo $mes ?>">
      <input name="nro_ano" type="hidden" value="<? echo $nro_ano ?>">
      MANTENEDOR HORAS RESUMEN PLANIFICACION CURRICULAR</div></td>
    </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2" class="textosimple">N&ordm; Horas</td>
    </tr>
  <tr>
    <td width="113" class="textosimple">Programadas</td>
    <td width="449"><input name="programadas" type="text" id="programadas" onFocus="calcula()" value="<?php echo $programadas ?>"  ></td>
    </tr>
  <tr>
    <td class="textosimple">Realizadas</td>
    <td><input type="text" name="realizadas" id="realizadas" onFocus="calcula(),calculatotal('+')" value="<?php echo $realizadas ?>"></td>
    </tr>
  <tr>
    <td class="textosimple">No realizadas</td>
    <td><input name="norealizadas" type="text" id="norealizadas" onFocus="calcula(),calculatotal('+')" value="<?php echo $norealizadas ?>"></td>
    </tr>
 <!-- <tr>
    <td class="textosimple">Total Clases</td>
    <td><input name="totalclases" type="text" id="totalclases" onChange="calculatotal(),calculatotal('+')"  ></td>
  </tr>-->

  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td><div align="center"></div></td>
    <td><input type="submit" name="button" id="button" value="<?php echo $txt ?>" class="botonXX"></td>
    </tr>
</table>
                              </form>
<?php }?> </td>
                                </tr>
                              </table>
</td>
                          </tr>
                        </table></td>
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