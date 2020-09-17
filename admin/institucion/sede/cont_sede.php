<?
header( 'Content-type: text/html; charset=iso-8859-1' );
require('../../../util/header.inc');
session_start();

//$objMembrete= new Membrete($_IPDB,$_DBNAME);


$funcion = $_POST['funcion'];


		  if($funcion==1){
			  
	   $qryREG="SELECT * FROM REGION ORDER BY COD_REG ASC";
	    $resultREG	=@pg_Exec($conn,$qryREG);
		if($resultREG){
		 $select =  '<select name="select_region" id="select_region" onChange="cargarselect2(2,this.value)">
         <option value=0 selected>Selecccionar</option>';
		  for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){  
		  $filaREG = @pg_fetch_array($resultREG ,$i); 
   		 $select  .="<OPTION value=\"".trim($filaREG['cod_reg'])."\">".trim($filaREG['nom_reg'])." </OPTION>";
		       } 
		$select .= "</select>";
		echo $select;
		}else{
		 echo 0;	
		}
     } 
	 
	 
	   if($funcion==2){
			  
		$id_region=$_POST['id_region'];	  
	    $qry="SELECT * FROM PROVINCIA WHERE COD_REG=".$id_region." ORDER BY NOM_PRO ASC";
	    $result	=@pg_Exec($conn,$qry);
		if($result){
		 $select =  '<select name="select_provincias" id="select_provincias" onChange="cargarselect3(3,this.value)">
         <option value=0 selected>Selecccionar</option>';
		  for($i=0 ; $i < @pg_numrows($result) ; $i++){  
		  $fila = @pg_fetch_array($result ,$i); 
   		 $select  .="<OPTION value=\"".trim($fila['cor_pro'])."\">".trim($fila['nom_pro'])." </OPTION>";
		       } 
		$select .= "</select>";
		echo $select;
		}else{
		 echo 0;	
		}
     } 
	 
	  if($funcion==3){
			  
		$id_provincia=$_POST['id_provincia'];	  
		$id_region=$_POST['id_region'];
	    $qry="SELECT * FROM COMUNA WHERE COR_PRO=".$id_provincia." AND COD_REG=".$id_region." ORDER BY NOM_COM ASC";
	    $result	=@pg_Exec($conn,$qry);
		if($result){
		 $select =  '<select name="select_comuna" id="select_comuna">
         <option value=0 selected>Selecccionar</option>';
		  for($i=0 ; $i < @pg_numrows($result) ; $i++){  
		  $fila = @pg_fetch_array($result ,$i); 
   		 $select  .="<OPTION value=\"".trim($fila['cor_com'])."\">".trim($fila['nom_com'])." </OPTION>";
		       } 
		$select .= "</select>";
		echo $select;
		}else{
		 echo 0;	
		}
     } 
	

?>