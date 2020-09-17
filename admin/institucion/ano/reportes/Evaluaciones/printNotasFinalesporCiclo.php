<? 
require('../../../../../util/header.inc'); 
include('../../../../clases/class_Reporte.php');

//setlocale("LC_ALL","es_ES");
$institucion	= $_INSTIT;
$ano			= $_ANO;
$reporte		=$c_reporte;



//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	

/// tomar nombre de la institucion
$qry2="SELECT nombre_instit FROM institucion WHERE rdb = '$_INSTIT'";
$result2 =@pg_Exec($conn,$qry2);
$fila2 = @pg_fetch_array($result2,0);
$nombre_institucion = $fila2['nombre_instit'];


/// tomar el número de año
$qry4="SELECT nro_ano FROM ano_escolar WHERE id_ano = '$ano'";
$result4 =@pg_Exec($conn,$qry4);
$fila4 = @pg_fetch_array($result4,0);
$nro_ano = $fila4['nro_ano'];

///  tomo el nombre del ciclo
$qry5 = "select ciclo_conf.id_ciclo, ciclo_conf.nomb_ciclo from ciclo_conf where rdb = '$institucion' and id_ano = '$ano' and id_ciclo = '$cmbCICLO' ";	
$result5 =@pg_Exec($conn,$qry5);
$fila15 = @pg_fetch_array($result5,0);	
$nombre_ciclo   = $fila15['nomb_ciclo'];
	
/// tomar todos los subsectores de los cursos al que pertenece este nivel
$qry6 = "select ramo.cod_subsector, subsector.nombre, ramo.modo_eval from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector where id_curso in (select id_curso from ciclos where id_ciclo = '$cmbCICLO' and id_ano = '$ano') AND ramo.modo_eval<>3 AND ramo.modo_eval<>4 group by ramo.cod_subsector, subsector.nombre, ramo.modo_eval order by subsector.nombre";
$result6 =@pg_Exec($conn,$qry6);
for ($i=0; $i < @pg_numrows($result6); $i++){
     $fila6 = @pg_fetch_array($result6,$i);	
     $nombre_subsector_[]   = $fila6['nombre'];
	 $cod_subsector_[]      = $fila6['cod_subsector'];
}	

// tomar los niveles asociados
$qry7 = "select id_nivel, nombre from niveles where id_nivel in (select id_nivel from ciclo_niveles where id_ciclo = '$cmbCICLO' and id_ano = '$ano' and rdb = '$institucion') order by id_nivel";
$result7 =@pg_Exec($conn,$qry7);
for ($i=0; $i < @pg_numrows($result7); $i++){
     $fila7 = @pg_fetch_array($result7,$i);	
     $nombre_nivel_[]  = $fila7['nombre'];
	 $id_nivel_[]      = $fila7['id_nivel'];
}	

// tomar los períodos de la institucion
$qry8 = "select id_periodo, nombre_periodo from  periodo where id_ano = '$ano' order by id_periodo";
$result8 =@pg_Exec($conn,$qry8);
for ($i=0; $i < @pg_numrows($result8); $i++){
     $fila8 = @pg_fetch_array($result8,$i);	
     $nombre_periodo_[]  = $fila8['nombre_periodo'];
	 $id_periodo_[]      = $fila8['id_periodo'];
	 
}	


	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style>
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo13 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; color:#000000; }
.Estilo14 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color:#FFFFFF;
}
</style>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
.Estilo25 {font-weight: bold; }
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

<body>
<div id="capa0">
<table width="650" align="center">
  <tr><td>
   <input name="button4" type="submit" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
        <font size="1" face="Arial, Helvetica, sans-serif"></font>
   <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
  </td></tr></table>
</div>

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">

	<table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
			  <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
			  <tr>
                <td width="114"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"></font></div></td>
                <td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font></td>
                <td width="361"><div align="left"></div></td>
                <td width="161" rowspan="7" align="center" valign="top" >
				<?
		$result_foto = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result_foto,0);
		$fila_foto = @pg_fetch_array($result_foto,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."../tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
				</td>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"></font></div></td>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font></td>
                <td><div align="left"></div></td>
                </tr>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"></font></div></td>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
				</font></div></td>
                </tr>	
              <tr>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="4" rowspan="6" align="center">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
			  <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
	<table width="650" border="1" cellspacing="0" cellpadding="3">
      <tr >
        <td colspan="5" class="tableindex">
          <div align="center" class="Estilo14">NOTAS FINALES POR CICLO</div></td>
      </tr>
      <tr>
        <td colspan="5"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
        </tr>
      <tr>
        <td width="178" class="Estilo13">Nombre Establecimiento</td>
        <td width="472" class="Estilo13">&nbsp;<?=$nombre_institucion?></td>
      </tr>
      <tr>
        <td class="Estilo13">Ciclo</td>
        <td class="Estilo13">&nbsp;<?=$nombre_ciclo?></td>
      </tr>
      <tr>
        <td class="Estilo13">A&ntilde;o</td>
        <td class="Estilo13">&nbsp;<?=$nro_ano ?></td>
      </tr>
    </table>
	<br>

          <table width="100%" border="1" cellpadding="2" cellspacing="0">
            <tr>
              <td colspan="8" class="tableindex"><div align="center" class="Estilo14">PROMEDIOS PERIODOS</div></td>
            </tr>
            <tr>
              <td class="Estilo13">Subsector</td>
			  <?
			  for ($i=0; $i < @pg_numrows($result8); $i++){
			        $prom_periodo_[$i] = 0;
				    $contador_col_sem_[$i] = 0;
				    ?>			  
			        <td class="Estilo7"><div align="center"><strong><?=$nombre_periodo_[$i]?></strong></div></td>
			<? } ?>	  
           
              
              <td class="Estilo7"><div align="center"><strong>Promedio Final</strong></div></td>
            </tr>
			<?		
			
			for ($i=0; $i < @pg_numrows($result6); $i++){ ?>
				<tr>
				  <td class="Estilo13"><?=$nombre_subsector_[$i]?></td>
				  
				   <?
			       for ($h=0; $h < @pg_numrows($result8); $h++){  // ciclo de periodos
				       $suma_promedio=0;
					   $contador_promedios=0;
				   
				       for ($j=0; $j < @pg_numrows($result7); $j++){
						  // rescato el promedio del subsector
						  //$qry9 = "select sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$nro_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_curso in (select id_curso  from nivel_curso where id_ano = '$ano' and id_nivel  in (select id_nivel from ciclo_niveles where rdb = '$institucion' and id_ciclo = '$cmbCICLO' and id_ano = '$ano' and id_nivel = '$id_nivel_[$j]'))   and id_ano = '$ano')  and cod_subsector = '$cod_subsector_[$i]') and id_periodo = '$id_periodo_[$h]' and promedio > 0";
						  $qry9= "SELECT sum(CAST(notas$nro_ano.promedio AS integer)) AS suma, count(promedio) AS cantidad FROM ramo INNER JOIN notas$nro_ano ON ramo.id_ramo=notas$nro_ano.id_ramo WHERE ramo.cod_subsector=".$cod_subsector_[$i]." AND notas$nro_ano.id_periodo=".$id_periodo_[$h]." AND notas$nro_ano.promedio not in ('MB','B','S','I','')";
						  
						  /*
						  $qry9 = "select sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$nro_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_curso in (select id_curso from ciclo_niveles where rdb = '$institucion' and id_ciclo = '$cmbCICLO' and id_ano = '$ano') and id_nivel = '$id_nivel_[$j]' and id_ano = '$ano') and cod_subsector = '$cod_subsector_[$i]') and id_periodo = '$id_periodo_[$h]' and promedio > 0";  */
    					  $result9 = @pg_Exec($conn, $qry9);
						  $fila9 = @pg_fetch_array($result9,0);
						  $cantidad = $fila9['cantidad'];
						  $suma     = $fila9['suma'];
						  $promedio = round($suma / $cantidad);  
						 						 
						  if ($promedio>0){
							   $suma_promedio = $suma_promedio + $promedio;
							   $contador_promedios++;
							   $prom_nivel_[$j] = $prom_nivel_[$j] + $promedio;	
							   $contador_col_[$j]++;			    
					      }	   
					      $promedio=0;
				       }
				  
				  	   $prom_sub_periodo = 	round($suma_promedio/$contador_promedios);
					   
					   if ($prom_sub_periodo>0){
					       $suma_prom_sub_periodo = $suma_prom_sub_periodo + $prom_sub_periodo;
						   $contador_prom_sub_periodo++;
						   $prom_periodo_[$h] = $prom_periodo_[$h] + $prom_sub_periodo;
						   $contador_col_sem_[$h]++;
						   
					   }
					   
					   ?>	
				        <td class="Estilo7"><div align="center">&nbsp;<? if ($prom_sub_periodo>0){ ?>  <? echo $prom_sub_periodo; ?> <? } ?></div></td>
				<? }
				
				  $prom_final_subsector = round($suma_prom_sub_periodo/$contador_prom_sub_periodo); 
				  ?>
				  <td class="Estilo7"><div align="center">&nbsp;<? if ($prom_final_subsector>0){ ?><?=$prom_final_subsector?><? } ?></div></td>
				</tr>
		 <? 
		 $suma_prom_sub_periodo=0;
		 $contador_prom_sub_periodo=0;
		 $prom_final_subsector=0;
		 
		 
		 } ?>	
				<tr>
				  <td class="Estilo13">Promedio Final</td>
				   <?
			      for ($i=0; $i < @pg_numrows($result8); $i++){  
				  
				      ?>	
				      <td class="Estilo7"><div align="center"><strong><? echo round($prom_periodo_[$i]/$contador_col_sem_[$i]);?></strong></div></td>
				 <? } ?> 
				  <td class="Estilo7"><div align="center"><strong>&nbsp;</strong></div></td>
				</tr>
			
      </table>
    </td>
  </tr>
</table>
<table width="1024" border="0">
		  <tr>
		  	<?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
			<td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000"><div align="center"><span class="item"><?=$ob_reporte->nombre_emp;?> </span><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? } ?>
			<? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
		    <td width="25%" class="item"><hr align="center" width="150" color="#000000"> 
		      <div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?></div></td>
			<? } ?>
			 <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
			<td width="25%" class="item"><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? } ?>
			 <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
		    <td width="25%" class="item"><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?> </div></td>
			<? }?>
		  </tr>
</table>
</body>
</html>
