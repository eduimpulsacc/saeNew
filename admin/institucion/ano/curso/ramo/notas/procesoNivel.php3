<?php require('../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$docente		=5; //Codigo Docente
	$frmModo 		=$_FRMMODO;

	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];

	$qry="SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso, matricula.nro_lista "; 
	$qry = $qry . " FROM alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno ";
	$qry = $qry . " INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno ";
	$qry = $qry . " WHERE tiene$nro_ano.id_ramo=".$ramo." AND matricula.id_ano=".$ano." ";
	$qry = $qry . " ORDER BY matricula.nro_lista asc, ape_pat, ape_mat, nombre_alu, rut_alumno asc ";
	$Rs_Alum = @pg_exec($conn,$qry);

	if(($frmModo=="ingresar") or ($frmModo=="modificar")){
		for($i=0;$i<@pg_numrows($Rs_Alum);$i++){
			$fils=@pg_fetch_array($Rs_Alum,$i);
			if(($_POST['Nota'][$i]>0) OR $_POST['Nota'][$i]==MB OR $_POST['Nota'][$i]==B OR $_POST['Nota'][$i]==S OR $_POST['Nota'][$i]==I){
				$qry7="SELECT * FROM NOTAS$nro_ano WHERE RUT_ALUMNO=".$fils['rut_alumno']." AND ID_RAMO=".$ramo." AND ID_PERIODO=".$cmbPERIODO;
				$result7 =pg_Exec($conn,$qry7);
				if (@pg_numrows($result7)!=0){
					$sql="UPDATE notas$nro_ano SET nota20='".trim($_POST['Nota'][$i])."' WHERE rut_alumno=". $fils['rut_alumno']." AND id_ramo=". $ramo ." AND id_periodo=". $cmbPERIODO;
						$Rs_Notas =@pg_exec($conn,$sql);
						if (!$Rs_Notas) {
							error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
						}
				}
				else{
					$sql="INSERT INTO notas$nro_ano (RUT_ALUMNO, ID_RAMO, ID_PERIODO, NOTA20) VALUES (".$fils['rut_alumno'].",".$ramo .", ".$cmbPERIODO.", '".trim($_POST['Nota'][$i])."')";
						$Rs_Notas =@pg_exec($conn,$sql);
						if (!$Rs_Notas) {
							error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
						}
				}
			}
		}
	}
	echo "<script>window.location = 'seteaNivel.php3?caso=1' </script>";
?>