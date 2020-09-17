<?php require('../../../../../util/header.inc');?>
<?php


/*if($_PERFIL==0){
	print_r($_POST);
	}*/
$institucion = $_INSTIT;

if($_PERFIL==0){
  $sql= "SELECT num_corp FROM corp_instit WHERE rdb=".$institucion;
  $rs_corp = @pg_exec($conn,$sql);
  $corporacion = @pg_result($rs_corp,0);
 }else{
  $corporacion=$_CORPORACION;
 }
 


  if(pg_dbname($conn)=='coi_antofagasta'){ 
	
	  echo '<br/> fecha : '.$fecha =$txtNAC;
	
	}else{
 
  echo '<br/> fecha : '.$fecha =fEs2En($txtNAC);
 
 } 


   if (($pesta == 6) and ($borrar == 1)){
       // borrar
	   $q1 = "delete from relacion_grupo where rut_integrante = '".trim($_ALUMNO)."' and id_grupo = '$id_grupo'";
	   $r1 = pg_Exec($conn,$q1);
	   pg_close($conn);
	   echo "<script>window.location='alumno.php3?pesta=6'</script>";
	   	
	   exit();
   }	   
  
   


  if (($pesta=="6") and ($graba=="1")){
       // Agregar grupo al alumno
	   $q1 = "select * from grupos where rdb = '".trim($institucion)."' order by id_grupo Desc";
	   $r1 = pg_Exec($conn,$q1);
	   $n1 = pg_numrows($r1);   
	   
       
	   $i = 0;
	   while ($i < $n1){
	       $f1 = pg_fetch_array($r1,$i);
		   $chg = "chg".$i;
		   $chg = $$chg;
		   $id_grupo = $f1['id_grupo'];
		  		  	   
		   if ($chg == $id_grupo){
		     
		      // antes de agregar consultar si ya existe
			  $q3 = "select * from relacion_grupo where id_grupo = '$id_grupo' and rut_integrante = '".trim($_ALUMNO)."'";
			  $r3 = pg_Exec($conn,$q3);
			  $n3 = pg_numrows($r3);
			  
			  if ($n3==0){  // Inserto		   
		   		   // Agrego al alumno en detalle_grupos			   
				   $q2 = "insert into relacion_grupo (id_grupo, rut_integrante, id_perfil, id_ano, id_curso)
				   values ('".trim($id_grupo)."','".trim($_ALUMNO)."','16','".trim($_ANO)."', '".trim($_CURSO)."')";
				   $r2 = pg_Exec($conn,$q2);
								   
				   // registro insertado
			   }	   
		   }
		   $i++;
	   }	   	    
		
	   // fin proceso
	   pg_close($conn);
	   echo "<script>window.location = 'alumno.php3?pesta=6'</script>";
	   	
	   exit();
  }
  
  
  
  
  
  if (($pesta==7) and ($graba==1)){
       // Agregar entrevista al apoderado
	   // seleccionar al apoderado del alumno
	   $sql_apo = "select * from tiene2 where rut_alumno = '".trim($_ALUMNO)."' and responsable=1";
	   $res_apo = @pg_Exec($conn,$sql_apo) or die(pg_last_error($conn));
	   $fil_apo = @pg_fetch_array($res_apo);
	   $rut_apo = $fil_apo['rut_apo'];
	   
	   /// fecha de hoy
	   $dd = date(d);
	   $mm = date(m);
	   $aa = date(Y);	   
	   
	   $fecha_hoy = "$aa-$mm-$dd";
	   
	   // insertamos en la tabla de entrevistas
	  $insertar_entrevista = "insert into entrevista (rdb,id_ano,rut_apo,rut_alumno,fecha,asunto,observaciones)
	   values ('".$_INSTIT."','".$_ANO."','$rut_apo','".$_ALUMNO."','$fecha_hoy','$asunto','$observaciones')";
	   //echo $insertar_entrevista;
	   //return;
	   $res_insertar = @pg_Exec($conn,$insertar_entrevista) or die(pg_last_error($conn));

	 
	   // fin de insertar
	   pg_close($conn);
	   echo "<script>window.location = 'alumno.php3?pesta=7'</script>";
	   	
	   exit();
  }
  
  
  
  if (($pesta == 7) and ($borrar == 1)){
       // borrar
	   $q1 = "delete from entrevista where id_entrevista = '$id_entrevista'";
	   $r1 = pg_Exec($conn,$q1);
	   pg_close($conn);
	   echo "<script>window.location='alumno.php3?pesta=7'</script>";
	   	
	   exit();
   }




$aa = date(Y);
$ano_retiro = substr($FechaRetiro,6,4);

$frmModo		=$_FRMMODO;
$ano            =$_ANO;

$separa = explode("_",$m3);
/*
$txtCOM = trim($separa[0]);
$txtCIU = trim($separa[1]);
$txtREG = trim($separa[2]);
*/




  if ($pesta != 1){
  
  if ($aa != $ano_retiro){ ?>
     <script type="text/JavaScript">
     <!--
        function MM_callJS(jsStr) { //v2.0
           return eval(jsStr)
        }
      //-->
     </script>
	 <br /><br /><div align="center">
	 <table width="400" height="150" border="1" cellpadding="5" align="center"><tr><td align="center">
	 <font face="Arial, Helvetica, sans-serif" size="2">Error, la fecha ingresada no corresponde al año actual.<br /><br />
     <a href="#" onclick="MM_callJS('history.go(-1)')">Volver a ingresar información</a></font>
	 </td></tr></table>
	 
	 </div>
	 <?
	 exit();
   }	 
     
	}
	
	if ($pesta == 1){
	    	
		    // se actualizan los datos personales solamente
		    	
			
		  $qry="UPDATE alumno SET nombre_alu = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", email = '".trim($txtEMAIL)."', fecha_nac = '".$fecha."', nacionalidad= ". intval(trim($cmbNac)).", comuna = ".$Comuna.", ciudad = ".$Provincia.", region = ".$Region." WHERE (((rut_alumno)='".trim($_ALUMNO)."'));";
		  $result = pg_Exec($conn,$qry);
		  
		 	 
		 if (!$result){
		    echo "Error, no se pudo actualizar ".$qry;
		    exit();
		 }
		 
		 // Actualizamos para el caso de la alumna embarazada y los indígenas
		 if($AE)     $AE=1;      else     $AE=0;
		 if($AOI)    $AOI=1;     else     $AOI=0;
		 
		 if($proced_Alumno) $proced_Alumno=$proced_Alumno; else $proced_Alumno="-";
		  if($con_quien_vive) $con_quien_vive=$con_quien_vive; else $con_quien_vive="-";
		 
		 $qry2="UPDATE matricula SET 
		 bool_ae ='".$AE."', 
		 bool_aoi ='".$AOI."',
		 proced_alumno='".$proced_Alumno."',
		 con_quien_vive='".$con_quien_vive."'
		 WHERE rut_alumno='".trim($_ALUMNO)."' AND ID_ANO='".trim($ano)."'";
	     $result2 = @pg_Exec($conn,$qry2);  
	     if (!$result2) {
	        echo "Error, al intentar actualizar".$qry2;	
	        exit();       
	     }		 	
		 
echo	"<script>window.location = 'seteaAlumno.php3?caso=1&alumno=".trim($_ALUMNO)."'</script>";
			 
	}else{
		 
		
	  	 
	 
	 
  	$frmModo		=$_FRMMODO;
	$ano            =$_ANO;
	
		
	if($Region=="")
		$Region=1;
	if($Provincia=="")
		$Provincia=1;
	if($Comuna=="")
		$Comuna=1;
if ($frmModo=="modificar"){
         if($BAJ)	    $BAJ=1;		else	$BAJ=0;
	     if($BCHS)		$BCHS=1;	else	$BCHS=0;
	     if($AOI)		$AOI=1;		else	$AOI=0;
	     if($RDG)		$RDG=1;		else	$RDG=0;
	     if($AE)	    $AE=1;		else	$AE=0;
	     if($GRD)		$GRD=1;		else	$GRD=0;
         if($I)		    $I=1;		else	$I=0;
         if($AR)        $AR=1;      else    $AR=0;
		 if($ED)        $ED=1;      else    $ED=0;
		 if($SEP)        $SEP=1;    else    $SEP=0;
		 if($FCI)		$FCI=1;		else	$FCI=0;
         
		      $qry="UPDATE alumno SET nombre_alu = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$Region.", ciudad = ".$Provincia.", comuna = ".$Comuna.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", email = '".trim($txtEMAIL)."', fecha_nac = '".fEs2En($txtNAC)."', nacionalidad= ". intval(trim($cmbNac)) ." WHERE (((rut_alumno)='".trim($_ALUMNO)."'));";
			 
			  
		            $result = @pg_Exec($conn,$qry);
					
				 	 if (($FechaRetiro !="") and ($AR=1)) {
				   $qry2="UPDATE matricula SET  bool_baj ='".$BAJ."', bool_bchs ='".$BCHS."', bool_aoi ='".$AOI."', bool_rg ='".$RDG."', bool_ae = '".$AE."', bool_gd ='".$GRD."', bool_i ='".$I."', bool_ar ='".$AR."', fecha_retiro = '".fEs2En($FechaRetiro)."', bool_ed='".$ED."', ben_sep='".$SEP."',bool_fci='".$FCI."' WHERE (((rut_alumno)='".trim($_ALUMNO)."') AND (ID_ANO='".trim($ano)."'));";
				  
		             }else{
				     if (($FechaRetiro =="") or ($AR=0)) {
		          $qry2="UPDATE matricula SET  bool_baj ='".$BAJ."', bool_bchs ='".$BCHS."', bool_aoi ='".$AOI."', bool_rg ='".$RDG."', bool_ae = '".$AE."', bool_gd ='".$GRD."', bool_i ='".$I."', bool_ar ='".$AR."', fecha_retiro = NULL, bool_ed='".$ED."', ben_sep='".$SEP."',bool_fci='".$FCI."'  WHERE (((rut_alumno)='".trim($_ALUMNO)."') AND (ID_ANO='".trim($ano)."'));";
				  
					 }
					 if($_PERFIL==0){ exit;}
					}  
				  $result2 = @pg_Exec($conn,$qry2);  
		       if (!$result2) {
			       error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry2);  
		       }else{
			
			
			   if ($AR){
					   $mes_retiro = substr($FechaRetiro,3,2);
					   if ($mes_retiro == "01" or $mes_retiro == "02" or $mes_retiro == "03" or $mes_retiro == "04"){
					       pg_close($conn);									   
						   echo "<script>window.location = 'seteaAlumno.php3?caso=1&sw=1&alumno=".trim($_ALUMNO)."'</script>";
					   }else{
					       pg_close($conn);
						   echo "<script>window.location = 'seteaAlumno.php3?caso=1&alumno=".trim($_ALUMNO)."'</script>";
					   }
			   }else{
			        pg_close($conn);
			 	   	echo "<script>window.location = 'seteaAlumno.php3?caso=1&alumno=".trim($_ALUMNO)."'</script>";
			   }
			   }	   
}

}
?>