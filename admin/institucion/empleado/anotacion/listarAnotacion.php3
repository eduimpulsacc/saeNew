<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$empleado		=$_EMPLEADO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$alumno			=$_ALUMNO;
	$_POSP          = 4;
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
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		
	
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<link href="../../../../estilos.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../Sea/cortes/b_ayuda_r.jpg','../../../../Sea/cortes/b_info_r.jpg','../../../../Sea/cortes/b_mapa_r.jpg','../../../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!-- codigo nuevo -->
								  
								  
								  
	<?php //echo tope("../../../../util/");?>
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD COLSPAN=3>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
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
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
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
									<strong>EMPLEADO</strong>
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
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												$fila1 = @pg_fetch_array($result,0);	
												if (!$fila1){
													error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
													exit();
												}
												echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_emp']);
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<tr>
				<td colspan=3 align=right>
					         
					<?php if($_PERFIL==17){ //DOCENTE?>									
							<INPUT class="botonXX"  TYPE="button" value="AGREGAR" onClick=document.location="listarAno.php3">
					<?php }?>									
									<?php if($_PERFIL==17){ //DOCENTE?>									
						<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="../../ano/curso/alumno/alumno.php3">
					<?php }else{ ?>
					<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="../seteaEmpleado.php3?caso=4">
					<?php }?>									
				</td>
			</tr>
			<tr height="20" class="tableindex">
				<td align="middle" colspan="3">
					ANOTACIONES
				</td>
			</tr>
			<tr class="tablatit2-1">
				<td align="center" width="150">
					FECHA
				</td>
				<td align="center" width="300">
					ALUMNO
				</td>
				<td align="center" width="150">
					TIPO
				</td>
			</tr>
			<?php
				$qry="SELECT alumno.rut_alumno, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, anotacion.tipo, anotacion.fecha, anotacion.id_anotacion, empleado.rut_emp, anotacion.tipo_conducta FROM (empleado INNER JOIN anotacion ON empleado.rut_emp = anotacion.rut_emp) INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno, ano_escolar INNER JOIN institucion ON ano_escolar.id_institucion = institucion.rdb WHERE (((empleado.rut_emp)=".$empleado.")) and anotacion.fecha between ano_escolar.fecha_inicio and ano_escolar.fecha_termino group by alumno.rut_alumno, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, anotacion.tipo, anotacion.fecha, anotacion.id_anotacion, empleado.rut_emp, anotacion.tipo_conducta order by anotacion.fecha ASC";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
				}else{
				if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
					$fila = @pg_fetch_array($result,0);	
					if (!$fila){
						error('<B> ERROR :</b>Error al acceder a la BD. (8) No hay alumnos inscritos en este curso</B>');
						exit();
					}
				}
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
						if ($fila['tipo_conducta']==1)
							$tipo_conducta = " - Positiva";
						if ($fila['tipo_conducta']==2)
							$tipo_conducta = " - Negativa";
			?>
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaAnotacion.php3?alumno=<?php echo trim($fila["rut_alumno"]);?>&anotacion=<?php echo $fila["id_anotacion"];?>&caso=1')>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php impF($fila["fecha"]);?></strong>
								</font>
							</td>
							<td align="left" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["ape_pat"]." ".$fila["ape_mat"].", ".$fila["nombre_alu"];?></strong>
								</font>
							</td>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
										<?php 
											switch ($fila['tipo']) {
												 case 0:
													 imp('INDETERMINADO');
													 break;
												 case 1:
													 imp("Conductas".$tipo_conducta);
													 break;
												 case 2:
													 imp('Atraso');
													 break;
												 case 3:
													 imp('Inasistencia');
													 break;
												 case 4:
													 imp('Enfermería');
													 break;
											 };
										?>
									</strong>
								</font>
							</td>
						</tr>
			<?php
					}
				}
			?>
			<tr>
				<td colspan="3">
				<hr width="100%" color="#003b85">
				</td>
			</tr>
		</table>
	</center>

								  
								  <!-- codigo nuevo --></td>
                                </tr>
                              </table></td>
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
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
