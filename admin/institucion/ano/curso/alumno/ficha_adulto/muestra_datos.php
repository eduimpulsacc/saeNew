<?php

include_once('mod_ficha_alumno.php');
header('Content-Type: text/html; charset=iso-8859-1'); 
$rut_alumno			=  $_POST['rutusuario'];
$id_ano = $_POST['ano'];
$ret = $_POST['ret'];

$obj_fichaAlumno = new FichaAlumno($conn);

//echo $_PERFIL;

/************ PERMISOS DEL PERFIL *************************/
                if($_PERFIL==0){
                               $ingreso = 1;
                               $modifica =1;
                               $elimina =1;
                               $ver =1;
                }else{
                               if($nw==1){
                                               $_MENU =$menu;
                                               session_register('_MENU');
                                               $_CATEGORIA = $categoria;
                                               session_register('_CATEGORIA');
                                               $_ITEM =$item;
                                               session_register('_ITEM');
                               }
                               $sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$_INSTIT." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." and id_item=".$_ITEM;
                               $rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
                               $ingreso = @pg_result($rs_permiso,0);
                               $modifica =@pg_result($rs_permiso,1);
                               $elimina =@pg_result($rs_permiso,2);
                               $ver =@pg_result($rs_permiso,3);
                }

$sql ="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
	$rs_ano =pg_exec($conn,$sql);
	$nro_ano = pg_result($rs_ano,0);
	$nro_ano_ant = $nro_ano - 1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
	div.ui-datepicker{
	font-size:12px;
	}
</style>
<script>
$(document).ready(function() {
	
	$("#txtFECHA").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'mm-dd-yy'
	//buttonImage: 'img/Calendario.PNG',
	});
	//$.datepicker.regional['es']	
	 
	
	 
	 
	$(function() {
		$( "#tabs" ).tabs(2);
	});
	
 cambia_titulos(1);
// datos_familiar();

	
 });
 


  
 

</script>
</head>
<body>

<form name="Formulariolista" id="Formulariolista" >

<div id="titulo" class="tableindex">titulo</div>

<div id="tabs">

	<ul>
        <li value="1" ><a href="#personal" onClick="cambia_titulos(1)" >Personal</a></li>
      <li value="5"><a href="#becas" onClick="cambia_titulos(5)" >Becas</a></li>
        <li value="8"><a href="#documentos" onClick="cambia_titulos(8)" >Documentos</a></li>
       
     
   </ul>
      
	
    <div id="personal" style="width:100%; margin-left:-23px" >
    

	<table width="100%">
    <tr class="cuadro01">
  
    <td width="1069" align="right"><input type="button" class="botonXX" title="Volver" value="Volver" onClick="window.location='../listarAlumnos.php3?menu=6&categoria=3&item=2&nw=1'" ></td>
    <? if($modifica==1){?>
    <td width="68"><input type="button" class="botonXX" title="Modificar" value="Modificar" onClick="modifica_datos()"></td>
   <? } ?>
      <td width="70"><input class="botonXX" type="button" onClick="window.open('frmFoto.php?rut=<?=$rut_alumno?>&swfoto=1&estilo=<?=$_ESTILO;?>','','width=600,height=180,top=200,left=200')" name="btnFoto" title="Subir Foto Alumno" value="FOTO"></td>
    </tr>
    
    </table> 
    <?php
    $regis = $obj_fichaAlumno->datos_alumno($rut_alumno);
	
	$regis_matricula=$obj_fichaAlumno->datosMatricula($rut_alumno,$id_ano,$curso,$ret);	
	
		
		for($i=0;$i<pg_num_rows($regis);$i++){
			$fila=pg_fetch_array($regis);
			
			if($fila['sexo']==1){
				$fila['sexo']="F";
				}else{
					$fila['sexo']="M";
			}
			if($fila['nacionalidad']==1){
				 $fila['nacionalidad']="Extranjera";					
				}else if($fila['nacionalidad']==2){
					$fila['nacionalidad']="Chilena";	
			}
			
			
			
			$cod_reg = $fila['region'];
			$cod_prov = $fila['ciudad'];
			$cod_com = $fila['comuna'];
				
			
				$fila_matricula=pg_fetch_array($regis_matricula,$i);
			
			
				if($fila_matricula['bool_ae']==1){
				$fila_matricula['bool_ae']="si";
				}else{
				$fila_matricula['bool_ae']="No";
				}
				
				if($fila_matricula['bool_aoi']==1){
				$fila_matricula['bool_aoi']="si";
				}else{
				$fila_matricula['bool_aoi']="No";
				}
				
				if($fila_matricula['ben_pie']==1){
				$fila_matricula['ben_pie']="si";
				}else{
				$fila_matricula['ben_pie']="No";
				}
				
				if($fila_matricula['curso_rep']==1){
				$fila_matricula['curso_rep']="si";
				}else{
				$fila_matricula['curso_rep']="No";
				}
				
				if($fila_matricula['trat_especialista']==""){
				$fila_matricula['trat_especialista']="No";
				}else if ($fila_matricula['trat_especialista']==0){
				$fila_matricula['trat_especialista']="No";
		        }else{
				$fila_matricula['trat_especialista'];
				}
				
				if($fila_matricula['ben_sep']==1){
				$fila_matricula['ben_sep']="si";
				}else{
				$fila_matricula['ben_sep']="No";
				}
				
				if($fila_matricula['bool_retos']==1){
				$fila_matricula['bool_retos']="si";
				}else{
				$fila_matricula['bool_retos']="No";
				}
				
				if($fila_matricula['ben_puente']==1){
				$fila_matricula['ben_puente']="si";
				}else{
				$fila_matricula['ben_puente']="No";
				}
				
				if($fila_matricula['bool_fci']==1){
				$fila_matricula['bool_fci']="si";
				}else{
				$fila_matricula['bool_fci']="No";
				}
				
				if($fila_matricula['sancion']==1){
				$fila_matricula['sancion']="si";
				}else{
				$fila_matricula['sancion']="No";
				}
				
				if($fila_matricula['enfermedad']==""){
				$fila_matricula['enfermedad']="No";
				}else{
				$fila_matricula['enfermedad'];
				}
				
				if($fila_matricula['cirugia']==""){
				$fila_matricula['cirugia']="No";
				}else{
				$fila_matricula['cirugia'];
				}
				
				if($fila_matricula['medicamento']==""){
				$fila_matricula['medicamento']="No";
				}else{
				$fila_matricula['medicamento'];
				}
				
				if($fila_matricula['alergia']==""){
				$fila_matricula['alergia']="No";
				}else{
				$fila_matricula['alergia'];
				}
				
				if($fila_matricula['fisica']==""){
				$fila_matricula['fisica']="No";
				}else{
				$fila_matricula['fisica'];
				}
				
				if($fila_matricula['fiebre']==""){
				$fila_matricula['fiebre']="No";
				}else{
				$fila_matricula['fiebre'];
				}
				
				if($fila_matricula['seguro']==""){
				$fila_matricula['seguro']="No";
				}else{
				$fila_matricula['seguro'];
				}
				
				if($fila_matricula['autoriza_emergencia']==1){
				$fila_matricula['autoriza_emergencia']="si";
				}else{
				$fila_matricula['autoriza_emergencia']="No";
				}
				
				if($fila_matricula['viaja_furgon']==1){
				$fila_matricula['viaja_furgon']="si";
				}else{
				$fila_matricula['viaja_furgon']="No";
				}
				
				if($fila_matricula['bool_ar']==1){
				$fila_matricula['bool_ar']="si";
				}else{
				$fila_matricula['bool_ar']="No";
				}
				
				if($fila_matricula['condicionalidad']==1){
				$fila_matricula['condicionalidad']="si";
				}else{
				$fila_matricula['condicionalidad']="No";
				}
				
				if($fila_matricula['bool_rg']==1){
				$fila_matricula['bool_rg']="Opta";
				}else{
				$fila_matricula['bool_rg']="No";
				}
				
				if($fila_matricula['bool_ed']==1){
				$fila_matricula['bool_ed']="si";
				}else{
				$fila_matricula['bool_ed']="No";
				}
				
				if($fila_matricula['bool_i']==1){
				$fila_matricula['bool_i']="si";
				}else{
				$fila_matricula['bool_i']="No";
				}
				
				if($fila_matricula['bool_pdentales']==1){
				$fila_matricula['bool_pdentales']="Si";
				}else{
				$fila_matricula['bool_pdentales']="No";
				}
				
				if($fila_matricula['bool_controldental']==1){
				$fila_matricula['bool_controldental']="Si";
				}else{
				$fila_matricula['bool_controldental']="No";
				}
				
				if($fila_matricula['bool_famenfermo']==1){
				$fila_matricula['bool_famenfermo']="Si";
				}else{
				$fila_matricula['bool_famenfermo']="No";
				}
				
				
if($fila['tipo_parto']==1){
	$fila['tipo_parto']="Normal";
}
elseif($fila['tipo_parto']==2){
	$fila['tipo_parto']="Cesárea";
}
else{
	$fila['tipo_parto']="";
}

if($fila['peso_nace']!=0){
	$fila['peso_nace']=$fila['peso_nace'];
}
else{
	$fila['peso_nace']="";
}
if($fila['talla_nace']!=0){
	$fila['talla_nace']=$fila['talla_nace'];
}
else{
	$fila['talla_nace']="";
}
		
				
					if ($fila_matricula['controlsano']!='1111-11-11' && $fila_matricula['controlsano']!='0000-00-00' && $fila_matricula['controlsano']!=null){
			$fila_matricula['controlsano']=CambioFechaDisplay($fila_matricula['controlsano']);
		}else{
			$fila_matricula['controlsano']="";
			}
				
	

				if($fila_matricula['bool_espacio_juego']==1){
				$fila_matricula['bool_espacio_juego']="Si";
				}else{
				$fila_matricula['bool_espacio_juego']="No";
				}
				
				
if($fila_matricula['bool_espacio_estudio']==1){
				$fila_matricula['bool_espacio_estudio']="Si";
				}else{
				$fila_matricula['bool_espacio_estudio']="No";
				}
				
if($fila_matricula['bool_hizo_jardin']==1){
				$fila_matricula['bool_hizo_jardin']="Si";
				}else{
				$fila_matricula['bool_hizo_jardin']="No";
				}	
				
if($fila_matricula['bool_aporta_figura_paterna']==1){
				$fila_matricula['bool_aporta_figura_paterna']="Si";
				}else{
				$fila_matricula['bool_aporta_figura_paterna']="No";
				}			
			
if($fila_matricula['carinoso']==1){
			$fila_matricula['carinoso']="Siempre";
		}
		elseif($fila_alumno['carinoso']==2){
			$fila_matricula['carinoso']="Frecuentemente";
		}
		elseif($fila_matricula['carinoso']==3){
			$fila_matricula['carinoso']="Raras veces";
		}
		elseif($fila_matricula['carinoso']==4){
			$fila_matricula['carinoso']="Casi nunca";
		}
		elseif($fila_matricula['carinoso']==5){
			$fila_matricula['carinoso']="Nunca";
		}
		else{
			$fila_matricula['carinoso']="";
		}
		


if($fila_matricula['sociable']==1){
			$fila_matricula['sociable']="Siempre";
		}
		elseif($fila_alumno['sociable']==2){
			$fila_matricula['sociable']="Frecuentemente";
		}
		elseif($fila_matricula['sociable']==3){
			$fila_matricula['sociable']="Raras veces";
		}
		elseif($fila_matricula['sociable']==4){
			$fila_matricula['sociable']="Casi nunca";
		}
		elseif($fila_matricula['sociable']==5){
			$fila_matricula['sociable']="Nunca";
		}
		else{
			$fila_matricula['sociable']="";
		}
		
		
		
if($fila_matricula['curioso']==1){
			$fila_matricula['curioso']="Siempre";
		}
		elseif($fila_alumno['curioso']==2){
			$fila_matricula['curioso']="Frecuentemente";
		}
		elseif($fila_matricula['curioso']==3){
			$fila_matricula['curioso']="Raras veces";
		}
		elseif($fila_matricula['curioso']==4){
			$fila_matricula['curioso']="Casi nunca";
		}
		elseif($fila_matricula['curioso']==5){
			$fila_matricula['curioso']="Nunca";
		}
		else{
			$fila_matricula['curioso']="";
		}
		
		if($fila_matricula['bool_retirosolo']==0){
	$fila_matricula['bool_retirosolo']="No";
}else{
	$fila_matricula['bool_retirosolo']="Si";
	}	
	
	if($fila_matricula['bool_tieneluz']==0){
	$fila_matricula['bool_tieneluz']="No";
}else{
	$fila_matricula['bool_tieneluz']="Si";
	}	
	
	if($fila_matricula['bool_tieneagua']==0){
	$fila_matricula['bool_tieneagua']="No";
}else{
	$fila_matricula['bool_tieneagua']="Si";
	}	
	
	if($fila_matricula['bool_tienealcantarillado']==0){
	$fila_matricula['bool_tienealcantarillado']="No";
}else{
	$fila_matricula['bool_tienealcantarillado']="Si";
	}	
	
	
	if($fila_matricula['bool_neurologo']==0){
	$fila_matricula['bool_neurologo']="No";
}else{
	$fila_matricula['bool_neurologo']="Si";
	}	
	
	if($fila_matricula['bool_psicopedagogo']==0){
	$fila_matricula['bool_psicopedagogo']="No";
}else{
	$fila_matricula['bool_psicopedagogo']="Si";
	}
	
	if($fila_matricula['bool_psicologo']==0){
	$fila_matricula['bool_psicologo']="No";
}else{
	$fila_matricula['bool_psicologo']="Si";
	}		
			
			
			
			
			
			if($fila_matricula['bool_otratamiento']==1){
				$fila_matricula['txt_otratamiendo']=$fila_matricula['txt_otratamiendo'];
				}else{
				$fila_matricula['txt_otratamiendo']="No";
				}
				
		
		if($fila_matricula['bool_tratactual']==1){
				$fila_matricula['txt_tratactual']=$fila_matricula['txt_tratactual'];
				}else{
				$fila_matricula['txt_tratactual']="No";
				}
				
		
		if($fila_matricula['bool_tastornosaprendizaje']==1){
				$fila_matricula['txt_tastornosaprendizaje']=$fila_matricula['txt_tastornosaprendizaje'];
				}else{
				$fila_matricula['txt_tastornosaprendizaje']="No";
				}
	
	
	if($fila['edad_madre_nace']==0){
	$fila['edad_madre_nace']="";
}else{
	$fila['edad_madre_nace']=$fila['edad_madre_nace'];
	}	
	
	if($fila['peso_nace']==""){
	$fila['peso_nace']="";
}else{
	$fila['peso_nace']=$fila['peso_nace'];
	}	
	
	if($fila['talla_nace']==0){
	$fila['talla_nace']="";
}else{
	$fila['talla_nace']=$fila['talla_nace'];
	}	
	
	
	if($fila['estado_civil']==0)
	{$fila['estado_civil']="";}
	if($fila['estado_civil']==1)
	{$fila['estado_civil']="Soltero(a)";}
	if($fila['estado_civil']==2)
	{$fila['estado_civil']="Casado(a)";}
	if($fila['estado_civil']==3)
	{$fila['estado_civil']="Viudo(a)";}
	if($fila['estado_civil']==4)
	{$fila['estado_civil']="Divorciado(a)";}
	if($fila['estado_civil']==5)
	{$fila['estado_civil']="Otro";}
	
	if($fila_matricula['bool_trabajo']==0){
		$fila_matricula['bool_trabajo']="No";
	}else{
		$fila_matricula['bool_trabajo']="Si";}
		
if($fila['bool_padre']==0 && $fila['bool_madre']==0){
		$espadre="No";
	}else{
		$espadre="Si";}
	
	if($fila_matricula['bool_examenvalidacion']==0){
		$fila_matricula['bool_examenvalidacion']="No";
	}else{
		$fila_matricula['bool_examenvalidacion']="Si";}
	
		
		if($fila_matricula['bool_carnetdiscapacidad']==0){
		$fila_matricula['bool_carnetdiscapacidad']="No";
	}else{
		$fila_matricula['bool_carnetdiscapacidad']="Si";}
		
		
		if($fila_matricula['bool_vif']==0){
		$fila_matricula['bool_vif']="No";
	}else{
		$fila_matricula['bool_vif']="Si";}
		
		if($fila_matricula['bool_saludmental']==0){
		$fila_matricula['bool_saludmental']="No";
	}else{
		$fila_matricula['bool_saludmental']="Si";}
		
		if($fila_matricula['bool_drogas']==0){
		$fila_matricula['bool_drogas']="No";
	}else{
		$fila_matricula['bool_drogas']="Si";}
		
		if($fila_matricula['bool_sernam']==0){
		$fila_matricula['bool_sernam']="No";
	}else{
		$fila_matricula['bool_sernam']="Si";}
		
		
		if($fila_matricula['bool_sename']==0){
		$fila_matricula['bool_sename']="No";
	}else{
		$fila_matricula['bool_sename']="Si";}
		
		if($fila_matricula['bool_ccc']==0){
		$fila_matricula['bool_ccc']="No";
	}else{
		$fila_matricula['bool_ccc']="Si";}
		
		
		if($fila_matricula['bool_traecertificados']==0){
		$fila_matricula['bool_traecertificados']="No";
	}else{
		$fila_matricula['bool_traecertificados']="Si";}
		
		
		if($fila_matricula['bool_traecertificadosant']==0){
		$fila_matricula['bool_traecertificadosant']="No";
	}else{
		$fila_matricula['bool_traecertificadosant']="Si";}
		
		
		if($fila_matricula['bool_secreduc']==0){
		$fila_matricula['bool_secreduc']="No";
	}else{
		$fila_matricula['bool_secreduc']="Si";}
		
		
		if($fila_matricula['bool_manualconvivencia']==0){
		$fila_matricula['bool_manualconvivencia']="No";
	}else{
		$fila_matricula['bool_manualconvivencia']="Si";}
		
		if($fila_matricula['bool_pagomatricula']==0){
		$fila_matricula['bool_pagomatricula']="No";
	}else{
		$fila_matricula['bool_pagomatricula']="Si";}
		
		
		if($fila_matricula['bool_exentomatricula']==0){
		$fila_matricula['bool_exentomatricula']="No";
	}else{
		$fila_matricula['bool_exentomatricula']="Si";}
		
		
		
		
		/*txt_discapacidad
		
				
		txt_enfcronica
		*/
			
/*****************************fin campos nuevos*/
				
	$regis_region = $obj_fichaAlumno->get_region($cod_reg);
	$region = pg_result($regis_region,1);
	
	
	$regis_prov = $obj_fichaAlumno->get_provincia($cod_reg,$cod_prov);
	$provincia = pg_result($regis_prov,2);		
	
	$regis_com = $obj_fichaAlumno->get_comuna($cod_com,$cod_prov,$cod_reg);
	$comuna = pg_result($regis_com,3);
				
	?>		
    
    <table width="100%">
    <tr>
    <td class="cuadro01">Curso: <?=CursoPalabra($curso,0,$conn);?></td>
    </tr>
    </table>

    <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    <tr>
    <TD colspan=8 class="cuadro02">RUT</TD>
    </tr>
    <tr>
    <td colspan="7" class="cuadro01"><?=$fila['rut_alumno'].'-'.$fila['dig_rut']?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Nombre</td>
    <td class="cuadro02">Apellido Paterno</td>
    <td class="cuadro02">Apellido Materno</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><? echo $fila['nombre_alu']?></td>
    <td class="cuadro01"><? echo $fila['ape_pat']?></td>
    <td class="cuadro01"><? echo $fila['ape_mat']?></td>
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
    <td class="cuadro02">Alumna Embarazada</td>
    <td class="cuadro02">Alunm@ Indigena</td>
    <td class="cuadro02">Etnia</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=$fila_matricula['bool_ae']?><?php echo($fila_matricula['bool_ae']=="si")?", ".$fila_matricula['txt_mesembarazo']." mes(es)":""; ?></td>
    <td class="cuadro01"><?=$fila_matricula['bool_aoi']?></td>
    <td class="cuadro01"><?=$fila['txt_etnia']?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Procedencia del Alumno</td>
    <td class="cuadro02">Con quien vive</td>
    <td class="cuadro02">Estado civil</td>
    </tr>
    
    
    <tr>
    <td class="cuadro01"><?=$fila['c_procedencia']?></td>
    <td class="cuadro01"><?=$fila['cq_vive']?></td>
    <td class="cuadro01"><?=$fila['estado_civil']?></td>
    </tr>
    
    <tr>
      <td class="cuadro02">Es Padre / Madre</td>
      <td class="cuadro02">Hijos</td>
      <td class="cuadro02">Trabaja</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $espadre ?></td>
      <td class="cuadro01"><?=$fila['cant_hijos']?></td>
      <td class="cuadro01"><?=$fila_matricula['bool_trabajo']?></td>
    </tr>
    
      <tr>
    <td class="cuadro02">Lugar de trabajo</td>
    <td class="cuadro02">Edad</td>
    <td class="cuadro02">Religion</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=$fila_matricula['lugar_trabajo']?></td>
    <td class="cuadro01"><?=$fila['edad']?></td>
    <td class="cuadro01"><?=$fila['religion']?></td>
    </tr>
    <tr>
    <td class="cuadro02" colspan="3">Observaciones</td>
    </tr>
    
    <tr>
    <td class="cuadro01" colspan="3"><?=$fila_matricula['datos_interes']?></td>
    </tr>
    </table>
    <br />
    <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    <TR>
    <TD colspan="7"><div id="titulo" class="tableindex">DIRECCION</div>
    </TD>
    </TR>

    <tr>
    <td class="cuadro02">Calle</td>
    <td class="cuadro02">Numero</td>
    <td class="cuadro02">Block</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=$fila['calle']?></td>
    <td class="cuadro01"><?=$fila['nro']?></td>
    <td class="cuadro01"><?=$fila['block']?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Depto</td>
    <td class="cuadro02">Villa/Poblacion</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=$fila['depto']?></td>
    <td class="cuadro01"><?=$fila['villa']?></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
    
    <tr>
    <td class="cuadro02">Telefono</td>
    <td class="cuadro02">Telefono Recados</td>
    <td class="cuadro02">Email</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=$fila['telefono']?></td>
    <td class="cuadro01"><?=$fila['telefono_recado']?></td>
    <td class="cuadro01"><?=$fila['email']?></td>
    </tr>
    
      <tr>
    <td class="cuadro02">Region</td>
    <td class="cuadro02">Provincia</td>
    <td class="cuadro02">Comuna</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><? echo $region;?></td>
    <td class="cuadro01"><? echo $provincia;?></td>
    <td class="cuadro01"><? echo $comuna;?></td>
    </tr>
  </table>
  <br />
    <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    <TR>
    <TD colspan="7"><div id="titulo" class="tableindex">ANTECEDENTES ACADEMICOS</div>
    </TD>
    </TR>
    
    <tr>
    <td class="cuadro02">Fecha Matricula</td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo CambioFechaDisplay($fila_matricula['fecha']);?></td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
    
    <tr>
    <td class="cuadro02">Retirado</td>
    <td class="cuadro02">Fecha Retiro</td>
    <td class="cuadro02">Motivo Retiro</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['bool_ar'];?></td>
    <td class="cuadro01"><? echo CambioFechaDisplay($fila_matricula['fecha_retiro']);?></td>
    <td class="cuadro01">
    <?php 
	switch($fila_matricula['tipo_retiro']){
	case 1:
	$mr="Cambio de Domiciclio";
	break;
	case 2:
	$mr="Traslado de establecimiento";
	break;
	case 3:
	$mr="Deserci&oacute;n";
	break;	
	case 4:
	$mr="Motivos de salud";
	break;
	case 5:
	$mr="Otros";
	break;	
	default:
	$mr="";
	break;	
			
	}
	echo $mr;
	?>
    </td>
    </tr>
    <tr>
      <td class="cuadro02">Detalle motivo retiro</td>
      <td class="cuadro02">Requiere examen de validaci&oacute;n de estudios</td>
      <td class="cuadro02">Estudio a&ntilde;o anterior</td>
      </tr>
    <tr>
      <td class="cuadro01"><? echo $fila_matricula['motivo_retiro'];?></td>
      <td class="cuadro01"><? echo $fila_matricula['bool_examenvalidacion'];?></td>
      <td class="cuadro01"><? echo $fila_matricula['bool_rg'];?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Ha repetido curso</td>
    <td class="cuadro02">Pertenece al programa de integracion escolar (PIE) </td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['curso_rep'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['ben_pie'];?></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
     
     <tr>
       <td class="cuadro02">A&ntilde;os retirados</td>
       <td class="cuadro02">Causa a&ntilde;os retirados</td>
       <td class="cuadro02">&nbsp;</td>
     </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['txt_anosretiro'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['txt_causaretiroant'];?></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
    <tr>
       <td class="cuadro02" colspan="3">Observaciones</td>
       
     </tr>
    
    <tr>
    <td class="cuadro01" colspan="3"><?=$fila_matricula['obs_reporte']?></td>
   
    </tr>
  </table>  
  <br />
    <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    <TR>
    <TD colspan="7"><div id="titulo" class="tableindex">ANTECEDENTES DE SALUD</div>
    </TD>
    </TR>
    <tr>
      <td class="cuadro02">Sistema de Salud</td>
      <td class="cuadro02">Ha estado en tratamiento psicol&oacute;gico</td>
      <td class="cuadro02">Problema Aprendizaje</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php $regis_salud = $obj_fichaAlumno->get_sistema_salud_ficha($fila['s_salud']);
	$sistema_salud2 = pg_result($regis_salud,1);  ?>
        <?=$sistema_salud2;?>
        &nbsp;</td>
      <td class="cuadro01"><?php echo $fila_matricula['bool_psicologo'] ?>&nbsp;</td>
      <td class="cuadro01"><?php echo $fila_matricula['txt_tastornosaprendizaje'] ?></td>
    </tr>
    <tr>
      <td class="cuadro02">Enfermedad cr&oacute;nica</td>
      <td class="cuadro02">Posee discapacidad</td>
      <td class="cuadro02">Posee carnet de discapacidad</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['txt_enfcronica'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['txt_discapacidad'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['bool_carnetdiscapacidad'] ?></td>
    </tr>
    	 <tr>
      <td class="cuadro02">Centro de atenci&oacute;n</td>
      <td class="cuadro02">&nbsp;</td>
      <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['txt_centroatencion'] ?></td>
      <td class="cuadro01">&nbsp;</td>
      <td class="cuadro01">&nbsp;</td>
    </tr>
     <tr>
       <td class="cuadro02" colspan="2">Observaciones</td>
       <td class="cuadro02">&nbsp;</td>
     </tr>
    
    <tr>
    <td class="cuadro01" colspan="2"><? $fila_matricula['observacion_salud']?></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
   </table><br>
 <!------------------------------------>
   <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    <TR>
    <TD colspan="7"><div id="titulo" class="tableindex">ANTECEDENTES GENERALES</div>
    </TD>
    </TR>
    
    <tr>
    <td class="cuadro02">N&uacute;mero de personas que dependen del estudiante</td>
    <td class="cuadro02">Total Ingreso Familiar</td>
    <td class="cuadro02">Tramo sistema de salud</td>
    </tr>
    <tr>
    <td class="cuadro01"><?php echo $fila_matricula['num_grupofamiliar'] ?></td>
    <td class="cuadro01"><?php echo $fila_matricula['ingresos'] ?></td>
    <td class="cuadro01"><?php echo $fila_matricula['tramo_salud'] ?></td>
    </tr>
    	 <tr>
    	   <td class="cuadro02">Chile crece contigo</td>
    	   <td class="cuadro02">Ficha de Proteci&oacute;n social</td>
    	   <td class="cuadro02">Programa Violencia Intrafamiliar</td>
  	   </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['bool_ccc'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['txt_fichaps'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['bool_vif'] ?></td>
    </tr>
     <tr>
    	   <td class="cuadro02">Programa Salud Mental</td>
    	   <td class="cuadro02">Programa Consumo Drogas</td>
    	   <td class="cuadro02">Programa SENAME</td>
  	   </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['bool_saludmental'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['bool_drogas'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['bool_sename'] ?></td>
    </tr>
     <tr>
    	   <td class="cuadro02">Programa SERNAM</td>
    	   <td class="cuadro02">&nbsp;</td>
    	   <td class="cuadro02">&nbsp;</td>
  	   </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['bool_sernam'] ?></td>
      <td class="cuadro01">&nbsp;</td>
      <td class="cuadro01">&nbsp;</td>
    </tr>
     <tr>
    <td class="cuadro02" colspan="2">Observaciones Generales</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    
    <tr>
    <td class="cuadro01" colspan="2">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
   </table>
   <!------------------------------------>
   <br>
    <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    <TR>
    <TD colspan="7"><div id="titulo" class="tableindex">EMERGENCIAS </div>
    </TD>
    </TR>
         
    <tr>
    <td width="34%" class="cuadro02">Nombre en caso de emergencia</td>
    <td width="31%" class="cuadro02">Fono</td>
    <td width="35%" class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['txt_contactoemergencia'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['txt_fonocontactoemergencia'];?></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
    <tr>
    <td width="34%" class="cuadro02">Nombre Apoderado / Tutor</td>
    <td width="31%" class="cuadro02">Fono</td>
    <td width="35%" class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['txt_tutor'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['txt_fonotutor'];?></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>

   </table>
   <br>

  
  <?php
     } 
	?>
    </div>

        
    <div id="becas">
    
    <?php
		$regis_matricula=$obj_fichaAlumno->datosMatricula($rut_alumno,$id_ano,$curso,$ret);	
		
		for($e=0;$e < pg_num_rows($regis_matricula);$e++)
		    {
			$fila = pg_fetch_array($regis_matricula,$e);
			
			   if($fila['bool_baj']==1){
				$fila['bool_baj']="si";
				}else{
				$fila['bool_baj']="No";
				}
				if($fila['bool_bchs']==1){
				$fila['bool_bchs']="si";
				}else{
				$fila['bool_bchs']="No";
				}
				if($fila['bool_mun']==1){
				$fila['bool_mun']="si";
				}else{
				$fila['bool_mun']="No";
				}
				if($fila['bool_fci']==1){
				$fila['bool_fci']="si";
				}else{
				$fila['bool_fci']="No";
				}
				if($fila['bool_cpadre']==1){
				$fila['bool_cpadre']="si";
				}else{
				$fila['bool_cpadre']="No";
				}
				if($fila['bool_seg']==1){
				$fila['bool_seg']="si";
				}else{
				$fila['bool_seg']="No";
				}
				if($fila['bool_otros']==1){
				$fila['bool_otros']="si";
				}else{
				$fila['bool_otros']="No";
				}
				if($fila['ben_pie']==1){
				$fila['ben_pie']="si";
				}else{
				$fila['ben_pie']="No";
				}
				if($fila['ben_sep']==1){
				$fila['ben_sep']="si";
				}else{
				$fila['ben_sep']="No";
				}
				if($fila['ben_puente']==1){
				$fila['ben_puente']="si";
				}else{
				$fila['ben_puente']="No";
				}
		
		$rs_becas =	$obj_fichaAlumno->Becas_ins($ano);

	?>
    
    <table width="100%">
    <tr>
    <td class="cuadro01">
    <div id="modifica_becas" style="float:right;"><input align="right" type="hidden" class="botonXX" name="modifica_becas" id="modifica_becas" value="Modificar" title="Modificar" onClick="modificar_becas()" /></div>
    </td>
    </tr>
    </table>
    <div id="muestra_becas">  
     <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    <TR>
    <TD colspan="7"><div id="titulo" class="tableindex">Becas</div>
    </TD></TR>

    <tr>
    <td class="cuadro02">Alimentaci&oacute;n JUNAEB</td>
    <td class="cuadro02">Chile Solidario</td>
    <td class="cuadro02">Municipal </td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=$fila['bool_baj']?></td>
    <td class="cuadro01"><?=$fila['bool_bchs']?></td>
    <td class="cuadro01"><?=$fila['bool_mun']?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Financiamiento compartido de la Instituci&oacute;n</td>
    <td class="cuadro02">C. de Padres</td>
    <td class="cuadro02">Seguro</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=$fila['bool_fci']?></td>
    <td class="cuadro01"><?=$fila['bool_cpadre']?></td>
    <td class="cuadro01"><?=$fila['bool_seg']?></td>
    </tr>
    <tr>
      <td class="cuadro02">Beneficiario PIE</td>
      <td class="cuadro02">Beneficiario SEP</td>
      <td class="cuadro02">Programa PUENTE</td>
    </tr>
    <tr>
      <td class="cuadro01"><?=$fila['ben_pie']?></td>
      <td class="cuadro01"><?=$fila['ben_sep']?></td>
      <td class="cuadro01"><?=$fila['ben_puente']?></td>
    </tr>
    <tr>
    <td class="cuadro02">Otras</td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=$fila['bool_otros']?></td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
    </table>
    <br />
    <table width="100%" border="1" style="border-collapse:collapse">
    <tr>
    <td class="cuadro02">Becas de la Instituci&oacute;n</td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    
     <?php
    	for($i=0;$i < pg_num_rows($rs_becas);$i++)
		{
			$fila_b = pg_fetch_array($rs_becas,$i);
			$id_beca = $fila_b['id_beca'];
		
		?>
    <tr>    
    <td width="21%" class="cuadro01">
    <? echo $fila_b['nomb_beca'];?>
    </td>
    <td width="30%" class="cuadro01">
    <?php
    $rs_becas_al =$obj_fichaAlumno->Becas_alumno($id_beca,$rut_alumno);
	$www = pg_num_rows($rs_becas_al);
	if($www>0){echo "si";}else{echo "no";}
	?>
    </td>
    <td width="49%">&nbsp;</td>
     </tr>
	<?
	}	
	?>
    </table>
    <?
	  }
	?>
    </div>
    </div>
    <div id="documentos">
     <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
      <TD colspan="6"><div id="titulo" class="tableindex">Documentos entregados por el alumno</div>
    </TD></TR>
       <tr>
    <td class="cuadro02">Certificado de Nacimiento</td>
    <td class="cuadro02">Certificado de Notas</td>
    <td class="cuadro02">Nivel </td>
    </tr>
      <tr>
    <td class="cuadro01"><?php echo $fila_matricula['bool_traecertificados'] ?></td>
    <td class="cuadro01"><?php echo $fila_matricula['bool_traecertificadosant'] ?></td>
    <td class="cuadro01"><?php echo $fila_matricula['nivel_certificado'] ?></td>
    </tr>
     <tr>
    <td class="cuadro02">Autor. Secreduc</td>
    <td class="cuadro02">Plazo Fecha</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
      <tr>
    <td class="cuadro01"><?php echo $fila_matricula['bool_secreduc'] ?></td>
    <td class="cuadro01"><?php echo $fila_matricula['plazo_autorizacion'] ?></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
     <tr>
    <td class="cuadro02">Manual de convivencia</td>
    <td class="cuadro02">Aporte Voluntario CCA</td>
    <td class="cuadro02">Pago Matr&iacute;cula </td>
    </tr>
      <tr>
    <td class="cuadro01"><?php echo $fila_matricula['bool_manualconvivencia'] ?></td>
    <td class="cuadro01"><?php echo $fila_matricula['apvol_cgp'] ?></td>
    <td class="cuadro01"><?php echo $fila_matricula['bool_pagomatricula'] ?></td>
    </tr>
     <tr>
    <td class="cuadro02">Abono</td>
    <td class="cuadro02">Nro. Boleta</td>
    <td class="cuadro02">Exento Matr&iacute;cula</td>
    </tr>
      <tr>
    <td class="cuadro01"><?php echo $fila_matricula['abono_matricula'] ?></td>
    <td class="cuadro01"><?php echo $fila_matricula['numboleta'] ?></td>
    <td class="cuadro01"><?php echo $fila_matricula['bool_exentomatricula'] ?></td>
    </tr>
     <tr>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
      <tr>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
     </table>
    </div>
</div>

</form>
</body>
</html>
<?
pg_close($conn);
pg_close($connection);
?>