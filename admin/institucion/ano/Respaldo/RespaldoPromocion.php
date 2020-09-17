<?php require('../../../../util/header.inc');
include('../../../clases/class_Membrete.php');
//print_r($_POST);
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_POST['ano'];
	$curso=   $_POST['cmb_curso'];
	$sw 			= 1;
	
	//------------
//	echo $id_curso."<br>";
//	echo $id_periodo."<br>";
//	echo $id_ramo."<br>";
//	exit;
	//------------	
	$ls_string 		= ""		;
	$salto 			= "\n"		;
	$ls_espacio		= chr(9)	;
	
	$ob_membrete = new Membrete();
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	//----------------
	//----------------------------------------------------------------------------	
	function InicialesSubsector($Subsector)
{
	$largo = strlen($Subsector);
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
		}
		$letra_query = substr($Subsector,$cont_letras,1);
		if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
		if (strlen($cadena)==6 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		echo trim(strtoupper(substr($Subsector,0,3)));
	else
		echo trim($cadena);
}


if($cb_ok!="Ver"){
 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Respaldo_Promocion_$fecha_actual.xls"); 	 
}	


?>



<html>
<head>
<title>RESPALDO DE PROMOCION</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="javascript">

function exportar(){
		   	//form.target="_blank";
	window.location='RespaldoPromocion.php?id_curso=<?=$curso?>&cmb_ano=<?=$ano?>&xls=1';
			form.submit(true);
			//return false;
		  }		
</script>
</head>
<body >
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="capa0">
		<table width="100%">
		  <tr><td><input name="button4" type="button" class="botonXX" onClick="window.close()"   
		  value="CERRAR">
          
		  </td>
		<td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  
		  </td></tr></table>
        
      </div>
    </td>
  </tr>
</table>

<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br>";
	   
  }else{

	?>

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487" class="item"><strong><? echo strtoupper(trim($ob_membrete->ins_pal));?></strong></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">

      <table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top" >
          <td width="125" align="center">
		  	<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>		  </td>
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td class="item"><? echo ucwords(strtolower($ob_membrete->direccion));?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="item">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="item">Curso:&nbsp;<? echo $Curso_pal;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<? } ?>

<table width="100%" border="1" style="font-size:10px">
		<tr>
			<td align="center" colspan="20"class="tableindex">PROMOCION</td>
		</tr>
		<tr align="center">
			<td class="item">RUT</td>
			<td class="item" width="20%">NOMBRE ALUMNO</td>
            <?
            	 $sql_ramo="select id_ramo,nombre from subsector  
                INNER JOIN RAMO ra on ra.cod_subsector=subsector.cod_subsector
                 where ra.id_curso=".$curso;
		 $rs_ramo=pg_exec($conn,$sql_ramo);
		 $cont_ramo = @pg_numrows($rs_ramo);
		 for($i=0; $i<$cont_ramo; $i++){
		 $fila_ramo = @pg_fetch_array($rs_ramo,$i);	
		  $nombreRamo=$fila_ramo['nombre'];?>
		  <td class="item">
          <?
		  InicialesSubsector($fila_ramo['nombre']);
		 }
			?>
            
            </td>
            <td class="item">PROMEDIO</td>
			<td class="item">ASISTENCIA</td>
            <td class="item">SITUACION</td>
            <td class="item">OBSERVACION</td>
		</tr>
	<? 
 $sql_ramos ="select Distinct a.rut_alumno,a.dig_rut, a.ape_pat ||' '|| a.ape_mat ||' '|| a.nombre_alu as nombre_alu, p.promedio as promediofinal,p.asistencia,p.situacion_final,p.observacion, ps.promedio as promediosub
from promocion p 
INNER JOIN alumno a ON p.rut_alumno=a.rut_alumno 
INNER JOIN promedio_sub_alumno ps ON ps.rut_alumno=p.rut_alumno and ps.id_curso=p.id_curso
where p.id_curso=".$curso." ORDER BY nombre_alu  ASC";
	$result_ramos =@pg_Exec($conn,$sql_ramos)or die("FALLO!".$sql_ramos);
	 $cont_ramos = @pg_numrows($result_ramos);	
	
	//if($_PERFIL==0) echo "<br>".$sql_ramos;
	for($cont_sub=0 ; $cont_sub<$cont_ramos; $cont_sub++)
	{
		//$apreciacion=0;
		$fila_ramos = @pg_fetch_array($result_ramos,$cont_sub);
		//$ramo = $fila_ramos['id_ramo'];
		$subsector = $fila_ramos['id_ramo'];
		$rut_alumno= $fila_ramos['rut_alumno'];
		$nombre_alu= $fila_ramos['nombre_alu'];
		$nombre_alu_cortado=substr($nombre_alu,0,24);
		$situacion_final=$fila_ramos['situacion_final'];
		
	if ($situacion_final == 1) {
		$situacion_final= "APROBADO";
		} elseif ($situacion_final == 2) {
		$situacion_final= "REPROBADO";
		} elseif ($situacion_final == 3) {
		$situacion_final= "RETIRADO";
	}
	
	if($rut_alumno!=$rut_alum){
	
	 ?>
		<tr align="left">
			<td class="subitem">&nbsp;<?=$rut_alumno;?></td>
			<td class="subitem">&nbsp;<?=$nombre_alu_cortado;?></td>
            <?
			$rs_ramo=pg_exec($conn,$sql_ramo);
		    $cont_ramo = @pg_numrows($rs_ramo);
            for($j=0; $j<$cont_ramo; $j++){
			$fila_ramo = @pg_fetch_array($rs_ramo,$j);
			$id_ramo=$fila_ramo['id_ramo'];
		 ?>
		  <td class="item">
          <?
		  
		   $sql_prom="select promedio  from promedio_sub_alumno where id_curso=".$curso."	and id_ramo=".$id_ramo." and rut_alumno=".$rut_alumno;
		  $resul_prom=pg_exec($conn,$sql_prom)or die("Fallo ".$sql_prom);
		  
		 	for($y=0; $y<pg_numrows($resul_prom); $y++){
				
			$fila_prom=pg_fetch_array($resul_prom,$y);
			 $promedio=$fila_prom['promedio'];
			 echo $promedio;
			}
		  
		 
			?>
            </td>
            <? }?> 
			<td class="subitem">&nbsp;<?=$fila_ramos['promediofinal']; ?></td>
            <td class="subitem">&nbsp;<?=$fila_ramos['asistencia']."%"; ?></td>
            <td class="subitem">&nbsp;<?=$situacion_final; ?></td>
            <td class="subitem">&nbsp;<?=$fila_ramos['observacion']; ?></td>
		</tr>	
<? }	$rut_alum=$rut_alumno;
}	?>
  </table>
</center>	
<?		


		

	
?>

 
</center>
</body>
</html>
<? pg_close ($conn);?>