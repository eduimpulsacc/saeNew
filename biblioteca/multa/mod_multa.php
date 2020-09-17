<?php 
 require("../../util/header.php");
 
class Multa{
	public function construct(){
		
	}
	
public function traeMulta($conn,$rdb){
 $sql="select * from biblio.multa_config where rdb=$rdb and estado=1";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaMulta($conn,$rdb,$monto){
	$sql0="update biblio.multa_config set estado=0 where rdb=$rdb";
	$result0 = pg_exec($conn,$sql0);
	
 $sql="insert into biblio.multa_config(rdb,monto,estado) values($rdb,$monto,1)";
$result = pg_exec($conn,$sql);
return $result;	
}

public function cambiaMulta($conn,$rdb,$monto){
 $sql="update  biblio.multa_config set monto=$monto where rdb=$rdb and estado=1";
$result = pg_exec($conn,$sql);
return $result;	
}

public function quitaMulta($conn,$rdb){
 $sql="update  biblio.multa_config set estado=0 where rdb=$rdb";
$result = pg_exec($conn,$sql);
return $result;	
}

}//fin clase
?>