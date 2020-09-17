<?php require('../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$empleado		=$_EMPLEADO;
	$_MDINAMICO     =0;
	$_POSP          =1;
//echo pg_dbname($conn);
		
	/*$sql_profjefe = "select rut_emp from supervisa where rut_emp = '$_NOMBREUSUARIO'"; // Profesor Jefe
	$res_profjefe = @pg_Exec($conn,$sql_profjefe);
	$num_profjefe = @pg_numrows($res_profjefe);*/
	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
    $perfil 		= $_PERFIL; 
	
    $usuarioensesion = $_USUARIOENSESION;
    ##Selecciono los datos para mostrar en el Diario Mural.


   if ($ano == NULL){
      $qry="SELECT * FROM ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
      //$qry="SELECT * FROM ano_escolar WHERE RDB=".$_INSTIT." AND SITUACION = 1";
      $result = @pg_Exec($conn,$qry);
      $fila = @pg_fetch_array($result,0);	
      $_ANO=$fila["id_ano"];
      $ano = $_ANO;      
   }


$sqlDiario = "select * from diario_mural where id_ano = $ano order by fecha_publi desc";
$rsDiario  = @pg_Exec($conn,$sqlDiario);


	
?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
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
<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              
			 
			   <tr align="left" valign="top"> 
                <td height="75" valign="top">
				
				    <?
			         include("../cabecera/menu_superior.php");
			        ?>
				
				</td>
              </tr>
			  </table>
              <tr align="left" valign="top"> 
                <td>
                 </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="362" align="left" valign="top">
					  
					   <!-- AQUI INSERTO EL MENÚ DINÁMICO -->
					   <?
						include("../menus/menu_lateral.php");
					   ?> 
					  
					  
                    </td>
                      <td width="73%" align="left" valign="top">
					  <table width="100%" border="1" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td align="left" valign="top">
							
							<!-- cuerpo de la pagina -->
							
							<table WIDTH="600" BORDER="0" align="center" CELLPADDING="3" CELLSPACING="1">
			<tr>
				<td colspan=4 align=left>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR >
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>USUARIO</strong>
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
											$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$_USUARIO;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
												}
											}
											
											$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$fila1['nombre_usuario']."";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												//error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila2 = @pg_fetch_array($result,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													
													echo trim($fila2['nombre_emp']." ".$fila2['ape_pat']." ".$fila2['ape_mat']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</td>
			</tr>
			<tr>
				<td align=center>
					<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
						<tr>
							<td colspan=4 align=right></td>
						</tr>
						<tr height="20" >
							<td align="middle" colspan="5" class="tableindex">
								CURSOS COMO PROFESOR JEFE
							</td>
						</tr>
						<tr bgcolor="#48d1cc">
							<td align="center" width="40" class="tablatit2-1">
								GRADO
							</td>
							<td align="center" width="40" class="tablatit2-1">
								LETRA
							</td>
							<td align="center" width="320" class="tablatit2-1">
								ENSEÑANZA
							</td>
							<td align="center" width="50" class="tablatit2-1">
								AÑO
							</td>
							<td align="center" width="150" class="tablatit2-1">
								INSTITUCION
							</td>
						</tr>
						<?php
							$qry="SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ano_escolar.nro_ano, institucion.nombre_instit, supervisa.rut_emp, ano_escolar_1.id_ano, institucion.rdb FROM institucion INNER JOIN (((tipo_ensenanza INNER JOIN (curso INNER JOIN supervisa ON curso.id_curso = supervisa.id_curso) ON tipo_ensenanza.cod_tipo = curso.ensenanza) INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) INNER JOIN ano_escolar AS ano_escolar_1 ON curso.id_ano = ano_escolar_1.id_ano) ON institucion.rdb = ano_escolar_1.id_institucion WHERE (((supervisa.rut_emp)=".$empleado.") and institucion.rdb = '".trim($institucion)."') ORDER BY curso.grado_curso ASC";
							
							$result =@pg_Exec($conn,$qry);
							if (!$result) {
								error('<B> ERROR :</b>Error al acceder a la BD. (52)</B>');
							}else{
								if (pg_numrows($result)!=0){
									/*$fila = @pg_fetch_array($result,0);	
									if (!$fila){
										error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
										exit();
									}*/
								//}
						?>
						<?php
								for($i=0 ; $i < @pg_numrows($result) ; $i++){
									$fila = @pg_fetch_array($result,$i);
									$sql="SELECT situacion FROM ano_escolar WHERE id_ano=" . $fila['id_ano'];
									$Rs_Ano = @pg_exec($conn,$sql);
									$fils = @pg_fetch_array($Rs_Ano,0);

									if($fils['situacion']==1){
						?>
									<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaDocente.php3?ano=<?php echo $fila['id_ano'];?>&institucion=<?php echo $fila['rdb'];?>&curso=<?php echo $fila['id_curso'];?>&caso=1&from=1&swa=0&ta=0&menu=5&categoria=19&nw=1')>
										<td align="center" >
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["grado_curso"];?></strong>
											</font>
										</td>
										<td align="center" >
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["letra_curso"];?></strong>
											</font>
										</td>
										<td align="left">
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["nombre_tipo"];?></strong>
											</font>
										</td>
										<td align="center">
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["nro_ano"];?></strong>
											</font>
										</td>
										<td align="center">
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["nombre_instit"];?></strong>
											</font>
										</td>
									</tr>
						<?php
	}
								}
							}
						}	
						?>
						<tr>
							<td colspan="5">
								<hr width="100%" color="#003b85">
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align=center height=10>
								<hr width="100%" color="#000000" height=50>
				</td>
			</tr>
			<tr>
				<td align=center>
					<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
						<tr height="20">
							<td align="middle" colspan="4" class="tableindex">
								SUBSECTOR COMO DOCENTE
							</td>
						</tr>
						<tr>
							<td align="center"  class="tablatit2-1">
								SUBSECTOR
							</td>
							<td align="center" class="tablatit2-1">
								CURSO
							</td>
							<td align="center" class="tablatit2-1">
								AÑO
							</td>
							<td align="center" class="tablatit2-1">
								INSTITUCION
							</td>
						</tr>
						<?php
						 $qry="SELECT empleado.rut_emp, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ano_escolar.nro_ano, institucion.nombre_instit, institucion.rdb, empleado.rut_emp, ramo.id_ramo, curso.id_curso, ano_escolar.id_ano, subsector.nombre, subsector.cod_subsector FROM (institucion INNER JOIN ((tipo_ensenanza INNER JOIN (((empleado INNER JOIN dicta ON empleado.rut_emp = dicta.rut_emp) INNER JOIN ramo ON dicta.id_ramo = ramo.id_ramo) INNER JOIN curso ON ramo.id_curso = curso.id_curso) ON tipo_ensenanza.cod_tipo = curso.ensenanza) INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON institucion.rdb = ano_escolar.id_institucion) INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((empleado.rut_emp)=".$empleado.") and institucion.rdb = '".trim($institucion)."') ORDER BY curso.ensenanza,curso.grado_curso,curso.letra_curso ASC";
							$result =@pg_Exec($conn,$qry);
							
							if (!$result) {
								error('<B> ERROR :</b>Error al acceder a la BD. (51)</B>');
							}else{
								if (pg_numrows($result)!=0){
									/*$fila = @pg_fetch_array($result,0);	
									if (!$fila){
										error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
										exit();
									}
								}*/
						?>
						<?php
								for($i=0 ; $i < @pg_numrows($result) ; $i++){
									$fila = @pg_fetch_array($result,$i);
									$sql="SELECT situacion FROM ano_escolar WHERE id_ano=" . $fila['id_ano'];
									$Rs_Ano = @pg_exec($conn,$sql);
									$fils = @pg_fetch_array($Rs_Ano,0);
                                    $_SESSION["verifi_rd"] =$fila['rdb'];
									if($fils['situacion']==1){
						?>
									<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaDocente.php3?ano=<?php echo $fila['id_ano']?>&institucion=<?php echo $fila['rdb']?>&curso=<?php echo $fila['id_curso']?>&ramo=<?php echo $fila['id_ramo']?>&cod_subsector=<?php echo $fila['cod_subsector']?>&caso=2&from=1&swa=1&ta=1&menu=6&categoria=3&item=3&nw=1')>

										<td align="left" >
										    <font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["nombre"];?></strong>
											</font>
										</td>
										<td align="center" >
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["grado_curso"]." - ".$fila["letra_curso"]." ".$fila["nombre_tipo"];?></strong>
											</font>
										</td>
										<td align="center">
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["nro_ano"];?></strong>
											</font>
										</td>
										<td align="center">
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["nombre_instit"];?></strong>
											</font>
										</td>
									</tr>
						<?php
	}
								}
							}
						}	
						?>
						<tr>
							<td colspan="4">
							<hr width="100%" color="#003b85">
							</td>
						</tr>
					</table>
				</td>
			</tr>
						
<!-- -->
<? if($_PERFIL==17){	?>
			<tr>
				<td align=center height=10>
								<hr width="100%" color="#000000" height=50>
				</td>
			</tr>
			<tr>
				<td height="174" align=center>
					<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
						<tr height="20">
							<td align="middle" colspan="4" class="tableindex">
								TALLER COMO DOCENTE
							</td>
						</tr>
						<tr>
							<td align="center"  class="tablatit2-1">
								TALLER
							</td>
							<td align="center" class="tablatit2-1">
								AÑO
							</td>
							<td align="center" class="tablatit2-1">
								INSTITUCION
							</td>
						</tr>
<?						$sql_taller = "SELECT * FROM taller t INNER JOIN dicta_taller dt ON t.id_taller=dt.id_taller INNER JOIN ano_escolar a ON a.id_ano=t.id_ano INNER JOIN institucion i ON i.rdb=t.rdb WHERE t.rdb=".$institucion." AND t.id_ano=".$ano." AND dt.rut_emp=".$empleado; 
							$result_taller =@pg_Exec($conn,$sql_taller);
							if (!$result_taller) {
								error('<B> ERROR :</b>Error al acceder a la BD. (55)</B>');
							}else{
								if (pg_numrows($result_taller)!=0){
									for($i=0 ; $i < @pg_numrows($result_taller) ; $i++){
										$fila = @pg_fetch_array($result_taller,$i);	?>

										<tr  onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('../admin/institucion/ano/curso/ramo/seteaTaller.php3?taller=<?php echo $fila["id_taller"];?>&caso=1&ano=<?php echo $ano; ?>&menu=6&categoria=3&item=3&nw=1')>
											<td align="left" >
												<font face="arial, geneva, helvetica" size="1" color="#000000">
													<strong><?php echo $fila["nombre_taller"];?></strong>
												</font>
											</td>
											<td align="center">
												<font face="arial, geneva, helvetica" size="1" color="#000000">
													<strong><?php echo $fila["nro_ano"];?></strong>
												</font>
											</td>
											<td align="center">
												<font face="arial, geneva, helvetica" size="1" color="#000000">
													<strong><?php echo $fila["nombre_instit"];?></strong>
												</font>
											</td>
										</tr>
										
<?									}								
								}
							}	?>
					</table>
				</td>
				</tr>
<? 
/*
if($institucion == 24988 or $institucion == 14629 or $institucion == 769 or $institucion == 8933 or $institucion == 14912 or $institucion == 9239 or $institucion == 9035 $institucion == 1961 ){  // Subsector como ayudante *vel*
*/
 
	$emp = trim($empleado);
	$qry_ayudante = "SELECT * FROM ayuda where rut_emp = '".trim($emp)."'"; // Reviso si el empleado es ayudante de algun curso
	$res_ayudante = @pg_Exec($conn,$qry_ayudante);
	if(pg_numrows($res_ayudante)>0)
	{		
	?>

			<tr>
				<td align=center height=10>
								<hr width="100%" color="#000000" height=50>
				</td>
			</tr>
<tr>
				<td height="174" align=center><table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
                  <tr height="20">
                    <td align="middle" colspan="4" class="tableindex"> SUBSECTOR COMO AYUDANTE </td>
                  </tr>
                  <tr>
                    <td align="center"  class="tablatit2-1"> SUBSECTOR </td>
                    <td align="center" class="tablatit2-1"> CURSO </td>
                    <td align="center" class="tablatit2-1"> A&Ntilde;O </td>
                    <td align="center" class="tablatit2-1"> INSTITUCION </td>
                  </tr>
                  <?php
							 $qry="SELECT empleado.rut_emp, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ano_escolar.nro_ano, institucion.nombre_instit, institucion.rdb, empleado.rut_emp, ramo.id_ramo, curso.id_curso, ano_escolar.id_ano, subsector.nombre, subsector.cod_subsector FROM (institucion INNER JOIN ((tipo_ensenanza INNER JOIN (((empleado INNER JOIN ayuda ON empleado.rut_emp = ayuda.rut_emp) INNER JOIN ramo ON ayuda.id_ramo = ramo.id_ramo) INNER JOIN curso ON ramo.id_curso = curso.id_curso) ON tipo_ensenanza.cod_tipo = curso.ensenanza) INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON institucion.rdb = ano_escolar.id_institucion) INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((empleado.rut_emp)=".$empleado.") and institucion.rdb = '".trim($institucion)."') ORDER BY curso.grado_curso ASC";
							$result =@pg_Exec($conn,$qry);
							
							if (!$result) {
								error('<B> ERROR :</b>Error al acceder a la BD. (51)</B>');
							}else{
								if (pg_numrows($result)!=0){
									/*$fila = @pg_fetch_array($result,0);	
									if (!$fila){
										error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
										exit();
									}
								}*/
						?>
                  <?php
								for($i=0 ; $i < @pg_numrows($result) ; $i++){
									$fila = @pg_fetch_array($result,$i);
									$sql="SELECT situacion FROM ano_escolar WHERE id_ano=" . $fila['id_ano'];
									$Rs_Ano = @pg_exec($conn,$sql);
									$fils = @pg_fetch_array($Rs_Ano,0);

									if($fils['situacion']==1){
						?>
                  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaDocente.php3?ano=<?php echo $fila['id_ano']?>&institucion=<?php echo $fila['rdb']?>&curso=<?php echo $fila['id_curso']?>&ramo=<?php echo $fila['id_ramo']?>&cod_subsector=<?php echo $fila['cod_subsector']?>&caso=2&from=1&swa=1&ta=1&menu=6&categoria=3&item=3&nw=1')>
                    <td align="left" ><font face="arial, geneva, helvetica" size="1" color="#000000"> <strong><?php echo $fila["nombre"];?></strong> </font> </td>
                    <td align="center" ><font face="arial, geneva, helvetica" size="1" color="#000000"> <strong><?php echo $fila["grado_curso"]." - ".$fila["letra_curso"]." ".$fila["nombre_tipo"];?></strong> </font> </td>
                    <td align="center"><font face="arial, geneva, helvetica" size="1" color="#000000"> <strong><?php echo $fila["nro_ano"];?></strong> </font> </td>
                    <td align="center"><font face="arial, geneva, helvetica" size="1" color="#000000"> <strong><?php echo $fila["nombre_instit"];?></strong> </font> </td>
                  </tr>
                  <?php
	}
								}
							}
						}	
						?>
                  <tr>
                    <td colspan="4"><hr width="100%" color="#003b85">
                    </td>
                  </tr>
                </table></td>
				</tr>											
<?	 //}	
}		
			} ?>						
<!-- -->						
						
		</table>
		
		
		
							
							
							
							
							</td>
                          </tr>                          
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 - Desarrolla Colegio Interactivo</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
