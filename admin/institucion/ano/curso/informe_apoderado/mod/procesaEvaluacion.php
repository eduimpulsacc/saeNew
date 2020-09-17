<?php
 require('../../../../../../util/header.inc');
require "../class/plantilla.php";

foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
    eval($asignacion); 
	//echo "<br>".$asignacion;
}
$obj_plantilla = new Plantilla();

if($ex==1){
$rs_guarda = $obj_plantilla->guardaEvaluacion($conn,$rut,$periodo,$plantilla,$entrevistador,$observacion,$cmb_ano);

$rs_ultimo = $obj_plantilla->traeEvaluacionultimo($conn);

$evaluacion = pg_result($rs_ultimo,0);

for($e=0;$e<count($_POST['item']);$e++){
$data = explode("_",$_POST['item'][$e]);
 $area= $data[0];
 $item= $data[1];
 $concepto= $data[2];

$rs_guarda2 = $obj_plantilla->guardaEvaluacionItem($conn,$evaluacion,$area,$item,$concepto);
}
	
}
if($ex==2){
$rs_limpia = $obj_plantilla->eliminaEvaluacionItem($conn,$evaluacion);

for($e=0;$e<count($_POST['item']);$e++){
$data = explode("_",$_POST['item'][$e]);
 $area= $data[0];
 $item= $data[1];
 $concepto= $data[2];

$rs_guarda = $obj_plantilla->guardaEvaluacionItem($conn,$evaluacion,$area,$item,$concepto);

}

}

//if($rs_guarda){
?>
<script>
location.href='evaluar.php?periodo=<?php echo $periodo ?>&rut=<?php echo $rut ?>&planilla=<?php echo $plantilla ?>&tipo=<?php echo $tipo ?>&cmb_ano=<?php echo $cmb_ano ?>';
</script>
<?php // }else{ echo "no guardse";}
?>