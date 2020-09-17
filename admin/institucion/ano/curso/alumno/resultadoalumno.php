<?php 
require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
session_start();
?>
<?php if($_PERFIL==0){
//show($_SESSION);
}?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_SESSION['_CURSO']	= $cmb_curso;
	$curso			=$_SESSION['_CURSO'];
	$ramo			=$_RAMO; 
	$frmModo		=$_FRMMODO;
	$empleado		=$_EMPLEADO;
    $_POSP = 5;
	$_bot           =5;
	$_MDINAMICO     = 1;
	
	
		
			
	if (trim($_url)=="") $_url=0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--link href="../../../../../estilos.css" rel="stylesheet" type="text/css"-->

<script language="javascript" type="text/javascript">
	function delRow(a)
	{
		b="adjunta["+a+"]";
		a="td"+a;
		z=document.getElementById(b);
		z.disabled=true;
		x=document.getElementById(a);
		x.style.display="none";
		//x=document.getElementById('mytable').deleteRow(a)
	}
	
	function insRow()
	{
		largo=document.getElementById('mytable').rows.length;
		var x=document.getElementById('mytable').insertRow(largo);
		j=largo;
		var y=x.insertCell(0)
		y.className="td2";
		y.id="td"+j;
		y.innerHTML="<input name='adjunta["+j+"]' type='file' id='adjunta["+j+"]'><input name='nombreadjunta["+j+"]' type='hidden' id='adjunta["+j+"]'>		<a href=\"javascript:;\" onclick=\"delRow('"+j+"');\">elimina</a>"
	
	}
	
	function coloca_nombre(){
		largo=document.getElementById('mytable').rows.length;
		for (ii=1;ii<largo;ii++){
			origen="adjunta["+ii+"]";
			z=document.getElementById(origen);
			temp=tomaNombre(z)
			
			destino="nombreadjunta["+ii+"]";
			zz=document.getElementById(destino);
			zz.value=temp;	
		}
	}

</script><script language="JavaScript" type="text/JavaScript">
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
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
           			 <?
			   include("../../../../../cabecera/menu_superior.php");
			   ?>	
					</td></tr></table>
					
					</td>
                  
                  </tr>
               
					<!-- FIN DE COPIA DE CABECERA -->
                 
                </table></td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table><tr><td><?
					  		$menu_lateral="3_1";
							include("../../../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top" >
					  <table><tr><td height="15"></td></tr></table>
					                                 
	
					  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                      
                          <tr> 						  
                            <td height="250" align="left" valign="top" colspan="5">
							 
							<table width="100%" border="0" align="center">
									   <tr>
									   		<td colspan="7" align="center" class="textolink">
												<input class="botonXX" type="submit" name="submit2" value="i"> Información del Alumno
												<input class="botonXX" type="submit" name="submit2" value="+"> Ficha Médica
												<input class="botonXX" type="submit" name="submit2" value="D"> Ficha Deportiva
												<input class="botonXX" type="submit" name="submit2" value="M"> Matricula
										 </td>
									   </tr>	
									   <tr align="center">  
											<td class="tabla01">RUT</td>										
											<td class="tabla01">NOMBRE</td>										
											<td class="tabla01">CURSO</td>
											<td colspan="4" class="tabla01">FICHAS</td>
									   </tr> 	
							<?php
							
									$sql = "
										SELECT matricula.rut_alumno,
										   alumno.dig_rut,
										   alumno.ape_pat,
										   alumno.ape_mat,
										   alumno.nombre_alu,
										   matricula.id_curso,
										   matricula.bool_ar
										FROM MATRICULA, ALUMNO
										WHERE matricula.rut_alumno = alumno.rut_alumno
										and matricula.id_ano = ".$_ANO;
									
									if($filtroRBD!="")	{	
										$sql.= " and matricula.rut_alumno =".$filtroRBD;
									}
									if($Nombre!="")		{	
										$sql.= " and upper(alumno.nombre_alu) like '%".strtoupper($Nombre)."%'";
									}	
									if($ApellidoP!="")	{	
										$sql.= " and upper(alumno.ape_pat) like '%".strtoupper($ApellidoP)."%'";
									}
									if($ApellidoM!="")	{	
										$sql.= " and upper(alumno.ape_mat) like '%".strtoupper($ApellidoM)."%'";
									}
									if($cmb_curso!="")	{	
										$sql.= " and matricula.id_curso =".$cmb_curso;
									}
									$sql.= " order by ape_pat asc";

									$resultado =@pg_Exec($conn,$sql);
									
									for($i=0 ; $i < @pg_numrows($resultado) ; $i++){
										$registro = @pg_fetch_array($resultado,$i);
										
										$rut=$registro["rut_alumno"];
										$dig_=$registro["dig_rut"];
										$ape_pat=$registro["ape_pat"];
										$ape_mat=$registro["ape_mat"];
										$nombre_alu=$registro["nombre_alu"];
										$id_curso=$registro["id_curso"];
										$retirado=$registro["bool_ar"];
										$Curso_pal = CursoPalabra($id_curso, 1, $conn);
										if($retirado == 0) {											
										?>
										<tr>  
											<td class="textosesion"><?php echo $rut." - ".$dig_?> </font> </td>										
										<!--	<td class="textosesion"><?php echo $nombre_alu." ".$ape_pat." ".$ape_mat?></td> -->
											<td class="textosesion"><?php echo $ape_pat." ".$ape_mat." ".$nombre_alu ?></td>																																
											<td class="textosesion"><?php echo $Curso_pal;?></td>
											<td><input onClick="window.location='nueva_ficha_alumno/ficha_alumno.php?alumno=<?php echo trim($rut);?>&r=0&crs=<?=$id_curso ?>'" class="botonXX" type="button" name="submit2" value="i"></td>
											<td><input onClick="window.location='../../fichas/medicas/listarFichasAlumno.php3?alumno=<?php echo $rut?>&caso=1'" class="botonXX" type="submit" name="submit2" value="+"></td>
											<td><input onClick="window.location='../../fichas/deportivas/seteaFicha.php3?alumno=<?php echo $rut?>&caso=1'" class="botonXX" type="submit" name="submit2" value="D"></td>
											<td><input onClick="window.location='../../matricula/seteaMatricula.php3?alumno=<?php echo $rut?>&caso=1'" class="botonXX" type="submit" name="submit2" value="M"></td>											
										</tr> 										
										<?php }
										else {?> 
										<tr>
											<td class="textosesion"><span class="textosesion"><?php echo $rut." - ".$dig_?></spam></td>										
											<td class="textosesion"><span class="tachado"><?php echo $nombre_alu." ".$ape_pat." ".$ape_mat?></spam></td>																																
											<td class="textosesion"><span class="tachado"><?php echo $Curso_pal;?></spam></td>
											<td><input onClick="window.location='nueva_ficha_alumno/ficha_alumno.php?alumno=<?php echo trim($rut);?>&r=1&crs=<?=$id_curso ?>'" class="botonXX" type="button" name="submit2" value="i"></td>
											<td><input onClick="window.location='../../fichas/medicas/listarFichasAlumno.php3?alumno=<?php echo $rut?>&caso=1'" class="botonXX" type="submit" name="submit2" value="+"></td>
											<td><input onClick="window.location='../../fichas/deportivas/seteaFicha.php3?alumno=<?php echo $rut?>&caso=1'" class="botonXX" type="submit" name="submit2" value="D"></td>
											<td><input onClick="window.location='../../matricula/seteaMatricula.php3?alumno=<?php echo $rut?>&caso=1'" class="botonXX" type="submit" name="submit2" value="M"></td>												
										</tr>
										<?php	}
									}
							?>
						
							</table> 
							
				</td>
              </tr>
            </table></td>
        </tr>
					
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php");?></td>
                    </tr>
                  </table></td>
  </tr>
</table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
		   

</body>
</html>


  
<? pg_close($conn);
pg_close($connection);?>


