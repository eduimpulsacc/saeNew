<? 
require('../../../../../util/header.inc');
  
  $ano     = $_REQUEST['c_ano'];
  $alumno    = $_REQUEST['alumno'];
  $Cuenta_desde_que_fila = $_REQUEST['Cuenta'];
  $van = $_REQUEST['van'];
  
  $numero_fila = 30;
  $xx=0;
  
  if( $Cuenta_desde_que_fila  == 0 )
  { $Cuenta_desde_que_fila = 0;  }
 
    $cantidad_reg = "SELECT a.codigo_anotacion FROM anotacion as a
    INNER JOIN alumno as al ON a.rut_alumno = al.rut_alumno AND al.rut_alumno = $alumno
	LEFT JOIN empleado as e ON a.rut_emp = e.rut_emp 
	LEFT JOIN sigla_subsectoraprendisaje as si ON si.id_sigla = cast(a.sigla as integer)
	LEFT JOIN tipos_anotacion as ti ON ti.id_tipo = cast(a.codigo_tipo_anotacion as integer)
	LEFT JOIN detalle_anotaciones as dt ON dt.id_tipo = ti.id_tipo AND dt.codigo = a.codigo_anotacion
	WHERE a.id_periodo in (select id_periodo from periodo where id_ano = $ano ) order by fecha";  
	 
   $result = pg_Exec($conn,$cantidad_reg)  or die ( "Error : 12ERT" );

	if (!$result){
			echo 'No se encontro Informacion en BD.(1)';
			}else{
					if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
						$reg = pg_fetch_array($result,0);	
					if (!$reg){
						  echo "Error al acceder a la BD.(2)";
						}
					}
			}
		
$num_reg = pg_numrows($result);

$sql = "SELECT * FROM anotacion WHERE rut_alumno = $alumno";
$reg =@pg_Exec($conn,$sql)  or die ("Error 013):".$sql);

if ( pg_numrows($reg) != 0 ){

$regfila = @pg_fetch_array($reg,0);
	

		if (!$regfila['sigla']){
		    $nullsigla1 = '/*';
			$nullsigla2 = '*/';
		}else{ 
			$nullsigla1 = '';
			$nullsigla2 = '';
		}
		

	if (!$regfila['codigo_tipo_anotacion']){
	    $nullcota1 = '/*';
		$nullcota2 = '*/';
	}else{ 
		$nullcota1 = '';
		$nullcota2 = '';
	}

			if (!$regfila['codigo_anotacion']){
		          $nullca1 = '/*';
				  $nullca2 = '*/';
			}else{ 
				$nullca1 = '';
				$nullca2 = '';
			}


 }


$sql = "SELECT a.*,$nullsigla1 si.sigla,si.detalle, $nullsigla2
CASE
  WHEN a.codigo_anotacion IS NULL THEN 'TRADICIONAL'
  ELSE (a.codigo_anotacion  
  $nullca1 || '-' || dt.detalle $nullca2  ) END as anotacion,
CASE 
  $nullcota1 WHEN ti.codtipo IS NOT NULL THEN (ti.codtipo || '-'|| ti.descripcion) $nullcota2
  WHEN a.tipo = 1 and a.tipo_conducta = 1 THEN 'CONDUCTA POSITIVA'
  WHEN a.tipo = 1 and a.tipo_conducta = 2 THEN 'CONDUCTA NEGATIVA'
  WHEN a.tipo = 2 THEN 'ATRASO'
  WHEN a.tipo = 3 THEN 'RESPONSABILIDAD'
  WHEN a.tipo = 4 THEN 'INASISTENCIA' 
END as tipo_anotacion,
  a.observacion,
  a.rut_alumno,initcap(al.nombre_alu || ' ' ||al.ape_pat || ' ' || al.ape_mat) as nombre_alumno,
  e.rut_emp,initcap(e.nombre_emp || ' ' || e.ape_pat || ' ' ||e.ape_mat) as nombre_empleado 
FROM anotacion as a
INNER JOIN alumno as al ON a.rut_alumno = al.rut_alumno AND al.rut_alumno = $alumno 
INNER JOIN empleado as e ON a.rut_emp = e.rut_emp 
$nullsigla1 LEFT JOIN sigla_subsectoraprendisaje as si ON si.id_sigla = cast(a.sigla as integer) $nullsigla2
$nullcota1 LEFT JOIN tipos_anotacion as ti ON ti.id_tipo = cast(a.codigo_tipo_anotacion as integer) $nullcota2
$nullca1 LEFT JOIN detalle_anotaciones as dt ON dt.id_tipo = ti.id_tipo AND dt.codigo = a.codigo_anotacion $nullca2
WHERE a.id_periodo in (select id_periodo from periodo where id_ano = $ano ) order by fecha asc
LIMIT $numero_fila OFFSET $Cuenta_desde_que_fila";
		
 '<pre>'.$sql.'</pre>';
		
			$result = pg_Exec($conn,$sql) or die ( "Error : 345rt5");

		if (!$result){
            echo "Error al acceder a la BD. (3)";
        }else{
				if (pg_numrows($result)!=0){  //En caso de estar el arreglo vacio.
					$reg = pg_fetch_array($result,0);	
				if (!$reg){
					echo "Error al acceder a la BD.(4)";
					}
				}
        }
    
	

	
  ?>

<style type="text/css" media="screen, projection">

  tr.tdsea { 
    background-color: #ebf3ff;
	color: #000000; 
	cursor:pointer; 
	}
  
  tr.hilite { 
  	background-color:#FFFF99;
	color: #000000;
	cursor:pointer;
    }
	
 tr.tres { 
  	
	color: #F00;
	cursor:pointer;
    }	
				   
</style>

<script type="text/javascript" language="javascript">

  function abrirdialog(x){

   var ano=document.form.cmbANO.value;
   var alumno=document.form.cmbALUMNO.value;
	
   var parametros='c_ano='+ano+'&alumno='+alumno+'&idanotacion='+x;
    		       
    $.ajax({
			
	  url:'mostrar.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	     
	    $("#dialogo").html(data);
		
			   $("#dialogo").dialog({
				  modal: true,
				  title: "Anotacion Numero:"+x,
				  width: 800,
				  minWidth: 400,
				  maxWidth: 700,
				  show: "fold",
				  hide: "scale"
				  
			   });
		  }
	  })
  }
  


 $("#listaanotaciones .tdsea").hover(function () {
      $(this).addClass("hilite");
  }, function () {
      $(this).removeClass("hilite");
 });



   
/*  $(document).ready(function() {
   
   $("#tabla-proyectos tr").click(function() {
   
      $(this).val();
	  
   
      });
   
    });*/
	  


/*   function elimina_anotacion(){ 
   
   	var parametros ="idperiodo="+idper;
   
   			$.ajax({
   							
   			  url:'elimina_anotacion.php',
   			  data:parametros,
			  type:'POST',
			  
			  success:function(data){
			        $("#fechasdeperiodo").html(data);
				    } 
	             })  
		       } */
			   
			   
			   
</script>

<div id="dialogo" ></div>
<br>
<table id="listaanotaciones" width="65%" class="tablatit2-1" cellspacing="1" cellpadding="0"
border="0" style="border-collapse:collapse" >

 <tr align="left" style="border:solid" >
  <th width="6%" >&nbsp;&nbsp;</th> 
  <th width="13%" >FECHA&nbsp;&nbsp;</th>
  <th width="32%" >RESPONSABL-E&nbsp;&nbsp;</th>
  <? if ($fila['sigla']){  ?> 
  <th width="9%"  align="center">SIGLA&nbsp;&nbsp;</th>
  <? } ?>
  <th width="22%" >TIPO ANOTACION&nbsp;</th>
  <th width="18%" >ANOTACION&nbsp;&nbsp;</th>
 </tr>
 

  <?
  
  if ($_REQUEST['Cuenta'] != ""){
  $e = $_REQUEST['Cuenta'];
  $c = $_REQUEST['Cuenta'];
  }else{
  $e = 0 ;
 
$cuenta_atraso=1;
   }
  
  	$total= pg_numrows($result);
	$divisor = ($total % 3);
	 
	$divisor;
	
	$x=0;
  for($i=0 ; $i < @pg_num_rows($result) ; $i++){
   
    $e++; // contador de registros hasta mostrar el ultimo 
	
	
  $fila = @pg_fetch_array($result,$i);

 if($fila["tipo_anotacion"]=="ATRASO"){
	  $x=1+$x;
	  $ca=$ca+1;
    }
	

//if($fila["tipo_anotacion"]=="ATRASO" and $x==3 || $x==6 || $x==9 || $x==12 || $x==15 || $x==18 || $x==24 || $x==27 || $x==30){
if($fila["tipo_anotacion"]=="ATRASO" && ($x+$van)%3==0){
	
?>

<tr class="tres" id="registroanotacion" onclick="abrirdialog(<?=$fila["id_anotacion"]?>)">

<?	
}else{
?>

  <tr id="registroanotacion" class="tdsea">
  <?
}
  ?>
    <td id="" onclick="elimina_anotacion(<?=$fila["id_anotacion"]?>)" align="center">
<img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-48/Delete.png" width="18" height="18" border="0" />&nbsp;</td>
    <td id="" onclick="abrirdialog(<?=$fila["id_anotacion"]?>)" ><p>
      <?=impF($fila["fecha"])?>
      &nbsp;&nbsp;</p>
        <p> </p></td>
    <td id="" onclick="abrirdialog(<?=$fila["id_anotacion"]?>)" ><p>
      <?=$fila["nombre_empleado"]?>
      &nbsp;&nbsp;</p>
        <p> </p></td>
    <? if ($fila['sigla']){  ?>    
    <td id="" onclick="abrirdialog(<?=$fila["id_anotacion"]?>)" align="center"><p>
      <?=$fila["sigla"]?>
      &nbsp;&nbsp;</p>
        <p> </p></td>
        <?  } ?>
    <td id="" onclick="abrirdialog(<?=$fila["id_anotacion"]?>)" ><p>
      <?=substr($fila["anotacion"],0,15);?>
      &nbsp;&nbsp;</p>
        <p> </p></td>
    <td id="" onclick="abrirdialog(<?=$fila["id_anotacion"]?>)" ><p>
      <?=substr($fila["tipo_anotacion"],0,15);?>
      &nbsp;&nbsp;</p>
        <p> </p></td>
  </tr>
  <?  } ?>

</table>
<div>
<?php //echo $ca+$van; ?>
<?
if ($num_reg <= 30){  
	
	echo $num_reg; 
	 
	} else {
	
	
	if ($e!=0){
    $r1 = $c;
	$r2 = $e;
	

	if($c <= 30){ $r = 0;}
	else{ 
	  $r = $r1-30;}
	
	$ultima = $num_reg - 30;
	
	echo '<a href="#" onClick="enviapag(0)" ><<-</a>';
	echo '<a href="#" onClick="enviapag('.$r.','.$ca.')" ><img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-48/Back.png" width="18" height="18" border="0" /></a>';
	echo ' Del '.($c+1).' Hasta '.$e.' de '.$num_reg.'  ';
	if($num_reg != $e){
	echo '<a href="#" onClick="enviapag('.$r2.','.$ca.')" ><img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-48/Next.png" width="18" height="18" border="0" /></a>';
	echo '<a href="#" onClick="enviapag('.$ultima.')" >->></a>';
	}
	}
	
	}
?>

</div>
