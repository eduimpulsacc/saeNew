<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?
require('../../util/header.inc');

$institucion	=$_INSTIT;
$ano			=$_ANO;
$alumno		    =$c_alumno;
$periodo		=$c_periodos;
$_POSP = 5;
$_bot = 8;


?>
  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<? if ($_PERFIL!=16 AND $_PERFIL!=15 ) {?>
		<div id="capa0" align="center"> 
          <input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="botonXX" 
		id="cmdimprimiroriginal" 
	 	onClick="imprimir()"
	 	value="Imprimir"
		>
      	</div> 
		<? }?>	
</head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<center>
<br><br><br>

<table width="80%" cellspacing="0" cellpadding="5">
<tr><td>
<?
$sql_ano = "select nro_ano from ano_escolar where id_ano = '$ano' ";
$res_ano = @pg_Exec($conn,$sql_ano);
$fila_ano = @pg_fetch_array($res_ano);

$sql="select ape_pat, ape_mat, nombre_alu from alumno where rut_alumno = '$cmb_alumno'";
$result= @pg_Exec($conn,$sql);
$fila_alumno = @pg_fetch_array($result);

$sql_instit = "select nombre_instit from institucion where rdb = '$institucion'";
$res_instit = @pg_Exec($conn, $sql_instit);
$fila_instit = @pg_fetch_array($res_instit);

$sqlTraeCurso="SELECT * FROM curso WHERE id_curso=".$cmb_curso;
$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
$filaCurso=@pg_fetch_array($resultCurso);

$sqlEns="select * from tipo_ensenanza where cod_tipo=".$filaCurso['ensenanza'];
$resultEns=@pg_Exec($conn, $sqlEns);
$filaEns=@pg_fetch_array($resultEns);
?>		
<div class="textosesion"><strong> INSTITUCIÓN: <?=$fila_instit['nombre_instit']?></strong></div>
<div class="textosesion"><strong>&nbsp;</strong></div>
<div class="textosesion"><strong> AÑO ESCOLAR: <?=$fila_ano['nro_ano']?></strong></div>
<div class="textosesion"><strong>&nbsp;</strong></div>
<div class="textosesion"><strong> CURSO: <?=$filaCurso['grado_curso']."-".$filaCurso['letra_curso']." ".$filaEns['nombre_tipo'];?></strong></div>
<div class="textosesion"><strong>&nbsp;</strong></div>
<div class="textosesion"><strong> ALUMNO: <?=$fila_alumno['nombre_alu']." ".$fila_alumno['ape_pat']." ".$fila_alumno['ape_mat'];?></strong></div>
<br>
</td>
<td align="right">
					<?
					$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto = @pg_fetch_array($result,0);
					## código para tomar la insignia
			
				  if($institucion!=""){
					   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?>
</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
<td colspan="2">				  	
	<table width="100%" border="1">
								  <tr>
								  	<td height="20"  class="tableindex" colspan="3"><div align="center">FICHA ORIENTADOR</div></td>
								  </tr>
	  </table><br>
								  <?
								  // rescato la informacion de la tabla 
								  $qry2 = "select * from ficha_psicologica where rut_alum = '".trim($cmb_alumno)."' and tipo = '2'";
								  $res2 = pg_Exec($conn,$qry2);
								  $nres = pg_numrows($res2);
								  
								  if ($nres>0){
									  $i = 0;
									  while ($i < $nres){
											  $fres = pg_fetch_array($res2,$i);
											  $fecha_inicio = $fres['fechacontrol'];
											  $medicamento  = $fres['medicamento'];
											  $tratamiento  = $fres['tratamiento'];
											  $diagnostico  = $fres['diagnostico'];
											  $observacion  = $fres['observacion'];
											  $titulo		= $fres['titulo'];
											  
											  $dd = substr($fecha_inicio,8,2);
											  $mm = substr($fecha_inicio,5,2);
											  $aa = substr($fecha_inicio,0,4);
											  
											  $fecha_inicio = "$dd-$mm-$aa";										  
											  
											  ?>
										<table width="100%" border="1">											  						  
											  <tr>
												 <td class="cuadro01" width="20%"><div align="left">
													 <?=$fecha_inicio ?>
												  </div></td>
												 <!-- <td class="cuadro01"><div align="left">
													 <?=$medicamento ?>
												  </div></td>
												  <td class="cuadro01"><div align="left">
													 <?=$tratamiento ?>
												  </div></td>
												  <td class="cuadro01"><div align="left">
													 <?=$diagnostico ?> -->
												  </div>
												  <td class="cuadro01"><?=$titulo ?></td>
											  </tr>
											  <tr>
											  	<td class="cuadro01" colspan="2"><?=nl2br($observacion) ?></td>
											  </tr>
										   </table>	<br>
										  <?
										  $i++;
								      }
							      }
								  
							?> 					   
                             
							  </tr></td>
</table>								  
</center>							 
</html>							  	