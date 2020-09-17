<?	require('../../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;	
	$frmModo		=$_FRMMODO;
	$_POSP = 4;
	$_bot = 8;
	
	$sql = "SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector, ramo.eee, ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, 
ramo.porc_examen,ramo.bool_ip, ramo.sub_obli, ramo.bool_sar, ramo.bool_artis, ramo.aprox_entero, ramo.truncado, ramo.pct_examen, ramo.nota_exim,ramo.pct_ex_escrito, ramo.pct_ex_oral, ramo.truncado_pnivel, ramo.pct_nivel, ramo.modo_eval_pnivel, ramo.apreciacion, ramo.hrs_jec, ramo.hrs_plan, ramo.minima1, ramo.maxima1, ramo.bonifica1, ramo.minima2, ramo.maxima2, ramo.bonifica2, ramo.minima3, ramo.maxima3, ramo.bonifica3,formacion FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso.")) order by ramo.id_orden ASC";
	$rs_ramo = @pg_exec($conn,$sql);
	

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
body{
color: #333;
font-size: 11px;
font-family: verdana;
}
a{
color: #fff;
text-decoration: none;
}
a:hover{
color: #DFE44F;
}
p{
margin: 0;
padding: 5px;
line-height: 1.5em;
text-align: justify;
border: 1px solid #CCCCCC;
}
#wrapper{
width: 950px;
margin: 0 auto;
}
.box{
background: #fff;
vertical-align:top;
background-position:top;

}
.boxholder{
clear: both;
padding: 3px;
background: #CCCCCC;
vertical-align:top;
}
.tab{
float: left;
height: 32px;
width: 150px;
margin: 0 1px 0 0;
text-align: center;
background: #CCCCCC url(images/greentab.jpg) no-repeat;
}
.tabtxt{
margin: 0;
color: #fff;
font-size: 12px;
font-weight: bold;
padding: 9px 0 0 0;
}
</style>
<script type="text/javascript" src="scripts/prototype.lite.js"></script>
<script type="text/javascript" src="scripts/moo.fx.js"></script>
<script type="text/javascript" src="scripts/moo.fx.pack.js"></script>
<script type="text/javascript">
function init(){
	var stretchers = document.getElementsByClassName('box');
	var toggles = document.getElementsByClassName('tab');
	var myAccordion = new fx.Accordion(
		toggles, stretchers, {opacity: false, height: true, duration: 600}
	);
	//hash functions
	var found = false;
	toggles.each(function(h3, i){
		var div = Element.find(h3, 'nextSibling');
			if (window.location.href.indexOf(h3.title) > 0) {
				myAccordion.showThisHideOpen(div);
				found = true;
			}
		});
		if (!found) myAccordion.showThisHideOpen(stretchers[0]);
}
function enviapag(form){
	if(document.form.cmb_curso.value!=0){
		form.action='seteaConfig.php3?caso=1&curso='+document.form.cmb_curso.value;
		form.submit(true);
	}
}
function validarex(form,nombre,posicion){
	 var oral="txt_ORAL" + posicion;
	 var escrito = "txt_ESCRITO" + posicion;
	 var total;
	 if(document.form.elements[nombre].value > 0 || document.form.elements[nombre].value < 100){
	 	total = parseInt(document.form.elements[oral].value) + parseInt(document.form.elements[escrito].value);
		if(total < 100){
			alert("Examen Oral y Escrito deben sumar 100%");
			document.form.elements[oral].focus();
		}else if(total > 100){
			alert("Examen Oral y Escrito exede el 100%");
			document.form.elements[oral].value="";
			document.form.elements[escrito].value="";
			document.form.elements[escrito].focus();
		}
	 }else{
	 	alert("fuera");
	 }
}
function activar(form,nombre,posicion){
	 var pexamen="txt_PEXAMEN" + posicion;
	 var nexamen="txt_NEXAMEN" + posicion;
	 var escrito="txt_ESCRITO" + posicion;
	 var oral="txt_ORAL" + posicion;

	if(document.form.elements[nombre].checked==true){
		document.form.elements[pexamen].disabled=false;
		document.form.elements[nexamen].disabled=false;
		document.form.elements[escrito].disabled=false;
		document.form.elements[oral].disabled=false;
		document.form.elements[pexamen].value="";
		document.form.elements[nexamen].value="";
		document.form.elements[escrito].value="";
		document.form.elements[oral].value="";
		document.form.elements[pexamen].focus(true);
	}else{
		document.form.elements[pexamen].disabled=true;
		document.form.elements[nexamen].disabled=true;
		document.form.elements[escrito].disabled=true;
		document.form.elements[oral].disabled=true;
		document.form.elements[pexamen].value="";
		document.form.elements[nexamen].value="";
		document.form.elements[escrito].value="";
		document.form.elements[oral].value="";
	}
}
function activarnivel(form,nombre,posicion){

	var pnivel="txt_PNIVEL" + posicion;
	var aproxnivel="cb_APROXN" + posicion;
	var evalua="cmbEVALUAPRUEBANIVEL" + posicion;
	
	if(document.form.elements[nombre].checked==true){
		document.form.elements[pnivel].disabled=false;
		document.form.elements[aproxnivel].disabled=false;
		document.form.elements[evalua].disabled=false;
		document.form.elements[pnivel].value="";
		document.form.elements[evalua].value=0;
		document.form.elements[pnivel].focus(true);
	}else{
		document.form.elements[pnivel].disabled=true;
		document.form.elements[aproxnivel].disabled=true;
		document.form.elements[evalua].disabled=true;
		document.form.elements[pnivel].value="";
		document.form.elements[evalua].value=0;
		document.form.elements[aproxnivel].checked=false;
	}
	
}
function limpia(form,nombre,posicion){
	if(document.form.elements[nombre].value==0){
		document.form.elements[nombre].value="";
	}
}
function ValidaMinima(form,nombre){
	if((parseInt(document.form.elements[nombre].value) < 10) ||  (parseInt(document.form.elements[nombre].value) > 70)){
		alert("Nota de estar entre el rango de 11 y 69");
		document.form.elements[nombre].value="";
		document.form.elements[nombre].focus();
	}
}
function ValidaMaxima(form,nombre,posicion,caso){
	if(caso==1){
		var minima ="txt_MINIMA1" + posicion;
	}
	if(caso==2){
		var minima ="txt_MINIMA2" + posicion;
	}
	if(caso==3){
		var minima ="txt_MINIMA3" + posicion;
	}
	if((parseInt(document.form.elements[nombre].value) < 10) ||  (parseInt(document.form.elements[nombre].value) > 70)){
		alert("Nota de estar entre el rango de 11 y 69");
		document.form.elements[nombre].value="";
		document.form.elements[nombre].focus();
	}else{
		if(parseInt(document.form.elements[nombre].value) < parseInt(document.form.elements[minima].value)){
			alert("Nota máxima debe ser mayor que nota mínima");
			document.form.elements[nombre].focus();
		}
	}
}
function ValidaBonifica(form,nombre){
	if(parseInt(document.form.elements[nombre].value) > 70){
		alert("Bonificación no debe superar 70 puntos");
		document.form.elements[nombre].focus();
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>"></td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../../cabecera/menu_superior.php");
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
						include("../../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
							<form action="procesaConfiguracion.php" name="form" method="post">
							<input type="hidden" name="contador" value="<?=@pg_numrows($rs_ramo);?>" />
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td valign="top">
								  <table width="100%" border="0">
									  <tr>
										<td width="15%" class="textonegrita">CURSO</td>
										<td>
                						<?	$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
											$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
											$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano."))   ";
											$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
											$resultado_query_cue = pg_exec($conn,$sql_curso);
						                ?>
									  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
											<option value="0" selected>(Seleccione un Curso)</option>
									 <?
									// $sw3 = 1;
									 
									 for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i)
										{  
										$fila = @pg_fetch_array($resultado_query_cue,$i); 
										$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
								  
										if (($fila['id_curso'] == $curso)){
										   echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
										   $sw3 = 0;
										}else{	    
										   echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
										}
									 } 
									
									 ?>
								  </select>	 </td>
							  </tr>
									  <tr>
										<td colspan="2">&nbsp;</td>
									  </tr>
									  <tr>
										<td colspan="2"><div align="right">
										<? if($frmModo=="mostrar"){?>
										  <input type="button" name="modifica" value="MODIFICAR" class="botonXX" onclick="window.location='seteaConfig.php3?caso=3'">
										  <input type="button" name="Submit2" value="VOLVER" class="botonXX" onClick="window.location='listarRamos.php3?cmb_curso=<?=$curso;?>'">
										 <? } 
										 if($frmModo=="modificar"){ ?>
										  <input type="submit" name="guardar" value="GUARDAR" class="botonXX">
										  <input type="button" name="CANCELAR" value="CANCELAR" class="botonXX" onClick="window.location='seteaConfig.php3?caso=1&curso=<?=$curso;?>'">							 
										 
										 <? }?>
									    </div></td>
									  </tr>
									</table>
									<br>
									<!-- INCLUYO CODIGO DE LOS BOTONES -->
								<table width="" height="49" border="0" cellpadding="0" cellspacing="0">
								  <tr> 
									<td width="" height="30" align="center" valign="top"> <? include("../../../../../cabecera/menu_inferior.php");?></td>	  
									  
							    <tr>
								</tr> 
								  
								  
								</table>
 								  	<div id="wrapper">
									<div id="content">
									<h3 class="tab" title="Configuración Básica"><div class="tabtxt"><a href="#">GENERAL</a></div></h3>
									<div class="tab"><h3 class="tabtxt" title="Examén y Prueba de Nivel"><a href="#">EXAMEN/P. NIVEL</a></h3></div>
									<div class="tab"><h3 class="tabtxt" title="Apreciación y Bonificación"><a href="#">APREC./BONFIC</a></h3></div>
									<div class="tab"><h3 class="tabtxt" title="Otras Config."><a href="#">OTRAS CONFIG.</a></h3></div>
									<div class="boxholder">
										<div class="box">
											&nbsp;

										</div>
										<div class="box">
											&nbsp;

										</div>
										<div class="box">
											&nbsp;

										</div>
									  <div class="box">
									    <table width="100%" border="1">
                                              <tr>
                                                <td>Nombre</td>
                                                <td>Formaci&oacute;n</td>
                                              </tr>
                                              <? if($frmModo!="mostrar"){?>

                                              <? } ?>
                                              <? for($j=0;$j<@pg_numrows($rs_ramo);$j++){
											  		$fila_ramo = @pg_fetch_array($rs_ramo,$j);
											  ?>
                                              <input name="ramo<?=$j;?>2" type="hidden" value="<?=$fila_ramo['id_ramo'];?>" />
                                              <tr>
                                                <td><?=$fila_ramo['nombre'];?></td>
                                                <td>
												<? if($frmModo=="ingresar"){?>
												<select name="cmbFORMACION<?=$j;?>">
                                                  <option value="1" selected="selected">Formaci&oacute;n General</option>
                                                  <option value="2">Formaci&oacute;n Diferencial</option>
                                                  <option value="3">Formaci&oacute;n Intrumental</option>
                                                </select>
												<? }
												if($frmModo=="modificar"){?>
												<select name="cmbFORMACION<?=$j;?>">
                                                  <option value="1" <? if($fila_ramo['formacion']==1){ echo "selected"; }else{ echo "&nbsp;";}?>>Formaci&oacute;n General</option>
                                                  <option value="2" <? if($fila_ramo['formacion']==2){ echo "selected"; }else{ echo "&nbsp;";}?>>Formaci&oacute;n Diferencial</option>
                                                  <option value="3" <? if($fila_ramo['formacion']==3){ echo "selected"; }else{ echo "&nbsp;";}?>>Formaci&oacute;n Intrumental</option>
                                                </select>
												 
												<? } 
													if($frmModo=="mostrar"){
														if($fila_ramo['formacion']==1){
															echo "General";
														}elseif($fila_ramo['formacion']==2){
															echo "Diferenciada";
														}elseif($fila_ramo['formacion']==3){
															echo "Intrumental";
														}
													}
													?>
												</td>
                                              </tr>
                                              <?  } ?>
                                              <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                              </tr>
                                            </table>
									  </div>
									</div>
								</div>
								</div>
								<script type="text/javascript">
									Element.cleanWhitespace('content');
									init();
								</script>							  
								  </td>
                                </tr>
                              </table>
							  </form>
							  </td>
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
<? pg_close($conn);?>