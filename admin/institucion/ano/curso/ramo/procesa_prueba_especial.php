<?
		
	session_start();
	require('../../../../../util/header.inc');
	
   $institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$frmModo 		=$_FRMMODO;


	/*echo"<pre>";
	print_r($_POST);
	echo"</pre>";
	exit;*/

	$cuenta_array =  sizeof($rut_alumno);
	
	for($i=0;$i < $cuenta_array; $i++){
		
	echo"<pre>";	
	 "Rut-->".$_POST['rut_alumno'][$i];
	echo"</pre>";
	
	echo"<pre>";	
    "Promedio-->".$_POST['Nota'][$i];
	echo"</pre>";
		
	echo"<pre>";	
	    "Nota Especial -->".$_POST['p_especial'][$i];
	echo"</pre>";
	
	echo"<pre>";	
	 "Nota EXAMEN -->".$_POST['n_examen'][$i];
	echo"</pre>";
	
	$sql="SELECT * FROM situacion_final WHERE rut_alumno=".$_POST['rut_alumno'][$i]." and id_ramo=".$id_ramo." ";
	$rs_existe = pg_exec($conn,$sql);
	//echo pg_numrows($rs_existe);
	
	if(pg_numrows($rs_existe)!=0){
				$sql="update situacion_final set prueba_especial=".$_POST['p_especial'][$i].",nota_final=".$_POST['p_final'][$i]."
				where rut_alumno=".$_POST['rut_alumno'][$i]." and id_ramo=".$id_ramo." ";
				$result = pg_exec($conn,$sql)or die("fallo1".$sql);
	
	}else{
			if($_POST['Nota'][$i]>0){
				if($_POST['p_especial'][$i]=="") $_POST['p_especial'][$i]=0;
				$sql="insert into situacion_final (rut_alumno,id_ramo,prom_gral,nota_final,prueba_especial)
				values(".$_POST['rut_alumno'][$i].",".$id_ramo.",".$_POST['Nota'][$i].",".$_POST['p_final'][$i].",".$_POST['p_especial'][$i].")";
				$result = pg_exec($conn,$sql)or die("fallo2".$sql);
			}else{
				continue;
			}
			
	}
		
}
	
echo "<script>window.location='prueba_especial.php?id_ramo=$id_ramo&caso=2'</script>";
?>