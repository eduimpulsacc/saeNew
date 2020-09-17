<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP          = 3;
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
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
	
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<link href="../../../estilos.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
           <? include("../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!-- codigho antiguo -->
								  
								  
	<?php //echo tope("../../../util/");?>
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD COLSPAN=5>
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
												if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
												}
												echo trim($fila1['nombre_instit']);
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
				<td colspan=5 align=right>
					<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
						<!--INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" onClick=document.location="seteaTelefono.php3?caso=2"-->
											<?php }?>
					<?php }//ACADEMICO Y LEGAL?>
					<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarEmpleado.php3">
				</td>
			</tr>
			<tr height="20" class="tableindex">
				<td align="middle" colspan="5">
					PERSONAL TOTAL DE LA INSTITUCION = 
						<?php
											$qry="SELECT COUNT(*) AS SUMA FROM TRABAJA WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila7 = @pg_fetch_array($result,0);	
													if (!$fila7){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila7['suma']);
												}
											}
										?>
						
				</td>
			</tr>
			<tr class="tablatit2-1">
				
      <td align="center" width="184"> <div align="center">NOMBRE </div></td>
				
      <td align="center" width="20"> <div align="center">CARGO </div></td>
				
      <td align="center" width="111"> <div align="center">TELEFONO 1 </div></td>
				
      <td align="center" width="110"> <div align="center">TELEFONO 2 </div></td>
								
      <td align="center" width="109"> <div align="center">TELEFONO 3 </div></td>


			</tr>
			<?php
				$qry="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.telefono,empleado.telefono2,empleado.telefono3, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.")) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";

				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
				}else{
					if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
						$fila1 = @pg_fetch_array($result,0);	
						if (!$fila1){
							error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
							exit();
						}
					}
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila1 = @pg_fetch_array($result,$i);
			?>
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaEmpleado.php3?empleado=<?php echo trim($fila1["rut_emp"]);?>&caso=1')>
							
      <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000"> 
        <strong><?php echo $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"];?></strong> 
        </font> </td>
							
      <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000"> 
        <strong>
        <?php
											switch ($fila1['cargo']) {
												 case 0:
													 imp('INDETERMINADO');
													 break;
												 case 1:
													 imp('Director');
													 break;
												 case 2:
													 imp('Jefe UTP');
													 break;
												 case 3:
													 imp('Enfermeria');
													 break;
												 case 4:
													 imp('Contador');
													 break;
												 case 5:
													 imp('Docente');
													 break;
											     case 6:
													 imp('Sub-Director');
												     break;
												 case 7:
													 imp('Inspector General');
													 break;
											 	 case 8:
													 imp('Titulacion');
													 break;
												 case 9:
													 imp('Curriculista');
													 break;
												 case 10:
													 imp('Evaluador');
													 break;
												 case 11:
													 imp('Orientador(a)');
													 break;
												 case 12:
													 imp('Sicopedagoga');
													 break;
												 case 13:
													 imp('Sicologo');
													 break;
												 case 14:
													 imp('Inspectora');
													 break;
												 case 15:
													 imp('Auxiliar');
													 break;
												 case 16:
													 imp('Coordinación CRA');
													 break;
												 case 17:
													 imp('Coordinación Pastoral');
													 break;
												 case 18:
													 imp('Coordinación ACLE');
													 break;
												 case 19:
													 imp('Secretaria');
													 break;
												 case 20:
													 imp('Tesorera');
													 break;
												 case 21:
													 imp('Asistente Social');
													 break;
											   	 case 22:
													 imp('Coordinación Mantenimiento');
													 break; 
											 			 };
										?>
        </strong> </font> </td>
							<td align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
										<?php echo $fila1["telefono"];?>
										
									</strong>
								</font>
							</td>
														<td align="left" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila1["telefono2"];?></strong>
								</font>
							</td>
														<td align="left" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila1["telefono3"];?></strong>
								</font>
							</td>
						</tr>
			<?php
					}
				}
			?>
			<tr>
				<td colspan="5">
				<hr width="100%" color="#0099cc">
				</td>
			</tr>
		</table>
	</center>

								  
								  <!-- codigo antiguo --></td>
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
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
