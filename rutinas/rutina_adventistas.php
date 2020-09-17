
<?php 

$id_base =2; 
//$nano = 2017;
//$rdb =9121;  
  


 if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

  if($id_base==3){
	$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");	
	//$conn=pg_connect("dbname=coi_antofagasta host=190.196.32.148 port=5432 user=postgres password=300600") or die ("Error de conexion Antofagasta.");	
	 }
	 
  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	 }
	
	//ano escolar
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

function envia_mes($mes){
		
		if($mes=="01"){$t_mes="Enero";}
		if($mes=="02"){$t_mes="Febrero";}
		if($mes=="03"){$t_mes="Marzo";}
		if($mes=="04"){$t_mes="Abril";}
		if($mes=="05"){$t_mes="Mayo";}
		if($mes=="06"){$t_mes="Junio";}
		if($mes=="07"){$t_mes="Julio";}
		if($mes=="08"){$t_mes="Agosto";}
		if($mes=="09"){$t_mes="Septiembre";}
		if($mes=="10"){$t_mes="Octubre";}
		if($mes=="11"){$t_mes="Noviembre";}
		if($mes=="12"){$t_mes="Diciembre";}	
		return ($t_mes);			
	  
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
	
	

?>
<!DOCTYPE HTML>
<html>
<head>
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script src="../admin/clases/jquery/jquery.js"></script>
<script>
$( document ).ready(function() {
   listaAno();
});


function listaAno(){

var funcion=3;
var base = <?php echo $id_base ?>;
var rdb = $('#cmbINSTITUCION').val();
var aan = parseInt(<?php echo $_POST['cmbANO'] ?>);


var parametros = "funcion="+funcion+"&rdb="+rdb+"&base="+base;
//alert(parametros)
	  $.ajax({
			url:"arma_penalolen/armar.php",
			data:parametros,
			type:'POST',
			success:function(data){
			
			console.log(data);
					if(data == 0){
					   alert("Error al cargar");
					}else{
					 $("#aa").html(data);
					 $('#cmbANO > option[value="'+aan+'"]').attr('selected', 'selected');
					}
		        }
		    })

}

</script>
<form action="rutina_adventistas_print.php" method="post"  name="form">

<table width="80%" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td width="11%">Institucion</td>
    <td width="3%">&nbsp;</td>
    <td width="86%">&nbsp;
    <? $sql="SELECT distinct(i.rdb), i.nombre_instit 
			FROM corp_instit ci 
			INNER JOIN institucion i ON ci.rdb=i.rdb  
			WHERE num_corp in (14,15,16,17,18,19,20,33,34)
			ORDER BY 2 ASC";
	$rs_institucion = pg_exec($conn,$sql);
	?> 
    <select name="cmbINSTITUCION" id="cmbINSTITUCION" onchange="listaAno()">
    	<option value="0">SELECCIONE...</option>
     <? for($i=0;$i<pg_numrows($rs_institucion);$i++){
		 	$fila = pg_fetch_array($rs_institucion,$i);
			if($_POST['cmbINSTITUCION']==$fila['rdb']){
	 ?>
     	<option value="<?=$fila['rdb'];?>" selected ><?=$fila['nombre_instit'];?></option>
        
      <? }else{ ?>
		       	<option value="<?=$fila['rdb'];?>"><?=$fila['nombre_instit'];?></option>
	<?  }
	} ?>
		   
    </select>
    <input name="id_base" type="hidden" id="id_base" value="<?php echo $id_base ?>">
    </td>
  </tr> 
  <tr>
    <td>A&ntilde;o</td>
    <td>&nbsp;</td>
    <td>&nbsp;
   <span id="aa"> 
   <select name="cmbANO" id="cmbANO">
   <option	value="0">SELECCIONE...</option>
   </select>
    </span>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><input name="b_exp" id="b_exp" type="submit" value="EXPORTAR A EXCEL" ></td>
  </tr>
    </table>
</form>
<br>
<br>
<br>
<br>


</head></html>