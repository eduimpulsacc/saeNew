<?php
 class Escala{
	public function contruct(){
		
	} 
	
public function getEscala($conn,$rbd){
 $sql="select * from escala_notas where rbd=$rbd";
$result = pg_exec($conn,$sql);
return $result;
}

public function creaEscala($conn,$rbd,$min,$max,$apr,$exg){
$sql="insert into escala_notas (rbd,nmin,nmax,napr,exig) values($rbd,$min,$max,$apr,$exg)";
$result = pg_exec($conn,$sql);
return $result;

}


public function updEscala($conn,$rbd,$min,$max,$apr,$exg){
 $sql="update escala_notas set nmin=$min,nmax=$max,napr=$apr,exig=$exg where rbd = $rbd";
$result = pg_exec($conn,$sql);
return $result;
}
	
 }//fin clase?>