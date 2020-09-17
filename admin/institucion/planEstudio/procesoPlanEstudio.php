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
	
	
if ($frmModo=="ingresar1"){
   
  			$qry="Select * from plan_inst where ((rdb='".$instit."') and (cod_decreto='".$cmbPLAN."'))";
				$result =@pg_Exec($conn,$qry);
		         if (pg_numrows($result)!=0){ ?>
				<td align="center"> <div align="center">
    			<?php
			    echo ('<b> EL DECRETO YA EXISTE2!</b>');
				?>
 			 	</div></td>
				<div align="center">
  					<script> setTimeout("window.location='listarPlanesEstudio.php'",2000);</script>					
		<?php
					exit;} 
						else{
		
         			$qry="INSERT INTO plan_inst (rdb,cod_decreto) VALUES ('".trim($instit)."','".trim($cmbPLAN)."')";
					 $result =@pg_Exec($conn,$qry);
		     		   if (!$result){ 
			    	    error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
					  exit;}
		 				echo "<script>window.location = 'listarPlanesEstudio.php'</script>";
						}  
		 }else{  
		      if ($frmModo=="ingresar") {	 
						 $qry="Select * from plan_estudio where (cod_decreto='".$txtNRESOL."')";
						 $result =@pg_Exec($conn,$qry);
		      				if (@pg_numrows($result)!=0){ ?>
					<td align="center"> <div align="center">
    			<?php
			    			echo ('<b> EL DECRETO YA EXISTE3!</b>');
				?>
 			 		</div></td>
					<div align="center">
  					<script> setTimeout("window.location='listarPlanesEstudio.php'",2000);</script>
 			 	<?php
					exit;} 
				else{
		$qry="INSERT INTO plan_estudio (cod_decreto, cursos, nombre_decreto, rdb, fecha_decreto) VALUES ('".trim($txtNRESOL)."','".$txtDRES."','".trim($txtNOMDECRE)."','".trim($instit)."','".trim($txtFECHARES)."')";
		 $result =@pg_Exec($conn,$qry);
		     if (!$result){ 
			    error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
				exit;}
		    $qry2="INSERT INTO plan_inst (rdb, cod_decreto) VALUES ('".trim($instit)."','".trim($txtNRESOL)."')";
			   $result2 =@pg_Exec($conn,$qry2);
			         if (!$result2){ 
			    error('<b> ERROR :</b>Error al acceder a la BD. (4)'.$qry2);
				   exit;}  
			$qry3="INSERT INTO plan_tipo (cod_decreto, cod_tipo) VALUES ('".trim($txtNRESOL)."','".trim($cmbENS)."')";
			            $result3 =@pg_Exec($conn,$qry3);
						 if (!$result3){ 
			    error('<b> ERROR :</b>Error al acceder a la BD. (5)'.$qry3);
				exit;  
				 }
			$qry4="INSERT INTO tipo_ense_inst (rdb, cod_tipo, cod_decreto, estado) VALUES ('".trim($instit)."','".trim($cmbENS)."','".trim($txtNRESOL)."','1')";
			            $result4 =@pg_Exec($conn,$qry4);
						 if (!$result4){ 
			    error('<b> ERROR :</b>Error al acceder a la BD. (5)'.$qry4);
				exit;  
				 }
			$qry5="INSERT INTO cursos_plan(cod_decreto, pa, sa, ta, cu, qu, sx, sp, oc) VALUES ('".trim($txtNRESOL)."', '".trim($PA)."', '".trim($SA)."', '".trim($TA)."', '".trim($CU)."', '".trim($QU)."', '".trim($SX)."', '".trim($SP)."', '".trim($OC)."')";
			            $result5 =@pg_Exec($conn,$qry5);
						 if (!$result5){ 
			    error('<b> ERROR :</b>Error al acceder a la BD. (5)'.$qry5);
				exit;  
				 }


		for($i=1 ; $i <= 20 ; $i++){
			$sub = sub.$i;
			if (${$sub}!='' and ${$sub}!=0){
			  $qry="Select * from incluye_propio where ((cod_decreto='".trim($cod_decreto)."') and (cod_subsector='".${$sub}."'))";
				$result =@pg_Exec($conn,$qry);
		          if ((pg_numrows($result)==0) and ((${$sub})!='')){
				$qry6 ="INSERT INTO incluye_propio (cod_decreto, cod_subsector) VALUES ('".trim($txtNRESOL)."','".${$sub}."')";
					 $result6 =@pg_Exec($conn,$qry6);
					 if (!$result6){
					 error('<b> ERROR :</b>Error al acceder a la BD. (6)'.$qry6);
					 exit;
					}
				 }
		      }
		}
			echo "<script>window.location = 'listarPlanesEstudio.php?plan=".$txtNRESOL."&ensenanza=".$cmbENS."'</script>";
			  }
		 }
	}
     

if ($frmModo=="modificar"){

					
				$qry="Select * from plan_tipo where ((cod_decreto='".trim($cod_decreto)."') and (cod_tipo='".trim($cmbENS)."'))";
					  $result =@pg_Exec($conn,$qry);
		        	  if (pg_numrows($result)==0){
					       if ($cmbENS!=0){
					$qry3="INSERT INTO plan_tipo (cod_decreto, cod_tipo) VALUES ('".trim($cod_decreto)."','".trim($cmbENS)."')";
			             $result3 =@pg_Exec($conn,$qry3);
						 if (!$result3){ 
			             error('<b> ERROR :</b>Error al acceder a la BD. (5)'.$qry3);
				         exit;  
				         }
						 
					$qry4="INSERT INTO tipo_ense_inst (rdb, cod_tipo, estado, cod_decreto) VALUES ('".trim($instit)."','".trim($cmbENS)."','1','".trim($cod_decreto)."')";
			             $result4 =@pg_Exec($conn,$qry4);
						 if (!$result4){ 
			             error('<b> ERROR :</b>Error al acceder a la BD. (5)'.$qry4);
				         exit;  
				         }
					   }
					   }
					  
					$qry5 = "UPDATE cursos_plan SET pa='".trim($PA)."', sa='".trim($SA)."', ta='".trim($TA)."', cu='".trim($CU)."', qu='".trim($QU)."', sx='".trim($SX)."', sp='".trim($SP)."', oc='".trim($OC)."' WHERE cod_decreto =".$cod_decreto;                 
					     $result5 = @pg_Exec($conn,$qry5);
                          if (!$result5) {
						  error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry5);
				          }
						  
					$qry6 = "UPDATE plan_estudio SET cursos='".trim($cursos)."' WHERE cod_decreto =".$cod_decreto;                 
					     $result6 = @pg_Exec($conn,$qry6);
                          if (!$result6) {
						  error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry6);
				          }	  
					   
						
			
			for($i=1 ; $i <= 20 ; $i++){ 
			$sub = sub.$i;
			  $qry="Select * from incluye_propio where ((cod_decreto='".trim($cod_decreto)."') and (cod_subsector='".${$sub}."'))";
					   $result =@pg_Exec($conn,$qry);
		        	     if ((pg_numrows($result)==0) and ((${$sub})!='')){
				   		 $qry6 = "INSERT  into incluye_propio (cod_decreto, cod_subsector) VALUES ('".trim($cod_decreto)."', '".${$sub}."')";
							$result6 = @pg_Exec($conn,$qry6);
						 	if (!$result6) {
						  	error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry6);
				          	}
						  }	
						}
						 
					for ($i=0;$i<count($_POST['subsector']);$i++) { 
                     $qryA="DELETE  FROM incluye_propio  WHERE ((cod_decreto='".trim($cod_decreto)."') and (cod_subsector='".$_POST['subsector'][$i]."')) ";
				         $resultA =@pg_Exec($conn,$qryA);
                    }
						echo "<script>window.location = 'listarPlanesEstudio.php'</script>";         
                          
                 }
       
	
if ($frmModo=="eliminar"){
	$qry="DELETE FROM tipo_ense_inst WHERE(((cod_tipo)=$_ENSENANZA) and ((rdb)=$_INSTIT))";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al eliminar.'.$qry);
	}else{
		echo "<script>window.location = 'listarTiposEnsenanza.php'</script>";
	}
  }
?>
</div>
</body>
</html>