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
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>

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

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

//-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../Sea/cortes/b_ayuda_r.jpg','../../../Sea/cortes/b_info_r.jpg','../../../Sea/cortes/b_mapa_r.jpg','../../../Sea/cortes/b_home_r.jpg')">
	
		<table WIDTH="700" BORDER="0" CELLSPACING="1" CELLPADDING="3" align="center">
			<TR height=15>
				<TD COLSPAN=5>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=2>
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
					</TABLE>
			  </TD>
			</TR>
			<tr>
				<td colspan=5 align=right>
				<div align="right">
				  <div id="capa0">
				    <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
				  </div>
				</div>
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
				?>
				</td>
			</tr>
			</table>
			
			<table WIDTH="700" BORDER="0" CELLSPACING="1" CELLPADDING="2" align="center">
			<tr class="tablatit2-1">
				<td align="center" width="310">NOMBRE</td>
				<td align="center" width="80">
					RUT								</td>
				<td align="center" width="80">
					CARGO				</td>
								
     <td align="center" width="80"> FONOS </td>
     <td align="center" width="150"> MAIL </td>
			</tr>
			<?php
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
					
							<td width="310" align="left" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"];?></strong>								</font>							</td>
							<td width="80" align="right" ><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fila1["rut_emp"]." - ".$fila1["dig_rut"];?></strong></font></td>
							<td width="80" align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
										<?php
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
																		 echo('Rector(a)');
																		 break;
																	 case 24:
																		 echo('Administrativo');
																		 break;			
																	 case 27:
																		 echo('Jefe de Departamento');
																		 break;	
																	 case 29:
																		 echo('Bibliotecologo');
																		 break;	
																	
																	case 33:
																		 echo('Educador Diferencial');
																		 break;		 
																		 
																	case 28:
																		 echo('Asistente de Parvulos');
																		 break;	
																	 case 35:
																		 echo('Director(a) Básica');
																		 break;
																	case 36:
																		 echo('Director(a) Media');
																		 break;			 	 
																	case 37:
																		 echo('Director(a) Pre-Básica');
																		 break;	
																	case 38:
																		 echo('Jefe UTP Media');
																		 break;	
																    case 34:
																		 echo('Educadora de Parvulos');
																		 break;	
																   case 39:
																		 echo('Inspector de Patio');
																		 break;	
																    case 40:
																		 echo('Inspector de patio');
																		 break;	
																	case 41:
																		 echo('PSICOPEDAGOGA');
																		 break;		
																	case 42:
																		 echo('Auxiliar Biblioteca');
																		 break;
																	case 44:
																		 echo('Profesor SEP');
																		 break;		
																	case 47:
																		 echo('Jefe UTP Básica');
																		 break;				
																	case 32:
																		 echo('Capellan');
																		 break;		
																    case 43:
																		 echo('Guardia');
																		 break;			
																	case 46:
																		 echo('Especialista PIE');
																		 break;		 
																	case 48:
																		 echo('Asistente de Aula');
																		 break;	
																		 
																	case 49:
																		 echo('Portero');
																		 break;		 
																	case 50:
																		 echo('Secretaria Academica');
																		 break;		 	 			
																	case 51:
																		 echo('Secretaria de Dirección');
																		 break;
																	case 52:
																		 echo('Ejecutiva Financiera');
																		 break;		 		 												 																 	case 54:
																		 echo('Asistente de la Educación');
																		 break;		 		 												 																 	case 57:
																		 echo('Coordinador de Enlaces');
																		 break;
																	case 58:
																		 echo('Director Interino');
																		 break;	
																	case 60:
																		 echo('asistente de biblioteca CRA');
																		  break;	
																	case 65:
																		 echo('Director(a) de ciclo');	
																		  break;	
																		 case 104:
																		 echo('Fonoaudiólogo');
																		 break;
																		 case 105:
																		 echo('Coordinador(a) de ciclo Media');
																		 break;	
																		 case 106:
																		 echo('Coordinador(a) de ciclo Básica');	 		 												 																		 break;	
																		 case 107:
																		 echo('INSPECTOR 1er.CICLO');	 		 												 																		 break;	
																		 case 108:
																		 echo('INSPECTOR 2°CICLO ');	 		 												 																		break;	
																		 case 109:
																		 echo('COORD.UTP 1er.CICLO ');
																		 break;	
																		 case 110:
																		 echo('COORD.UTP 2do.CICLO');
																		 break;	
																		 case 111:
																		 echo('COORD.UTP PREBASICA');
																		 break;	
																		 case 112:
																		 echo('COORD.PASTORAL');
																		 break;	
																		 case 113:
																		 echo('COORD.PIE');
																		 break;	
																		 case 114:
																		 echo('TERAPEUTA OCUPACIONAL');
																		 break;	
																		 break;	
																		 case 116:
																		 echo('RONDIN');
																		 break;	
																		 case 117:
																		 echo('ASISTENTE DE BIBLIOTECA');	
																		 break;	
																		 case 118:
																		 echo('AUXILIAR ASEO');																																							 																};
												$flag=1;
											   $query_trabaja2="select * from trabaja where rut_emp='$fila1[rut_emp]' and rdb='$institucion' and cargo<>$fila1[cargo]";
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
																		 echo('Evaluador');
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
																		 echo('Coordinación <br> Mantenimiento');
																		 break;
																 };
												}
										?>
									</strong></font></td>
							
							<td width="80" align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila1["telefono"]." - ".$fila1["telefono2"]." - ".$fila1["telefono3"];?></strong>								</font>							</td>
							<td align="left" width="150">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila1["email"];?></strong>								</font>							</td>
		  </tr>
			<?php
							if($i==25){	
							     ?>
								 </table>
			                     <?
								 echo "<H1 class=SaltoDePagina></H1>";	?>
			                     <table WIDTH="700" BORDER="0" CELLSPACING="1" CELLPADDING="2" align="center">
								 <tr class="tablatit2-1">
									<td align="center" width="310">NOMBRE</td>
									<td align="center" width="80">
										RUT								</td>
									<td align="center" width="80">
										CARGO				</td>
													
								 <td align="center" width="80"> FONOS </td>
								 <td align="center" width="150"> MAIL </td>
								</tr>
						  <? } 			
			
						}
					}
				}
			?>
			<tr>
				<td colspan="5">
					<hr width="100%" color="#0099cc">				
				</td>
			</tr>
		</table>
	

								  
