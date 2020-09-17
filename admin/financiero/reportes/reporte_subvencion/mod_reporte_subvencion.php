<?php
session_start();
require('../../../../util/header.inc');
//$nacional=	$_ID_NACIONAL;
 
class Motor
{
	private $conect;       

//constructor 
	 public function __construct($con){ 
	  $this->conect = $con;  
	}
	
	
	public function datos_institucion($rdb)
	{
	  $sql = "select * from institucion where rdb=$rdb";
	  $rerult=pg_Exec($this->conect,$sql);
			 
			if($rerult){
			return $rerult;
			}else{
			return false;
		}	
	}
	
	
 public function ano_academico($rdb,$nro_ano){
		
	      $sql="select id_ano from ano_escolar where id_institucion=".$rdb." and nro_ano=".$nro_ano."";
	     $rerult=pg_Exec($this->conect,$sql);
			 
			if($rerult){
			return $rerult;
			}else{
			return false;
		}
	}
	
	
	public function busca_institucion($id_nacional)
	{
		 $sql="select distinct ins.rdb,ins.nombre_instit,estado 
			from nacional_corp nc 
			inner join corp_instit ci on ci.num_corp=nc.num_corp
			inner join institucion ins on ins.rdb=ci.rdb
			where nc.id_nacional=".$id_nacional." 
			order by nombre_instit asc";
							
			$regis=pg_Exec($this->conect,$sql);
			
			 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function busca_institucion_graf_es($id_nacional,$limit)
	{
		 $sql="select ins.rdb,ins.nombre_instit,estado 
			from nacional_corp nc 
			inner join corp_instit ci on ci.num_corp=nc.num_corp
			inner join institucion ins on ins.rdb=ci.rdb
			where nc.id_nacional=".$id_nacional." 
			order by nombre_instit asc limit $limit";
							
			$regis=pg_Exec($this->conect,$sql);
			
			 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
		public function busca_institucion_graf_es2($id_nacional,$limit)
	{
		 $sql="select ins.rdb,ins.nombre_instit,estado 
			from nacional_corp nc 
			inner join corp_instit ci on ci.num_corp=nc.num_corp
			inner join institucion ins on ins.rdb=ci.rdb
			where nc.id_nacional=".$id_nacional." 
			order by nombre_instit asc offset $limit";
							
			$regis=pg_Exec($this->conect,$sql);
			
			 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
public function habiles($mes,$anno){
   $habiles = 0; 
   // Consigo el número de días que tiene el mes mediante "t" en date()
   $dias_mes = date("t", mktime(0, 0, 0, $mes, 1, $anno));
   // Hago un bucle obteniendo cada día en valor númerico, si es menor que 
   // 6 (sabado) incremento $habiles
   for($i=1;$i<=$dias_mes;$i++) {
       if (date("N", mktime(0, 0, 0, $mes, $i, $anno))<6) $habiles++;
   }

   return $habiles;
}

public function habilesdiciembre($mes,$id_ano)
{			
  if($mes==3){
     $elmes="fecha_inicio";
  }else{
	 $elmes="fecha_termino";
  }
	$sql = "SELECT date_part('day',$elmes) FROM periodo WHERE id_ano = ".$id_ano." and date_part('month',$elmes)=$mes";
	$result = @pg_exec($this->conect,$sql);
	return $result;	
}
	
	
	public function dias_feriados($id_ano,$mes)
	{
		 $sql="select * from feriado where id_ano=$id_ano and date_part('month',fecha_inicio)=$mes "; 
		$result=pg_exec($this->conect,$sql);
		$total=0;
		for($i=0;$i<pg_numrows($result);$i++)
		{
			$fila=pg_fetch_array($result,$i);
		 $inicio = $fila['fecha_inicio'];
		 $fin = $fila['fecha_fin'];
			
			if($fin==""){
				
				$fin=$inicio;
				}
				$inicio = strtotime($inicio);
		$fin = strtotime($fin);
		$dif = $fin - $inicio;
		$diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
		if($inicio==$fin){
			$diasFalt=1;
			}
			$total = $diasFalt+$total;
		}
		
		return ceil($total);
	
	}
		
		
	public function total_matricula($id_ano,$mes,$tipo)
	{
		$igual="=";
		if($tipo==1){
			$c_tipo=" and ben_sep=1";
			}else if($tipo==2){
				$c_tipo=" and ben_pie=1";
				}else if($tipo==3){
				$c_tipo=" and bool_retos=1";
				}else if($tipo==4){
					unset($tipo);
					unset($igual);
					$c_tipo=" and (ben_pie=0 or ben_pie is null) and (ben_sep=0 or ben_sep is null) and (bool_retos=0 or bool_retos is NULL)";
		 }
					
	
			  $sql_mat="select count(m.*) as contador, c.ensenanza,c.grado_curso,c.id_curso 
		 		   from matricula m INNER JOIN curso c ON m.id_ano=c.id_ano and m.id_curso=c.id_curso
		           where m.id_ano=$id_ano and date_part('month',fecha)<=$mes $c_tipo GROUP by 2,3,4
                   ORDER BY ensenanza,grado_curso asc";
		 $rs_mat=pg_exec($this->conect,$sql_mat);
		  if($rs_mat){
				   return $rs_mat;
			}else{
				 return false;
		 }
	}
	
	
	
	
	public function aistencia_mes($id_ano,$mes,$tipo,$id_curso)
	{
		
		$igual="=";
		if($tipo==1){
			$c_tipo=" and ben_sep";
			}else if($tipo==2){
				$c_tipo=" and ben_pie";
				}else if($tipo==3){
				$c_tipo=" and bool_retos";
				}else if($tipo==4){
					unset($tipo);
					unset($igual);
					$c_tipo=" and (ben_pie=0 or ben_pie is null) and (ben_sep=0 or ben_sep is null) and (bool_retos=0 or bool_retos is NULL)";
		 }
		
		 $sql="select count(a.*) as asistencia, c.ensenanza,c.grado_curso,c.id_curso 
		      from asistencia a 
			  inner JOIN matricula m on a.rut_alumno=m.rut_alumno and a.id_curso=m.id_curso	
			  INNER JOIN curso c ON m.id_ano=c.id_ano and m.id_curso=c.id_curso
		where ano=$id_ano and date_part('month',a.fecha)=$mes $c_tipo $igual $tipo and a.id_curso=$id_curso
		GROUP by 2,3,4 
        ORDER BY ensenanza,grado_curso asc
		";
		$result=pg_exec($this->conect,$sql)or die("A_S".$sql);
		if($result){
				 return $result;
			}else{
				 return false;
		 }
	}
	
	
	public function calculasubvencion($ensenanza,$grado_curso,$tipo,$tipo_instit,$nro_ano){
		
	//	print_r($_POST);
		
		 $sql=" select f.factor,f.monto from factores_subvencion as f 
               where f.cod_ensenanza=$ensenanza and f.grado_curso=$grado_curso and f.id_tipo=$tipo 
			   and f.tipo_instit=$tipo_instit and f.nro_ano=$nro_ano";
			   
			   $result=pg_exec($this->conect,$sql)or die("A_V");
		if($result){
				 return $result;
			}else{
				 return false;
		 }
		
		}
		
		
		
		
		
		
		public function guarda_subvencion($rdb,$nom_instit,$nro_ano,$mes,$monto_total1,$monto_total2,$monto_total3,$monto_total4,$id_nacional)
		{
	 $sql_insert="insert into subvencion_intitucion (rdb,nombre_intitucion,nro_ano,mes,sep,pie,retos,normal,id_nacional)
	values	
	(".$rdb.",'".$nom_instit."',".$nro_ano.",".$mes.",".$monto_total1.",".$monto_total2.",".$monto_total3.",".intval($monto_total4).",".$id_nacional.")";
	
    $result = pg_exec($this->conect,$sql_insert);
	if($result)
	 return $result;
		}


	public function carga_subvenciones($id_nacional,$nro_ano,$cmb_mes)
	{
		$sql="select distinct * from subvencion_intitucion where id_nacional=$id_nacional and nro_ano=$nro_ano and mes=$cmb_mes";
		$result = @pg_exec($this->conect,$sql);
	    return $result;
			
	}
	
	
	public function busca_nacional($id_nacional,$mes,$nro_ano)
	{
	 $sql="select * from subvencion_intitucion where id_nacional=$id_nacional and mes=$mes and nro_ano=$nro_ano limit 20";
	 $result = pg_exec($this->conect,$sql);
	 if($result){
		 return $result; 
		 }else{
	    return false;
		 }
	}
	
	public function busca_grafico_nacional($id_nacional,$mes,$nro_ano,$contador)
	{
	 $sql="select * from subvencion_intitucion where id_nacional=$id_nacional and mes=$mes and nro_ano=$nro_ano order by rdb limit $contador";
	 $result = pg_exec($this->conect,$sql);
	 if($result){
		 return $result; 
		 }else{
	    return false;
		 }
	}
	
	public function busca_grafico_nacional2($id_nacional,$mes,$nro_ano,$contador)
	{
	  $sql="select * from subvencion_intitucion where id_nacional=$id_nacional and mes=$mes and nro_ano=$nro_ano order by rdb offset $contador ";
	 $result = pg_exec($this->conect,$sql);
	 if($result){
		 return $result; 
		 }else{
	    return false;
		 }
	}
	
	
	public function cuenta_nacional_mensual($id_nacional,$mes,$nro_ano)
	{
	 $sql="select count(*) from subvencion_intitucion where id_nacional=$id_nacional and mes=$mes and nro_ano=$nro_ano";
	 $result = pg_exec($this->conect,$sql);
	 if($result){
		 return $result; 
		 }else{
	    return false;
		 }
	}
	
	
	
	
	
}


?>