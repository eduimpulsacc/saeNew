<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../../class/Membrete.class.php";

class Crea_Plan {
	   
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
	 
	 
 public function IngresaDatos($nombre_proyecto,$ano_1,$ano_4,$presupuesto,$objetivo,$fecha,$estado,$clasificacion,$rdb)
 {
	 $sql="INSERT INTO pme.proyecto (nombre_proyecto,objetivo,financiamiento,nro_ano_1,nro_ano_4,fecha,estado,clasificacion,rdb) 
           VALUES ('$nombre_proyecto','$objetivo',$presupuesto,$ano_1,$ano_4,'$fecha',$estado,$clasificacion,$rdb)";
		   $result = pg_exec($this->Conec->Conectar(),$sql)or die("fallo x1".$sql );
		   
		   $sql_s="select MAX(id_proyecto) from pme.proyecto";		   
		   $result_s = pg_exec($this->Conec->Conectar(),$sql_s)or die("fallo x2".$sql_s );
		   $id_proyecto = pg_result($result_s,0);
		   
		   $ano = $ano_1;
		   for($x=0;$x<4;$x++){
		   
		 
		   $ano_sig = $ano+$x;
		    
		  $sql_i="insert into pme.proyecto_ano values (default,$id_proyecto,$ano_sig,0) ";
		  $result_i = pg_exec($this->Conec->Conectar(),$sql_i)or die("fallo x2".$sql_i );
		   }
		   
		   
		   if($result){
			   return $result;
			   }else{
				return false;   
			   }
 }
 
 public function muestra_datos(){
	 
	 $sql="select *,
case when pm.estado=0 then 'Deshabilidato'
	 when pm.estado=1 then 'Habilitado' end as estado,
case when pm.clasificacion=0 then 'Autonomo'
	 when pm.clasificacion=1 then 'En recuperación'
     when pm.clasificacion=2 then 'Emergento' end as clasificacion     
 from pme.proyecto pm order by pm.id_proyecto";
	 $result = pg_exec($this->Conec->Conectar(),$sql)or die("fallo x3".$sql );
		   
		   if($result){
			   return $result;
			   }else{
				return false;   
			   }
	 }	 
	 
public function BuscaDatos($id_proyecto)
	{
		$sql="select * from pme.proyecto where id_proyecto = $id_proyecto";	
		 $result = pg_exec($this->Conec->Conectar(),$sql)or die("fallo x4".$sql );
		   
		   if($result){
			   return $result;
			   }else{
				return false;   
			   }
} 
	
public function ModificaDatos($nombre_proyecto,$ano_1,$ano_4,$presupuesto,$objetivo,$fecha,$estado,$clasificacion,$id_proyecto)
{
	$sql="update pme.proyecto set nombre_proyecto='$nombre_proyecto',nro_ano_1=$ano_1,nro_ano_4=$ano_4,financiamiento=$presupuesto,objetivo='$objetivo',fecha='$fecha',estado=$estado,clasificacion=$clasificacion where id_proyecto=$id_proyecto ";
	$result = pg_exec($this->Conec->Conectar(),$sql)or die("fallo x4".$sql );
		   
		   if($result){
			   return $result;
			   }else{
				return false;   
    }
}	 
	 
	 
	public function ElimaDatos($id_proyecto)
	{
		$sql="delete from pme.proyecto where id_proyecto = $id_proyecto";	
		$result = pg_exec($this->Conec->Conectar(),$sql)or die("fallo x4".$sql );
		   
		   if($result){
			   return $result;
			   }else{
				return false;   
    }
	} 
	 
}
?>	 
	 