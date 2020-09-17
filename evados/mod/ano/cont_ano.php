<?php session_start();
  require "mod_ano.php";
	
  $obj_ano = new Ano($_IPDB,$_ID_BASE);
	
  $funcion = $_POST['funcion'];
  
  if($funcion==1){
	
	//añops que tengo en evados
	$rs_listado = $obj_ano->traeTodosAnos($_INSTIT);
	?><br>
<br>
<div align="right"><input name="btnn" type="button" value="Cargar A&ntilde;os" class="botonXX" onClick="traeAno()"></div><br>
<br>

    <table width="90%" border="1" align="center" style="border-collapse:collapse">
  <tr class="cuadro02">
    <td colspan="4">A&ntilde;os acad&eacute;micos</td>
    </tr>
  <tr class="cuadro02">
    <td width="8%" align="center">A&ntilde;o</td>
    <td width="37%">Fecha Inicio</td>
    <td width="36%">Fecha t&eacute;rmino</td>
    <td width="19%">Estado</td>
  </tr>
 
	<?
    for($i=0;$i<pg_numrows($rs_listado);$i++){
		$fila_ano = pg_fetch_array($rs_listado,$i);
		
		if($fila_ano['situacion']==1){
			$estado="<img src='img/PNG-48/Delete.png' width='22' height='22' border='0' title='Cerrar A&ntildeo;' onclick='Modifica_Anio(".$fila_ano['id_ano'].",0)'/>";	
		}else{
			$estado="<img src='img/PNG-48/Add.png' width='22' height='22' border='0' title='Abrir A&ntildeo;' onclick='Modifica_Anio(".$fila_ano['id_ano'].",1)'/>";	
		}
	?>
     <tr class="textosimple">
    <td align="center"><?php echo $fila_ano['nro_ano'] ?></td>
    <td><?php echo $fila_ano['fecha_inicio'] ?></td>
    <td><?php echo $fila_ano['fecha_termino'] ?></td>
    <td><?php echo $estado ?></td>
  </tr>


    <?
	}
	?>
    </table>
    <?
	 
 }
 if($funcion==2){
	$rs_ano = $obj_ano->Modifica($ano,$estado,$_INSTIT);
	
	if($rs_ano){
		echo 1;	
		unset ($_ANO);
		unset ($_SESSION['_ANO']);
		session_unregister('_ANO');
		$_SESSION['_ANO'] = $ano;
		session_register('_ANO');
		$_ANO = $ano;
		
	 $sql="SELECT id_periodo FROM evados.eva_periodos_evaluacion WHERE id_anio=".$ano;
	$rs_periodo = pg_exec($obj_ano->Conec->conectar(),$sql) or die("ERROR111");
	$periodo = pg_result($rs_periodo,0);
	$_SESSION['_PERIODO'] = $periodo;
		
	}else{
		echo 0;
	}
}
if($funcion==3){
	$rs_ano = $obj_ano->traeAnoNotengo($_INSTIT);
	
	if(pg_numrows($rs_ano)>0){
	for($i=0;$i<pg_numrows($rs_ano);$i++){
		$fila_ano = pg_fetch_array($rs_ano,$i);
		
		//guardo el año
		$obj_ano->guardaAno($fila_ano['id_ano']);
		
		
		
		$rs_per = $obj_ano->BuscaPeriodo($fila_ano['id_ano']);
		
		
		
		}
	
	}

}
  
 ?>