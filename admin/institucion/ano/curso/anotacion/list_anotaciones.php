<!--MUESTRA INFORMACION Y PERMITE MODIFCAR O ELIMINAR-->
<? 
require('../../../../../util/header.inc');

  /***VARIABLES HOJA DE VIDA***/
  $curso   = $_REQUEST['c_curso'];
  $ano     = $_REQUEST['c_ano'];
  $tipo_hoja = $_REQUEST['tipo_hoja'];
  $alumno    = $_REQUEST['alumno'];
  /********/
  $activo = $_REQUEST['activo'];
  $mod    = $_REQUEST['mod'];
		
 if($activo=="Agregar"){
	$activar = 1;
  }

 if($activo=="Buscar"){
	$activar = 0;
  }

/*INICIO DE PROCESO MOSTRAR NOTAS*/
//require('seteaAnotacion.php3');

$modo = $_FRMMODO;

if($activar==0){ 

if($ano!=NULL && $curso!=NULL && $alumno!=NULL){?>

<table WIDTH="100%" BORDER="0" align="center" CELLPADDING="5" CELLSPACING="0">
<tr height="20">
<td align="middle" colspan="5" class="tableindex">
CONDUCTA
</td>
</tr>
<tr>
<td colspan=5 align=right>
</td>
</tr>
			
<tr class="tablatit2-1">
<td align="center" width="10%">
FECHA
</td>
<td align="center" width="15%">
RESPONSABLE
</td>
<td align="center" width="20%">
SIGLA 
</td>
<td align="center" width="30%">
TIPO ANOTACION 
</td>
<td align="center" width="25%">
ANOTACION
</td>
</tr>
<?
				  
$qry="SELECT anotacion.id_anotacion, anotacion.sigla, anotacion.codigo_tipo_anotacion, anotacion.codigo_anotacion, anotacion.tipo, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, anotacion.fecha, anotacion.tipo, empleado.rut_emp, anotacion.tipo_conducta  FROM (anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) left JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((alumno.rut_alumno)=".trim($alumno).")) and anotacion.id_periodo in (select id_periodo from periodo where id_ano = '".trim($ano)."') order by fecha ";

$result =@pg_Exec($conn,$qry);

//echo $numero_filas = pg_numrows($result);

if (!$result){

error('<B> ERROR :</b>Error al acceder a la BD. (101)</B>');

}else{

if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.

$fila = @pg_fetch_array($result,0);	

if (!$fila){

error('<B> ERROR :</b>Error al acceder a la BD. (8) No hay alumnos inscritos en este curso</B>');
	    exit();
		
       }

	}

 }
 
  $nu_anotaciones = 0;
			
			
  for($i=0 ; $i < @pg_numrows($result) ; $i++){
  
  $fila = @pg_fetch_array($result,$i);
						
  $sigla_aux = $fila["sigla"];
						
  if($fila['tipo']==2){
	  $nu_anotaciones++;
	
	      }					
						
 //if ($sigla_aux!=NULL){
						
 /// NO MUESTRO NADA					
								
  if($sigla_aux!=NULL){
  if($nu_anotaciones==3){
  
    ?>

<tr bgcolor="#F47068" onClick=go('seteaAnotacion.php3?alumno=<?=trim($alumno)?>&anotacion=<?=$fila["id_anotacion"];?>&caso=4&desde=alumno')>
   <?
   
	$nu_anotaciones = 0;
	}else{
		
	   ?>
<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' 
onmouseout=this.style.background='transparent' 
onClick=go('seteaAnotacion.php3?alumno=<?=trim($alumno)?>&anotacion=<?=$fila["id_anotacion"];?>&caso=4&desde=alumno')>
    <? }	
   }else{
   
   if ($nu_anotaciones==3){
	?>
<tr bgcolor="#F47068" onClick=go('seteaAnotacion.php3?alumno=<?=trim($alumno)?>&anotacion=<?=$fila["id_anotacion"];?>&caso=4&desde=alumno&old=1')>
	<?
	   $nu_anotaciones = 0;
	}else{										 
	        ?>
<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' 
onmouseout=this.style.background='transparent' onClick=go('seteaAnotacion.php3?alumno=<?=trim($alumno)?>&anotacion=<?php echo $fila["id_anotacion"];?>&caso=4&desde=alumno&old=1')>
 <?  }
          }    
		      ?> 	
<td align="center" class="textosimple" >

<font face="arial, geneva, helvetica" size="1" color="#000000">
<strong>
<?php echo impF($fila["fecha"]);?>
</strong>
</font>

</td>
<td align="center" class="textosimple" >

<font face="arial, geneva, helvetica" size="1" color="#000000">
<strong>
<?php echo $fila["ape_pat"]." ".$fila["ape_mat"].",".$fila["nombre_emp"];?>
</strong>
</font>
</td>

<td align="center" class="textosimple" >

<font face="arial, geneva, helvetica" size="1" color="#000000">
<strong>
<?php 

// busco la sigla
												
$q1 = "select * from sigla_subsectoraprendisaje where id_sigla = '$sigla_aux'";
       $r1 = @pg_Exec($conn,$q1);
	   $f1 = @pg_fetch_array($r1,0);
																					

echo $f1["sigla"];?> </strong></font></td>						
												
  <td align="center" class="textosimple" >
  <font face="arial, geneva, helvetica" size="1" color="#000000">
  <strong><?php
  
  if($fila["codigo_tipo_anotacion"]=="")
	{
	
	if ($fila['tipo']==1){
	    echo "CONDUCTA ";
	if ($fila['tipo_conducta']==1){
	    echo "POSITIVA";
	                     }	
    if ($fila['tipo_conducta']==2){
	    echo "NEGATIVA";
		                  }
                             }
													   	
														
	if($fila['tipo']==2){
	   echo "ATRASO";
		}															
		
	if($fila['tipo']==3){
	   echo "INASISTENCIA";
			}
															
	if($fila['tipo']==4){
			echo "RESPONSABILIDAD";
			}												
																											
	}else{
																							 
	$cod_ta = $fila["codigo_tipo_anotacion"];													   
	$q1 = "select * from tipos_anotacion where id_tipo = '$cod_ta'";
	$r1 = @pg_Exec($conn,$q1);
	$f1 = @pg_fetch_array($r1,0);

														
	$codta       = $f1['codtipo'];
	$descripcion	= $f1['descripcion'];
																																
	echo "$codta - $descripcion";  
			}
													  
	 ?>
	</strong></font></td>
	<td align="center" class="textosimple" >
	<font face="arial, geneva, helvetica" size="1" color="#000000">
	<strong>
	
<?php 
$codigo_anotacion = $fila["codigo_anotacion"];
$q1 = "select * from detalle_anotaciones  where id_tipo = '$cod_ta' and codigo = '$codigo_anotacion'";

//echo $q1;

$r1 = @pg_Exec($conn,$q1);
$f1 = @pg_fetch_array($r1,0);
												   
$detalle = $f1["detalle"];
												   
echo "$codigo_anotacion - $detalle"; 
 ?>
												
</strong></font></td>
</tr>
<? // } ?>		
<?php
}
  ?>
<tr>
<td colspan="5">
<hr width="100%" color="#003b85">
</td>
</tr>
</table>
<? 		}
}?>
		
