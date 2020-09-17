
<?
//$conn = @pg_connect("dbname=coi_usuario host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 1");

$conn_final = @pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 2");

$conn_vina = @pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 3");


//$conn_final = @pg_connect("dbname=coi_antofagasta host=200.29.70.184  port=5432 user=postgres password=anto2010") or die ("No pude conectar a la base de datos destino");






/************* TRASPASO INSTITUCION DE LA COI FINAL *************************/
 /*$sql =" select * from institucion where rdb=1598";
$rs_final = pg_exec($conn_final,$sql);

for($i=0;$i<@pg_numrows($rs_final);$i++){
	$fila = @pg_fetch_array($rs_final,$i);
	
	
	
	if(pg_numrows($rs_final)!=0){
	 $sql ="INSERT INTO institucion 
	 (rdb, dig_rdb, nombre_instit,calle,nro,depto,block,villa,region,ciudad,comuna,telefono,fax,email,tipo_instit,tipo_educ,tipo_regimen,idioma,sexo,metodo,
	 formacion,carta_direccion,proyecto_educativo,reglamento_interno,nuestra_institucion,proceso_admision,uniforme,insignia,mapa,contacto,img_proyecto,img_uniforme,
	 bool_pae,bool_ca,bool_cp,bool_ws,bool_cpa,bool_ex,emailcp,repcp,emailca,repca,emailws,repws,emailcpa,repcpa,emailex,repex,plan,nu_resolucion,numero_inst,
	 num_res_ro,fecha_resolucion,letra_inst,fecha_res_ro,dependencia,area_geo,info_colegio,estado_colegio,matricula_inicial,proceso_promocion,reglamento,
	 run,dig_run,proyecto,saemovil,cede,manual_convivencia,modo_instit) 
	 VALUES 
	 (".$fila[0].",'".$fila[1]."','".$fila[2]."',".$fila[3].",'".$fila[4]."',".$fila[5].",".$fila[6].",'".$fila[7]."',".$fila[8].",".$fila[9]."
	 ,".$fila[10].",'".$fila[11]."','".$fila[12]."','".$fila[13]."',".$fila[14].",".$fila[15].",".$fila[16].",".$fila[17].",".$fila[18].",".$fila[19]."
	 ,".$fila[20].",'".$fila[21]."','".$fila[22]."','".$fila[23]."','".$fila[24]."','".$fila[25]."','".$fila[26]."','".$fila[27]."',,'".$fila[28]."',
	 '".$fila[9]."','".$fila[30]."','".$fila[31]."',".$fila[32].",".$fila[33].",".$fila[34].",".$fila[35].",".$fila[36].",".$fila[37].",".$fila[38]."
	 ,'".$fila[39]."','".$fila[40]."','".$fila[41]."','".$fila[42]."','".$fila[43]."','".$fila[44]."','".$fila[45]."','".$fila[46]."','".$fila[47]."'
	 ,'".$fila[48]."',".$fila[49].",".$fila[50].",".$fila[51].",'".$fila[52]."','".$fila[53]."','".$fila[54]."',".$fila[55].",'".$fila[56]."','".$fila[57]."'
	 ,".$fila[58].",".$fila[59].",".$fila[60].",'".$fila[61]."','".$fila[62]."','".$fila[63]."','".$fila[64]."',".$fila[65].",".$fila[66].",'".$fila[67]."'
	 ,".$fila[68].")";
		//$rs_usuario = @pg_exec($conn_vina,$sql);	
	}
}*/

/**********************************************************************************************************************************/

/**********************AÑOS ACADEMICOS************************************************************************************************************/

/*$sql_ano_escolar="select * from ano_escolar where id_institucion=1598";
	$rs_ano_es = @pg_exec($conn_final,$sql_ano_escolar);	
	$id_ano_ante=0;
	for($i=0;$i<pg_numrows($rs_ano_es);$i++){
		
		$fila_ano=pg_fetch_array($rs_ano_es,$i);
		
		echo "<PRE>";
	    print_r($fila_ano);
	    echo "</PRE>";
		 "<br>"."--->I = ".$i."<br>";
		if($i==0){
			$id_ano_ante=0;
			}else{
			$id_ano_ante=$id_ano_ante;		
		}
		if($fila_ano[8]==""){
			$fila_ano[8]="00:00:00";
			}
		if(pg_numrows($rs_final)!=0){
			
			$sql_ins_ano="insert into ano_escolar (nro_ano,fecha_inicio,fecha_termino,situacion,id_institucion,ano_anterior,tipo_regimen,hora_entrada)
			VALUES
			(".$fila_ano[1].",'".$fila_ano[2]."','".$fila_ano[3]."',".$fila_ano[4].",".$fila_ano[5].",".$id_ano_ante.",".$fila_ano[7].",'".$fila_ano[8]."')";
			//$rs_ins_ano = @pg_exec($conn_vina,$sql_ins_ano)or die("fallo ".$sql_ins_ano);	
			
			
			$sql_id_ante="SELECT id_ano FROM ano_escolar ORDER BY id_ano DESC LIMIT 1";
			$rs_id_ante=pg_exec($conn_vina,$sql_id_ante);
			 $id_ano_ante=pg_result($rs_id_ante,0);
			
			}
	}
*/
/******************************periodos****************************************************************************************************/

			


	     /*   $sql_ano="SELECT * FROM ano_escolar WHERE id_institucion=1598 ORDER BY id_ano ASC";
			$rs_ano=pg_exec($conn_final,$sql_ano);
			
			for($i=0;$i<pg_numrows($rs_ano);$i++){
				$fila=pg_fetch_array($rs_ano,$i);
				
				
			"<br>".$sql_id_ano_vina="select id_ano,nro_ano from ano_escolar where nro_ano=".$fila['nro_ano']." and id_institucion=1598";
				$rs_ano_vina=pg_exec($conn_vina,$sql_id_ano_vina);
				
				for($e=0;$e<pg_numrows($rs_ano_vina);$e++){
					$fila_ano_vina=pg_fetch_array($rs_ano_vina,0);
					echo "<PRE>";
				    print_r($fila_ano_vina);
				    echo "</PRE>";	
					}
				

				$sql_per="select * from periodo where id_ano=".$fila['id_ano']." ";
				$rs_per=pg_exec($conn_final,$sql_per);
				for($x=0;$x<pg_numrows($rs_per);$x++){
				
				$fila_per=pg_fetch_array($rs_per,$x);
      			
				
				if($fila_per['fecha_inicio']==""){
					$fila_per['fecha_inicio']="".$fila_ano_vina['nro_ano']."-12-01";
					}
				
				if($fila_per['fecha_termino']==""){
					$fila_per['fecha_termino']="".$fila_ano_vina['nro_ano']."-01-01";
					}
				if($fila_per['mostrar_notas']==""){
					$fila_per['mostrar_notas']='0';
					}	
				if($fila_per['dias_habiles']==""){
					$fila_per['dias_habiles']='0';
					}	
				if($fila_per['cerrado']==""){
					$fila_per['cerrado']='0';
					}	
				if($fila_per['ing_notas']==""){
					$fila_per['ing_notas']='0';
					}		
				
	$sql_insert_per="insert into periodo (nombre_periodo,fecha_inicio,fecha_termino,id_ano,mostrar_notas,dias_habiles,cerrado,ing_notas)
	VALUES
	('".trim($fila_per['nombre_periodo'])."','".$fila_per['fecha_inicio']."','".$fila_per['fecha_termino']."',".$fila_ano_vina['id_ano'].",".$fila_per['cerrado'].",".$fila_per['dias_habiles'].",".$fila_per['ing_notas'].",
					 ".$fila_per['ing_notas'].")";
				$rs_ins_per=pg_exec($conn_vina,$sql_insert_per)or die("fallo ".$sql_insert_per);
				echo "<PRE>";
				echo $sql_insert_per;
				echo "</PRE>";	
				
					}
			}
			*/
			
/************************plan de estudios*******************************************************************************************************/

	/*$sql="select * from plan_inst where rdb=1598";
	$rs_plan=pg_exec($conn_final,$sql);
	
	for($i=0;$i<pg_numrows($rs_plan);$i++){
		
		$fila=pg_fetch_array($rs_plan,$i);
		
		
		echo $sql_ins="insert into plan_inst (rdb,cod_decreto)VALUES(".$fila[0].",".$fila[1].")";
		$rs_ins=pg_exec($conn_vina,$sql_ins)or die("fallo ".$sql_ins);
		echo "<pre>";
		print_r($fila);		
		echo "</pre>";
	}*/
/*********************************TIPO ENSE INST****************************************************************************************************************/



/*$sql="select * from tipo_ense_inst where rdb=1598";
$rs=pg_exec($conn_final,$sql);

for ($i=0;$i<pg_numrows($rs);$i++){
	
	$fila=pg_fetch_array($rs,$i);
	
	echo"<pre>";
	print_r($fila);
	echo"</pre>";
}*/
/***************CURSO*************************************************************************************************************/

	/*$sql_ano="SELECT * FROM ano_escolar WHERE id_institucion=1598 ORDER BY id_ano ASC";
			$rs_ano=pg_exec($conn_final,$sql_ano);
			
			for($i=0;$i<pg_numrows($rs_ano);$i++){
				$fila=pg_fetch_array($rs_ano,$i);
				
				
			"<br>".$sql_id_ano_vina="select id_ano,nro_ano from ano_escolar where nro_ano=".$fila['nro_ano']." and id_institucion=1598 ORDER BY id_ano ASC";
				$rs_ano_vina=pg_exec($conn_vina,$sql_id_ano_vina);
				
				for($e=0;$e<pg_numrows($rs_ano_vina);$e++){
					$fila_ano_vina=pg_fetch_array($rs_ano_vina,0);
					echo "<PRE>";
				    print_r($fila_ano_vina);
				    echo "</PRE>";	
				}
				
				
				$sql_curso="select id_curso from curso where id_ano=".$fila[0]."";
				$rs_curso=pg_exec($conn_final,$sql_curso);
				for($x=0;$x<pg_numrows($rs_curso);$x++){
					
					$fila_c=pg_fetch_array($rs_curso,$x);
					echo "<PRE>";
					print_r($fila_c);
					echo "</PRE>";
					*/
				
				
				/*if($fila_c['total_horas_1']==""){
					$fila_c['total_horas_1'] = 0;
					}
				if($fila_c['total_horas_2']==""){
					$fila_c['total_horas_2']=0;
					}	
				if($fila_c['total_horas_3']==""){
					$fila_c['total_horas_3']=0;
					}	
				if($fila_c['observaciones']==""){
					$fila_c['observaciones']=0;
					}	
				if($fila_c['vacantes']==""){
					$fila_c['vacantes']=0;
					}
				if($fila_c['nivel_grado']==""){
					$fila_c['nivel_grado']=0;
					}	
				if($fila_c['bloq_ramos']==""){
					$fila_c['bloq_ramos']=0;
					}		
				if($fila_c['bloq_nota']==""){
					$fila_c['bloq_nota']=0;
					}	
				if($fila_c['bool_jor']==""){
					$fila_c['bool_jor']=0;
					}	
				if($fila_c['truncado_per']==""){
					$fila_c['truncado_per']=0;
					}
				if($fila_c['simce']==""){
					$fila_c['simce']=0;
					}
				if($fila_c['acta']==""){
					$fila_c['acta']=0;
					}	
				if($fila_c['truncado_final']==""){
					$fila_c['truncado_final']=0;
					}
				if($fila_c['truncado_sf']==""){
					$fila_c['truncado_sf']=0;
					}			
				if($fila_c['val_sub']==""){
					$fila_c['val_sub']=0;
					}
				if($fila_c['id_nivel']==""){
					$fila_c['id_nivel']=0;
					}	
					*/
					
					
					
					
	/*echo	$sql_max_id="select max(id_curso) as id_curso from curso";
				$rs_max_id=pg_exec($conn_vina,$sql_max_id);
			echo"<BR>"."MAX ID--->".$max_id=pg_result($rs_max_id,0);	
			echo "MAX ID+1--->".$id_max=$max_id+1;					
					
$sql_ins_curso="insert into curso (id_curso,
				grado_curso,
				letra_curso,
				ensenanza,
				cod_decreto,
				cod_eval,
				id_ano,
				cod_es,
				cod_sector,
				cod_rama,
				bool_jor,
				truncado_per,
				simce,
				acta,
				observaciones,
				val_sub,
				truncado_final,
				truncado_sf,
				total_horas_2,
				total_horas_1,
				total_horas_3,
				cap_curso,
				vacantes,
				nivel_grado,
				id_nivel,
				bloq_nota,
				bloq_ramos)
			VALUES
				(".$id_max.",".$fila_c['grado_curso'].",'".trim($fila_c['letra_curso'])."',".$fila_c['ensenanza'].",".$fila_c['cod_decreto']."
				,".$fila_c['cod_eval'].",".$fila_ano_vina['id_ano'].",".$fila_c['cod_es'].",".$fila_c['cod_sector'].",".$fila_c['cod_rama'].",".$fila_c['bool_jor']."
				,".$fila_c['truncado_per'].",".$fila_c['simce'].",".$fila_c['acta'].",".$fila_c['observaciones'].",'".$fila_c['val_sub']."',".$fila_c['truncado_final']."
				,".$fila_c['truncado_sf'].",".$fila_c['total_horas_2'].",".$fila_c['total_horas_1'].",".$fila_c['total_horas_3'].",".$fila_c['cap_curso']."
				,".$fila_c['vacantes'].",'".$fila_c['nivel_grado']."',".$fila_c['id_nivel'].",".$fila_c['bloq_nota'].",".$fila_c['bloq_ramos'].")";	
				echo"<pre>";
				echo $sql_ins_curso;
				echo"</pre>";*/
				
				
				//$rs_ins_curso=pg_exec($conn_vina,$sql_ins_curso)or die("fallo ".$sql_ins_curso);
				//unset($id_max);
	
	
		/*	$sql_curso_v="select id_curso from curso where id_ano=".$fila_ano_vina[0]."";
			$rs_curso_v=pg_exec($conn_vina,$sql_curso_v)or die("fallo CURSO   ");
			for($z=0;$z<pg_numrows($rs_curso_v);$z++){
				
				$fila_curso_v=pg_fetch_array($rs_curso_v,$z);
				echo"<pre>";
				print_r($fila_curso_v);
				echo"</pre>";
				
	          }*/
						
			
	
			
			
				
				
	
	//}
	
	

//}
/**********************************ramo************************************************************************************/
/*$sql_ano="SELECT * FROM ano_escolar WHERE id_institucion=1598 ORDER BY id_ano ASC";
$rs_ano=pg_exec($conn_final,$sql_ano);
			
for($i=0;$i<pg_numrows($rs_ano);$i++){
	$fila=pg_fetch_array($rs_ano,$i);
	
	$sql_id_ano_vina="select id_ano,nro_ano from ano_escolar where nro_ano=".$fila['nro_ano']." and id_institucion=1598 ORDER BY id_ano ASC";
	$rs_ano_vina=pg_exec($conn_vina,$sql_id_ano_vina);
	$id_ano_vina=pg_result($rs_ano_vina,0);

	$sql_curso="select id_curso, ensenanza,grado_curso,letra_curso from curso where id_ano=".$fila[0]."";
	$rs_curso=pg_exec($conn_final,$sql_curso);
	for($x=0;$x<pg_numrows($rs_curso);$x++){
		$fila_c=pg_fetch_array($rs_curso,$x);
		echo "<PRE>";
		//print_r($fila_c);
		echo "</PRE>";	

		$sql_curso_v="select id_curso from curso where id_ano=".$id_ano_vina." and ensenanza=".$fila_c['ensenanza']." 
		and grado_curso=".$fila_c['grado_curso']." and letra_curso='".$fila_c['letra_curso']."'";
		$rs_curso_v=pg_exec($conn_vina,$sql_curso_v)or die("fallo CURSO ");
		echo"id_curso_vina ->".$id_curso_v=pg_result($rs_curso_v,0);
	
		
	
		echo $sql_sup="select * from ramo where id_curso = ".$fila_c['id_curso']."";
		$rs_sup=pg_exec($conn_final,$sql_sup)or die("Fallooooo ");
		
		for($b=0;$b < pg_numrows($rs_sup);$b++){
			$fila_ramo=pg_fetch_array($rs_sup,$b);
			echo"<pre>";
			print_r($fila_ramo);
			echo"</pre>";
			
			$fila_ramo['material']= 'NULL';
			
			if($fila_ramo['modo_eval']==""){
				$fila_ramo['modo_eval']=0;
			}			
			if($fila_ramo['tipo_ramo']==""){
				$fila_ramo['tipo_ramo']=0;
			}
			if($fila_ramo['horas']==""){
				$fila_ramo['horas']=0;
			}		
			if($fila_ramo['sub_obli']==""){
				$fila_ramo['sub_obli']=0;
			}
			if($fila_ramo['sub_elect']==""){
				$fila_ramo['sub_elect']=0;
			}
			if($fila_ramo['bool_ip']==""){
				$fila_ramo['bool_ip']=0;
			}
			if($fila_ramo['bool_sar']==""){
				$fila_ramo['bool_sar']=0;
			}
			if($fila_ramo['conex']==""){
				$fila_ramo['conex']=0;
			}
			if($fila_ramo['pct_examen']==""){
				$fila_ramo['pct_examen']=0;
			}
			if($fila_ramo['nota_exim']==""){
				$fila_ramo['nota_exim']=0;
			}
			if($fila_ramo['truncado']==""){
				$fila_ramo['truncado']=0;
			}
			if($fila_ramo['id_orden']==""){
				$fila_ramo['id_orden']=0;
			}
			if($fila_ramo['truncado_per']==""){
				$fila_ramo['truncado_per']=0;
			}
			if($fila_ramo['prueba_nivel']==""){
				$fila_ramo['prueba_nivel']=0;
			}
			if($fila_ramo['pct_nivel']==""){
				$fila_ramo['pct_nivel']=0;
			}
			if($fila_ramo['modo_eval_pnivel']==""){
				$fila_ramo['modo_eval_pnivel']=0;
			}
			if($fila_ramo['pct_ex_escrito']==""){
				$fila_ramo['pct_ex_escrito']=0;
			}
			if($fila_ramo['pct_ex_oral']==""){
				$fila_ramo['pct_ex_oral']=0;
			}
			if($fila_ramo['id_padre']==""){
				$fila_ramo['id_padre']=0;
			}
			if($fila_ramo['nombre_hijo']==""){
				$fila_ramo['nombre_hijo']='-';
			}
			if($fila_ramo['porcentaje']==""){
				$fila_ramo['porcentaje']=0;
			}
			if($fila_ramo['truncado_pnivel']==""){
				$fila_ramo['truncado_pnivel']=0;
			}
			if($fila_ramo['eee']==""){
				$fila_ramo['eee']=0;
			}
			if($fila_ramo['bool_artis']==""){
				$fila_ramo['bool_artis']=0;
			}
			if($fila_ramo['porc_examen']==""){
				$fila_ramo['porc_examen']=0;
			}
			if($fila_ramo['aprox_entero']==""){
				$fila_ramo['aprox_entero']=0;
			}
			if($fila_ramo['hrs_jec']==""){
				$fila_ramo['hrs_jec']=0;
			}
			if($fila_ramo['hrs_plan']==""){
				$fila_ramo['hrs_plan']=0;
			}
			if($fila_ramo['apreciacion']==""){
				$fila_ramo['apreciacion']=0;
			}
			if($fila_ramo['minima1']==""){
				$fila_ramo['minima1']=0;
			}
			if($fila_ramo['maxima1']==""){
				$fila_ramo['maxima1']=0;
			}
			if($fila_ramo['bonifica1']==""){
				$fila_ramo['bonifica1']=0;
			}
			if($fila_ramo['minima2']==""){
				$fila_ramo['minima2']=0;
			}
			if($fila_ramo['maxima2']==""){
				$fila_ramo['maxima2']=0;
			}
			if($fila_ramo['bonifica2']==""){
				$fila_ramo['bonifica2']=0;
			}
			if($fila_ramo['minima3']==""){
				$fila_ramo['minima3']=0;
			}
			if($fila_ramo['maxima3']==""){
				$fila_ramo['maxima3']=0;
			}
			if($fila_ramo['bonifica3']==""){
				$fila_ramo['bonifica3']=0;
			}
			if($fila_ramo['formacion']==""){
				$fila_ramo['formacion']=0;
			}
			if($fila_ramo['minima4']==""){
				$fila_ramo['minima4']=0;
			}
			if($fila_ramo['maxima4']==""){
				$fila_ramo['maxima4']=0;
			}
			if($fila_ramo['bonifica4']==""){
				$fila_ramo['bonifica4']=0;
			}
			if($fila_ramo['tipo_aproximacion']==""){
				$fila_ramo['tipo_aproximacion']=0;
			}
			if($fila_ramo['aplica_aproximacion']==""){
				$fila_ramo['aplica_aproximacion']=0;
			}
			if($fila_ramo['bool_bloq']==""){
				$fila_ramo['bool_bloq']=0;
			}
			if($fila_ramo['conexper']==""){
				$fila_ramo['conexper']=0;
			}
			if($fila_ramo['truncado_ex_semestral']==""){
				$fila_ramo['truncado_ex_semestral']=0;
			}
			if($fila_ramo['truncado_ex_final']==""){
				$fila_ramo['truncado_ex_final']=0;
			}
			if($fila_ramo['nota_ex_semestral']==""){
				$fila_ramo['nota_ex_semestral']=0;
			}
			if($fila_ramo['pct_ex_semestral']==""){
				$fila_ramo['pct_ex_semestral']=0;
			}
	
			$sql_ins_ramo="INSERT INTO  ramo(material,modo_eval,tipo_ramo,id_curso,cod_subsector,horas,sub_obli,sub_elect,bool_ip,bool_sar,
			conex,pct_examen,nota_exim,truncado,id_orden,truncado_per,prueba_nivel,pct_nivel,modo_eval_pnivel,pct_ex_escrito,
			pct_ex_oral,id_padre,nombre_hijo,porcentaje,truncado_pnivel,eee,bool_artis,porc_examen,aprox_entero,hrs_jec,hrs_plan,
			apreciacion,minima1,maxima1,bonifica1,minima2,maxima2,bonifica2,minima3,maxima3,bonifica3,formacion,minima4,maxima4,
			bonifica4,tipo_aproximacion,aplica_aproximacion,bool_bloq,conexper,truncado_ex_semestral,truncado_ex_final,nota_ex_semestral,
			pct_ex_semestral) 
			VALUES 
			(".$fila_ramo['material'].",".$fila_ramo['modo_eval'].",".$fila_ramo['tipo_ramo'].",".$id_curso_v.",".$fila_ramo['cod_subsector']."
			,".$fila_ramo['horas'].",".$fila_ramo['sub_obli'].",".$fila_ramo['sub_elect'].",".$fila_ramo['bool_ip'].",".$fila_ramo['bool_sar']."
			,".$fila_ramo['conex'].",".$fila_ramo['pct_examen'].",".$fila_ramo['nota_exim'].",".$fila_ramo['truncado'].",".$fila_ramo['id_orden']."
			,".$fila_ramo['truncado_per'].",".$fila_ramo['prueba_nivel'].",".$fila_ramo['pct_nivel'].",".$fila_ramo['modo_eval_pnivel']."
			,".$fila_ramo['pct_ex_escrito'].",".$fila_ramo['pct_ex_oral'].",".$fila_ramo['id_padre'].",'".$fila_ramo['nombre_hijo']."',".$fila_ramo['porcentaje']."
			,".$fila_ramo['truncado_pnivel'].",".$fila_ramo['eee'].",".$fila_ramo['bool_artis'].",".$fila_ramo['porc_examen'].",".$fila_ramo['aprox_entero']."
			,".$fila_ramo['hrs_jec'].",".$fila_ramo['hrs_plan'].",".$fila_ramo['apreciacion'].",".$fila_ramo['minima1'].",".$fila_ramo['maxima1'].",".$fila_ramo['bonifica1']."
			,".$fila_ramo['minima2'].",".$fila_ramo['maxima2'].",".$fila_ramo['bonifica2'].",".$fila_ramo['minima3'].",".$fila_ramo['maxima3'].",".$fila_ramo['bonifica3']."
			,".$fila_ramo['formacion'].",".$fila_ramo['minima4'].",".$fila_ramo['maxima4'].",".$fila_ramo['bonifica4'].",".$fila_ramo['tipo_aproximacion']."
			,".$fila_ramo['aplica_aproximacion'].",".$fila_ramo['bool_bloq'].",".$fila_ramo['conexper'].",".$fila_ramo['truncado_ex_semestral']."
			,".$fila_ramo['truncado_ex_final'].",".$fila_ramo['nota_ex_semestral'].",".$fila_ramo['pct_ex_semestral'].")";
			
			echo"<pre>";
			echo $sql_ins_ramo;
			echo"</pre>";
			
			//$rs_insert_ramo=pg_exec($conn_vina,$sql_ins_ramo)or die("Fallo Ramo ".$sql_ins_ramo);
		}

	}
}*/
/***********************************DICTA**************************************************************************************************************/


/*	$sql_ano="SELECT * FROM ano_escolar WHERE id_institucion=1598 ORDER BY id_ano ASC";
$rs_ano=pg_exec($conn_final,$sql_ano);
			
for($i=0;$i<pg_numrows($rs_ano);$i++){
	$fila=pg_fetch_array($rs_ano,$i);
	
	$sql_id_ano_vina="select id_ano,nro_ano from ano_escolar where nro_ano=".$fila['nro_ano']." and id_institucion=1598 ORDER BY id_ano ASC";
	$rs_ano_vina=pg_exec($conn_vina,$sql_id_ano_vina);
	$id_ano_vina=pg_result($rs_ano_vina,0);
	
	
	
	$sql_curso="select id_curso, ensenanza,grado_curso,letra_curso from curso where id_ano=".$fila[0]."";
	$rs_curso=pg_exec($conn_final,$sql_curso);
	for($x=0;$x<pg_numrows($rs_curso);$x++){
		$fila_c=pg_fetch_array($rs_curso,$x);
		echo "<PRE>";
		//print_r($fila_c);
		echo "</PRE>";	

		$sql_curso_v="select id_curso from curso where id_ano=".$id_ano_vina." and ensenanza=".$fila_c['ensenanza']." 
		and grado_curso=".$fila_c['grado_curso']." and letra_curso='".$fila_c['letra_curso']."'";
		$rs_curso_v=pg_exec($conn_vina,$sql_curso_v)or die("fallo CURSO ");
		"id_curso_vina ->".$id_curso_v=pg_result($rs_curso_v,0);
		
		
	
		 $sql_sup="select di.* from ramo ra
						inner join dicta di on ra.id_ramo=di.id_ramo
						where ra.id_curso= ".$fila_c['id_curso']."";
		$rs_sup=pg_exec($conn_final,$sql_sup)or die("Fallooooo ");
		
		for($b=0;$b < pg_numrows($rs_sup);$b++){
			$fila_ramo=pg_fetch_array($rs_sup,$b);
			echo"<pre>";
			//print_r($fila_ramo);
			echo"</pre>";
			
			
		echo $sql_ramo_v="select id_ramo from ramo where id_curso=$id_curso_v";
		$rs_ramo_v=pg_exec($conn_vina,$sql_ramo_v)or die("Fallo ".$sql_ramo_v);
		
		for($a=0;$a < pg_numrows($rs_ramo_v);$a++){
		$fila_ramo_v=pg_fetch_array($rs_ramo_v,$a);
			echo"<pre>";
			print_r($fila_ramo_v);
			echo"</pre>";
			
			
		$sql_ins_dicta="insert into dicta (rut_emp,id_ramo)values(".$fila_ramo['rut_emp'].",".$fila_ramo_v[0].")";	
		echo"<pre>";
			echo($sql_ins_dicta);
			echo"</pre>";
	
			
	//$rs_ins_dic=pg_exec($conn_vina,$sql_ins_dicta);
	
		  }
		}
    }
}*/
/***********************************************************************************************************************************************/

	
	/*$sql_ano="SELECT * FROM ano_escolar WHERE id_institucion=1598 ORDER BY id_ano ASC";
$rs_ano=pg_exec($conn_final,$sql_ano);
			
for($i=0;$i<pg_numrows($rs_ano);$i++){
	$fila=pg_fetch_array($rs_ano,$i);
	$nro_ano_final=$fila['nro_ano'];
	$sql_id_ano_vina="select id_ano,nro_ano from ano_escolar where nro_ano=".$fila['nro_ano']." and id_institucion=1598 ORDER BY id_ano ASC";
	$rs_ano_vina=pg_exec($conn_vina,$sql_id_ano_vina);
	$id_ano_vina=pg_result($rs_ano_vina,0);
	
	
	
	$sql_curso="select id_curso, ensenanza,grado_curso,letra_curso from curso where id_ano=".$fila[0]."";
	$rs_curso=pg_exec($conn_final,$sql_curso);
	for($x=0;$x<pg_numrows($rs_curso);$x++){
		$fila_c=pg_fetch_array($rs_curso,$x);
		echo "<PRE>";
		//print_r($fila_c);
		echo "</PRE>";	

		$sql_curso_v="select id_curso from curso where id_ano=".$id_ano_vina." and ensenanza=".$fila_c['ensenanza']." 
		and grado_curso=".$fila_c['grado_curso']." and letra_curso='".$fila_c['letra_curso']."'";
		$rs_curso_v=pg_exec($conn_vina,$sql_curso_v)or die("fallo CURSO ");
		"id_curso_vina ->".$id_curso_v=pg_result($rs_curso_v,0);
		
		
		
	
		  $sql_tiene="select ti.rut_alumno,ti.id_ramo,ra.cod_subsector from ramo ra
						inner join tiene$nro_ano_final ti on ti.id_curso=ra.id_curso and ra.id_ramo=ti.id_ramo  
						where ra.id_curso= ".$fila_c['id_curso']."";

		//$sql_tiene ="SELECT id_ramo, cod_subsector from ramo where id_curso=".$fila_c['id_curso'];
		$rs_tiene=pg_exec($conn_final,$sql_tiene)or die("Fallooooo ".$sql_tiene);
		
		for($b=0;$b < pg_numrows($rs_tiene);$b++){
			$fila_tiene=pg_fetch_array($rs_tiene,$b);
			echo"<pre>";
			print_r($fila_tiene);
			echo"</pre>";
			
			
		echo $sql_notas_final="select * from notas$nro_ano_final where rut_alumno=".$fila_tiene['rut_alumno']." and id_ramo=".$fila_tiene['id_ramo']." ";
			$rs_not=pg_exec($conn_final,$sql_notas_final);
				for($r=0;$r < pg_numrows($rs_not);$r++){
					$fila_not=pg_fetch_array($rs_not,$r);
					echo"<pre>";
					print_r($fila_not);
					echo"</pre>";
					}
					
		
			
			
		 $sql_ramo_v="select id_ramo from ramo where id_curso=$id_curso_v and cod_subsector=".$fila_tiene['cod_subsector']."";
		$rs_ramo_v=pg_exec($conn_vina,$sql_ramo_v)or die("Fallo ".$sql_ramo_v);
		
		for($a=0;$a < pg_numrows($rs_ramo_v);$a++){
		$fila_ramo_v=pg_fetch_array($rs_ramo_v,$a);
			echo"<pre>";
		//	print_r($fila_ramo_v);
			echo"</pre>";
			
		
		$sql_per="select * from periodo where id_ano=$id_ano_vina order by id_periodo asc";
		$rs_per=pg_exec($conn_vina,$sql_per)or die("fallo per ".$sql_per);
		for($p=0;$p < pg_numrows($rs_per);$p++){
			
			$fila_per=pg_fetch_array($rs_per,$p);
			echo"<pre>";
			print_r($fila_per);
			echo"</pre>";
			
				
				if(trim($fila_not['promedio'])==""){
					$fila_not['promedio']="0";
				}
				
				if(trim($fila_not['notaap'])==""){
					$fila_not['notaap']="NULL";
				}
			
		$sql_ins_notas="insert into notas$nro_ano_final (rut_alumno,id_ramo,id_periodo,nota1,nota2,nota3,nota4,nota5,nota6,nota7,nota8,nota9,nota10,nota11
		,nota12,nota13,nota14,nota15,nota16,nota17,nota18,nota19,nota20,promedio,notaap)
		values
		(".$fila_tiene['rut_alumno'].",".$fila_ramo_v['id_ramo'].",".$fila_per['id_periodo'].",'".trim($fila_not['nota1'])."','".trim($fila_not['nota2'])."','".trim($fila_not['nota3'])."'
		,'".trim($fila_not['nota4'])."','".trim($fila_not['nota5'])."','".trim($fila_not['nota6'])."','".trim($fila_not['nota7'])."','".trim($fila_not['nota8'])."'
		,'".trim($fila_not['nota9'])."','".trim($fila_not['nota10'])."','".trim($fila_not['nota11'])."','".trim($fila_not['nota12'])."','".trim($fila_not['nota13'])."'
		,'".trim($fila_not['nota14'])."','".trim($fila_not['nota15'])."','".trim($fila_not['nota16'])."','".trim($fila_not['nota17'])."','".trim($fila_not['nota18'])."'
		,'".trim($fila_not['nota19'])."','".trim($fila_not['nota20'])."','".trim($fila_not['promedio'])."',".trim($fila_not['notaap']).")";	
		echo"<pre>";
		echo($sql_ins_notas);
		echo"</pre>";
	
			
	//  $rs_ins_dic=pg_exec($conn_vina,$sql_ins_notas); 
	//pg_last_error($sql_ins_tiene);
	
			}
		  }
		}
    }
}*/

/********************ASISTENCIA**********************************************************************************/

/*
$sql_ano="SELECT * FROM ano_escolar WHERE id_institucion=1598 ORDER BY id_ano ASC";
$rs_ano=pg_exec($conn_final,$sql_ano);
			
for($i=0;$i<pg_numrows($rs_ano);$i++){
	$fila=pg_fetch_array($rs_ano,$i);
	$nro_ano_final=$fila['nro_ano'];
	
	$sql_id_ano_vina="select id_ano,nro_ano from ano_escolar where nro_ano=".$fila['nro_ano']." and id_institucion=1598 ORDER BY id_ano ASC";
	$rs_ano_vina=pg_exec($conn_vina,$sql_id_ano_vina);
	$id_ano_vina=pg_result($rs_ano_vina,0);
	
	
	
	$sql_curso="select id_curso, ensenanza,grado_curso,letra_curso from curso where id_ano=".$fila[0]."";
	$rs_curso=pg_exec($conn_final,$sql_curso);
	for($x=0;$x<pg_numrows($rs_curso);$x++){
		$fila_c=pg_fetch_array($rs_curso,$x);
		echo "<PRE>";
		print_r($fila_c);
		echo "</PRE>";	
		

		$sql_curso_v="select id_curso from curso where id_ano=".$id_ano_vina." and ensenanza=".$fila_c['ensenanza']." 
		and grado_curso=".$fila_c['grado_curso']." and letra_curso='".$fila_c['letra_curso']."'";
		$rs_curso_v=pg_exec($conn_vina,$sql_curso_v)or die("fallo CURSO ");
		echo"id_curso_vina ->".$id_curso_v=pg_result($rs_curso_v,0);
		
				
		echo $sql_asis="select * from asistencia where ano=".$fila[0]." and id_curso=".$fila_c['id_curso']."";
		$rs_asis_final=pg_exec($conn_final,$sql_asis)or die("Fallo asistencia final");
		
		for($z=0;$z<pg_numrows($rs_asis_final);$z++){
			$fila_sis_f=pg_fetch_array($rs_asis_final,$z);
			echo "<PRE>";
			print_r($fila_sis_f);
			echo "</PRE>";	
			
			$fila_sis_f['hora']="Null";
			
			$sql_ins_asi="insert into asistencia (rut_alumno,ano,id_curso,fecha) 
			values
			(".$fila_sis_f['rut_alumno'].",".$id_ano_vina.",".$id_curso_v.",'".$fila_sis_f['fecha']."')
			";
			echo "<PRE>";
			echo $sql_ins_asi;
			echo "</PRE>";	
			
			$rs_ins_asis=pg_exec($conn_vina,$sql_ins_asi)or die("Fallo xx ".$sql_ins_asi);
			
		}
	 }
  }*/
/**********************ANOTACION*************************************************************************************************************************/





$sql_ano="SELECT * FROM ano_escolar WHERE id_institucion=1598 ORDER BY id_ano ASC";
$rs_ano=pg_exec($conn_final,$sql_ano);
			
for($i=0;$i<pg_numrows($rs_ano);$i++){
	$fila=pg_fetch_array($rs_ano,$i);
	
	$sql_id_ano_vina="select id_ano,nro_ano from ano_escolar where nro_ano=".$fila['nro_ano']." and id_institucion=1598 ORDER BY id_ano ASC";
	$rs_ano_vina=pg_exec($conn_vina,$sql_id_ano_vina);
	$id_ano_vina=pg_result($rs_ano_vina,0);

	
	
	 $sql_per="select * from periodo where id_ano=".$fila[0]."";
	$rs_per_final=pg_exec($conn_final,$sql_per)or die("Fallo Periodo ".$sql_per);
		
		for($j=0;$j < pg_numrows($rs_per_final); $j++){
			
			$fila_per_final=pg_fetch_array($rs_per_final,$j);
			echo "<PRE>";
			//print_r($fila_per_final);
			echo "</PRE>";
				
	
	
		
	
	
	 $sql_anot="select * from anotacion where id_periodo=".$fila_per_final['id_periodo']."";
	$rs_anot=pg_exec($conn_final,$sql_anot)or die("fallo.......");
	
	for($q=0;$q < pg_numrows($rs_anot);$q++){
		$fila_anot=pg_fetch_array($rs_anot,$q);
			echo "<PRE>";
			print_r($fila_anot);
			echo "</PRE>";
			
			$sql_per_vina="select * from periodo where id_ano=".$id_ano_vina." and nombre_periodo='".$fila_per_final['nombre_periodo']."'";
	$rs_per_v=pg_exec($conn_vina,$sql_per_vina)or die ("Fallo la w...");
	
	for($a=0;$a<pg_numrows($rs_per_v);$a++){
		
		$fila_per_v=pg_fetch_array($rs_per_v,$a);
		    echo "<PRE>";
			//print_r($fila_per_v);
			echo "</PRE>";
			
			if($fila_anot['tipo']==""){
				$fila_anot['tipo']=0;
				}
			if(trim($fila_anot['observacion'])==""){
				$fila_anot['observacion']='-';
				}	
			if(trim($fila_anot['tipo_conducta'])==""){
				$fila_anot['tipo_conducta']=0;
				}	
			if(trim($fila_anot['codigo_anotacion'])==""){
				$fila_anot['codigo_anotacion']='-';
				}	
			if(trim($fila_anot['codigo_tipo_anotacion'])==""){
				$fila_anot['codigo_tipo_anotacion']='-';
				}	
			if(trim($fila_anot['sigla'])==""){
				$fila_anot['sigla']='-';
				}	
			if(trim($fila_anot['tipo_responsable'])==""){
				$fila_anot['tipo_responsable']=0;
				}
			if(trim($fila_anot['jornada'])==""){
				$fila_anot['jornada']=0;
				}		
			$rdb=1598;	
			
			
			
			$sql_ins="insert into anotacion (tipo,fecha,observacion,rut_alumno,rut_emp,tipo_conducta,id_periodo
			          ,codigo_anotacion,codigo_tipo_anotacion,sigla,rdb,tipo_responsable,jornada)
					  VALUES
					  (".$fila_anot['tipo'].",'".$fila_anot['fecha']."','".trim($fila_anot['observacion'])."',".$fila_anot['rut_alumno'].",".$fila_anot['rut_emp'].",".$fila_anot['tipo_conducta'].",".$fila_per_v['id_periodo']."
					  ,'".trim($fila_anot['codigo_anotacion'])."','".$fila_anot['codigo_tipo_anotacion']."','".$fila_anot['sigla']."',".$rdb.",'".$fila_anot['tipo_responsable']."',".$fila_anot['jornada'].")";
					echo "<PRE>";
					echo $sql_ins;
					echo "</PRE>";
			
				//$rs_ist=pg_exec($conn_vina,$sql_ins)or die("Fallo Insert ".$sql_ins);
	    }
      }		
	}

}




