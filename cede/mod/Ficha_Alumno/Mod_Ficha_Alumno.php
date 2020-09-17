<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../../Class/Membrete.php";
 
class Ficha_Alumno {
	   
		public $Conec;

//Constructor 
public function __construct($_IPDB,$_ID_BASE){
	$this->Conec = new DBManager($_IPDB,$_ID_BASE);
	
		 } 
       
	   
      public function Carga_Anos($int){
	  $sql = "SELECT * FROM ano_escolar WHERE id_institucion=".$int." Order By Nro_ano";
	  $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Años" );
	  if($regis){ 
	  return $regis; 
	  }
	  else{ return false; 
	  }
	  } 
	   
	   
	  public function Carga_Cursos($ano){
		   $sql= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, 
						tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  
						FROM  curso 
						INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo 
						WHERE curso.id_ano=".$ano."
						ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
           $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Cursos" );
	       if($regis){ return $regis; }else{ return false; }}

      
	  public function Carga_Alumnos($id_curso,$id_ano){
		  
	      $sql = "SELECT alumno.rut_alumno,
						alumno.dig_rut, alumno.nombre_alu, 
						alumno.ape_pat, alumno.ape_mat,
						alumno.telefono, alumno.calle,
						alumno.nro, alumno.depto,
						alumno.region, 	alumno.ciudad,
						alumno.comuna, matricula.id_curso,
						matricula.nro_lista, matricula.bool_ar,
						matricula.num_mat 
						FROM curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso 
						INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno 
						WHERE matricula.id_curso = $id_curso AND matricula.id_ano = $id_ano 
						ORDER BY ape_pat,ape_mat,nombre_alu ASC";
           
		   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Alumnos" );
		   
	       if($regis){ return $regis; }else{ return false; }}
	  
	  
	  
	  public function  Buscar_Alumno($rut_alumno){
		  
	  $sql = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, 
					alumno.ape_mat, alumno.telefono, alumno.calle, alumno.nro, alumno.depto, 
					alumno.region, alumno.ciudad, alumno.comuna, matricula.id_curso, 
					matricula.nro_lista, matricula.bool_ar, matricula.num_mat,region.nom_reg,comuna.nom_com,
					provincia.nom_pro
					FROM curso 
					INNER JOIN matricula ON curso.id_curso = matricula.id_curso 
					INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno 
					INNER JOIN region on alumno.region=region.cod_reg
					inner join provincia on alumno.ciudad=provincia.cor_pro and provincia.cod_reg=region.cod_reg
					inner join comuna on alumno.comuna=comuna.cor_com and comuna.cor_pro=provincia.cor_pro and comuna.cod_reg=region.cod_reg
					WHERE matricula.rut_alumno=".$rut_alumno;
           
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Alumnos" );
		   
	    if($regis){ return $regis; }else{ return false; }}
	      
          	  
		public function Buscar_Apoderados($rut_alumno){ 
			  
		 $sql = "SELECT * FROM tiene2  t2
					  INNER JOIN  apoderado a ON a.rut_apo = t2.rut_apo
					  INNER JOIN region on a.region=region.cod_reg 
			  		  inner join provincia on a.ciudad=provincia.cor_pro and 
					  provincia.cod_reg=region.cod_reg 
					  inner join comuna on a.comuna=comuna.cor_com and 
					  comuna.cor_pro=provincia.cor_pro and comuna.cod_reg=region.cod_reg 

					  WHERE t2.rut_alumno = ".$_POST['rut_alumno'].";";
	    $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Alumnos" );
			   
		if($regis){ return $regis; }else{ return false; }}
		   
	   
	   public function Cursos_Solicitado($rut,$ano){
		   $sql= "SELECT * FROM matricula ma
INNER JOIN curso cu ON cu.id_curso = ma.id_curso AND cu.id_ano = ma.id_ano
INNER JOIN tipo_ensenanza ten ON ten.cod_tipo = cu.ensenanza 
INNER JOIN ano_escolar aes ON aes.id_ano = ma.id_ano AND aes.situacion = 1
WHERE ma.rut_alumno = $rut AND ma.id_ano =  $ano ";
           $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga El Curso" );
	       if($regis){ return $regis; }else{ return false; }}
	   
	   
	   public function Opta_O_No_Reg($rut,$ano){

		// busco el año en que esta:
	    $q1 = "select * from ano_escolar where id_ano = $ano ";
		$r1 = pg_Exec($this->Conec->conectar(),$q1);
		$f1 = pg_fetch_array($r1);
		$nro_ano = $f1['nro_ano'];
		
       $q2 = "select * from tiene$nro_ano , ramo where tiene$nro_ano.rut_alumno = '$rut' and tiene$nro_ano.id_ramo = ramo.id_ramo and ramo.cod_subsector = '13'";
		$r2 = pg_Exec($this->Conec->conectar(),$q2);
		$n2 = pg_num_rows($r2);
		if ($n2 > 0){  // entonces opta a religión 
		    echo 1;			
		}else{
		    echo 2;
		}
		   
		   }
	   
	   public function Conducta($rut,$ano){
	   $sql = "SELECT anotacion.id_anotacion, anotacion.sigla, anotacion.codigo_tipo_anotacion, anotacion.codigo_anotacion, anotacion.tipo, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, anotacion.fecha, anotacion.tipo, empleado.rut_emp, anotacion.tipo_conducta FROM (anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) left JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((alumno.rut_alumno)=$rut)) and anotacion.id_periodo in (select id_periodo from periodo where id_ano = '$ano') order by fecha";
           $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Anotaciones" );
	       if($regis){ return $regis; }else{ return false; }}
	   
	   
	   
	   public function buscaNotas($rut_alumno,$rdb,$periodo,$nro_ano,$id_ramo){
		   
	  $sql = "SELECT notas$nro_ano.nota1, notas$nro_ano.nota2, notas$nro_ano.nota3, notas$nro_ano.nota4, notas$nro_ano.nota5, notas$nro_ano.nota6, notas$nro_ano.nota7, notas$nro_ano.nota8, notas$nro_ano.nota9, notas$nro_ano.nota10, notas$nro_ano.nota11, notas$nro_ano.nota12, notas$nro_ano.nota13, notas$nro_ano.nota14, notas$nro_ano.nota15, notas$nro_ano.nota16, notas$nro_ano.nota17,notas$nro_ano.nota18, notas$nro_ano.nota19, notas$nro_ano.nota20, notas$nro_ano.promedio,notas$nro_ano.id_ramo,sub.nombre,nombre_periodo 
			FROM notas$nro_ano
			INNER join ramo r on notas$nro_ano.id_ramo=r.id_ramo
            inner join subsector sub on r.cod_subsector= sub.cod_subsector
			inner join periodo per on notas$nro_ano.id_periodo = per.id_periodo
			
			WHERE (((notas$nro_ano.rut_alumno)='".$rut_alumno."') AND ((notas$nro_ano.id_ramo)=".$id_ramo.") AND ((notas$nro_ano.id_periodo)=".$periodo.")); ";

		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Notas".$sql );
	       if($regis){ 
		   return $regis; 
		   }else{
	      return false; }
		}	
	   
	   
	   
	   function detalles_anot($codtipo,$codigo_anotacion,$anotacion){
		   
		   if($codtipo!=""){
				$sql = "select * from detalle_anotaciones  where id_tipo = '$codtipo' and codigo = '$codigo_anotacion'";
		   }else{
				$sql="SELECT observacion FROM anotacion WHERE id_anotacion=".$anotacion;   
		   }
		  $regis = pg_Exec( $this->Conec->conectar(),$sql );
		   
		   //$sindet="Sin Detalles";
		   if($regis){
			    return $regis; 
			}else{ 
				return false; 
			}
		   
		   
		   
		  }
	   
	   
	   
	   
	   
      //**************PLANTILLAS********************************// 
	  public function cargaplantillas($id_bloque,$id_nacional){
	  $sql = "SELECT  id_plantilla,rdb,ensenanza,fecha_creacion,
	  nombre,primera,segunda,tercera,cuarta,quinta,sexta,septima,octava,estado
	  FROM cede.plantilla_apo ;";
	  $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 22" );
	  if($regis){ return $regis; }else{ return false; }} 
  
	  public function buscar_plantilla($id_plantilla){
	  $sql = "SELECT  id_plantilla,rdb,ensenanza,fecha_creacion,
	  nombre,primera,segunda,tercera,cuarta,quinta,sexta,septima,
	  octava,estado FROM cede.plantilla_apo WHERE id_plantilla = ".$id_plantilla."";
	  $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 4" );
	  if($regis){ return $regis; }else{ return false; 	}}
	
	   public function insertar_plantilla($id_bloque,$nombre_plantilla,$id_instit){
	   $nombre_plantilla = utf8_decode($nombre_plantilla);
	   $sql = "INSERT INTO cede.plantilla_apo
	   (id_plantilla,rdb,ensenanza,fecha_creacion,nombre,estado) 
	   VALUES (DEFAULT,$id_instit,$id_bloque,CURRENT_DATE,'$nombre_plantilla',1);";
       $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 1" );
	   if($regis){ return true; }else{ return false; }
	   }
       
	   public function actualizar_plantilla($id_plantilla,$id_bloque,$nombre_plantilla){
	   $nombre_plantilla = utf8_decode($nombre_plantilla);
	   $sql = "UPDATE cede.plantilla_apo SET  ensenanza = $id_bloque,
       nombre = '$nombre_plantilla' WHERE  id_plantilla = $id_plantilla;";
	   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Update 1" );
	   if($regis){ return true; }else{ return false; }
	   }
       
       public function eliminar_plantilla($id_plantilla){
	   $sql = "DELETE FROM cede.plantilla_apo WHERE id_plantilla= $id_plantilla;";
       $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Delete 1" );
	   if($regis){ return true; }else{ return false; }
	   }
       //*************FIN**************///
    
	
		public function Meses($x){
			switch ($x){
				case 2:
					echo "Febrero";
					break;
				case 3:
					echo "Marzo";
					break;	
				case 4:
					echo "Abril";
					break;		
				case 5:
					echo "Mayo";
					break;		
				case 6:
					echo "Junio";
					break;		
				case 7:
					echo "Julio";
					break;		
				case 8:
					echo "Agosto";
					break;		
				case 9:
					echo "Septiembre";
					break;			
				case 10:
					echo "Octubre";
					break;		
				case 11:
					echo "Noviembre";
					break;			
				case 12:
					echo "Diciembre";
					break;																								
			}
		}
		
		public function DiasHabiles($ano,$mes){
			
			$sql="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
			$rs_ano = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error".$sql );
			$nro_ano = pg_result($rs_ano,0);
			
			$sql="SELECT fecha_inicio FROM periodo WHERE id_ano=".$ano." AND (nombre_periodo='PRIMER SEMESTRE' OR nombre_periodo='PRINER TRIMESTRE')";
			$rs_periodo = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error".$sql );
			$fecha_inicio = pg_result($rs_periodo,0);
			$dia_inicio = substr($fecha_inicio,8,2);
			$mes_inicio = substr($fecha_inicio,5,2);
			
			if($mes==5 || $mes==7 || $mes==8 || $mes==10){
				$dia=31;
			}elseif($mes==4 || $mes==6 || $mes==9 || $mes==11){
				$dia=30;
			}elseif($mes==12){
				$dia=31;		
			}elseif($mes==2){
				if($mes_inicio==03){
					$dia=0;
				}else{
					$dia=28;
				}
			}elseif($mes==3){
				if($mes_inicio==03){
					$dia = 31 - $dia_inicio;	
				}else{
					$dia=31;
				}
			}
			
			for($i=1;$i<=$dia;$i++){
				$semana=date("l",mktime(0,0,0,$mes,$i,$ano));
				if($semana=="Sunday" OR $semana=="Saturday"){
					$cuentanohabil++;
				}
			}
			$diashabiles = $dia - $cuentanohabil;
			return($diashabiles);
				
		}
	
		public function Atrasos($mes,$alumno,$ano){
			$sql="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
			$rs_ano = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error".$sql );
			$nro_ano = pg_result($rs_ano,0);
			
			$sql="SELECT case when (jornada=1) then count(jornada) else 0 end as manana,
	   CASE	when (jornada=2) then count(jornada) else 0 end as tarde FROM anotacion WHERE tipo=2 AND rut_alumno=".$alumno." AND date_part('month',fecha)=".$mes." AND date_part('year',fecha)=".$nro_ano." GROUP BY jornada";
			$rs_atraso = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error".$sql );
						
			return $rs_atraso;
		}

	
		public function Asistencia($mes,$alumno,$ano){
			$sql = "SELECT count(*) as cantidad FROM asistencia WHERE ano=".$ano." AND rut_alumno=".$alumno." AND date_part('month',fecha)=".$mes;
			$result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error".$sql );
			
			return $result;
				
		}
		
		public function ano_escolar($ano){
			$sql="SELECT nro_ano FROM ano_Escolar WHERE id_ano=".$ano;
			$result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error".$sql );
			$nro_ano = pg_result($result,0);
			
			return $nro_ano;
			
		}
		
		public function Inasistencia($fecha,$alumno,$ano){
			$sql = "SELECT * FROM asistencia WHERE ano=".$ano." AND rut_alumno=".$alumno." AND fecha='".$fecha."'";
			$result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error".$sql );
			
			return $result;

		}
    } // FIN CLASS


?>