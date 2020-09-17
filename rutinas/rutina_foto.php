<? 
require_once('util/header.inc');


echo $sql ="SELECT id_ano FROM ano_escolar WHERE situacion=1 and id_institucion=24988";
$rs_ano = pg_exec($conn,$sql);
$ano =1414; //pg_result($rs_ano,0);

echo "<br>".$sql="SELECT rut_alumno FROM matricula WHERE id_ano=".$ano;
$rs_matricula = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_matricula);$i++){
	$fila=pg_fetch_array($rs_matricula,$i);
	
	$filen = $fila['rut_alumno'];
	echo unlink("infousuario/images/$filen"); 

	echo "<br>".$sql="UPDATE matricula SET nom_foto=NULL WHERE rut_alumno=".$fila['rut_alumno'];
	$rs_alumno = pg_exec($conn,$sql); 

}


/*	$filen = 19539427;
	unlink( "infousuario/images/$filen"); 

	$sql="UPDATE matricula SET nom_foto=NULL WHERE rut_alumno=".$filen;
	$rs_alumno = pg_exec($conn,$sql); 
*/

echo "<br>fin proceso";

?>