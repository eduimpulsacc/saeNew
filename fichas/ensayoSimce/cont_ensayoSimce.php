<?php session_start();
require('../../util/header.inc');

require "mod_ensayoSimce.php";

//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$obj_EnsayoSimce = new EnsayoSimce($conn);
$funcion = $_POST['funcion'];

if($funcion==1){

			$id_curso=$_POST['id_curso'];
		  $result = $obj_EnsayoSimce->carga_ramos($id_curso);
		  if($result){?>
<select name='select_ramos' id='select_ramos' onchange='carga_puntaje(this.value)'>
		<option value='0' select='select' >(Seleccionar)</option>
		<?
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
		?>
			<option value="<?php echo $fila['id_ramo'] ?>"><?php echo $fila['nombre'] ?></option>;
		 <?php }?> 
		 </select>
<?php 
		  }
}

if($funcion==2){
	//var_dump($_POST);
	
	$rs_fecha = $obj_EnsayoSimce->carga_lista_puntajes($_CURSO,$id_ramo);
	if(pg_numrows($rs_fecha)>0){
	$rs_dicta= $obj_EnsayoSimce->traeDicta($id_ramo);
	
	$arr_fecha = "";
	$arr_pun="";
	for($x=0;$x<@pg_numrows($rs_fecha);$x++){
		 $fila_fecha=pg_fetch_array($rs_fecha,$x);
		 
	 	 $rs_pun = $obj_EnsayoSimce->puntaje_alumno_fecha($_CURSO,$id_ramo,$_ALUMNO,$fila_fecha['fecha']);
		$fila_pun = pg_fetch_array($rs_pun,0);
		$pun = (intval($fila_pun['puntaje']==0 ))?"null":$fila_pun['puntaje'].",";
		$arr_pun.=$pun;
	  
	   $arr_fecha.="'".CambioFD($fila_fecha['fecha'])."',"; 
	}
	
	
	//echo $arr_pun;
	 $arr_fecha= substr($arr_fecha, 0, -1);
	  $arr_pun= substr($arr_pun, 0, -1);
	  
	?>
    <script type="text/javascript" src="../../admin/clases/jquery/jquery.js"></script>

  <script type="text/javascript" src="../../admin/clases/highcharts/js/highcharts.js"></script>
  

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<script>
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Puntaje Ensayo Simce'
        },
        subtitle: {
            text: 'Docente: <?php echo strtoupper(pg_result($rs_dicta,2)); ?>'
        },
        xAxis: {
            categories: [<?php echo $arr_fecha ?>]
        },
        yAxis: {
            title: {
                text: 'Puntaje'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Puntaje',
            data: [<?php echo $arr_pun ?>]
        }]
    });
});
</script>
    <?
}else{
	echo "Sin informaci&oacute;n";
	}
}
?>