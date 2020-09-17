<?php

echo "PATRACOM<br>";

$conn1=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 1");

//$conn2=@pg_connect("dbname=murialdo host=190.101.89.162 port=1550 user=postgres password=post2005*") or die ("No pude conectar a la base de datos destino 2");

$sql = "select * from respaldonotas2011_murialdo";
$rs = @pg_exec($conn1,$sql);
$x=0;

for($i=0; $i<pg_numrows($rs); $i++){
	
$fila = pg_fetch_array($rs,$i); 

$_id_ramo = $fila['id_ramo'];
$_id_curso = $fila['id_curso'];
$_ensenanza = $fila['ensenanza'];
$_grado_curso = $fila['grado_curso'];
$_letra_curso = $fila['letra_curso'];
$_nombre = $fila['nombre'];
$_codsub = $fila['cod_subsector'];
$rut_alu = $fila['rut_alumno'];

				
				$_ql = "select * from matricula m where m.rut_alumno = $rut_alu  and m.id_ano = 1269; "; 
				$rs_ql = @pg_exec($conn1,$_ql);
					if( pg_numrows($rs_ql)==0 ){
						if($rut_alu!=$x){
							 $x =  $rut_alu;
							 echo $rut_alu."<br>"; 
						}
					 }
				
				$_ql = "select * from alumno as a where a.rut_alumno = $rut_alu;";
				$rs_ql = @pg_exec($conn1,$_ql);
					if( pg_numrows($rs_ql)==0 ){
						echo $rut_alu."=Alumno<br>"; 
					 }

	$sql2="select r.id_ramo,r.cod_subsector 
	from alumno a 
	inner join matricula m on m.rut_alumno = a.rut_alumno and m.id_ano = 1269
	inner join curso c on c.id_curso = m.id_curso
	--inner join tiene2011 t on t.id_curso = c.id_curso and t.rut_alumno = m.rut_alumno
    inner join ramo r on r.id_curso = c.id_curso
	inner join subsector s on s.cod_subsector = r.cod_subsector and s.cod_subsector = $_codsub
	where a.rut_alumno = $rut_alu ";
	$rs2 = pg_exec($conn1,$sql2) or die ("Error SELECT = $sql2 <br/>");
	
	if( pg_numrows($rs2)==0 ){

				
	    $sql_0 = " SELECT DISTINCT r.id_ramo,c.id_curso FROM curso c  
		inner join ramo r on r.id_curso = c.id_curso 
		inner join subsector s on s.cod_subsector = r.cod_subsector and s.cod_subsector = $_codsub 
		WHERE  	c.grado_curso = $_grado_curso  and c.letra_curso = '$_letra_curso'  
		and c.ensenanza = $_ensenanza  and c.id_ano = 1269; ";
		$rs22 = pg_exec($conn1,$sql_0) or die ("Error en SELECT = $sql_0 <br/>");
		
			if( pg_numrows($rs22)!=0 ){
	
				 $id_ramo = pg_result($rs22,0); 
				 $id_curso = pg_result($rs22,1); 
				 
				$sql_3 = "SELECT * FROM  public.tiene2011 WHERE rut_alumno = $rut_alu and id_ramo = $id_ramo and id_curso = $id_curso; "; 
				$rs3 = pg_exec($conn1,$sql_3) or die ("Error en SELECT = $sql_3 <br/>");
				
								if( pg_numrows($rs3)==0 ){			
								
								$insert_sql = "INSERT INTO public.tiene2011 (rut_alumno,id_ramo,id_curso) 
								VALUES ($rut_alu,$id_ramo,$id_curso);";
								$rs22 = pg_exec($conn1,$insert_sql) or die ("Error en SELECT = $insert_sql <br/>");
								
								}
				
				}else{
				
         				echo $sql_0."<br/>";
				
				}

		 
	 }else{ 
	  
	    $id_ramo = pg_result($rs2,0); 
	  
	  }
	  
	  
//2563=1621
//2564=1622

if($fila['id_periodo']==1621)$id_periodo = 2563;

if($fila['id_periodo']==1622)$id_periodo = 2564;

	 if($fila['notaap']==NULL){ 
	  $notaap = NULL; 
	 }else{ 
	  $notaap = $fila['notaap']; 
	 }

//echo $_ensenanza."=";

$sql_4 = "SELECT * FROM   public.notas2011 WHERE
rut_alumno = $rut_alu  and  id_ramo = $id_ramo  and  id_periodo = $id_periodo; ";

$rs4 = pg_exec($conn1,$sql_4) or die ("Error en SELECT = $sql_4 <br/>");

if( pg_numrows($rs4)==0 ){	

$insert = "INSERT INTO 
  public.notas2011
(
  rut_alumno,id_ramo,
  id_periodo,nota1,
  nota2,nota3,nota4,nota5,nota6,
  nota7,nota8,nota9,nota10,nota11,
  nota12,nota13,nota14,nota15,nota16,
  nota17,nota18,nota19,nota20,promedio,notaap
) 
VALUES (
  ".$rut_alu.",
  ".$id_ramo.",
  ".$id_periodo.",
  '".$fila['nota1']."',
  '".$fila['nota2']."',
  '".$fila['nota3']."',
  '".$fila['nota4']."',
  '".$fila['nota5']."',
  '".$fila['nota6']."',
  '".$fila['nota7']."',
  '".$fila['nota8']."',
  '".$fila['nota9']."',
  '".$fila['nota10']."',
  '".$fila['nota11']."',
  '".$fila['nota12']."',
  '".$fila['nota13']."',
  '".$fila['nota14']."',
  '".$fila['nota15']."',
  '".$fila['nota16']."',
  '".$fila['nota17']."',
  '".$fila['nota18']."',
  '".$fila['nota19']."',
  '".$fila['nota20']."',
  '".$fila['promedio']."',
  '".$notaap."' );";

//echo $insert."<br>";

$rs22 = pg_exec($conn1,$insert) or die("Error : ".$insert);

if($rs22) $i_i_i++;

   }


  }

echo "Registros".$i_i_i;

 
?>
