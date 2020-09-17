	<?	session_start(); 
		require('../util/header.inc');
		echo $_SESSION['cmb_ins'];
		$sql="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE rdb=".$_SESSION['cmb_ins']." GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb,la.perfil ORDER BY sum DESC";
		echo $sql;
		$sql_total="SELECT SUM(suma) FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica WHERE rdb=".$_SESSION['cmb_ins']." GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA";
		$resultado = pg_exec($conn,$sql);
						$result = pg_exec($conn,$sql_total);
						$total_arr = @pg_fetch_array($result);
						$total= $total_arr[0];
						
						$data = array();
						$labels= array();
						   // Añade las etiquetas de cada fila al array de
						   // etiquetas que le pasaremos a Open Flash Chart
							 while ($arr_adms = @pg_fetch_array($resultado)) {
								$sql_perfil = "SELECT nombre_perfil FROM perfil WHERE id_perfil = ".$arr_adms[2];
								//echo $sql_perfil;
								$res_perfil = @pg_exec($conn,$sql_perfil);
								$res_perfil = @pg_fetch_array($res_perfil);
								
								$perfil=substr($res_perfil['nombre_perfil'],0,6);
								$labels[] =$perfil;
								$data[] =round($arr_adms[0]*100/$total,2);
								$val=$arr_adms[0];
								$links[] = "javascript:alert('$val')";
								}
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
$g->title( 'Perfiles ', '{font-size:18px; color: #000000}' );

echo $g->render();
?>
