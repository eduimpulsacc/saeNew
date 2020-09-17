<script language=javascript>

function destino(){

url = document.navegador.calendario.options[document.navegador.calendario.selectedIndex].value

if (url != " no") window.location = url;

}

</script>
<?

//		echo $arreglo[4];
$fondo = "#E6C1AC";
$diaa = "1";

$mes[1] = "Enero"; 
$mes[2] = "Febrero"; 
$mes[3] = "Marzo"; 
$mes[4] = "Abril"; 
$mes[5] = "Mayo"; 
$mes[6] = "Junio"; 
$mes[7] = "Julio"; 
$mes[8] = "Agosto"; 
$mes[9] = "Septiembre"; 
$mes[10] = "Octubre"; 
$mes[11] = "Noviembre"; 
$mes[12] = "Diciembre"; 


//$mess = $_GET['mess'];
//$anio = $_GET['anio'];

if($mess == "" || $anio == ""){
    $anio = date("Y");
    $mess = date("m");
	
}
    $ultimo = date("t",mktime(0, 0, 0, $mess, 1, $anio));
    if($mess == '12' || $mess == '1'){
        if($mess == '12'){
            $next = 1;
            $prev = $mess -1;
            $anion = $anio + 1;
            $aniop = $anio;
        }
        if($mess == '1'){
            $next = $mess + 1;
            $prev = 12;
            $anion = $anio;
            $aniop = $anio -1;        
        }
    }else{
        $next = $mess + 1;
        $prev = $mess - 1;    
        $aniop = $anio;
        $anion = $anio;
    }
	
	$fech1 = date("Y"."-"."m"."-"."01");
	$fech2 = date("Y"."-"."m"."-".$ultimo);

if($institucion!=""){



 $agenda = "select distinct fecha from agenda where rdb = '$institucion' and (fecha >= '$fech1') and ((fecha < '$fech2') or (fecha = '$fech2'))";
 if($_PERFIL==17){
	$agenda.=" AND id_curso=".$_CURSO; 
 }
 if($_PERFIL==16){
	$agenda.=" AND id_curso in (SELECT id_curso FROM matricula WHERE id_ano=".$_ANO." AND rut_alumno=".$_NOMBREUSUARIO." AND bool_ar=0)"; 
	
 }
	$res = pg_Exec($conn,$agenda); 	
	$n_filas = pg_numrows($res);
	for($n=0;$n<$n_filas;$n++)
	{
		$fila = pg_fetch_array($res,$n);
		$arreglo[$n] = $fila['fecha'];

	}
}
//echo $agenda;	
?>

<!----<form name="navegador" method="post" >
<select name="calendario" onchange="destino()">
  <option value="index.php?nomes">Seleccione Mes</option>
  <option value="index.php?mes_actu=1&act=1&diaas=31"<? if ($mes_actu == 1){ ?> selected="selected"<? } ?>>Enero</option>
  <option value="index.php?mes_actu=2&act=1&diaas=28"<? if ($mes_actu == 2){ ?> selected="selected"<? } ?>>Febrero</option>
  <option value="index.php?mes_actu=3&act=1&diaas=31"<? if ($mes_actu == 3){ ?> selected="selected"<? } ?>>Marzo</option>
  <option value="index.php?mes_actu=4&act=1&diaas=30"<? if ($mes_actu == 4){ ?> selected="selected"<? } ?>>Abril</option>
  <option value="index.php?mes_actu=5&act=1&diaas=31"<? if ($mes_actu == 5){ ?> selected="selected"<? } ?>>Mayo</option>
  <option value="index.php?mes_actu=6&act=1&diaas=30"<? if ($mes_actu == 6){ ?> selected="selected"<? } ?>>Junio</option>
  <option value="index.php?mes_actu=7&act=1&diaas=31"<? if ($mes_actu == 7){ ?> selected="selected"<? } ?>>Julio</option>
  <option value="index.php?mes_actu=8&act=1&diaas=31"<? if ($mes_actu == 8){ ?> selected="selected"<? } ?>>Agosto</option>
  <option value="index.php?mes_actu=9&act=1&diaas=30"<? if ($mes_actu == 9){ ?> selected="selected"<? } ?>>Septiembre</option>
  <option value="index.php?mes_actu=10&act=1&diaas=31"<? if ($mes_actu == 10){ ?> selected="selected"<? } ?>>Octubre</option>
  <option value="index.php?mes_actu=11&act=1&diaas=30"<? if ($mes_actu == 11){ ?> selected="selected"<? } ?>>Noviembre</option>
  <option value="index.php?mes_actu=12&act=1&diaas=31"<? if ($mes_actu == 12){ ?> selected="selected"<? } ?>>Diciembre</option>
</select>
</form>
------->
<? 

if  ($act != 1){
$mes_act = intval(date("m"));
}
else 
{ 
$mes_act = $mes_actu;
$mess = $mes_actu; 
	}
	?>
<table width="200" border="1" cellspacing="0" cellpadding="2" class="borde"><tr><td>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr><td class="tableindex" colspan="7"><div align="center"><?=$mes[$mes_act]?> - <?=$anio?></div></td>
	<tr align="center" class="Estilo15">
		<td><div align="center" class="Estilo4">D</div></td>
		<td><div align="center" class="Estilo4">L</div></td>
		<td><div align="center" class="Estilo4">M</div></td>
		<td><div align="center" class="Estilo4">M</div></td>
		<td><div align="center" class="Estilo4">J</div></td>
		<td><div align="center" class="Estilo4">V</div></td>
		<td><div align="center" class="Estilo4">S</div></td>
	</tr>
    <? 

if ($diaas > 0){

$ultimo = $diaas;

}


    while($diaa <= $ultimo){
        $dia_tab = date("D",mktime(0,0,0,$mess,$diaa,$anio));
		$dia = date("d",mktime(0,0,0,$mess,$diaa,$anio)); # retorna el dia de la semana en letras...
        $fecha = date("j",mktime(0,0,0,$mess,$diaa,$anio)); #retorna el dia del mes en 01/31
        $dia_semana = date("w",mktime(0,0,0,$mess,$diaa,$anio)); #retorna el dia de la semana en numero

        if($dia_tab == "Sun"){
            echo "</tr><tr>";
        }
        if($fecha == "1"){
            $i=0;
            while($i != $dia_semana){
                echo "<td>&nbsp;</td>";
                $i++;
            }
        }
		$fecha_comp = $anio."-".$mess."-".$dia;
        if($anio == date("o") && $mes[$mess] == $mes[date("n")] && $fecha == date("j")){

			$esta=false;
			for($t=0;$t<$n_filas;$t++) //realiza 2 ciclos
			{
				$arreglo[$t]."=".$fecha_comp."<br>";
				if($arreglo[$t]==$fecha_comp)
					$esta=true;
			}
			if($esta){	?>
					<td bgcolor="<?=$fondo?>" height="20"><div align="center"><a href="agenda/lista_agenda.php?fecha=<?=$fecha_comp?>"><b><?=$fecha?></b></a></div></td>
<?			}else{		?>
					<td class='calendario' align='center'><b><?=$fecha;?></b></td>
<?			}		
//			for($t=0;$t<$n_filas;$t++)
//			{
//            	$arreglo[$t]==)
				//echo "<td class='calendario' align='center'><b>$fecha</b></td>";
//			}
        }else{
			$esta=false;
			for($t=0;$t<$n_filas;$t++) //realiza 2 ciclos
			{
				$arreglo[$t]."=".$fecha_comp."<br>";
				if($arreglo[$t]==$fecha_comp)
					$esta=true;
			}
			if($esta){	?>
					<td bgcolor="<?=$fondo?>" height="20"><div align="center"><a href="agenda/lista_agenda.php?fecha=<?=$fecha_comp?>"><span class="Estilo3"><?=$fecha?></span></a></div></td>
<?			}else{		?>
					<td align='center' height="20"><span class="Estilo3"><?=$fecha?></span></td>
<?			}			
			
//            echo "<td align='center'>$fecha</td>";
        }
        $diaa++;
    }
?></tr>
</table>
</td>
</tr></table>
