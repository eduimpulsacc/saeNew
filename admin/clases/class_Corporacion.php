<? require "../../../../util/connect.php";

class Corporacion {

 function Institucion($conn){
 	$sql = "select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, ";
	$sql.= "institucion where corp_instit.num_corp = '".$this->corporacion."' and corp_instit.rdb = institucion.rdb ";
	$sql.= "order by nombre_instit asc";
	$result = pg_exec($conn,$sql) or die ("Select falló: ".$sql);
	return $result;
 }


}



?>
