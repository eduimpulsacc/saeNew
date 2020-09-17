<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$anotacion		=$_ANOTACION;
	$alumno			=$_ALUMNO;
	$desde			=$_DESDE;
	$_POSP          =4;
	
	
	/**********VARIABLES HOJA DE VIDA********************/
	$c_ano = $_GET['c_ano'];
	$c_curso = $_GET['c_curso'];
	$tipo_hoja = $_GET['tipo_hoja'];
	/*****************************/
        
	if ($_PERFIL == 0 or $_PERFIL == 17 or $_PERFIL == 14){		
		$_FRMMODO	=	"eliminar";
		   if(!session_is_registered('_FRMMODO')){
			  session_register('_FRMMODO');
			
		   };
		
    }		
		
		$_DESDE	=	"alumno";
		if(!session_is_registered('_DESDE')){
			session_register('_DESDE');
		};
?>
<SCRIPT language="JavaScript">
	function Confirmacion(){
		if(confirm('¿ESTA SEGURO DE ELIMINAR ESTOS DATOS?') == false){ return; };
			document.location="procesoAnotacion.php3?desde=$desde&tipo_hoja=<?=$tipo_hoja?>&c_ano=<?=$c_ano?>&c_curso=<?=$c_curso?>"
		};
</SCRIPT>

<?php
		$qry="SELECT * FROM ANOTACION WHERE ID_ANOTACION=".$anotacion;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1333)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
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
<LINK REL="STYLESHEET" HREF="../../../../util/td.css" TYPE="text/css">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include ("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? 
						$menu_lateral="3_1";
						include("../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390"><!-- inicio codigo antiguo -->
								  
								  
								  
								  
	<FORM method=post name="frm" action="../../../../procesoAnotacion.php3?desde=<?php echo $desde?>">
	<?php 
		echo "<input type=hidden name=rut value=".$alumno.">";
		echo "<input type=hidden name=emp value=".$empleado.">";
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
											      <INPUT class="botonXX"  TYPE="button" value="MODIFICAR"  name="MODIFICAR" onClick=window.location="mod_anotacion.php?anotacion=<?=$_ANOTACION ?>&tipo_hoja=<?=$tipo_hoja?>&c_ano=<?=$c_ano?>&c_curso=<?=$c_curso?>">
											<? } ?>
											
											<?php if (($_PERFIL==14) or ($_PERFIL==8) or ($_PERFIL==9) or ($_PERFIL==0) or ($_PERFIL==17) or ($_PERFIL==19)){?>
												<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick="Confirmacion()">&nbsp;
											<?php }else{?>
												<!--INPUT  TYPE="button" value="ELIMINAR"  name=btnEliminar disabled-->&nbsp;
											<?php }?>
								<?php //if ($_DESDE!=""){ ?>
								<!--INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="../../ano/curso/alumno/anotacion/listarAnotacion.php3"-->&nbsp;
								<?php // }else {?>
							<?
							if ($_PERFIL == 0){ ?>
								<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=window.location="../../ano/curso/alumno/seteaAlumno.php3?caso=1&pesta=4&alumno=<?=$alumno?>&tipo_hoja=<?=$tipo_hoja?>&c_ano=<?=$c_ano?>&c_curso=<?=$c_curso?>">
								&nbsp;
<? }else{ ?>
						        <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick="window.history.go(-2)">
						        &nbsp;
<? }  ?>					  
						
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
