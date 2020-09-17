<?php
require('../util/header.inc');
$_INSTIT=8933;
include ("FusionCharts.php");
		$sql="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE rdb=".$_INSTIT." GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil ORDER BY sum DESC";
		//$sql="select sum(rdb) from corp_instit union select sum(rdb) from corp_instit where num_corp = '".$_CORP."'";
		//$sql_total="select sum(cant_conex) from estadistica where estadistica.rdb in (select rdb from corp_instit where num_corp =  '".$_CORP."')";
		//echo $sql;
		$result = @pg_Exec($conn,$sql);
				$result = pg_exec($conn,$sql_total);
						$total_arr = @pg_fetch_array($result);
						$total= $total_arr[0];
						$i=0;
						$data = array();
						$labels= array();
						   while ($arr_adms = @pg_fetch_array($result)) {
						   		$sql_perfil = "SELECT nombre_perfil FROM perfil WHERE id_perfil = ".$arr_adms[2];
								$res_perfil = @pg_exec($conn,$sql_perfil);
								$res_perfil = @pg_fetch_array($res_perfil);
								//$perfil=substr($res_perfil['nombre_perfil'],0,6);
								$valores[0][$i]=$res_perfil['nombre_perfil'];
								//echo round($arr_adms[1]*100/$total,2);
								$valores[1][$i]=round($arr_adms[0]*100/$total,2);
								//$data[] =round($arr_adms[0]*100/$total,2);
								$val=$arr_adms[0];
								$i++;
								}
								//echo $i;
/*$valores[0][0]="enero";
$valores[0][1]="febrero";
$valores[0][2]="marzo";
$valores[0][3]="abril";
$valores[0][4]="mayo";*/

/*$valores[1][0]=150000;
$valores[1][1]=200000;
$valores[1][2]=900000;
$valores[1][3]=18970;
$valores[1][4]=333666;*/

$valores[2][0]="111111";
$valores[2][1]="333333";
$valores[2][2]="aaaaaa";
$valores[2][3]="ffffff";
$valores[2][4]="333666";


$strXML = "<graph caption='titulo general' xAxisName='Valores mensuales' yAxisName='Valor Gasto' decimalPrecision='0' formatNumberScale='0'>";
echo  $strXML;





$colorea = "333fff";
$maxgru = 4;
$ancho=800;


for ($abajo=0;$abajo<=($maxgru);$abajo++)
{
     // se grarfica imprime
     $nomest=$valores[0][$abajo];
     $cantid=$valores[1][$abajo];
     $colorea=$valores[2][$abajo];
     $strXML .= "<set name='$nomest' value='$cantid' color='$colorea' />";
}
 $strXML .= "</graph>";
echo  $strXML;

   echo renderChartHTML("FusionCharts/FCF_Column3D.swf", "", $strXML, "myNext", $ancho, 300);
?>