<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
	$_POSP = 5;
	$_bot   = 5;

if ($alumno == NULL){
   $alumno = $_ALUMNO;
}   
/********DATOS PARA PAGINA HOJA DE VIDA**********************/

$c_curso=$_GET['curso'];
$c_ano = $_GET['c_ano'];

/*******************************/
	
// TOMO LOS DATOS DEL ALUMNO
 
$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM alumno WHERE alumno.rut_alumno='".$_GET["rut"]."'";
//return;
$result =@pg_Exec($conn,$qry);
if (!$result){
    error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
}else{
   	$n1 = pg_numrows($result);
	if ($n1 > 0){
	    $fila2 = pg_fetch_array($result,0);	
		if (!$fila2){
			error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
			exit();
		}
	}
}
$rut = $fila2["rut_alumno"];
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

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function imprSelec(nombre)
{
  var ficha = document.getElementById(nombre);
  var ventimp = window.open(' ', 'popimpr');
  ventimp.document.write( ficha.innerHTML);
  ventimp.document.close();
 ventimp.print( );
}

function valida_elimina(a,b,c,d){
    if(confirm('Esta seguro que desea eliminar registro?')){
	     window.location='elimina_medica.php?id_ficha='+a+'&alumno='+b+'&caso='+c+'&id_curso='+d;
		 
	}


}
//-->
</script>

<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
	

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="window.print(); window.close();">
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
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top">
								  <!-- inicio codigo nuevo -->
								  
								  
								  
								  
								  
								  
<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
<table width="90%"  border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center" valign="top"> 
      <? //include("../../../../../cabecera/menu_inferior.php"); ?> </td>
  </tr>
</table>
<? } ?>
	<?php //echo tope("../../../../../util/");?>
	
				<div align="right">
<table>
					<tr>
				<td colspan=4>&nbsp;</td>
			</tr>
</table>
				</div>
<DIV ID="seleccion">

<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
		<table WIDTH="90%" BORDER="0" align="center" CELLPADDING="3" CELLSPACING="1">
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
									<strong>FICHA MEDICA</strong></font></td>
		</tr>

			<TR height=15>
				<TD COLSPAN=3>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
						<TR>
							<TD align=left class="textosimple">												INSTITUCION															</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result	 =@pg_Exec($conn,$qry);
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
									</strong>								</FONT>							</TD>
						</TR>
						<TR>
						  <TD align=left><span class="textosimple">ALUMNO</span></TD>
						  <TD><span class="Estilo11">:</span></TD>
						  <TD><span class="Estilo11"><?php echo $fila2["ape_pat"]." ".$fila2["ape_mat"].", ".$fila2["nombre_alu"];?></span></TD>
						  </TR>
						<TR>
						  <TD align=left><span class="textosimple">RUT ALUMNO </span></TD>
						  <TD><span class="Estilo11">:</span></TD>
						  <TD><span class="Estilo11"><?php echo $fila2["rut_alumno"]." - ".$fila2["dig_rut"];?></span></TD>
						  </TR>
						<TR class="textosimple">
						  <TD align=left>CURSO</TD>
						  <TD>:</TD>
						  <TD>
						  
							<? 				$sqlcurso="select * from curso where id_ano=".$ano." and id_curso=".$_GET["curso"];
											$resultcurso =@pg_Exec($conn,$sqlcurso);
											$filacurso = @pg_fetch_array($resultcurso,0);
											echo $filacurso["grado_curso"]." ".$filacurso["letra_curso"]
											?>
						  &nbsp;</TD>
						  </TR>
					</TABLE>				</TD>
			</TR>

			<tr height="20">
				<td align="middle" colspan="3" class="tableindex">
					
							REGISTRO DE SALUD DEL ALUMNO				</td>
			</tr>
			<tr class="tablatit2-1">
				<td align="center" width="80">
					FECHA				</td>
				<td align="center" width="220" colspan="4">OBSERVACIONES</td>
			<?php
		
		 		$q2="SELECT * FROM FICHA_MEDICANEW WHERE rut_alumno = '".$_GET["rut"]."'";
				$r2 =@pg_Exec($conn,$q2);
				if (!$r2) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($r2)!=0){
						$f2 = @pg_fetch_array($r2,0);	
						if (!$f2){
							error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
							exit();
						}
					}
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($r2) ; $i++){
						$f2 = @pg_fetch_array($r2,$i);
			?>
						<tr >
							 <td align="center" bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaFicha.php3?alumno=<?php echo trim($f2["rut_alumno"]);?>&idFicha=<?php echo $f2["id_ficha"];?>&caso=1')>
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?
									 $fecha = $f2['fecha'];
									 $dd = substr($fecha,8,2);
									 $mm = substr($fecha,5,2);
									 $aa = substr($fecha,0,4);
									 $fecha = "$dd-$mm-$aa";
									
									 echo $fecha; ?></strong></font></td>
							<td align="left" bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaFicha.php3?alumno=<?php echo trim($f2["rut_alumno"]);?>&idFicha=<?php echo $f2["id_ficha"];?>&caso=1')><font face="arial, geneva, helvetica" size="1" color="#000000"> <strong> <?php echo $f2["observaciones"]?></strong></font></td>
							<? if ($_PERFIL==14 OR $_PERFIL==0){?> <td width="5%" align="left">
							<!--<input name="Submit" type="button" class="Botonxx" onClick="MM_goToURL('parent','elimina_medica.php?id_ficha=<?php //echo $f2["id_ficha"];?>&alumno=<?php //echo trim($f2["rut_alumno"]);?>&caso=1&id_curso=<? echo $_CURSO;?>');return document.MM_returnValue" value="E" >-->
						</tr>	<? } ?>		
			<?php
					}
				}
			?>
			
		</table>
			</div>				  
						  <!-- fin codigo nuevo -->
							  
								  </td>
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
