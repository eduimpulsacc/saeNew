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

<script language="JavaScript" type="text/JavaScript">
<!--

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                <tr> 
                                  <td>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){  ?>
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
	          <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">	
      		</div>		</td>
	</tr>
</table>
<?
if ($institucion=="770"){ 
    // no muestro los datos de la institucion
    // por que ellos tienen hojas pre-impresas
   echo "<br><br><br><br><br><br><br><br><br><br><br>";   
}
	?>
	<table width="100%" border="1">
		<tr>
			<td align="center" colspan="4"class="tableindex">ALUMNOS EXTRANJEROS</td>
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
		where m.id_ano = '$ano' and m.rdb = '$institucion' and m.rut_alumno = a.rut_alumno and m.id_curso = '$chk_curso' and a.nacionalidad != '2'
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
			<td class="textosesion"><?=$curso_palabra?></td>
			<td class="textosesion"><?=$retirados['rut_alumno']."-".$retirados['dig_rut']?></td>
			<td class="textosesion"><?=$retirados['nombre_alu'].$retirados['ape_pat'].$retirados['ape_mat']?></td>
			
		</tr>	
<?	}	?>
  </table>
</center>	
<?	}	?>

	
	
<!-- FIN CUERPO DE LA PAGINA -->								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table>          </td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>