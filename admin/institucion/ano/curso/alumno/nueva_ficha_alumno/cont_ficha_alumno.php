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
	$pais_origen= $_POST['pais_origen'];
	$enc_matricula=$_POST['enc_matricula'];
	$num_mat=intval($_POST['num_mat']);
	
	$bool_deporte=$_POST['bool_deporte'];
	$txt_deporte=$_POST['txt_deporte'];
	
	
	
	
	$ret = $_POST['ret'];
	
	$datos_interes = utf8_decode($_POST['datos_interes']);
	$observacion = utf8_decode($_POST['observacion']);
	$observacion_salud = utf8_decode($_POST['observacion_salud']);
	
	if($_POST['controlsano']!=""){
		$controlsano = CambioFecha($_POST['controlsano']);
		}
		else{
			$controlsano = "1111-11-11";
		}
		
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
		
		
	$txt_eleccion=(strlen($txt_eleccion)>0)?$txt_eleccion:"-";
	$pasaporte=(strlen($pasaporte)>0)?$pasaporte:"-";
	
	$estilo_aprendizaje=$_POST['estilo_aprendizaje'];
	$celular=$_POST['celular'];
	
	
	$rut_sinpuntos2 = $_POST['rut_sinpuntos2'];
	$nombre_retira2 = utf8_decode($_POST['nombre_retira2']);
	$parentesco_retira2 = $_POST['parentesco_retira2'];
	$telefono_retira2 = $_POST['telefono_retira2'];
	$cel_retira2 = $_POST['cel_retira2'];
	$rut_sinpuntos2 = $_POST['rut_sinpuntos2'];
	
	$nombre_retira3 = utf8_decode($_POST['nombre_retira3']);
	$parentesco_retira3 = $_POST['parentesco_retira3'];
	$telefono_retira3 = $_POST['telefono_retira3'];
	$cel_retira3 = $_POST['cel_retira3'];
	
	$aut_vacuna=$_POST['aut_vacuna'];	
			
	
	
	$txt_subsidio=$_POST['txt_causajuzgado'];
	$txt_causajuzgado=$_POST['txt_subsidio'];
	$txt_fichaps=$_POST['txt_fichaps'];
	$ben_prog_prot_social=$_POST['ben_prog_prot_social'];
	
	
		
		$result = $obj_combos->actualiza_datos_personales($rut_alumno,$dig_rut,$nombre_alum,$ape_pat,$ape_mat,$fecha_nac,$sexo,$nacionalidad,$alum_emb,$alum_ind,$proced_alum,$con_quien_vive,$txt_calle,$txt_nro,$txt_block,$txt_depto,$txt_villa,$txt_fono,$txt_email,$region,$provincia,$comuna,$curso_rep,$especialista,$al_pie,$al_sep,$al_retos,$al_puente,$al_fc,$cmbSANCION,$txtENFERMEDAD,$txtCIRUGIA,$txtMEDICAMENTO,$txtALERGIA,$txtFISICA,$txtFIEBRE,$txtSEGURO,$aut_emergencia,$rut_sinpuntos,$nombre_retira,$parentesco_retira,$telefono_retira,$cel_retira,$viaja_furgon,$nombre_tio,$fono_furgon,$fecham,$alumno_ret,$fechar,$motivo_r,$cmb_condicional,$opta_religion,$ed_diferencial,$al_integrado,$id_curso,$nro_ano,$id_ano,$datos_interes,$observacion,$observacion_salud,$ret,$cmbMOTIVO,$religion,$telefono_recado,$tipo_parto,$edad_madre_nace,$peso_nace,$talla_nace,$s_salud,$probdentales,$controldental,$famenfermo,$jefe_hogar,$ocup_jefehogar,$num_grupofamiliar,$ingresos,$tipo_vivienda,$cant_dormitorios,$cant_banos,$espacio_juego,$espacio_estudio,$hizo_jardin,$carinoso,$sociable,$curioso,$org_participa,$con_quien_estudia,$obse_general,$figura_paterna,$jefe_aporta,$controlsano,$bool_neurologo,$bool_psicopedagogo,$bool_psicologo,$bool_tieneluz,$bool_tieneagua,$bool_tienealcantarillado,$bool_retirosolo,$bool_otratamiento,$bool_tratactual,$bool_tastornosaprendizaje,$material_vivienda,$estado_vivienda,$txt_otratamiendo,$txt_tratactual,$txt_trastornosaprendizaje,$cant_hermanos,$num_hermano,$txt_eleccion,$bool_cambioropa,$bool_tomafoto,$bool_facebook,$pais_origen,$pasaporte,$estilo_aprendizaje,$celular,$enc_matricula,$rut_sinpuntos2,$nombre_retira2,$parentesco_retira2,$telefono_retira2,$cel_retira2,$rut_sinpuntos3,$nombre_retira3,$parentesco_retira3,$telefono_retira3,$cel_retira3,utf8_decode($txt_etnia),$aut_vacuna,$num_mat,$txt_subsidio,$txt_causajuzgado,$txt_fichaps,$ben_prog_prot_social,$bool_deporte,$txt_deporte);
		
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
          <td class="cuadro02">Estado Civil</td>
        </tr>
        <tr>
          <td class="cuadro01"><?=$fila['edad_primer_parto'];?></td>
          <td class="cuadro01"><?=$fila['ultimo_ano_aprobado'];?></td>
          <td class="cuadro01"><?
		  switch($fila['estado_civil']){
			  case 1: $est="SOLTERO(A)";break;
			  case 2: $est="CASADO(A)";break;
			  case 3: $est="VIUDO(A)";break;
			  case 4: $est="DIVORCIADO(A)";break;
			  case 5: $est="OTROS";break;
			  default: $est="SIN INFORMACI&Oacute;n";break;
			  
		 }
		  
		  echo $est;?></td>
        </tr>
         <tr>
          <td class="cuadro02">Pa&iacute;s origen de Apoderado(a) o Tutor(a)</td>
          <td class="cuadro02">&nbsp;</td>
          <td class="cuadro02">&nbsp;</td>
        </tr>
        <tr>
          <td class="cuadro01">
          <?php $lip = $obj_familia->pOrigen1($fila['pais_origen']);?>
      <?=pg_result($lip,2);?>
          </td>
          <td class="cuadro01">&nbsp;</td>
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
     <tr>
      <td class="cuadro02">Tipo de trabajo</td>
      <td class="cuadro02">&nbsp;</td>
      <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr >
      <td class="cuadro01"><?
		  switch($fila['tipo_trabajo']){
			  case 1: $ttp="JORNADA COMPLETA";break;
			  case 2: $ttp="JORNADA PARCIAL";break;
			  case 3: $ttp="NO TRABAJA EN ESTE MOMENTO";break;
			  case 4: $ttp="NO ESTA TRABAJANDO PERO ESTA EN BUSQUEDA";break;
			  case 5: $ttp="OTROS";break;
			  default: $ttp="SIN INFORMACI&Oacute;n";break;
			  
		 }
		  
		  echo $ttp;?></td>
      <td class="cuadro01">&nbsp;</td>
      <td class="cuadro01">&nbsp;</td>
    </tr>
    <?php //if($_PERFIL==0){
		$rs_gruposApo = $obj_familia->get_grupos($fila['rut_apo']);
		?>
    <tr >
      <td colspan="3" class="cuadro02">Grupos Mensajer&iacute;a</td>
      </tr>
    <tr >
      <td colspan="3" align="center" class="cuadro01">
     <?php for($gg=0;$gg<pg_numrows($rs_gruposApo);$gg++){
		 $filag= pg_fetch_array($rs_gruposApo,$gg);
		 echo "- ".$filag['nombre']."<br>";
		 ?>
         
      <?php  }?>
      </td>
      </tr>
      <?php // }?>
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
		$com_com = pg_result($registro_al,12);
		
		$rs_com = $obj_familia->get_comunas($region_com,$prov_com);
		?>
        
        <script type="text/javascript">
		$(document).ready(function() {
			
				$('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
          });
			
		$("#_fecha_nac_apo").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
	//buttonImage: 'img/Calendario.PNG',
	});
	
	 get_provincias($("#hidden_region").val(),$("#hidden_prov").val());
	 
	 get_comunas($("#hidden_prov").val()+","+$("#hidden_region").val());
	
	});	
	
	
	function get_provincias(cod_reg,x)
{
   
   var funcion = 2;
   var cod_prov = x + ',' +cod_reg;
 
	var parametros='funcion='+funcion+'&cod_reg='+cod_reg;	
	//alert (parametros);	
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  alert(data);
	    $("#ciudad_apo").html(data);
		//if(x==1){
		$("#select_provincias option[value="+cod_prov+"]").attr("selected",true);
		//}
		//else{
	//	$("#select_provincias option[value=0]").attr("selected",true);	
		//}
		//$("#select_comunas option[value=0]").attr("selected",true);
		
	   }
	})	
}	

function get_comunas(cod_prov,cod_reg)
{
	var cod_com = $('#txt_comuna').val();
	//alert (cod_com);
	if(cod_reg == undefined){
		
		var separa = cod_prov.split(',');
		var cod_prov=separa[0];
		var cod_reg=separa[1];
		}
	
   var funcion = 3;
		
	var parametros='funcion='+funcion+'&cod_reg='+cod_reg+'&cod_prov='+cod_prov;	
	//alert (parametros);	
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  alert(data);
	    $("#comuna_apo").html(data);
		$('#select_comunas option[value='+cod_com+']').attr("selected",true);
		
	//document.getElementById('select_comunas').value = cod_com;
		
	   }
	})	
}	
	
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
          <td class="cuadro02">Sexo</td>
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
          <td class="cuadro02">Estado Civil</td>
        </tr>
        <tr>
          <td class="cuadro01"><input name="txtEDADPRIMERPARTO" type="text" id="txtEDADPRIMERPARTO_" size="10" maxlength="10" /></td>
          <td class="cuadro01"><select name="cmbULTIMOANO" id="cmbULTIMOANO_">
            <option value="1ro BASICO">1ro BASICO</option>
            <option value="2do BASICO" selected="selected">2do BASICO</option>
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
            <option value="ENSEÑANZA SUPERIOR">ENSE&Ntilde;ANZA SUPERIOR</option>
          </select></td>
          <td class="cuadro01"><select name="cmbESTADOCIVILX" id="cmbESTADOCIVILX">
            <option value="0">seleccione...</option>
            <option value="1">SOLTERO(A)</option>
            <option value="2">CASADO(A)</option>
            <option value="3">VIUDO(A)</option>
            <option value="4">DIVORCIADO(A)</option>
            <option value="5">OTRO</option>
          </select></td>
        </tr>
         <tr>
          <td class="cuadro02">Pa&iacute;s origen de Apoderado(a) o Tutor(a)</td>
          <td class="cuadro02">&nbsp;</td>
          <td class="cuadro02">&nbsp;</td>
        </tr>
        <tr>
          <td class="cuadro01">
          <?php $lista_paises = $obj_familia->pOrigen(); ?>
    <select name="pais_origen_apo" id="pais_origen_apo" >
    <option value="0">Seleccione pa&iacute;s origen</option>
    <?php for($pa=0;$pa<pg_numrows($lista_paises);$pa++){
		$fila_pais = pg_fetch_array($lista_paises,$pa);
		?>
     <option value="<?php echo $fila_pais['id'] ?>" ><?php echo $fila_pais['nombre'] ?></option>
    <?php }?>
    </select>
          </td>
          <td class="cuadro01">&nbsp;</td>
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
    <td class="cuadro02">&nbsp;</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_depto_apo_" size="40" id="txt_depto_apo_" value="<?=trim($fila['depto'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_villa_apo_" id="txt_villa_apo_" value="<?=trim($fila['villa'])?>" /></td>
    <td class="cuadro01">
    <input type="hidden" name="hidden_region" id="hidden_region" value="<?=$region_com?>" />
         <input type="hidden" name="hidden_prov" id="hidden_prov" value="<?=$prov_com?>" />
         <input type="hidden" name="txt_comuna" id="txt_comuna" value="<?=$com_com ?>" />
        
        <!-- <?php
    $select = "<select name='select_comunas_apo_i' id='select_comunas_apo_i'>
		";
		for($i=0;$i<pg_numrows($rs_com);$i++){
			$fila3=pg_fetch_array($rs_com,$i);
			$select .= "<option value='".$fila3['cor_com']."' >".$fila3['nom_com']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 ?>--> </td>
    </tr>
     <?
		  $regis_com = $obj_familia->get_regiones();
		  ?>
    <tr>
      <td class="cuadro02">Regi&oacute;n </td>
      <td class="cuadro02">Ciudad</td>
      <td class="cuadro02">Comuna</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php
    $select = "<select name='select_region_apo_i' id='select_region_apo_i' onchange='get_provincias(this.value,1)'>
		";
		for($i=0;$i<pg_numrows($regis_com);$i++){
			$fila3=pg_fetch_array($regis_com,$i);
			$valr = ($region_com==$fila3['cod_reg'])?"selected":"";
			
			$select .= "<option value='".$fila3['cod_reg']."' $valr >".$fila3['nom_reg']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 ?></td>
      <td class="cuadro01">
	  <div id="ciudad_apo">
	  </div></td>
      <td class="cuadro01">
	   <div id="comuna_apo">
	 </div>
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
    <td class="cuadro01"><input type="text" name="txt_email_apo_" size="30" id="txt_email_apo_" value="<?=trim($email_apo)?>"  /></td>
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
      <td width="75" class="cuadro02">Tipo Empleo</td>
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
    <td class="cuadro01"><select name="cmbTIPOTRABAJOX" id="cmbTIPOTRABAJOX">
      <option value="0">seleccione...</option>
      <option value="1" <?php echo ($fila['tipo_trabajo']==1)?"selected":"" ?>>JORNADA COMPLETA</option>
      <option value="2" <?php echo ($fila['tipo_trabajo']==2)?"selected":"" ?>>JORNADA PARCIAL</option>
      <option value="3" <?php echo ($fila['tipo_trabajo']==3)?"selected":"" ?>>NO TRABAJA EN ESTE MOMENTO</option>
      <option value="4" <?php echo ($fila['tipo_trabajo']==44)?"selected":"" ?>>NO ESTA TRABAJANDO PERO ESTA EN BUSQUEDA</option>
      <option value="5" <?php echo ($fila['tipo_trabajo']==5)?"selected":"" ?>>OTRO</option>
    </select></td>
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
	
		$('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
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
	
	
	
		$('.pasar').click(function() { return !$('#origen option:selected').remove().appendTo('#destino'); });  
		$('.quitar').click(function() { return !$('#destino option:selected').remove().appendTo('#origen'); });
		$('.pasartodos').click(function() { $('#origen option').each(function() { $(this).remove().appendTo('#destino'); }); });
		$('.quitartodos').click(function() { $('#destino option').each(function() { $(this).remove().appendTo('#origen'); }); });
		//$('.submit').click(function() { $('#destino option').prop('selected', 'selected'); });
	 
	 
	 $('.pasaro').click(function() { return !$('#eva_origen option:selected').remove().appendTo('#eva_destino'); });  
		$('.quitaro').click(function() { return !$('#eva_destino option:selected').remove().appendTo('#eva_origen'); });
		$('.pasartodoso').click(function() { $('#eva_origen option').each(function() { $(this).remove().appendTo('#eva_destino'); }); });
		$('.quitartodoso').click(function() { $('#eva_destino option').each(function() { $(this).remove().appendTo('#eva_origen'); }); });
		//$('.submit').click(function() { $('#destino option').prop('selected', 'selected'); });
	 
	 get_provincias($("#select_region_apo_e").val(),$("#hidden_prov2").val());
	 
	 get_comunas($("#hidden_prov2").val()+","+$("#select_region_apo_e").val());
	
	
 });
 
 function get_provincias(cod_reg,x)
{
   
   var funcion = 2;
   var cod_prov = x + ',' +cod_reg;
  
 
	var parametros='funcion='+funcion+'&cod_reg='+cod_reg;	
	//alert (parametros);	
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  alert(data);
	    $("#ciudad_apo2").html(data);
		
				
		$("#ciudad_apo2 select").removeAttr("name");
		$("#ciudad_apo2 select").removeAttr("id");
		
   $("#ciudad_apo2 select").attr("id","select_provincias_e");
    $("#ciudad_apo2 select").attr("name","select_provincias_e");
   
		//if(x==1){
		$("#select_provincias_e option[value="+cod_prov+"]").attr("selected",true);
		//}
		//else{
	//	$("#select_provincias option[value=0]").attr("selected",true);	
		//}
		//$("#select_comunas option[value=0]").attr("selected",true);
		
	   }
	})	
}	

function get_comunas(cod_prov,cod_reg)
{
	var cod_com = $('#txt_comuna').val();
	//alert (cod_com);
	if(cod_reg == undefined){
		
		var separa = cod_prov.split(',');
		var cod_prov=separa[0];
		var cod_reg=separa[1];
		}
	
   var funcion = 3;
		
	var parametros='funcion='+funcion+'&cod_reg='+cod_reg+'&cod_prov='+cod_prov;	
	//alert (parametros);	
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  alert(data);
	    $("#comuna_apo2").html(data);
		
		
		$("#comuna_apo2 select").removeAttr("name");
		$("#comuna_apo2 select").removeAttr("id");
		
		 $("#comuna_apo2 select").attr("id","select_comunas_e");
    $("#comuna_apo2 select").attr("name","select_comunas_e");
		
		$('#select_comunas_e option[value='+cod_com+']').attr("selected",true);
		
	//document.getElementById('select_comunas').value = cod_com;
		
	   }
	})	
}	
	
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
          <td class="cuadro02">Estado Civil</td>
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
          </select>
          <? //echo $fila['ultimo_ano_aprobado'] ;?></td>
          <td class="cuadro01"><select name="cmbESTADOCIVIL" id="cmbESTADOCIVIL">
            <option value="0">seleccione...</option>
            <option value="1" <?php echo ($fila['estado_civil']==1)?"selected":"" ?>>SOLTERO(A)</option>
            <option value="2" <?php echo ($fila['estado_civil']==2)?"selected":"" ?>>CASADO(A)</option>
            <option value="3" <?php echo ($fila['estado_civil']==3)?"selected":"" ?>>VIUDO(A)</option>
            <option value="4" <?php echo ($fila['estado_civil']==4)?"selected":"" ?>>DIVORCIADO(A)</option>
            <option value="5" <?php echo ($fila['estado_civil']==5)?"selected":"" ?>>OTRO</option>
          </select></td>
          </tr>
           <tr>
          <td class="cuadro02">Pa&iacute;s origen de Apoderado(a) o Tutor(a)</td>
          <td class="cuadro02">&nbsp;</td>
          <td class="cuadro02">&nbsp;</td>
        </tr>
        <tr>
          <td class="cuadro01">
          <?php $lista_paises = $obj_familia->pOrigen(); ?>
    <select name="pais_origen_apo" id="pais_origen_apo" >
    <option value="0">Seleccione pa&iacute;s origen</option>
    <?php for($pa=0;$pa<pg_numrows($lista_paises);$pa++){
		$fila_pais = pg_fetch_array($lista_paises,$pa);
		?>
     <option value="<?php echo $fila_pais['id'] ?>" <?php echo ($fila['pais_origen']==$fila_pais['id'])?"selected":"" ?> ><?php echo $fila_pais['nombre'] ?></option>
    <?php }?>
    </select>
          </td>
          <td class="cuadro01">&nbsp;</td>
          <td class="cuadro01">&nbsp;</td>
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
    <td class="cuadro02"><!--Comuna--></td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_depto_apo" size="40" id="txt_depto_apo" value="<?=trim($fila['depto'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_villa_apo" id="txt_villa_apo" value="<?=trim($fila['villa'])?>" /></td>
    <td class="cuadro01"><!--<?php
    $select = "<select name='select_comunas_apo' id='select_comunas_apo'>
		";
		for($i=0;$i<pg_numrows($regis_com);$i++){
			$fila3=pg_fetch_array($regis_com,$i);
			$select .= "<option value='".$fila3['cor_com']."' >".$fila3['nom_com']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 ?>-->
      </td>
    </tr>
   
    <tr>
      <td class="cuadro02">Regi&oacute;n </td>
      <td class="cuadro02">Ciudad</td>
      <td class="cuadro02">Comuna<input type="hidden" name="hidden_region2" id="hidden_region2" value="<?=$cod_reg?>" />
      <input type="hidden" name="hidden_prov2" id="hidden_prov2" value="<?=$cod_prov?>" />
      <input type="hidden" name="txt_comuna2" id="txt_comuna2" value="<?=$cod_com ?>" /></td>
    </tr>
    <tr>
      <td class="cuadro01"><?php
	    $regis_com = $obj_familia->get_regiones();
    $select = "<select name='select_region_apo_e' id='select_region_apo_e' onchange='get_provincias(this.value,1)'>
		";
		for($i=0;$i<pg_numrows($regis_com);$i++){
			$fila3=pg_fetch_array($regis_com,$i);
			$valr = ($cod_reg==$fila3['cod_reg'])?"selected":"";
			
			$select .= "<option value='".$fila3['cod_reg']."' $valr >".$fila3['nom_reg']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 ?></td>
      <td class="cuadro01">
      <div id="ciudad_apo2">
        </div></td>
      <td class="cuadro01"><div id="comuna_apo2"></div></td>
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
      <td width="75" class="cuadro02">Tipo Empleo</td>
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
    <td class="cuadro01"><select name="cmbTIPOTRABAJOM" id="cmbTIPOTRABAJOM">
      <option value="0">seleccione...</option>
      <option value="1" <?php echo ($fila['tipo_trabajo']==1)?"selected":"" ?>>JORNADA COMPLETA</option>
      <option value="2" <?php echo ($fila['tipo_trabajo']==2)?"selected":"" ?>>JORNADA PARCIAL</option>
      <option value="3" <?php echo ($fila['tipo_trabajo']==3)?"selected":"" ?>>NO TRABAJA EN ESTE MOMENTO</option>
      <option value="4" <?php echo ($fila['tipo_trabajo']==4)?"selected":"" ?>>NO ESTA TRABAJANDO PERO ESTA EN BUSQUEDA</option>
      <option value="5" <?php echo ($fila['tipo_trabajo']==5)?"selected":"" ?>>OTRO</option>
    </select></td>
    </tr>
    <?php //if($_PERFIL==0){
		$rsg = $obj_familia->get_grupos_inst_apo($_INSTIT,$fila['rut_apo']);
		$rs_gruposApo = $obj_familia->get_grupos($fila['rut_apo']);

		?>
 <tr>
    <td colspan="3"  class="cuadro02">Grupos Mensajer&iacute;a</td>
      </tr>
    <tr>
      <td colspan="3" align="center"  class="cuadro01"><table width="90%" border="0">
        <tr>
          <td width="44%" align="center"><select name="eva_origen[]" multiple="multiple" size="8" style="width:250px; font-size:10px" id="eva_origen" >
            <?php for($t=0;$t<pg_numrows($rsg);$t++){
				$fila_tipo = pg_fetch_array($rsg,$t);?>
            <option value="<?php echo $fila_tipo['id_grupo'] ?>"><?php echo $fila_tipo['nombre'] ?></option>
            <?php }?>
          </select></td>
          <td width="18%" align="center"><p>
    <input type="button" class="pasaro izq botonXX" value="Pasar &raquo;">
  </p>
    <p>
      <input type="button" class="quitaro der botonXX" value="&laquo; Quitar">
      <br />
      <br />
      <input type="button" class="pasartodoso izq botonXX" value="Todos &raquo;" >
    </p>
    <p>
      <input type="button" class="quitartodoso der botonXX" value="&laquo; Todos">
    </p></td>
          <td width="38%" align="center"><select name="eva_destino[]" id="eva_destino" multiple="multiple" size="8" style="width:250px; font-size:10px">
            <?php for($t=0;$t<pg_numrows($rs_gruposApo);$t++){
				$fila_tipo = pg_fetch_array($rs_gruposApo,$t);?>
            <option value="<?php echo $fila_tipo['id_grupo'] ?>"><?php echo $fila_tipo['nombre'] ?></option>
            <?php }?>
          </select></td>
        </tr>
      </table></td>
      </tr>
      <?php //}?>
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
	 
	 $txt_profesion_apo = utf8_decode($_POST['txt_profesion_apo']);
	 
	  $edad_primer_parto = $_POST['edad_primer_parto'];
	  $ultimo_ano_aprobado = $_POST['ultimo_ano_aprobado'];
	  
	  $estado_civil = $_POST['estado_civil'];
	  $tipo_trabajo = $_POST['tipo_trabajo'];
	 $region_apo = $_POST['region_apo'];
	  $ciudad_apo = $_POST['ciudad_apo'];
	 
	 
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
		 
		 
		//grupos
		 $gr = explode(",",$grup);
		 //echo "a.".$grup."gr.".count($gr);
		 if(strlen($grup)>0){
			 $resulee=$obj_familia->Elimina_grupo_apo($rut_apo);
			for($g=0;$g<count($gr);$g++){
			//echo $gr[$g];
			$resultg=$obj_familia->guarda_grupo_apo($rut_apo,$gr[$g],$_ANO,$_CURSO);
		
			}	 
		}
		
		$pais_origen_apo = $pais_origen_apo;
		
	 $result = $obj_familia->Update_Apo($rut_apo,$nombre_apo,$ape_pat_apo,$ape_mat_apo,$fecha_nac_apo,$sexo_apo,$nacionalidad_apo,$txt_calle_apo,$txt_nro_apo,$txt_block_apo,$txt_depto_apo,$txt_villa_apo,$txt_fono_apo,$txt_celular_apo,$txt_email_apo,$comuna_apo,$txt_niv_edu_apo,$txt_ocupacion_apo,$txt_religion_apo,$select_sistema_salud_apo,$relacion_apo,$sistema_salud_apo,$chk_apoderado,$chk_sostenedor,$rut_alumno,$txt_profesion_apo,$edad_primer_parto,$ultimo_ano_aprobado,$estado_civil,$tipo_trabajo,$region_apo,$ciudad_apo,$pais_origen_apo);
	 
	 if($result){
		 
		  
		 
		 
		 
		 echo 1;
		 }else{
		echo 0;		 
	}
	 
   }
   
   if($funcion==13)
   {
	  // show($_POST);
	   
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
	   
	   $edad_primer_parto = ($_POST['edad_primer_parto']=="")?0:intval($_POST['edad_primer_parto']);
	   
	    $estado_civil = $_POST['estado_civil'];
		$tipo_trabajo = $_POST['tipo_trabajo'];
	   $pais_origen_apo = $_POST['pais_origen_apo'];
		   
		   
	   $result = $obj_familia->guarda_apoderado($rut_alumno,$rut_apo,$dig_rut_apo,$relacion,$chk_apoderado,$chk_sostenedor,$nombre_apo,$ape_pat,$ape_mat,$fecha_nac,$sexo,$nacionalidad,$calle_apo,$nro_apo,$block_apo,$depto_apo,$villa_apo,$comuna_apo,$fono_apo,$cel_apo,$mail_apo,$niv_edu_apo,$ocupacion_apo,$religion_apo,$sistema_salud,$region_apo,$prov_apo,$rdb,$txt_profesion_apo,$edad_primer_parto,$ultimo_ano_aprobado,$estado_civil,$tipo_trabajo,$pais_origen_apo);
	   
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
	dateFormat: 'dd/mm/yy'
	//buttonImage: 'img/Calendario.PNG',
	});
	 
	 
	 
		</script>
		<?
		 $nombre_apo_ = $_POST['nombre_apo'];
		 
		   $rut_apo = $_POST['rut_apo'];
		?>
<table width="100%">
        <tr>
        <td class="cuadro01">
        <div id="modifica_becas" style="float:right;"><input align="right" type="button" class="botonXX" name="agregar_entrevista" id="agregar_entrevista" value="Guardar Entrevista" title="Agregar Entrevista" onclick="guardar_entrevistas();" />
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
              <td class="cuadro02">Motivo Entrevista</td>
              <td class="cuadro01">
              <span id="citacioncmb">
                <select name="cmbTipo" id="cmbTipo" onchange="cargaCitacion()">
                <option value="0">seleccione...</option>
                </select>
                </span>
                
                <img src="../../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Add.png" width="24" height="24" border="0" onclick="IngresoCitacion()" title="AGREGAR CITACION">
                
              </td>
            </tr>
            <tr>
            <td class="cuadro02">Fecha Entrevista</td>
            <td class="cuadro01"><input type="text" name="fecha_ent" id="fecha_ent" />
            <div id="idasis"><input type="hidden" name="id_asistencia" id="id_asistencia" value="0" />
              <input type="hidden" name="fecha_citacion" id="fecha_citacion" value="" />
              <input type="hidden" name="motivo_ent" id="motivo_ent" value="" />
               
              <input name="convoca" id="convoca" type="hidden" />
            </div>
            </td>
            </tr>
         
            <tr>
              <td class="cuadro02">Convoca</td>
              <td class="cuadro01"><div id="txtconv"></div></td>
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
              <td class="cuadro02">Canal de Comunicaci&oacute;n</td>
              <td class="cuadro01">
             <?php  $rs_canales = $obj_familia->getCanales($_INSTIT);
			 ?>
              
              <select name="canal" id="canal">
                <option value="0">Seleccione</option>
                <?php  for($c=0;$c<pg_numrows($rs_canales);$c++){
			$fila_canal=pg_fetch_array($rs_canales,$c);
			?>
                <option value="<?php echo $fila_canal['id'] ?>"><?php echo $fila_canal['nombre'] ?></option>
                <?php }?>
              </select></td>
            </tr>
         
            <tr>
            <td class="cuadro02">Descripcion</td>
            <td class="cuadro01"><textarea cols="60" rows="3" id="contenido_ent" name="contenido_ent"></textarea>
              
            
              </td>
            </tr>
            <tr>
              <td class="cuadro02">Observaciones</td>
              <td class="cuadro01"><textarea cols="60" rows="3" id="compromiso_ent" name="compromiso_ent"></textarea></td>
            </tr>
            <tr>
              <td class="cuadro02">Compromisos y acuerdos</td>
              <td class="cuadro01"><textarea cols="60" rows="3" id="acuerdo_ent" name="acuerdo_ent"></textarea></td>
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
		$acuerdo_ent = $_POST['acuerdo_ent'];
		$observaciones = $_POST['compromiso_ent'];
		$tipo_entrevista = $_POST['tipo_entrevista'];
		$id_asistencia=$_POST['id_asistencia']; 
		$canal=$_POST['canal']; 
		
		$result = $obj_familia->guarda_entrevista($rdb,$id_ano,$rut_alumno,$rut_apo,$fecha_ent,$asunto_ent,$contenido_ent,$tipo_entrevista,$id_asistencia,$acuerdo_ent,$observaciones,$canal);
		if($result){
		 echo 1;
		 }else{
		 echo 0;		 
	   }
	}
	
	if($funcion==22){
		
		$id_entrevista = $_POST['id_entrevista'];
		$id_citacion = $_POST['citacion'];
		$result = $obj_familia->elimina_ent($id_entrevista,$id_citacion);
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

	if($funcion == 24){
		//var_dump($_POST);
		$result = $obj_combos->getCitacionALL($id_ano,$rut_apo);
		//echo pg_numrows($result);
		?>
        <select name="cmbTipo" id="cmbTipo" onchange="cargaCitacion1()" >
                <option value="0">seleccione...</option>
               <?php  for($i=0;$i<pg_numrows($result);$i++){
				   $fila=pg_fetch_array($result,$i);
				   
				   ?>
               <option value="<?= $fila['id_citacion']?>"><?= CambioFD($fila['fecha'])?> - <?= $fila['asunto']?></option>
                <?php }?>
                </select>
        <?
	}
	
	if($funcion == 25){
		//var_dump($_POST);
		$result = $obj_combos->getCitacion1($id_ano,$rut_apo,$id_citacion);
		
		if(pg_numrows($result)==0)
		{echo 0;}
		else{
			
			$rs_conc=$obj_combos->traeNombreEnMatricula(pg_result($result,3));
			$nomc =  trim(pg_result($rs_conc,0)." ".pg_result($rs_conc,1).", ".pg_result($rs_conc,2));
			
			
			?>
            <input type="hidden" name="id_asistencia" id="id_asistencia" value="<?php echo pg_result($result,0) ?>" />
           <input type="hidden" name="fecha_citacion" id="fecha_citacion" value="<?php echo CambioFD(pg_result($result,1)) ?>" />
<input type="hidden" name="motivo_ent" id="motivo_ent" value="<?php  echo pg_result($result,2) ?>" />
<input name="convoca" id="convoca" type="hidden" value="<?php  echo pg_result($result,3) ?>" />


<script>
		   $( document ).ready(function() {
    $("#txtconv").html("<?php echo $nomc ?>");
});
		   </script>
            <?
		}
		}
		
		
	if($funcion==26){
		//show($_POST);
		$result_ins = $obj_combos->institucion($_INSTIT);
		$rs_ano = $obj_combos->Ano_academico($id_ano);
		$nro_ano = pg_result($rs_ano,0);
		$regis = $obj_combos->datos_alumno($rut_alumno);
		$fila=pg_fetch_array($regis);
		
		$rs_asunto = $obj_combos->traeNombreAsunto($motivo_ent);
		
		
		$rs_canal = $obj_combos->getCanalbyID($canal);
		$fila_canal = pg_fetch_array($rs_canal,0);
		$txt_canal = $fila_canal['nombre'];
		
		
		$rs_responsable = $obj_combos->Datos_Familiar_responsable($rut_alumno);
	$rut_responsable = pg_result($rs_responsable,0);
	//$rut_responsable;
	$rs_datos_apo = $obj_combos->Datos_Familiar2($rut_responsable);
	 $nombre_apo = pg_result($rs_datos_apo,2);
	$ape_pat_apo = pg_result($rs_datos_apo,3);
	$ape_mat_apo = pg_result($rs_datos_apo,4);
	
	$nombre_completo_apo = trim($nombre_apo).' '.trim($ape_pat_apo).' '.trim($ape_mat_apo);
	//$result_entr = $obj_fichaAlumno->get_entrevista_apo($rut_responsable);
		
		$rs_conc=$obj_combos->traeNombreEnMatricula($convoca);
			$nomc =  strtoupper(trim(pg_result($rs_conc,2).", ".pg_result($rs_conc,0)." ".pg_result($rs_conc,1)));
		
		
		?>
        
<STYLE>

 .titulo
 {
 font-family:Arial, Helvetica, sans-serif;
 font-size:14px;
 }
 .item
 {
  font-family:Arial, Helvetica, sans-serif;
 font-size:12px;

 }
 .subitem
 {
 font-family:Arial, Helvetica, sans-serif;
 font-size:11px;
 }
</style>
        
        <table width="654" border="0" align="center" cellpadding="0" class="item">
  <tr>
    <td colspan="5">
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="item" >
		  <tr>
   
    <td width="178"><div align="left">INSTITUCI&Oacute;N</div></td>
    <td width="10">:</td>
    <td width="310"><div align="left"><? echo strtoupper(trim($obj_combos->ins_pal)) ?></div></td>
    <td width="156" rowspan="7" align="center" valign="top" ><?
					
					   echo "<img src='../../../../../../tmp/".trim($obj_combos->rdb)."insignia". "' >";
				?>    </td>
    
  </tr>
  <tr>
    <td><div align="left">A&Ntilde;O ESCOLAR</div></td>
    <td>:</td>
    <td><div align="left"><? echo trim($nro_ano) ?></div></td>
  </tr>
  <tr>
    <td><div align="left">CURSO</div></td>
    <td>:</td>
    <td><div align="left"><?=CursoPalabra($id_curso,0,$conn);?></div></td>
  </tr>
  
  <tr>
    <td><div align="left">PROFESOR(A) JEFE</div></td>
    <td><div align="left">:</div></td>
    <td><div align="left">
      <? $obj_combos->ProfeJefe($id_curso); 
		 echo strtoupper($obj_combos->profe_nombre);
							
					?>
    </div></td>
  </tr>
  
</table>
    
    </td>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="5" align="center" style="text-align:center">ENTREVISTA APODERADO</td>
    </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="176">&nbsp;</td>
    <td width="146">&nbsp;</td>
    <td width="145">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">ALUMNO</td>
    <td colspan="3"><? echo $fila['nombre_alu']?> <? echo $fila['ape_pat']?> <? echo $fila['ape_mat']?></td>
    </tr>
  <tr>
    <td colspan="2">APODERADO</td>
    <td colspan="3"><?php echo strtoupper($nombre_completo_apo) ?></td>
    </tr>

  <tr>
    <td colspan="2">CONVOCA</td>
    <td colspan="3"><?php echo $nomc ?></td>
    </tr>
 
  <tr>
    <td colspan="2">FECHA CITACION</td>
    <td><?php echo $fecha_citacion ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">FECHA ENTREVISTA</td>
    <td><?php echo $fecha_ent ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">TIPO ENTREVISTA</td>
    <td colspan="3"><?php echo ($tipo_entrevista==1)?"Rendimiento":"Conducta"; ?></td>
    </tr>
  <tr>
    <td colspan="2">MOTIVO ENTREVISTA</td>
    <td colspan="3"><?php echo pg_result($rs_asunto,1); ?></td>
    </tr>
  <tr>
    <td colspan="2">ASUNTO</td>
    <td><?php echo utf8_decode($asunto_ent) ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php //if($_PERFIL==0){?>
  <tr>
    <td colspan="2">CANAL DE COMUNICACION</td>
    <td><?php echo utf8_decode($txt_canal) ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php //}?>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">DESCRIPCION</td>
    <td colspan="3"><?php echo utf8_decode($contenido_ent) ?></td>
    </tr>
  <tr>
    <td colspan="2">OBSERVACIONES</td>
    <td colspan="3"><?php echo utf8_decode($compromiso_ent) ?></td>
  </tr>
  <tr>
    <td colspan="2">COMPROMISOS Y<br />
       ACUERDOS</td>
    <td colspan="3"><?php echo utf8_decode($acuerdo_ent) ?></td>
  </tr>
  <tr>
    <td width="59">&nbsp;</td>
    <td width="116">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
         <table width="650" border="0" align="center" cellpadding="0">
         <tr>
           <td align="center">_______________________</td>
           <td align="center">_______________________</td>
         </tr>
         <tr>
           <td align="center">FIRMA ENTREVISTADOR</td>
           <td align="center">FIRMA APODERADO</td>
         </tr>
         </table>

        <?
	}
	if($funcion==27){
	
	$rs_ent = $obj_combos->getEntrevistaDet($id_entrevista);
	
	$fila_ent = pg_fetch_array($rs_ent,0);
	
	$rs_citacion = $obj_combos->getCitDet($idcit);
	
	$fila_cit = pg_fetch_array($rs_citacion,0);
	
	$canal =$fila_ent['canal']; 
	
	
	
	
	$data_ent = $fila_ent['fecha']."_".$fila_ent['asunto']."_".$fila_ent['observaciones']."_".$fila_ent['tipo_entrevista']."_".$fila_cit['fecha']."_".$fila_cit['id_asunto']."_".$fila_ent['compromisos']."_".$fila_ent['acuerdos']."_".$fila_cit['atendido']."_".$canal;
	echo $data_ent;
	}
	
if($funcion==28){
	include("../../citacion/mod_citacion.php");
	$obj_citacion = new Citacion();
	$rs_asunto = $obj_citacion->asunto($conn,$_INSTIT);
	
	?>
<script type="text/javascript" src="../../../../../clases/jquery-ui-1.9.2.custom/js/jquery.maskedinput-1.2.2.js"></script>
<script type="text/javascript">
	
	//alert(anio);
		$(document).ready(function() {
			$("#txtFECHAS").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			minDate: new Date('01/01/'+<?php echo date("Y")?>+''),
			maxDate: new Date('12/31/'+<?php echo date("Y")?>+''),
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});
		
		$("#txtHORAINGRESO").mask('99:99');
		$("#txtHORAEGRESO").mask('99:99');
	
	});
		function utf8_encode(argString) {
  //  discuss at: http://phpjs.org/functions/utf8_encode/
  // original by: Webtoolkit.info (http://www.webtoolkit.info/)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: sowberry
  // improved by: Jack
  // improved by: Yves Sucaet
  // improved by: kirilloid
  // bugfixed by: Onno Marsman
  // bugfixed by: Onno Marsman
  // bugfixed by: Ulrich
  // bugfixed by: Rafal Kukawski
  // bugfixed by: kirilloid
  //   example 1: utf8_encode('Kevin van Zonneveld');
  //   returns 1: 'Kevin van Zonneveld'

  if (argString === null || typeof argString === 'undefined') { 
    return '';
  }

  var string = (argString + ''); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
  var utftext = '',
    start, end, stringl = 0;

  start = end = 0;
  stringl = string.length;
  for (var n = 0; n < stringl; n++) {
    var c1 = string.charCodeAt(n);
    var enc = null;

    if (c1 < 128) {
      end++;
    } else if (c1 > 127 && c1 < 2048) {
      enc = String.fromCharCode(
        (c1 >> 6) | 192, (c1 & 63) | 128
      );
    } else if ((c1 & 0xF800) != 0xD800) {
      enc = String.fromCharCode(
        (c1 >> 12) | 224, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
      );
    } else { // surrogate pairs
      if ((c1 & 0xFC00) != 0xD800) {
        throw new RangeError('Unmatched trail surrogate at ' + n);
      }
      var c2 = string.charCodeAt(++n);
      if ((c2 & 0xFC00) != 0xDC00) {
        throw new RangeError('Unmatched lead surrogate at ' + (n - 1));
      }
      c1 = ((c1 & 0x3FF) << 10) + (c2 & 0x3FF) + 0x10000;
      enc = String.fromCharCode(
        (c1 >> 18) | 240, ((c1 >> 12) & 63) | 128, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
      );
    }
    if (enc !== null) {
      if (end > start) {
        utftext += string.slice(start, end);
      }
      utftext += enc;
      start = end = n + 1;
    }
  }

  if (end > start) {
    utftext += string.slice(start, stringl);
  }

  return utftext;
}
		</script>


<table width="90%" border="0" align="center">
 
  <tr>
    <td class="tableindex"> CITACIONES APODERADO</td>
  </tr>
</table><br />
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr>
    <td class="cuadro02">FECHA CITACION</td>
    <td class="cuadro01"><input name="txtFECHAS" type="text" id="txtFECHAS" size="10" maxlength="10" readonly></td>
    <td class="cuadro02">ASUNTO</td>
    <td class="cuadro01">
   
    <div id="asuntoCI">
    <select name="cmbASUNTOI" id="cmbASUNTOI">
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_asunto);$i++){
				$fila_pat = pg_Fetch_array($rs_asunto,$i);
		?>
        <option value="<?=$fila_pat['id_asunto'];?>"><?=$fila_pat['asunto'];?></option>
        <? } ?>
    </select>
    <a href="#"><img src="../../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Add.png" width="24" height="24" border="0" onclick="IngresoPatologia()"  title="AGREGAR ASUNTO"/></a>    
    </div>
</td>
  </tr>
  <tr>
    <td class="cuadro02">HORA</td>
    <td class="cuadro01"><input name="txtHORAINGRESO" type="text" id="txtHORAINGRESO" size="10" maxlength="5" data-mask="00:00" /> 
      (hh:mm)</td>
    <td class="cuadro02">CONVOCA</td>
    <td class="cuadro01">
  <?php   $sql_emp = "SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.ape_pat||' '||empleado.ape_mat||', '|| 
empleado.nombre_emp nombre,ape_pat, ape_mat, nombre_emp FROM empleado "; 
		
		if($_PERFIL==0 || $_PERFIL==14){
		$sql_emp.=" inner join trabaja t on t.rut_emp=empleado.rut_emp ";
			if($_INSTIT!=31392){
				$sql_emp.=" and t.cargo in (1,2,5) ";
			}
		}
			
		$sql_emp.= "
		INNER JOIN institucion ON t.rdb = institucion.rdb 
		WHERE institucion.rdb=".$_INSTIT." ";
		
		if($_PERFIL==17){
		$sql_emp.=" and empleado.rut_emp=$_NOMBREUSUARIO ";
		}
		
		$sql_emp.= "ORDER BY ape_pat, ape_mat, nombre_emp asc";
		
		//echo $sql_emp;
		
		$result_emp = @pg_exec($conn,$sql_emp); ?>
        
		<?php if($_PERFIL!=17){?>
		
    <div id="empe">
    <select name="cmbEmpleado" id="cmbEmpleadoCI">
    <option value="0">Seleccione...</option>
    <?php for($ee=0;$ee<pg_numrows($result_emp);$ee++){
		$fila_emp=pg_fetch_array($result_emp,$ee);?>
    <option value="<?php echo $fila_emp['rut_emp'] ?>"><?php echo $fila_emp['nombre'] ?></option>
    <?php }?>
    </select>
    </div>
    <?php } else {?>
   <?php   ?>
    <input name="cmbEmpleado" id="cmbEmpleado" type="hidden" value="<?php echo $_NOMBREUSUARIO ?>" />
    <?php echo pg_result($result_emp,2) ?>  <?php echo pg_result($result_emp,3) ?>  <?php echo pg_result($result_emp,4) ?>
    <?php }?>
    </td>
  </tr>
  <tr>
    <td colspan="4" class="cuadro01"><input name="cmbCURSOI" type="hidden" id="cmbCURSOI" value="<?php echo $_CURSO ?>" />
       <input name="cmbAPODERADOI" type="hidden" id="cmbAPODERADOI" value="<?php echo $rut_apo ?>" /></td>
  </tr>
  <tr>
    <td class="cuadro02">Mensaje</td>
    <td colspan="3" class="cuadro01"><textarea name="txtOBS" cols="70" rows="8" id="txtOBS"></textarea></td>
  </tr>
</table>
<br />


<?	

	}
if($funcion==29){
include("../../citacion/mod_citacion.php");
	$obj_citacion = new Citacion();
	$result = $obj_citacion->AgregaAsunto($conn,$_INSTIT,$nombre);	

	if($result){
		echo 1;
	}else{
		echo 0;	
	}
}
if($funcion==30){
	
	include("../../citacion/mod_citacion.php");
	$obj_citacion = new Citacion();
	$result = $obj_citacion->asunto($conn,$_INSTIT);
?>
<select name="cmbASUNTOI" id="cmbASUNTOI">
    	<option value="0">seleccione...</option>
      <? for($i=0;$i<pg_numrows($result);$i++){
		  	$fila_a = pg_fetch_array($result,$i);
	  ?>
      	<option value="<?=$fila_a['id_asunto'];?>"><?=$fila_a['asunto'];?></option>
      <? } ?>
    </select>
    <?
}
if($funcion==31){
if($_PERFIL==0){
$user_type2=0;
}else{
$sqlu="select t.cargo,c.nombre_cargo 
from trabaja t inner join cargos c on c.id_cargo = t.cargo 
where t.rut_emp = $user_name order by identificador asc limit 1";	
$rsu = pg_exec($conn,$sqlu);
$user_type2 = pg_result($rsu,0);
}


$rs_guardaComm = $obj_familia->guardaMensajeCom($token,$_INSTIT,$curso,$alumno,$user_name,$fecha,$hora,$modo,$user_type2,utf8_decode($mensaje),$tipo_mensaje);
}


 ?>
