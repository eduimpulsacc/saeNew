<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php 
$qry="Select * from nota order by rut_alumno, id_ramo, id_periodo";
   $result=@pg_Exec($conn,$qry);
     if (!$result){ 
		error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>'.$qry);
		}else{
     if (@pg_numrows($result)!=0){
	    for ($i=0 ; $i < @pg_numrows($result); $i++){
		     $fila=@pg_fetch_array($result,$i);
		   $qry2="Select * from nota where rut_alumno=".$fila['rut_alumno']."and id_ramo=".$fila['id_ramo']."and id_periodo=".$fila['id_periodo']."order by rut_alumno, id_ramo, id_periodo";
		 		$result2=@pg_Exec($conn,$qry2);
				    if (!$result2){ 
						error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>'.$qry2);
						   }else{
				if (@pg_numrows($result2)!=0){
				    $qry3="Select * from notas_prueba where rut_alumno=".$fila2['rut_alumno']."and id_ramo=".$fila2['id_ramo']."and id_periodo=".$fila2['id_periodo']."order by rut_alumno, id_ramo, id_periodo";
  						$result3=@pg_Exec($conn,$qry3);
						     if (!$result3){ 
								error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>'.$qry3);
								} else{
						if (@pg_numrows($result3)==0){
				    for($i=0 ; $i < @pg_numrows($result2); $i++){
					        if($i==1 and $fila2['valor'][1]!=""){
						     $valor1=$fila2['valor'][1];
							}else{
							if($i==1 and $fila2['valor'][1]==""){ 
							 $valor1=0;
							 }  
							  if($i==2 and $fila2['valor'][2]!=""){
						     $valor2=$fila2['valor'][2];
							}else{
							if($i==2 and $fila2['valor'][2]==""){ 
							 $valor2=0;
							 }
							  if($i==3 and $fila2['valor'][3]!=""){
						     $valor3=$fila2['valor'][3];
							}else{
							if($i==3 and $fila2['valor'][3]==""){ 
							 $valor3=0;
							 }
							  if($i==4 and $fila2['valor'][4]!=""){
						     $valor4=$fila2['valor'][4];
							}else{
							if($i==4 and $fila2['valor'][4]==""){ 
							 $valor4=0;
							 }
							  if($i==5 and $fila2['valor'][5]!=""){
						     $valor5=$fila2['valor'][5];
							}else{
							if($i==5 and $fila2['valor'][5]==""){ 
							 $valor5=0;
							 }
							  if($i==6 and $fila2['valor'][6]!=""){
						     $valor6=$fila2['valor'][6];
							}else{
							if($i==6 and $fila2['valor'][6]==""){ 
							 $valor6=0;
							 }
							  if($i==7 and $fila2['valor'][7]!=""){
						     $valor7=$fila2['valor'][7];
							}else{
							if($i==7 and $fila2['valor'][7]==""){ 
							 $valor7=0;
							 }
							  if($i==8 and $fila2['valor'][8]!=""){
						     $valor8=$fila2['valor'][8];
							}else{
							if($i==8 and $fila2['valor'][8]==""){ 
							 $valor8=0;
							 }
							  if($i==9 and $fila2['valor'][9]!=""){
						     $valor9=$fila2['valor'][9];
							}else{
							if($i==9 and $fila2['valor'][9]==""){ 
							 $valor9=0;
							 }
							  if($i==10 and $fila2['valor'][10]!=""){
						     $valor10=$fila2['valor'][10];
							}else{
							if($i==10 and $fila2['valor'][10]==""){ 
							 $valor10=0;
							 }
							}
						   }
						    $qry4="insert into notas_prueba (rut_alumno, id_ramo, id_periodo, nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10) values (".$fila2['rut_alumno'].",  ".$fila2['id_ramo'].", ".$fila2['id_periodo'].", '".$valor1."', '".$valor2."', '".$valor3."', '".$valor4."', '".$valor5."', '".$valor6."', '".$valor7."', '".$valor8."', '".$valor9."', '0')";
       						 $result4=@pg_Exec($conn,$qry4);
							 if (!$result4) {
								error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>'.$qry4);
								exit();						
					             }
						    
					        }
						
					  }
				
				 }
						 
		   }
		   		   	  		
      }
	}   
?>
</body>
</html>
