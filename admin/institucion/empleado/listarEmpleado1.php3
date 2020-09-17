<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP           =3;
	

	$sql="";
	$sql ="SELECT * FROM cargo";
	$Rs_Cargo =@pg_exec($conn,$sql);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

//-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../Sea/cortes/b_ayuda_r.jpg','../../../Sea/cortes/b_info_r.jpg','../../../Sea/cortes/b_mapa_r.jpg','../../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
		  <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> <? include("../../../cabecera/menu_superior.php"); ?></td>
        </tr>
        <tr align="left" valign="top"> 
          <td height="83" colspan="3">
		  		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
					  <? include("../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top">
					  	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!-- inicio codigo antiguo -->
								  
								  
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD COLSPAN=5>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>INSTITUCION</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
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
									</strong>								</FONT>							</TD>
						</TR>
					</TABLE>				</TD>
			</TR>
			<tr>
				<td colspan=4 align=right>
					<? if(($_PERFIL!=3)&&($_PERFIL!=4)&&($_PERFIL!=5)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=25)){ ?>
						<INPUT class="botonXX"  TYPE="button" value="AGREGAR" onClick=document.location="seteaEmpleado.php3?caso=2">
					<? }?>
					<? if ($_PERFIL == 0 OR $_PERFIL == 14){?>
					     <INPUT class="botonXX"  TYPE="button" value="CLAVES DE USUARIO" onClick=document.location="claves.php3?caso=4"> 
					<? } ?>				
				      <input class="botonXX" type="button" value="IMPRIMIR" onClick="MM_openBrWindow('Print_lista_empleado.php','','scrollbars=yes,resizable=yes,width=770,height=500')" >
					</td>
			</tr>
			<tr height="20" class="tableindex">
				<td align="middle" colspan="5">
					
						PERSONAL TOTAL DE LA INSTITUCION = 
						<?php
											 $qry="SELECT count(distinct(rut_emp)) AS SUMA FROM TRABAJA WHERE RDB=".$institucion; 
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
										?>				</td>
			</tr>
			<tr class="tablatit2-1">
				<td align="center" width="214">NOMBRE</td>
				<td align="center" width="72">
					RUT								</td>
				<td align="center" width="89">
					CARGO				</td>
								
     <td align="center" width="89"> FONOS </td>
     <td align="center" width="89"> MAIL </td>
			</tr>
			<?php
//				$qry="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.email, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.")) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
				$qry="SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.email, trabaja.cargo,empleado.telefono,empleado.telefono2,empleado.telefono3, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.")) order by ape_pat, ape_mat, nombre_emp asc, trabaja.cargo ";

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
				$rut_existe[]="";
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila1 = @pg_fetch_array($result,$i);
						if (in_array($fila1[rut_emp],$rut_existe)){}else{
						
						$rut_existe[]=$fila1[rut_emp];
					?>
					<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaEmpleado.php3?empleado=<?php echo trim($fila1["rut_emp"]);?>&caso=1')>
					
							<td align="left" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"];?></strong>								</font>							</td>
							<td align="left" ><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fila1["rut_emp"]." - ".$fila1["dig_rut"];?></strong></font></td>
							<td align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
										<?php
											
											
											//  for($a=0;$a<@pg_numrows($Rs_Cargo);$a++){
												//	$filsCargo = @pg_fetch_array($Rs_Cargo,$a);
													//if($fila1['cargo']==$filsCargo['id_cargo']){
														switch ($fila1[cargo]) {
																	 case 0:
																		 echo ('INDETERMINADO');
																		 break;
																	 case 1:
																		 echo('Director(a)');
																		 break;
																	 case 2:
																		 echo('Jefe UTP');
																		 break;
																	 case 3:
																		 echo('Enfermeria');
																		 break;
																	 case 4:
																		 echo('Contador');
																		 break;
																	 case 5:
																		 echo('Docente');
																		 break;
																	 case 6:
																		 echo('Sub-Director');
																		 break;
																   	 case 7:
																		 echo('Inspector General');
																		 break;
																 	 case 8:
																		 echo('Titulacion');
																		 break;
																	 case 9:
																		 echo('Curriculista');
																		 break;
																	 case 10:
																		 imp('Evaluador');
																		 break;
																	 case 11:
																		 echo('Orientador(a)');
																		 break;
																	 case 12:
																		 echo('Sicopedagogo(a)');
																		 break;
																	 case 13:
																		 echo('Sicologo(a)');
																		 break;
																	 case 14:
																		 echo('Inspector(a)');
																		 break;
																	 case 15:
																		 echo('Auxiliar');
																		 break;
																	 case 16:
																		 echo('Coordinación CRA');
																		 break;
																	 case 17:
																		 echo('Coordinación Pastoral');
																		 break;
																	 case 18:
																		 imp('Coordinación ACLE');
																		 break;
																	 case 19:
																		 echo('Secretaria');
																		 break;
															 		 case 20:
																		 echo('Tesorero(a)');
																		 break;
																	 case 21:
																		 echo('Asistente Social');
																		 break;
															    	 case 22:
																		 echo('Coordinación Mantenimiento');
																		 break;
																	 case 23:
																		 echo('Rector');
																		 break;
																	 case 24:
																		 echo('Administrativo');
																		 break;	 	 
																 };
														$flag=1;
												//	}
											//  }
										/*	  if($flag!=1){
												echo "INDETERMINADO";
											  }*/
											  //$query_trabaja2="select * from trabaja where rut_emp='$fila1[rut_emp'] and 
											/*switch ($fila1['cargo']) {
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
*/
										?>
										<?   $query_trabaja2="select * from trabaja where rut_emp='$fila1[rut_emp]' and rdb='$institucion' and cargo<>$fila1[cargo]";
												$result_trabaja2=pg_exec($conn,$query_trabaja2);
												$num_trabaja2=pg_numrows($result_trabaja2);
												if ($num_trabaja2!=0){
													$row_trabaja2=pg_fetch_array($result_trabaja2);
													echo ",";
														switch ($row_trabaja2[cargo]) {
																	 case 0:
																		 echo ('INDETERMINADO');
																		 break;
																	 case 1:
																		 echo('Director(a)');
																		 break;
																	 case 2:
																		 echo('Jefe UTP');
																		 break;
																	 case 3:
																		 echo('Enfermeria');
																		 break;
																	 case 4:
																		 echo('Contador');
																		 break;
																	 case 5:
																		 echo('Docente');
																		 break;
																	 case 6:
																		 echo('Sub-Director');
																		 break;
																   	 case 7:
																		 echo('Inspector General');
																		 break;
																 	 case 8:
																		 echo('Titulacion');
																		 break;
																	 case 9:
																		 echo('Curriculista');
																		 break;
																	 case 10:
																		 imp('Evaluador');
																		 break;
																	 case 11:
																		 echo('Orientador(a)');
																		 break;
																	 case 12:
																		 echo('Sicopedagogo(a)');
																		 break;
																	 case 13:
																		 echo('Sicologo(a)');
																		 break;
																	 case 14:
																		 echo('Inspector(a)');
																		 break;
																	 case 15:
																		 echo('Auxiliar');
																		 break;
																	 case 16:
																		 echo('Coordinación CRA');
																		 break;
																	 case 17:
																		 echo('Coordinación Pastoral');
																		 break;
																	 case 18:
																		 imp('Coordinación ACLE');
																		 break;
																	 case 19:
																		 echo('Secretaria');
																		 break;
															 		 case 20:
																		 echo('Tesorero(a)');
																		 break;
																	 case 21:
																		 echo('Asistente Social');
																		 break;
															    	 case 22:
																		 echo('Coordinación Mantenimiento');
																		 break;
																	 case 23:
																		 echo('Rector');
																		 break;
																	 case 24:
																		 echo('Administrativo');
																		 break; 	 	 
																 };
												}
												
										?>
									</strong>								</font>							</td>
							
							<td align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila1["telefono"]." - ".$fila1["telefono2"]." - ".$fila1["telefono3"];?></strong>								</font>							</td>
							<td align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila1["email"];?></strong>								</font>							</td>
						</tr>
			<?php
			}
					}
				}
			?>
			<tr>
				<td colspan="5">
				<hr width="100%" color="#0099cc">				</td>
			</tr>
		</table>
	</center>

								  
								  <!-- fin codigo antiguo --></td>
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
          <td width="53" align="left" valign="top" background="../../../Sea/<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
