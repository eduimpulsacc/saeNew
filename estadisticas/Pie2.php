<?php
session_start(); 
require('../util/header.inc');
echo $_CMBPERFIL;
//return;
		$sql="((SELECT SUM(estadistica.cant_conex) as total2 FROM estadistica WHERE rdb=".$_INSTIT." and perfil=".$_CMBPERFIL.") UNION (SELECT (SELECT SUM(estadistica.cant_conex) FROM estadistica WHERE rdb=".$_INSTIT.") - SUM(estadistica.cant_conex)  as total1 FROM estadistica WHERE rdb=".$_INSTIT." and perfil=".$_CMBPERFIL."))";
		echo $sql;
		$sql_total="SELECT SUM(suma) FROM (SELECT SUM(estadistica.cant_conex) as suma FROM estadistica WHERE  rdb=".$_INSTIT." GROUP BY estadistica.cant_conex) as total";
		$total_result = pg_exec($conn,$sql_total);
		$resultado = pg_exec($conn,$sql);
		$total= pg_result($total_result,0);
		$data = array();
		$labels= array();
		 while ($arr_adms = @pg_fetch_array($resultado)) {
		 				$sql_institucion = "SELECT nombre_perfil FROM perfil WHERE id_perfil = ".$arr_adms[2];	
						$res_institucion = @pg_exec($conn,$sql_institucion);
						$arr_institucion = @pg_fetch_array($res_institucion);
						$data[] =round($arr_adms[0]*100/$total,2);
						$val=$arr_adms[0];
						$institucion=substr($arr_institucion['nombre_perfil'],0,4);
						$labels[] =$institucion;
						$links[] = "javascript:alert('$val')";
						
	}

/**********************************************************************************************************************/
include_once('ofc/php-ofc-library/open-flash-chart.php');
$g = new graph();

$g->pie(70,'#000000','{font-size:8px; color: #000000;');
$g->pie_values( $data, $labels,$links);
//
// Colours for each slice, in this case some of the colours
// will be re-used (3 colurs for 5 slices means the last two
// slices will have colours colour[0] and colour[1]):
//
$g->pie_slice_colours( array('#d01f3c','#356aa0','#C79810','#28A74C','#B2119D','#24E8FA','#713B3C','#05946D','#d01f3c','#356aa0','#C79810','#28A74C','#B2119D','#24E8FA','#713B3C','#05946D') );

$g->set_tool_tip( '#val#%' );
$g->title( 'Estadisticas', '{font-size:18px; color: #000000}' );

echo $g->render();
?>
