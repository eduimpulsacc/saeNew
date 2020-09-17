<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
//print_r($_POST);
require "../../class/Coneccion.class.php";

class Pautaeva {
	   
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
	 

public function cargadorportafolio($r,$a){
	
$sql = "SELECT rut_evaluado,id_ano,id_documento,nombre_archivo,tipo_archivo,td.nombre as tipo_doc
FROM evados.eva_portafolio 
  inner join evados.eva_tipo_doc as td on td.id_tipo = id_documento
  WHERE rut_evaluado = $r AND id_ano = $a;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error EEEE1" );
		if($regis){
		 return $regis;
		}else{
		return false;
		}	
	
	}
	 
	 
	public function evaluadosporevaluador($r,$a,$i,$periodo){
	
	
		$sql ="SELECT id_ano FROM evados.eva_ano_Escolar WHERE id_institucion=".$i." AND situacion=1";
		$rs_ano = pg_Exec( $this->Conec->conectar(),$sql ) or die( $sql );
		$fila = pg_fetch_array($rs_ano,0);
		//$_SESSION['_ANO'] = $fila['id_ano'];
		$a=$fila['id_ano'];
		
		$sql = "SELECT distinct v.id_bloque as 
		bloqueevaluador,e.id_cargo as idcargoevaluador ,e.rut_evaluador,w.rut_evaluado,UPPER(q.ape_pat) as 
		ape_pat,UPPER(q.ape_mat) as ape_mat,UPPER(q.nombre_emp) as 
		nombre_emp,c.id_cargo,c.nombre_cargo,a.fecha_evaluacion FROM evados.eva_evaluador e
		INNER JOIN evados.eva_relacion_evaluacion as a on a.rut_evaluador = e.rut_evaluador and e.id_cargo = 
		a.id_cargo and a.id_ano = $a 
		INNER JOIN evados.eva_evaluado as w on w.rut_evaluado = a.rut_evaluado and w.id_cargo = a.cargo_evaluado 
		and w.id_ano = $a
		INNER JOIN empleado q on q.rut_emp = w.rut_evaluado
		INNER JOIN trabaja t on t.rut_emp = q.rut_emp and t.rdb = $i
		INNER JOIN cargos c on c.id_cargo = w.id_cargo 
		INNER JOIN evados.eva_bloque_evaluador v on v.rut_evaluador = e.rut_evaluador AND v.id_cargo = e.id_cargo
		WHERE e.rut_evaluador = $r  AND e.id_ano = $a AND w.id_ano = $a AND v.id_periodo=$periodo ORDER BY ape_pat ASC";

        $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( $sql );
		
		/*if($r==10139802){
		echo "<pre>";
		echo $sql;
		echo "</pre>";
		}*/
		
	    if($regis){  return $regis; }else{ return false; }
			
      } // fin metodo

   
   public function fechas_periodo_evaluacion($anio){
   			
   $sql = "SELECT CASE WHEN CURRENT_DATE  BETWEEN eee.fecha_inicio AND eee.fecha_termino 
					  THEN 1 ELSE 0 END as bool,eee.id_periodo   
					  FROM evados.eva_periodos_evaluacion eee
					  INNER JOIN periodo p ON p.id_periodo = eee.id_periodo 
					  WHERE eee.id_anio = $anio and eee.id_periodo in (
					  SELECT CASE WHEN CURRENT_DATE BETWEEN p.fecha_inicio AND p.fecha_termino 
					  THEN p.id_periodo ELSE 0 END as periodo
					  FROM periodo p WHERE p.id_ano = $anio )";
     
     $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error. 2");
     
     return $regis;
             	
      }


public function putaevaluacion($_rutevador,$_rutevado,$_cargo_evaluado,$_cargo_evaluador,$_bloqueevaluador,$id_nacional,$id_ano){
		
		//$connP=pg_connect("dbname=coi_final_vina host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conex Coi_Usuario");	
		
		$connP=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conex Coi_Usuario");	
        $result2 = $this->fechas_periodo_evaluacion($id_ano);
		$fila_validafechaperiodo = pg_fetch_array($result2,0);
		$idperiodo = $fila_validafechaperiodo['id_periodo']; 


	if($_rutevador==$_rutevado){
		
	   
	    /* $s = "SELECT id_bloque,nombre,porcentaje,autoeva
					FROM  evados.eva_bloque WHERE autoeva=1 ;";*/
			 $s = "SELECT id_bloque,nombre,porcentaje,autoeva
					FROM  evados.eva_bloque WHERE id_bloque = $_bloqueevaluador";		
					
			//$reg = pg_Exec($this->Conec->conectar(),$s) or die( "Error bd Select 0" );
			$reg = pg_Exec( $this->Conec->conectar(),$s) or die( "Error bd Select 0" );
	        
			if($reg){
				$fil = pg_fetch_array($reg,0);
				$_bloqueevaluador = $fil[0];
				}
	  
	         }
			 
			 
	
		/*if($_cargo_evaluado==5 and $id_ano!=1282){
			$sql ="SELECT * FROM supervisa s INNER JOIN curso c ON s.id_curso=c.id_curso WHERE rut_emp=".$_rutevado." AND c.id_ano=".$id_ano."";
			//$rs_existe = pg_exec($this->Conec->conectar(),$sql ) or die( "Error bd Select profesor jefe" );
			$rs_existe = pg_exec($connP,$sql ) or die( "Error bd Select profesor jefe" );
			
			if(pg_numrows($rs_existe)>0){
				$_cargo_evaluado=102;	
			}
		}*/

	    // evpa.id_bloque = corresponde al cargo que tenga el evaluado :) por pcardenas
	       $sql = "select evpa.id_plantilla,evpa.nombre from evados.eva_plantilla evpa where evpa.id_bloque = $_cargo_evaluado and evpa.id_nacional=$id_nacional;";
		//$regis0 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 1" );
		//echo pg_dbname($conn);
		$regis0 = pg_Exec(  $this->Conec->conectar(),$sql ) or die( "Error bd Select 1" );
		
		
		  if( pg_num_rows($regis0)!=0 ){
			
			$fila = pg_fetch_array($regis0,0);
			
			$nombre_plantilla = $fila['nombre'];
			$id_plantilla = $fila['id_plantilla'];
			$cont_select=0; // variable contador de elemenst
			
		  }else{

		   echo "<br/><h2>".htmlentities("Este Cargo no Tiene Pauta de Evaluación Creada",ENT_QUOTES,'UTF-8')."</h2>";
		   return false;

		  }
		
		/// LIMPIO LA TABLA DE EVALUACION
		$sql = "DELETE FROM evados.eva_plantilla_evaluacion WHERE 
		id_plantilla = $id_plantilla and rut_evaluador = $_rutevador and rut_evaluado = $_rutevado and 
		id_ano = $id_ano and id_cargo_evaluado = $_cargo_evaluado and id_cargo_evaluador = $_cargo_evaluador ";
		//$rs = pg_Exec( $this->Conec->conectar(),$sql ) or die( pg_last_error($this->Conec->conectar()) );
		$rs = pg_Exec( $this->Conec->conectar(),$sql ) or die( pg_last_error($this->Conec->conectar()) );
		
		
		$table = "<form id='evaluacion_patoc' name='evaluacion_patoc' >
		
		<input type='hidden' name='tableevaluacion' id='tableevaluacion'  value='1'/>
		
		<input type='hidden' name='_cargo_evaluado' id='_cargo_evaluado'  value='".$_cargo_evaluado."'/>
		<input type='hidden' name='_cargo_evaluador' id='_cargo_evaluador'  value='".$_cargo_evaluador."'/>
		<br>
		<table border=1 style='border-collapse:collapse' id='descripcion' align='center' >
		<tr bgcolor='#CCCCFF' >
		<th>Sigla</th>
		<th>Categoria</th>
		<th>Concepto</th>
		<th>Critico</th>
		<tr>";
       
	     $sql = "SELECT * FROM evados.eva_concepto WHERE id_nacional = ".$id_nacional." and estado=1 ORDER BY orden;";
		//$regis44 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 55");
		$regis44 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 55");
	     
		 for($a=0;$a<pg_numrows($regis44);$a++){ 
		 
		 $fila44 = pg_fetch_array($regis44,$a);
		 
		 if($fila44['critico']==1){
			  
			  $co = "bgcolor='#FFFFCC'";
			  $cri = "No Puede Contestar Mas de el 5% de la Encuesta Con este Concepto";
			  $id_campo_critico = '<input type="hidden" id="id_campo_critico"  value="'.$fila44['id_concepto'].'"/>';
			  $nombre_campo_critico = '<input type="hidden" id="nombre_campo_critico"  value="'.$fila44['categoria'].'"/>';
			
			}	 
		 
		 $table .=  "<tr $co >
		                     <td>".$this->tilde($fila44['sigla'])."</td>
		                     <td>".$this->tilde($fila44['categoria'])."</td>
							 <td>".$this->tilde($fila44['concepto'])."</td>
							 <td>".$cri."</td>
							 </tr>";
				
				} // for 4
				
					$sql_nom="select nombre_emp ||' '|| ape_pat ||' '|| ape_mat as nombre_ampleado from empleado where rut_emp=".$_rutevado;
					//$res_emp=pg_Exec($this->Conec->conectar(),$sql_nom) or die("fallo emp ".$sql_nom);
					$res_emp=pg_Exec( $this->Conec->conectar(),$sql_nom) or die("fallo emp ".$sql_nom);
					$fila_emp=pg_fetch_array($res_emp,0);
					
				
		$table .= "</table><table align='center' id='nombre_evaluador'><tr><td><div><h5>Evaluando A : ".$fila_emp['0']."</h5></div></td></tr></table>";		
				
				
	   
		$table .= "$id_campo_critico$nombre_campo_critico
			 
			<div id='scroll' style='overflow:auto; background-color:#FFF;width:1100px;height:400px;' >
			<table border=1 style='border-collapse:collapse' align='center' id='vistaprevia'>
			<tr bgcolor='#C0C0C0' ><th colspan='5' ><h2>".$nombre_plantilla."</h2></th></tr>";

    		  $sql = "SELECT distinct epe.id_area,epn.id_plantilla,epe.nombre,eib.id_bloque 
			FROM evados.eva_plantilla_area  epe
			INNER JOIN evados.eva_plantilla_nacional epn ON epe.id_area=epn.id_area
			INNER JOIN evados.eva_item_bloque eib on eib.id_area = epn.id_area and eib.id_bloque = ".$_bloqueevaluador."
			WHERE epn.id_plantilla = ".$id_plantilla."; ";
			


		//$regis1 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		$regis1 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );

		  if($regis1){

			  for($e=0;$e<pg_numrows($regis1);$e++){

				$fila = pg_fetch_array($regis1,$e);
				$nombre_area = $fila['nombre'];
				$id_area = $fila['id_area'];
				$id_plantilla = $fila['id_plantilla'];
				
				$table .= "<tr bgcolor='#FFFFCC' ><td colspan='1'>&nbsp;>&nbsp;</td><td colspan='2'  ><strong>".$nombre_area."</strong></td></tr>";

				/*$sql = "SELECT distinct epn.id_plantilla,epn.id_area,eps.id_subarea,eps.nombre,eib.id_bloque  
				FROM evados.eva_plantilla_subarea as eps
				INNER JOIN evados.eva_plantilla_nacional epn ON epn.id_area = ".$id_area." AND eps.id_subarea=epn.id_subarea
				INNER JOIN evados.eva_item_bloque eib on  eib.id_area = ".$id_area."  AND eib.id_subarea = epn.id_subarea and eib.id_bloque = ".$_bloqueevaluador." 
				WHERE epn.id_plantilla =".$id_plantilla.";";*/
				$sql= "SELECT DISTINCT id_plantilla,id_area,eps.id_subarea,nombre,id_bloque 
				FROM evados.eva_item_bloque eib INNER JOIN evados.eva_plantilla_subarea eps ON  eib.id_subarea=eps.id_subarea 
				WHERE eib.id_plantilla=".$id_plantilla." and eib.id_area=".$id_area." and id_bloque=".$_bloqueevaluador."";
				 
			  	//$regis2 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 3" );
				$regis2 = pg_Exec( $this->Conec->conectar(),$sql) or die( "Error bd Select 3" );
			
			  if($regis2){
					
			  for($t=0;$t<pg_numrows($regis2);$t++){
					  
			  $fila = pg_fetch_array($regis2,$t);
			  $nombre_subarea = $fila['nombre'];
			  $id_subarea = $fila['id_subarea'];
				  
			  $table .= "<tr><td>&nbsp;&nbsp;</td><td colspan='2' bgcolor='#CCCCFF' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;><strong>".$nombre_subarea."&nbsp;&nbsp;&nbsp;</strong></td></tr>";
			
			 $sql_1 = "SELECT epn.id_plantilla,epn.id_area,epn.id_subarea,epi.id_item,epi.nombre,eib.id_bloque 
			FROM evados.eva_plantilla_item epi
			INNER JOIN evados.eva_plantilla_nacional epn ON  epn.id_area = ".$id_area."  and epn.id_subarea = ".$id_subarea."  and epn.id_item = epi.id_item 
			INNER JOIN evados.eva_item_bloque eib on eib.id_item = epi.id_item and eib.id_bloque = ".$_bloqueevaluador." AND eib.id_area = epn.id_area 
			AND eib.id_subarea = epn.id_subarea  AND eib.id_plantilla = epn.id_plantilla 
			WHERE epn.id_plantilla = ".$id_plantilla."; ";	
		
			
			//$regis3 = pg_Exec( $this->Conec->conectar(),$sql_1 ) or die( "Error bd Select 4" );
			$regis3 = pg_Exec( $this->Conec->conectar(),$sql_1 ) or die( "Error bd Select 4" );

				     for($q=0;$q<pg_numrows($regis3);$q++){ 
							
					     $fila = pg_fetch_array($regis3,$q);
						 $id_plantilla=$fila['id_plantilla'];
						 $id_area=$fila['id_area'];
						 $id_subarea=$fila['id_subarea'];
						 $id_item=$fila['id_item'];

$table .= "<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>&nbsp;".$fila['nombre']."&nbsp;&nbsp;&nbsp;</td>";
		 
		 $sql_2 = "SELECT * FROM evados.eva_concepto 
		 WHERE id_nacional = ".$id_nacional." and estado=1 ORDER BY orden;";
				
				//$regis4 = pg_Exec( $this->Conec->conectar(),$sql_2 ) or die( "Error bd Select 5 :".$sql_2 );
				$regis4 = pg_Exec( $this->Conec->conectar(),$sql_2 ) or die( "Error bd Select 5 :".$sql_2 );
				
					$cont_select++; 
				
					$table .= '<td width="180px">';
   											
	for($a=0;$a<pg_numrows($regis4);$a++){
		 
	$fila = pg_fetch_array($regis4,$a);								
   
   $table .=  '<label>
   <input type="radio" name="conceptos['.$cont_select.']" value="'.$fila['id_concepto'].'" id="conceptos['.$cont_select.']">'.$fila['sigla'].'</label>';
						
						} // for 4			  

$table .=  '<input type="radio" name="conceptos['.$cont_select.']" value="0" id="conceptos['.$cont_select.']" checked="checked"  style="visibility:hidden;" >';
				
$table .= '<input type="hidden" id="ids_pauta['.$cont_select.']" name="ids_pauta['.$cont_select.']"  value="  '.$id_plantilla.','.$id_area.','.$id_subarea.','.$id_item.','.$_rutevador.','.$_rutevado.','.$idperiodo.','.$_cargo_evaluado.','.$_cargo_evaluador.'" /></td></tr>';
					 
					 } // for 3
				  
				  } // for 2
				  
				  }else{
				  
				  		echo "No Encontrado";
				  
				  } 
			 
			 } // for 1 
			 
		  }else{
	
		   echo "No Encontrado";
	
		  }

		$table .= "</table></div>";
	
		$cantidad_critica = $cont_select*(5/100);
		$table .= "<input type='hidden' id='cantidad_critica' value='".round($cantidad_critica)."' />";
	
		$table .="</form>";
 	
		echo $table;
	  
	   } // fin metodo
	
	
	
	
public function insert_evaluacion($datos,$id_conce,$a,$_cargo_evaluado,$_cargo_evaluador,$periodo){

$sql_insert = "INSERT INTO evados.eva_plantilla_evaluacion(id_plantilla,id_area,id_subarea,id_item,  
id_concepto,rut_evaluador,rut_evaluado,id_ano,id_cargo_evaluado,id_cargo_evaluador,ip_periodo) 
VALUES (".$datos[0].",".$datos[1].",".$datos[2].",".$datos[3].",".$id_conce.",".$datos[4].",".$datos[5].",".$a.",".$_cargo_evaluado.",".$_cargo_evaluador.",".$periodo.");";// SE DEBE ELIMINAR EL CAMPO EN DURO Y AGREGAR ESTA VARIABLE ".$datos[6]." DESPUES QUE SE TERMINE EL PROCESO DE EVALUACION EN EL COLEGIO ELISA LATAPPIAT (EDUARDO ROJAS 26-12)

$regis = pg_Exec($this->Conec->conectar(),$sql_insert) or die($sql_insert);  
	    
		if($regis){
			   return true;
			}else{
		       return false;
		    }		
		
		}
	
	public function fechaevaluacion($a,$b,$c,$d,$e){
		//MOFICACION QUE PERMITE DIFERENCIAR LAS PAUTAS QUE SE VAN A EVALUAR
			$sql_update = "UPDATE evados.eva_relacion_evaluacion SET fecha_evaluacion = CURRENT_DATE
			WHERE id_ano = ".$a." AND rut_evaluado = ".$b." AND rut_evaluador = ".$c." AND cargo_evaluado=".$d."
			 AND id_cargo=".$e.";";
			$regis = pg_Exec($this->Conec->conectar(),$sql_update) or die( "Error:".$sql_update );
		      	    
					if($regis){
						return true;
					}else{
					    return false;
					}	
					
    		}
	
	
	
	
	
	 public 	function tilde($campo){

		$dato="";
		
		for($s=0;$s<=strlen($campo);$s++){
			
			$letra = substr($campo,$s,1);
			
			if($s==0){
				
			  if($letra=="á"){
			    $dato .= str_replace("á","Á",$letra);
			   }else if($letra=="é"){
			    $dato .= str_replace("é","é",$letra);
			   }else if($letra=="í"){
			    $dato .= str_replace("í","Í",$letra);
			   }else if($letra=="ó"){
			    $dato .= str_replace("ó","Ó",$letra);
			   }else if($letra=="ú"){
			    $dato .= str_replace("ú","Ú",$letra);
			   }else if($letra=="ñ"){
			    $dato .= str_replace("ñ","Ñ",$letra);	
			   }else{
				$dato .= strtoupper($letra); //MAYUSCULA
				 }
			   
			 }else{
				 
			   if($letra=="Á"){
			    $dato .= str_replace("Á","á",$letra);
			   }else if($letra=="É"){
			    $dato .= str_replace("É","é",$letra);
			   }else if($letra=="Í"){
			    $dato .= str_replace("Í","í",$letra);
			   }else if($letra=="Ó"){
			    $dato .= str_replace("Ó","ó",$letra);
			   }else if($letra=="Ú"){
			    $dato .= str_replace("Ú","ú",$letra);
			   }else if($letra=="Ñ"){
			    $dato .= str_replace("Ñ","ñ",$letra);
			   }else if($letra=="á"){
			    $dato .= str_replace("á","á",$letra);
			   }else if($letra=="é"){
			    $dato .= str_replace("é","é",$letra);
			   }else if($letra=="í"){
			    $dato .= str_replace("í","í",$letra);
			   }else if($letra=="ó"){
			    $dato .= str_replace("ó","ó",$letra);
			   }else if($letra=="ú"){
			    $dato .= str_replace("ú","ú",$letra);
			   }else if($letra=="ñ"){
			    $dato .= str_replace("ñ","ñ",$letra);	
			   }else{
				$dato .= strtolower($letra); // MINUSCULA
				 }
				 
				 }
			 
			}//for
		   
		   return $dato;
	   		   
	     }
	public function cargos($cargo){
		$sql="SELECT nombre_cargo FROM cargos WHERE id_cargo=".$cargo;
		$result = pg_Exec($this->Conec->conectar(),$sql) or die( "Error:".$sql );
		$cargo_evaluador = pg_result($result,0);
		
		return $cargo_evaluador;	      	    	
	}
	
	
	public function EliminaRelacion($rutevaluado,$rut_evaluador,$cargoevaluado,$cargoevaluador,$periodo){
		$sql = "DELETE FROM evados.eva_relacion_evaluacion WHERE id_periodo=".$periodo." AND rut_evaluado=".$rutevaluado."
						AND rut_evaluador=".$rut_evaluador." AND id_cargo=".$cargoevaluador." AND cargo_evaluado=".$cargoevaluado;
		$result = pg_Exec($this->Conec->conectar(),$sql) or die( "Error:".$sql );
		
		return $result;		
	}
	
	}  //Fin Funcion 



	
?>

