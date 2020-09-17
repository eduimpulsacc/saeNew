<?php 

require('../../../../../util/header.inc');?>

<?php 
	$institucion	=$_INSTIT;
echo    $anotacion1		=$_ANOTACION1;
	
	$alumno			=$_ALUMNO;
	$desde			=$_DESDE;
	$frmModo		=$_FRMMODO;
	$_POSP          =4;
	$actualiza 		=$_GET['actualiza'];   

	$tipo_anotacion=$_POST['tipo_anotacion'];
	$cmb_periodos=$_GET['cmb_periodos'];
	$cambio_cmb=$_GET['cambio_cmb'];
        
	
	/*
	if ($_PERFIL == 0 or $_PERFIL == 17 or $_PERFIL == 14){		
		$_FRMMODO	=	"eliminar";
		   if(!session_is_registered('_FRMMODO')){
			  session_register('_FRMMODO');
			
		   };
		
    }		*/
		
		$_DESDE	=	"alumno";
		if(!session_is_registered('_DESDE')){
			session_register('_DESDE');
		};
?>
<SCRIPT language="JavaScript">


	function Confirmacion(){
		if(confirm('¿ESTA SEGURO DE ELIMINAR ESTOS DATOS?') == false){ return; };
			document.location="procesoAnotacion.php3?desde=$desde&elimina=1>"
		};
		
		
		
	function enviapag(form){
	form.action = 'mostrarAnotacion.php?actualiza=1';
	form.submit(true);
}		

	function enviapag2(form){
	periodo=cmb_periodos.options[cmb_periodos.selectedIndex].value;
	form.action = 'mostrarAnotacion.php?tipo_hoja=&ano=<?echo $ano;?>&curso=<?echo $curso;?>&tipo_anotacion=<?echo $tipo_anotacion;?>&cmb_periodos='+periodo+'&c_alumno=<?echo $alumno;?>&actualiza=1&cambio_cmb=1';
	form.submit(true);
}




function valida(form){	
				if(cmb_periodos.options[cmb_periodos.selectedIndex].value==0){
						alert('Debe seleccionar PERIODO.');
						return false;
				};
				
				
				if(sigla_subsector.options[sigla_subsector.selectedIndex].value==0){
						alert('Debe seleccionar SUBSECTOR APRENDIZAJE.');
						return false;
				};
				
				
				if(tipo_anotacion.options[tipo_anotacion.selectedIndex].value==0){
						alert('Debe Seleccionar TIPO ANOTACIÓN.');
						return false;
				};
				
				
				if(detalle_anotaciones.options[detalle_anotaciones.selectedIndex].value==0){
						alert('Debe Seleccionar SUB TIPO.');
						return false;
				};
				
			

				if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					return false;
				};

				if(!chkFecha(form.txtFECHA,'Fecha inválida.')){
					return false;
				};

						
				frm.action='procesoAnotacion.php3?caso=2&frmModo=modificar';
			frm.submit(true);	
				
				
			}
</SCRIPT>

<?php
		$qry="SELECT * FROM ANOTACION1 WHERE ID_ANOTACION =".$anotacion1;
		$result =@pg_Exec($conn,$qry);
		
		
		if (!$result) {
			
			error('<B> ERROR :</b>Error al acceder a la BD. (1333)</B>');
			
		}else{
		
			if (pg_numrows($result)!=0){
		
				$fila = @pg_fetch_array($result,0);	
		
				if (!$fila){
					
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					//exit();
				}
			}
		}
		$empleado = $fila['rut_emp'];
		
		
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
//-->
</script>
<LINK REL="STYLESHEET" HREF="../../../../../util/td.css" TYPE="text/css">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','.../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include ("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? 
						$menu_lateral="3_1";
						include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390"><!-- inicio codigo antiguo -->
								  
								  
								  
								  
	<FORM method=post name="frm" action="procesoAnotacion.php3?desde=<?php echo $desde?>">
	<?php 
		echo "<input type=hidden name=rut value=".$alumno.">";
		echo "<input type=hidden name=emp value=".$empleado.">";
	
	
	if($actualiza==0){
	?>
		<TABLE WIDTH=90% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>INSTITUCION</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>RESPONSABLE</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php

												$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$empleado;
												$result =pg_Exec($conn,$qry);
												$fila1 = pg_fetch_array($result,0);
												echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_emp']);

										?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>ALUMNO</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']);
												}
											}
										?>
									</strong>
								</FONT>   
							</TD>
						</TR>
					</TABLE> 
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=2 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
								<!--?php if(($_PERFIL!=8)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?-->
											<!--?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?-->
											<?php if (($_PERFIL==14) or ($_PERFIL==8) or ($_PERFIL==9) or ($_PERFIL==0) or ($_PERFIL==19)){?>											
											      <INPUT class="botonXX"  TYPE="button" value="MODIFICAR"  name="MODIFICAR" onClick="enviapag(this.form);" >
											<? } ?>
											
											<?php if (($_PERFIL==14) or ($_PERFIL==8) or ($_PERFIL==9) or ($_PERFIL==0) or ($_PERFIL==17) or ($_PERFIL==19)){?>
												<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick="Confirmacion()">&nbsp;
											<?php }else{?>
												<!--INPUT  TYPE="button" value="ELIMINAR"  name=btnEliminar disabled-->&nbsp;
											<?php }?>
								<?php //if ($_DESDE!=""){ ?>
								<!--INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="../../ano/curso/alumno/anotacion/listarAnotacion.php3"-->&nbsp;
								<?php // }else {?>

						        <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick="window.history.go(-1)">
	  
						
								<?php //} ?>							</TD>
						</TR>
						<TR height=20 class="tableindex">
							<TD align=middle colspan=2>
								ANOTACION							</TD>
						</TR>
						<TR>
							<TD width=40% class="cuadro02">FECHA</TD>
							<TD width="60%" align="left" class="cuadro01"><?php 
																impF($fila['fecha']);
														?></TD>
						</TR>
						
						<TR>
						  <TD width="40%" class="cuadro02">SUBSECTOR APRENDIZAJE</TD>
						  <TD width="60%" align="left" class="cuadro01">&nbsp;<?php 
												// busco la sigla
	$sigla_aux = $fila["sigla"];	
												
												
$q1 = "select * from sigla_subsectoraprendisaje where id_sigla = '$sigla_aux'";
	$r1 = @pg_Exec($conn,$q1);
	$f1 = @pg_fetch_array($r1,0);
	$detalle_sigla = $f1['detalle'];
																					
												
	echo $f1["sigla"];?> - <? echo $detalle_sigla; ?>  </TD>
					  </TR>
						<TR>
							<TD width=40% class="cuadro02">TIPO DE ANOTACI&Oacute;N </TD>
							<TD width="60%" align="left" class="cuadro01">&nbsp;<?php
												   $cod_ta = $fila["codigo_tipo_anotacion"];
												   
$q1 = "select * from tipos_anotacion where id_tipo = '$cod_ta'";
		$r1 = @pg_Exec($conn,$q1);
		$f1 = @pg_fetch_array($r1,0);
													
		$codta       = $f1['codtipo'];
		$descripcion	= $f1['descripcion'];
																															
		echo "$codta - $descripcion";  ?></TD>
						</TR>
						<TR>
							<TD width=40% class="cuadro02">SUB-TIPO </TD>
							<TD width="60%" align="left" class="cuadro01">&nbsp;<?php 
												   $codigo_anotacion = $fila["codigo_anotacion"];
												
$q1 = "select * from detalle_anotaciones  where id_tipo = '$cod_ta' and codigo = '$codigo_anotacion'";
												   $r1 = @pg_Exec($conn,$q1);
												   $f1 = @pg_fetch_array($r1,0);
												   
												   $detalle = $f1["detalle"];
												   
												   echo "$codigo_anotacion - $detalle";
												
												   ?></TD>
						</TR>
						
							<TR>
								<TD width=40% class="cuadro02">OBSERVACI&Oacute;N</TD>
								<TD width="60%" align=left class="cuadro01"><?php 
													imp($fila['observacion']);
											?></TD>
							</TR>
							<TR>
								<TD colspan=4>
									<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
										<TR>
											<TD>
												<HR width="100%" color=#003b85>											</TD>
										</TR>
									</TABLE>								</TD>
							</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
		
		
		<? }
		
		
		
		if($actualiza==1){
		
		
		$sql = "SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano;
		$result_peri = @pg_exec($conn,$sql);
		
		$sql1 = "SELECT periodo.id_periodo,periodo.nombre_periodo FROM periodo INNER JOIN anotacion ON (periodo.id_periodo=anotacion.id_periodo) WHERE periodo.id_ano=".$ano." AND anotacion.id_anotacion=".$anotacion1;
		$result_peri1 = @pg_exec($conn,$sql1);
		$fila_p = @pg_fetch_array($result_peri1,0);

		

		?>
		
		
		
		
	
		<table width="100%" border="0" cellpadding="5" cellspacing="0">
								<div align="right"><input class="botonXX" type="button" value="GUARDAR"   name="btnGuardar1" onClick="valida(this.form);" > <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick="window.history.go(-2)"></div>
								<tr>
								  <td width="30%" class="Estilo3"><font face="Geneva, Arial, Helvetica" color=#000000>PERIODO</font></td>
								  <td width="70%"><select name="cmb_periodos" id="cmb_periodos" class="ddlb_9_x Estilo2">
                                    <option value=0 selected>(Seleccione Periodo)</option>
                                    <?
										
										
										  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
										  {
										  $fila1 = @pg_fetch_array($result_peri,$i); 
										  
										
										 if($cambio_cmb!=1){ 
										  if ($fila1['id_periodo']==$fila_p['id_periodo']){
											echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
											
										  }else{
											echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
										  }
										  
										}else{  
										  
										    if ($fila1['id_periodo']==$cmb_periodos){
											echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
											
										  }else{
											echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
										  }
										  
										}  
										  
										  ?>
                                    <? } 
									
									
									
									?>
									
									
                                  </select> 
								    <span class="Estilo7">(*)								    </span></td>
								</tr>
								
								
								
							
								
								<tr>
								  <td width="30%" class="Estilo3">SECTOR DE APRENDIZAJE </td>
								  <td width="70%" class="Estilo2">
								    <label>
									<?
$q100 = "select * from sigla_subsectoraprendisaje where rdb = '$institucion' order by detalle";
									 $r100 = pg_Exec($conn,$q100);
									 $n100 = pg_numrows($r100);
									  
									 ?> 
									
								    <select name="sigla_subsector" id="sigla_subsector">
									  <option value="0">Seleccione Sector de Aprendizaje </option>
									  <?
									  
								
									  $j = 0;
									  while ($j < $n100){
									       $f100 = pg_fetch_array($r100,$j);
										   $sigla    = $f100['sigla'];
										   $detalle  = $f100['detalle'];
										   $id_sigla = $f100['id_sigla'];
										    
										   
										    if($cambio_cmb!=1){ 
										  if ($id_sigla==$fila['sigla']){
											echo  "<option selected value=".$id_sigla." >".$detalle." - ".$sigla."</option>";
											
										  }else{
											echo  "<option value=".$id_sigla." >".$detalle." - ".$sigla."</option>";
										  }
										  
										}else{  
										  
										    if ($id_sigla==$sigla_subsector){
											echo  "<option selected value=".$id_sigla." >".$detalle." - ".$sigla."</option>";
											
										  }else{
											echo  "<option value=".$id_sigla." >".$detalle." - ".$sigla."</option>";
										  }
										  
										} 
										 
										   
										   $j++;
									  }
									 
									  
									  ?>									
								      </select>
								    </label>
								  </td>
								</tr>
								<tr>
								  <td width="30%" class="Estilo3">TIPO ANOTACION </td>
								  <td width="70%" class="Estilo2">
								     <?
									
									  $q200 = "select * from tipos_anotacion where rdb = '$institucion'";
									  $r200 = pg_Exec($conn,$q200);
									  $n200 = pg_numrows($r200);								 
									 ?>
									  
								
								    <select name="tipo_anotacion" id="tipo_anotacion" onChange="enviapag2(this.form);">
									  <option value="0">Seleccione Tipo de Anotaci&oacute;n </option>
									  <?									
									
									  $k = 0;
									  while ($k < $n200){
									       $f200 = pg_fetch_array($r200,$k);
                                           $id_tipo = $f200['id_tipo'];
										   $codtipo = $f200['codtipo'];
										   $descripcion = $f200['descripcion'];
										   				   
										   if($cambio_cmb!=1){
										   if ($id_tipo==$fila['codigo_tipo_anotacion']){
											echo  "<option selected value=".$id_tipo." >".$codtipo." - ".$descripcion."</option>";
											
										  }else{
											echo  "<option value=".$id_tipo." >".$codtipo." - ".$descripcion."</option>";
										  }
										   
										   
										  }else{ 
										    if ($id_tipo==$tipo_anotacion){
											echo  "<option selected value=".$id_tipo." >".$codtipo." - ".$descripcion."</option>";
											
										  }else{
											echo  "<option value=".$id_tipo." >".$codtipo." - ".$descripcion."</option>";
										  }
										  }
										   
										   $k++;
									  }						  
									
									    
								     ?>
									</select>
									
								  </td>
								  </tr>
                               
								<tr>
								  <td width="30%" class="Estilo3">SUB TIPO </td>
								  <td width="70%" class="Estilo2">
								    <?
									
if($cambio_cmb==1){
$q300 = "select * from detalle_anotaciones where id_tipo = '".trim($tipo_anotacion)."' order by codigo";								}else{
$q300 = "select * from detalle_anotaciones where id_tipo = '".$fila['codigo_tipo_anotacion']."' order by codigo"; 							  }
$r300 = @pg_Exec($conn,$q300);
$n300 = @pg_numrows($r300);
									
									?>
									<select name="detalle_anotaciones" id="detalle_anotaciones">
									   <option value="0">Seleccione Sub-Tipo de Anotaci&oacute;n</option>
									  
									 <?								
									 
																  
									  $l = 0;
									  while ($l < $n300){
									       $f300 = pg_fetch_array($r300,$l);
										   $codigosubtipo  = $f300['codigo'];
										   $detallesubtipo = $f300['detalle'];
										   
										   if ($codigosubtipo!=NULL){
										       
											   
											    if ($codigosubtipo==$fila['codigo_anotacion']){
											echo  "<option selected value=".$codigosubtipo." >".$codigosubtipo." - ".$detallesubtipo."</option>";
											
										  }else{
											echo  "<option value=".$codigosubtipo." >".$codigosubtipo." - ".$detallesubtipo."</option>";
										  }

										       
										   }	   
										   $l++;
									  }		  	 
										 
										 
									
									 ?>	   
                                    </select>
								  </td>
								  </tr>
								  
						 
								<tr>
								  <td width="30%" class="Estilo3">FECHA</td>
								  <td width="70%" class="Estilo2">
								    <label>
									<? 
									
									$dd = substr($fila['fecha'],0,4);
			  						$mm = substr($fila['fecha'],5,2);
									$aa = substr($fila['fecha'],8,2);
			   						$fecha = "$aa-$mm-$dd";
									
									?>
								    <INPUT type="text" name="txtFECHA" id="txtFECHA" size=10 maxlength=10 value="<? echo $fecha;?>">
								    <span class="Estilo7">(*)</span>								    <br>
										<FONT face="arial, geneva, helvetica" size=1 color=#000000>
											<STRONG>(DD-MM-AAAA)</STRONG>										</FONT>								    </label>
								  </td>
								  </tr>
								<tr>
								  <td width="30%" class="Estilo3">OBSERVACI&Oacute;N</td>
								  <td width="70%" class="Estilo2">
								    <textarea name="txtOBS" id="txtOBS" cols="40" rows="5"><? echo $fila['observacion'];?></textarea>
								  </td>
								  </tr>
								  
								<tr>
								  <td colspan="2"><div align="center" class="Estilo13">(*) Datos obligatorios </div></td>
								  </tr>  
							  </table>
							  
							  <? }?>
	</FORM>

								  
								  
								  
								  
								  
								  
								  <!-- fin codigo antiguo--></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><div align="center">SAE 
                          Sistema de Administraci&oacute;n Escolar - 2005 - Desarrolla 
                          Colegio Interactivo</div></td>
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
