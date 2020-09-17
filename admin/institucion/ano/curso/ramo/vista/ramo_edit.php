<?
include('../../../../../../util/header.inc');  
include('../controlador/ramo.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
<script type="text/javascript" src="../scripts/prototype.lite.js"></script>
<script type="text/javascript" src="../scripts/moo.fx.js"></script>
<script type="text/javascript" src="../scripts/moo.fx.pack.js"></script>
<script type="text/javascript">
<!--

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


function valida(){
   document.form.submit();
}
//-->
</script>
</head>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body topmargin="0" leftmargin="0" rightmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
							<? $menu_lateral="3_1"; include("../../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="">
								  
<!-- inicio de la pagina -->


<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td width="30%"><b>INSTITUCI&Oacute;N</b></td>
    <td><b>:  
	<?
	$fil_instit = get_institucion($_INSTIT, $conn);
	echo $fil_instit['nombre_instit'];	
	?>		
	</b></td>
  </tr>
  <tr>
    <td><b>A&Ntilde;O ESCOLAR </b></td>
    <td><b>:	
	<?
	$fil_ano  = get_ano($_ANO, $conn);
	echo $fil_ano['nro_ano'];	
	?></b></td>
  </tr>
  <tr>
    <td><b>CURSO</b></td>
    <td><b>: <? echo $curso_palabra = cursoPalabra($_CURSO,0,$conn);?></b></td>
  </tr>
  <tr>
    <td><b>SUBSECTOR</b></td>
    <td><b>: 
	<?
	$fil_subsector = get_subsector($_RAMO, $conn);
	echo $fil_subsector['nombre'];	
	?>
	</b></td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td align="right"><label>
      <input type="button" name="Submit" value="GUARDAR" class="botonXX" onclick="valida();">
    </label>
      <label>
      <input type="submit" name="Submit2" value="VOLVER" class="botonXX">
    </label></td>
  </tr>
</table>
<form name="form" method="post" action="ramo_act.php">
<input type="hidden" name="campo_actualiza" value="1" />
<div id="wrapper">
	<div id="content">
	<h3 class="tab" title="GENERAL"><div class="tabtxt"><a href="#">GENERAL</a></div></h3>
	<div class="tab"><h3 class="APROXIMACIONES" title="second"><a href="#">APROXIMACIONES</a></h3></div>
	<div class="tab"><h3 class="OTRAS" title="third"><a href="#">OTRAS</a></h3></div>
	<div class="tab"><h3 class="CONFIG. ESPECIAL" title="fourth"><a href="#">CONFIG. ESPECIAL</a></h3></div>
	<div class="boxholder">
		<div class="box">
			<table width="100%" border="0" cellpadding="2" cellspacing="0">
			  <tr>
				<td width="30%" height="25">SUBSECTOR</td>
				<td><label>
				  <?
				  echo $fil_subsector['nombre'];	
				  ?>				  
				</label></td>
			  </tr>
			  <tr>
				<td height="25">OBLIGATORIO</td>
				<td><label>
				<?
				$fil_ramo = get_ramo($_RAMO, $conn);
				$sub_obli = $fil_ramo['sub_obli'];
				?><input type="radio" name="sub_obli" <? if ($sub_obli==1){ ?> checked="checked" <? } ?> value="1" />   SI  &nbsp; &nbsp;
				  <input type="radio" name="sub_obli" <? if ($sub_obli!=1){ ?> checked="checked" <? } ?> value="0" />	NO			 
				</label></td>
			  </tr>
			  <tr>
				<td height="25">INCIDE EN PROMOCI&Oacute;N </td>
				<td>
				<?
				$bool_ip = $fil_ramo['bool_ip'];
				
				?>
				  <input type="radio" name="bool_ip" <? if ($bool_ip==1){ ?> checked="checked" <? } ?> value="1" />   SI  &nbsp; &nbsp;
				  <input type="radio" name="bool_ip" <? if ($bool_ip!=1){ ?> checked="checked" <? } ?> value="0" />	NO
				</td>
			  </tr>
			  <tr>
				<td height="25">ASOCIADO A RELIGI&Oacute;N </td>
				<td>
				<?
				$bool_sar = $fil_ramo['bool_sar'];
				
				?>
				 <input type="radio" name="bool_sar" <? if ($bool_sar==1){ ?> checked="checked" <? } ?> value="1" />   SI  &nbsp; &nbsp;
				 <input type="radio" name="bool_sar" <? if ($bool_sar!=1){ ?> checked="checked" <? } ?> value="0" />	NO
				</td>
			  </tr>
			  <tr>
				<td height="25">ART&Iacute;STICO</td>
				<td>
				<?
				$bool_artis = $fil_ramo['bool_artis'];
				
				?>
				  <input type="radio" name="bool_artis" <? if ($bool_artis==1){ ?> checked="checked" <? } ?> value="1" />   SI  &nbsp; &nbsp;
				  <input type="radio" name="bool_artis" <? if ($bool_artis!=1){ ?> checked="checked" <? } ?> value="0" />	NO
				</td>
			  </tr>
			  <tr>
				<td height="25">MODO DE EVALUACI&Oacute;N </td>
				<td>
				<?
				$modo_eval = $fil_ramo['modo_eval'];
				?>
				<select name="modo_eval">
				  <option value="0" <? if ($modo_eval==0){ ?> selected="selected" <? } ?>>Indeterminado</option>
				  <option value="1" <? if ($modo_eval==1){ ?> selected="selected" <? } ?>>Num�rico</option>
				  <option value="2" <? if ($modo_eval==2){ ?> selected="selected" <? } ?>>Conceptual</option>
				  <option value="3" <? if ($modo_eval==3){ ?> selected="selected" <? } ?>>Num�rico - Conceptual (I,S,B,MB)</option>
				  <option value="4" <? if ($modo_eval==4){ ?> selected="selected" <? } ?>>Conceptual (I,S,B,MB) - Num�rico</option>
				  <option value="5" <? if ($modo_eval==5){ ?> selected="selected" <? } ?>>Conceptual ESpecial (SIGLAS)</option>
				</select>				
				</td>
			  </tr>
		  </table>
		</div>
		<div class="box">
			<table width="100%" border="0" cellpadding="2" cellspacing="0">
			  <tr>
				<td width="30%" height="25">APROXIMAR PROMEDIO DE NOTAS </td>
				<td width="70%">
				<?
				$truncado = $fil_ramo['truncado'];
				?>
				<input type="radio" name="truncado" <? if ($truncado==1){ ?> checked="checked" <? } ?> value="1" />   SI  &nbsp; &nbsp;
				<input type="radio" name="truncado" <? if ($truncado!=1){ ?> checked="checked" <? } ?> value="0" />	NO
				</td>
			  </tr>
			  <tr>
				<td height="25">TIPO DE APROXIMACI&Oacute;N </td>
				<td>
				<?
				$tipo_aproximacion = $fil_ramo['tipo_aproximacion'];
				?>
				<input type="radio" name="tipo_aproximacion" <? if ($tipo_aproximacion==1){ ?> checked="checked" <? } ?> value="1" />   SI  &nbsp; &nbsp;
				<input type="radio" name="tipo_aproximacion" <? if ($tipo_aproximacion!=1){ ?> checked="checked" <? } ?> value="0" />	NO
				</td>
			  </tr>
			  
			  <?
			  if ($tipo_aproximacion!=0){ ?>
			  <tr>
				<td colspan="2">
				<div>
				<table width="90%" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
                  <tr>
                    <td><table width="100%" border="0" cellpadding="2" cellspacing="2">
                      <tr>
                        <td colspan="9">OPCIONES</td>
                      </tr>
                      <tr>
                        <td>X</td>
                        <td>Si decimal es </td>
                        <td>X,</td>
                        <td>9</td>
                        <td>a</td>
                        <td>xx,</td>
                        <td>8</td>
                        <td>Aproximar al entero siguiente </td>
                        <td>Ej: 39,5 =&gt; 40 </td>
                      </tr>
                      <tr>
                        <td>X</td>
                        <td>Si entero es </td>
                        <td>X</td>
                        <td>9</td>
                        <td>a</td>
                        <td>x</td>
                        <td>8</td>
                        <td>Subir a d&eacute;cima siguiente </td>
                        <td>Ej: 35 =&gt; 40 </td>
                      </tr>
                      <tr>
                        <td>x</td>
                        <td>Si entero es </td>
                        <td>X</td>
                        <td>9</td>
                        <td>a</td>
                        <td>x</td>
                        <td>9</td>
                        <td>Dejar unidad en Cero </td>
                        <td>Ej: 34 =&gt; 30 </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="9">OPCIONES LIBRES </td>
                      </tr>
                      <tr>
                        <td>X</td>
                        <td>Si promedio es </td>
                        <td>xx</td>
                        <td>a</td>
                        <td>xx</td>
                        <td> = </td>
                        <td>xx</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>X</td>
                        <td>Si promedio es </td>
                        <td>xx</td>
                        <td>a</td>
                        <td>xx</td>
                        <td>=</td>
                        <td>xx</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>x</td>
                        <td>Si promedio es </td>
                        <td>xx</td>
                        <td>a</td>
                        <td>xx</td>
                        <td>=</td>
                        <td>xx</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
				  
				  <tr>
					<td>APLICA CONFIGURACI&Oacute;N EN </td>
					<td>
					<?
					$fil_subsector = get_subsector($_RAMO, $conn);
					$aplica_aproximacion = $fil_ramo['aplica_aproximacion'];
					if ($aplica_aproximacion==0){
						echo "Solo en este subsector";  
					}
					if ($aplica_aproximacion==1){
						echo "En todos los subsectores de este curso";  
					}
					if ($aplica_aproximacion==2){
						echo "En este tipo de ense�anza";  
					}
					if ($aplica_aproximacion==3){
						echo "En todos los subsectores del establecimiento";  
					}
					
					?>
					</td>
				  </tr>
				  
                </table>
				</div>
				</td>
			  </tr>
			<? } ?>  
			  
		  </table>
		</div>
		<div class="box">
			<table width="100%" border="0" cellpadding="2" cellspacing="0">
			  <tr>
				<td width="30%" height="25">DOCENTE</td>
				<td width="70%">
				<?
				$fil_doc = get_docente($_RAMO, $conn);
				$rut_docente = $fil_doc['rut_emp'];
				
				$docentes = get_all_docentes($_INSTIT, $conn);
				?>
				<select name="rut_docente">
				    <option value="0">Seleccione Docente de Subsector </option>
				    <? 
				    foreach ($docentes as $docente): 
					    ?>
						<option value="<?=$docente['rut_emp']?>" <? if ($rut_docente==$docente['rut_emp']){ ?> selected="selected" <? } ?>><?=$docente['ape_pat']?> <?=$docente['ape_mat']?>, <?=$docente['nombre_emp']?> </option>
					    <?
				    endforeach				
				?>
				</select>				
				</td>
			  </tr>
			  <tr>
				<td height="25">AYUDANTE</td>
				<td>
				<?
				$fil_ayu = get_ayudante($_RAMO, $conn);
				$rut_ayudante = $fil_ayu['rut_emp'];
				
				$docentes = get_all_docentes($_INSTIT, $conn);
				?>
				<select name="rut_ayudante">
				    <option value="0">Seleccione Ayudante de Subsector </option>
				    <? 
				    foreach ($docentes as $docente): 
					    ?>
						<option value="<?=$docente['rut_emp']?>" <? if ($rut_ayudante==$docente['rut_emp']){ ?> selected="selected" <? } ?>><?=$docente['ape_pat']?> <?=$docente['ape_mat']?>, <?=$docente['nombre_emp']?> </option>
					    <?
				    endforeach				
				?>
				</select> 	
				<label>
				<input type="checkbox" name="elim_ayu" value="1" />
				</label>
				Eliminar			</td>
			  </tr>
			  <tr>
				<td height="25">EXAMEN</td>
				<td>
				<? 
				$con_examen = $fil_ramo['conex'];
				?>
				<input type="radio" name="con_examen" <? if ($con_examen==1){ ?> checked="checked" <? } ?> value="1" />   SI  &nbsp; &nbsp;
				<input type="radio" name="con_examen" <? if ($con_examen!=1){ ?> checked="checked" <? } ?> value="2" />	NO				
				</td>
			  </tr>
			  <?
			  if ($con_examen==1){ ?>
			  <tr>
				<td height="25">&nbsp;</td>
				<td><table width="70%" border="0" align="right" cellpadding="2" cellspacing="2">
                  <tr>
                    <td width="40%">Porcentaje Examen </td>
                    <td width="60%">
					<? 
                      $porcentaje_examen = $fil_ramo['pct_examen'];
					  echo $porcentaje_examen;
					?>  
				    %</td>
                  </tr>
                  <tr>
                    <td>Nota de Eximici&oacute;n </td>
                    <td>
					<?
					  $nota_eximicion = $fil_ramo['nota_exim'];
					  echo $nota_eximicion;
					?>
					</td>
                  </tr>
                </table></td>
			  </tr>
		    <? } ?>	  
			  <tr>
			    <td height="25">PRUEBA DE NIVEL </td>
			    <td>
				<?
				$prueba_nivel = $fil_ramo['prueba_nivel'];
				?>
				<input type="radio" name="prueba_nivel" <? if ($prueba_nivel==1){ ?> checked="checked" <? } ?> value="1" />   SI  &nbsp; &nbsp;
				<input type="radio" name="prueba_nivel" <? if ($prueba_nivel!=1){ ?> checked="checked" <? } ?> value="2" />	NO				
				</td>
		      </tr>
			  <?
			  if ($prueba_nivel=="1"){ ?>
				  <tr>
					<td height="25">&nbsp;</td>
					<td><table width="70%" border="0" align="right" cellpadding="2" cellspacing="2">
					  <tr>
						<td width="40%">Porcentaje Prueba de Nivel </td>
						<td width="60%"><? 
						  $porcentaje_prueba_nivel = $fil_ramo['pct_nivel'];
						  echo $porcentaje_prueba_nivel;
						?>
						  %</td>
					  </tr>
					  <tr>
						<td>Aproxima con Promedio </td>
						<td><?
						  $truncado_pnivel = $fil_ramo['truncado_pnivel'];
						  if ($truncado_pnivel=="1"){
							  echo "SI";
						  }else{
							   if ($truncado_pnivel=="0"){
								   echo "NO";
							   }else{
								   echo "<font face='arial, geneva, helvetica' size='2' color='#FF0000'><strong>Indeterminado</strong></font>";
							   }
						  }					  	  
						?>                    </td>
					  </tr>
					  <tr>
						<td>Modo de Evaluaci�n </td>
						<td>
						 <? 
						 $modo_eval_pnivel = $fil_ramo['modo_eval_pnivel'];
						 
						 if ($modo_eval_pnivel=="1"){
							  echo "Num�rico";					 
						 }else{
							 if ($modo_eval_pnivel=="2"){
								  echo "Conceptual"; 
							 }else{
								  echo "<font face='arial, geneva, helvetica' size='2' color='#FF0000'><strong>Indeterminado</strong></font>";			  
							 }
						 }				 
						 ?>
						</td>
					  </tr>
					</table></td>
				  </tr>
			  <? } ?>
		  </table>
		</div>
		<div class="box">
			<table width="100%" border="0" cellpadding="2" cellspacing="0">
			  <tr>
				<td width="30%" height="25">PORCENTAJE PROMEDIO DE NOTAS PARCIALES </td>
				<td width="70%">
				<? 
				$porc_examen = $fil_ramo['porc_examen'];
				?>
				<input type="text" name="porc_examen" value="<?=$porc_examen?>" size="2" /> %
				</td>
			  </tr>
			  <tr>
				<td colspan="2"><hr /></td>
			  </tr>
			  <tr>
				<td height="25">EX&Aacute;MENES SEMESTRALES </td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td height="25" colspan="2">
				
				<table width="80%" border="0" align="center" cellpadding="2" cellspacing="2">
				  <?
				  $examenes = get_examen_semestral($_RAMO, $conn);
				  
				  foreach ($examenes as $examen): 
					  ?>
					  <tr>
						<td><?=$examen['nombre'];?></td>
						<td><?=$examen['porc'];?></td>
					  </tr>
					  <?
				  endforeach ?>
                </table>
				
				</td>
			  </tr>
			  <tr>
				<td colspan="2"><hr /></td>
			  </tr>
			  <tr>
				<td height="25">APROXIMA PROMEDIO FINAL </td>
				<td>
				<? 
				$bool_ap = $fil_ramo['bool_ap'];
				?>
				<input type="radio" name="bool_ap" <? if ($bool_ap==1){ ?> checked="checked" <? } ?> value="1" />   SI  &nbsp; &nbsp;
				<input type="radio" name="bool_ap" <? if ($bool_ap!=1){ ?> checked="checked" <? } ?> value="0" />	NO
				</td>
			  </tr>
			  <tr>
				<td height="25">&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
		  </table>
		</div>
		
	</div>
</div>
</div>
</form>
 <!-- fin del codigo -->
 
<script type="text/javascript">
	Element.cleanWhitespace('content');
	init();
</script>

 </td>
                                </tr>
                              </table></td>
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
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>