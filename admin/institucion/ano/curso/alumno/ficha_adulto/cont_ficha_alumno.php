<?php
header('Content-Type: text/html; charset=iso-8859-1'); 
session_start();
include_once('mod_ficha_alumno.php');


/*function CambioFecha($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para insertar
{
	
	$f = explode("-",$fecha);
	$retorno = $f[2]."-".$f[1]."-".$f[0];
	return $retorno;
}
*/

function CambioFecha($fecha)   //    cambia fecha del tipo  dd/mm/aaaa  ->  aaaa/mm/dd    para poder hacer insert y update
{
	$retorno="";
	if(strlen($fecha) !=10)
		return $retorno;
	$d=substr($fecha,0,2);
	$m=substr($fecha,3,2);
	$a=substr($fecha,6,4);
	if (checkdate($m,$d,$a))
		$retorno=$a."-".$m."-".$d;
	else
		$retorno="";
	return $retorno;
}
?>




<?php

$obj_combos = new FichaAlumno($conn,$connection);
$obj_familia = new FichaAlumno($conn,$connection);

$funcion = $_POST['funcion'];


if($funcion == 1){
		  $cod_reg=$_POST['cod_region'];	
		  $result = $obj_combos->get_regiones();
		  if($result){
		$select = "<select name='select_regiones' id='select_regiones' onchange='get_provincias(this.value)'>
				   <option value='0'>Seleccione</option>	
		";
		
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['cod_reg']."' >".$fila['nom_reg']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	
	if($funcion == 2){
		  $cod_reg=$_POST['cod_reg'];	
		  $result = $obj_combos->get_provincias($cod_reg);
		  if($result){
		$select = "<select name='select_provincias' id='select_provincias' onchange='get_comunas(this.value)'>
				   <option value=0,0>Seleccione</option>		
		";
		
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['cor_pro'].",".$fila['cod_reg']."' >".$fila['nom_pro']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	
	if($funcion == 3){
		  $cod_reg=$_POST['cod_reg'];
		  $cod_prov = $_POST['cod_prov'];	
		  $result = $obj_combos->get_comunas($cod_reg,$cod_prov);
		  if($result){
		$select = "<select name='select_comunas' id='select_comunas' onchange=''>
				   <option value='0'>Seleccione</option>	
		";
		
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['cor_com']."' >".$fila['nom_com']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	if($funcion==4){
		
    $rut_alumno = $_POST['rut_alumno'];
	$dig_rut = $_POST['dig_rut'];	
	$nombre_alum = utf8_decode($_POST['nombre_alum']);
	$ape_pat = utf8_decode($_POST['ape_pat']);
	$ape_mat = utf8_decode($_POST['ape_mat']);
	$fecha_nac = CambioFecha($_POST['fecha_nac']);
	$sexo = $_POST['sexo'];		
	$nacionalidad = $_POST['nacionalidad'];
	$alum_emb = $_POST['alum_emb'];
	$alum_ind = $_POST['alum_ind'];
	$proced_alum = utf8_decode($_POST['proced_alum']);
	$con_quien_vive =utf8_decode($_POST['con_quien_vive']);
	$txt_calle = utf8_decode($_POST['txt_calle']);
	$txt_nro = $_POST['txt_nro'];
	$txt_block = $_POST['txt_block'];
	$txt_depto = $_POST['txt_depto'];
	$txt_villa = utf8_decode($_POST['txt_villa']);
	$txt_fono = $_POST['txt_fono'];
	$txt_email = $_POST['txt_email'];
	$region = $_POST['region'];
	$provincia = $_POST['provincia'];
	$comuna = $_POST['comuna'];
	
	$curso_rep = $_POST['curso_rep'];
	$especialista = $_POST['especialista'];
	$al_pie = $_POST['al_pie'];
	$al_sep = $_POST['al_sep'];
	$al_retos = $_POST['al_retos'];
	$al_puente = $_POST['al_puente'];
	$al_fc = $_POST['al_fc'];
	$cmbSANCION = $_POST['cmbSANCION'];
	$txtENFERMEDAD = $_POST['txtENFERMEDAD'];
	$txtCIRUGIA = $_POST['txtCIRUGIA'];
	$txtMEDICAMENTO = $_POST['txtMEDICAMENTO'];
	$txtALERGIA = $_POST['txtALERGIA'];
	$txtFISICA = $_POST['txtFISICA'];
	$txtFIEBRE = $_POST['txtFIEBRE'];
	$txtSEGURO = $_POST['txtSEGURO'];
	
	$aut_emergencia = $_POST['aut_emergencia'];
	$rut_sinpuntos = $_POST['rut_sinpuntos'];
	
	$nombre_retira = utf8_decode($_POST['nombre_retira']);
	$parentesco_retira = $_POST['parentesco_retira'];
	$telefono_retira = $_POST['telefono_retira'];
	$cel_retira = $_POST['cel_retira'];
	$viaja_furgon = $_POST['viaja_furgon'];
	$nombre_tio = utf8_decode($_POST['nombre_tio']);
	$fono_furgon = $_POST['fono_furgon'];
	
	$fecham = CambioFecha($_POST['fecham']);
	$alumno_ret = $_POST['alumno_ret'];
	$fechar = (strlen($_POST['fechar'])>0)?CambioFecha($_POST['fechar']):"";
	$motivo_r =utf8_decode($_POST['motivo_r']);
	$cmb_condicional = $_POST['cmb_condicional'];
	$opta_religion = $_POST['opta_religion'];
	$ed_diferencial = $_POST['ed_diferencial'];
	$al_integrado = $_POST['al_integrado'];
	$id_curso = $_POST['id_curso'];
	$nro_ano = $_POST['nro_ano'];
	$id_ano = $_POST['id_ano'];
	$cmbMOTIVO = $_POST['cmbMOTIVO'];
	
	
	$ret = $_POST['ret'];
	
	$datos_interes = utf8_decode($_POST['datos_interes']);
	$observacion = utf8_decode($_POST['observacion']);
	$observacion_salud = utf8_decode($_POST['observacion_salud']);
	
	$controlsano = "1111-11-11";
		
		
		if($_POST['num_grupofamiliar']!=""){
		$num_grupofamiliar = $_POST['num_grupofamiliar'];
		}
		else{
			$num_grupofamiliar = 0;
		}
		
		if($_POST['ingresos']!=""){
		$ingresos = $_POST['ingresos'];
		}
		else{
			$ingresos = 0;
		}
		
		if($_POST['cant_dormitorios']!=""){
		$cant_dormitorios = $_POST['cant_dormitorios'];
		}
		else{
			$cant_dormitorios = 0;
		}
		
		if($_POST['cant_banos']!=""){
		$cant_banos = $_POST['cant_banos'];
		}
		else{
			$cant_banos = 0;
		}
		
		if($_POST['cant_hermanos']!=""){
		$cant_hermanos = $_POST['cant_hermanos'];
		}
		else{
			$cant_hermanos = 0;
		}
		
		if($_POST['num_hermano']!=""){
		$cant_banos = $_POST['num_hermano'];
		}
		else{
			$num_hermano = 0;
		}
		
		
		if($_POST['cant_hijos']!=""){
		$cant_hijos = $_POST['cant_hijos'];
		}
		else{
			$cant_hijos = 0;
		}
		if($_POST['txt_edad']!=""){
		$txt_edad = $_POST['txt_edad'];
		}
		else{
			$txt_edad = 0;
		}
		
		if($_POST['lugar_trabajo']!="" && $_POST['bool_trabajo']==1){
		$lugar_trabajo = $_POST['lugar_trabajo'];
		}
		else{
			$lugar_trabajo = '';
		}
		
		if($_POST['lugar_trabajo']!="" && $_POST['bool_trabajo']==1){
		$lugar_trabajo = $_POST['lugar_trabajo'];
		}
		else{
			$lugar_trabajo = '';
		}
		
		
		if($_POST['txt_anosretiro']!=""){
		$txt_anosretiro = $_POST['txt_anosretiro'];
		}
		else{
			$txt_anosretiro = '';
		}
		
		if($_POST['txt_causaretiroant']!=""){
		$txt_causaretiroant = $_POST['txt_causaretiroant'];
		}
		else{
			$txt_causaretiroant = '';
		}
		
		if($_POST['txt_enfcronica']!=""){
		$txt_enfcronica = $_POST['txt_enfcronica'];
		}
		else{
			$txt_enfcronica = 'Null';
		}
		
		if($_POST['txt_discapacidad']!="" && $_POST['bool_discapacidad']!=0){
		$txt_discapacidad = $_POST['txt_discapacidad'];
		}
		else{
			$txt_discapacidad = 'Null';
		}
		
	
	if($_POST['txt_centroatencion']!=""){
		$txt_centroatencion = $_POST['txt_centroatencion'];
		}
		else{
			$txt_centroatencion = 'Null';
		}
		
		if($_POST['txt_contactoemergencia']!=""){
		$txt_contactoemergencia = $_POST['txt_contactoemergencia'];
		}
		else{
			$txt_contactoemergencia = 'Null';
		}
		
		if($_POST['txt_fonocontactoemergencia']!=""){
		$txt_fonocontactoemergencia = $_POST['txt_fonocontactoemergencia'];
		}
		else{
			$txt_fonocontactoemergencia = 'Null';
		}
		
		
		if($_POST['txt_tutor']!=""){
		$txt_tutor = $_POST['txt_tutor'];
		}
		else{
			$txt_tutor = 'Null';
		}
		
		if($_POST['txt_fonotutor']!=""){
		$txt_fonotutor = $_POST['txt_fonotutor'];
		}
		else{
			$txt_fonotutor = 'Null';
		}
	
	
	$aut_emergencia=0;
			
	
	if($_POST['tramo_salud']!=""){
		$tramo_salud = $_POST['tramo_salud'];
		}
		else{
			$tramo_salud = 'Null';
		}
		
		if($_POST['txt_fichaps']!=""){
		$txt_fichaps = $_POST['txt_fichaps'];
		}
		else{
			$txt_fichaps = 'Null';
		}

	$cant_hermanos=0;
	$num_hermano=0;
	$txtENFERMEDAD='';
	$txtCIRUGIA='';
	$txtMEDICAMENTO='';
	$txtALERGIA='';
	$txtFISICA='';
	$txtFIEBRE='';
	$txtSEGURO='';
	$jefe_hogar='';
	$ocup_jefehogar='';
	$tipo_vivienda=0;
	$cant_dormitorios=0;
	$cant_banos=0;
	$figura_paterna='';
	$carinoso=0;
	$sociable=0;
	$curioso=0;
	$org_participa='';
	$con_quien_estudia='';
	$espacio_juego=0;
	$espacio_estudio=0;
	$jefe_aporta=0;
	$hizo_jardin=0;	
	
	
		
		$result = $obj_combos->actualiza_datos_personales($rut_alumno,$dig_rut,$nombre_alum,$ape_pat,$ape_mat,$fecha_nac,$sexo,$nacionalidad,$alum_emb,$alum_ind,$proced_alum,$con_quien_vive,$txt_calle,$txt_nro,$txt_block,$txt_depto,$txt_villa,$txt_fono,$txt_email,$region,$provincia,$comuna,$curso_rep,$especialista,$al_pie,$al_sep,$al_retos,$al_puente,$al_fc,$cmbSANCION,$txtENFERMEDAD,$txtCIRUGIA,$txtMEDICAMENTO,$txtALERGIA,$txtFISICA,$txtFIEBRE,$txtSEGURO,$aut_emergencia,$rut_sinpuntos,$nombre_retira,$parentesco_retira,$telefono_retira,$cel_retira,$viaja_furgon,$nombre_tio,$fono_furgon,$fecham,$alumno_ret,$fechar,$motivo_r,$cmb_condicional,$opta_religion,$ed_diferencial,$al_integrado,$id_curso,$nro_ano,$id_ano,$datos_interes,$observacion,$observacion_salud,$ret,$cmbMOTIVO,$religion,$telefono_recado,$tipo_parto,$edad_madre_nace,$peso_nace,$talla_nace,$s_salud,$probdentales,$controldental,$famenfermo,$jefe_hogar,$ocup_jefehogar,$num_grupofamiliar,$ingresos,$tipo_vivienda,$cant_dormitorios,$cant_banos,$espacio_juego,$espacio_estudio,$hizo_jardin,$carinoso,$sociable,$curioso,$org_participa,$con_quien_estudia,$obse_general,$figura_paterna,$jefe_aporta,$controlsano,$bool_neurologo,$bool_psicopedagogo,$bool_psicologo,$bool_tieneluz,$bool_tieneagua,$bool_tienealcantarillado,$bool_retirosolo,$bool_otratamiento,$bool_tratactual,$bool_tastornosaprendizaje,$material_vivienda,$estado_vivienda,$txt_otratamiendo,$txt_tratactual,$txt_trastornosaprendizaje,$cant_hermanos,$num_hermano,$bool_madre,$bool_padre,$txt_etnia,$cant_hijos,$txt_edad,$bool_trabajo,$lugar_trabajo,$txt_anosrepetidos,$txt_anosretiro,$txt_causaretiroant,$bool_examenvalidacion,$txt_enfcronica,$bool_discapacidad,$txt_discapacidad,$bool_carnetdiscapacidad,$txt_centroatencion,$txt_contactoemergencia,$txt_fonocontactoemergencia,$txt_tutor,$txt_fonotutor,$tramo_salud,$bool_ccc,$txt_fichaps,$bool_vif,$bool_saludmental,$bool_drogas,$bool_sename,$bool_sernam);
		
		if($result){
			echo 1;
			}else{
			echo 0;	
			}
		
		}
		
	if($funcion==5){

	  $rut_alumno=$_POST['rut_alumno'];
	  $result = $obj_combos->Datos_Familiar($rut_alumno);
	  if($result){
		$select = "<select name='select_familiar' id='select_familiar' onchange='get_familiar(this.value)'>
		<option value='0'>Seleccione Familiar</option>
		";
						
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$nombre_apo = trim($fila['nombre_apo']);
			$ape_pat = trim($fila['ape_pat']);
			$ape_mat = trim($fila['ape_mat']);
			
			$select .= "<option value='".$fila['rut_apo']."' >".$nombre_apo.' '.$ape_pat.' '.$ape_mat."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	} 	
	
	
	if($funcion==6){
		//print_r($_POST);
		 $rut_apo = $_POST['rut'];
		 $dig_rut = $_POST['dig_rut'];
		
		$result = $obj_familia->Encuentra_Apo($rut_apo,$dig_rut);
		$resultado=pg_numrows($result);
		if($resultado==1){
		for($i=0;$i<pg_numrows($result);$i++){
			$fila = pg_fetch_array($result,$i);
			
	        $cod_reg = $fila['region'];
			$cod_prov = $fila['ciudad'];
			$cod_com = $fila['comuna'];		
			
			$relacion=$fila['relacion'];	
			if($relacion==1){
				$relacion="Apoderado";
			}else if($relacion==2){
					$relacion="Sostenedor";
			}
			
			if($fila['sexo']==1){
				$fila['sexo']="Femenino";
				}else if($fila['sexo']==2){
				$fila['sexo']="Masculino";		
			}
			
			if($fila['nacionalidad']==1){
				$fila['nacionalidad']="Extranjero";
				}else if($fila['nacionalidad']==2){
				$fila['nacionalidad']="Chileno";		
			}
	$id_sistema_salud =$fila['sistema_salud'];	
	
	$profesion_apo = $fila['profesion'];	
	
	$regis_com = $obj_familia->get_comuna($cod_com,$cod_prov,$cod_reg);
	$comuna = pg_result($regis_com,3);		
	
	$regis_salud = $obj_familia->get_sistema_salud();
	$sistema_salud = pg_result($regis_salud,1);
	
	if($fila['edad_primer_parto']!=0){
			$fila['edad_primer_parto']=$fila['edad_primer_parto'];	
			}
			else{
			$fila['edad_primer_parto']="";
			}
			
			
			
		?>
        
      
        <br>
        <table width="100%" border="1" style="border-collapse:collapse;"  align="center">
        
        <tr>
          <td width="32%" class="cuadro02">Rut</td>
          <td width="34%" class="cuadro02">Relacion</td>
          <td width="34%" class="cuadro02">&nbsp;</td>
        </tr>
        
       <tr>
         <td class="cuadro01"><?=$fila['rut_apo'].'-'.$fila['dig_rut']?></td>
         <td class="cuadro01"><?=$relacion?></td>
         <td class="cuadro01">&nbsp;<input type="hidden" id="hidden_rut_familiar" value="<?=$fila['rut_apo']?>"></td>
       </tr>
        
        <tr>
          <td class="cuadro02">Nombre</td>
          <td class="cuadro02">Apellido Paterno</td>
          <td class="cuadro02">Apellido Materno</td>
        </tr>
        <tr>
        <td class="cuadro01"><?=$fila['nombre_apo'];?></td>
        <td class="cuadro01"><?=$fila['ape_pat'];?></td>
        <td class="cuadro01"><?=$fila['ape_mat'];?></td>
        </tr>
        
          <tr>
          <td class="cuadro02">Fecha Nacimiento</td>
          <td class="cuadro02">Sexo</td>
          <td class="cuadro02">Nacionalidad</td>
        </tr>
        <tr>
        <td class="cuadro01"><?=CambioFechaDisplay($fila['fecha_nac'])?></td>
        <td class="cuadro01"><?=$fila['sexo']?></td>
        <td class="cuadro01"><?=$fila['nacionalidad']?></td>
        </tr>
        <tr>
          <td class="cuadro02">Edad primer Parto (en caso de la madre)</td>
          <td class="cuadro02">Ultimo a&ntilde;o aprobado</td>
          <td class="cuadro02">&nbsp;</td>
        </tr>
        <tr>
          <td class="cuadro01"><?=$fila['edad_primer_parto'];?></td>
          <td class="cuadro01"><?=$fila['ultimo_ano_aprobado'];?></td>
          <td class="cuadro01">&nbsp;</td>
        </tr>
        </table>
        <hr />
        <table width="100%" border="1" style="border-collapse:collapse;" align="center" >
   

    <tr>
    <td class="cuadro02">Calle</td>
    <td class="cuadro02">Numero</td>
    <td class="cuadro02">Block</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=trim($fila['calle'])?></td>
    <td class="cuadro01"><?=trim($fila['nro'])?></td>
    <td class="cuadro01"><?=trim($fila['block'])?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Depto</td>
    <td class="cuadro02">Villa/Poblacion</td>
    <td class="cuadro02">Comuna</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=trim($fila['depto'])?></td>
    <td class="cuadro01"><?=trim($fila['villa'])?></td>
    <td class="cuadro01"><?=$comuna;?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Telefono</td>
    <td class="cuadro02">Celular</td>
    <td class="cuadro02">Email</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=trim($fila['telefono'])?></td>
    <td class="cuadro01"><?=trim($fila['celular'])?></td>
    <td class="cuadro01"><?=trim($fila['email'])?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Estudios</td>
    <td class="cuadro02">Profesion</td>
    <td class="cuadro02">Ocupacion Actual</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=trim($fila['nivel_edu'])?></td>
    <td class="cuadro01"><?=trim($fila['profesion'])?></td>
    <td class="cuadro01"><?=trim($fila['ocupacion'])?></td>
    </tr>
    <tr>
      <td class="cuadro02">Religion</td>
      <td class="cuadro02">SISTEMA DE SALUD</td>
      <td class="cuadro02">Telefono recados</td>
    </tr>
    <tr >
      <td class="cuadro01"><?=trim($fila['religion'])?></td>
      <td class="cuadro01"><?php 
	$regis_salud = $obj_familia->get_sistema_salud_ficha($fila['sistema_salud']);
	$sistema_salud2 = pg_result($regis_salud,1);  ?>
	<?=$sistema_salud2;?></td>
      <td class="cuadro01">&nbsp;</td>
    </tr>
   <!-- <td width="150" class="cuadro02" colspan="3">SISTEMA DE SALUD</td>
    </tr>
    <tr>
    <td  class="cuadro01">
	<?php 
	$regis_salud = $obj_familia->get_sistema_salud_ficha($fila['sistema_salud']);
	$sistema_salud2 = pg_result($regis_salud,1);  ?>
	<?=$sistema_salud2;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>-->

   
    </table>
    <?php
     } 
  
	?>
        <?php	
	}else{
		
		echo 0;
		
		}		
			
   }
   
   if($funcion==12){
	   
	$registro_al = $obj_familia->datos_alumno($rut_alumno);
		$region_com = pg_result($registro_al,10);
		$prov_com = pg_result($registro_al,11);
		
		$rs_com = $obj_familia->get_comunas($region_com,$prov_com);
		?>
        
        <script type="text/javascript">
		$(document).ready(function() {
		$("#_fecha_nac_apo").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
	//buttonImage: 'img/Calendario.PNG',
	});
	
	});
		
		</script>
        
		<br>
        <table width="100%" border="1" style="border-collapse:collapse;"  align="center">
        <tr>
          <td class="cuadro02">Apoderado</td>
          <td class="cuadro02">Sostenedor</td>
          <td class="cuadro02">Relacion</td>
         
        </tr>
        
       <tr>
         <td class="cuadro01"><input type="checkbox" value="1" id="_chk_apoderado" ></td>
         <td class="cuadro01"><input type="checkbox" value="1" id="_chk_sostenedor"></td>
         <td class="cuadro01">
         <select name="relacion" id="relacion" >
         					  <option value="0">Seleccione</option>
                              <option value="1">Padre</option>
                              <option value="2">Madre</option>
                              <option value="3">Otro</option>
                              </select>
                              	
         </td>
       </tr>
        
        <tr>
          <td class="cuadro02">Nombre</td>
          <td class="cuadro02">Apellido Paterno</td>
          <td class="cuadro02">Apellido Materno</td>
        </tr>
        <tr>
        <td class="cuadro01">
        <input type="text" name="_nombre_apo" id="_nombre_apo" />
        </td>
        <td class="cuadro01">
        <input type="text" name="_ape_pat_apo" id="_ape_pat_apo" />
        </td>
        <td class="cuadro01">
        <input type="text" name="_ape_mat_apo" id="_ape_mat_apo" />
        </td>
        </tr>
        
          <tr>
          <td class="cuadro02">Fecha Nacimiento</td>
          <td class="cuadro02">sexo</td>
          <td class="cuadro02">Nacionalidad</td>
        </tr>
        <tr>
        <td class="cuadro01">
         <input type="text" name="_fecha_nac_apo" id="_fecha_nac_apo" />
        </td>
        <td class="cuadro01">
        <input type="hidden" id="tipo_sexo" name="tipo_sexo" value="<?=$fila['sexo']?>" />
                      M:<input type="radio" name="sexo_" id="sexo1" value="2" checked="checked"/>
                      F:<input type="radio" name="sexo_" id="sexo0" value="1"/>
        </td>
        <td class="cuadro01">
                         Chilena :<input type="radio" name="_nacionalidad" id="nacionalidad_2" value="2" checked="checked" />
                         Extranjera :
                         <input type="radio" name="_nacionalidad" id="nacionalidad_1" value="1" />
        <input type="hidden" name="tipo_nacionalidad_" id="tipo_nacionalidad_" value="<?=$fila['nacionalidad']?>" />
        </td>
        </tr>
         <tr>
          <td class="cuadro02">Edad primer Parto (en caso de la madre)</td>
          <td class="cuadro02">Ultimo a&ntilde;o aprobado</td>
          <td class="cuadro02">&nbsp;</td>
        </tr>
        <tr>
          <td class="cuadro01"><input name="txtEDADPRIMERPARTO" type="text" id="txtEDADPRIMERPARTO_" size="10" maxlength="10" /></td>
          <td class="cuadro01"><select name="cmbULTIMOANO" id="cmbULTIMOANO_">
            <option value="1ro BASICO">1ro BASICO</option>
            <option value="2do BASICO">2do BASICO</option>
            <option value="3ro BASICO">3ro BASICO</option>
            <option value="4to BASICO">4to BASICO</option>
            <option value="5to BASICO">5to BASICO</option>
            <option value="6to BASICO">6to BASICO</option>
            <option value="7mo BASICO">7mo BASICO</option>
            <option value="8vo BASICO">8vo BASICO</option>
            <option value="1ro MEDIO">1ro MEDIO</option>
            <option value="2do MEDIO">2do MEDIO</option>
            <option value="3ro MEDIO">3ro MEDIO</option>
            <option value="4to MEDIO">4to MEDIO</option>
            <option value="5to MEDIO">5to MEDIO</option>
            <option value="SUPERIOR">ENSEÑANZA SUPERIOR</option>
          </select></td>
          <td class="cuadro01">&nbsp;</td>
        </tr>
        </table>
        <hr />
        <table width="100%" border="1" style="border-collapse:collapse;" align="center" >
   

    <tr>
    <td class="cuadro02">Calle</td>
    <td class="cuadro02">Numero</td>
    <td class="cuadro02">Block</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_calle_apo_" id="txt_calle_apo_" size="40" value="<?=trim($fila['calle'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_nro_apo_" id="txt_nro_apo_"  value="<?=trim($fila['nro'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_block_apo_" size="30" id="txt_block_apo_" value="<?=trim($fila['block'])?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Depto</td>
    <td class="cuadro02">Villa/Poblacion</td>
    <td class="cuadro02">Comuna</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_depto_apo_" size="40" id="txt_depto_apo_" value="<?=trim($fila['depto'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_villa_apo_" id="txt_villa_apo_" value="<?=trim($fila['villa'])?>" /></td>
    <td class="cuadro01">
    <input type="hidden" name="hidden_region" id="hidden_region" value="<?=$region_com?>" />
         <input type="hidden" name="hidden_prov" id="hidden_prov" value="<?=$prov_com?>" />
    <?php
    $select = "<select name='select_comunas_apo_i' id='select_comunas_apo_i'>
		";
		for($i=0;$i<pg_numrows($rs_com);$i++){
			$fila3=pg_fetch_array($rs_com,$i);
			$select .= "<option value='".$fila3['cor_com']."' >".$fila3['nom_com']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 ?>
    </td>
    </tr>
    
    <tr>
    <td class="cuadro02">Telefono</td>
    <td class="cuadro02">Celular</td>
    <td class="cuadro02">Email</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_fono_apo_" size="40" id="txt_fono_apo_" value="<?=trim($telefono_apo)?>" /></td>
    <td class="cuadro01"><input type="txt_celular" name="txt_celular_apo_" size="20" id="txt_celular_apo_" value="<?=trim($celular_apo)?>"/></td>
    <td class="cuadro01"><input type="text" name="txt_email_apo_" size="30" id="txt_email_apo_" value="<?=trim($email_apo)?>" onblur="verifica_email(this.value)" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Estudios</td>
    <td class="cuadro02">Profesion</td>
    <td class="cuadro02">Ocupacion Actual</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_niv_edu_apo_" size="40" id="txt_niv_edu_apo_" value="<?=trim($nivel_edu_apo)?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_profesion_apo_" size="20" id="txt_profesion_apo_" value="<?=trim($fila['profesion'])?>"/></td>
    <td class="cuadro01"><input type="text" name="txt_ocupacion_apo_" size="20" id="txt_ocupacion_apo_" value="<?=trim($ocupacion_apo)?>"/></td>
    </tr>
    <tr>
      <td width="35" class="cuadro02">Religion</td>
      <td width="36" class="cuadro02">SISTEMA DE SALUD</td>
      <td width="75" class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
    <td  class="cuadro01"><input type="text" name="txt_religion_apo_" size="30" id="txt_religion_apo_" value="<?=trim($religion_apo)?>" /></td>
    <td class="cuadro01">
      <?php
	   $rs_sis_salud = $obj_familia->get_sistema_salud();
       $select = "<select name='select_sistema_salud_apo_' id='select_sistema_salud_apo_' style='width:110'>";
	   $select .= "<option value='0'>Seleccione...</option>";
		for($i=0;$i<pg_numrows($rs_sis_salud);$i++){
			$fila2=pg_fetch_array($rs_sis_salud,$i);
			$select .= "<option value='".$fila2['id_sistema_salud']."' >".$fila2['sistema_salud']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
	 ?>
    </td>
    <td>&nbsp;</td>
    </tr>
	
    </table>
    <?php   
	   
	   
   }
   
			
	/*if($funcion==7){
		//print_r($_POST);
		 $rut_apo = $_POST['rut_apo'];
		
		$result = $obj_familia->Encuentra_Apo($rut_apo);
		
		for($i=0;$i<pg_numrows($result);$i++){
			
			$fila = pg_fetch_array($result,$i);
			//print_r($fila);
			
	        $cod_reg = $fila['region'];
			$cod_prov = $fila['ciudad'];
			$cod_com = $fila['comuna'];		
			
			$relacion=$fila['relacion'];	
		
	$regis_com = $obj_familia->get_comuna($cod_com,$cod_prov,$cod_reg);
	$comuna = pg_result($regis_com,3);		
			
		?><br>
        <table width="100%" border="1" style="border-collapse:collapse;"  align="center">
        <tr>
          <td class="cuadro02">Apoderado</td>
          <td class="cuadro02">Sostenedor</td>
          <td class="cuadro02">&nbsp;</td>
        </tr>
        
       <tr>
         <td class="cuadro01"><input type="checkbox" value="1" id="chk_apoderado"></td>
         <td class="cuadro01"><input type="checkbox" value="1" id="chk_sostenedor"></td>
         <td class="cuadro01">&nbsp;<input type="hidden" id="relacion" value="<?=$relacion?>" /></td>
       </tr>
        
        <tr>
          <td class="cuadro02">Nombre</td>
          <td class="cuadro02">Apellido Paterno</td>
          <td class="cuadro02">Apellido Materno</td>
        </tr>
        <tr>
        <td class="cuadro01">
        <input type="text" name="nombre_apo" id="nombre_apo" value="<?=$fila['nombre_apo'];?>" />
        </td>
        <td class="cuadro01">
        <input type="text" name="ape_pat" id="ape_pat" value="<?=$fila['ape_pat'];?>" />
        </td>
        <td class="cuadro01">
        <input type="text" name="ape_mat" id="ape_mat" value="<?=$fila['ape_mat'];?>" />
        </td>
        </tr>
        
          <tr>
          <td class="cuadro02">Fecha Nacimiento</td>
          <td class="cuadro02">sexo</td>
          <td class="cuadro02">Nacionalidad</td>
        </tr>
        <tr>
        <td class="cuadro01">
         <input type="text" name="fecha_nac2" id="fecha_nac2" value="<?=$fila['fecha_nac']?>" />
        </td>
        <td class="cuadro01">
        <input type="hidden" id="tipo_sexo" name="tipo_sexo" value="<?=$fila['sexo']?>" />
                         F:<input type="radio" name="sexo" id="sexo0" value="0"/>
    					 M:<input type="radio" name="sexo" id="sexo1" value="1"/>
        </td>
        <td class="cuadro01">
                         Chilena :<input type="radio" name="nacionalidad" id="nacionalidad_2" value="2" />
                         Extrangera :<input type="radio" name="nacionalidad" id="nacionalidad_1" value="1" />
        <input type="hidden" name="tipo_nacionalidad" id="tipo_nacionalidad" value="<?=$fila['nacionalidad']?>" />
        </td>
        </tr>
        </table>
        <hr />
        <table width="100%" BORDER=0 CELLPADDING=0 CELLSPACING=0 >
   

    <tr>
    <td class="cuadro02">Calle</td>
    <td class="cuadro02">Numero</td>
    <td class="cuadro02">Block</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_calle" id="txt_calle" size="40" value="<?=trim($fila['calle'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_nro" id="txt_nro"  value="<?=trim($fila['nro'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_block" size="30" id="txt_block" value="<?=trim($fila['block'])?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Depto</td>
    <td class="cuadro02">Villa/Poblacion</td>
    <td class="cuadro02">Comuna</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_depto" size="40" id="txt_depto" value="<?=trim($fila['depto'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_villa" id="txt_villa" value="<?=trim($fila['villa'])?>" /></td>
    <td class="cuadro01">
    <?php
    $select = "<select name='select_comunas' id='select_comunas'>
		";
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['comuna']."' >".utf8_encode($comuna)."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 ?>
    </td>
    </tr>
    
    <tr>
    <td class="cuadro02">Telefono</td>
    <td class="cuadro02">Celular</td>
    <td class="cuadro02">Email</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_fono" size="40" id="txt_fono" value="<?=trim($fila['telefono'])?>" /></td>
    <td class="cuadro01"><input type="txt_celular" name="txt_email" size="20" id="txt_celular" value="<?=trim($fila['celular'])?>"/></td>
    <td class="cuadro01"><input type="text" name="txt_email" size="30" id="txt_email" value="<?=trim($fila['email'])?>" onblur="verifica_email(this.value)" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Estudios</td>
    <td class="cuadro02">Ocupacion Actual</td>
    <td class="cuadro02">Religion</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_niv_edu" size="40" id="txt_niv_edu" value="<?=trim($fila['niv_edu'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_ocupacion" size="20" id="txt_ocupacion" value="<?=trim($fila['ocupacion'])?>"/></td>
    <td class="cuadro01"><input type="text" name="txt_religion" size="30" id="txt_religion" value="<?=trim($fila['religion'])?>" /></td>
    </tr>
    <td width="150" class="cuadro02" colspan="3">SISTEMA DE SALUD</td>
    </tr>
    <tr>
    <td  class="cuadro01"><select name="cmbSALUDP" id="cmbSALUDP">
      <option value="0">seleccione...</option>
      <option value="FONASA">FONASA</option>
      <option value="CONSALUD">CONSALUD</option>
      <option value="BANMEDICA">BANMEDICA</option>
      <option value="CRUZ BLANCA">CRUZ BLANCA</option>
      <option value="MAS VIDA">MAS VIDA</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>

   <?php
     } 
	?>
    </table>
        <?php	
			
			
            }		*/
		
	if($funcion==8){
		$rut_apo = $_POST['rut_apo'];
		$rut_alumno = $_POST['rut_alumno'];
		
		$result = $obj_familia->Crea_relacion($rut_apo,$rut_alumno);
		if($result){
			echo 1;
			}else{
			echo 0;	
			}
		}
		
		
		if($funcion==9){

	  $rut_alumno=$_POST['rut_alumno'];
	  $result = $obj_combos->Datos_Familiar($rut_alumno);
	  if($result){
		$select = "<select name='select_familiar' id='select_familiar' onchange='Modifica_familiar(this.value)'>
		<option value='0'>Seleccione Familiar</option>
		";
						
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$nombre_apo = trim($fila['nombre_apo']);
			$ape_pat = trim($fila['ape_pat']);
			$ape_mat = trim($fila['ape_mat']);
			
			$select .= "<option value='".$fila['rut_apo']."' >".utf8_decode($nombre_apo).' '.utf8_encode($ape_pat).' '.utf8_decode($ape_mat)."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	} 		
	
	if($funcion==10){
		?>
		<script type="text/javascript">
$(document).ready(function() {
	//alert("carga");
	$("#fecha_nac2").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
	//buttonImage: 'img/Calendario.PNG',
	//$.datepicker.regional['es']
	});
	/*************redio sexo******************/
    var sexo = $('#tipo_sexo').val();
    if(sexo==1)
    {
		$('#sexo0').attr('checked',true);
		$("#chk_apoderado").attr("checked","checked");
    }
    else
    {
    
		$("#sexo1").attr("checked","checked");
    }
	/******************radio nacionalidad**********************************/
	var tipo_nacionalidad = $('#tipo_nacionalidad_').val();
    if(tipo_nacionalidad==2)
    {
		$('input:radio[name=nacionalidad]:nth(2)').attr('checked','checked');
    }
    else
    {
		$('input:radio[name=nacionalidad]:nth(1)').attr('checked','checked');
    }
	
	if($('#apo_responsable').val()==1){
		//alert("Apoderado");
		$("#chk_apoderado").attr("checked","checked");	
	}
	if($('#apo_sostenedor').val()==1){
	     $("#chk_sostenedor").attr("checked","checked");
	}
	
	var sis_salud=$('#hidden_sis_salud').val();
	//alert(sis_salud);
	$("#select_sistema_salud_apo option[value="+sis_salud+"]").attr("selected",true);
	
 });
	
</script>
		<?
		$result = $obj_familia->Encuentra_Apo($rut_apo);
		$result_resp = $obj_familia->Datos_Familiar_responsable2($rut_alumno,$rut_apo);
		$fila_resp = pg_fetch_array($result_resp,0);
		$apo_responsable = $fila_resp['responsable'];
		$apo_sostenedor = $fila_resp['sostenedor'];	
		
		//print_r($fila_resp);
			
						
		for($i=0;$i<pg_numrows($result);$i++){
			
			$fila = pg_fetch_array($result,$i);
			//echo "<pre>";
			//print_r($fila);
			//echo "</pre>";
			/*echo "<pre>";
			print_r($fila_resp);
			echo "</pre>";*/
			
			
			
		
		
			$telefono_apo=$fila['telefono'];
			$celular_apo = $fila['celular'];
			$email_apo = $fila['email'];
			$nivel_edu_apo = $fila['nivel_edu'];
			$ocupacion_apo = $fila['ocupacion'];
			$religion_apo = $fila['religion'];
						
	        $cod_reg = $fila['region'];
			$cod_prov = $fila['ciudad'];
			$cod_com = $fila['comuna'];		
			
			$relacion=$fila['relacion'];
			
			if($fila['edad_primer_parto']!=0){
			$fila['edad_primer_parto']=$fila['edad_primer_parto'];	
			}
			else{
			$fila['edad_primer_parto']="";
			}
			
				
			
	$regis_com = $obj_familia->get_comunas($cod_reg,$cod_prov);
	$regis_sis_salud = $obj_familia->get_sistema_salud();
		
			
		?><br>
        <table width="100%" border="1" style="border-collapse:collapse;"  align="center">
        <tr>
          <td class="cuadro02">Rut</td>
          <td class="cuadro02">Apoderado</td>
          <td class="cuadro02">Sostenedor</td>
         
        </tr>
        
       <tr>
       <td class="cuadro01">&nbsp;<?=$fila['rut_apo'].'-'.$fila['dig_rut'];?>
       		 <input type="hidden" id="txt_rut_apo" value="<?=$fila['rut_apo']?>"/>
         <input type="hidden" id="txt_rut_alumnoe" name="txt_rut_alumnoe" value="<?=$rut_alumno?>"/>
             					
       </td>
         <td class="cuadro01"><input name="chk_apoderado" type="checkbox" id="chk_apoderado" value="0">
         <input name="apo_responsable" type="hidden" id="apo_responsable" value="<?=$apo_responsable?>"/></td>
         <td class="cuadro01"><input name="chk_sostenedor" type="checkbox" id="chk_sostenedor" value="0">
         <input name="apo_sostenedor" type="hidden" id="apo_sostenedor" value="<?=$apo_sostenedor?>"/>
         </td>
       </tr>
        
        <tr>
          <td class="cuadro02">Nombre</td>
          <td class="cuadro02">Apellido Paterno</td>
          <td class="cuadro02">Apellido Materno</td>
        </tr>
        <tr>
        <td class="cuadro01">
        <input type="text" name="nombre_apo" id="nombre_apo" value="<?=trim($fila['nombre_apo']);?>" />
        </td>
        <td class="cuadro01">
        <input type="text" name="ape_pat_apo" id="ape_pat_apo" value="<?=trim($fila['ape_pat']);?>" />
        </td>
        <td class="cuadro01">
        <input type="text" name="ape_mat_apo" id="ape_mat_apo" value="<?=trim($fila['ape_mat']);?>" />
        </td>
        </tr>
        
          <tr>
          <td class="cuadro02">Fecha Nacimiento</td>
          <td class="cuadro02">Sexo</td>
          <td class="cuadro02">Nacionalidad</td>
        </tr>
        <tr>
        <td class="cuadro01">
         <input type="text" name="fecha_nac2" id="fecha_nac2" value="<?=CambioFechaDisplay($fila['fecha_nac'])?>" />
        </td>
        <td class="cuadro01">
        <input type="hidden" id="tipo_sexo" name="tipo_sexo" value="<?=$fila['sexo']?>" />
                      M:<input type="radio" name="sexo_" id="sexo1" value="2" <? if($fila['sexo']==2)echo "checked";?>/>
                      F:<input type="radio" name="sexo_" id="sexo0" value="1" <? if($fila['sexo']==1)echo "checked";?>/>
        </td>
        <td class="cuadro01">
                         Chilena :<input type="radio" name="nacionalidad" id="nacionalidad_2" value="2" />
                         Extranjera :
                         <input type="radio" name="nacionalidad" id="nacionalidad_1" value="1" />
        <input type="hidden" name="tipo_nacionalidad_" id="tipo_nacionalidad_" value="<?=$fila['nacionalidad']?>" />
        </td>
        </tr>
        <tr>
          <td class="cuadro02">Edad primer Parto (en caso de la madre)</td>
          <td class="cuadro02">Ultimo a&ntilde;o aprobado</td>
          <td class="cuadro02">&nbsp;</td>
        </tr>
        <tr>
          <td class="cuadro01"><input name="txtEDADPRIMERPARTO" type="text" id="txtEDADPRIMERPARTO" size="10" maxlength="10" value="<?=$fila['edad_primer_parto']?>" /></td>
          <td class="cuadro01"><select name="cmbULTIMOANO" id="cmbULTIMOANO">
            <option value="1ro BASICO" selected="selected">1ro BASICO</option>
            <option value="2do BASICO">2do BASICO</option>
            <option value="3ro BASICO">3ro BASICO</option>
            <option value="4to BASICO">4to BASICO</option>
            <option value="5to BASICO">5to BASICO</option>
            <option value="6to BASICO">6to BASICO</option>
            <option value="7mo BASICO">7mo BASICO</option>
            <option value="8vo BASICO">8vo BASICO</option>
            <option value="1ro MEDIO">1ro MEDIO</option>
            <option value="2do MEDIO">2do MEDIO</option>
            <option value="3ro MEDIO">3ro MEDIO</option>
            <option value="4to MEDIO">4to MEDIO</option>
            <option value="5to MEDIO">5to MEDIO</option>
            <option value="SUPERIOR">ENSEÑANZA SUPERIOR</option>
          </select></td>
          <td class="cuadro01"><? //echo $fila['ultimo_ano_aprobado'] ;?></td>
        </tr>
</table>
        <hr />
        <table width="100%" border="1" style="border-collapse:collapse;"  align="center" >
   

    <tr>
    <td class="cuadro02">Calle</td>
    <td class="cuadro02">Numero</td>
    <td class="cuadro02">Block</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_calle_apo" id="txt_calle_apo" size="40" value="<?=trim($fila['calle'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_nro_apo" id="txt_nro_apo"  value="<?=trim($fila['nro'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_block_apo" size="30" id="txt_block_apo" value="<?=trim($fila['block'])?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Depto</td>
    <td class="cuadro02">Villa/Poblacion</td>
    <td class="cuadro02">Comuna</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_depto_apo" size="40" id="txt_depto_apo" value="<?=trim($fila['depto'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_villa_apo" id="txt_villa_apo" value="<?=trim($fila['villa'])?>" /></td>
    <td class="cuadro01">
    <?php
    $select = "<select name='select_comunas_apo' id='select_comunas_apo'>
		";
		for($i=0;$i<pg_numrows($regis_com);$i++){
			$fila3=pg_fetch_array($regis_com,$i);
			$select .= "<option value='".$fila3['cor_com']."' >".$fila3['nom_com']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 ?>
    </td>
    </tr>
    
    <tr>
    <td class="cuadro02">Telefono</td>
    <td class="cuadro02">Celular</td>
    <td class="cuadro02">Email</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_fono_apo" size="40" id="txt_fono_apo" value="<?=trim($telefono_apo)?>" /></td>
    <td class="cuadro01"><input type="txt_celular" name="txt_celular_apo" size="20" id="txt_celular_apo" value="<?=trim($celular_apo)?>"/></td>
    <td class="cuadro01"><input type="text" name="txt_email_apo" size="30" id="txt_email_apo" value="<?=trim($email_apo)?>"  /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Estudios</td>
    <td class="cuadro02">Profesion</td>
    <td class="cuadro02">Ocupacion Actual</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_niv_edu_apo" size="40" id="txt_niv_edu_apo" value="<?=trim($nivel_edu_apo)?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_profesion_apo" size="20" id="txt_profesion_apo" value="<?=trim($fila['profesion'])?>"/></td>
    <td class="cuadro01"><input type="text" name="txt_ocupacion_apo" size="20" id="txt_ocupacion_apo" value="<?=trim($ocupacion_apo)?>"/></td>
    </tr>
    <tr>
      <td width="35" class="cuadro02">Religion</td>
      <td width="36" class="cuadro02">SISTEMA DE SALUD</td>
      <td width="75" class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
    <td  class="cuadro01"><input type="text" name="txt_religion_apo" size="30" id="txt_religion_apo" value="<?=trim($religion_apo)?>" />
    
    </td>
    <td class="cuadro01"><input type="hidden" id="hidden_sis_salud" value="<?=$fila['sistema_salud']?>" />
    <?php
       $select = "<select name='select_sistema_salud_apo' id='select_sistema_salud_apo' style='width:110'>";
	   $select .= "<option value='0'>Seleccione...</option>";
		for($i=0;$i<pg_numrows($regis_sis_salud);$i++){
			$fila2=pg_fetch_array($regis_sis_salud,$i);
			$select .= "<option value='".$fila2['id_sistema_salud']."' >".$fila2['sistema_salud']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
	 ?></td>
    <td>&nbsp;</td>
    </tr>

	<?php
    } 
    ?>
    </table>
	<?
 }
 
 if($funcion==11){
	
	 $rut_apo = $_POST['rut_apo'];
	 $nombre_apo = utf8_decode($_POST['nombre_apo']);
	 $ape_pat_apo = utf8_decode($_POST['ape_pat_apo']);
	 $ape_mat_apo = utf8_decode($_POST['ape_mat_apo']);
	 $fecha_nac_apo = CambioFecha($_POST['fecha_nac_apo']);
	 $sexo_apo = $_POST['sexo_apo'];
	 $nacionalidad_apo = $_POST['nacionalidad_apo'];
	 $txt_calle_apo = utf8_decode($_POST['txt_calle_apo']);
	 $txt_nro_apo = $_POST['txt_nro_apo'];
	 $txt_block_apo = $_POST['txt_block_apo'];
	 $txt_depto_apo = $_POST['txt_depto_apo'];
	 $txt_villa_apo = utf8_decode($_POST['txt_villa_apo']);
	 $txt_fono_apo = $_POST['txt_fono_apo'];
	 $txt_celular_apo = $_POST['txt_celular_apo'];
	 $txt_email_apo = $_POST['txt_email_apo'];
	 $comuna_apo = $_POST['comuna_apo'];
	 $txt_niv_edu_apo = $_POST['txt_niv_edu_apo'];
	 $txt_ocupacion_apo = utf8_decode($_POST['txt_ocupacion_apo']);
	 $txt_religion_apo = $_POST['txt_religion_apo'];
	 $select_sistema_salud_apo = $_POST['select_sistema_salud_apo'];
	 $relacion_apo = $_POST['relacion_apo'];
	 $sistema_salud_apo = $_POST['select_sistema_salud_apo'];
	 $chk_apoderado=$_POST['chk_apoderado'];
	 $chk_sostenedor=$_POST['chk_sostenedor'];
	 $rut_alumno = $_POST['rut_alumno'];
	 
	 $txt_profesion_apo = $_POST['txt_profesion_apo'];
	 
	  $edad_primer_parto = $_POST['edad_primer_parto'];
	  $ultimo_ano_aprobado = $_POST['ultimo_ano_aprobado'];
	 
	 
	 
	 /*****************VALIDAR DATOS VACIOS*********************************************************************/
	 
	 if($txt_calle_apo==""){
		 $txt_calle_apo="-";
		 }
	 if($txt_nro_apo==""){
		 $txt_nro_apo="-";
		 }	 
	  if($txt_block_apo==""){
		 $txt_block_apo="-";
		 }	 
	  if($txt_depto_apo==""){
		 $txt_depto_apo="-";
		 }	 
	  if($txt_villa_apo==""){
		 $txt_villa_apo="-";
		 }
	  if($txt_fono_apo==""){
		 $txt_fono_apo="-";
		 }	
	  if($txt_celular_apo==""){
		 $txt_celular_apo="-";
		 }	 
	  if($txt_email_apo==""){
		 $txt_email_apo="-";
		 }	 
	  if($txt_niv_edu_apo==""){
		 $txt_niv_edu_apo="-";
		 }	  	 
	  if($txt_ocupacion_apo==""){
		 $txt_ocupacion_apo="-";
		 }
	  if($txt_religion_apo==""){
		 $txt_religion_apo="-";
		 }	
		 
	 if($txt_profesion_apo==""){
		 $txt_profesion_apo="-";
		 } 	
		 
		 if($edad_primer_parto==""){
		 $edad_primer_parto=0;
		 } 	 
	 
	 $result = $obj_familia->Update_Apo($rut_apo,$nombre_apo,$ape_pat_apo,$ape_mat_apo,$fecha_nac_apo,$sexo_apo,$nacionalidad_apo,$txt_calle_apo,$txt_nro_apo,$txt_block_apo,$txt_depto_apo,$txt_villa_apo,$txt_fono_apo,$txt_celular_apo,$txt_email_apo,$comuna_apo,$txt_niv_edu_apo,$txt_ocupacion_apo,$txt_religion_apo,$select_sistema_salud_apo,$relacion_apo,$sistema_salud_apo,$chk_apoderado,$chk_sostenedor,$rut_alumno,$txt_profesion_apo,$edad_primer_parto,$ultimo_ano_aprobado);
	 
	 if($result){
		 echo 1;
		 }else{
		echo 0;		 
	}
	 
   }
   
   if($funcion==13)
   {
	   $rut_alumno=$_POST['rut_alumno'];
	   $rut_apo=$_POST['rut_apo'];
	   $dig_rut_apo=$_POST['dig_rut_apo'];
	   $relacion =$_POST['relacion'];
	   $chk_apoderado=$_POST['chk_apoderado'];
	   $chk_sostenedor=$_POST['chk_sostenedor'];
	   $nombre_apo=utf8_decode($_POST['nombre_apo']);
	   $ape_pat=utf8_decode($_POST['ape_pat']);
	   $ape_mat=utf8_decode($_POST['ape_mat']);
	   $fecha_nac=$_POST['fecha_nac'];
	   $sexo=$_POST['sexo'];
	   $nacionalidad=$_POST['nacionalidad'];
	   $calle_apo=utf8_decode($_POST['calle_apo']);
	   $nro_apo=$_POST['nro_apo'];
	   $block_apo=$_POST['block_apo'];
	   $depto_apo=$_POST['depto_apo'];
	   $villa_apo=utf8_decode($_POST['villa_apo']);
	   $comuna_apo=utf8_decode($_POST['comuna_apo']);
	   $fono_apo=$_POST['fono_apo'];
	   $cel_apo=$_POST['cel_apo'];
	   $mail_apo=utf8_decode($_POST['mail_apo']);
	   $niv_edu_apo=$_POST['niv_edu_apo'];
	   $ocupacion_apo=utf8_decode($_POST['ocupacion_apo']);
	   $religion_apo=$_POST['religion_apo'];
	   $sistema_salud=$_POST['sistema_salud'];
	   $region_apo = $_POST['region_apo'];
	   $prov_apo = $_POST['prov_apo'];
	   $rdb = $_INSTIT;
	   
	   if($nro_apo==""){$nro_apo="S/N";}
	   if($block_apo==""){$block_apo="-";}
	   if($depto_apo==""){$depto_apo="-";}
	   if($villa_apo==""){$villa_apo="-";}
	   if($niv_edu_apo==""){$niv_edu_apo="-";}
	   if($ocupacion_apo==""){$ocupacion_apo="-";}
	   if($religion_apo==""){$religion_apo="-";}
	   
	   $txt_profesion_apo = $_POST['txt_profesion_apo'];
	   
	   $ultimo_ano_aprobado = $_POST['ultimo_ano_aprobado'];
	   
	   $edad_primer_parto = $_POST['edad_primer_parto'];
	   
		   
		   
	   $result = $obj_familia->guarda_apoderado($rut_alumno,$rut_apo,$dig_rut_apo,$relacion,$chk_apoderado,$chk_sostenedor,$nombre_apo,$ape_pat,$ape_mat,$fecha_nac,$sexo,$nacionalidad,$calle_apo,$nro_apo,$block_apo,$depto_apo,$villa_apo,$comuna_apo,$fono_apo,$cel_apo,$mail_apo,$niv_edu_apo,$ocupacion_apo,$religion_apo,$sistema_salud,$region_apo,$prov_apo,$rdb,$txt_profesion_apo,$edad_primer_parto,$ultimo_ano_aprobado);
	   
	    if($result){
		 echo 1;
		 }else{
		 echo 0;		 
	   }
   }
   
   
   if($funcion==14)
   {
	   $rut_apo = $_POST['rut_apo'];
	   $rut_alumno = $_POST['rut_alumno'];
	   $result=$obj_familia->Elimina_apo($rut_apo,$rut_alumno);
	   
	   if($result){
		 echo 1;
		 }else{
		 echo 0;		 
	   }
   }
   
   if($funcion==15)
   {
	   $id_ano = $_POST['id_ano'];
	   $result = $obj_familia->Ano_academico($id_ano);
	   $nro_ano = pg_result($result,0);
	    if($nro_ano){
		 echo $nro_ano;
		 }else{
		 echo 0;		 
	   }
   }
   
   
if($funcion==16)
{
	$rut_alumno=$_POST['rut_alumno'];
	$junaeb = $_POST['junaeb'];
	$chile_sol = $_POST['chile_sol'];
	$beca_muni = $_POST['beca_muni'];
	$compar_inst = $_POST['compar_inst'];
	$cpadre = $_POST['cpadre'];
	$bec_seguro = $_POST['bec_seguro'];
	$bec_otros = $_POST['bec_otros'];
	$ben_pie = $_POST['ben_pie'];
	$ben_sep = $_POST['ben_sep'];
	$ben_puente = $_POST['ben_puente'];
	
	$arr_becas_alu = $_POST['arr_becas_alu'];
	
	$result=$obj_familia->Update_becas($rut_alumno,$junaeb,$chile_sol,$beca_muni,$compar_inst,$cpadre,$bec_seguro,$bec_otros,$ben_pie,$ben_sep,$ben_puente,$arr_becas_alu);
	if($result){
		 echo 1;
		 }else{
		 echo 0;		 
	   }	
}

if($funcion==17)
{
	$rdb=$_POST['rdb'];
	$res_grup_int = $obj_familia->get_grupos_inst($rdb);	
	?>
    
	<table width="100%">
    <tr class="cuadro01">
    <td width="987" align="right">&nbsp;</td>
    <td width="224" align="right" class="cuadro01"><input type="button" class="botonXX" title="Guardar" value="Guardar" onclick="guarda_grupo()">&nbsp;<input type="button" class="botonXX" id="vuelve" value="Volver" onclick="vuelve_g()" /></td>
   
    </tr>
    </table>
	
	 <table width="100%" cellpadding="1" cellspacing="1" border="1" style="border-collapse:collapse">
    <tr>
    <td width="45%" class="cuadro02"><div align="left">Nombre</div></td>
	<td width="45%" class="cuadro02"><div align="left">Descripci&oacute;n</div></td>
    <td width="10%" class="cuadro02"><div align="center">Agregar</div></td>
    </tr>
    
    <?php for($x=0;$x < pg_num_rows($res_grup_int);$x++){
		  $fila_g_i = pg_fetch_array($res_grup_int,$x);
		?>
		<tr>
        <td class="cuadro01"><?=$fila_g_i['nombre'];?></td>
        <td class="cuadro01"><?=$fila_g_i['descripcion'];?></td>
        <td class="cuadro01" align="center">
        
        <input type="checkbox" name="add_grupo<?=$x?>" id="add_grupo<?=$x?>" value="<?=$fila_g_i['id_grupo']?>" onclick="guarda_grupo(<?=$fila_g_i['id_grupo']?>,this.name)"></td>
        </tr>
		<?
		}
	?>
    <input type="hidden" name="contador_g" id="contador_g" value="<?=$x?>" />
    </table>
    <?
    }
	
	if($funcion==18)
	{
		$rut_alumno = $_POST['rut_alumno'];
		$id_grupo = $_POST['id_grupo'];
		$id_ano = $_POST['id_ano'];
		$id_curso = $_POST['id_curso'];
		
		$result=$obj_familia->guarda_grupo($rut_alumno,$id_grupo,$id_ano,$id_curso);
		if($result){
		 echo 1;
		 }else{
		 echo 0;		 
	   }
	}
	
	if($funcion==19)
	{
		$id_aux=$_POST['id_aux'];
		$result = $obj_familia->Elimina_grupo($id_aux);
		if($result){
		 echo 1;
		 }else{
		 echo 0;		 
	   }
			
	}
	
	if($funcion==20)
	{
		?>
		<script type="text/javascript">
		 $("#fecha_ent").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy'
	//buttonImage: 'img/Calendario.PNG',
	});
	 
		</script>
		<?
		$nombre_apo_ = $_POST['nombre_apo'];
		?>
        <table width="100%">
        <tr>
        <td class="cuadro01">
        <div id="modifica_becas" style="float:right;"><input align="right" type="button" class="botonXX" name="agregar_entrevista" id="agregar_entrevista" value="Guardar Entrevista" title="Agregar Entrevista" onclick="guardar_entrevistas()" />
        <input align="right" type="button" class="botonXX" name="volver_entrevista"6 id="volver_entrevista" value="Volver" title="Volver Atras" onclick="volver_ent()" /></div>
        </td>
        </tr>
        </table>
        	
        	<table width="100%" style="border-collapse:collapse" border="1">
            <tr>
            <td class="cuadro02">Apoderado</td>
            <td class="cuadro01"><?=$nombre_apo_;?></td>
            </tr>
            <tr>
            <td class="cuadro02">Fecha</td>
            <td class="cuadro01"><input type="text" name="fecha_ent" id="fecha_ent" /></td>
            </tr>
            <tr>
            <td class="cuadro02">Asunto</td>
            <td class="cuadro01"><input type="text" name="asunto_ent" id="asunto_ent" /></td>
            </tr>
            <tr>
              <td class="cuadro02">Tipo</td>
              <td class="cuadro01"><input name="tipo_entrevista" id="tipo_entrevista1" type="radio" value="1" />Rendimiento <input name="tipo_entrevista" id="tipo_entrevista2" type="radio" value="2" />Conducta</td>
            </tr>
            <tr>
            <td class="cuadro02">Contenido</td>
            <td class="cuadro01"><textarea cols="60" rows="3" id="contenido_ent" name="contenido_ent"></textarea></td>
            </tr>
            </table>
        <?
	}
	
	if($funcion==21){
		$rut_apo = $_POST['rut_apo'];
		$rut_alumno = $_POST['rut_alumno'];
		$id_ano = $_POST['id_ano'];
		$rdb = $_POST['rdb'];
		$fecha_ent = CambioFecha($_POST['fecha_ent']);
		$asunto_ent = $_POST['asunto_ent'];
		$contenido_ent = $_POST['contenido_ent'];
		$tipo_entrevista = $_POST['tipo_entrevista'];
		
		$result = $obj_familia->guarda_entrevista($rdb,$id_ano,$rut_alumno,$rut_apo,$fecha_ent,$asunto_ent,$contenido_ent,$tipo_entrevista);
		if($result){
		 echo 1;
		 }else{
		 echo 0;		 
	   }
	}
	
	if($funcion==22){
		
		$id_entrevista = $_POST['id_entrevista'];
		$result = $obj_familia->elimina_ent($id_entrevista);
		if($result){
		 echo 1;
		 }else{
		 echo 0;		 
	   }
 	}
	
	if($funcion == 23){
		  $id_ano=$_POST['id_ano'];	
		  $result = $obj_combos->get_cursos($id_ano);
		  if($result){
		$select = "<select name='select_cursos' id='select_cursos'>";
						
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$id_curso = $fila['id_curso'];
			$nombre_curso=CursoPalabra($id_curso,0,$conn);
			
			$select .= "<option value='".$fila['id_curso']."' >".$nombre_curso."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}

if($funcion==25){
	
	//var_dump($_POST);
	
		if($nivel_certificado==""){
		$nivel_certificado="-";
		}	
		if($plazo_autorizacion==""){
		$plazo_autorizacion="-";
		}	
		
		if($txtaporteCGP==""){
		$txtaporteCGP=0;
		}	
		
		if($abono_matricula==""){
		$abono_matricula="-";
		}	
		
		if($numboleta==""){
		$numboleta="-";
		}	
		
	$result=$obj_combos->actualiza_datos_documentos($bool_traecertificados,$bool_traecertificadosant,$nivel_certificado,$bool_secreduc,$plazo_autorizacion,$bool_manualconvivencia,$txtaporteCGP,$bool_pagomatricula,$abono_matricula,$numboleta,$bool_exentomatricula,$rut_alumno,$id_ano);
		 
if($result){
		 echo 1;
		 }else{
		 echo 0;		 
	   }
//echo 1;
}
	
 ?>
