 <?php require('../../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$formula		=$_FORMULA;
	$periodo        =$_PERIODO;
?>
<script type="text/JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
<?	


if($frmModo=="ingresar"){
   	
	$conta =0;
	for($a=0;$a<$cont;$a++){
		if(($_POST['nota'][$a]!="")){
			$PosNota[$conta]		= $_POST['nota'][$a];
			$conta++;
		}
	}
	
	
	if ($modo==2){
	    // inserto pero sin la posicion de las notas
		for($i=0;$i<count($_POST['padre']);$i++){
			$qry = "";
			$qry = "INSERT INTO formula (id_ramo,modo) VALUES ('".$_POST['padre'][$i]."','2')";
			$Rs_Formula = @pg_exec($conn,$qry);
		}
		
	}
	
	if ($modo==1){
	   // tomar todos los alumnos del ramo
	   $qry_ano    = "select * from ano_escolar where id_ano = '".trim($_ANO)."'";
	   $res_ano    = @pg_Exec($conn,$qry_ano);
	   $fila_ano   = @pg_fetch_array($res_ano);
	   $nro_ano    = $fila_ano['nro_ano'];  
	   $ramo_padre = $_POST['padre'][0];
	   
	      
	   $qry_alum  = "select * from notas$nro_ano where id_ramo = '$ramo_padre'";
	   $res_alum  = @pg_Exec($conn,$qry_alum);
	   $num_alum =  @pg_numrows($res_alum);
	   
	   $posicionnota = 0;
	   
	   
	   for ($i=0; $i < $num_alum; $i++){
	       $fila_alum = @pg_fetch_array($res_alum);
		   $rut_alumno  = $fila_alum['rut_alumno'];
		   $nota1       = $fila_alum['nota1'];
		   $nota2       = $fila_alum['nota2'];
		   $nota3       = $fila_alum['nota3'];
		   $nota4       = $fila_alum['nota4'];
		   $nota5       = $fila_alum['nota5'];
		   $nota6       = $fila_alum['nota6'];
		   $nota7       = $fila_alum['nota7'];
		   $nota8       = $fila_alum['nota8'];
		   $nota9       = $fila_alum['nota9'];
		   $nota10      = $fila_alum['nota10'];
		   $nota11      = $fila_alum['nota11'];
		   $nota12      = $fila_alum['nota12'];
		   $nota13      = $fila_alum['nota13'];
		   $nota14      = $fila_alum['nota14'];
		   $nota15      = $fila_alum['nota15'];
		   $nota16      = $fila_alum['nota16'];
		   $nota17      = $fila_alum['nota17'];
		   $nota18      = $fila_alum['nota18'];
		   $nota19      = $fila_alum['nota19'];
		   $nota20      = $fila_alum['nota20']; 
		   
		  
		   
		   if ($nota1!=0){
		       $sw=1;			   
		   }
		   if ($nota2!=0){
		       $sw=2;
			   
		   }
		   if ($nota3!=0){
		       $sw=3;
			   
		   }
		   if ($nota4!=0){
		       $sw=4;
			   
		   }
		   if ($not5!=0){
		       $sw=5;
			   
		   }
		   if ($nota6!=0){
		       $sw=6;
			  
		   }
		   if ($nota7!=0){
		       $sw=7;
			   
		   }
		   if ($nota8!=0){
		       $sw=8;
			  
		   }
		   if ($nota9!=0){
		       $sw=9;
			   
		   }
		   if ($nota10!=0){
		       $sw=10;
			   
		   }
		   if ($nota11!=0){
		       $sw=11;
			  
		   }
		   if ($nota12!=0){
		       $sw=12;
			   
		   }
		   if ($nota13!=0){
		       $sw=13;
			   
		   }
		   if ($nota14!=0){
		       $sw=14;
			  
		   }
		   if ($nota15!=0){
		       $sw=15;
			   
		   }
		   if ($nota16!=0){
		       $sw=16;
			  
		   }
		   if ($nota17!=0){
		       $sw=17;
			  
		   }
		   if ($nota18!=0){
		       $sw=18;
			   
		   }
		   if ($nota19!=0){
		       $sw=19;
			   
		   }
		   if ($nota20!=0){
		       $sw=20;			   
		   }
		   
		   if (($sw!=0) AND ($posicionnota==0)){
		       $posicionnota = $sw;
		   }
		   
		   if ($sw > $posicionnota){
		       // actualizo la maxima posicon de la nota
			   $posicionnota = $sw;
		   }   
		   
		}
		
		/*
		if ($posicionnota>0){
		   echo "<script>alert('Error, actualmente existen notas ingresadas en el subsector padre, no es posible continuar');</script>";
		   ?>
		   <body onLoad="MM_callJS('history.go(-3);')">
           </body>
		   <?
		   exit();
		}*/
			
		for($i=0;$i<count($_POST['padre']);$i++){
			$qry = "";
			$qry = "INSERT INTO formula (id_ramo,nota,modo) VALUES (" . $_POST['padre'][$i] . "," . $PosNota[$i] . ",'1')";
			$Rs_Formula = @pg_exec($conn,$qry);
		}
	
	}
	
	if ($modo==3){
			
		for($i=0;$i<count($_POST['padre']);$i++){
			$qry = "";
			$qry = "INSERT INTO formula (id_ramo,modo) VALUES ('".$_POST['padre'][$i]."','3')";
			$Rs_Formula = @pg_exec($conn,$qry);
		}
	
	}
	
	
	$qry1 = "";
	$qry1 = "SELECT  max(id_formula) as maximo FROM formula";
	$Rs_Idformula = @pg_exec($conn,$qry1);
	$fila = @pg_fetch_array($Rs_Idformula,0);
	$Maximo	= $fila['maximo'];
	
	if ($modo==1){	
		$contador =0;
		for($a=0;$a<count($_POST['Porcent']);$a++){
			if($_POST['Porcent'][$a]!=""){
				$porcentaje[$contador] 	= $_POST['Porcent'][$a];
				//$PosNota[$contador]		= $_POST['nota'][$a];
				$contador++;
			}
		}	
		for($j=0;$j<count($_POST['hijo']);$j++){
			$qry2 = "";
			$qry2 = "INSERT INTO formula_hijo (id_formula, id_hijo,porcentaje) VALUES ('".$Maximo."','".$_POST['hijo'][$j]."','".$porcentaje[$j]."')";
			$Rs_Hijo = pg_exec($conn,$qry2);
		}	
	}
	
	if ($modo==2){	
		$contador =0;
		for($a=0;$a<count($_POST['Porcent2']);$a++){
			if($_POST['Porcent2'][$a]!=""){
				$porcentaje[$contador] 	= $_POST['Porcent2'][$a];
				//$PosNota[$contador]		= $_POST['nota'][$a];
				$contador++;
			}
		}	
		for($j=0;$j<count($_POST['hijo']);$j++){
			$qry2 = "";
			$qry2 = "INSERT INTO formula_hijo (id_formula, id_hijo,porcentaje) VALUES ('".$Maximo."','".$_POST['hijo'][$j]."','".$porcentaje[$j]."')";
			$Rs_Hijo = pg_exec($conn,$qry2);
		}	
	}
	
	if ($modo==3){
				
		for($j=0;$j<count($_POST['hijo']);$j++){
			$qry2 = "";
			$qry2 = "INSERT INTO formula_hijo (id_formula, id_hijo,porcentaje) VALUES ('".$Maximo."','".$_POST['hijo'][$j]."','0')";
			$Rs_Hijo = pg_exec($conn,$qry2);
		}	}	
}




if($frmModo=="modificar"){
	$conta =0;
	for($a=0;$a<$cont;$a++){
		if(($_POST['nota'][$a]!="")){
			$PosNota[$conta]		= $_POST['nota'][$a];
			$conta++;
		}
	}

	for($i=0;$i<count($_POST['padre']);$i++){
		$qry = "";
//		$qry = "UPDATE formula SET id_ramo=" . $_POST['padre'][$i]." WHERE id_formula=" . $formula;
		$qry = "UPDATE formula SET id_ramo=".$_POST['padre'][$i].", nota=".$PosNota[$i]." WHERE id_formula=" . $formula;
		$Rs_Formula = @pg_exec($conn,$qry);
	}
	
	$qry3 = "";
	$qry3 = "DELETE FROM formula_hijo WHERE id_formula=" . $formula;
	$Rs_Delete = @pg_exec($conn,$qry3);
	
	$contador =0;
	for($a=0;$a<count($_POST['Porcent']);$a++){
		if($_POST['Porcent'][$a]!=""){
			$porcentaje[$contador] 	= $_POST['Porcent'][$a];
			$contador++;
		}
	}	
	for($j=0;$j<count($_POST['hijo']);$j++){
		$qry2 = "";
		$qry2 = "INSERT INTO formula_hijo (id_formula, id_hijo,porcentaje) VALUES (". $formula . ", " . $_POST['hijo'][$j] . ",".$porcentaje[$j].")";
		$Rs_Hijo = @pg_exec($conn,$qry2);
	} 
}
if($frmModo=="eliminar"){
	$qry = "";
	$qry = "DELETE FROM formula WHERE id_formula=" . $formula;
	$Rs_Formula = @pg_exec($conn,$qry);
	
	$qry1 ="";
	$qry1 ="DELETE FROM formula_hijo WHERE id_formula=" . $formula;
	$Rs_Hijo = @pg_exec($conn,$qry1);
}


echo "<script>window.location = 'seteaFormula.php3?caso=4&formula=".$formula."' </script>";


?>