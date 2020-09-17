<?php 
require('../util/header.inc');
require('../util/funciones_new.php'); 

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$frmModo		="mostrar";

	// REGISTRO DE HISTORIAL DE NAVEGACION
	registrarnavegacion($_USUARIO,'FICHA CONTENIDOS DISPONIBLES',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);
	//******************************************************//
	


	if($frmModo!="ingresar"){
		$qry="SELECT * FROM FICHA_DEPORTIVA WHERE ID_ANO=".$ano." AND RUT_ALUMNO=".$alumno;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO ?>" rel="stylesheet" type="text/css">
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
		
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtANO,'Ingresar A�O.')){
					return false;
				};

				return true;
			}
		</SCRIPT>
<?php }?>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg','../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->
								  
								  
								  
								  
								  
								  
								  
								  
								  
<script>
 function downloadme(x){
    myTempWindow = window.open(x,"","left=10000,screenX=10000");
    myTempWindow.document.execCommand("SaveAs","null",x);
    myTempWindow.close();
}
</script>



	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=idFicha value=".$fila['id_ficha'].">"
	?>
	<TABLE WIDTH=100% align="center" cellpadding="0" cellspacing="0" background="../imagenes/background.gif">
  <!--<TR> 
      <TD height="99"> 
        <div align="center"><img src="imagenes/superior_contenidos.gif" height="99" width="600"></div></TD>
  </TR>-->
</TABLE>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 width=100%>
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
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
							<td rowspan=4>
								<TABLE BORDER=3 CELLSPACING=5 CELLPADDING=5>
									<TR>
										<TD>
											<?php
												$sql_arr = "select * from alumno where rut_alumno= '$alumno'";
												$result = pg_Exec($conn,$sql_arr);												
												$arr=pg_fetch_array($result);
																								/*
 												$output= "select lo_export('/opt/www/newsae/infousuario/images/".$arr[rut_alumno]."');";
												$retrieve_result = @pg_exec($conn,$output);
												$retrieve_result;
											if (!$retrieve_result){ */												
												$nombre_archivo = '../infousuario/images/'.$arr[rut_alumno];																																		 

												if (file_exists($nombre_archivo)) {?>
												   <img src="../infousuario/images/<?php echo $arr[rut_alumno]?>" ALT="NO DISPONIBLE" width=150></p>
											<?	} else { ?>
												   <img src="apoderado/imag/alumno222.jpg" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="180" height="220" id="ALUMNO">
											<?	}?>
										</TD>
									</TR>
								</TABLE>
							</td>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>A&Ntilde;O ESCOLAR</strong>
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
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
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
									<strong>CURSO</strong>
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
						 	// --- se agrego al query "tipo_ensenanza.cod_tipo" (pmeza) -----------
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo,tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
							// ---------------------------------------------------------------------
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													$tipo=$fila1['cod_tipo'];
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
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat'])." ".trim($fila1['nombre_alu']);
													
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
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=3 CELLPADDING=3 height="100%">
        <!--<TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="mostrar"){ ?>
									<INPUT TYPE="button" value="FICHA DEPORTIVA"  class="button" onClick=document.location="fichaDeportiva.php3">
									<INPUT TYPE="button" value="FICHA MEDICA"  class="button"onClick=document.location="seteaFichaMed.php3">
									<INPUT TYPE="button" value="FICHA ALUMNO"  class="button"onClick=document.location="fichaAlumno.php3">
									<INPUT TYPE="button" value="FICHA APODERADOS"  class="button"onClick=document.location="fichaApoderados.php3">
									<INPUT TYPE="button" value="SALIR"  class="button" onClick="window.open('../util/logout.php3', '_parent')">
								<?php };?>
							</TD>
						</TR>-->
        <TR height=20 >
							
          <TD colspan=2 align=middle class="tableindex"> FICHA CONTENIDOS DISPONIBLES</TD>
						</TR>

						<TR>
							<TD>
								<TABLE width=100% Border=0 cellpadding=0 cellspacing=0>
									<TR>
										
										<TD>
                                        
                                        
                                        <TABLE width=100%  Border=0 cellpadding=1 cellspacing=0>
                                        	<TR>
											  <TD align=left height=10 class="textoNegrita">&nbsp;FECHA</TD>
											  <TD align=left class="textoNegrita">&nbsp;NOMBRE ARCHIVO</TD>
											  <TD align=left class="textoNegrita">&nbsp;DESCARGAR</TD>
											 </TR>
											<!--SUBSECTORES DEL ALUMNO-->
											<?php
												//TOTAL DE RAMOS INGRESADOS
												if($_PERFIL!=15 && $_PERFIL!=16){
												$qryX="SELECT * FROM archivos_publicos WHERE id_ano=".$ano." " ;
}
else{
$qryX="select * from archivos_publicos ap inner join archivos_publicos_vista apv on apv.id_archivo = ap.id_archivo where apv.id_curso =$curso";
}

//echo $qryX;
												$resultX =@pg_Exec($conn,$qryX);
												if(pg_numrows($resultX)!=0){
													for($i=0 ; $i < @pg_numrows($resultX) ; $i++){
														$filaX = @pg_fetch_array($resultX,$i);
											?>
												
													<TR>
														<TD align=left height=10><?=$filaX['fecha'];?>
															
														</TD>
														<TD align=left>&nbsp;<FONT face="arial, geneva, helvetica" size=1 >
																<STRONG>&nbsp;&nbsp;
																	<?php echo $filaX['observacion'];?>
																</STRONG>
															</FONT></TD>
														<TD align=left>&nbsp;<a href="../admin/institucion/ano/archivos_publicos/archivos/<?=$filaX['nombre_archivo'];?>" target="_blank"><img src="../util/disk2.png"  width=30 border="0"></a></TD>
													</TR>
													
													<!--ARCHIVOS DEL SUBSECTOR-->
													
												
											<?php
													}
												}
											?>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD colspan=3>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#0099cc>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR height=15>
							<TD width="100%" colspan=2 ALIGN=CENTER>
								<FONT face="arial, geneva, helvetica" size=2 COLOR=RED>&nbsp;
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
				</TD>	
			</TR>
		</TABLE>
	</CENTER>









								  
								  
								  
								  
								  
								  
								  
								  
								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 - Desarrolla Colegio 
                        Interactivo</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
