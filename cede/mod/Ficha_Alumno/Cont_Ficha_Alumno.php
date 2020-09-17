<?   header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();

require "Mod_Ficha_Alumno.php";

$objMembrete= new Membrete($_IPDB,$_ID_BASE);

$Obj_Ficha_Alumno = new Ficha_Alumno($_IPDB,$_ID_BASE);

$funcion = $_POST['funcion'];
$este_ano = $_POST['select_an_escolar'];

if(isset($_POST['ficha'])) $numero_ficha = $_POST['ficha'];
if(isset($_GET['ficha'])) $numero_ficha = $_GET['ficha'];

if(isset($_POST['caso'])) $caso = $_POST['caso'];
if(isset($_GET['caso'])) $caso = $_GET['caso'];



//echo print_r($_POST)


      /*CARGA ANOS*/
	  if($funcion==1){
		  
	    $result = $Obj_Ficha_Alumno->Carga_Anos($_INSTIT);
		if($result){
		$select = "<span>".htmlentities("Seleccionar Año :",ENT_QUOTES,'UTF-8')."</span>
		<select name='select_an_escolar' id='select_an_escolar' onchange='carga_curso(this.value)' style='margin-left:28px' >
		<option value='0' select='select'  >Selecccionar</option>";
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			if ($fila['situacion'] == 0){ $estado = "Cerrado"; }
			if ($fila['situacion'] == 1){ $estado = "Abierto"; }
			$select .= "<option value=".$fila['id_ano'].">".$fila['nro_ano']."&nbsp;(".ucwords(strtolower(htmlentities(trim($estado)))).")</option>";
		 }  
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;	
		 }
     } 

     
	 /*CARGA CURSOS*/
	  if($funcion==2){
	    $result = $Obj_Ficha_Alumno->Carga_Cursos($_POST['an_escolar']); 
		if($result){
		 $select =  '<span>Seleccionar Cursos :</span><select name="select_curso" id="select_curso" onChange="carga_alumno(this.value)" style="margin-left:8px" >
         <option value=0 selected>Selecccionar</option>';
		  for($i=0 ; $i < @pg_numrows($result ) ; $i++){  
		  $fila = @pg_fetch_array($result ,$i); 
   		  $Curso_pal = $objMembrete->CursoPalabra($fila['id_curso'],1);
	      $select  .=  "<option value=".$fila['id_curso'].">".ucwords(strtolower(htmlentities(trim($Curso_pal))))." </option>";
		       } 
		$select .= "</select>";
		echo $select;
		}else{
		 echo 0;	
		}
     } 
		
	  /*CARGA ALUMNOS*/
	  if($funcion==3){
		  
		$result = $Obj_Ficha_Alumno->Carga_Alumnos($_POST['id_curso'],$_POST['id_ano']); 
		
		if($result){
		  $select =  '<span>Seleccionar Alumnos :</span><select name="select_alumnos" id="select_alumnos" 
		  onChange="Buscar_Ficha_Alumno(0,1)" style="margin-left:1px">
          <option value=0 selected>Selecccionar</option>';
		for($i=0 ; $i < @pg_numrows($result ) ; $i++){  
  		   
		  $fila = @pg_fetch_array($result ,$i); 
		    
		  $nombre  = ucwords(strtolower(htmlentities(trim($fila["ape_pat"]))));
	      $nombre .= "&nbsp;".ucwords(strtolower(htmlentities(trim($fila["ape_mat"]))));
	      $nombre .= "&nbsp;".ucwords(strtolower(htmlentities(trim($fila["nombre_alu"]))));
		 
          $select  .=  "<option value=".trim($fila["rut_alumno"]).">".$nombre." </option>";
		 
		  }
		$select .= "</select>";
		echo $select;
		}else{
	    echo 0;	
		}
     } 
	 
	 

switch ($numero_ficha) {
	
	case '0':
	 	
	$result = $Obj_Ficha_Alumno->Buscar_Alumno($_POST['rut_alumno']); 
	if($result){
		if(pg_numrows($result )>0){
			  $fila = @pg_fetch_array($result ,0); 
			   
			  $ape_pat  = ucwords(strtolower(htmlentities(trim($fila["ape_pat"]))));
			  $ape_mat = ucwords(strtolower(htmlentities(trim($fila["ape_mat"]))));
			  $nombre  = ucwords(strtolower(htmlentities(trim($fila["nombre_alu"]))));
			  $rut_alumno = trim($fila["rut_alumno"]);
			  $dig_rut = trim($fila["dig_rut"]); 

			  $fila["id_curso"];
			  $fila["nro_lista"]; 
			  $fila["bool_ar"];
			  $fila["num_mat"];	
					
			}
		}	
	  
   $ficha  =  '<table>
	        <tr class="color_fondo">
              <td colspan="3">Rut Alumno</td>
            </tr>
            <tr>
              <td colspan="3">'.$rut_alumno.'-'.$dig_rut.'</td>
            </tr>
            <tr class="color_fondo">
              <td  width="40%" >Nombre</td>
              <td  width="40%" >A. Paterno</td>
              <td >A. Materno</td>
            </tr>
            <tr>
              <td>'.$nombre.'</td>
              <td>'.$ape_pat.'</td>
              <td>'.$ape_mat.'</td>
            </tr>
            <tr class="color_fondo" >
              <td>Fecha Nacimiento</td>
              <td>Sexo</td>
              <td>Nacionalidad</td>
            </tr>
            <tr>
              <td>'.$fila["fecha_nac"].'</td>
              <td>'.$fila["sexo"].'</td>
              <td>'.$fila["nacionalidad"].'</td>
            </tr>
            <tr  class="color_fondo">
              <td>Alumna Embarazada</td>
              <td colspan="2"  >Alumno(a) '.htmlentities("Indígena",ENT_QUOTES,'UTF-8').'</td>
            </tr>
            <tr>
              <td>'.$fila["ingestab"].'</td>
              <td colspan="2">'.$fila["ingestab"].'</td>
            </tr>
        </table>

        <table>
             <tr>
             <td colspan="3" class="color_fondo" >'.htmlentities("Dirección",ENT_QUOTES,'UTF-8').'</td>
            </tr>
            <tr class="color_fondo" >
              <td  width="40%">Calle</td>
              <td   width="40%" >Nro.</td>
              <td>Block</td>
            </tr>
            <tr>
              <td>'.$fila["calle"].'</td>
              <td>'.$fila["nro"].'</td>
              <td>0</td>
            </tr>
            <tr class="color_fondo" >
              <td >Departamento</td>
              <td >'.htmlentities("Villa / Población",ENT_QUOTES,'UTF-8').'</td>
              <td ></td>
            </tr>
            <tr>
              <td>'.$fila["depto"].'</td>
              <td></td>
              <td></td>
            </tr>
            <tr class="color_fondo">
              <td>'.htmlentities("Teléfono",ENT_QUOTES,'UTF-8').'</td>
              <td colspan="2" >E-mail</td>
            </tr>
            <tr>
              <td>'.$fila["telefono"].'</td>
              <td colspan="2">'.$fila["email"].'</td>
            </tr>
            <tr class="color_fondo" >
              <td>'.htmlentities("Región",ENT_QUOTES,'UTF-8').'</td>
              <td>Provincia</td>
              <td>Comuna</td>
            </tr>
            <tr>
              <td>'.$fila["nom_reg"].'</td>
              <td>'.ucwords(strtolower(htmlentities($fila["nom_pro"],ENT_QUOTES,'UTF-8'))).'</td>
              <td>'.ucwords(strtolower(htmlentities($fila["nom_com"],ENT_QUOTES,'UTF-8'))).'</td>
            </tr>
        </table>';
	
	$_SESSION['_RUT_ALUMNO']=$_POST['rut_alumno'];
        $_RUT_ALUMNO=$_SESSION['_RUT_ALUMNO'];
	    $_RUT_ALUMNO;
		
	if($_POST['rut_alumno']!="") echo $ficha;
	
	break;
		
	case '1':

	$result = $Obj_Ficha_Alumno->Buscar_Apoderados($_POST['rut_alumno']); 
	if($result){
		if(pg_num_rows($result )>0){
			 echo '<div id="accordion2">';
			 for($a=0;$a<pg_num_rows($result );$a++){
	         $fila = @pg_fetch_array($result ,$a); 
			 $sexo=$fila['sexo'];
			 $relacion=$fila['relacion'];
			 if($relacion==1){
				 $relacion="Padre";
			 }else{
				 $relacion="Madre";
				 }
				 
			 if($sexo==1){
				 $sexo="Femenino";
				 }else{
					 $sexo="Masculino";
					 }

			$fila['region'];$fila['ciudad'];$fila['id_usuario'];$fila['foto'];$fila['celular'];$fila['nom_foto'];$fila['nivel_social'];
				
	 echo '	<h3><a href="#">'.$fila['nombre_apo'].' '.ucwords(strtolower(htmlentities($fila['nombre_apo'],ENT_QUOTES,'UTF-8'))).'&nbsp;'.ucwords(strtolower(htmlentities($fila['ape_pat'],ENT_QUOTES,'UTF-8'))).'&nbsp;'.ucwords(strtolower(htmlentities($fila['ape_mat'],ENT_QUOTES,'UTF-8'))).' '.$fila['ape_mat'].'</a></h3>
	<div>
      <table>
          <tr>
		  <td class="color_fondo">Rut</td>
          <td colspan="2" >'.$fila['rut_apo'].'-'.$fila['dig_rut'].'</td>
		  </tr>
           <tr class="color_fondo" >
		  <td >Nombres</td>
          <td>Apellido Paterno</td>
          <td>Apellido Materno</td>
		  </tr>
		 <tr>
          <td>'.$fila['nombre_apo'].' '.ucwords(strtolower(htmlentities($fila['nombre_apo'],ENT_QUOTES,'UTF-8'))).'</td>
          <td>'.ucwords(strtolower(htmlentities($fila['ape_pat'],ENT_QUOTES,'UTF-8'))).'</td>
          <td>'.$fila['ape_mat'].' '.ucwords(strtolower(htmlentities($fila['ape_mat'],ENT_QUOTES,'UTF-8'))).'</td>
        </tr>
		<tr class="color_fondo">
          <td>Fecha de Nacimiento</td>
          <td>Sexo</td>
          <td>Nacionalidad</td>
        </tr>
        <tr>
          <td>'.$fila['fecha_nac'].'</td>
          <td>'.$sexo.'</td>
          <td>'.$fila['nacionalidad_apo'].'</td>
        </tr>
        <tr class="color_fondo">
          <td colspan="3">'.htmlentities("Dirección",ENT_QUOTES,'UTF-8').'</td>
        </tr>
        <tr class="color_fondo">
          <td>Calle</td>
          <td>Nro</td>
          <td>Block</td>
        </tr>
        <tr>
          <td>'.$fila['calle'].'</td>
          <td>'.$fila['nro'].'</td>
          <td>'.$fila['block'].'</td>
        </tr>
        <tr  class="color_fondo">
          <td >Dpto.</td>
          <td>'.htmlentities("Villa / Población",ENT_QUOTES,'UTF-8').'</td>
          <td>Comuna</td>
        </tr>
        <tr>
          <td>'.$fila['depto'].'</td>
          <td>'.$fila['villa'].'</td>
          <td>'.ucwords(strtolower(htmlentities($fila["nom_com"],ENT_QUOTES,'UTF-8'))).'</td>
        </tr>
        <tr class="color_fondo" >
          <td >'.htmlentities("Teléfono",ENT_QUOTES,'UTF-8').'</td>
          <td>E-mail</td>
          <td>'.htmlentities("Relación",ENT_QUOTES,'UTF-8').'</td>
        </tr>
        <tr>
          <td>'.$fila['telefono'].'</td>							
          <td>'.$fila['email'].'</td>
          <td>'.$relacion.'</td>
        </tr>
        <tr class="color_fondo">
          <td >Nivel Educacional</td>
          <td>'.htmlentities("Profesión",ENT_QUOTES,'UTF-8').'</td>
          <td>Lugar de Trabajo</td>
        </tr>
        <tr>
          <td>'.$fila['nivel_edu'].'</td>
          <td>'.$fila['profesion'].'</td>
          <td>'.$fila['lugar_trabajo'].'</td>
        </tr>
		<tr class="color_fondo">
          <td  >Cargo</td>
          <td>'.htmlentities("Dirección Trabajo",ENT_QUOTES,'UTF-8').'</td>
          <td>Ingresos Familiares</td>
        </tr>
		<tr>
          <td>'.$fila['cargo_apo'].'</td>
          <td></td>
          <td>'.$fila['percapita'].'</td>
        </tr>
        <tr class="color_fondo" >
          <td ><div align="center">'.htmlentities("Ocupación Actual",ENT_QUOTES,'UTF-8').'</div></td>
          <td><div align="center">Grupo Familiar</div></td>
          <td><div align="center">Ingreso PerCapita</div></td>
        </tr>
        <tr>
          <td><div align="center">'.$fila['ocupacion'].'</div></td>
          <td><div align="center">'.$fila['grupo_familiar'].'</div></td>
          <td><div align="center">'.$fila['percapita'].'</div></td>
        </tr>
        <tr class="color_fondo" >
          <td colspan="3"><div align="center">'.htmlentities("Situación Familiar",ENT_QUOTES,'UTF-8').'</div></td>
        </tr>
        <tr>
          <td colspan="3"><div align="center">'.$fila['situacion_familiar'].'</div></td>
        </tr>
      </table>
 	</div>';				
            }
		  echo "</div>"; //**Fin Acordeon2**/	
		}else{
			echo "<p><h3>No Se Encontraron Resultados Para la Busqueda Indicada</h3></p>";
			}
	    }

	  
		break;
	
	case '2':
	
	$result = $Obj_Ficha_Alumno->Cursos_Solicitado($_POST['rut_alumno'],$este_ano);
	
		if($result){
		if(pg_num_rows($result )>0){
		    
			$fila = @pg_fetch_array($result,0); 
		        
			$Curso_pal = $objMembrete->CursoPalabra($fila['id_curso'],1);

			echo  '<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tbody>
			<tr class="color_fondo"  >
			  <td colspan="4">'.htmlentities("Antecedentes académicos",ENT_QUOTES,'UTF-8').'</td>
			</tr>
			<tr class="color_fondo"  >
			  <td>Curso</td>
			  <td>Fecha Matricula</td>
			  <td colspan="2">&nbsp;</td>
			</tr>
			<tr>
			  <td>'.ucwords(strtolower(htmlentities(trim($Curso_pal)))).'</td>
			  <td>'.$fila['fecha'].'</td>
			  <td></td>
			  <td></td>
			</tr>
			<tr class="color_fondo"  >
			  <td>Retirado</td>
			  <td>Fecha de Retiro</td>
			  <td>'.htmlentities("Religión",ENT_QUOTES,'UTF-8').'</td>
			  <td>Repitente del grado</td>
			</tr>
			<tr>
			  <td>'.$fila['bool_ar'].'</td>
			  <td>'.$fila['fecha_retiro'].'</td>
			  <td>';
			  
		// Busco el Año en que Esta:
	    $q1 = "select * from ano_escolar where id_ano = $este_ano ";
		$r1 = pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$q1);
		$f1 = pg_fetch_array($r1);
		$nro_ano = $f1['nro_ano'];
		
       $q2 = "select * from tiene$nro_ano , ramo where tiene$nro_ano.rut_alumno = '".$_POST['rut_alumno']."' and tiene$nro_ano.id_ramo = 
	   ramo.id_ramo and ramo.cod_subsector = '13'";
		$r2 = pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$q2);
		$n2 = pg_num_rows($r2);
		if ($n2 > 0){  // entonces opta a religión 
		    echo 'Opta';			
		}else{
		    echo 'No Opta';
		}
			  
			  echo '</td>
			  <td>'.$fila['bool_rg'].'</td>
			</tr>
			<tr class="color_fondo"  >
			  <td>Ev. Diferencial</td>
			  <td>Integrado</td>
			  <td></td>
			  <td></td>
			</tr>
			<tr>
			  <td>'.$fila['bool_ed'].'</td>
			  <td>'.$fila['bool_i'].'</td>
			  <td><div align="left"></div></td>
			  <td></td>
			</tr>
		  </tbody>
		</table>';
				
			
			}
		}
	
	break;
	
	case '3':
	
	$result = $Obj_Ficha_Alumno->Conducta($_POST['rut_alumno'],$este_ano);
	if($result){
		if(pg_num_rows($result )>0){
			
	echo   '<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tbody>
    <tr class="color_fondo">
      <td align="center" width="10%">FECHA</td>
      <td align="center" width="15%">RESPONSABLE</td>
      <td align="center" width="35%">TIPO ANOTACION</td>
      <td align="center" width="5%">ANOTACION</td>
    </tr>';
	
			$contador_positivas=0;
			$contador_negativas=0;
			for($s=0;$s<pg_num_rows($result);$s++ ){
				
			$fila = @pg_fetch_array($result,$s); 
			$ape_mat=$fila['ape_mat'];
	
  echo   '<tr>
      <td align="center"><strong>'.$fila["fecha"].'</strong></td>
      <td align="center"><strong>'.$fila['ape_pat'].' '.strtoupper($ape_mat[0]).'. '.
	  ucwords(strtolower(htmlentities($fila['nombre_emp'],ENT_QUOTES,'UTF-8'))).'</strong></td>
      
      <td align="center"><strong>';
	  
	    if($fila["codigo_tipo_anotacion"]==""){

		 if ($fila['tipo']==1){ echo "CONDUCTA"; 
		 if ($fila['tipo_conducta']==1){
			  
			  echo " POSITIVA"; 
			  $contador_positivas++;
			  }	 
		 if ($fila['tipo_conducta']==2){
			  echo " NEGATIVA"; 
			  $contador_negativas++;
			  
			  }
	    }
														
		if($fila['tipo']==2){
		echo "ATRASO";
		$contador_negativas++;
		}															
															
        if($fila['tipo']==3){
		echo "INASISTENCIA";
		$contador_negativas++;
		}
															
		if($fila['tipo']==4){
		echo "RESPONSABILIDAD";
		$contador_negativas++;
		}												
																											
		}else{ 
		
		$cod_ta = $fila['codigo_tipo_anotacion'];													   
		$q1 = "select * from tipos_anotacion where id_tipo = '$cod_ta'";
		$r1 = @pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$q1)or die("Fallo anotacion".$q1);
		if($r1){
		$f1 = @pg_fetch_array($r1,0);
		$codta= $f1['codtipo'];
		$descripcion	= $f1['descripcion'];
		 $tipo2	= $f1['tipo'];
								   
		   if ($tipo2==1){
			   $contador_positivas++;
		   }
		   if ($tipo2==2){
			   $contador_negativas++;
		   }	   	   
		echo"$codta - $descripcion";  
		 }
	  }
	  echo '</strong></td>
	  

		  <td width="%" align="center"><div id="eldiv" ><strong>';
		 
		 ?>
         
         
         <img src="Class/PNG-32/Search.png" width="32" height="32" style="cursor:pointer" onclick="muestra_detalle('<?=$cod_ta?>','<?=$fila["codigo_anotacion"];?>','<?=$fila['id_anotacion'];?>')"/>
         
         
         <?
		
	  
	  echo  '</div></strong></td>
    </tr>';
	
		}
  
 echo  '</tbody></table> ';
 
 
 
 
 $dives = '<div id="div_a" class="curved">
	          <div >Anotaciones Positivas = '.$contador_positivas.'</div>
 			  <div >Anotaciones Negativas = '.$contador_negativas.'</div>
			  </div>';	
 
 	echo $dives;
 
	
			        
		}
	}
	
	break;
	
	case '4':
	
	
	 $qryB="SELECT * FROM MATRICULA WHERE RUT_ALUMNO='".$_POST['rut_alumno']."' AND RDB='".$_INSTIT."' AND ID_ANO='".$este_ano."' "; 
	         
	 $resultB =@pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$qryB);
	
	if (!$resultB) {
	 echo '<B> ERROR :</b>Error al acceder a la BD. (1)</B>';
	 }else{
		 if (pg_num_rows($resultB)!=0){

				$filaB = @pg_fetch_array($resultB,0);	

                 $AlJu = ($filaB['bool_baj']==0)?"NO":"SI";
				 $CenPad = ($filaB['bool_cpadre']==0)?"NO":"SI";
				 $Seg =   ($filaB['bool_seg']==0)?"NO":"SI";
				 $Otros = ($filaB['bool_otros']==0)?"NO":"SI";
				 $ChSol = ($filaB['bool_bchs']==0)?"NO":"SI";
				 $Munc =  ($filaB['bool_mun']==0)?"NO":"SI";
				 $AlSep = ($filaB['ben_sep']==1)?"SI":"NO";
				 
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tbody>
    <tr class="color_fondo" >
      <td>'.ucwords(strtolower(htmlentities("Alimentación Junaeb",ENT_QUOTES,'UTF-8'))).'</td>
      <td>C. de Padres</td>
    </tr>
    <tr>
      <td>'.$AlJu.'</td>
      <td>'.$CenPad.'</td>
    </tr>
    <tr class="color_fondo"  >
      <td >Seguro</td>
      <td>Otras</td>
    </tr>
    <tr>
      <td>'.$Seg.'</td>
      <td>'.$Otros .'</td>
    </tr>
    <tr>
      <td class="color_fondo" >Chile Solidario</td>
      <td>Municipal</td>
    </tr>
    <tr>
      <td>'.$ChSol.'</td>
      <td>'.$Munc.'</td>
    </tr>
    <tr class="color_fondo" >
      <td >Alumno SEP</td>
      <td></td>
    </tr>
    <tr>
      <td>'.$AlSep.'</td>
      <td></td>
    </tr>
  
    <tr class="color_fondo" >
      <td colspan="2">Becas de la Institucion</td>
    </tr>';
    
	$sql = "select id_beca,nomb_beca FROM becas_conf WHERE id_ano=".$este_ano." ORDER BY nomb_beca ASC";
  	$rs_beca = @pg_exec($Obj_Ficha_Alumno->Conec->conectar(),$sql);
	for($n=0;$n < @pg_numrows($rs_beca);$n++){
	
	$fila_beca = @pg_fetch_array($rs_beca,$n);
	
	$sql = "SELECT * FROM becas_benef 
	WHERE id_beca=".$fila_beca['id_beca']." AND rut_alumno=".$_POST['rut_alumno'];
	$rs_existe = @pg_exec($Obj_Ficha_Alumno->Conec->conectar(),$sql);
	
	?>
          <tr>
    <td width="20%" class="color_fondo" ><?=ucfirst(strtolower($fila_beca['nomb_beca']));?></td>
    <td><? if(@pg_numrows($rs_existe)>0) echo "SI"; else echo "NO";?></td>
  </tr>  
  <? } 

  echo '</tbody>
</table>';
						
	            }
            }  
										 

	break;
	
	case '5':
	          
			  $qryB="SELECT * FROM MATRICULA 
			  WHERE RUT_ALUMNO='".$_POST['rut_alumno']."' AND RDB='$_INSTIT' AND ID_ANO='$este_ano'"; 
			  $resultB =@pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$qryB);
				 
				 if (!$resultB) {
					 echo "Error al acceder a la BD. (1)";
				 }else{
					 if (pg_num_rows($resultB)!=0){
						 $filaB = @pg_fetch_array($resultB,0);	
						 if (!$filaB){
							 echo "Error al acceder a la BD. (2)";
						 }
					 }
				 } 
				   
				 ?>
                 
 <table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td class="color_fondo">Grupos</td>
   </tr>
  <tr>
    <td>
	<?	 
	
	$q1 = "select * from grupos, relacion_grupo where grupos.id_grupo = relacion_grupo.id_grupo and relacion_grupo.rut_integrante = '".trim($_POST['rut_alumno'])."' and grupos.rdb = '".trim($_INSTIT)."'";
			$r1 = pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$q1);
			$n1 = pg_num_rows($r1);
			?>
			21584908
	<td width="45%" ><div align="left">Nombre</div></td>
				<td width="45%" ><div align="left">Descripci&oacute;n</div></td>
   </tr>
				<?
				$i = 0;
				while ($i < $n1){
					 $f1 = pg_fetch_array($r1,$i);
					 $nombre      = $f1['nombre'];
					 $descripcion = $f1['descripcion'];
					 $id_aux      = $f1['id_aux'];
					 $id_grupo    = $f1['id_grupo'];
					 if ($nombre!=NULL){ ?>			    				 
						 <tr class="color_fondo" >
						 <td ><?=$nombre ?></td>
						 <td ><?=$descripcion ?></td>
						 </tr>
				  <? 
				           }
					 $i++;
				}
				?>	 
</table>
	<?
	break;
	case '6':
		$q1 = "SELECT * FROM tiene2 WHERE rut_alumno = '".trim($_POST['rut_alumno'])."'";
		$r1 = @pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$q1);
		$f1 = @pg_fetch_array($r1);
		$rut_apo = $f1['rut_apo'];
		$select_apo = "SELECT * FROM apoderado WHERE rut_apo = '$rut_apo'";
		$res_apo = @pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$select_apo);
		$fil_apo = @pg_fetch_array($res_apo);
		$nom_apo = $fil_apo['nombre_apo'];
		$ape_pat = $fil_apo['ape_pat'];
		$ape_mat = $fil_apo['ape_mat'];	
		?>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
          <td colspan="4"><div align="right">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr class="color_fondo" >
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
                APODERADO: <? echo "$nom_apo $ape_pat $ape_mat";  ?></font> </td>
              </tr>
            </table>
            </div></td>
		  </tr>
          <tr class="color_fondo" >
          <td width="15%" class="cuadro02"><div align="left">Fecha</div></td>
		  <td width="20%" class="cuadro02"><div align="left">Asunto</div></td>
		  <td width="60%" class="cuadro02"><div align="left">Descripci&oacute;n</div></td>
  </tr>
                <?
				$sql_1 = "SELECT * FROM entrevista WHERE rut_apo = '$rut_apo'";
				$r1    = @pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$sql_1);
				$n1    = @pg_numrows($r1);
				$i = 0;
				while ($i < $n1){
					 $f1 = pg_fetch_array($r1,$i);
					 $id_entrevista  = $f1['id_entrevista'];
					 $rut_alumno     = $f1['rut_alumno'];
					 $rut_apo        = $f1['rut_apo'];
					 $fecha          = $f1['fecha'];
					 $asunto         = $f1['asunto'];
					 $observaciones  = $f1['observaciones'];
					 $dd = substr($fecha,8,2);
					 $mm = substr($fecha,5,2);
					 $aa = substr($fecha,0,4);
					 $fecha = "$dd-$mm-$aa";					 
					 if ($rut_apo!=0){ ?>			    				 
                        <tr>
					      <td class="cuadro01"><?=$fecha ?></td>
					      <td class="cuadro01"><?=$asunto ?></td>
					      <td class="cuadro01"><?=$observaciones ?></td>
                       </tr>
                  <? 	}
		          $i++;
			  }
		    ?>	 
          </table>
	  <? 
	break;
	/*********************ficha medica*/
	case 7:
	  $sql_fim="select * from ficha_medica where rut_alumno=".trim($_POST['rut_alumno']);
	$r1    = @pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$sql_fim);
				$n1    = @pg_numrows($r1);
				$i = 0;
				while ($i < $n1){
					$f1 = pg_fetch_array($r1,$i);
					?>
                    <table width="100%">
                    <tr>
                    <td colspan="6" class="color_fondo">ANTECEDENTES GENERALES</td>
                    </tr>
                    <tr>
                      <td colspan="6" >&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" class="color_fondo">OFTANMOLOGIA</td>
                    </tr>
                    <tr>
                      <td colspan="6" >&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="5%" class="cuadro01"><?php echo ($f1['of_alta']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">ALTA</td>
                      <td width="5%" class="cuadro01"><?php echo ($f1['of_en_estudio']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">EN ESTUDIO</td>
                      <td width="5%" class="cuadro01"><?php echo ($f1['of_hipermetropia']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">HIPERMETROPIA</td>
                      </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['of_miopia']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">MIOPIA</td>
                      <td class="cuadro01"><?php echo ($f1['of_astigmatismo_miope']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">ASTIGMATISMO MIOPE</td>
                      <td class="cuadro01"><?php echo ($f1['of_astigmatismo_hipermetrope']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">ASTIGMATISMO HIPERMETROPE</td>
                    </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['of_astigmatismo_mixto']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">ASTIGMATISMO MIXTO</td>
                      <td class="cuadro01"><?php echo ($f1['of_astigmatismo_miopito_comp']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">ASTIGMATISMO MIOPITO COMP</td>
                      <td class="cuadro01"><?php echo ($f1['of_astigmatismo_hipermetria_c']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">ASTIGMATISMO HIPERMETRIA COMP</td>
                    </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['of_anisometropia']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">ANISOMETROPIA</td>
                      <td class="cuadro01"><?php echo ($f1['of_estrabismo']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">ESTRABISMO</td>
                      <td class="cuadro01"><?php echo ($f1['of_influencia_convergencia']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">INFLUENCIA CONVENGENCIA</td>
                    </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01">OTRO: <?php echo $f1['of_otros_desc'] ?></td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="4" class="cuadro01">&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="6" align="center" class="cuadro01">INDICACIONES</td>
                      </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">&nbsp;</td>
                      </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['of_lentes_primera_vez']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">LENTES PRIMERA VEZ</td>
                      <td class="cuadro01"><?php echo ($f1['of_cambiar_lentes']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">CAMBIAR LENTES</td>
                      <td class="cuadro01"><?php echo ($f1['of_mantener_lentes']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">MANTENER LENTES</td>
                    </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['of_estudio_estrabismo']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">ESTUDIO ESTRABISMO</td>
                      <td class="cuadro01"><?php echo ($f1['of_ejercicios_opticos']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">EJERCICIOS OPTICOS</td>
                      <td class="cuadro01"><?php echo ($f1['of_cirugia']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">CIRUGIA</td>
                    </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01">OTRO: <?php echo $f1['of_otros_desc_indic'] ?></td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="4" class="cuadro01">&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">&nbsp;</td>
                      </tr>
                      <tr>
                      <td colspan="6" class="color_fondo">OTORRINO</td>
                    </tr>
                    <tr>
                      <td colspan="6" >&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="5%" class="cuadro01"><?php echo ($f1['ot_alta']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">ALTA</td>
                      <td width="5%" class="cuadro01"><?php echo ($f1['ot_en_estudio']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">EN ESTUDIO</td>
                      <td width="5%" class="cuadro01"><?php echo ($f1['ot_agenesia_pabellon']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">AGENESIA PABELLON</td>
                      </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['ot_cerumen_impactado']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">CERUMEN IMPACTADO</td>
                      <td class="cuadro01"><?php echo ($f1['ot_mucosis_timpanica']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">MUCOSIS TIMPANICA</td>
                      <td class="cuadro01"><?php echo ($f1['ot_alta']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">HIPOACUSIA NEUROSENSORIAL</td>
                    </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01">OTRO: <?php echo $f1['ot_otros_desc'] ?></td>
                      </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="6" align="center" class="cuadro01">INDICACIONES</td>
                      </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">&nbsp;</td>
                      </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['ot_audiometria']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">AUDIOMETRIA</td>
                      <td class="cuadro01"><?php echo ($f1['ot_impedanciometria']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">IMPEDANCIOMETRIA</td>
                      <td class="cuadro01"><?php echo ($f1['ot_radiografia']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">RADIOGRAFIA</td>
                    </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['ot_medicamento']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">MEDICAMENTO</td>
                      <td class="cuadro01"><?php echo ($f1['ot_audifono']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">AUDIFONO</td>
                      <td class="cuadro01"><?php echo ($f1['ot_cirugia']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">CIRUGIA</td>
                    </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01">OTRO: <?php echo $f1['ot_otros_desc_indic'] ?></td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="4" class="cuadro01">&nbsp;</td>
                      </tr>
                       <tr>
                      <td colspan="6" class="color_fondo">ORTOPEDIA</td>
                    </tr>
                    <tr>
                      <td colspan="6" >&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="5%" class="cuadro01"><?php echo ($f1['or_alta']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">ALTA</td>
                      <td width="5%" class="cuadro01"><?php echo ($f1['or_en_estudio']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">EN ESTUDIO</td>
                      <td width="5%" class="cuadro01"><?php echo ($f1['or_pie_plano']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">PIE PLANO</td>
                      </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['or_genu_valgo_varo']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">GENU VALGO/VARO</td>
                      <td class="cuadro01"><?php echo ($f1['or_deform_adquir_dedos']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">DEFORM. ADQUIR. DEDOS</td>
                      <td class="cuadro01"><?php echo ($f1['or_escoliosis']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">ESCOLIOSIS</td>
                    </tr>
                    
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01">OTRO: <?php echo $f1['or_otros_desc'] ?></td>
                      </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="6" align="center" class="cuadro01">INDICACIONES</td>
                      </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">&nbsp;</td>
                      </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['or_cambiar_plantillas']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">CAMBIAR PLANTILLAS</td>
                      <td class="cuadro01"><?php echo ($f1['or_mantener_plantillas']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">MANTENER PLANTILLAS</td>
                      <td class="cuadro01"><?php echo ($f1['or_kinesiterapia']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">KINESIOTERAPIA</td>
                    </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['or_rx_extrem_inferiores']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">RX EXTREM INFERIORES</td>
                      <td class="cuadro01"><?php echo ($f1['or_rx_columna']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">RX COLUMNA</td>
                      <td class="cuadro01"><?php echo ($f1['or_corse']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">CORSE</td>
                    </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['or_cirugia']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">CIRUGIA</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01">OTRO: <?php echo $f1['or_otros_desc_indic'] ?></td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="6" class="color_fondo">ACCIDENTES</td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01"><?php echo $f1['accidentes'] ?></td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" class="color_fondo">ALERGIAS</td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01"><?php echo $f1['alergias'] ?></td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" class="color_fondo">MEDICAMENTOS</td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01"><?php echo $f1['medicamentos'] ?></td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" class="color_fondo">GRUPO SANGUINEO                      </td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01"><?php  switch($f1['grupo_sanguineo']) 
		{
			case 1:
			$grup = "RH(-)";
			break;
			case 2:
			$grup = "RH(+)";
			break;	
			case 3:
			$grup = "AB(I)";
			break;
			case 4:
			$grup = "A(I)";
			break;	
			case 5:
			$grup = "B(III)";
			break;
			case 6:
			$grup = "0(IV)";
			break;
			default:
			$grup = "S/I";
			break;
			  
		}echo $grup;	
					  ?></td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" class="color_fondo">PROBLEMAS ESPECIFICOS DE SALUD DEL ALUMNO</td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['problema_especifico1']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">DIABETES</td>
                      <td class="cuadro01"><?php echo ($f1['problema_especifico2']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">PROBLEMAS DE COAGULACION</td>
                      <td class="cuadro01"><?php echo ($f1['problema_especifico3']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">EPILEPSIA</td>
                    </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['problema_especifico4']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">CRISIS ASMATICAS</td>
                      <td class="cuadro01"><?php echo ($f1['problema_especifico5']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">CRISIS CONVULSIVAS</td>
                      <td class="cuadro01"><?php echo ($f1['problema_especifico6']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">ASMA</td>
                    </tr>
                    <tr>
                      <td class="cuadro01"><?php echo ($f1['problema_especifico7']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">SANGRAMIENTO NASAL FRECUENTE</td>
                      <td class="cuadro01"><?php echo ($f1['problema_especifico8']==1)?"<img src='img/PNG-48/check.png' width='18' height='18' />":"" ?></td>
                      <td class="cuadro01">REACCION ALERGICA A PICADURAS DE INSECTOS</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01">OTROS: <?php echo $f1['problema_especifico_otros'] ?></td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01">&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="6" class="color_fondo">TRATAMIENTO CON ESPECIALISTA</td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">NEUROLOGIA</td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01"><?php echo $f1['te_neu'] ?></td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">PSICOPEDAGOGIA</td>
                    </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01"><?php echo $f1['te_psig'] ?></td>
                      </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">PSICOLOGIA</td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01"><?php echo $f1['te_psi'] ?></td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">FONOAUDIOLOGIA</td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01"><?php echo $f1['te_fono'] ?></td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">OTROS: </td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01"><?php echo $f1['te_otr'] ?></td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" class="color_fondo">SEGURO CLINICA</td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="cuadro01"><?php echo $f1['te_se_cli'] ?></td>
                      </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="6" class="cuadro01">SEGURO CLINICA</td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="4" class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01"><?php echo ($f1['tipo_seguro']==1)?"ESTATAL":"PRIVADO" ?></td>
                      <td colspan="4" class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="4" class="cuadro01">&nbsp;</td>
                    </tr>
                  <?php   if($f1['tipo_seguro']==2){?>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">NOMBRE CLINICA</td>
                      <td colspan="4" class="cuadro01"><? echo trim(strtoupper($f1['clinica']))?></td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">FONO CLINICA</td>
                      <td colspan="4" class="cuadro01"><? echo trim(strtoupper($f1['fono_clinica']))?></td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td colspan="5" class="color_fondo">ISAPRE</td>
                      </tr>
                    <tr>
                      <td class="cuadro01">&nbsp;</td>
                      <td class="cuadro01">NOMBRE</td>
                      <td colspan="4" class="cuadro01"><? echo trim(strtoupper($f1['isapre']))?></td>
                      </tr>
                      <?php }?>
                    </table>
                    <?php
					
					$i++;
			  }
				
	break;
	
	default:
		break;
}

if($funcion==5){
	
	    echo '<ul>';
		
		  $sql = "SELECT 
						*
						FROM matricula ma
						INNER JOIN alumno al ON al.rut_alumno = ma.rut_alumno
						INNER JOIN curso cu ON cu.id_curso = ma.id_curso AND cu.id_ano = ma.id_ano
						INNER JOIN tipo_ensenanza ten ON ten.cod_tipo = cu.ensenanza 
						INNER JOIN ano_escolar aes ON aes.id_ano = ma.id_ano
						WHERE ma.rut_alumno =  ".trim($_POST['rut_alumno'])." ORDER BY aes.nro_ano ";
		
		$result = @pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$sql);
		
		if(pg_num_rows($result)>0){
		
		for($e=0;$e<pg_num_rows($result);$e++){
				$fila = pg_fetch_array($result,$e);
		        echo  '<li><a href="Cont_Ficha_Alumno.php" onClick="Buscar_Ficha_Alumno_Seteado_Ano('.trim($fila['id_ano']).',0,0)" >'.trim($fila['nro_ano']).'</a></li>';
				
		      }
		    }
		echo '</ul>';
		
}

//if($funcion==15){
	switch ($caso) {
       case '0':
	
	$sql = "SELECT 
						*
						FROM matricula ma
						INNER JOIN alumno al ON al.rut_alumno = ma.rut_alumno
						INNER JOIN curso cu ON cu.id_curso = ma.id_curso AND cu.id_ano = ma.id_ano
						INNER JOIN tipo_ensenanza ten ON ten.cod_tipo = cu.ensenanza 
						INNER JOIN ano_escolar aes ON aes.id_ano = ma.id_ano
						WHERE ma.rut_alumno =  ".trim($_POST['rut_alumno'])." and aes.id_ano=".$_POST['id_ano']." ORDER BY aes.nro_ano ";
		
		$result = @pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$sql);
	
	
	
	
	  	if(pg_num_rows($result)>0){
		
		for($e=0;$e<pg_num_rows($result);$e++){
			
		$fila = pg_fetch_array($result,$e);  
	
	   echo '<div>';
	   
    	echo $anio='<input type="hidden" id="anio" value="'.$fila["id_ano"].'">';
   		$ape_pat  = ucwords(strtolower(htmlentities(trim($fila["ape_pat"]))));
		$ape_mat = ucwords(strtolower(htmlentities(trim($fila["ape_mat"]))));
		$nombre  = ucwords(strtolower(htmlentities(trim($fila["nombre_alu"]))));
		$rut_alumno = trim($fila["rut_alumno"]);
		$dig_rut = trim($fila["dig_rut"]);
	    
		$Curso_pal = $objMembrete->CursoPalabra($fila['id_curso'],1);

		$fila["nro_lista"]; 
		$fila["bool_ar"];
		$fila["num_mat"];	  
		      
		echo '<table>
	        <tr class="color_fondo">
              <td colspan="3">Rut Alumno</td>
            </tr>
            <tr>
              <td colspan="3">'.$rut_alumno.'-'.$dig_rut.'</td>
            </tr>
			<tr class="color_fondo">
              <td >Fecha Matricula</td>
              <td >Nro Matricula</td>
              <td >&nbsp;</td>
            </tr>
            <tr>
              <td>'.$fila["fecha"].'</td>
              <td>'.$fila["num_mat"].'</td>
              <td>&nbsp;</td>
            </tr>
            <tr class="color_fondo">
              <td >Nombre</td>
              <td >A. Paterno</td>
              <td >A. Materno</td>
            </tr>
            <tr>
              <td>'.$nombre.'</td>
              <td>'.$ape_pat.'</td>
              <td>'.$ape_mat.'</td>
            </tr>
            <tr class="color_fondo" >
              <td>Fecha Nacimiento</td>
              <td>Sexo</td>
              <td>Nacionalidad</td>
            </tr>
            <tr>
              <td>'.$fila["fecha_nac"].'</td>
              <td>'.$fila["sexo"].'</td>
              <td>'.$fila["nacionalidad"].'</td>
            </tr>
            <tr  class="color_fondo">
              <td>Alumna Embarazada</td>
              <td colspan="2"  >Alumno(a) '.htmlentities("Indígena",ENT_QUOTES,'UTF-8').'</td>
            </tr>
            <tr>
              <td>'.$fila["ingestab"].'</td>
              <td>'.$fila["ingestab"].'</td>
              <td>&nbsp;</td>
			</tr>
            <tr class="color_fondo" >
              <td>Calle</td>
              <td>Nro.</td>
              <td>Block</td>
            </tr>
            <tr>
              <td>'.$fila["calle"].'</td>
              <td>'.$fila["nro"].'</td>
              <td>0</td>
            </tr>
            <tr class="color_fondo" >
              <td >Departamento</td>
              <td >'.htmlentities("Villa / Población",ENT_QUOTES,'UTF-8').'</td>
              <td ></td>
            </tr>
            <tr>
              <td>&nbsp;'.$fila["depto"].'</td>
              <td>&nbsp;'.$fila['villa'].'</td>
              <td>&nbsp;</td>
            </tr>
            <tr class="color_fondo">
              <td>'.htmlentities("Teléfono",ENT_QUOTES,'UTF-8').'</td>
              <td>E-mail</td>
			  <td>Curso</td>
            </tr>
            <tr>
              <td>'.$fila["telefono"].'</td>
              <td>'.$fila["email"].'</td>
			  <td>'.$Curso_pal.'</td>
            </tr>
            <tr class="color_fondo" >
              <td>'.htmlentities("Región",ENT_QUOTES,'UTF-8').'</td>
              <td>Provincia</td>
              <td>Comuna</td>
            </tr>
            <tr>
              <td>'.ucwords(strtolower(htmlentities($fila["region"],ENT_QUOTES,'UTF-8'))).'</td>
              <td>'.ucwords(strtolower(htmlentities($fila["ciudad"],ENT_QUOTES,'UTF-8'))).'</td>
              <td>'.ucwords(strtolower(htmlentities($fila["comuna"],ENT_QUOTES,'UTF-8'))).'</td>
            </tr>
			<tr class="color_fondo" >
			<td>Salud</td>
			<td>Colegio De Procedencia</td>
			<td>Cursos Repetidos</td>
			</tr>
			<tr>
			<td>'.$fila["salud"].'</td>
			<td>&nbsp;'.$fila['colegioprocedencia'].'</td>
			<td>&nbsp;'.$fila['cursosrep'].'</td>
			</tr>
			 <tr class="color_fondo" >
			 <td>Sistema Informatico de Junaeb</td>
			<td>Ingresado Por El Establecimiento</td>
			<td>Alumno Prioritario</td>
			</tr>
			<tr>
			<td>&nbsp;'.$fila['junaeb'].'</td>
			<td>&nbsp;'.$fila['ingestab'].'</td>
			<td>&nbsp;'.$fila_ver['prioritario'].'</td>
			</tr>
        </table>';
         echo  '</div>';
        
		}
		}
		break;
		
	case '1':
	$result = $Obj_Ficha_Alumno->Conducta($_POST['rut_alumno'],$_POST['id_ano']);
	if($result){
		if(pg_num_rows($result )>0){
			echo $anio='<input type="hidden" id="anio" value="'.$_POST['id_ano'].'">';
	echo   '<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tbody>
    <tr class="color_fondo">
	
     <td align="center" width="10%">FECHA</td>
      <td align="center" width="15%">RESPONSABLE</td>
      <td align="center" width="35%">TIPO ANOTACION</td>
      <td align="center" width="5%">ANOTACION</td>
    </tr>';
			
			$contador_positivas=0;
			$contador_negativas=0;
			for($s=0;$s<pg_num_rows($result);$s++ ){
			$fila = @pg_fetch_array($result,$s); 
			
			
			$ape_mat=$fila['ape_mat'];
	
  echo   '<tr>
      <td align="center"><strong>'.$fila["fecha"].'</strong></td>
      <td align="center"><strong>'.$fila['ape_pat'].' '.strtoupper($ape_mat[0]).'. '.
	  ucwords(strtolower(htmlentities($fila['nombre_emp'],ENT_QUOTES,'UTF-8'))).'</strong></td>
			
      
      <td align="center"><strong>';
	  
	    if($fila["codigo_tipo_anotacion"]==""){
													
		 if ($fila['tipo']==1){ echo "CONDUCTA "; 
		 if ($fila['tipo_conducta']==1){ 
		 echo " POSITIVA"; 
		 $contador_positivas++;
		 }	 
		 if ($fila['tipo_conducta']==2){
			 echo " NEGATIVA"; 
			 $contador_negativas++;
			 }
	    }
														
		if($fila['tipo']==2){
		echo "ATRASO";
		$contador_negativas++;
		}															
															
        if($fila['tipo']==3){
		echo "INASISTENCIA";
		$contador_negativas++;
		}
															
		if($fila['tipo']==4){
		echo "RESPONSABILIDAD";
		$contador_negativas++;
		}												
																											
		}else{
		
		$cod_ta = $fila["codigo_tipo_anotacion"];													   
		$q1 = "select * from tipos_anotacion where id_tipo = '$cod_ta'";
		$r1 = @pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$q1);
		if($r1){
		$f1 = @pg_fetch_array($r1,0);
		$codta= $f1['codtipo'];
		$descripcion	= $f1['descripcion'];
		$tipo2	= $f1['tipo'];
								   
		   if ($tipo2==1){
			   $contador_positivas++;
		   }
		   if ($tipo2==2){
			   $contador_negativas++;
		   }	   	   
		
		
		echo "$codta - $descripcion";  
		 }
	  }
	  echo '</strong></td>
	  
      <td width="%" align="center"><div id="eldiv" ><strong>';
		 ?>
         <img src="Class/PNG-32/Search.png" width="32" height="32" onclick="muestra_detalle('<?=$cod_ta?>','<?=$fila["codigo_anotacion"];?>')"/>
         
         <?
		
	  
	  echo  '</div></strong></td>
	  
    </tr>';
	
		}
  
 echo  '</tbody></table> ';
 
 
 
 	$dives = '<div id="div_a" class="curved">
	          <div >Anotaciones Positivas = '.$contador_positivas.'</div>
 			  <div >Anotaciones Negativas = '.$contador_negativas.'</div>
			  </div>';	
 
 	echo $dives;
 
		}
	}
	break;		
	
	
	case '2':
		
	 $qryB="SELECT * FROM MATRICULA WHERE RUT_ALUMNO='".$_POST['rut_alumno']."' AND RDB='".$_INSTIT."' AND ID_ANO='".$_POST['id_ano']."' "; 
	         
	 $resultB =@pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$qryB);
	
	if (!$resultB) {
	 echo '<B> ERROR :</b>Error al acceder a la BD. (1)</B>';
	 }else{
		 if (pg_num_rows($resultB)!=0){

				$filaB = @pg_fetch_array($resultB,0);	

                 $AlJu   =($filaB['bool_baj']==0)?"NO":"SI";
				 $CenPad =($filaB['bool_cpadre']==0)?"NO":"SI";
				 $Seg    =($filaB['bool_seg']==0)?"NO":"SI";
				 $Otros  =($filaB['bool_otros']==0)?"NO":"SI";
				 $ChSol  =($filaB['bool_bchs']==0)?"NO":"SI";
				 $Munc   =($filaB['bool_mun']==0)?"NO":"SI";
				 $AlSep  =($filaB['ben_sep']==1)?"SI":"NO";
	echo $anio='<input type="hidden" id="anio" value="'.$_POST['id_ano'].'">';			 
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tbody>
    <tr class="color_fondo" >
      <td>'.ucwords(strtolower(htmlentities("Alimentación Junaeb",ENT_QUOTES,'UTF-8'))).'</td>
      <td>C. de Padres</td>
    </tr>
    <tr>
      <td>'.$AlJu.'</td>
      <td>'.$CenPad.'</td>
    </tr>
    <tr class="color_fondo">
      <td >Seguro</td>
      <td>Otras</td>
    </tr>
    <tr>
      <td>'.$Seg.'</td>
      <td>'.$Otros .'</td>
    </tr>
    <tr>
      <td class="color_fondo">Chile Solidario</td>
      <td class="color_fondo">Municipal</td>
    </tr>
    <tr>
      <td>'.$ChSol.'</td>
      <td>'.$Munc.'</td>
    </tr>
    <tr class="color_fondo" >
      <td >Alumno SEP</td>
      <td></td>
    </tr>
    <tr>
      <td>'.$AlSep.'</td>
      <td></td>
    </tr>
  
    <tr class="color_fondo" >
      <td colspan="2">Becas de la Institucion</td>
    </tr>';
    
	$sql = "select id_beca,nomb_beca FROM becas_conf WHERE id_ano=".$este_ano." ORDER BY nomb_beca ASC";
  	$rs_beca = @pg_exec($Obj_Ficha_Alumno->Conec->conectar(),$sql);
	for($n=0;$n < @pg_numrows($rs_beca);$n++){
	
	$fila_beca = @pg_fetch_array($rs_beca,$n);
	
	$sql = "SELECT * FROM becas_benef 
	WHERE id_beca=".$fila_beca['id_beca']." AND rut_alumno=".$_POST['rut_alumno'];
	$rs_existe = @pg_exec($Obj_Ficha_Alumno->Conec->conectar(),$sql);
	
	?>
  <tr>
    <td width="20%" class="color_fondo" ><?=ucfirst(strtolower($fila_beca['nomb_beca']));?></td>
    <td><? if(@pg_numrows($rs_existe)>0) echo "SI"; else echo "NO";?></td>
  </tr>  
  <? } 

  echo '</tbody>
</table>';
	            }
            }  
	break;

/*promedios*/
	case '3':
	echo $anio='<input type="hidden" id="anio" value="'.$_POST['id_ano'].'">';
		
	?>
	  <table width="100%" border="1" style="border-collapse:collapse" align="center" cellpadding="0" cellspacing="0">
		  <tr class="color_fondo">
            <td width="323" align="left" class="item">&nbsp;</td>
            <? 
			 $sql_p = "select  * from periodo where id_ano = ".$_POST['id_ano']." order by fecha_inicio" ;
			 $result_p =@pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$sql_p);
			 $num_periodos = @pg_numrows($result_p);
		
			$fila_p = pg_num_rows($result_p);
			if ($num_periodos==2) $tipo_per = "SE";
	        if ($num_periodos==3) $tipo_per = "TR";	
			$arr_prom=array();
			for ($i=1; $i<=$fila_p; $i++) { 
			
			?>
				<td align="center" class="item" colspan="2"><strong>
				  <?=$i?>
				  &deg;<? echo $tipo_per ?></strong>
             
                  </td>
			<? }?>
            	<td align="center" colspan="2"><strong>Prom. Final</strong></td>  
            </tr>  
            
            <tr class="color_fondo">
            <td><div align="center"><strong>Subsector del Aprendizaje (Formaci&oacute;n General ) </strong></div></td>
            <?
            	for($j=0;$j<$i;$j++){
					?>
					 <td width="33">Nota</td>
                     <td width="48">Nivel</td>
					<?
					}
			
			?>
          
            </tr>
	
	<?
	
	 $sql_nro_ano="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$_POST['id_ano']."";
	 $result_nro_ano =@pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$sql_nro_ano);
	 $fila_nro_ano=pg_fetch_array($result_nro_ano,0);
	 $nro_ano=$fila_nro_ano[0];
	 
	  echo $nro_ano2='<input type="hidden" id="nro_ano" value="'.$nro_ano.'">';
	
	
	
	 $sql_notas="select m.id_curso,r.id_ramo,su.nombre,nt.promedio,p.nombre_periodo, sf.prom_gral,psa.promedio as prom_final
				from matricula m  
				LEFT join ramo r on m.id_curso=r.id_curso and m.rut_alumno=".$_POST['rut_alumno']."
				LEFT join notas$nro_ano nt on r.id_ramo=nt.id_ramo and nt.rut_alumno=".$_POST['rut_alumno']."
				LEFT join subsector su on r.cod_subsector=su.cod_subsector
				LEFT JOIN periodo p ON nt.id_periodo=p.id_periodo
				LEFT JOIN situacion_final sf ON sf.id_ramo=r.id_ramo AND m.rut_alumno=sf.rut_alumno
				LEFT JOIN promedio_sub_alumno psa ON psa.rut_alumno=m.rut_alumno AND psa.id_ano=m.id_ano AND psa.id_ramo=r.id_ramo
				where m.id_ano=".$_POST['id_ano']." order by r.id_orden, nombre_periodo"; 
	         
	 $result_notas =@pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$sql_notas);
	
	 for($a=0;$a<pg_num_rows($result_notas );$a++){
	         $fila_notas = @pg_fetch_array($result_notas ,$a); 
			 if($id_ramo==$fila_notas['id_ramo']){
				 continue;
				 }
		
		?>
		<tr>
		<td>&nbsp;<?=$fila_notas['nombre']?></td>
        <?
		$contador=0;
		$prome1=0;
         for($x=0;$x<pg_numrows($result_p);$x++){
			 	$fila_per= pg_fetch_array($result_p,$x);
				$sql ="SELECT distinct CAST(n.promedio as INT),
						case when CAST(n.promedio as int) >= cnv.nota_minima and CAST(n.promedio as int)<= cnv.nota_maxima  
						then cnv.concepto end as conceptos
						FROM notas$nro_ano n
						inner join periodo pe on n.id_periodo=pe.id_periodo AND pe.id_periodo=".$fila_per['id_periodo']."
						inner join ano_escolar ae ON ae.id_ano=pe.id_ano
						inner join cede.nivel_logro cnv ON cnv.rdb=ae.id_institucion
						WHERE n.rut_alumno=".$_POST['rut_alumno']."  AND n.id_ramo=".$fila_notas['id_ramo']."
						ORDER BY conceptos
						limit 1";
				/*echo "<pre>";
				echo $sql;
				echo "</pre>";*/
				$fila_per['id_periodo'];
				$rs_prom = @pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$sql); 
				$prome = pg_result($rs_prom,0);
				//$prome = $fila_notas['promedio'];
				$conceptos = pg_result($rs_prom,1);
				/*if($prome<40){
				  $conceptos="inicial";
				}*/
					  
				if($prome==""){
				$conceptos="";
				
				}
				else{$arr_prom[$x][]=$prome;}		   
					   
				$contador++;
			  ?>
              
       <td id="tab" align="center"><input type="text" align="center" readonly="readonly" id="promedio<?=$x;?>" size="2" maxlength="2" value="<?=$prome;?>" onclick="dimealgo(this.value,<?=$fila_per['id_periodo']?>,<?=$fila_notas['id_ramo']?>)" >
       </td>
        <td align="center"><?=$conceptos;?></td>

        <?  
		
		$promedio_final=$fila_notas['prom_final'];
		
		if($promedio_final==""){
			$promedio_final=($prome + $prome1);	
			}
			
		/*if($prome!=""){
		$promedio_final=round($promedio_final/2);
			}*/
			
		$prome1=$prome;
		} 
	  
	    if($promedio_final==0){
			$promedio_final="";
			}
			else
			{
			$c_pfinal=$c_pfinal+1;
			$s_pfinal=$s_pfinal+$promedio_final;	
			}
	  
		?>
        <td align="center">&nbsp;<?=$promedio_final;?></td>
        <td align="center">&nbsp;
        <?php
        	 $sql_prom="SELECT distinct CAST(n.promedio as INT), 
				case when CAST(n.promedio as int) >= cnv.nota_minima and 
				CAST(n.promedio as int)<= cnv.nota_maxima then cnv.concepto end as conceptos 
				FROM promedio_sub_alumno n 
				INNER JOIN ano_escolar ae ON ae.id_ano=n.id_ano
				inner join cede.nivel_logro cnv ON ae.id_institucion=cnv.rdb 
				WHERE n.rut_alumno=".$_POST['rut_alumno']." AND n.id_ramo=".$fila_notas['id_ramo']."  order by conceptos ASC limit 1";
				
				$rs_promfinal = @pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$sql_prom); 
				//$prome = pg_result($rs_prom,0);
				$conceptosF = pg_result($rs_promfinal,1);
	         /* if($promedio_final<40 and $promedio_final>0){
				  $conceptosF="inicial";
				   }*/
				   
			  if($fila_notas['prom_final']==""){
				  
				 /* $sql_prom_2="SELECT distinct 
						 case when 
						 $promedio_final >= cnv.nota_minima and 
						 $promedio_final<= cnv.nota_maxima 
						 then cnv.concepto end as conceptos 
						 FROM cede.nivel_logro cnv
						 WHERE  cnv.id_ano=$_ANO_CEDE limit 1";*/
					$sql_prom_2=" select  concepto  FROM cede.nivel_logro cnv 
					WHERE cnv.rdb=$_INSTIT  AND $promedio_final >= cnv.nota_minima and $promedio_final<= cnv.nota_maxima ";

				
				$rs_promfinal_2 = @pg_Exec($Obj_Ficha_Alumno->Conec->conectar(),$sql_prom_2); 
				//$prome = pg_result($rs_prom,0);
				$conceptosF = pg_result($rs_promfinal_2,0);
				  
				  
				  
				  
				  
				   }	   
		echo $conceptosF;
		?>
        
        </td>
	    </tr>
		<? 
		
	 $id_ramo=$fila_notas['id_ramo'];
	 
	 
	 
	 }
	
	?>
    <tr>
    	<td>&nbsp;PROMEDIOS</td>
     <? for($x=0;$x<pg_numrows($result_p);$x++){
		 $prom_per=0;
		  ?>
       <td align="center"><?php 
	  /* echo "<pre>";
	    var_dump($arr_prom[$x]); 
		echo "</pre>";*/
		foreach($arr_prom[$x] as $d_prom => $v_prom){
		$prom_per = $prom_per+$v_prom;
		}
		echo round(($prom_per/count($arr_prom[$x])),0);
		?></td>
        <td>&nbsp;</td>
	<? } ?>
        <td align="center"><?php echo round($s_pfinal/$c_pfinal,0) ?></td>
        <td>&nbsp;</td>
	</table>								 
	<?
	
	
	
	break;
	
	case 4:
	?>
		<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr class="color_fondo">
    <td width="52%" rowspan="2">&nbsp;MESES</td>
    <td width="14%" rowspan="2">&nbsp;DIAS HABILES</td>
    <td colspan="2" align="center">    ATRASOS&nbsp;</td>
    </tr>
  <tr class="color_fondo">
    <td width="17%" align="center"><? echo htmlentities("MAÑANA",ENT_QUOTES,'UTF-8')?></td>
    <td width="17%" align="center">TARDE</td>
  </tr>
  <? for($i=2;$i<=12;$i++){
	  
	  $rs_atraso= $Obj_Ficha_Alumno->Atrasos($i,$_POST['rut_alumno'],$_ANO_CEDE);
	  $manana = pg_result($rs_atraso,0);
	  $tarde = pg_result($rs_atraso,1);
	  
	 //$rs_habiles = $Obj_Ficha_Alumno->DiasHabiles($_ANO_CEDE,$i);
	  	 ?>
  <tr>
    <td>&nbsp;<? $Obj_Ficha_Alumno->Meses($i);?></td>
    <td>&nbsp;<?=$Obj_Ficha_Alumno->DiasHabiles($_ANO_CEDE,$i);;?></td>
    <td>&nbsp;<?=$manana;?></td>
    <td>&nbsp;<?=$tarde;?></td>
  </tr>


	<? } ?>
	 </table> 
   <?
    break;
		
    
	case 5:
		?>
		<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr class="color_fondo">
    <td width="35%">&nbsp;MESES</td>
    <td width="23%">&nbsp;DIAS HABILES</td>
    <td width="15%" align="center">AUSENCIAS</td>
    <td width="16%" align="center">PORCENTAJE</td>
    <td width="11%" align="center">&nbsp;</td>
    </tr>
  <? for($i=2;$i<=12;$i++){
	  
	  $rs_asistencia= $Obj_Ficha_Alumno->Asistencia($i,$_POST['rut_alumno'],$_ANO_CEDE);
	  $inasistencia= pg_result($rs_asistencia,0);
	  $dias_habiles =$Obj_Ficha_Alumno->DiasHabiles($_ANO_CEDE,$i);
	  $porcentaje = 100- (intval((100 * $inasistencia) / $dias_habiles)) ;

	  	 ?>
  <tr>
    <td>&nbsp;<? $Obj_Ficha_Alumno->Meses($i);?></td>
    <td>&nbsp;<?=$dias_habiles;?></td>
    <td>&nbsp;<?=$inasistencia;?></td>
    <td>&nbsp;<? echo $porcentaje."%";?> </td>
    <td><a href="#"><img src="img/PNG-48/Comment.png" width="30" height="30" title="Detalle Inasistencia" onclick="muestraAsistencia(<?=$i;?>,<?=$_POST['rut_alumno'];?>,<?=$_ANO_CEDE?>)"/></a></td>
  </tr>


	<? } ?>
	 </table> 
     <? 
	break;
	
	}
	 
	 
	 if($funcion==6){
		 
	
	    $_SESSION['_RUT_ALUMNO']=$_POST['rut_alumno'];
	    $_RUT_ALUMNO=$_SESSION['_RUT_ALUMNO'];
		
		$id_curso=$_POST['id_curso'];
		
		 $_SESSION['_ID_CURSO']=$_POST['id_curso'];
        $_ID_CURSO=$_SESSION['_ID_CURSO'];
		//echo "Alumno Actual=".$_RUT_ALUMNO;		
		$input='<input type="hidden" id="Rut_Alumno" value="'.$_RUT_ALUMNO.'">';
		echo $input;
		return 	$_ID_CURSO;
		return 	$_RUT_ALUMNO;
		
		}
		
	if($funcion==7){
		
	echo "A&ntilde;o Actual = ".$nro_ano=$_POST['nro_ano'];
	$_SESSION['_ANO_CEDE']=$_POST['id_ano'];
    $_ANO_CEDE=$_SESSION['_ANO_CEDE'];
	
	return 	$_ANO_CEDE;
		
	}
	
	
	if($funcion==8){
$resultnotas = $Obj_Ficha_Alumno->buscaNotas($rut_alumno,$rdb,$periodo,$nro_ano,$id_ramo);

		if($resultnotas){
			
		
			
	   $tablanotas = '
	  <table width="70" id="tablanotas" class="textosimple" >
	  <tr>
	  <td colspan="21" align="center" style="font-size:14px"><u>Notas</u></td>
	  </tr>
	  <tr>
	  <td colspan="21" align="center">&nbsp;</td>
	  </tr>
		<tr class="textosimple" align="center" >
		  <td width="2" > 1</td>
		  <td width="2" > 2</td>
		  <td width="2" > 3</td>
		  <td width="2" > 4</td>
		  <td width="2" > 5</td>
		  <td width="2" > 6</td>
		  <td width="2" > 7</td>
		  <td width="2" > 8</td>
		  <td width="2" > 9</td>
		  <td width="2" > 10</td>
		  <td width="2" > 11</td>
		  <td width="2" > 12</td>
		  <td width="2" > 13</td>
		  <td width="2" > 14</td>
		  <td width="2" > 15</td>
		  <td width="2" > 16</td>
		  <td width="2" > 17</td>
		  <td width="2" > 18</td>
		  <td width="2" > 19</td>
		  <td width="2" > 20</td>
		  <td width="10" >Promedio</td>
		</tr><br>';
	  for($j=0;$j<pg_numrows($resultnotas);$j++){
	  $filanotas = pg_fetch_array($resultnotas,$j);
	  echo $nombreramos=$filanotas['nombre']."<br>"."<br>";
	 echo  $nombre_periodo = $filanotas['nombre_periodo'];
	  $promedio=$filanotas['promedio'];
	 
     $tablanotas .= '<tr class="textosimple">
	 
	  
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota1'].'></td>
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota2'].'></td>
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota3'].'></td>
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota4'].'></td>
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota5'].'></td>
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota6'].'></td>
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota7'].'></td>
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota8'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota9'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota10'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota11'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota12'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota13'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota14'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota15'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota16'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota17'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota18'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota19'].'></td>
	 <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota20'].'></td>
	 <td><input type="text" name="promedio" id="promedio" disabled="disabled" size="1" value='.$filanotas['promedio'].'></td>
    </tr>';																																																																																																																																				
     }// fin for
    $tablanotas .= "</table>";																																	
    echo $tablanotas;	
			}else{ 
	   echo "Sin Notas"; 
	}
	 
		}
		
		
	/*if($funcion==9){
		
		$rut_alumno=$_POST['rut_alumno'];
		
		$foto='<img src="../../../infousuario/images/'.trim($rut_alumno).' "width="160" height="180" />';	
		
		echo $foto;
		
	}	*/
	
	
	if($funcion==10){
		
		$codtipo=$_POST['codtipo'];
		$codigo_anotacion=$_POST['codigo_anotacion'];
		
		$result = $Obj_Ficha_Alumno->detalles_anot($codtipo,$codigo_anotacion,$anotacion);
		
		
		for($e=0;$e<pg_numrows($result);$e++){
			  
				$fila = pg_fetch_array($result,0);
				if($fila['detalle']!=""){
					$detalle_anot=$fila['detalle'];
				}else{
					$detalle_anot=$fila['observacion'];
				}
				
				
								
				?>
                <div id="ventana">
              <h3>Detalles Anotacion</h3>
                <table width="650" height="100" align="center" border="1" style="border-collapse:collapse">
                <tr>
                <td><?=$detalle_anot;?></td> <!--<textarea name="mensaje" cols="100" rows="5"></textarea>-->
                </tr>
                </table>
		       </div>
        <?
					
		}
		
		
		}
		
	if($funcion==11){
		$mes = $_POST['mes'];
		$alumno = $_POST['alumno'];
		$ano = $_POST['ano'];
		$nro_ano = $Obj_Ficha_Alumno->ano_escolar($ano);
		$ultimo_dia= date("d",(mktime(0,0,0,$mes+1,1,$nro_ano)-1));
	?>
    <table width="100%" border="1" style="border-collapse:collapse">
  <tr>
    <td>MES</td>
    <td colspan="30">&nbsp;<?=$Obj_Ficha_Alumno->Meses($mes);?></td>
    </tr>
    <tr>
    <td>&nbsp;</td>
   <?  
		for($i=1;$i<=$ultimo_dia;$i++){
	?>
    <td>&nbsp;<?=$i;?></td>
  <? } ?>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <?  
	for($i=1;$i<=$ultimo_dia;$i++){
		$dia = $mes."/".$i."/".$nro_ano;
		$rs_inasistencia = $Obj_Ficha_Alumno->Inasistencia($dia,$alumno,$ano);		
		if(pg_numrows($rs_inasistencia)==0){			
			$presente ="<img src='img/PNG-48/ok.png' width='20' height='20' />";
		}else{
			$presente  = "<img src='img/PNG-48/Delete.png' width='20' height='20' />";
		}
	?>
    <td><?=$presente;?></td>
  <? } ?>
  </tr>
</table>

  <?  
	}
	

?>