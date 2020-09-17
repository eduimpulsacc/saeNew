<?php require('../../../util/header.inc');?>
<?php
     $instit = $_INSTIT;
 	$frmModo	= $_FRMMODO;
?><html>
 <head>
 </head>
 <body>
<?php
	if($PA)		$PA=1; else $PA=0;
	if($SA)		$SA=1; else	$SA=0;	
	if($TA)		$TA=1; else	$TA=0;	
	if($CU)		$CU=1; else	$CU=0;	
	if($QU)		$QU=1; else	$QU=0;	
	if($SX)		$SX=1; else	$SX=0;	
	if($SP)		$SP=1; else	$SP=0;	
	if($OC)		$OC=1; else	$OC=0;	
	
	
	
 
	if ($frmModo=="ingresar") {
		 for($i=0;$i < 20 ;$i++){	 
						    $qry="Select * from incluye_propio where (cod_decreto='$sub[$i]')";
						    $result =@pg_Exec($conn,$qry);
		      				if (@pg_numrows($result)==0){ ?>
					 		<td align="center"> <div align="center">
    						<?php
			    
					$qry="INSERT INTO incluye_propio (cod_decreto, rdb, cod_subsector) VALUES ('".trim($plan)."','".$instit."','".trim($sub[$i])."')";
						 $result =@pg_Exec($conn,$qry);
		    		 if (!$result){ 
			   			 error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
							exit;}
			  		}
		 		}
			echo "<script>window.location = 'SubPlanPropio.php3?plan=".$txtNRESOL."&ensenanza=".$cmbENS."'</script>";
		}
	
	
     

if ($frmModo=="modificar"){
                   echo "<script>window.location = '../atributos/seteaTipoEnse.php3?caso=1&ensenanza=".$_ENSENANZA." &institucion1=".$_INSTIT."'</script>";         
                 }
       
	
if ($frmModo=="eliminar"){
	$qry="DELETE FROM tipo_ense_inst WHERE(((cod_tipo)=$_ENSENANZA) and ((rdb)=$_INSTIT))";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al eliminar.'.$qry);
	}else{
		echo "<script>window.location = 'listarTiposEnsenanza.php3'</script>";
	}
  }
?>
</div>
</body>
</html>