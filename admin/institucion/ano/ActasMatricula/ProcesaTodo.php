<style>
body {
	font-family: Verdana;
	font-size: 10px;
}
</style>
<?php require('../../../../util/header.inc');?>
<?php 


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	 $ano			=$_ANO;
	$_POSP = 4;
	$_bot = 9;
	$ano_ac=date("Y");
	
	 foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   } 
   
    foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   }
   	
	
	
	//// FUNCION QUE VALIDA EL RUT   ///////
	function validar_dav ($alumno,$dig_rut){	      
		 $alumno = $alumno;
		 $dig_rut = $dig_rut;		  
		 $largo_rut = strlen($alumno);
		 $multiplicador = 2;
		 $resultado = 0;
		 $largo=$largo_rut-1;			 
		 for ($i=0; $i < $largo_rut; $i++){
			 $num = substr($alumno,$largo,1);
			 
			 if ($multiplicador > 7){
				 $multiplicador = 2;
			 }
			 $resultado = $resultado + ($multiplicador * $num);			 
			 $multiplicador++; 
			 $largo--;		 
		 }				 
		 $resto = 11-($resultado%11);		 
		 
		 if ($resto==10){
			 $dig = "K";
		 }else{
		     if ($resto==11){
			     $dig = 0;
			 }else{	 
		         $dig = $resto;
			 }	 
		 }	 
		 
		 if ($dig_rut=="k"){
		     $dig_rut="K";   
		 } 
		 
		 if ($dig==$dig_rut){
			  $ok=1;  
		 }else{
			  $ok=0;
		 }	
		 return $ok;
		       	 
	}
	
//datos institucion
$sql1="select * from institucion where rdb= $institucion";
$res=pg_exec($conn,$sql1);	
$fil_cole=@pg_fetch_array($res,0);
$nom_inst=$fil_cole['nombre_instit'];
$rdb=$fil_cole['rdb'];
$dig_rdb=$fil_cole['dig_rdb'];


	
	//valido si hay algo en los horarios
$sql_corre="select * from tipo_ense_inst where rdb= $institucion";
//echo "<br>";
$res_corre=@pg_exec($conn,$sql_corre);
$tot_corre=pg_numrows($res_corre);

if($tot_corre==0)
echo "Instituci�n $nom_inst error: Tipos de ense�anza no registrados<br>";
else
{
	

	for ($p=0;$p<$tot_corre;$p++)
	{	
		
		$fil_corre=@pg_fetch_array($res_corre,$p);
		$corre=$fil_corre['corre'];
		$ense=$fil_corre['cod_tipo'];
		
		
		//valido si colegio tiene tipos de ense�anza
		$sql_ens="select cod_tipo from tipo_ensenanza where  cod_tipo=$ense";
		$res_ens=@pg_exec($conn,$sql_ens);
		$tot_tipo=pg_numrows($res_ens);
		if ($tot_tipo==0)
		echo "Instituci�n $nom_inst error: Tipos de ense�anza ($ense) no existente<br>";
		
		//consultar si tipo de ense�anza tiene horarios;
		$sql_jm="select * from hora_jm where corre=$corre";
		$res_jm=@pg_exec($conn,$sql_jm);
		$tot_hm=pg_numrows($res_jm);
		if ($tot_jm==0)
		{
		 // busco en jornada tarde
		 	$sql_jt="select * from hora_jt where corre=$corre";
			$res_jt=@pg_exec($conn,$sql_jt);
			$tot_ht=pg_numrows($res_jt);
			if ($tot_jt==0)
			{
			//busco en jornada completa
					
					$sql_mt="select * from hora_mt where corre=$corre";
					//echo "<br>";
					$res_mt=@pg_exec($conn,$sql_mt);
					$tot_mt=pg_numrows($res_mt);
					if ($tot_mt==0)
					{
					//busco en nocturna
						$sql_mt="select * from hora_vn where corre=$corre";
						//echo "<br>";
						$res_vn=@pg_exec($conn,$sql_vn);
						$tot_vn=pg_numrows($res_vn);
						if ($tot_vn==0)
						{
							echo "Instituci�n $nom_inst error: Horario de entrada y salida no registrado (ninguna jornada) <br>";						
						}
						else
						{
						
							$fil_vn=@pg_fetch_array($res_vn,0);
							if (strlen($fil_vn['hora_ini'])<1 or strlen($fil_vn['hora_ter'])<1)
							echo "Instituci�n $nom_inst error: Horario de entrada y/o salida no registrado (jornada vespertina)<br>";
				
						}
					
					}
					else
					{
					
						$fil_mt=@pg_fetch_array($res_mt,0);
						if (strlen($fil_mt['hora_ini'])<1 or strlen($fil_mt['hora_ter'])<1)
						echo "Instituci�n $nom_inst error: Horario de entrada y/o salida no registrado (jornada completa)<br>";
			
					}
				
				
			}
			else
			{
			
				$fil_jt=@pg_fetch_array($res_jt,0);
				if (strlen($fil_jt['hora_ini'])<1 or strlen($fil_jt['hora_ter'])<1)
				echo "Instituci�n $nom_inst error: Horario de entrada y/o salida no registrado (jornada tarde)<br>";
	
			}
		
		}
		else
		{
		
			$fil_jm=@pg_fetch_array($res_jm,0);
			if (strlen($fil_jm['hora_ini'])<1 or strlen($fil_jm['hora_ter'])<1)
			echo "Instituci�n $nom_inst error: Horario de entrada y/o salida no registrado (jornada ma�ana)<br>";

		}
		
		
		/* $sql_jt="";
		$sql_mt="";
		$sql_vn=""; */
	
	
	}


}




    //valido los rut
	  $sql_rut="SELECT * FROM alumno INNER JOIN matricula ON (alumno.rut_alumno = matricula.rut_alumno) where  matricula.id_ano =$ano";
	$res_rut=@pg_exec($conn,$sql_rut);
	$total_filas		= pg_numrows($res_rut);
	
	$contador=0;

		for ($i=0; $i < $total_filas; $i++){
			$fila2 = @pg_fetch_array($res_rut,$i);
			$rut_alumno = $fila2['rut_alumno'];
			$dig_rut    = $fila2['dig_rut'];
			
			$ok = validar_dav($rut_alumno,$dig_rut);		
			   
			if ($ok==1){
				$contador++;
				
			}
			if ($ok==0){
				$contador++;
				echo "rut alumno= $rut_alumno error: Rut no v�lido. Debe corregir la ficha del alumno<br>";
			}
		}	
		
	
	
	//valido los horarios
	
	//saco los demas datos del alumno  para validar
	$sql_alu="SELECT alumno.rut_alumno,alumno.sexo,alumno.nombre_alu,alumno.fecha_nac,alumno.region,alumno.ciudad,alumno.comuna,alumno.ape_pat,alumno.nombre_alu FROM alumno INNER JOIN matricula ON (alumno.rut_alumno = matricula.rut_alumno) where matricula.id_ano =$ano";
	$res_alu=@pg_exec($conn,$sql_alu);
	
	for($j=0;$j<pg_numrows($res_alu);$j++)
	{
		$fil_alu=@pg_fetch_array($res_alu,$j);
		$r_alu=$fil_alu['rut_alumno'];
		
		//valido fecha de nacimiento (ano que sea mayor a 1950 y menor a a�o actual)
		$sql_fec="select date_part ('year', fecha_nac) as anio from alumno where rut_alumno=$r_alu";
		$res_fec=@pg_exec($conn,$sql_fec);
		for ($k=0;$k<pg_numrows($res_fec);$k++)
		{
			$fil_fec=@pg_fetch_array($res_fec,$k);
			$fec=$fil_fec['anio'];
			
			if ($fec<1950 || $fec>$ano_ac)
			echo "rut alumno $r_alu : A�o de Nacimiento Inv�lido ($fec), rango 1950 - $ano_ac<br>";				
			
		}
		$fil_alu['sexo'];
		//valido sexo (que tenga)
		if ($fil_alu['sexo']<1 or $fil_alu['sexo']>2)
		echo "rut alumno $r_alu : Sexo no especificado<br>";
			
		if (strlen($fil_alu['ape_pat'])<1 or strlen($fil_alu['nombre_alu'])<1)
		echo "rut alumno $r_alu : Apellido Paterno o Nombre No especificado<br>";
		
			
		 	$sql_reg="select cod_reg from region where cod_reg=". $fil_alu['region'];
			//echo "<br>"; echo
			 $res_reg=@pg_exec($conn,$sql_reg);
			 $total_reg=pg_numrows($res_reg);
			 
			 if ($total_reg==0)
			echo "rut alumno $r_alu : error: Regi�n no existente. Debe corregir la ficha del alumno<br>";
			
			//busco ciudad
			  $sql_ciu="select cor_pro from provincia where cod_reg=". $fil_alu['region']."and cor_pro=".$fil_alu['ciudad'];
			//echo "<br>";echo
			 $res_ciu=@pg_exec($conn,$sql_ciu);
			 $total_ciu=pg_numrows($res_ciu);
			 
			 if ($total_ciu==0)
			echo "rut alumno $r_alu : error: Ciudad no existente. Debe corregir la ficha del alumno<br>";
			
			//busco comuna
		 $sql_com="select * from comuna where cod_reg=". $fil_alu['region']."and cor_pro=".$fil_alu['ciudad']." and cor_com=".$fil_alu['comuna'];
			//echo "<br>";
			 $res_com=@pg_exec($conn,$sql_com);
			 $total_com=pg_numrows($res_com);
			 
			 if ($total_com==0)
			echo "rut alumno $r_alu : error: Comuna no existente. Debe corregir la ficha del alumno<br>"; /* */
		
			
	} 
	
	
	
	
	
	
	
	//valido run profesor jefe
	$sql_prof="SELECT * FROM empleado INNER JOIN supervisa ON (empleado.rut_emp = supervisa.rut_emp) INNER JOIN curso ON (supervisa.id_curso = curso.id_curso) WHERE (curso.id_ano = $ano)"; 
	$res_prof=@pg_exec($conn,$sql_prof);
	$total_prof		= pg_numrows($res_prof);
	
	$contador=0;

		for ($l=0; $l < $total_filas; $l++){
			$fila2 = @pg_fetch_array($res_prof,$l);
			$rut_emp = $fila2['rut_emp'];
			$dig_rut    = $fila2['dig_rut'];
			
			$ok = validar_dav($rut_emp,$dig_rut);		
			   
			if ($ok==1){
				$contador++;
				
			}
			if ($ok==0){
				$contador++;
				echo "rut empleado= $rut_emp error<br>";
			}
		}	
	
	
	
	//valido especialidad
	$sql_es="SELECT cod_es, grado_curso,letra_curso,cod_sector,id_curso,region,ciudad,comuna FROM curso WHERE
  (curso.id_ano = $ano ) AND (curso.ensenanza > 400)";
  
  $res_es=@pg_exec($conn,$sql_es);
	$total_es		= pg_numrows($res_es);
	for($m=0;$m<$total_es;$m++)
	{
			$fil_cur=@pg_fetch_array($res_es,$m);
			if (strlen($fil_cur['cod_es'])<1 or $fil_cur['cod_es']==0)
			{
				echo $fil_cur['grado_curso']." - ".$fil_cur['letra_curso']." error: Especialidad no especificada<br>";
			}
			else
			{
				// ver si el codigo existe en la bd
			 $sql_esp="select cod_esp from especialidad where cod_esp=". $fil_cur['cod_es'];
			//echo "<br>";
			 $res_esp=@pg_exec($conn,$sql_esp);
			 $total_esp=pg_numrows($res_esp);
			 
			 if ($total_esp==0)
			 echo $fil_cur['grado_curso']." - ".$fil_cur['letra_curso']." error: Especialidad no existente<br>";
			}
				 
					
			
			
		//veo sector economico	
			
			if (strlen($fil_cur['cod_sector'])<1 or $fil_cur['cod_sector']==0)
			{
				echo $fil_cur['grado_curso']." - ".$fil_cur['letra_curso']." error: Sector econ�mico no especificado<br>";
			}
			else
			{
				// ver si el codigo existe en la bd
			 $sql_sec="select cod_sector from sector_eco where cod_sector=". $fil_cur['cod_sector'];
			//echo "<br>";
			 $res_sec=@pg_exec($conn,$sql_sec);
			 $total_sec=pg_numrows($res_sec);
			 
			 if ($total_sec==0)
			 echo $fil_cur['grado_curso']." - ".$fil_cur['letra_curso']." error: Sector econ�mico no existente<br>";
			}
			
			// busco region
			
	}




 ?>