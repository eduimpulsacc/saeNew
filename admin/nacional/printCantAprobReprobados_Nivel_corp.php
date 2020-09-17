<?php require('../../util/header.inc');	

$corporacion   =$_CORPORACION;


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo8 {font-size: 10px}
.Estilo10 {color: #0099FF}
#subsectores { width: 400px;
height: 200px;
/*background-color: #366;*/
float: left;
position:relative; 
border: 1px solid #808080; 
overflow: auto; 
top:0px; 
left:0px; 

}
.Estilo11 {font-size: 9px}
.Estilo20 {
	font-size: 9px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo21 {font-size: 9}
.Estilo25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo26 {font-size: 9; font-family: Verdana, Arial, Helvetica, sans-serif; }
.Estilo28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }

-->
</style>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="capa0">
<table width="650" align="center">
  <tr><td>
   <input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
        <font size="1" face="Arial, Helvetica, sans-serif"></font>
   <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td></tr></table>
</div>
<?
// tomar Los datos del nivel seleccionado
$qry7 = "select id_nivel, nombre from niveles where id_nivel = '$id_nivel'";
$result7 =@pg_Exec($conn,$qry7);
for ($i=0; $i < @pg_numrows($result7); $i++){
	 $fila7 = @pg_fetch_array($result7,$i);	
	 $nombre_nivel  = $fila7['nombre'];
	 $id_nivel      = $fila7['id_nivel'];
}	


$qry2="SELECT institucion.nombre_instit, institucion.rdb FROM institucion inner join corp_instit on institucion.rdb = corp_instit.rdb  WHERE corp_instit.num_corp = '".$_CORPORACION."'  group by institucion.rdb, institucion.nombre_instit";
$result2 =@pg_Exec($conn,$qry2);
for ($i=0; $i < @pg_numrows($result2); $i++){
	$fila2 = @pg_fetch_array($result2,$i);
	$nombre_institucion_[] = $fila2['nombre_instit'];
	$rdb_[] = $fila2['rdb'];
	
	/// tomar el número número de año seleccionado
	$qry4="SELECT nro_ano, id_ano FROM ano_escolar WHERE nro_ano = '".$cmb_ano."' and id_institucion = '$rdb_[$i]'";
	$result4 =@pg_Exec($conn,$qry4);
	if (pg_numrows($result4)==0){
		$id_ano_[] = 0;
	}else{
		$fila4 = @pg_fetch_array($result4,0);
		$id_ano_[] = $fila4['id_ano'];
	}						
	
}					

?>			 
				 
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
<tr>
 <td valign="top">
	 <table width="650" border="1" cellspacing="0" cellpadding="3">
	   <tr >
		 <td colspan="5" class="tableindex"><div align="center">CANTIDAD APROBADOS Y REPROBADOS DE TODOS LOS ESTABLECIMIENTOS POR NIVEL </div></td>
	   </tr>
	   <tr>
		 <td colspan="5"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
	   </tr>
	  
	   <tr>
		 <td width="10%" class="Estilo28"><b>A&ntilde;o</b></td>
		 <td width="90%" class="Estilo28">&nbsp;
			 <?=$nombre_nivel ?></td>
	   </tr>
	  
	   <tr>
		 <td width="10%" class="Estilo28"><b>A&ntilde;o</b></td>
		 <td width="90%" class="Estilo28">&nbsp;
			 <?=$cmb_ano ?></td>
	   </tr>
	 </table>
   <br>
	 <table width="650" border="1" cellpadding="2" cellspacing="0" class="Estilo7">
	   <tr>
		 <td>&nbsp;</td>
		 <td colspan="<?=$num_est?>" align="center" class="Estilo28">Establecimientos</td>
		 <td>&nbsp;</td>
	   </tr>
	   <tr>
		 <td class="Estilo28">&nbsp;</td>
		  <?
		  for ($i=0; $i < @pg_numrows($result2); $i++){
			  
			  ?>
			  <td align="center"><span class="Estilo28"><?=$nombre_institucion_[$i]?></span></td>
			  <?
		  }
		  ?>                                         
		 <td align="center"><span class="Estilo28">Total </span></td>
	   </tr>
	  
	
									  
			  <tr>
				<td class="Estilo28">Aprobados</td>									
				   <?
				   for ($i=0; $i < @pg_numrows($result2); $i++){
					  // consultar en promoción la situación de los alumnos
					  $sql_apro = "select count(*) as cantidad from promocion where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and id_nivel = '$id_nivel') and situacion_final = '1'";
					  $res_apro = @pg_Exec($conn, $sql_apro);
					  $fil_apro = @pg_fetch_array($res_apro);
					  $suma1 = $suma1 + $fil_apro['cantidad'];
																		  
					  ?>
					  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_apro['cantidad'];?></span></td>
					  <?
				   }
				   ?> 
				   <td align="center" class="Estilo28">&nbsp;<?=$suma1?></td>
			  </tr>
			  <tr>
				<td class="Estilo28">Reprobados</td>									
				   <?
				   for ($i=0; $i < @pg_numrows($result2); $i++){
					  // alumnos reporbados
					  $sql_rep = "select count(*) as cantidad from promocion where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and id_nivel = '$id_nivel') and situacion_final = '2'";
					  $res_rep = @pg_Exec($conn, $sql_rep);
					  $fil_rep = @pg_fetch_array($res_rep);
					  $suma2 = $suma2 + $fil_rep['cantidad'];
					  ?>
					  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_rep['cantidad'];?></span></td>
					  <?
				   }
				   ?> 
				   <td align="center" class="Estilo28">&nbsp;<?=$suma2?></td>
			  </tr>
			  <tr>
				<td class="Estilo28">Por Inasistencia</td>									
				   <?
				   for ($i=0; $i < @pg_numrows($result2); $i++){
					  // alumnos reporbados por Inasistencia
					  $sql_rep_ina = "select count(*) as cantidad from promocion where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and id_nivel = '$id_nivel') and situacion_final = '2' and tipo_reprova = '2'";
					  $res_rep_ina = @pg_Exec($conn, $sql_rep_ina);
					  $fil_rep_ina = @pg_fetch_array($res_rep_ina);
					  $suma3 = $suma3 + $fil_rep_ina['cantidad'];
					  ?>
					  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_rep_ina['cantidad'];?></span></td>
					  <?
				   }
				   ?> 
				   <td align="center" class="Estilo28">&nbsp;<?=$suma3?></td>
			  </tr>
			  <tr>
				<td class="Estilo28">Por Rendimiento</td>									
				   <?
				   for ($i=0; $i < @pg_numrows($result2); $i++){
					  // alumnos reporbados por Rendimiento
					  $sql_rep_ren = "select count(*) as cantidad from promocion where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and id_nivel = '$id_nivel') and situacion_final = '2' and tipo_reprova = '1'";
					  $res_rep_ren = @pg_Exec($conn, $sql_rep_ren);
					  $fil_rep_ren = @pg_fetch_array($res_rep_ren);
					  $suma4 = $suma4 + $fil_rep_ren['cantidad'];
					  ?>
					  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_rep_ren['cantidad'];?></span></td>
					  <?
				   }
				   ?> 
				   <td align="center" class="Estilo28">&nbsp; <?=$suma4?></td>
			  </tr>                                       
   </table></td>
</tr>
</table>
</body>
</html>
