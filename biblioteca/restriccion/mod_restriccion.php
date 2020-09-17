<?php 
 require("../../util/header.php");
 
class Restriccion{
	public function construct(){
		
	}
	
public function traeRes($conn,$rdb){
 $sql="select * from biblio.restriccion where rdb=$rdb";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaRes($conn,$rdb,$lim_reno,$lim_pres,$lim_rese,$lim_diasbloqueo){
 $sql="insert into biblio.restriccion values($rdb,$lim_rese,$lim_pres,$lim_reno,$lim_diasbloqueo)";
$result = pg_exec($conn,$sql);
return $result;	
}

public function cambiaRes($conn,$rdb,$lim_reno,$lim_pres,$lim_rese,$lim_diasbloqueo){
  $sql="update  biblio.restriccion set lim_reservas=$lim_rese,lim_prestamo = $lim_pres,lim_renovacion = $lim_reno,lim_diasbloqueo=$lim_diasbloqueo where rdb=$rdb";
$result = pg_exec($conn,$sql);
return $result;	
}

}//fin clase
?>