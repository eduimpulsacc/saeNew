	<?	session_start(); 
		require('../util/header.inc');
		echo $_SESSION['cmb_ins'];
				$sql ="SELECT SUM(suma),rdb FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.rdb FROM estadistica where estadistica.rdb in (select rdb from corp_instit where num_corp = '".$_CORP."') GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AS LA GROUP BY la.rdb LIMIT 5";
				//$sql ="SELECT SUM(suma),rdb,perfil FROM ( SELECT SUM(estadistica.cant_conex) as suma,estadistica.perfil,estadistica.rdb,estadistica.id_usuario FROM estadistica GROUP BY estadistica.cant_conex,estadistica.perfil,estadistica.rdb,estadistica.id_usuario) AND estadistica.rdb in (select rdb from corp_instit where num_corp = '".$_SESSION['corp']."' AS LA GROUP BY la.rdb,la.perfil";
				echo $sql;
				//aca
				$sql_total="SELECT SUM(estadistica.cant_conex) FROM estadistica where estadistica.rdb in (select rdb from corp_instit where num_corp = '".$_CORP."') ";
				$result_total = pg_exec($conn,$sql_total);
				$total_arr = @pg_fetch_array($result_total);
				$total= $total_arr[0];
				//$res1= round ($row['valor1']*100/$row['total'],2);  
				$resultado = pg_exec($conn,$sql);
				$data = array();
				$labels= array();
				   // Añade las etiquetas de cada fila al array de
				   // etiquetas que le pasaremos a Open Flash Chart
					 while ($arr_adms = @pg_fetch_array($resultado)) {
						$sql_institucion = "SELECT nombre_instit FROM institucion WHERE rdb = ".$arr_adms['rdb'];
						echo $sql_institucion;
						$res_institucion = @pg_exec($conn,$sql_institucion);
						$arr_institucion = @pg_fetch_array($res_institucion);
						$data[] =round($arr_adms[0]*100/$total,2); 
						$val=$arr_adms[0];
						$str = $arr_institucion['nombre_instit'];
						$arr=explode(" ", $str);
						$institucion=substr($arr[1],0,15);
						//echo $arr[1];
						//return;
						$labels[] =$institucion;
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
