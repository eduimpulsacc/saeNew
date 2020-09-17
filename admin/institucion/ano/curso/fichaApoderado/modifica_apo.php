<?
	require('../../../../../util/header.inc');
	require_once("../alumno/includes/widgets/widgets_start.php");
	include('../../../../clases/class_MotorBusqueda.php');

$ob_motor = new MotorBusqueda();

	 $frmModo=$_POST['frmModo'];
     $rut_apo=$_POST['rut_apod'];
	 
	 $ob_motor ->ano =$_POST['ano'];
	 $ob_motor ->cmb_curso =$_POST['curso'];
	 $result_curso = $ob_motor ->alumno($conn);

?>

<?
	if($frmModo=="ingresar"){;?>
		
	<table width="684" border="0" cellpadding="1" cellspacing="1">
 					 	<TR height=20>
							<TD class="tableindex" align="center">
							INGRESAR APODERADO
							</TD> 
 						</TR>
					</table><br>
					<?
 																																	
					?>
                   
					<table class="tabla01" width="650" Border=0 cellpadding=1 cellspacing=0>
					  
                      
					  <tr><td>
	<FORM name="frm_aux" id="frm_aux">					  
					  <table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
					    
                        <tr class="textonegrita">
						<td ><strong>&nbsp;Rut</strong></td>							
						<td class="td2">
                        <input type="text" name="rut" id="rut"> - <input type="text" name="dig" id="dig" size="2" maxlength="1">
                        </td>
					    <td >&nbsp;</td>
					    <td align="left">&nbsp;</td>
					  </tr>
                      <tr class="textonegrita">
						<td ><strong>&nbsp;Nombres</strong></td>							
						<td class="td2">
                        <input type="text" name="nombres2" id="nombres2">
                        </td>
					    <td ><strong>&nbsp;Nivel&nbsp;Educacional</strong></font></td>
					    <td align="left"><input type="text" name="nivel_edu2" id="nivel_edu2" ></td>
					  </tr>
					  <tr class="textonegrita">
						<td><strong>&nbsp;Apellido&nbsp;Paterno</strong></font></td>
						<td><input type="text" name="apellido_pat2" id="apellido_pat2">
                        </td>
						<td>&nbsp;Apellido&nbsp;Materno</font></td>
						<td><input type="text" name="apellido_mat2" id="apellido_mat2" >
                        </td>
					  </tr>
					  <tr class="textonegrita">
						<td><strong>&nbsp;Tel&eacute;fono</strong></font></td>
						<td><input type="text" name="telefono2" id="telefono2">
                        </td>
						<td><strong>&nbsp;Celular</strong></font></td>
						<td><input type="text" name="celular2" id="celular2" >
                        </td>
					  </tr >
					  <tr class="textonegrita">
						<td><strong>&nbsp;Direcci&oacute;n</strong></font></td>
						<td><input type="text" name="direccion2" id="direccion2" >
                        </td>
						<td><strong>&nbsp;N&deg;</strong></font></td>
						<td>
						<input type="text" name="numero2" id="numero2" >
                        </td>
					  </tr>
					  <tr class="textonegrita">
						<td><strong>&nbsp;Regi&oacute;n</strong></font></td>						<td><!-- sacar nombre de region -->
	
    
			<?php if($frmModo=="ingresar"){ ?>
    
			<select name="Region" id="Region" class="ingreso2" onChange="javascript:LlenaProvincia();"  >
				<option value="0" selected="selected">Seleccione Region</option>
				<?php 
					$sql = "SELECT cod_reg,nom_reg FROM region ORDER BY cod_reg";
					$Rs_Region= pg_exec($conn,$sql);
					for($i=0 ; $i < pg_numrows($Rs_Region) ; $i++){
						$fila = pg_fetch_array($Rs_Region,$i);
						if ($fila["cod_reg"]==$cod_reg){ 
							echo  "<option selected value=".$fila["cod_reg"]." >".$fila["nom_reg"]."</option>";
							
						}else{
							echo  "<option value=".$fila["cod_reg"]." >".$fila["nom_reg"]."</option>";
						}
					}
					?>
			</select>	
    <?php };?>
    
	
                        </td>
					    <td class="textonegrita"><strong>&nbsp;Relaci&oacute;n</strong></font></td>
        <td>
        <Select name="cmbRELACION2" id="cmbRELACION2">
        <option value=0></option>
        <option value=1 >Padre</option>
        <option value=2 >Madre</option>
        <option value=3 >Otro</option>
        </Select>
        </td>
					  </tr>
					  <tr class="textonegrita">
					    <td ><strong>&nbsp;Provincia</strong></font></td>
					    <td><?
	        $qryPRO		= "SELECT * FROM PROVINCIA WHERE COD_REG='".$cod_reg."'";
			   $resultPRO	= @pg_Exec($conn,$qryPRO);
			   $numPRO      = @pg_numrows($resultPRO);
			   ?>
			   <select name="Provincia" id="Provincia" class="ingreso2" onChange="javascript:LlenaComuna();">
			   <? 
			   for ($i=0; $i < $numPRO; $i++){
		            $filaPRO = @pg_fetch_array($resultPRO,$i);
					$cod_prov =  $filaPRO['cor_pro'];
					$nom_pro =  $filaPRO['nom_pro'];
					?>
					<option value="<?=$cod_prov?>" <? if ($cod_prov==$cod_pro){ ?> selected="selected" <? } ?>><?=$nom_pro?></option>
					<?		   
			   
			   ?>
			   </select>
			   <? 
		  
		 } ?> 
                        </td>
					    <td><strong>&nbsp;Profesi&oacute;n</strong></font></td>
					    <td align="left" valign="top"><input type="text" name="profesion2" id="profesion2" ></td>
				      </tr>
					  <tr class="textonegrita">
						<td ><strong>&nbsp;Comuna</strong></font></td>				<td><?
                	  $qryCOM		= "SELECT * FROM COMUNA WHERE COD_REG='".$cod_reg."' AND COR_PRO='".$cod_pro."'";
			$resultCOM	= @pg_Exec($conn,$qryCOM);
			$numCOM     = @pg_numrows($resultCOM);
			?>
			<select name="Comuna" id="Comuna" class="ingreso2">			
			    <?
				for ($i=0; $i < $numCOM; $i++){
				   $filaCOM = @pg_fetch_array($resultCOM,$i);
				   $nom_com = $filaCOM['nom_com'];
				   $cor_com = $filaCOM['cor_com']; 
				   ?>
				   <option value="<?=$cor_com?>" <? if ($cod_com==$cor_com){ ?> selected="selected" <? } ?> ><?=$nom_com?></option>
				   <?
				
				}   
			?>
			</select>
			<?
    
	  ?>  
	          
                </td>
					    <td><strong>&nbsp;Cargo</strong></font></td>
					    <td align="left" valign="top"><input type="text" name="cargo2" id="cargo2" ></td>
					  </tr>
					  <tr class="textonegrita">
					    <td ><strong>&nbsp;Lugar&nbsp;de&nbsp;Trabajo </strong></font></td>
					    <td align="left" valign="top"><input type="text" name="lugar_trabajo2" id="lugar_trabajo2" > </td>
                        
                        <td><strong>&nbsp;Email </strong></font></td>
                        <td><input type="text" name="email2" id="email2" ></td>
                      </tr>
                      <tr class="textonegrita">
                        <td colspan="2"><strong>Seleccione Alumno</strong></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                </tr>      <tr>
                        <td class="textonegrita"><strong>Curso</strong></td>
                        <td class="textosimple">
                       
                        <input name="hdd_curso" type="hidden" id="hdd_curso" value="" /><? echo CursoPalabra($_POST['curso'],0,$conn);?>
                        
                        </td>
                        <td class="textonegrita"><strong>Alumno</strong></td>
                      <td> <select name="cmb_alumno" class="ddlb_9_x" id="cmb_alumno">
                      <option value="0">(Seleccione Alumno)</option>
<?php  for($i=0 ; $i < @pg_numrows($result_curso) ;++$i){
	$fila = @pg_fetch_array($result_curso,$i);
	?>
<option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
<?php }?>
</select></td>
                      </tr>
                      <tr>
                        <td colspan="4">&nbsp;</td>
                        </tr>
                      <tr class="textosimple"><td></td><td></td><td><input align="right" class="botonXX"  name="guardar" type="button" value="GUARDAR"  onClick= "insertaapo()"></td>
                      <td> &nbsp;&nbsp;
        <input align="right" class="botonXX"  name="volver" type="button" value="volver" onClick="ocultadiv3()" >     </td>
                     
                      </tr>
					  </table>
                      </form>
					</td></tr>
					</table>
					<br>
					
								
				<? } ?>
                	<?	
	
if($frmModo=="modificar"){
?>

<table width="650" border="0" cellpadding="1" cellspacing="1">
 					 	<TR height=20>
							<TD class="tableindex" align="center">
							MODIFICAR APODERADO
							</TD> 
 						</TR>
					</table><br>
					<?
 $sqlApoderado="select apoderado.*,  region.nom_reg, provincia.nom_pro, comuna.nom_com from apoderado, tiene2, region, comuna, provincia where tiene2.rut_apo = '".$rut_apo."' and apoderado.rut_apo = tiene2.rut_apo
and comuna.cod_reg = apoderado.region and comuna.cor_com = apoderado.comuna and comuna.cor_pro = apoderado.ciudad 
and region.cod_reg = apoderado.region and provincia.cod_reg = apoderado.region and provincia.cor_pro = apoderado.ciudad ";
//if($_PERFIL==0){echo $sqlApoderado;}
					$rsApoderado = @pg_Exec($conn,$sqlApoderado);
					for($i=0 ; $i < @pg_numrows($rsApoderado) ; $i++){
						$fApoderado = @pg_fetch_array($rsApoderado,$i);
						$sqlFoto= "select lo_export(".$fApoderado[foto].",'/opt/www/coeint/tmp/".chop($fApoderado['rut_apo'])."');";
						$rsFoto = @pg_exec($conn,$sqlFoto);
						//-------
						$nombres = strtoupper($fApoderado['nombre_apo']);
					    $ape_pat = trim(strtoupper($fApoderado['ape_pat']));
						$ape_mat= trim(strtoupper($fApoderado['ape_mat']));
						$rut_apod = strtoupper($fApoderado['rut_apo'])."-".strtoupper($fApoderado['dig_rut']);
						$direccion = trim(strtoupper($fApoderado['calle']));
						$numero    = trim(strtoupper($fApoderado['nro']));
						$comuna = trim(strtoupper($fApoderado['nom_com']));
						$region = trim(strtoupper($fApoderado['nom_reg']));
						$ciudad = trim(strtoupper($fApoderado['nom_pro']));						
						$email = trim(strtoupper($fApoderado['email']));
						$telefono = trim(strtoupper($fApoderado['telefono']));
						$celular = trim(strtoupper($fApoderado['celular']));
						$nivel_edu = trim(strtoupper($fApoderado['nivel_edu']));
						$profesion = trim(strtoupper($fApoderado['profesion']));
						$lugar_trabajo = trim(strtoupper($fApoderado['lugar_trabajo']));
						$cod_reg = $fApoderado['region'];
						$cod_pro = $fApoderado['ciudad'];
						$cod_com = $fApoderado['comuna'];
						$cargo= trim(strtoupper($fApoderado['cargo']));
						if ($fApoderado['relacion']==1) $relacion = "PADRE";
						if ($fApoderado['relacion']==2) $relacion = "MADRE";
						if ($fApoderado['relacion']==3) $relacion = "OTROS";
						if ($fApoderado['sostenedor']>0) $sostenedor = "SI"; else 	$sostenedor = "NO";
						if ($fApoderado['responsable']>0) $responsable = "Y RESPONSABLE"; else $responsable  = "";
						//-------
						/*if (empty($nombres))  $nombres = "&nbsp;";
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
						if (empty($cargo))  $cargo = "&nbsp;";	*/																																			
					?>
                   
					<table class="tabla01" width="650" Border=0 cellpadding=1 cellspacing=0>
					  <tr>
						<td colspan="4" align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>DATOS - <? echo $relacion." ".$responsable ?></strong></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       
                        </td>
					  </tr>
                      
					  <tr><td>
	<FORM name="frm_aux" id="frm_aux">					  
					  <table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
					  <tr class="textonegrita">
						<td  rowspan="14" align="left" valign="top">
						<? if ($rsFoto){ ?>
                        <img src="../../../../../../../tmp/<? echo chop($fApoderado['rut_apo'])?>" alt="NO DISPONIBLE"  width=110>                        
						<? } ?>
						</td>
                        
						<td ><strong>Nombres</strong></font></td>							
						<td class="td2"><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;
						<?
                        if($frmModo=="modificar"){?>
                        <input type="text" name="nombres" id="nombres" value="<?=trim($nombres)?>">
                        <? }?></font>
                        </td>
					    <td ><strong>Nivel Educacional</strong></td>
					    <td align="left"><input type="text" name="nivel_edu" id="nivel_edu" value="<?=trim($nivel_edu)?>"></td>
					  </tr>
					  <tr class="textonegrita">
						<td><strong>Apellido Paterno</strong></td>
						<td><input type="text" name="apellido_pat" id="apellido_pat" value="<?=trim($ape_pat)?>">
                        </td>
						<td>Apellido Materno</font></td>
						<td><input type="text" name="apellido_mater" id="apellido_mater" value="<?=$ape_mat?>">
                        </td>
					  </tr>
					  <tr class="textonegrita">
						<td><strong>Tel&eacute;fono</strong></td>
						<td>&nbsp;</td>
						<td><strong>Celular</strong></td>
						<td><input type="text" name="celular" id="celular" value="<?=$celular?>">
                        </td>
					  </tr >
					  <tr class="textonegrita">
						<td><strong>Direcci&oacute;n</strong></font></td>
						<td><input type="text" name="telefono" id="telefono" value="<?=$telefono?>" />						  <input type="text" name="direccion" id="direccion" value="<?=trim($direccion)?>">
                        </td>
						<td><strong>N&deg;</strong></font></td>
						<td>
                        <?php if($frmModo=="modificar"){ ?>
						<input type="text" name="numero" id="numero" value="<?=$numero?>">
                     <?  };?>								
                        </td>
					  </tr>
					  <tr class="textonegrita">
						<td><strong>Regi&oacute;n</strong></font></td>						<td><!-- sacar nombre de region -->
	<?php if($frmModo=="modificar"){ ?>
    
			<select name="Region" id="Region" class="ingreso2" onChange="javascript:LlenaProvincia();"  >
				<option value="0" selected="selected">Seleccione Region</option>
				<?php 
					$sql = "SELECT cod_reg,nom_reg FROM region ORDER BY cod_reg";
					$Rs_Region= pg_exec($conn,$sql);
					for($i=0 ; $i < pg_numrows($Rs_Region) ; $i++){
						$fila = pg_fetch_array($Rs_Region,$i);
						if ($fila["cod_reg"]==$cod_reg){ 
							echo  "<option selected value=".$fila["cod_reg"]." >".$fila["nom_reg"]."</option>";
							
						}else{
							echo  "<option value=".$fila["cod_reg"]." >".$fila["nom_reg"]."</option>";
						}
					}
					?>
			</select>	
    <?php };?>
    
	
                        </td>
					    <td ><strong>Sostenedor</strong></font></td>
					    <td> 
                        <input type="checkbox" name="chkSOS" id="chkSOS" value="1">
					  
                        </td>
					  </tr>
					  <tr class="textonegrita">
					    <td ><strong>Provincia</strong></font></td>
					    <td><?
                        if ($frmModo=="modificar"){ 
	        $qryPRO		= "SELECT * FROM PROVINCIA WHERE COD_REG='".$cod_reg."'";
			   $resultPRO	= @pg_Exec($conn,$qryPRO);
			   $numPRO      = @pg_numrows($resultPRO);
			   ?>
			   <select name="Provincia" id="Provincia" class="ingreso2" onChange="javascript:LlenaComuna();">
			   <? 
			   for ($i=0; $i < $numPRO; $i++){
		            $filaPRO = @pg_fetch_array($resultPRO,$i);
					$cod_prov =  $filaPRO['cor_pro'];
					$nom_pro =  $filaPRO['nom_pro'];
					?>
					<option value="<?=$cod_prov?>" <? if ($cod_prov==$cod_pro){ ?> selected="selected" <? } ?>><?=$nom_pro?></option>
					<?		   
			   }
			   ?>
			   </select>
			   <? 
		  
		 } ?> 
                        </td>
					    <td><strong>Profesi&oacute;n</strong></font></td>
					    <td align="left" valign="top"><input type="text" name="profesion" id="profesion" value="<?=trim($profesion)?>"></td>
				      </tr>
					  <tr class="textonegrita">
						<td ><strong>Comuna</strong></font></td>				<td><?
						if ($frmModo=="modificar"){ 
                	  $qryCOM		= "SELECT * FROM COMUNA WHERE COD_REG='".$cod_reg."' AND COR_PRO='".$cod_pro."'";
			$resultCOM	= @pg_Exec($conn,$qryCOM);
			$numCOM     = @pg_numrows($resultCOM);
			?>
			<select name="Comuna" id="Comuna" class="ingreso2">			
			    <?
				for ($i=0; $i < $numCOM; $i++){
				   $filaCOM = @pg_fetch_array($resultCOM,$i);
				   $nom_com = $filaCOM['nom_com'];
				   $cor_com = $filaCOM['cor_com']; 
				   ?>
				   <option value="<?=$cor_com?>" <? if ($cod_com==$cor_com){ ?> selected="selected" <? } ?> ><?=$nom_com?></option>
				   <?
				
				}   
			?>
			</select>
			<?
    
	 } ?>  
	          
                </td>
					    <td><strong>Cargo</strong></font></td>
					    <td align="left" valign="top"><input type="text" name="cargo" id="cargo" value="<?=trim($cargo)?>"></td>
					  </tr>
					  <tr class="textonegrita">
					    <td ><strong>Lugar de Trabajo </strong></font></td>
					    <td align="left" valign="top"><input type="text" name="lugar_trabajo" id="lugar_trabajo" value="<?=trim($lugar_trabajo)?>"> </td>
                        
                        <td><strong>Email </strong></font></td>
                        <td><input type="text" name="email" id="email" value="<?=trim($email)?>"></td>
                      </tr>
                      <td class="textonegrita"><strong>Relaci&oacute;n</strong></font></td>
        <td>
        <?php if($frmModo=="modificar"){ ?>
        <Select name="cmbRELACION" id="cmbRELACION">
        <option value=0></option>
        <option value=1 <?php echo ($fApoderado['relacion'])==1?"selected":"" ?>>Padre</option>
        <option value=2 <?php echo ($fApoderado['relacion'])==2?"selected":"" ?>>Madre</option>
        <option value=3 <?php echo ($fApoderado['relacion'])==3?"selected":"" ?>>Otro</option>
        </Select>
        <?php };?>								
        </td>
        </tr>
                      <tr class="textosimple"><td></td><td></td><td><input align="right" class="botonXX"  name="modificar" type="button" value="GUARDAR"  onClick= "modificaApo(<?=$rut_apo;?>)"></td>
                      <td> &nbsp;&nbsp;
        <input align="right" class="botonXX"  name="volver" type="button" value="volver" onClick="ocultadiv2()" >     </td>
                     
                      </tr>
					  </table>
                      </form>
					</td></tr>
					</table>
					<br>
					
								
				<? } }?>	
