<?php
require('../../../../../../util/header.inc');

$funcion = $_POST['funcion'];



$sql="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$_ANO;
$rs_ano = pg_exec($conn,$sql);
$nro_ano = pg_result($rs_ano,0);


if($funcion==1){
//print_r($_POST);
// Establecer el idioma al Español para strftime().
setlocale( LC_TIME, 'spanish' );
//$id_curso = 22710;
// Si no se ha seleccionado mes, ponemos el actual y el año
//echo "-->".$month = isset($_POST['mes']) ? $_POST[ 'mess' ] : date( 'Y-n' );


//$month = $_POST['ano'].'-'.$_POST['mes'];
$month = $nro_ano.'-'.$_POST['mes'];

$semama = 1;

for ( $i=1;$i<=date( 't', strtotime( $month ) );$i++ ) {

	$dia_semana = date( 'N', strtotime( $month.'-'.$i )  );

	$calendario[ $semama ][ $dia_semana ] = $i;

	if ( $dia_semana == 7 )
		$semama++;
}

?>


<table  width="50%" border="1" align="center" style="border-collapse:collapse">
    <tr>
    <td colspan="7" align="center" class="tableindex"><?php echo strftime( '%B %Y', strtotime( $month ) ); ?></td>
    </tr>
    <tr>
    <td>Lunes</td>
    <td>Martes</td>			
    <td>Mi&eacute;rcoles</td>			
    <td>Jueves</td>			
    <td>Viernes</td>			
    <td>S&aacute;bado</td>			
    <td>Domingo</td>			
    </tr>
    <?php foreach ( $calendario as $dias ) : ?>
    <tr>
    <?php for ( $i=1;$i<=7;$i++ ) : ?>
    <? 


	if(pg_dbname()=="coi_final_vina"){
		echo $fecha = '2013-3-'.$dias[ $i ];
		//$fecha_i=$dias[ $i ].'-3-2013';
		}else{
		$fecha=$_POST['mes']."-".$dias[ $i ]."-".$nro_ano;	
		}

	if($dias[ $i ] != "") {
		
		$sql_dias_ok="select date_part('DAY',fecha),estado_sige from asistencia_sige 
		where fecha='$fecha' and id_curso=$id_curso and estado=1";
		$result_dias_ok=@pg_exec($conn,$sql_dias_ok)or die("fallo ".$sql_dias_ok);
		 $dias_ok = pg_result($result_dias_ok,0);
		 $estado_sige=pg_result($result_dias_ok,1);
		
			?>
        <td>
        
    <input type="text" name="txt_dias<?=$dias[$i]?>" id="txt_dias<?=$dias[$i]?>" size="4" <? if($dias_ok == $dias[$i] and $estado_sige!=1){ ?> style="background-color:#F00" <? } else if($dias_ok == $dias[$i]  and  $estado_sige==1){ ?> style="background-color:#0C0" <? } ?> readonly onClick="comprueba_asistencia(this.value)" value="<?php  echo isset( $dias[ $i ] ) ? $dias[ $i ] : ''; ?>" >
    
    </td>
    <? }else{ ?>
 	 <td>&nbsp;
   
    </td>	
		
	<?  }?>
    
    <?php endfor; ?>
    </tr>
    <?php endforeach; ?>
</table>

<? }

	if($funcion==2){
		
	
		$mes = ($mes<10)?'0'.$mes:$mes;
		$dia = ($dia<10)?'0'.$dia:$dia;
	$fecha = $nro_ano.'-'.$mes.'-'.$dia;
	/*if(pg_dbname()=="coi_final_vina"){
		
		}else{
		$fecha = $dia.'-'.$mes.'-'.$nro_ano;
		}*/
	
	
	//$fecha = $dia.'-'.$mes.'-'.$nro_ano;
	//$fecha = $dia.'-'.$mes.'-'.'2013';
	
	
//	$fecha ='13-3-2013';
 	 $sql="select * from asistencia_sige where rdb=$_INSTIT and id_ano=$_ANO and id_curso=$curso and fecha='".$fecha."' and estado=1";		
	$result= pg_exec($conn,$sql)or die("fallo ".$sql);
	$codigo_sige= pg_result($result,5);
	$id_asistencia_sige= pg_result($result,0);
	
	
	
	
	echo'<input type="hidden" id="cod_sige" value="'.$codigo_sige.'">'; 
	echo'<input type="hidden" id="id_asistencia_sige" value="'.$id_asistencia_sige.'">'; 
		
	}
	
	if($funcion==3){
	
		
	  $sqla="update asistencia_sige set estado_sige=$codigo_sige where id_asistencia_sige = $id_asistencia_sige";
	  if($_PERFIL==0)echo $sqla;
	$resulta = pg_exec($conn,$sqla)or die("fallo ".$sqla);
	if($resulta){
		echo 1;
		}else{
		echo 0;	
		}
	}


?>