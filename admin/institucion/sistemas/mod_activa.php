<?php 
class Activa{
	
/*private $conect; 
	//private $conect2;  */      

//constructor 
public function __construct($con,$con2){ 
      $this->conect = $con;  
      $this->conect2 = $con2;
    }
	
public function listaSistemas($rbd){
 $sql="select * from sistemas where id_sistema not in(5,6,8,9,10,11) order by id_sistema";
$result=pg_Exec($this->conect2,$sql)or die("Fallo 0 ".$sql);
		
return $result;
}

public function listaAsociados($rbd){
$sql="select * from institucion where rdb=$rbd";
$result=pg_Exec($this->conect2,$sql)or die("Fallo 0 ".$sql);
return $result;
}

public function upColegio($rdb,$dis,$aso){
$con = ($dis!="" && $aso!="")?",":"";
 $sql="update institucion set $aso$con$dis where rdb=$rdb";
$result=pg_Exec($this->conect2,$sql)or die("Fallo 0 ".$sql);
return $result;

}

}//fin clase
	?>