<?php 	require('../../../../../util/header.inc');

$curso = $_CURSO;
$ano = $_ANO;
	
	$qry0="select nro_ano from ano_escolar where id_ano=".$ano;
	$result0=@pg_Exec($conn,$qry0);
	$fila0	= @pg_fetch_array($result0,0);
	$nro_ano=$fila0['nro_ano'];

    
	// SELECCIONAMOS A LOS APODERADOS DEL CURSO
//	$qry = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno in (select rut_alumno from matricula where id_curso = '$curso')) order by ape_pat, ape_mat";

$orden = ($tipoy==2)?"al.ape_pat,al.ape_mat,al.nombre_alu":"a.ape_pat,a.ape_mat,a.nombre_apo";
				  
				   $qry = "select 
a.rut_apo,a.nombre_apo,a.ape_pat,a.ape_mat,
al.rut_alumno,al.nombre_alu,al.ape_pat ape_palu,al.ape_mat ape_malu
from apoderado a
left join tiene2 t on t.rut_apo = a.rut_apo
left join alumno al on al.rut_alumno = t.rut_alumno
where t.rut_alumno in (select rut_alumno from matricula where id_curso = $curso )
group by a.rut_apo,a.ape_pat,a.ape_mat,a.nombre_apo,al.rut_alumno,al.nombre_alu,al.ape_pat,al.ape_mat
order by $orden";
	$result	= @pg_Exec($conn,$qry);
	if (!$result){
		error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$qry);
		}
	$X=0;
	$total_alumnos = @pg_numrows($result);	
	
	for($i=0; $i<pg_numrows($result); $i++){
		$X++;
		$filaAlu	= @pg_fetch_array($result,$i);
		$apo		= $filaAlu['rut_apo'];		
		for ($z=1 ; $z<=31 ; $z++){
				$dia=$z;
				$vv1="a_".$X."_".$z;				
					if($_POST[$vv1]=="on"){					
						if ($dia < 10){
						 	$fecha=("0".$dia."-".$cmbMes."-".$nro_ano);
						}else{
							$fecha=($dia."-".$cmbMes."-".$nro_ano);
						}
							$qry2="select * from asistencia_apo where rut_apo ='".$apo."' and id_curso=".$curso." and fecha=to_date ('".$fecha."' , 'DD MM YYYY')";
							$result2 =pg_Exec($conn,$qry2);
							if (@pg_numrows($result2)!=0){
								$fila=@pg_fetch_array($result2,0);
								$qry7="UPDATE asistencia_apo SET fecha=to_date ('".$fecha."' , 'DD MM YYYY') WHERE RUT_APO='".$apo."' AND ID_CURSO='".$curso."' AND fecha=to_date ('".$fecha."' , 'DD MM YYYY')";
							}else{
								$qry7="INSERT INTO asistencia_apo (RUT_APO, ID_curso, ano, fecha) VALUES ('".$apo."','".$curso."',".$ano.",to_date('".$fecha."' , 'DD MM YYYY'))";
							}
							$result7 =@pg_Exec($conn,$qry7);
							if (!$result7){
								error('<b> ERROR :</b>Error al acceder a la BD. (4)'.$qry7);
							}						
					}else{
						if ($_POST[$vv1]==""){
							if ($dia < 10){
							 	$fecha=("0".$dia."-".$cmbMes."-".$nro_ano);
							}else{
								$fecha=($dia."-".$cmbMes."-".$nro_ano);
							}
							$qry4="select * from asistencia_apo where rut_apo ='".$apo."' and id_curso=".$curso." and fecha=to_date ('".$fecha."' , 'DD MM YYYY')";
							$result4 =pg_Exec($conn,$qry4);
								if (@pg_numrows($result4)>0){
									$qry3="delete from asistencia_apo where rut_apo='".$apo."' and id_curso=".$curso." and fecha =to_date ('".$fecha."' , 'DD MM YYYY')";
									$result3 =pg_Exec($conn,$qry3);
										if (!$result3){
											error('<b> ERROR :</b>Error al acceder a la BD. (5)'.$qry3);
										}
								}//numrows
						}//if ($a[$X][$z]=="")
					}//ELSE
	    }//for ($z=1 ; $z<=31 ; $z++)
   }
		
	  
?>		
<script>window.location ="seteaAsistencia.php3?caso=13&tpv=<?php echo $tipoy; ?>"</script>

