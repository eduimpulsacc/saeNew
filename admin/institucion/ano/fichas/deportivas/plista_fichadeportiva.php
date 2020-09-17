<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$_POSP          =5;
	$_bot           = 5;

?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM FICHA_DEPORTIVA WHERE ID_ANO=".$ano." AND RUT_ALUMNO='".trim($alumno)."'";
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
function imprSelec(nombre)
{
  var ficha = document.getElementById(nombre);
  var ventimp = window.open(' ', 'popimpr');
  ventimp.document.write( ficha.innerHTML);
  ventimp.document.close();
 ventimp.print( );
}
//-->
</script>
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
		
<?php }?>
	
</head>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="window.print(); window.close();">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                        
						  <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                              
							    <tr> 
                                  <td height=""><!-- inicio codigo nuevo -->
								  
								  
								  
								  
								  
								  
<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
<table width="90%" height="30" border="0" cellpadding="0" cellspacing="0">
  	<tr>
		<TD>  <?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## c&oacute;digo para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' width='90' height = '100' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?></TD>
		<td colspan="5" align="center">
								<FONT face="arial, geneva, helvetica" size=3>
									<strong>FICHA DEPORTIVA </strong></font></td>
		</tr>
  <tr> 
  </tr>
</table>
<?php } ?>
	<?php //echo tope("../../../../../util/");?>
	
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=idFicha value=".$fila['id_ficha'].">"
	?>
<DIV ID="seleccion">
	
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
		<TABLE WIDTH=90% BORDER=0 align=center CELLPADDING=0 CELLSPACING=0>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
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
													echo trim($fila1['nro_ano']);
												}
											}
										?>
									</strong>								</FONT>							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>ALUMNO</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											 $qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
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
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']);
												}
												?></strong></FONT></TD>
										</TR>
											<tr>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>RUT ALUMNO</strong>								</FONT>							</TD>
											<td>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>					</td>
											<td>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong><?= $fila1['rut_alumno']?>-<?= $fila1['dig_rut']?></strong></FONT></td>
											</tr>
											<tr>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>FECHA DE NACIMIENTO</strong>								</FONT>							</TD>
											<td>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>					</td>
											<td>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong><?= date("d-m-Y",strtotime($fila1['fecha_nac']))?></strong></FONT></td>
											</tr>
												
										<? $sqlcurso="select * from curso where id_ano=".$ano." and id_curso=".$_CURSO;
											$resultcurso =@pg_Exec($conn,$sqlcurso);
											$filacurso = @pg_fetch_array($resultcurso,0);	
										?>
										<tr>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>CURSO</strong>								</FONT>							</TD>
											<td>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>					</td>
											<td>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong><?= $filacurso["grado_curso"]." ".$filacurso["letra_curso"]?></strong></FONT></td>
										</tr>
												<?
											}
										?>
					</TABLE>
				</TD>
			</TR>
						<? 																
								$sql_emp = "select d.rut_emp, e.nombre_emp, e.ape_pat, e.ape_mat
											from subsector s, ramo r, dicta d, empleado e, trabaja t
											where 	s.cod_subsector = 11 and s.cod_subsector = r.cod_subsector and r.id_ramo = d.id_ramo 
											and d.rut_emp = e.rut_emp and e.rut_emp = t.rut_emp and rdb = '$institucion'
											group by d.rut_emp, e.nombre_emp, e.ape_pat, e.ape_mat";
								$res_emp = @pg_Exec($conn, $sql_emp);
								$n_filas = @pg_numrows($res_emp);
								for($x=0;$x<$n_filas;$x++)
								{
									$emp = @pg_fetch_array($res_emp,$i);
									$nom_emp = $emp['nombre_emp'].$emp['ape_pat'].$emp['ape_mat'];
									if(trim($nom_emp) == trim($_USUARIOENSESION))
									{
										$ed_fisica = "1";
									}
								}						
						?>			
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD width="100%" colspan=2 align=right>							</TD>
						</TR>
						<TR height=20>
							<TD align=middle colspan=2 class="tableindex">								
									FICHA DEPORTIVA							</TD>
						</TR>
						<TR>
							<TD width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                              <tr>
                                <td size=2 class="cuadro02">Fecha</td>
                                <td class="cuadro02">Observaci&oacute;n</td>
                              </tr>
							  <?
							  // TOMO TODAS LAS FICHAS INGRESADAS PARA ESTE ALUMNO
							  $q1 = "select * from ficha_deportivanew where rut_alumno = '$alumno'";
							  $r1 = @pg_Exec($conn,$q1);
							  $n1 = @pg_numrows($r1);
							  if ($n1 != 0){
							     $i = 0;
								 while ($i < $n1){
							         $f1 = pg_fetch_array($r1,$i);
									 $fecha = $f1['fecha'];
									 $observaciones = $f1['observaciones'];
									 $id_ficha = $f1['id_ficha'];
									 
									 $dd = substr($fecha,8,2);
	                                 $mm = substr($fecha,5,2);
	                                 $aa = substr($fecha,0,4);
									 $fecha = "$dd-$mm-$aa";
									 
							         ?>						  
                                     <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='ffffff'>
									             <td class="cuadro01" ><a href="fichaDeportiva.php3?id_ficha=<?=$id_ficha ?>"><?=$fecha ?></a></td>
                                      <td><a href="fichaDeportiva.php3?id_ficha=<?=$id_ficha ?>"><?=$observaciones ?></a></td>
                                     </tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='ffffff'>
									 <?
									 $i++;
								 }
							  }
							  ?>					 
									 
                            </table></TD>
						</TR>
						<TR>
							<TD><table width="100%" border=0 cellspacing=0 cellpadding=0>
                              <tr>
                                <td><hr width="100%" color="#003b85">                                </td>
                              </tr>
                            </table></TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
				  
								</div>  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
