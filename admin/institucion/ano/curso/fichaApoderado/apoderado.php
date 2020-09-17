<?
require('../../../../../util/header.inc');
require_once("../alumno/includes/widgets/widgets_start.php");


$frmModo=$_POST['frmModo'];
$rut_apod=$_POST['rut_apo'];

?>
<table width="650" border="0" cellpadding="1" cellspacing="1">
 					 	<TR height=20>
							<TD class="tableindex" align="center">
							FICHA APODERADOS
							</TD>
 						</TR>
					</table><br> 
					<?
  $sqlApoderado="select DISTINCT apoderado.*, region.nom_reg, provincia.nom_pro, comuna.nom_com from apoderado, tiene2, region, comuna, provincia where tiene2.rut_apo = '".$rut_apo."' and apoderado.rut_apo = tiene2.rut_apo
and comuna.cod_reg = apoderado.region and comuna.cor_com = apoderado.comuna and comuna.cor_pro = apoderado.ciudad 
and region.cod_reg = apoderado.region and provincia.cod_reg = apoderado.region and provincia.cor_pro = apoderado.ciudad ";
					$rsApoderado = @pg_Exec($conn,$sqlApoderado);
					for($i=0 ; $i < @pg_numrows($rsApoderado) ; $i++){
						$fApoderado = @pg_fetch_array($rsApoderado,$i);
						$sqlFoto= "select lo_export(".$fApoderado[foto].",'/opt/www/coeint/tmp/".chop($fApoderado['rut_apo'])."');";
						$rsFoto = @pg_exec($conn,$sqlFoto);
						//-------
						$nombres = strtoupper($fApoderado['nombre_apo']);
						$apellidos = trim(strtoupper($fApoderado['ape_pat']))." ".trim(strtoupper($fApoderado['ape_mat']));
						$rut_apo = strtoupper($fApoderado['rut_apo'])."-".strtoupper($fApoderado['dig_rut']);
						$direccion = trim(strtoupper($fApoderado['calle']))." ".trim(strtoupper($fApoderado['nro']));
						$comuna = trim(strtoupper($fApoderado['nom_com']));
						$region = trim(strtoupper($fApoderado['nom_reg']));
						$ciudad = trim(strtoupper($fApoderado['nom_pro']));						
						$email = trim(strtoupper($fApoderado['email']));
						$telefono = trim(strtoupper($fApoderado['telefono']));
						$celular = trim(strtoupper($fApoderado['celular']));
						$nivel_edu = trim(strtoupper($fApoderado['nivel_edu']));
						$profesion = trim(strtoupper($fApoderado['profesion']));
						$lugar_trabajo = trim(strtoupper($fApoderado['lugar_trabajo']));
						$cargo= trim(strtoupper($fApoderado['cargo']));
						if ($fApoderado['relacion']==1) $relacion = "PADRE";
						if ($fApoderado['relacion']==2) $relacion = "MADRE";
						if ($fApoderado['relacion']==3) $relacion = "OTROS";
						if ($fApoderado['sostenedor']>0) $sostenedor = "SI"; else 	$sostenedor = "NO";
						if ($fApoderado['responsable']>0) $responsable = "Y RESPONSABLE"; else $responsable  = "";
						//-------
						if (empty($nombres))  $nombres = "&nbsp;";
						if (empty($apellidos))  $apellidos = "&nbsp;";
						if (empty($direccion))  $direccion = "&nbsp;";
						if (empty($comuna))  $comuna = "&nbsp;";
						if (empty($region))  $region = "&nbsp;";																								
						if (empty($ciudad))  $ciudad = "&nbsp;";																														
						if (empty($email))  $email = "&nbsp;";																														
						if (empty($telefono))  $telefono= "&nbsp;";
						if (empty($celular))  $celular = "&nbsp;";												
						if (empty($nivel_edu))  $nivel_edu = "&nbsp;";												
						if (empty($profesion))  $profesion = "&nbsp;";												
						if (empty($lugar_trabajo))  $lugar_trabajo = "&nbsp;";												
						if (empty($cargo))  $cargo = "&nbsp;";																																				
					?>
                   
					<table width="650"  class="tabla01" Border=0 cellpadding=1 cellspacing=0>
					  <tr class="textonegrita">
						<td colspan="4" align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>DATOS - <? echo $relacion." ".$responsable ?></strong></font><div align="right">
     <input type="button" class="botonXX" align="right" id="agregar_apo" name="agregar_apo" value="Volver" title="Agregar Apoderado" onClick="ocultadiv()"  />
     </div>
       
                        </td>
					  </tr>
					  <tr><td>
<form method="post" name="frm" id="frm" action="mod_ficha_apoderado.php">
					  <table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
					  <tr class="textonegrita">
						<td  rowspan="14" align="left" valign="top">
						<? if ($rsFoto){ ?>
                        <img src="../../../../../../../tmp/<? echo chop($fApoderado['rut_apo'])?>" alt="NO DISPONIBLE"  width=110>                        
						<? } ?>
						</td>
                        
						<td ><strong>Nombres</strong></td>							
						<td class="td2"><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;
						<? echo $nombres?></font></td>
					    <td ><strong>Nivel Educacional</strong></font></td>
					    <td align="left" valign="top"><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $nivel_edu?></font></td>
					  </tr>
					  <tr class="textosimple">
						<td ><strong>Apellidos</strong></font></td>
						<td><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $apellidos?></font></td>
						<td ><strong>E-mail</strong></font></td>
						<td><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $email?></font></td>
					  </tr>
					  <tr class="textosimple">
						<td><strong>Tel&eacute;fono</strong></font></td>
						<td><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $telefono?></font></td>
						<td><strong>Celular</strong></font></td>
						<td><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $celular?></font></td>
					  </tr>
					  <tr class="textosimple">
						<td ><strong>Direcci&oacute;n</strong></font></td>
						<td><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $direccion?></font></td>
						<td ><strong>Relaci&oacute;n</strong></font></td>
						<td><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $relacion?></font></td>
					  </tr>
					  <tr class="textosimple">
						<td ><strong>Comuna</strong></font></td>
						<td><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $comuna?></font></td>
					    <td><strong>Lugar de Trabajo</strong></font></td>
					    <td><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $lugar_trabajo?></font></td>
					  </tr>
					  <tr class="textosimple">
					    <td ><strong>Ciudad</strong></font></td>
					    <td><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $ciudad?></font></td>
					    <td><strong>Profesi&oacute;n</strong></font></td>
					    <td align="left" valign="top"><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $profesion?></font></td>
				      </tr>
					  <tr class="textosimple">
						<td ><strong>Reg&iacute;on</strong></font></td>
						<td ><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $region?></font></td>
					    <td><strong>Cargo</strong></font></td>
					    <td align="left" valign="top"><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $cargo?></font></td>
					  </tr>
					  
                      <tr class="textosimple"><td></td><td></td><td></td>
                      <? //if($_PERFIL==15){?>
                      <td>
                       <input align="right" class="botonXX"  name="button1" type="button" value="MODIFICAR" onClick="modifica_apoderado(<?=$rut_apod;?>)">
                       </td>
                      <? //} ?>
                      </tr> 
					  </table>
                      </form>
                      </td></tr>
					</table>
					<br>
					
								
				<? } ?>	