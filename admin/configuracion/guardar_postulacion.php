<?
require('../../util/header.inc');
$institucion	=$_INSTIT;
$ano =$_ANO;
$indice = $_POST['indice'];
$cmb_curso=$_POST['cmb_curso'];
for($i=0;$i<$indice;$i++){
	$destino=$_POST[cmb_insti.$i];
	$cmb_curso=$_POST['cmb_insti'.$i];
	$cmb_grado=$_POST['cmb_grado'.$i];
	$sql1="select grado_curso from curso where id_curso=".$cmb_grado;
	$result = pg_exec($conn,$sql1);
	$fila = @pg_fetch_array($result,0);
	$cmb_grado=$fila["grado_curso"];
	 $postula=$_POST['postula'.$i];
	$rut=$_POST['rut_alumno'.$i];
	$tipo_ensenanza=$_POST['tipo_ensenanza'.$i];
				/*if($_POST['postula'.$i]==null){
					$_POST['postula'.$i]=0;
				}*/
				
	if($_POST['postula'.$i] < 1){
					$sql="delete from  postulaciones where rut_alumno='$rut'";
					$resultado=@pg_Exec($conn,$sql);
	
	}else{
				
				 	$sql2="select * from postulaciones where rut_alumno=".$rut;
					$result2 = pg_exec($conn,$sql2);
					
					
				if (@pg_numrows($result2)==0){
							$sql="INSERT INTO postulaciones (rut_alumno,rdb_origen,grado,ensenanza,estado,rdb_destino,id_curso,id_ano) VALUES ('$rut','$institucion','$cmb_grado','$tipo_ensenanza','$postula','$destino',".$_POST['cmb_grado'.$i].",$ano)";
							$resultado=@pg_Exec($conn,$sql);
				}else{
					if($cmb_grado==""){
						$cmb_grado=0;
					}
					
					if($tipo_ensenanza==""){
						$tipo_ensenanza=0;
					}
					
					$sql="UPDATE postulaciones set rut_alumno='$rut',rdb_origen='$institucion',grado='$cmb_grado',ensenanza='$tipo_ensenanza',estado='$postula',rdb_destino='$destino',id_curso=".$_POST['cmb_grado'.$i].",id_ano=$ano where rut_alumno=".$rut;
					$resultado=@pg_Exec($conn,$sql);
	}
		
		}
	}
	
   
?>

<script language="javascript">window.location="Postular.php"</script>
