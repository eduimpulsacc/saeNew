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
 datos_familiar();
 $('#Modifica_fam').hide();
	
 });
 
 function datos_familiar()
{
	var rut_alumno = "<?=$rut_alumno;?>";
	var funcion = 5;
	
	var parametros = 'funcion='+funcion+'&rut_alumno='+rut_alumno;
	
		//alert(parametros);
		
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 //alert(data);
	    $("#sel_familiar").html(data);
		//$("#sel_familiar option[value="+rut_alumno+"]").attr("selected",true);
	   }
	})		
}

function ingresa_familiar()
{
	var rut_alumno = "<?=$rut_alumno;?>";
	
	var parametros = 'rut_alumno='+rut_alumno;
	  $.ajax({
	  url:'ingreso_familiar.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 //alert(data);
		 $('#ingreso_familiar').show();
	    $("#ingreso_familiar").html(data);
		$("#ver_familiar").hide();
		$('#guardar_apo').hide();
		
		
	   }
	})		
}

function volver_f()
  {
	   $("#carga_familiar").html(""); 
	   $('#volver_fam').hide();
	   $('#ingresa_fam').show();
	   $("#select_familiar option[value=0]").attr("selected",true);
  }
  
  
 

</script>
</head>
<body>

<form name="Formulariolista" id="Formulariolista" >

<div id="titulo" class="tableindex">titulo</div>

<div id="tabs">

	<ul>
        <li value="1" ><a href="#personal" onClick="cambia_titulos(1)" >Personal</a></li>
        <li value="2"><a href="#familiar" onClick="cambia_titulos(2)" >Familiar</a></li>
        <li value="5"><a href="#becas" onClick="cambia_titulos(5)" >Becas</a></li>
        <li value="6"><a href="#Grupos" onClick="cambia_titulos(6)" >Grupos</a></li>
        <li value="7"><a href="#Entrevistas" onClick="cambia_titulos(7)" >Entrevistas</a></li>
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
	
	
	
			
		/**/
			
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
    <td class="cuadro02">Religion</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=$fila_matricula['bool_ae']?></td>
    <td class="cuadro01"><?=$fila_matricula['bool_aoi']?></td>
    <td class="cuadro01"><?=$fila['religion']?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Procedencia del Alumno</td>
    <td class="cuadro02">Con quien vive</td>
    <td class="cuadro02">Elecci&oacute;n</td>
    </tr>
    
    
    <tr>
    <td class="cuadro01"><?=$fila['c_procedencia']?></td>
    <td class="cuadro01"><?=$fila['cq_vive']?></td>
    <td class="cuadro01"><?=$fila_matricula['txt_eleccion']?></td>
    </tr>
     <tr>
    <td class="cuadro02">Etnia o Pueblo Originario</td>
    <td class="cuadro02">N&deg; Pasaporte</td>
    <td class="cuadro02">Pa&iacute;s origen de Estudiante</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=$fila['txt_etnia']?></td>
    <td class="cuadro01"><? echo $fila['pasaporte']?></td>
    <td class="cuadro01"><?php $lip = $obj_fichaAlumno->pOrigen1($fila['pais_origen']);?>
      <?=pg_result($lip,2);?></td>
    </tr>
    <tr>
    <td class="cuadro02">Observaciones</td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=$fila_matricula['datos_interes']?></td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
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
    <td class="cuadro02">Celular</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><?=$fila['depto']?></td>
    <td class="cuadro01"><?=$fila['villa']?></td>
    <td class="cuadro01"><?=$fila['celular']?></td>
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
    <td class="cuadro02">Fecha Matr&iacute;cula</td>
    <td class="cuadro02">N&deg; matr&iacute;cula</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo CambioFechaDisplay($fila_matricula['fecha']);?></td>
    <td class="cuadro01"><? echo $fila_matricula['num_mat'];?></td>
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
      <td class="cuadro02">&nbsp;</td>
      <td class="cuadro02">&nbsp;</td>
      </tr>
    <tr>
      <td class="cuadro01"><? echo $fila_matricula['motivo_retiro'];?></td>
      <td class="cuadro01">&nbsp;</td>
      <td class="cuadro01">&nbsp;</td>
    </tr>
    
    <tr>
    <td class="cuadro02">Ha repetido curso</td>
    <td class="cuadro02">Esta en tratamiento con especialista</td>
    <td class="cuadro02">Pertenece al programa de integracion escolar (PIE) </td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['curso_rep'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['trat_especialista'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['ben_pie'];?></td>
    </tr>
    
      <tr>
    <td class="cuadro02">Pertenece a subvencion preferencial (SEP)</td>
    <td class="cuadro02">Clasificado(a) con retos multiples</td>
    <td class="cuadro02">Beca Puente </td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['ben_sep'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['bool_retos'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['ben_puente'];?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Financiamiento compartido</td>
    <td class="cuadro02">Presenta sanci&oacute;n</td>
    <td class="cuadro02">Condicionalidad</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['bool_fci'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['sancion'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['condicionalidad'];?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Religion</td>
    <td class="cuadro02">Ev. Diferencial</td>
    <td class="cuadro02">Integrado</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['bool_rg'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['bool_ed'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['bool_i'];?></td>
    </tr>
    <tr>
      <td class="cuadro02">Estilo de aprendizaje</td>
      <td class="cuadro02">Encargado Matr&iacute;cula</td>
      <td class="cuadro02">Grupo Diferencial</td>
    </tr>
    <tr>
      <td class="cuadro01">
      <?php $rs_estilo = $obj_fichaAlumno->estilo_aprendizaje_uno($fila_matricula['estilo_aprendizaje']); 
	  echo pg_result($rs_estilo,1);
	  ?>
      </td>
      <td class="cuadro01"><?
	 if($fila_matricula['enc_matricula']!="" || $fila_matricula['enc_matricula']!=0){
	    $rs_encmat= $obj_fichaAlumno->traeNombreEnMatricula($fila_matricula['enc_matricula']);
	  
	   echo pg_result($rs_encmat,0)." ".pg_result($rs_encmat,1).", ".pg_result($rs_encmat,2);
	 }
	   ?></td>
      <td class="cuadro01"><? echo ($fila_matricula['bool_gdiferencial']==1)?"Si":"No";?></td>
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
    <td class="cuadro02">Sufre alguna enfermedad</td>
    <td class="cuadro02">Ha sido sometido(a) a cirugia</td>
    <td class="cuadro02">Toma algun Medicamento Periodicamente </td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['enfermedad'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['cirugia'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['medicamento'];?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">presenta alguna alergia</td>
    <td class="cuadro02">Tiene Impedimentos para realizar Educacion Fisica</td>
    <td class="cuadro02">Puede tomar algun medicamento</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['alergia'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['fisica'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['fiebre'];?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Cuenta con algun seguro distinto al escolar</td>
    <td class="cuadro02">Tipo de Parto</td>
    <td class="cuadro02">Edad Madre al momento de Parto (alumno)</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['seguro'];?></td>
    <td class="cuadro01"><?php echo $fila['tipo_parto'] ?></td>
    <td class="cuadro01"><?php echo $fila['edad_madre_nace'] ?></td>
    </tr>
    <tr>
      <td class="cuadro02">Peso al nacer</td>
      <td class="cuadro02">Talla al nacer</td>
      <td class="cuadro02">Sistema de Salud</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila['peso_nace'] ?></td>
      <td class="cuadro01"><?php echo $fila['talla_nace'] ?></td>
      <td class="cuadro01"><?php $regis_salud = $obj_fichaAlumno->get_sistema_salud_ficha($fila['s_salud']);
	$sistema_salud2 = pg_result($regis_salud,1);  ?>
        <?=$sistema_salud2;?></td>
    </tr>
    <tr>
      <td class="cuadro02">Presenta Problemas Dentales</td>
      <td class="cuadro02">Se encuentra en Control Dental</td>
      <td class="cuadro02">Fecha &uacute;ltimo control sano</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['bool_pdentales'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['bool_controldental'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['controlsano'] ?></td>
    </tr>
    <tr>
      <td class="cuadro02">Familiares con problemas de salud o discapacidad diganosticada</td>
      <td class="cuadro02">Ha estado en tratamiento neurol&oacute;gico</td>
      <td class="cuadro02">Ha estado en tratamiento con psicopedagogo</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['bool_famenfermo'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['bool_neurologo'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['bool_psicopedagogo'] ?></td>
    </tr>
    	 <tr>
      <td class="cuadro02">Ha estado en tratamiento psicol&oacute;gico</td>
      <td class="cuadro02">Ha estado en otra clase de tratamientos</td>
      <td class="cuadro02">En la actualidad se encuentra en tratamiento</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['bool_psicologo'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['txt_otratamiendo'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['txt_tratactual'] ?></td>
    </tr>
    	 <tr>
      <td class="cuadro02">Posee antedecentes de trastornos de aprendizaje, d&eacute;ficit atencional, otros</td>
      <td class="cuadro02">Ha estado en tratamiento psiqui&aacute;trico</td>
      <td class="cuadro02">Ha estado en tratamiento con fonoaud&oacute;logo</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['txt_tastornosaprendizaje'] ?></td>
      <td class="cuadro01"><? echo ($fila_matricula['bool_psiquiatra']==1)?"Si":"No";?></td>
      <td class="cuadro01"><? echo ($fila_matricula['bool_fonoaudiologo']==1)?"Si":"No";?></td>
    </tr>
    <tr>
      <td class="cuadro02">Presenta problemas de visi&oacute;n</td>
      <td class="cuadro02">Presenta problemas de audici&oacute;n</td>
      <td class="cuadro02">Presenta problemas a la columna</td>
    </tr>
    <tr>
      <td class="cuadro01"><? echo ($fila_matricula['bool_pvision']==1)?"Si":"No";?></td>
      <td class="cuadro01"><? echo ($fila_matricula['bool_paudicion']==1)?"Si":"No";?></td>
      <td class="cuadro01"><? echo ($fila_matricula['bool_pcolumna']==1)?"Si":"No";?></td>
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
    <td class="cuadro02">Jefe de Hogar</td>
    <td class="cuadro02">Ocupaci&oacute;n Jefe de Hogar</td>
    <td class="cuadro02">Integrantes grupo familiar</td>
    </tr>
    <tr>
    <td class="cuadro01"><?php echo $fila_matricula['jefe_hogar'] ?></td>
    <td class="cuadro01"><?php echo $fila_matricula['ocup_jefehogar'] ?></td>
    <td class="cuadro01"><?php echo $fila_matricula['num_grupofamiliar'] ?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Total Ingresos</td>
    <td class="cuadro02">Tipo de Vivienda</td>
    <td class="cuadro02">Cantidad Dormitorios</td>
    </tr>
    <tr>
    <td class="cuadro01"><?php echo $fila_matricula['ingresos'] ?></td>
    <td class="cuadro01">
	<?php 
	if($fila_matricula['tipo_vivienda']==1){
		$fila_matricula['tipo_vivienda']="Propia";
		}
		elseif($fila_matricula['tipo_vivienda']==2){
	$fila_matricula['tipo_vivienda']="Arrendada";
		}
		elseif($fila_matricula['tipo_vivienda']==3){
	$fila_matricula['tipo_vivienda']="Allegados";
		}
		else{
			$fila_matricula['tipo_vivienda']="";
		}
	?>
	
	
	<?php echo $fila_matricula['tipo_vivienda'] ?></td>
    <td class="cuadro01"><?php echo $fila_matricula['cant_dormitorios'] ?></td>
    </tr>
     <tr>
      <td class="cuadro02">Material vivienda</td>
      <td class="cuadro02">Estado vivienda</td>
      <td class="cuadro02">Vivienda tiene luz</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['material_vivienda'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['estado_vivienda'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['bool_tieneluz'] ?></td>
    </tr>
     <tr>
      <td class="cuadro02">vivienda tiene agua</td>
      <td class="cuadro02">Vivienda tiene alcantarillado</td>
      <td class="cuadro02">Subsidio &uacute;nico</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['bool_tieneagua'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['bool_tienealcantarillado'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula[''] ?></td>
    </tr>
    <tr>
    <td class="cuadro02">Cantidad Ba&ntilde;os</td>
     
    <td class="cuadro02">Tiene Espacio para Jugar</td>
    <td class="cuadro02">Tiene Espacio para Estudiar</td>
    </tr>
    <tr>
    <td class="cuadro01"><?php echo $fila_matricula['cant_banos'] ?></td>
    <td class="cuadro01"><?php echo $fila_matricula['bool_espacio_juego'] ?></td>
    <td class="cuadro01"><?php echo $fila_matricula['bool_espacio_estudio'] ?></td>
    </tr>
    <tr>
      <td class="cuadro02">Figura Paterna</td>
      <td class="cuadro02">Aporta dinero al hogar</td>
      <td class="cuadro02">Hizo Jardin / Prekinder</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['figura_paterna'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['bool_aporta_figura_paterna'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['bool_hizo_jardin'] ?></td>
    </tr>
    <tr>
      <td class="cuadro02">Cuan Cari&ntilde;oso es</td>
      <td class="cuadro02">Cuan sociable es</td>
      <td class="cuadro02">Cuan curioso es</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['carinoso'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['sociable'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['curioso'] ?></td>
    </tr>
    <tr>
      <td class="cuadro02">Organizaciones en que Participa</td>
      <td class="cuadro02">Con quien estudia</td>
      <td class="cuadro02">N&uacute;mero de hermanos</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['org_participa'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['con_quien_estudia'] ?></td>
      <td class="cuadro01"><?php echo $fila['cant_hermanos'] ?></td>
    </tr>
     <tr>
      <td class="cuadro02">Num. Causa Juzgado Familia</td>
      <td class="cuadro02">Num. Ficha Protecci&oacute;n social</td>
      <td class="cuadro02">Beneficios programa social</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['txt_causajuzgado'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['txt_fichaps'] ?></td>
      <td class="cuadro01"><?php echo $fila_matricula['ben_prog_prot_social'] ?></td>
    </tr>
    	 <tr>
      <td class="cuadro02">Lugar que ocupa entre los hermanos</td>
      <td class="cuadro02">Sacramentos recibidos</td>
      <td class="cuadro02">Practica alg&uacute;n deporte</td>
        </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila['num_hermano'] ?></td>
      <td class="cuadro01"><?php echo ($fila['bool_bautismo']==1)?"Bautismo":"" ?> <?php echo ($fila['bool_pcomunion']==1)?"P. Comuni&oacute;n":"" ?> <?php echo ($fila['bool_confirmacion']==1)?"Confirmaci&oacute;n":"" ?>  </td>
      <td class="cuadro01"><? echo ($fila['bool_deporte']==0)?"NO":$fila['txt_deporte'];?></td> 
      </tr>
     <tr>
    <td class="cuadro02" colspan="3">Observaciones Generales</td>
    </tr>
    
    <tr>
    <td class="cuadro01" colspan="3">&nbsp;</td>
    </tr>
   </table>
   <!------------------------------------>
   <br>
    <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    <TR>
    <TD colspan="7"><div id="titulo" class="tableindex">EMERGENCIAS Y RETIROS</div>
    </TD>
    </TR>
    
    <tr>
    <td colspan="3" class="cuadro02">Autoriza al Establecimiento a sacar a su pupilo en caso de emergencia de salud</td>
   
    </tr>
    <tr>
    <td width="34%" class="cuadro01"><? echo $fila_matricula['autoriza_emergencia'];?></td>
    <td width="31%" class="cuadro01">&nbsp;</td>
    <td width="35%" class="cuadro01">&nbsp;</td>
    </tr>
     <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
    <tr class="tablatit2-1" >
    <td  colspan="3">
    PERSONAS AUTORIZADAS PARA RETIRAR EL ALUMNO, EN CASO DE NO SER LOS PADRES O APODERADOS
    </td>
    </tr>
    
    <tr>
      <td colspan="3" class="cuadro01">&nbsp;</td>
      </tr>
    <tr>
      <td colspan="3" class="cuadro02">Persona Autorizada n&deg;1</td>
      </tr>
    <tr>
    <td class="cuadro02">Rut</td>
    <td class="cuadro02">Nombre</td>
    <td class="cuadro02">Parentesco</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['rut_retira'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['nombre_retira'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['parentesco_retira'];?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Telefono</td>
    <td class="cuadro02">Celular</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['fono_retira'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['celular_retira'];?></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="3" class="cuadro01">&nbsp;</td>
      </tr>
      <tr>
      <td colspan="3" class="cuadro02">Persona Autorizada n&deg;2</td>
      </tr>
    <tr>
    <td class="cuadro02">Rut</td>
    <td class="cuadro02">Nombre</td>
    <td class="cuadro02">Parentesco</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['rut_retira2'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['nombre_retira2'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['parentesco_retira2'];?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Telefono</td>
    <td class="cuadro02">Celular</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['fono_retira2'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['celular_retira2'];?></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="3" class="cuadro01">&nbsp;</td>
      </tr>
      <tr>
      <td colspan="3" class="cuadro02">Persona Autorizada n&deg;3</td>
      </tr>
    <tr>
    <td class="cuadro02">Rut</td>
    <td class="cuadro02">Nombre</td>
    <td class="cuadro02">Parentesco</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['rut_retira3'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['nombre_retira3'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['parentesco_retira3'];?></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Telefono</td>
    <td class="cuadro02">Celular</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['fono_retira3'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['celular_retira3'];?></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="3" class="cuadro01">&nbsp;</td>
      </tr>
    <tr>
      <td class="cuadro02">Viaja en transporte escolar</td>
      <td class="cuadro02">Nombre tio(a)</td>
      <td class="cuadro02">telefono</td>
    </tr>
    <tr>
    <td class="cuadro01"><? echo $fila_matricula['viaja_furgon'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['nombre_tio'];?></td>
    <td class="cuadro01"><? echo $fila_matricula['fono_furgon'];?></td>
    </tr>
    	 <tr>
      <td class="cuadro02">Apoderado autoriza a alumno a retirarse solo del colegio</td>
      <td class="cuadro02">&nbsp;</td>
      <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
      <td class="cuadro01"><?php echo $fila_matricula['bool_retirosolo'] ?></td>
      <td class="cuadro01">&nbsp;</td>
      <td class="cuadro01">&nbsp;</td>
    </tr>
    
   </table>
   <br>
    <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    <TR>
    <TD colspan="4"><div id="titulo" class="tableindex">AUTORIZACIONES</div>
    </TD>
    </TR>
    <TR  class="cuadro02" >
      <TD valign="top">Cambiar de ropa en caso de ser necesario</TD>
      <TD valign="top" >Tomar fotografías/videos en actividades escolares</TD>
      <TD valign="top">Compartir fotografías en Facebook Escuela</TD>
      <TD valign="top">Aplicar vacunas en el establecimiento</TD>
    </TR>
    <TR  class="cuadro01">
      <TD>&nbsp;<?php echo ($fila_matricula['bool_cambioropa']==1)?"Si":"No" ?></TD>
      <TD>&nbsp;<?php echo ($fila_matricula['bool_tomafoto']==1)?"Si":"No" ?></TD>
      <TD>&nbsp;<?php echo ($fila_matricula['bool_facebook']==1)?"Si":"No" ?></TD>
      <TD><?php echo ($fila_matricula['aut_vacuna']==1)?"Si":"No" ?></TD>
    </TR>
    
    </table>
   <br>

  
  <?php
     } 
	?>
     </div>
<!-----------div datos familiar--------------------->     
<div id="familiar"> 
   <div id="ingreso_familiar"></div>
    <div id="ver_familiar">
    <table width="100%">
    <tr>
    <td class="cuadro01"><div id="sel_familiar"><select size="1px" ><option value="0">Seleccione Familiar</option></select></div></td>
    <td class="cuadro01">
      <div id="volver_fam" style="float:right;"><input align="right" type="button" class="botonXX" name="volver_fa" id="volver_fa" value="Volver" onClick="volver_f()" /></div>
      
    <div id="ingresa_fam" style="float:right;">
    <? if($ingreso==1){?>
    <input align="right" type="button" class="botonXX" name="btn_ingresa_fam" id="btn_ingresa_fam" value="Ingresar Familiar" onClick="ingresa_familiar()" />
    <? } ?>
    </div>
<!--    <div id="Modifica_fam" style="float:right;"><input align="right" type="button" class="botonXX" name="btn_mod_fam" id="btn_mod_fam" value="Modificar Familiar" onclick="Modifica_familiar()" /></div>--></td>
    </table>
    <div id="carga_familiar"></div>
    </tr>
    </table>
    </div>
    </div>
    
   <!-- <div id="academico">
    <h3>academica</h3>
    </div> -->
        
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
    <div id="modifica_becas" style="float:right;"><input align="right" type="hidden" class="botonXX" name="modifica_becas"  value="Modificar" title="Modificar" onClick="modificar_becas()" /></div>
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
    
    <!--grupos-->
   <div id="Grupos" style="width:100%;"  >
    
    <?php
		$rs_grupos = $obj_fichaAlumno->get_grupos($rut_alumno);
	?>

	<table width="97%">
    <tr class="cuadro01">
    <td width="876" align="right">&nbsp;</td>
    <td width="120" style="float:right;">
   	<? if($ingreso==1){?> 
    <input type="button" id="agregar_gruposx" align="right" class="botonXX" title="Agregar grupo" value="Agregar" onClick="agregar_grupo()">
    <? } ?>
    </td>
    
    </tr>
    </table>
    <div id="separar" style="height:5px;">&nbsp;</div>
    <div id="agrega_grupos"></div>
    <div id="muestra_grupos" align="left">
    <table width="93%" cellpadding="1" cellspacing="1" border="1" style="border-collapse:collapse">
    <tr>
    <td width="26%" class="cuadro02"><div align="left">Nombre</div></td>
	<td width="61%" class="cuadro02"><div align="left">Descripci&oacute;n</div></td>
	<?
    if (($_PERFIL=="14") OR ($_PERFIL=="0")){ ?>				
    <td width="13%" class="cuadro02"><div align="center">Borrar</div></td>
    <? } ?>	
    </tr>
    
    <?php for($x=0;$x < pg_num_rows($rs_grupos);$x++){
		  $fila_g = pg_fetch_array($rs_grupos,$x);
		?>
		<tr>
        <td class="cuadro01"><?=$fila_g['nombre'];?></td>
        <td class="cuadro01"><?=$fila_g['descripcion'];?></td>
        <td  align="center" style="CURSOR:hand;cursor:pointer">
          <img src="../../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Delete.png" width="24" height="24" onClick="elimina_grupo(<?=$fila_g['id_aux'];?>)"/>
        </td>
        </tr>
		<?
		}
	?>
    
    </table>
    </div>
    </div>
    <!--fin grupos-->
    
     <!--entrevista-->
         <div id="Entrevistas">
     <div id="div_agrega_ent"></div>
      <div id="contenedor_ent">
    <?php
    $rs_responsable = $obj_fichaAlumno->Datos_Familiar_responsable($rut_alumno);
	$rut_responsable = pg_result($rs_responsable,0);
	//$rut_responsable;
	$rs_datos_apo = $obj_fichaAlumno->Datos_Familiar2($rut_responsable);
	 $nombre_apo = pg_result($rs_datos_apo,2);
	$ape_pat_apo = pg_result($rs_datos_apo,3);
	$ape_mat_apo = pg_result($rs_datos_apo,4);
	
	$nombre_completo_apo = trim($nombre_apo).' '.trim($ape_pat_apo).' '.trim($ape_mat_apo);
	$result_entr = $obj_fichaAlumno->get_entrevista_apo($rut_responsable,$rut_alumno,$_ANO);
	
	
	
	?>
    <input type="hidden" id="h_rut_responsable" value="<?=$rut_responsable?>" />
   <table width="100%">
    <tr>
    <td>
   Nombre Apoderado&nbsp;&nbsp;:&nbsp;&nbsp;<?=$nombre_completo_apo;?>
   <input type="hidden" id="hidden_n_apo" value="<?=trim($nombre_completo_apo);?>">
    </td>
    </tr>
    </table> 
    
   <table width="100%">
    <tr>
    <td class="cuadro01">
    <div id="modifica_ent" style="float:right;">
    <? if($ingreso==1){?>
    <input align="right" type="button" class="botonXX" name="agregar_entrevista" id="agregar_entrevista" value="Agregar" title="Agregar Entrevista" onClick="agregar_entrevistas();cargaCitacionAll()" /></div>
    <? } ?>
    </td>
    </tr>
    </table>
    
    
   <table width="100%" style="border-collapse:collapse" border="1">
  
    <tr>
          <td width="12%"  class="cuadro02"><div align="left">Fecha</div></td>
          <td width="9%"  class="cuadro02"><div align="left">Tipo</div></td>
		  <td width="15%"  class="cuadro02"><div align="left">Asunto</div></td>
		  <td width="15%"  class="cuadro02"><div align="left">Descripci&oacute;n</div></td>
          <td width="15%" class="cuadro02">Observaciones</td>
		  <td width="15%" class="cuadro02">Compromisos y Acuerdos</td>
		  <td width="5%" align="center" class="cuadro02">VER</td>
				<?
				if (($_PERFIL=="14") OR ($_PERFIL=="0")){ ?>				
          <td width="5%" class="cuadro02"><div align="center">Borrar</div></td>
			   <? } ?>	
               </tr> 
               
               <?
               	for($j=0;$j < pg_num_rows($result_entr);$j++){
								
							  $fila_ent=pg_fetch_array($result_entr,$j);
							  
							  
							 $citacion=($fila_ent['id_citacion']=="")?0:$fila_ent['id_citacion'];
							  
				?>
					<tr>
                    	
                        <td  class="cuadro01"><?=CambioFechaDisplay($fila_ent['fecha'])?></td>
                        <td  class="cuadro01"><?=($fila_ent['tipo_entrevista']==2?"Rendimiento":"Conducta")?></td>
                        <td width="15%"  class="cuadro01"><?=$fila_ent['asunto']?></td>
                        <td width="15%"  class="cuadro01"><?=utf8_decode($fila_ent['observaciones'])?>
                      <td width="15%"  class="cuadro01"><?=utf8_decode($fila_ent['compromisos'])?>
                      <td width="15%"  class="cuadro01"><?=utf8_decode($fila_ent['acuerdos'])?>
                      </td>
                      <td width="5%" align="center"  class="cuadro01"><img src="../../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Search.png" width="24" height="24" onClick="traeComprobanteEntrevista2(<?php echo $fila_ent['id_entrevista'] ?>,<?=$citacion;?>)"/>
                   
                    </td>
                        
                           <?
			              if (($_PERFIL=="14") OR ($_PERFIL=="0")){ ?>
                              <td class="cuadro01" style="CURSOR:hand;cursor:pointer">
                              <? if (($_PERFIL!=19) and ($_PERFIL!=2) and ($_PERFIL!=20)){ ?>
                                  <div align="center">
 <img src="../../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Delete.png" width="24" height="24" onClick="elimina_ent(<?=$fila_ent['id_entrevista'];?>,<?=$citacion;?>)"/>                                  </div>
			                <? } ?>
                             </td>
			           <? } ?>
                    </tr>
				
				<?			  					
						
					
					}
			   ?>
               
               
               
               </table>
    </div>
    
    </div>

    <!--fin entrevista-->
 </div>
</form>
</body>
</html>
<?
pg_close($conn);
pg_close($connection);
?>