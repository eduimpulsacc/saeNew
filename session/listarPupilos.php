<?php 
require('../util/header.inc'); 


$institucion	=$_INSTIT;
$_POSP =1;
session_start();
$_NOMBREUSUARIO = $_SESSION['_NOMBREUSUARIO'];
session_register('_NOMBREUSUARIO');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilos.css" rel="stylesheet" type="text/css">
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
<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../Sea/cortes/b_ayuda_r.jpg','../Sea/cortes/b_info_r.jpg','../Sea/cortes/b_mapa_r.jpg','../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="90" height="722" align="left" valign="top" background="../Sea/cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                       </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->
                 
								  
								  
								  
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<tr>
				<td colspan=4 align=right>
				</td>
			</tr>
			<tr height="20" class="tableindex">
				<td align="middle" colspan="4">
					PUPILOS DEL APODERADO
				</td>
			</tr>
			<tr class="tablatit2-1">
				<td align="center" width="100">
					RUT
				</td>
				<td align="center" width="300">
					NOMBRE
				</td>
				<td align="center" width="200">
				INSTITUCION
				</td>
				<td align="center" width="100">
					AÑO ACADEMICO
				</td>
			</tr>

			<?php
				if($institucion!=24977 && $institucion!=24988 )
				{
					//TODOS LOS ALUMNOS PARA LOS CUALES A SIDO APODERADO, EN TODOS LOS AÑOS ACADEMICOS
	//				$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, institucion.nombre_instit, ano_escolar.nro_ano, institucion.rdb, matricula.id_ano, matricula.id_curso FROM (((alumno INNER JOIN (apoderado INNER JOIN tiene2 ON apoderado.rut_apo = tiene2.rut_apo) ON alumno.rut_alumno = tiene2.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN institucion ON matricula.rdb = institucion.rdb) INNER JOIN ano_escolar ON matricula.id_ano = ano_escolar.id_ano WHERE (((apoderado.rut_apo)='".$_APODERADO."')) ORDER BY matricula.id_ano DESC";
	
					 $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, institucion.nombre_instit, ano_escolar.nro_ano, institucion.rdb, matricula.id_ano, matricula.id_curso, ano_escolar.situacion FROM (((alumno INNER JOIN (apoderado INNER JOIN tiene2 ON apoderado.rut_apo = tiene2.rut_apo) ON alumno.rut_alumno = tiene2.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN institucion ON matricula.rdb = institucion.rdb) INNER JOIN ano_escolar ON matricula.id_ano = ano_escolar.id_ano WHERE apoderado.rut_apo=".$_NOMBREUSUARIO." ORDER BY institucion.rdb";
					 
				}else{
				
					$sql="select max(id_ano) from matricula where rdb = ".$institucion."";
						$res=pg_Exec($sql);
						$fila=@pg_fetch_array($res,0);
						$ano = $fila['max'];	
														
						$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, institucion.nombre_instit, ano_escolar.nro_ano, institucion.rdb, matricula.id_ano, matricula.id_curso, ano_escolar.situacion FROM (((alumno INNER JOIN (apoderado INNER JOIN tiene2 ON apoderado.rut_apo = tiene2.rut_apo) ON alumno.rut_alumno = tiene2.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN institucion ON matricula.rdb = institucion.rdb) INNER JOIN ano_escolar ON matricula.id_ano = ano_escolar.id_ano WHERE apoderado.rut_apo=".$_NOMBREUSUARIO." and matricula.id_ano = '$ano' ORDER BY ano_escolar.nro_ano DESC";	
										
				}

				
				$result =@pg_Exec($conn,$qry) or die("SELECT FALLO:".$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
				}else{
					if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
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
						
						
						if ($fila['rdb']==1914 and $fila['situacion']==0)
							{; }
						else
						{
						if(@pg_numrows($result)==1){ 		
							
 ?>
	<script type="text/javascript">
  window.location='seteaPupilo.php3?institucion=<?php echo $fila['rdb'];?>&alumno=<?php echo trim($fila['rut_alumno']);?>&ano=<?php echo $fila['id_ano'];?>&curso=<?php echo $fila['id_curso'];?>&caso=1'
</script>						
							<?
							
							
							?>
							<tr class="cuadro01" bgcolor="#D5D5D5" onmouseover=this.style.cursor='hand' onClick=go('seteaPupilo.php3?institucion=<?php echo $fila['rdb'];?>&alumno=<?php echo trim($fila['rut_alumno']);?>&ano=<?php echo $fila['id_ano'];?>&curso=<?php echo $fila['id_curso'];?>&caso=1')>
                   
          
<?							}
							else
							{
							?>
							<tr class="cuadro01" bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaPupilo.php3?institucion=<?php echo $fila['rdb'];?>&alumno=<?php echo trim($fila['rut_alumno']);?>&ano=<?php echo $fila['id_ano'];?>&curso=<?php echo $fila['id_curso'];?>&caso=1')>
<?						}		?>

							<td align="center">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></strong>
								</font>
							</td>
							<td align="left" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["ape_pat"]." ".$fila["ape_mat"]." ,".$fila["nombre_alu"];?></strong>
								</font>
							</td>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["nombre_instit"];?></strong>
								</font>
							</td>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["nro_ano"];?></strong>
								</font>
							</td>
						</tr>
			<?php
					}}
				}
			?>
			<tr>
				<td colspan="4">
				<hr width="100%" color="#0099cc">
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
                        de Administraci&oacute;n Escolar - 2005 - Desarrolla Colegio 
                        Interactivo</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="90" align="left" valign="top" background="../Sea/cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? 	pg_close($connection);
	pg_close($conn);
?>