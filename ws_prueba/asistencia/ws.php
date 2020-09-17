<?php

include_once '../lib/nusoap.php';
$servicio = new soap_server();
$servicio->soap_defencoding = 'UTF-8';
$servicio->decode_utf8 = false;
$servicio->encode_utf8 = true;


$ns = "urn:wsdlAsistencia";
$servicio->configureWSDL("wsAsistencia",$ns);
$servicio->schemaTargetNamespace = $ns;

$servicio->register("arbolAsistencia", array('rdb' => 'xsd:integer', 'ano' => 'xsd:integer', 'ensenanza' => 'xsd:integer', 'grado' => 'xsd:integer', 'letra' => 'xsd:string', 'mes' => 'xsd:integer'), array('return' => 'xsd:Array'), $ns );
//$servicio->register("arbolAsistencia", array('cad' => 'xsd:string'), array('return' => 'xsd:Array'), $ns );


function edad($fecha){
 list($Y,$m,$d) = explode("-",$fecha);
   return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}

function finmes($mes,$ano){
if($mes==1 || $mes==3 || $mes==5 || $mes==7 || $mes==8 || $mes==10 || $mes==12){
		$dia=31;
	}elseif($mes==4 || $mes==6 || $mes==9 || $mes==11){
		$dia=30;
	}elseif(($ano%4)==0){
		$dia=29;
	}else{
		$dia==28;
	}
	return $dia;
}

//datediff rango de fechas
function ddiff($start, $end) {
    			
        $sdate = strtotime($start." 00:00:00");
        $edate = strtotime($end." 23:59:59");
		
        
        if ($edate < $sdate) {
            $sdate_temp = $sdate;
            $sdate = $edate;
            $edate = $sdate_temp;
            
        }
       $time = $edate - $sdate;
        $preday[0] = 0;
        
        if($time>=0 && $time<=59) {
                // Seconds
                $timeshift = $time.' seconds ';

        } elseif($time>=60 && $time<=3599) {
                // Minutes + Seconds
                $pmin = ($edate - $sdate) / 60;
                $premin = explode('.', $pmin);
               
                $presec = $pmin-$premin[0];
                $sec = $presec*60;
               
                $timeshift = $premin[0].' min '.round($sec,0).' sec ';

        } elseif($time>=3600 && $time<=86399) {
                // Hours + Minutes
                $phour = ($edate - $sdate) / 3600;
                $prehour = explode('.',$phour);
               
                $premin = $phour-$prehour[0];
                $min = explode('.',$premin*60);
               
                $presec = '0.'.$min[1];
                $sec = $presec*60;

                $timeshift = $prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

        } elseif($time>=86400) {
                // Days + Hours + Minutes
                $pday = ($edate - $sdate) / 86400;
                $preday = explode('.',$pday);

                $phour = $pday-$preday[0];
                $prehour = explode('.',$phour*24);

                $premin = ($phour*24)-$prehour[0];
                $min = explode('.',$premin*60);
               
                $presec = '0.'.$min[1];
                $sec = $presec*60;
               
                $timeshift = $preday[0].' days '.$prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

        }
        

        return $preday[0]+1;
} 

//dias habiles por rango fijo, sin feriados
function hbl($fechainicio, $fechafin, $diasferiados = array()) {
        // Convirtiendo en timestamp las fechas
		
		// $fechainicio.".....".$fechafin;;
		
        $fechainicio = strtotime($fechainicio." 00:00:00");
	 $fechafin = strtotime($fechafin." 23:59:59");
       
        // Incremento en 1 dia
        $diainc = 24*60*60;
       
        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();
       
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                        if (!in_array(date('Y-m-d', $midia), $diasferiados)) {

                                array_push($diashabiles, date('Y-m-d', $midia));
                        }
                }
        }
      //echo  count($diashabiles);
        return count($diashabiles);
}



function arbolAsistencia($rdb,$ano,$ensenanza,$grado,$letra,$mes)
{ 

/*$p = xml_parser_create();
xml_parse_into_struct($p, $cad, $vals, $index);
xml_parser_free($p);
/*echo "Index array\n";
print_r($index);
echo "<br><br><br>";
echo "\nVals array\n<pre>";
print_r($vals);
echo "</pre>";
$rdb= $vals[5]['value'];
$nro_ano = $vals[7]['value'];
$ensenanza= $vals[9]['value'];
$grado= $vals[11]['value'];
$letra= $vals[13]['value'];
$mes= $vals[15]['value'];*/
	
	
	
	
$secret = base64_encode("semilla".$rdb);

/*$mes=($mes<10)?"0".$mes:$mes;
	$nro_ano = $ano;
	
*/

//voy a ver si institucion tiene la semilla
$connection=pg_connect("dbname=coi_usuario host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_Usuario ");
	
$sql_ins="select * from institucion where rdb=".$rdb." and secret='$secret'";
//$valor_retorno["yry"]=$sql_ins;
@$rs_ins = pg_exec($connection,$sql_ins);
$fil_ins = pg_fetch_array($rs_ins,0);
if(pg_numrows($rs_ins)==0){
	$valor_retorno["error"]="INSTITUCI&Oacute;N NO HABILITADA";
}
else{

$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	

//año escolar
$sql_ano="select id_ano from ano_escolar where id_institucion=$rdb and nro_ano=$ano";

@$rs_ano = pg_exec($conn,$sql_ano);
$id_ano = pg_result($rs_ano,0);
if(pg_numrows($rs_ano)==0){
	$valor_retorno["error"]="NO EXISTE A&Ntilde;O ESCOLAR";
}

//periodos
 $sql_per="select id_periodo,nombre_periodo from periodo where id_ano=$id_ano order by fecha_inicio";
@$rs_periodo = pg_exec($conn,$sql_per);
if(pg_numrows($rs_periodo)==0){
	$valor_retorno["error"]="A&Ntilde;O ESCOLAR NO TIENE PERIODOS";
}

//curso
$sql_curso = "select fecha_inicio,fecha_termino,id_curso from curso where id_ano=$id_ano and grado_curso=$grado and letra_curso='$letra' and ensenanza=$ensenanza";
$rs_cur = pg_exec($conn,$sql_curso);
$curso = pg_result($rs_cur,2);
$fecha_inicio_curso = pg_result($rs_cur,0);
$fecha_termino_curso = pg_result($rs_cur,1);
if(pg_numrows($rs_cur)==0){
	$valor_retorno["error"]="NO EXISTE CURSO";
	
}
if((strlen($fecha_inicio_curso)==0 && $fecha_inicio_curso="1111-11-11") || (strlen($fecha_termino_curso)==0 && $fecha_termino_curso="1111-11-11")){
	$valor_retorno["error"]="CURSO SIN FECHAS CONFIGURADAS";
}
//alumnps
$sql_tiene="select alu.rut_alumno,alu.nombre_alu,alu.ape_pat,alu.ape_mat,alu.dig_rut,alu.telefono,alu.celular,alu.calle,alu.fecha_nac,
cur.grado_curso,cur.letra_curso,ens.nombre_tipo,matricula.bool_ar,matricula.tipo_retiro,
matricula.motivo_retiro,cur.ensenanza,matricula.fecha,matricula.fecha_retiro,matricula.ben_pie
from alumno alu 
inner join matricula on matricula.rut_alumno = alu.rut_alumno 
inner join curso cur on cur.id_curso = matricula.id_curso
inner join tipo_ensenanza ens on ens.cod_tipo = cur.ensenanza
where rdb=$rdb and  matricula.id_curso = $curso";
//$valor_retorno["qry"]=$sql_tiene;
$rs_tiene = pg_exec($conn,$sql_tiene) ;

if(pg_numrows($rs_tiene)==0){
	$valor_retorno["error"]="SIN ALUMNOS";
	
	}else{

for($a=0;$a<pg_numrows($rs_tiene);$a++){	
			$f = pg_fetch_array($rs_tiene,$a);
			
			//datos basicos alumno
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['rut_alumno']=$f['rut_alumno'];
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['dv']=strtoupper($f['dig_rut']);
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['nombre']=strtoupper(utf8_encode($f['nombre_alu']));
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['ape_paterno']=strtoupper(utf8_encode($f['ape_pat']));
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['ape_materno']=strtoupper(utf8_encode($f['ape_mat']));
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['fecha_nacimientos']=$f['fecha_nac'];
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['edad']=edad($f['fecha_nac']);
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['sexo']=($f['sexo']==1)?"F":"M";
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['telefono']=(strlen(trim($f['telefono']))>0)?$f['telefono']:"-";
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['celular']=(strlen(trim($f['celular']))>0)?$f['celular']:"-";
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['direccion']=strtoupper(trim(utf8_encode($f['calle']." ".$f['nro'])));
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['rdb']=$rdb;
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['nombre_instit']=strtoupper(trim(utf8_encode($fil_ins['nombre_instit'])));
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['curso']=$f['grado_curso'];
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['letra']=$f['letra_curso'];
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['nivel']=strtoupper(trim(utf8_encode($f['nombre_tipo'])));
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['estado']=($f['bool_ar']==0)?"ACTIVO":"RETIRADO";
			
			if($f['bool_ar']==1 && $f['tipo_retiro']==2 &&  strlen($f['tipo_retiro'])>0){
			$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['nuevo_establecimiento']=strtoupper(trim(utf8_encode($f['motivo_retiro'])));
			}else{
				$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['nuevo_establecimiento']="-";
			}
			
			//datos asisgaturas
			if($f['ensenanza']>10){
				//asignaturas
				$sql_asid ="select t.*,s.nombre,s.cod_subsector from tiene$nro_ano t inner join ramo r on r.id_ramo = t.id_ramo inner join subsector s on s.cod_subsector=r.cod_subsector where rut_alumno = ".$f['rut_alumno']." and t.id_curso = ".$curso." order by r.id_orden";
				
				//$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['erwe']=$sql_asid;
			$rs_asid = pg_exec($conn,$sql_asid);
			
			
			for($as=0;$as<pg_numrows($rs_asid);$as++){
				
				$filar=pg_fetch_array($rs_asid,$as);
				$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['asignaturas'][$filar['cod_subsector']]['nombre']=utf8_encode($filar['nombre']);
				
				for($p=0;$p<pg_numrows($rs_periodo);$p++){
					$filap = pg_fetch_array($rs_periodo,$p);
					$cuentanota=20;
					$nomp=trim(strtolower($filap['nombre_periodo']));
					$nomp=str_replace(" ","",$nomp);
					
					$sql_notas="select nota1,nota2,nota3,nota4,nota5,nota6,nota7,nota8,nota9,nota10,
					nota11,nota12,nota13,nota14,nota15,nota16,nota17,nota18,nota19,nota20,promedio 
					from notas$nro_ano where rut_alumno=".$f['rut_alumno']." and id_ramo = ".$filar['id_ramo']." and id_periodo = ".$filap['id_periodo'];
					$rs_nota = pg_exec($conn,$sql_notas);
					$fila_nota = pg_fetch_array($rs_nota,0);
					
					if( trim($fila_nota['nota1'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					if(  trim($fila_nota['nota2'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					if(  trim($fila_nota['nota3'])==0){
						$cuentanota=$cuentanota-1;
					}
					if(  trim($fila_nota['nota4'])==0){
						$cuentanota=$cuentanota-1;
					}
					
					if(  trim($fila_nota['nota5'])==0){
						$cuentanota=$cuentanota-1;
					}
					if(  trim($fila_nota['nota6'])==0){
						$cuentanota=$cuentanota-1;
					}
					
					if( trim($fila_nota['nota7'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					
					if(  trim($fila_nota['nota8'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					
					if(  trim($fila_nota['nota9'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					
					if(  trim($fila_nota['nota10'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					
					if(  trim($fila_nota['nota11'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					
					if(  trim($fila_nota['nota12'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					
					if(  trim($fila_nota['nota13'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					
					if(  trim($fila_nota['nota14'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					
					if(  trim($fila_nota['nota15'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					
					if(  trim($fila_nota['nota16'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					
					if(  trim($fila_nota['nota17'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					
					if( trim($fila_nota['nota18'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					
					if(  trim($fila_nota['nota19'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					
					if(  trim($fila_nota['nota20'])=="0"){
						$cuentanota=$cuentanota-1;
					}
					
					
				
					$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['asignaturas'][$filar['cod_subsector']][$nomp]['cantidad_notas']=$cuentanota;
				
				$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['asignaturas'][$filar['cod_subsector']][$nomp]['prom_periodo']=$fila_nota['promedio'];
					
				
				}
				
			}
			
						
		}//fin paso por asignaturas
		
		
		$sql_pf="select promedio from promocion where rut_alumno=".$f['rut_alumno']." and id_curso=".$curso;
		$rs_pf = pg_exec($conn,$sql_pf);
		$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['promedio_final']=pg_result($rs_pf,0);
		
		//anotaciones
		$sql_anota="select count (*) from anotacion where rut_alumno=".$f['rut_alumno']." and date_part('year',fecha)=".$nro_ano." and tipo<>2";	
		$rs_anoa = pg_exec($conn,$sql_anota);
		
		
		$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['cant_anotaciones']=pg_result($rs_anoa,0);
		
		//asistencia
		
		$sql_faltados="select count(*) from asistencia where rut_alumno=".$f['rut_alumno']." and id_curso=".$curso." and date_part('month',fecha)=$mes and date_part('year',fecha)=$nro_ano";
		$rs_faltados=pg_exec($conn,$sql_faltados);
		
		
		$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['mes_asistencia']['dias_inasistencia']=pg_result($rs_faltados,0);
		
		
		//calculo dias habiles del mes
		$finmes = finmes($mes,$nro_ano);
		
		$d_semana = hbl($nro_ano."-".$mes."-01",$nro_ano."-".$mes."-".$finmes);
		
		//feriados
		$sql_feriados="select count(*) from feriado where id_ano=$id_ano and fecha_inicio>='".$nro_ano."-".$mes."-01"."' and fecha_fin <='".$nro_ano."-".$mes."-".$finmes."'";
		//$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['qry']=$sql_feriados;
		$rs_feriados=pg_exec($conn,$sql_feriados);
		
		$habiles = $d_semana-pg_result($rs_feriados,0);
		
		
		$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['mes_asistencia']['dias_habiles_mes']=$habiles;
		
		
		//calcular porcentaje de asistencia
		//$semana_ano = hbl(pg_result($rs_cur,0),pg_result($rs_cur,1));
		
		
		$feriados_ano=0;
		$fera=0;
//=========== calculo % asistencia nuevo =====
	//************ habiiles (nuevo)
	//fecha inicio -> matricule despues de incio de año, indicar fecha, si no, marcar inicio de año academico
		if($f['fecha'] <= pg_result($rs_cur,0))
		{$fini= pg_result($rs_cur,0);}
		else
		{$fini= $f['fecha'];}
		
		
		
		//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de año academico
		if($f['bool_ar']==1){
		 $fter =$f['fecha_retiro'];
		}else{
		 $fter = pg_result($rs_cur,1);
		}
		
		//conteo dias habiles año (sin feriados)
		 $habiles_ano=hbl($fini,$fter);
		
		
	
//***************fin habikes (nuevo)
//******feriados año
    $sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$id_ano."  AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
	
	$rs_feriadosano = @pg_exec($conn,$sql_fano);

for($ff=0;$ff<pg_numrows($rs_feriadosano);$ff++){
		$fila_feriadoano =pg_fetch_array($rs_feriadosano,$ff);
		
		$inciof= $fila_feriadoano['fecha_inicio'];
		
	
		
		if($fila_feriadoano['fecha_fin']==NULL)
		{
			 $finf=$inciof ;
			
		}else{
		
			$finf= $fila_feriadoano['fecha_fin'];
		}
		
		 $fera=$fera+$dif_dias =ddiff($inciof, $finf);
		
		}
		
	 	$feriados_ano=$fera;


//fin feriados año	
	
	//dias reales año
	 $habil_real_ano = $habiles_ano-$feriados_ano;
	

 //inasistencias
	 $sql_asisano = "SELECT * FROM asistencia WHERE rut_alumno = ".$f['rut_alumno']." and ano = ".$id_ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$curso;
	
	$r_asisano = @pg_exec($conn,$sql_asisano);
		
	$c_inasistenciaAno = pg_numrows($r_asisano);
	
//justificadas

  $sql_jasisano = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = ".$f['rut_alumno']." and ano = ".$id_ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$curso;
  	
  $r_justificaano= @pg_exec($conn,$sql_jasisano);
 $justificaano = pg_numrows($r_justificaano);
 
 //resta final
	  $con_total_inano = $habil_real_ano-($c_inasistenciaAno-$justificaano);
		$prc_base = number_format((100* $con_total_inano)/$habil_real_ano,1,',','.');
		
		$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['mes_asistencia']['porcentaje_asistencia_anual']=$prc_base;
		
		
		$sql_justifica="select count(*) from justifica_inasistencia where rut_alumno=".$f['rut_alumno']." and id_curso=".$curso."and date_part('month',fecha)=$mes and date_part('year',fecha)=$nro_ano";
		$rs_justifica=pg_exec($conn,$sql_justifica);
		
		$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['mes_asistencia']['inasistencias_justificadas']=pg_result($rs_justifica,0);
		
		
		//atrasos
		$sql_atraso="select count (*) from anotacion where rut_alumno=".$f['rut_alumno']." and date_part('year',fecha)=".$nro_ano."and tipo=2";	
		$rs_atraso = pg_exec($conn,$sql_atraso);
		
		$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['mes_asistencia']['cantidad_atrasos']=pg_result($rs_atraso,0);
		$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['mes_asistencia']['mes_consulta']=$mes."-".$nro_ano;
			
			
		$sql_cita="select count(*) from citacion_apo where rut_alumno=".$f['rut_alumno']." and id_ano=".$id_ano;
		$result_cita =@pg_Exec($conn,$sql_cita);
		//$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['tbeca']=$sql_cita;
				
	$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['entrevista_apoderado']=pg_result($result_cita,0);
	$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['alumno_pie']=($f['ben_pie']==1)?"SI":"NO";
	
	
	//becas
	$sql_beca="select count(*) from becas_benef where rut_alumno=".$f['rut_alumno']." and id_ano=";
		$result_beca =@pg_Exec($conn,$sql_beca);
	//$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['tbeca']=$sql_beca;
	$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['alumno_becado']=(pg_numrows($result_beca)>0)?"SI":"NO";
	
		
		//entrevistas alumno
		//becas
	$sql_ent_alumno="select count(*) from entrevista_alumno where rut_entrevistado=".$f['rut_alumno']." and id_ano=$id_ano";
		$result_enralumno =@pg_Exec($conn,$sql_ent_alumno);
		
	//$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['tbeca']=$sql_ent_alumno;
	$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['entrevista_alumno']=pg_result($result_enralumno,0);
	
	
	//consulta apoderado
	$sql_apo="select ap.rut_apo,dig_rut,nombre_apo,ape_pat,ape_mat,calle,nro,telefono,celular from apoderado ap inner join tiene2 ti on ti.rut_apo=ap.rut_apo where ti.rut_alumno=".$f['rut_alumno']." and ti.responsable=1";
	$rs_apo = pg_exec($conn,$sql_apo);
	$fila_apo=pg_fetch_array($rs_apo,0);
	
	$rutap=(strlen($fila_apo['rut_apo'])>0)?$fila_apo['rut_apo']:"-";
	$dvp=(strlen($fila_apo['dig_rut'])>0)?$fila_apo['dig_rut']:"-";
	$nomp=(strlen($fila_apo['nombre_apo'])>0)?strtoupper(utf8_encode($fila_apo['nombre_apo'])):"-";
	$apep=(strlen($fila_apo['ape_pat'])>0)?strtoupper(utf8_encode($fila_apo['ape_pat'])):"-";
	$amap=(strlen($fila_apo['ape_mat'])>0)?strtoupper(utf8_encode($fila_apo['ape_mat'])):"-";
	$calleap=(strlen($fila_apo['calle'])>0)?strtoupper(utf8_encode($fila_apo['calle']." ".$fila_apo['nro'])):"-";
	
	//$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['apoderado']['qry']=$sql_apo;
	$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['apoderado']['rut']=$rutap;
	$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['apoderado']['dv']=$dvp;
	$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['apoderado']['nombre']=$nomp;
	$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['apoderado']['ape_pat']=$apep;
	$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['apoderado']['ape_mat']=$amap;
	$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['apoderado']['direccion']=$calleap;
	$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['apoderado']['telefono']=(strlen(trim($fila_apo['telefono']))>0)?$fila_apo['telefono']:"-";
	$valor_retorno['asistencia']['alumno'][$f['rut_alumno']]['apoderado']['celular']=(strlen(trim($fila_apo['celular']))>0)?$fila_apo['celular']:"-";	
			
		}//fin for alumnos
	}//fin verificacion alumnos

	
}//fin info si tengo año escolar



return $valor_retorno;	
}//fin funcion

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$servicio->service($HTTP_RAW_POST_DATA);




?>