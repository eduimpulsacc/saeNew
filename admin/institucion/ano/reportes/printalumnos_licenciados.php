<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

if ($institucion==299){
	$whe_ensenanza=" OR (ensenanza = 10)";
   //	OR (curso.grado_curso<5) and (curso.ensenanza<>110)
}
if ($dia == ""){
	   ## si el campo esta vacío poner la fecha actual
	   $dia  = strftime("%d",time());
	   $mes  = strftime("%m",time());
	   $mes  = envia_mes($mes);
	   $ano2  = strftime("%Y",time()); 
	}else{
	   $dia = $dia;
	   $mes = $mes;
	   $ano2 = $ano2;
	}   

?>
<?php 
    //setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$c_alumno;
	$curso			=$cod_tipo;
	$cod_tipo		=$cod_tipo;
	$_POSP = 4;
	$_bot = 8;
	
	$sqlEns="select ensenanza from curso where id_curso =".$curso;
	$resEns=@pg_exec($conn, $sqlEns);
	$ensenanza=@pg_fetch_array($resEns,0);
	
	if ($institucion==769){
	    $cargo="23";
	}else{
	    $cargo="1";
	}
	
	$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, (empleado.nombre_emp || ' ' || empleado.ape_pat ||' ' || empleado.ape_mat) as nombre, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=".$cargo.")) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultDIR =@pg_Exec($conn,$qryDIR);
	$filaDIR=@pg_fetch_array($resultDIR);
	$nombre_director = $filaDIR['nombre']; 
		
	
	$sqlAlu="select (trim(nombre_alu) || ' ' || trim(ape_pat) || ' ' || trim(ape_mat)) as nombre from alumno where rut_alumno=".$alumno;
	$resAlu=@pg_exec($conn, $sqlAlu);
	$nombreAlu=@pg_fetch_array($resAlu);
	
	$sqlAno="select nro_ano from ano_escolar where id_ano=".$_ANO;
	$resAno=@pg_exec($conn, $sqlAno);
	$ano=@pg_fetch_array($resAno,0);
	$nro_ano = $ano['nro_ano'];
	
	$sqlInsit="SELECT nombre_instit, region, ciudad, comuna, nu_resolucion, fecha_resolucion FROM institucion WHERE rdb=".$_INSTIT;
	$resInstit=@pg_exec($conn, $sqlInsit);
	$filaInstit=@pg_fetch_array($resInstit,0);
	$nombre_institucion = $filaInstit['nombre_instit'];
	
	
	$sqlReg="select nom_reg from region where cod_reg=".$filaInstit['region'];
	$resReg=@pg_exec($conn, $sqlReg);
	$region=@pg_fetch_array($resReg,0);
	
	$sqlPro="select nom_pro from provincia where cod_reg=".$filaInstit['region']." and cor_pro=".$filaInstit['ciudad'];
	$resPro=@pg_exec($conn, $sqlPro);
	$ciudad=@pg_fetch_array($resPro,0);	
	
	$sqlCom="select nom_com from comuna where cod_reg=".$filaInstit['region']." and cor_pro=".$filaInstit['ciudad']." and cor_com=".$filaInstit['comuna'];
	$resCom=@pg_exec($conn, $sqlCom);
	$comuna=@pg_fetch_array($resCom,0);	
	
	
	
	
	$q1 = "select * from trabaja where rdb = '".trim($institucion)."' and (cargo=1 OR cargo=23)";
	$r1 = @pg_Exec($conn,$q1);
	$n1 = @pg_numrows($r1);
	//echo "n1 es: $n1 <br>";
	
	$f1 = @pg_fetch_array($r1,0);
	$cargo = $f1['cargo'];
	//echo "c: $cargo <br>";
	
	if ($cargo==1){
		$cargo_dir  = "director(a)";
		$cargo_dir2 = "Director(a)";
	}
	if ($cargo==23){
		$cargo_dir  = "rector(a)";
		$cargo_dir2 = "Rector(a)";
	}
	
 ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">


<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.Estilo3 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->



<table width="700" border="0"  cellpadding="0" cellspacing="0">
  <tr>
    <td><div id="capa0">
	<table width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
	<td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
	</td></tr></table>
      </div></td>
  </tr>
</table>
<?
if ($cod_tipo==110){
    $grado_curso = 8;
}
if ($cod_tipo==310){
    $grado_curso = 4;
}	

$sql_alumnos="select alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.rut_alumno, alumno.dig_rut from alumno where rut_alumno in (select rut_alumno from promocion where  situacion_final='1' and id_curso in  (select id_curso from curso where id_ano = '$_ANO' and ensenanza = '$cod_tipo' and grado_curso = '$grado_curso'))  order by ape_pat, ape_mat, nombre_alu";
$result_alumnos= @pg_Exec($conn,$sql_alumnos);
?>
<table width="700" border="0"  cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="logo_gobierno.jpg" width="121" height="81"><br>
          <br>
          <br>
          <br></td>
      </tr>
      <tr>
        <td><div align="center" class="Estilo2">N&oacute;mina de Alumnos Licenciados</div>
          <?php 
		  $tipo_ensenanza = $ensenanza['ensenanza'];
		  
		  $sql_ense = "select * from tipo_ensenanza where cod_tipo = '$tipo_ensenanza'";
		  $res_ense = @pg_Exec($conn,$sql_ense);
		  $fil_ense = @pg_fetch_array($res_ense);
		  
		  $nombre_ensenanza = $fil_ense['nombre_tipo'];
		  
		  echo "<font face=verdana size=1><div align=center>$nombre_ensenanza</div></font>";
		  
		  ?>
     </td>
      </tr>
    </table>
      <br>
      <br>
      <br>
      <table width="100%" border="1" cellpadding="3" cellspacing="1" bordercolor="#999999">
        <tr>
          <td colspan="5">
		  
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="20%"><span class="Estilo2">Establecimiento</span></td>
              <td width="50%" class="Estilo2"><?=$nombre_institucion ?></td>
              <td width="15%" class="Estilo3">A&ntilde;o escolar </td>
              <td width="15%" class="Estilo3"><font size="1" face="Arial, Helvetica, sans-serif"><?=$nro_ano ?></font></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="Estilo3">Regi&oacute;n</td>
              <td class="Estilo3"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $region['nom_reg']?></font></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="Estilo3">Provicnia</td>
              <td class="Estilo3"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $ciudad['nom_pro']?></font></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="Estilo3">Comuna</td>
              <td class="Estilo3"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $comuna['nom_com']?></font></td>
            </tr>
          </table>
            <br></td>
        </tr>
        <tr>
          <td width="5%" height="25" bgcolor="#CCCCCC"><span class="Estilo1">N&ordm;</span></td>
          <td width="23%" bgcolor="#CCCCCC"><span class="Estilo1">Apellido Paterno </span></td>
          <td width="23%" bgcolor="#CCCCCC"><span class="Estilo1">Apellido Materno </span></td>
          <td width="33%" bgcolor="#CCCCCC"><span class="Estilo1">Nombres </span></td>
          <td width="15%" bgcolor="#CCCCCC"><span class="Estilo1">R.U.N.</span></td>
        </tr>
		<?
		for($x=0;$x<@pg_numrows($result_alumnos);$x++){ 
            $fila_alumnos = pg_fetch_array($result_alumnos,$x);
            $ape_pat      = $fila_alumnos['ape_pat'];
			$ape_mat      = $fila_alumnos['ape_mat'];
			$nombre_alu   = $fila_alumnos['nombre_alu'];
			$rut_alumno   = $fila_alumnos['rut_alumno'];
			$dig_rut      = $fila_alumnos['dig_rut'];
			?>		
			<tr>
			  <td class="Estilo3"><?=$x + 1; ?></td>
			  <td class="Estilo3"><?=$ape_pat ?></td>
			  <td class="Estilo3"><?=$ape_mat ?></td>
			  <td class="Estilo3"><?=$nombre_alu ?></td>
			  <td class="Estilo3"><? echo "$rut_alumno-$dig_rut"; ?></td>
			</tr>
			<?
			
			if ($x==25){ ?>
			    </table>		   
			    <H1 class=SaltoDePagina>&nbsp;</H1>
			    <table width="100%" border="1" cellpadding="3" cellspacing="1" bordercolor="#999999">
            
		  <? } 
			
			
		}
		
		?>	
      </table>
      <br>
      <br>
      <br>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="Estilo3"><?php echo ucwords(strtolower($comuna['nom_com'])).", ".$dia." de ".$mes." del ".$ano2 ?>&nbsp;<br>
            <br>
            <br>
            <br></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="Estilo1"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="50%" class="Estilo1">
				<div align="center">
				 _________________________<br>
		  <?=$enomina ?>	  
		  <br>
          ENCARGADO DE CONFECCION DE NOMINAS</div>
				</td>
                <td width="50%" class="Estilo1">
				<div align="center">
				 _________________________<br>
		  <?
		  if ($_INSTIT==1756){
		     echo "RAQUEL GUERRERO OVALLE"; 
		  
		  }else{
              echo "$nombre_director";
		  }
		  
		  ?>	  
		  <br>
           DIRECTOR(A) DEL ESTABLECIMIENTO<? //=$cargo_dir2 ?></div>
				</td>
              </tr>
            </table></td>
        </tr>
      </table>
      <br></td>
  </tr>
</table>
<br>

<!-- FIN CUERPO DE LA PAGINA -->

</body>
</html>
<? pg_close($conn);?>