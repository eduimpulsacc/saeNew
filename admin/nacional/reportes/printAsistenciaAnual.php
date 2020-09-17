<?

include("../controlador/controlador_1.php");


$corporacion	= $_CORPORACION;
//$corporacion	= 2; 	//Usar esta corporación para pruebas si es que no existen datos en corporación
$ano			= $cmbANO;


function habiles($mes,$anno){
   $habiles = 0; 
   // Consigo el número de días que tiene el mes mediante "t" en date()
   $dias_mes = date("t", mktime(0, 0, 0, $mes, 1, $anno));
   // Hago un bucle obteniendo cada día en valor númerico, si es menor que 
   // 6 (sabado) incremento $habiles
   for($i=1;$i<=$dias_mes;$i++) {
	   if (date("N", mktime(0, 0, 0, $mes, $i, $anno))<6) $habiles++;
   }

   return $habiles;
}



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
<table width="900" height="843" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="113" valign="top">
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="../images/linea2.jpg" width="900" height="4" /></td>
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
          <td colspan="2"><img src="../images/linea.jpg" width="900" height="4" /></td>
        </tr>
      </table>
      <br />
      <br />
      <br />
		<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td class="titulo1">TOTAL DE ASISTENCIA ANUAL DE TODOS LOS ESTABLECIMIENTOS 
           <br />
          A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
	    <br />
      <br />
		<table width="100%" border="1" cellpadding="3" cellspacing="0">
                                 <tr>
                                   <td rowspan="2" class="celdas1">RBD</td>
                                   <td rowspan="2" class="celdas1">ESTABLECIMIENTOS</td>
                                   <td colspan="11" class="celdas1">MESES</td>
                                   <td rowspan="2" class="celdas1">TOTAL</td>
                                 </tr>
								 <? 

/*$sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO." ORDER BY nombre_instit ASC";*/

		$sql = "SELECT a.rdb,nombre_instit,c.id_ano 
					FROM institucion a 
					INNER JOIN corp_instit b ON a.rdb=b.rdb 
					INNER JOIN nacional_corp on nacional_corp.num_corp = b.num_corp
					INNER JOIN nacional on nacional.id_nacional = nacional_corp.id_nacional
					INNER JOIN ano_escolar c ON (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) 
					WHERE nacional.id_nacional = ".$corporacion." AND c.nro_ano = ".$cmbANO." ORDER BY b.rdb ASC; ";
					$rs_instit = @pg_exec($conn,$sql); 	?>
                                 <tr>
                                   <? for($i=2;$i<13;$i++){?>
                                   <td class="celdas1">&nbsp;
                                       <?=substr(envia_mes($i),0,3);?></td>
                                   <? } ?>
                                 </tr>
								 <? for($k=0;$k<@pg_numrows($rs_instit);$k++){
										$fila_inst = @pg_fetch_array($rs_instit,$k);
										$total_colegio=0;

										?>
                                 <tr>
                                   <td class="text2"><div align="center">
                                     <?=$fila_inst['rdb'];?>
                                   </div></td>
                                   <td class="text2"><div align="center">
                                     <?=strtoupper($fila_inst['nombre_instit']);?>
                                   </div></td>
                                   
                                   <? 
								   	$mes = date("m");
									
									for($i=2;$i<13;$i++){
								   		$sql = "select count(*) as cuenta,id_institucion,b.id_ano from matricula a INNER JOIN ano_escolar b ON a.id_ano=b.id_ano WHERE nro_ano=".$cmbANO." AND id_institucion=".$fila_inst['rdb']." AND date_part('month',fecha)<=".$i." group by id_institucion, b.id_ano ";
										$rs_mat = @pg_exec($conn,$sql);
										$ano = @pg_result($rs_mat,2);
										$dias_del_mes=habiles($i,$cmbANO);
										
										$sql ="SELECT count(*) FROM feriado WHERE id_ano=".$ano." AND date_part('month',fecha_inicio)=".$i;
										$rs_feriado = @pg_exec($conn,$sql);
										$feriado = @pg_result($rs_feriado,0);
										
										$sql = "select count(*) from asistencia a where a.ano=".$ano." and date_part('month',fecha)=".$i;
										$rs_asistencia = pg_exec($conn,$sql); 
										$asistencia = @pg_result($rs_asistencia,0);
																			
										$habiles = $dias_del_mes - $feriado;
										
										
										$asistencia_mes = pg_result($rs_mat,0) * $habiles - $asistencia;
										
										if($i > $mes){
											$asistencia_mes ="&nbsp;";
										}
										
										?>
                                   <td class="text2"><div align="center">
                                     <?=number_format($asistencia_mes,'',',','.');?>
                                   </div></td>
                                   <? 	$total_colegio = $total_colegio + $asistencia_mes;
								   		$total_mes[$i] = $total_mes[$i] + $asistencia_mes;
								   } ?>
                                   <td class="celdas1"><div align="center">
                                     <?=number_format($total_colegio,'0',',','.');?>
                                   </div></td>
                                 </tr>
								 <? } ?>
                                 <tr>
                                   <td class="celdas1">&nbsp;</td>
                                   <td class="celdas1">TOTAL</td>
                                   <? for($i=2;$i<13;$i++){?>
                                   <td class="celdas1"><?=number_format($total_mes[$i],'0',',','.');?>&nbsp;</td>
                                   <? $total_gral = $total_gral + $total_mes[$i];
								   } ?>
                                   <td class="celdas1"><?=number_format($total_gral,'0',',','.');?>&nbsp;</td>
                                 </tr>
                               </table>	
									  <BR />

								
								<span class="text2">
								Nota: Los saldos negativos correponden a la asignaci&oacute;n de fecha de matricula por parte del colegio</span>
                                <br>
		
    <br />
    <br />
    <br /></td>
  </tr>
  
  <tr>
    <td valign="baseline"><HR />
        <? $fecha=date("d-m-Y");
		$sql="SELECT comuna FROM nacional n INNER JOIN macional_corp nc ON n.id_nacional=nc.id_nacional WHERE num_corp=".$_CORPORACION;
		$rs_nacional = pg_exec($connection,$sql);
		$comuna=pg_result($rs_nacional,0);?>
       <?php switch($_CORPORACION){
			case 6:
				$nom_com="Pe&ntilde;alol&eacute;n,";
			break;
			case 1:
				$nom_com="Santiago,";
			break;
			case 2:
				$nom_com="Vi&ntilde;a del Mar,";
			break;
		}?>
       <div align="right" class="fecha"><?php echo $nom_com ?> <? echo fecha_espanol($fecha);?></div></td>
  </tr>
</table>
</body>
</html>