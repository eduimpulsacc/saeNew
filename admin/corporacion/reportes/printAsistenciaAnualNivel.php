<? 

include("../controlador/controlador_1.php");


$corporacion	= $_CORPORACION;
$ano			= $cmbANO;
$estados		= $cmb_estados;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte Sostenedor Corporativo</title>
<link href="../estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style>
<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
	  
		  
</script>
<link href="../../../../../admin/corporacion/estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {font-weight: bold; background-color: #CCCCCC; text-align: center;}
.Estilo3 {font-family:Verdana, Arial, Helvetica, sans-serif; text-align:center; font-weight: bold; background-color: #CCCCCC;}
-->
</style>
</head>
<body>
<div id="capa0">
  <table width="650" border="0" align="center">
    <tr>
      <td><input type="button" name="Submit" value="VOLVER" onClick="javascript:history.back(1) " class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" />
      </div></td>
	  
    </tr>
  </table>
</div>
<br />
<table width="750" height="843" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="113" valign="top">
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="../images/linea2.jpg" width="730" height="4" /></td>
        </tr>
        <tr>
          <td rowspan="5"> <?  echo "<img src='../images/".$corporacion."_logo.jpg' >"; ?></td>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$nombre;?></div></td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$direc;?></div></td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$fono;?></div></td>
        </tr>
        <tr>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><img src="../images/linea.jpg" width="730" height="4" /></td>
        </tr>
      </table>
      <br />
      <br />
	      <? $sql="SELECT nombre FROM niveles WHERE id_nivel=".$cmbNIVEL;
			$rs_nivel=@pg_exec($conn,$sql);
			$result_nivel = pg_result($rs_nivel,0);
			?>
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td class="titulo1">TOTAL DE ASISTENCIA ANUAL DE TODOS LOS ESTABLECIMIENTOS POR NIVELES <br />
            NIVEL <?=$result_nivel?>,
            A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />
								<table width="100%" border="1" cellpadding="3" cellspacing="0">
                                 <tr>
                                   <td rowspan="2" class="celdas1">ESTABLECIMIENTOS</td>
                                   <td colspan="10" class="celdas1"><div align="center"><strong>MESES</strong></div></td>
                                   <td rowspan="2" class="celdas1"><div align="center"><strong>TOTAL</strong></div></td>
                                 </tr>
								 <? 
								 $sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb";
								 $sql.=" INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where";
								 $sql.="  num_corp=".$corporacion."  AND nro_ano=".$cmbANO." ORDER BY nombre_instit ASC";
									$rs_instit = @pg_exec($conn,$sql); 
									
									
									?>
									
                                 <tr>
                                   <? for($j=3;$j<13;$j++){?>
                                   <td class="celdas1">&nbsp;
                                       <?=substr(envia_mes($j),0,3);?></td>
                                   <? } ?>
                                 </tr>
								 <? 
								 for($k=0;$k<@pg_numrows($rs_instit);$k++){
										$fila_inst = @pg_fetch_array($rs_instit,$k);
										$total_colegio=0;
										$numero_matricula=0;
										$matricula=0;
										$inasistencia=0;
										$fin_semana=0;
										$feriado=0;
										$total_mes=0;
										$dia_mes=0;
										$total_habiles=0;
										$total_mes=0;

								
										?>
                                 <tr>
                                   <td class="text2"><?=$fila_inst['nombre_instit'];?></td>
                                   <? 
								     for($i=3;$i<13;$i++){
						   				$sql = "select count(*) from asistencia WHERE ano=".$fila_inst['id_ano']." AND";
										$sql.=" date_part('month',fecha)=".$i." AND id_curso in (SELECT id_curso FROM curso WHERE";
										$sql.=" id_nivel=".$cmbNIVEL.")";										
										$rs_asistencia = @pg_exec($conn,$sql);
										$inasistencia = @pg_result($rs_asistencia,0);
										
								   		$sql = "select count(*) as cuenta,b.id_ano from matricula a INNER JOIN ano_escolar b ON";
										$sql.=" a.id_ano=b.id_ano INNER JOIN curso c ON c.id_ano=a.id_ano AND c.id_curso=a.id_curso AND";
										$sql.=" c.id_ano=b.id_ano WHERE a.id_ano=".$fila_inst['id_ano']." AND ";
										$sql.="id_institucion=".$fila_inst['rdb']." AND fecha<='".$i."-30-".$cmbANO."' AND ";
										$sql.="c.id_nivel=".$cmbNIVEL."  AND bool_ar=0 GROUP BY b.id_ano ";
									
										$rs_mat = @pg_exec($conn,$sql);
										$fila_cont = pg_fetch_array($rs_mat,0);
										$numero_matricula = @pg_result($rs_mat,0);
										$ano_matricula = $fila_cont['id_ano'];
										
										//---------------FERIADO ---------------
										$sql = "select sum((fecha_fin - fecha_inicio) + 1) as feriado from feriado where ";
										$sql.="id_ano=".$fila_inst['id_ano']." and date_part('month',fecha_inicio)=".$i;
										$rs_feriado = @pg_exec($conn,$sql);
										$feriado = @pg_result($rs_feriado,0);
										$fin_semana=0;
										if($i==3 || $i==5 || $i==7 || $i==8 || $i==10 || $i==12){
											$dia_mes =31;
											for($l=1;$l<=$dia_mes;$l++){
												$fecha_semana = mktime(0,0,0,$i,$l,$cmbANO); 
												$dia_semana = strftime("%a",$fecha_semana);
												if($dia_semana=="Sat" || $dia_semana=="Sun"){
													$fin_semana++;
												}
											}
											$total_mes=($dia_mes - $feriado) - $fin_semana;
											//echo "<br>".$fila_inst['rdb']." ".$i." ".$total_mes;
										}else{
											$dia_mes =30;
											for($l=1;$l<=$dia_mes;$l++){
												$fecha_semana = mktime(0,0,0,$i,$l,$cmbANO); 
												$dia_semana = strftime("%a",$fecha_semana);
												if($dia_semana=="Sat" || $dia_semana=="Sun"){
													$fin_semana++;
												}
											}
											$total_mes = ($dia_mes - $feriado) - $fin_semana;

										}
										
										$total_habiles=$total_mes;

										//echo "<br>".$fila_inst['rdb']." ".$i." ".$numero_matricula." ".$total_habiles. " ".$inasistencia;
										$matricula = ($numero_matricula * $total_habiles) - $inasistencia;

										?>
                                   <td class="text2"><div align="center">
                                     <?=number_format($matricula,'0',',','.');?>
                                   </div></td>
                                   <?
								   		$total_colegio = $total_colegio + $matricula;
								   		$total_meses[$i] = $total_meses[$i] + $matricula;   //<------NO FUNCIONA ASIGNANDO ASI!

										
								   } ?>
                                   <td class="celdas1"><div align="center">
                                     <?=number_format($total_colegio,'0',',','.');?>
                                   </div></td>
                                 </tr>
								 <? } ?>
                                 <tr>
                                   <td class="celdas1">TOTAL</td>
                                   <? for($m=3;$m<13;$m++){?>
                                   <td class="celdas1"><div align="center">
                                     <?=number_format($total_meses[$m],'0',',','.');?>
                                   </div></td>
                                   <? $total_gral = $total_gral + $total_meses[$m];
								   } ?>
                                   <td class="celdas1"><div align="center">
                                     <?=number_format($total_gral,'0',',','.');?>
                                   </div></td>
                                 </tr>
                               </table>

    <br />
    <br />
    <br /></td>
  </tr>
  
  <tr>
  <? 
	
	 setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
     $fechaEspañol = strftime("%A %d de %B del %Y");
	 
	?>
    <td valign="baseline"><HR />
       <div align="right" class="fecha"> <?=$fechaEspañol?> </div></td>
  </tr>
</table>
</body>
</html>