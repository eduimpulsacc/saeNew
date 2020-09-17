<?	require('../../../../util/header.inc');
//print_r($_POST);
$frmModo		=$_FRMMODO;
$institutcion	=$_INSTIT;
$curso			=$_CURSO;
$ano			=$_ANO;




if($frmModo=="modificar"){
	for($i=0;$i<$contador;$i++){
		$id_curso 		= ${"cod_curso".$i};														
		$rut_emp	    = ${"cmbPROF".$i};								
		$truncado_per	= ${"truncado_per".$i};					if($truncado_per!=1) $truncado_per=0;				
		$truncado_final	= ${"truncado_final".$i};			    if($truncado_final!=1) $truncado_final=0;			
		$truncado_sf	= ${"truncado_sf".$i};				    if($truncado_sf!=1) $truncado_sf=0;				
		$Jornada		= ${"Jornada".$i};						if($Jornada=="") $Jornada=0;					
		$simce		    = ${"simce".$i};						if($simce=="") $simce=0;
		$cmbACTA		= ${"cmbACTA".$i};						//if($cmbACTA=="") $cmbACTA=0;				
		$observaciones	= ${"observaciones".$i};		        if($observaciones=="") $observaciones='-';			
		$val_sub		= ${"val_sub".$i};				        if($val_sub=="")  $val_sub=0;		
		$cap_curso		= ${"cap_curso".$i};					if($cap_curso=="") $cap_curso=0;	
		$plan_inst		= ${"plan_ins".$i};						if($plan_inst=="") $plan_inst=0;
		
																											
																									
if ($frmModo=="modificar"){
	
			 $qry="SELECT * FROM SUPERVISA WHERE ID_CURSO=".$id_curso;
			$result =@pg_Exec($conn,$qry)or die("Fallo Select");
			if (!$result)
				error('<b> ERROR :</b>Error al acceder a la BD.(4)'.$qry);
				else{
					if(pg_numrows($result)!=0){
						$fila1 = @pg_fetch_array($result,0);
						$profe=trim($fila1['rut_emp']);
						$qry="DELETE FROM SUPERVISA WHERE RUT_EMP='".trim($profe)."' AND ID_CURSO=".$id_curso;
						$result =@pg_Exec($conn,$qry)or die("Fallo DELETE");
					}
					 $qry="INSERT INTO SUPERVISA VALUES ('".$rut_emp."',".$id_curso.")";
					$result =@pg_Exec($conn,$qry);
					
					
					// echo "<br>"."Jornada-->".$Jornada;
					
				if(!isset($cmbACTA)){
				$cmbACTA=0;
				}
	
					 $qryJ="UPDATE CURSO SET BOOL_JOR=".$Jornada.", truncado_per = ".$truncado_per.", truncado_final = ".$truncado_final." ,truncado_sf = ".$truncado_sf.", simce = ".$simce.", acta = ".$cmbACTA.", observaciones = '".$observaciones."', val_sub = '".$val_sub."', cap_curso = '".$cap_curso."',cod_decreto=".$plan_inst." WHERE ID_CURSO=".$id_curso;
	$resultJ =@pg_Exec($conn,$qryJ)or die ("Fallo C!!!!!".$qryJ);
	
			}
		}
	}
}
echo "<script>window.location='seteaConfig.php?caso=1&ano=$ano'</script>";

pg_close($conn);

?> 