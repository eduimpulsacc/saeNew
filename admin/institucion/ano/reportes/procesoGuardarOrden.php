<?php 
require('../../../../util/header.inc');

$ano = $_ANO;
$contador;
$cmb_ensenanza;

for($i=0; $i<$contador; $i++){
	$orden = ${"orden".$i};	
	$subsector = ${"subsector".$i};
	
	if($orden!=""){
		$sql="SELECT orden FROM orden_subsector WHERE id_ano=".$ano." AND tipo_ensenanza=".$cmb_ensenanza." AND cod_subsector=".$subsector."";
		$rs_existe = pg_exec($conn,$sql) or die ("Error: ".$sql);
		
		if(pg_numrows($rs_existe)==0){
			$sql="INSERT INTO orden_subsector VALUES(".$ano.",".$subsector.",".$cmb_ensenanza.",".$orden.")";
			
		}else{
			$sql="UPDATE orden_subsector SET orden=".$orden." WHERE id_ano=".$ano." AND tipo_ensenanza=".$cmb_ensenanza." AND cod_subsector=".$subsector;
		}
		$result =pg_exec($conn,$sql) or die("Error :".$sql);
	}
}
pg_close();
echo "<script>window.close();</script>";
?>