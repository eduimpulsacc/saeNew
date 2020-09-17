<?

require('../../../../../util/header.inc'); 
echo "antes";

//require('../../../../clases/class_Reporte.php');
echo "despues";
//require('../../../../clases/class_Membrete.php');

echo $institucion	= $_INSTIT;
$ano			= $_ANO;


/*$ob_reporte = new Reporte();
$ob_membrete = new Membrete();

/*******INSITUCION *******************/
/*$ob_membrete ->institucion=$institucion;
$ob_membrete ->institucion($conn);*/

	 
/********** AÑO ESCOLAR*****************/
/*$ob_membrete ->ano = $ano;
$ob_membrete ->AnoEscolar($conn);
$nro_ano = $ob_membrete->nro_ano;*/




/// tomar nombre de la institucion
$qry2="SELECT nombre_instit FROM institucion WHERE rdb = '$_INSTIT'";
$result2 =@pg_Exec($conn,$qry2);
$fila2 = @pg_fetch_array($result2,0);
$nombre_institucion = $fila2['nombre_instit'];

	
/// tomar período
$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) and id_periodo = '$cmbPERIODO'";
$result =@pg_Exec($conn,$qry);
$fila1 = @pg_fetch_array($result,0);
$nombre_periodo = $fila1['nombre_periodo'];

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
$qry6 = "select ramo.cod_subsector, subsector.nombre from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector where id_curso in (select id_curso from ciclos where id_ciclo = '$cmbCICLO' and id_ano = '$ano') group by ramo.cod_subsector, subsector.nombre order by subsector.nombre";
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

	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<title></title>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<style>
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo8 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo9 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.item { font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;
}
</style>
</head>
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
<body>
<div id="capa0">
<table width="650" align="center">
  <tr><td>
   <input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
        <font size="1" face="Arial, Helvetica, sans-serif"></font>
   <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td></tr></table>
</div>

<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="487" height="20" class="item"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
      <tr valign="top" >
        <td width="125" align="center"><?
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			## c&oacute;digo para tomar la insignia
	
			  if($institucion!=""){
				   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }
		?>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20" class="item"><? echo ucwords(strtolower($ob_membrete->direccion));?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="20" class="item">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">

	<table width="650" border="0" cellspacing="0" cellpadding="0">
 
</table>

	<table width="650" border="1" cellspacing="0" cellpadding="3">
      <tr >
        <td height="40" colspan="5" >
          <div align="center" class="Estilo8 Estilo9">NOTAS POR CICLO</div></td>
      </tr>
      
      <tr>
        <td width="178" class="Estilo7"><strong>Nombre Establecimiento</strong></td>
        <td width="472" class="Estilo7">&nbsp;<?=$nombre_institucion?></td>
      </tr>
      <tr>
        <td class="Estilo10">Ciclo</td>
        <td class="Estilo7">&nbsp;<?=$nombre_ciclo?></td>
      </tr>
      <tr>
        <td class="Estilo10">Per&iacute;odo</td>
        <td class="Estilo7">&nbsp;<?=ucwords(strtolower($nombre_periodo));?></td>
      </tr>
      <tr>
        <td class="Estilo10">A&ntilde;o</td>
        <td class="Estilo7">&nbsp;<?=$nro_ano ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
  <br>
          <table width="650" border="1" cellpadding="2" cellspacing="0" class="Estilo7">
            <tr>
              <td height="40" colspan="<?=@pg_numrows($result7)+2;?>"><div align="center" class="Estilo8">PROMEDIO NIVELES</div></td>
            </tr>
            <tr>
              <td width="209" height="35" ><strong>Subsector</strong></td>
			  <?
			  for ($j=0; $j < @pg_numrows($result7); $j++){
			      $prom_nivel_[$j]   = 0;
				  $contador_col_[$j] = 0;
				 
                  ?>    
                  <td ><div align="center"><strong><?=$nombre_nivel_[$j]?></strong></div></td>             
                  <?
			  }
			  
			  ?>		  
			  <td width="104" align="center"><strong>Promedio<br /> 
		      Final</strong></td>
            </tr>
			<?
			
			
			for ($i=0; $i < @pg_numrows($result6); $i++){ ?>	
               <tr>
                 <td><strong><?=$nombre_subsector_[$i]?></strong></td>
                 <?			 
				 
				 for ($j=0; $j < @pg_numrows($result7); $j++){
                      // rescato el promedio del subsector
					  $qry8 = "select sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$nro_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_curso in (select id_curso  from nivel_curso where id_ano = '$ano' and id_nivel  in (select id_nivel from ciclo_niveles where rdb = '$institucion' and id_ciclo = '$cmbCICLO' and id_ano = '$ano' and id_nivel = '$id_nivel_[$j]'))   and id_ano = '$ano')  and cod_subsector = '$cod_subsector_[$i]') and id_periodo = '$cmbPERIODO' and promedio > 0";
					  $result8 = @pg_Exec($conn, $qry8);
					  $fila8 = @pg_fetch_array($result8,0);
					  $cantidad = $fila8['cantidad'];
					  $suma     = $fila8['suma'];
					  $promedio = round($suma / $cantidad);  
					  				 					                      
					  ?>			 
				       <td><div align="center">&nbsp;<? if ($promedio>0){
				
				         /*	     
						 echo "<br><br>consulta: ".$qry8;
						 echo "<br>p: ".$promedio;
						 */
					    ?><?=$promedio?><? } ?></div></td>
                      <?
					  if ($promedio>0){
					       $suma_promedio = $suma_promedio + $promedio;
					       $contador_promedios++;
						   $prom_nivel_[$j] = $prom_nivel_[$j] + $promedio;	
						   $contador_col_[$j]++;			    
					  }	   
					  $promedio=0;
				}
				
				?>				 
                 <td align="center"><? echo round($suma_promedio/$contador_promedios)?></td>
               </tr>
		     <? 
		     $contador_promedios=0;
		     $suma_promedio = 0;
		
		   } 
		   
		   ?>			
            <tr>
              <td><strong>Promedio Final</strong></td>
              <?
			  for ($j=0; $j < @pg_numrows($result7); $j++){		  
				  
				  ?>			  
			      <td><div align="center"><strong><? echo round($prom_nivel_[$j]/$contador_col_[$j]);?></strong></div></td>
                  <?
			  }
			  ?>
			  
			  <td><strong>&nbsp;</strong></td>
            </tr>
      </table>
</td>
  </tr>
</table>
</body>
</html>
