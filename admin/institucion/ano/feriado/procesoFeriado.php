<?php require('../../../../util/header.inc');

	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$id_feriado		=$_IDFERIADO;
	$bool_fer		=$_BOOLFER;
	$fec1			=$fecha1;
	$fec2			=$fecha2;

	if ($cmbPeriodo==0) $cmbPeriodo="Null";
	
	if ($frmModo=="ingresar"){
		if (($fecha1=="") and ($fecha2=="")){
			$sql="insert into feriado (id_ano,descripcion,bool_fer,id_periodo) values(".$ano.", '".$descripcion."',1,".$cmbPeriodo.")";
		}else
		
		if ($fecha1==""){
			$sql="insert into feriado (id_ano,fecha_fin,descripcion,bool_fer,id_periodo) values(".$ano.", to_date('".trim($fec2)."','DD MM YYYY'), '".$descripcion."',1,".$cmbPeriodo.")";
		}else
		
		if ($fecha2==""){
			$sql="insert into feriado (id_ano,fecha_inicio,descripcion,bool_fer,id_periodo) values(".$ano.", to_date('".trim($fec1)."','DD MM YYYY'), '".$descripcion."',1,".$cmbPeriodo.")";
		}else
		if(($fecha1!="") and ($fecha2!="")) {
			$sql="insert into feriado (id_ano,fecha_inicio,fecha_fin,descripcion,bool_fer,id_periodo) values(".$ano.", to_date('".trim($fec1)."','DD MM YYYY'), to_date('".trim($fec2)."','DD MM YYYY'), '".$descripcion."',1,".$cmbPeriodo.")";

		}
		
		$result =@pg_Exec($conn,$sql);
				if (!$result) {
					error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$sql);
				}
	
	}	/******fin if ingresar******/
	
	
	if ($frmModo=="modificar"){
	
		$sqlVrfi="select * from feriado where id_feriado=".$id_feriado;
			$resultVrfi =@pg_Exec($conn,$sqlVrfi);
			$cant=pg_numrows($resultVrfi);
		if($cant>0) {
				
				if (($fecha1!="") and (($fecha2=="") or ($fecha2=="--")) and ($bool_fer==1)){
					$sql="update feriado set fecha_inicio=to_date('".trim($fec1)."','DD MM YYYY'), fecha_fin=Null, descripcion='".$descripcion."', bool_fer=1, id_periodo=".$cmbPeriodo." where id_feriado=".$id_feriado;
				}
				else
				if (($fecha1!="") and ($fecha2!="") and ($bool_fer==1)){ 
					$sql="update feriado set fecha_inicio=to_date('".trim($fec1)."','DD MM YYYY'), fecha_fin=to_date('".trim($fec2)."','DD MM YYYY'),descripcion='".$descripcion."', bool_fer=1, id_periodo=".$cmbPeriodo." where id_feriado=".$id_feriado;
				}else
				if (($fecha1!="") and (($fecha2=="") or ($fecha2=="--")) and ($bool_fer==0)){
					$sql="insert into feriado (id_ano,fecha_inicio,fecha_fin,descripcion,bool_fer,id_periodo) values(".$ano.", to_date('".trim($fec1)."','DD MM YYYY'), Null, '".$descripcion."',1,".$cmbPeriodo.")";
				}else
				if (($fecha1!="") and ($fecha2!="") and ($bool_fer==0)){ 
					$sql="insert into feriado (id_ano,fecha_inicio,fecha_fin,descripcion,bool_fer,id_periodo) values(".$ano.", to_date('".trim($fec1)."','DD MM YYYY'), to_date('".trim($fec2)."','DD MM YYYY'), '".$descripcion."',1,".$cmbPeriodo.")";
				}
				
		}else{//fin Vrfi
				if (($fecha1!="") and (($fecha2=="") or ($fecha2=="--")) and ($bool_fer==0)){
					$sql="insert into feriado (id_ano,fecha_inicio,fecha_fin,descripcion,bool_fer,id_periodo) values(".$ano.", to_date('".trim($fec1)."','DD MM YYYY'), Null, '".$descripcion."',1,".$cmbPeriodo.")";
				}else
				if (($fecha1!="") and ($fecha2!="") and ($bool_fer==0)){
					$sql="insert into feriado (id_ano,fecha_inicio,fecha_fin,descripcion,bool_fer,id_periodo) values(".$ano.", to_date('".trim($fec1)."','DD MM YYYY'), to_date('".trim($fec2)."','DD MM YYYY'), '".$descripcion."',1,".$cmbPeriodo.")";
				}
		}


		$result =@pg_Exec($conn,$sql);
			if (!$result) {
				error('<b> ERROR :</b>Error al acceder a la BD. (4)'.$sql);
			}
			
	}	/******fin if modificar******/
	
	
	if ($frmModo=="eliminar"){
	
		$sql="delete from feriado where id_feriado=".$id_feriado;
		$result =@pg_Exec($conn,$sql);
				if (!$result) {
					error('<b> ERROR :</b>Error al acceder a la BD. (5)'.$sql);
				}
	
	}
	
	
	echo "<script>window.location = 'seteaFeriado.php?caso=4'</script>";


?>