<?php require('../../../../util/header.inc');?>
<?php
 
 $institucion=$_INSTIT;
 $usuario=$_ID_USER;
 $empleado=$_EMPLEADO;
 $_POSP=4;


$sql_ins ="SELECT * FROM institucion where rdb = ".$_INSTIT;
$rs_ins = @pg_exec($connection,$sql_ins) or die("SELECT FALLO :".$sql_ins);
$fila_ins = @pg_fetch_array($rs_ins,0);	



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" type="text/JavaScript">
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
</SCRIPT>
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
<SCRIPT language="JavaScript">
	function valida(form){
	  return true;
		}
</SCRIPT>
</head>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
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
                                  <td><!--inicio codigo antiguo -->
								  
								  
	<?php //echo tope("../../../../util/");?>
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD COLSPAN=2>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>EMPLEADO</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$empleado;
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
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_emp']);
												}
											}
										?>
									</strong>								</FONT>							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<tr>
				<td colspan=2 align=right>
					<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="../empleado.php3?pesta=4">
				</td>
			</tr>
			<tr height="20" >
				<td align="middle" colspan="2" class="tableindex">
					AGREGAR PERFIL DE ACCESO A COLEGIO INTERACTIVO
				</td>
			</tr>
			<FORM method=post name="frm" action="procesoPerfil.php3">
			<input name="rut_emp" type="hidden" value="<?=$empleado;?>">
				<TR>
					<TD width=30></TD>
					<TD>
						<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
							<TR>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>NOMBRE USUARIO</STRONG>
									</FONT>
								</TD>
							</TR>
							<TR>
								<TD class="cuadro01">
									<?php imp(trim($empleado));?>
								</TD>
							</TR>
						</TABLE>
					</TD>
				</TR>
				<TR>
					<TD width=30></TD>
					<TD>
						<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 >
							<TR>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>PERFIL DE ACCESO</STRONG>
									</FONT>
								</TD>
							</TR>
							<TR>
								<TD>
								<?		
								
								
								if ($usuario!=NULL){
								    $sql ="SELECT count(*) FROM nacional n INNER JOIN nacional_corp nc ON n.id_nacional=nc.id_nacional INNER JOIN corp_instit ci ON nc.num_corp=ci.num_corp WHERE n.id_nacional=1 ";
									$rs_nacional = @pg_exec($connection,$sql) or die("SELECT FALLO :".$sql);
									if(@pg_numrows($rs_nacional)>0){
										/*$qry="select * from perfil where id_perfil not in (SELECT accede.id_perfil FROM (accede INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil) INNER JOIN usuario ON 
accede.id_usuario = usuario.id_usuario WHERE (((accede.rdb)=".$_INSTIT.") AND 
((accede.id_usuario)=".$usuario."))) order by nombre_perfil asc";*/	
 $qry="select * from perfil where
sistema = 1 or
(sistema in(SELECT saemovil 
from institucion where saemovil=2 and rdb = ".$_INSTIT."))
or (sistema in(SELECT evados 
from institucion where evados=3 and rdb = ".$_INSTIT."))
or (sistema in(SELECT reca 
from institucion where reca=4 and rdb = ".$_INSTIT."))
or (sistema in(SELECT cede 
from institucion where cede=7 and rdb = ".$_INSTIT."))
or (sistema in(SELECT sueldos 
from institucion where sueldos=11 and rdb = ".$_INSTIT."))
or (sistema in(SELECT biblioteca 
from institucion where biblioteca=13 and rdb = ".$_INSTIT."))
or (sistema in(SELECT edugestor 
from institucion where edugestor=14 and rdb = ".$_INSTIT."))
and id_perfil not in (SELECT accede.id_perfil 
FROM (accede INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil) INNER JOIN usuario ON 
accede.id_usuario = usuario.id_usuario WHERE (((accede.rdb)=".$_INSTIT.") AND 
((accede.id_usuario)=".$usuario.")))

order by nombre_perfil asc 
";


									}else{
										/*$qry="select * from perfil where id_perfil not in (SELECT accede.id_perfil FROM (accede INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil) INNER JOIN usuario ON 
accede.id_usuario = usuario.id_usuario WHERE (((accede.rdb)=".$_INSTIT.") AND 
((accede.id_usuario)=".$usuario."))) and sistema=1 order by nombre_perfil asc";*/
 $qry="select * from perfil where
sistema = 1 or
(sistema in(SELECT saemovil 
from institucion where saemovil=2 and rdb = ".$_INSTIT."))
or (sistema in(SELECT evados 
from institucion where evados=3 and rdb = ".$_INSTIT."))
or (sistema in(SELECT reca 
from institucion where reca=4 and rdb = ".$_INSTIT."))
or (sistema in(SELECT cede 
from institucion where cede=7 and rdb = ".$_INSTIT."))
or (sistema in(SELECT sueldos 
from institucion where sueldos=11 and rdb = ".$_INSTIT."))
or (sistema in(SELECT biblioteca 
from institucion where biblioteca=13 and rdb = ".$_INSTIT."))
or (sistema in(SELECT edugestor 
from institucion where edugestor=14 and rdb = ".$_INSTIT."))
and id_perfil not in (SELECT accede.id_perfil 
FROM (accede INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil) INNER JOIN usuario ON 
accede.id_usuario = usuario.id_usuario WHERE (((accede.rdb)=".$_INSTIT.") AND 
((accede.id_usuario)=".$usuario.")))
order by nombre_perfil asc 
";
									}
								}else{								
								
									/*$qry="select * from perfil where id_perfil not in (SELECT accede.id_perfil FROM (accede 
	INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil) INNER JOIN usuario ON 
	accede.id_usuario = usuario.id_usuario WHERE ((accede.rdb)=".$_INSTIT.")) order by nombre_perfil asc";*/
 $qry="select * from perfil where
sistema = 1 or
(sistema in(SELECT saemovil 
from institucion where saemovil=2 and rdb = ".$_INSTIT."))
or (sistema in(SELECT evados 
from institucion where evados=3 and rdb = ".$_INSTIT."))
or (sistema in(SELECT reca 
from institucion where reca=4 and rdb = ".$_INSTIT."))
or (sistema in(SELECT cede 
from institucion where cede=7 and rdb = ".$_INSTIT."))
or (sistema in(SELECT sueldos 
from institucion where sueldos=11 and rdb = ".$_INSTIT."))
or (sistema in(SELECT biblioteca 
from institucion where biblioteca=13 and rdb = ".$_INSTIT."))
or (sistema in(SELECT edugestor 
from institucion where edugestor=14 and rdb = ".$_INSTIT."))
and id_perfil not in (SELECT accede.id_perfil 
FROM (accede INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil) INNER JOIN usuario ON 
accede.id_usuario = usuario.id_usuario WHERE (((accede.rdb)=".$_INSTIT.") AND 
((accede.id_usuario)=".$usuario.")))
AND 
((accede.estado) !=0)))
order by nombre_perfil asc 
";                                 }
												
												
                                    ?>
								
								
									<Select name="cmbPERFIL">
										<!--option value=0 selected></option-->;
										<?php
											$result =@pg_Exec($connection,$qry) or die($qry);
											if (!$result) 
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													};
													for($i=0 ; $i < @pg_numrows($result) ; $i++){
														$fila1 = @pg_fetch_array($result,$i);
														if(($fila1["id_perfil"]!=0)&&
															
															($fila1["id_perfil"]!=9)&&
															($fila1["id_perfil"]!=15)&&
															
															($fila1["id_perfil"]!=16)&&
														    ($fila1["id_perfil"]!=3)&&
															($fila1["id_perfil"]!=4)&&
															($fila1["id_perfil"]!=5)&&
															($fila1["id_perfil"]!=7)&&
															($fila1["id_perfil"]!=23)&&
															($fila1["id_perfil"]!=24)&&
															($fila1["id_perfil"]!=51)&&
															($fila1["id_perfil"]!=57)&&
															//($fila1["id_perfil"]!=40)&&
															($fila1["id_perfil"]!=41)/*&&
															($fila1["id_perfil"]!=26) */) //perfil corporativo -> comentar															
																//echo  "<option value=".$fila1["id_perfil"].">".$fila1["nombre_perfil"]."</option>";
																echo  "<option value=".$fila1["id_perfil"]."_".$fila1["sistema"].">".$fila1["nombre_perfil"]."</option>";
													}
												}
											};
										?>
									</Select>
								</TD>
							</TR>
						</TABLE>
					</TD>
				</TR>
				<TR align=center HEIGHT=50 VALIGN=BOTTOM>
					<TD colspan=2 align=center>
						<input class="botonXX"  type=submit value=GUARDAR onClick="return valida(this.form);">
					</TD>
				</TR>

			</FORM>
			<tr>
				<td colspan="2">
				<hr width="100%" color="#003b85">
				</td>
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
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
