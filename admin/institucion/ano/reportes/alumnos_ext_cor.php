<?
require('../../../../util/header.inc');
	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$curso			=$c_curso	;
	$alumno			=$c_alumno	;
	$_POSP = 4;
	$_bot = 8;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
function enviapag(){
	form.submit(true);
}
function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
									
</script>

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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){  ?>
<table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="30" align="center" valign="top"> 
      
	  
	   <?
						include("../../../../cabecera/menu_inferior.php");
						?>
	  
	  
	  <tr>
		</tr> 
  
  
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<?
if($chk_curso!=""){	?>
<center>
<table width="100%">
	<tr>
		<td align="right">

    	    <div id="capa0">
	          <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('print_alumnos_extranjeros.php?c=1&chk_curso=<?=$chk_curso?>','','scrollbars=yes,resizable=yes,width=770,height=500')"  value="IMPRIMIR">	
      		</div>

		</td>
	</tr>
</table>

<table width="100%" border="1">
	<tr>
		<td align="center" colspan="4"class="tableindex">ALUMNOS EXTRANJEROS	</td>
	</tr>
	<tr align="center">
		<td class="tablatit2-1">CURSO</td>
		<td class="tablatit2-1">RUT</td>
		<td class="tablatit2-1">ALUMNO</td>
		
	</tr>
<? 
if($chk_curso == "1")
{
$qry2 = "select a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.fecha_retiro, m.id_curso
		from alumno a, matricula m, curso c
		where m.id_ano = '$ano' and m.rdb = '$institucion' and m.rut_alumno = a.rut_alumno and a.nacionalidad != '2'  and c.id_curso = m.id_curso and c.id_ano = m.id_ano
		order by c.ensenanza, c.grado_curso, c.letra_curso,id_curso, nro_lista, nombre_alu;";
}else{
$qry2 = "select a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.fecha_retiro, m.id_curso
		from alumno a, matricula m
		where m.id_ano = '$ano' and m.rdb = '$institucion' and m.rut_alumno = a.rut_alumno and m.id_curso = '$chk_curso' and a.nacionalidad !='2'
		order by id_curso, nro_lista, nombre_alu;";
}
$result2 =@pg_Exec($conn,$qry2);
$num = pg_numrows($result2);
for($x=0;$x<$num;$x++)
{
$retirados = pg_fetch_array($result2,$x);
$curso_palabra = CursoPalabra($retirados['id_curso'], 1, $conn);
     $fecha_retiro = $retirados['fecha_retiro'];
	 $dd = substr($fecha_retiro,8,2);
	 $mm = substr($fecha_retiro,5,2);
	 $aa = substr($fecha_retiro,0,4);
	 $fecha_retiro = "$dd-$mm-$aa";


?>
		<tr align="left">
			<td  class="textosesion"><?=$curso_palabra?></td>
			<td  class="textosesion"><?=$retirados['rut_alumno']."-".$retirados['dig_rut']?></td>
			<td  class="textosesion"><?=$retirados['nombre_alu'].$retirados['ape_pat'].$retirados['ape_mat']?></td>
			
		</tr>	
<?	}	?>
  </table>
</center>	
<?	}	?>

	<FORM method="post" name="form" action="alumnos_extranjeros.php?c=1">
	
			<?php
				$qry="SELECT * FROM CURSO WHERE ID_ANO='$ano' ORDER BY ensenanza, grado_curso, letra_curso;";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
				}						
						$num_filas = pg_numrows($result);	
						trim($fila['letra_curso']);
			?>
		<center>
			<table border="0" cellpadding="5" cellspacing="0">
				<tr>
					<td align="center" class="tableindex" colspan="3">Buscador Avanzado</td>
				</tr>
				<tr  class="cuadro01">
					<td>Seleccione Colegio </strong></td>
					<td>
						<select name="chk_curso">
							<option value="1">Todos los Cursos</option>
							<? 
								for($i=0;$i<$num_filas;$i++)
								{
									$fila = pg_fetch_array($result,$i);
									$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
									if($chk_curso==$fila["id_curso"]){?>
										<option selected="selected" value="<?=$fila['id_curso']?>"><?=$Curso_pal?></option>
									<?  }else{ ?>
										<option value="<?=$fila['id_curso']?>"><?=$Curso_pal?></option>
							<?	}		}?>
						</select>
						</td>
						<td>
								  <input name="buscar" type="button" value="Buscar" onClick="enviapag()" class="botonXX">
						</td>
					</tr>
		</table>
	        <table border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="302" align="center" class="tableindex">o</td>
              </tr>
            </table>
	        <p>&nbsp;</p>
		</center>			
</FORM>

	
<!-- FIN CUERPO DE LA PAGINA -->

 								  								  
								  </td>
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
<? pg_close($conn);?>