<?php require('../../../../../../util/header.inc');?>
<?php 
	if ($id_ramo){
		$_RAMO=$id_ramo;
		session_register("_RAMO");
		$_FRMMODO="mostrar";
	}
	if ($viene_de){
		$_VIENEPAG=$viene_de;	
	}
$_FRMMODO="mostrar";
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$docente		=5; //Codigo Docente
	$_POSP           =6;
	$_bot            = 5;
	$_MDINAMICO = 1;
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
<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
	


</head>
<link href="../../../../../../<? echo $_ESTILO;?>" rel="stylesheet" type="text/css">

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
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
					  <? $menu_lateral="3_1";?> 
                        <? include("../../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top">
								  
								  
								  <!--codigo antiguo inicio-->
								  
								  
								  
								  
								  
								  
								  
								  
<? if(($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=17)&&($_PERFIL!=15)&&($_PERFIL!=16)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
<table width="90%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top">&nbsp; 
      </td>
  </tr>
</table>
<? } ?>
	<?php //echo tope("../../../../../../util/");?>
	<center>
		<table WIDTH="90%" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD colspan=2>
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
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila['nombre_instit']);
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
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila['nro_ano']);
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
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
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
													echo trim($fila1['grado_curso'])." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
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
									<strong>ASIGNATURA</strong>
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
											$qry="SELECT subsector.nombre FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												echo trim($fila1['nombre']);
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<TR>
				<TD colspan=3 align=right>
					<?php if(($_PERFIL==17)||($_PERFIL==0)||($_PERFIL==14)||($_PERFIL==25)||($_PERFIL==21)){
								if($institucion==24977 || $institucion==9566){
									// no muestra boton
								}
								else{	?>
							<INPUT class="botonXX"  TYPE="button" value="AGREGAR" onClick=document.location="seteaContenido.php3?caso=2">
						<?		}?>
					<?php }?>
							<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="<? echo $_VIENEPAG;?>">
				</TD>
			</TR>
			<tr height="20" class="tableindex">
				<td align="middle" colspan="6">
					TOTAL DE ARCHIVOS ADJUNTOS
				</td>
			</tr>
			<tr class="tablatit2-1">
				<td align="center" colspan=3>TITULO</td>
				<td width="32%" align="center" >&nbsp;&nbsp;&nbsp;&nbsp;NOMBRE </td>
				<td width="13%" align="center" >FECHA CARGA</td>
               <?php  //if($institucion==25269){?>
				<td width="21%" align="center" >RESPUESTAS </td>
               <?php // }?>
			</tr>
			<?php
				$qry="SELECT archivo.id_archivo, archivo.nombre_archivo,archivo.descripcion_archivo as deci,archivo.fecha,archivo.titulo FROM adjunta INNER JOIN archivo ON adjunta.id_archivo = archivo.id_archivo WHERE (((adjunta.id_ramo)=".$ramo."));";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
						
						if(strlen(trim($fila["nombre_archivo"]))>0){
							$noma=trim($fila["nombre_archivo"]);
						}else{
							$noma=trim($fila["deci"]);
						}
						
						
			?>
			<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='white'>
				<td align="left"  onClick=go('seteaContenido.php3?archivo=<?php echo $fila["id_archivo"];?>&caso=1') colspan=3><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fila["titulo"];?></strong></font></td>
				<td align="center" onClick=go('seteaContenido.php3?archivo=<?php echo $fila["id_archivo"];?>&caso=1') ><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $noma;?></strong></font></td>
				<td align="center" onClick=go('seteaContenido.php3?archivo=<?php echo $fila["id_archivo"];?>&caso=1') ><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo CambioFD($fila["fecha"]);?></strong></font></td>
                  <?php  if($institucion==25269){?>
				<td align="center" onClick=go('seteaContenido.php3?archivo=<?php echo $fila["id_archivo"];?>&caso=1') >
               <font face="arial, geneva, helvetica" size="1" color="#000000"><strong> <?php  $sqlRA = "select count(*) from archivo_alumno where id_archivo = ".$fila["id_archivo"];
				$rsRA = pg_exec($conn,$sqlRA);
				echo pg_result($rsRA,0);
				 ?></strong></font>
                </td>
                <?php }?>
			</tr>
			<?php
					}
				}
			?>
			<tr>
				<td colspan="6">
				<hr width="100%" color="#003b85">
				</td>
			</tr>
			
		</table>
	</center>

								  
								  
								  
								  
								  
								  
								  
								  <!--fin codigo antiguo-->
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?> </td>
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
