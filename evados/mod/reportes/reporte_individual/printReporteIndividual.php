<? 
session_start();
require "../../../class/Membrete.class.php";
require "../class_reporte/class_sql.php";

$ob_membrete = new Membrete($_IPDB,$_DBNAME);
$ob_membrete->estilosae($_INSTIT);
$fila_inst=$ob_membrete->institucion($_INSTIT);
 $fila_ano = $ob_membrete->anoescolar($_INSTIT);


//print_r($_POST);


 $bloque		= $_POST['cmbGRUPO'];
$pauta		= $_POST['cmbPAUTA'];
$dimension	= $_POST['cmbDIMENSION'];
$funcion	= $_POST['cmbFUNCION'];
$indicador	= $_POST['cmbINDICADOR'];
$tipo_dato	= $_POST['tipo_dato'];
$nacional	= $_NACIONAL;
$ano=$_ANO;


$ob_reporte = new SQL($_IPDB,$_DBNAME);
$rs_evaluado = $ob_reporte->Evaluados($ano,$bloque);
$nombre_evaluado = pg_result($rs_evaluado,2);
$rut_evaluado = pg_result($rs_evaluado,1);
$rut_emp = pg_result($rs_evaluado,3);
$rs_pauta = $ob_reporte->PautaEvaluacion($pauta);
$nombre_pauta = pg_result($rs_pauta,3);
$rs_dimension = $ob_reporte->Dimension($dimension);
$nombre_dimension = pg_result($rs_dimension,2);
$rs_funcion = $ob_reporte->Funcion($funcion);
$nombre_funcion = pg_result($rs_funcion,1);
$rs_indicador = $ob_reporte->Indicador($indicador);
$nombre_indicador = pg_result($rs_indicador,1);
$rs_concepto = $ob_reporte->Conceptos($nacional);
$rs_personal = $ob_reporte->PersonalBloque($bloque);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SISTEMA EVALUACI&Oacute;N DOCENTES</title>
</head>

<body>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="right">
      <input type="submit" name="Submit" value="IMPRIMIR"  class="botonXX"/>
      <input type="submit" name="Submit2" value="CERRAR" class="botonXX" onclick="window.close()"/>
    </div></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>

    <td width="114" class="textonegrita"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
    <td width="9" class="textonegrita"><strong>:</strong></td>
    <td width="361" class="textonegrita"><div align="left"><? echo strtoupper(trim($fila_inst['nombre_instit'])) ?></div></td>
    <td width="161" rowspan="9" align="center" valign="top" ><img src="../../../../cortes/<?=$_INSTIT?>/insignia.jpg" width="100" height="100" /></td>
  </tr>
  <tr>
    <td class="textonegrita"><div align="left"><strong>A&Ntilde;O ESCOLAR</strong></div></td>
    <td class="textonegrita"><strong>:</strong></td>
    <td class="textonegrita"><div align="left"><? echo trim($fila_ano['nro_ano']) ?></div></td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;</td>
    <td class="textonegrita">&nbsp;</td>
    <td class="textonegrita">&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;</td>
    <td class="textonegrita">&nbsp;</td>
    <td class="textonegrita">&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="cuadro02"><div align="center">REPORTE EVALUADO </div></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td width="149" class="textonegrita">Evaluado </td>
    <td width="24" class="textonegrita"><div align="center">:</div></td>
    <td width="463" class="textosimple">&nbsp;<?=$nombre_evaluado;?></td>
  </tr>
  <tr>
    <td width="149" class="textonegrita">Rut  </td>
    <td width="24" class="textonegrita"><div align="center">:</div></td>
    <td width="463" class="textosimple">&nbsp;<?=$rut_evaluado;?></td>
  </tr>
  <tr>
    <td class="textonegrita">Pauta de Evaluaci&oacute;n </td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<?=$nombre_pauta;?></td>
  </tr>
  <tr>
    <td class="textonegrita">Dimenci&oacute;n</td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<?=$nombre_dimension;?></td>
  </tr>
  <tr>
    <td class="textonegrita">Funci&oacute;n</td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<?=$nombre_funcion;?></td>
  </tr>
  <tr>
    <td class="textonegrita">Indicador</td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<?=$nombre_indicador;?></td>
  </tr>
  <tr>
    <td class="textonegrita">Datos</td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<? echo ($tipo==1)?"Ponderados":"Sin Ponderar";?></td>
  </tr>
  <tr>
    <td class="textonegrita">Datos</td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<? echo ($tipo==1)?"Ponderados":"Sin Ponderar";?></td>
  </tr>
</table>
<br />

<table width="800" border="1" align="center" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
 <tr>
    <td width="164" class="tablatit3">&nbsp;</td>
   	<? for($i=0;$i<pg_numrows($rs_concepto);$i++){
			$fila_con = pg_fetch_array($rs_concepto,$i);
	?>
    <td width="36" class="tablatit3"><div align="center"><?=$fila_con['sigla'];?></div></td>
<? }  // for conceptos 	?>

    <td width="36" class="tablatit3"><div align="center">Total</div></td>

  </tr>
  <? 
    
	$fe_con = array();
	
	for( $i3 = 0 ; $i3<pg_numrows($rs_concepto) ; $i3++ ) {
	
	        $fila_con = pg_fetch_array($rs_concepto,$i3);
            $fe_con[$fila_con['sigla']] = $fila_con['id_concepto'];
    
	       } 
	
	//print_r($fe_con);
	//var_export($fe_con);


	//Enviar todos los parametros para filtrar las Querys

	$rs_ = $ob_reporte->datoscompilados($_POST['cmbANO'],$nacional,$_POST['cmbCORP'],$_POST['cmbINST'],$_POST['cmbCARGO'],$_POST['cmbGRUPO'],$_POST['cmbPAUTA'], 
$_POST['cmbDIMENSION'],$_POST['cmbFUNCION'],$_POST['cmbINDICADOR']); 
	
	$bloque_ciclo = 0;
	$estado_ponderado = 0;
	$s=0;
  
    
   for( $x = 0 ; $x<pg_numrows($rs_); $x++ ){
  	
	$fila_ = pg_fetch_array($rs_,$x);
   					
	$bloque_ciclo  =  $fila_['id_bloque'];
					
		echo '<tr>';
		echo '<td>';
		echo trim($fila_['nombre']);
		echo '</td>';
			   
			$f2=0;		
			$cont=0;
			$sumaresultados=0;
			   
		    for( $xw = $x; $xw <= pg_numrows( $rs_ ); $xw++ ){
										
				 
				   $fila_1 = pg_fetch_array($rs_,$xw);
				   
				   	if( $bloque_ciclo != $fila_1['id_bloque'] ){

					$x = $xw-1;
					break;						
					} 
				   
				   // CONSULTA
    			   $rs_2 = $ob_reporte->gruposdebloques($_POST['cmbPAUTA']);
										
					for($x1=0;$x1<pg_numrows($rs_2);$x1++){
							$fila_2  =  pg_fetch_array($rs_2,$x1);
						    $e .= $fila_2['id_bloque']."-";
						  }
	                  
					  if(pg_numrows($rs_2)==1){
						  $e .= "0-0-0-0";
					  }elseif(pg_numrows($rs_2)==2){
					  	  $e .= "0-0-0";
					  }elseif(pg_numrows($rs_2)==3){
					  	  $e .= "0-0";
					  }elseif(pg_numrows($rs_2)==4){
					  	  $e .= "0";
					  }
					  					  
					  // Enviar numero ano si no se toma todo los anos ??
					  $rs_3 = $ob_reporte->grupoporcentajes($e,$_POST['cmbANO']); 
					  					  
					  $fila_3  =  pg_fetch_array($rs_3,0);
					  	
					  if($fila_1['id_bloque'] == $fila_3['bloque1'] ){
						$porc_ponde = $fila_3['porcentaje1'];
					  }elseif( $fila_1['id_bloque'] == $fila_3['bloque2'] ){
						$porc_ponde = $fila_3['porcentaje2'];
					  }elseif( $fila_1['id_bloque'] == $fila_3['bloque3'] ){
						$porc_ponde = $fila_3['porcentaje3'];  
					  }elseif( $fila_1['id_bloque'] == $fila_3['bloque4'] ){
						$porc_ponde = $fila_3['porcentaje4'];	  
					  }elseif( $fila_1['id_bloque'] == $fila_3['bloque5'] ){
						$porc_ponde = $fila_3['porcentaje5'];		  
					  }

                   
                  /*Se Envia Bloque para obtener
				  el array de conceptos que interactuan en las respuestas del bloque*/
				   
				   $array_misconceptos = array();
				   
				   $rs_x2_conceptos_bloque = $ob_reporte->arrays_conceptos(
				   $_POST['cmbANO'],$nacional,$_POST['cmbCORP'],
				   $_POST['cmbINST'],$_POST['cmbCARGO'],
				   $_POST['cmbGRUPO'],$_POST['cmbPAUTA'], 
				   $_POST['cmbDIMENSION'],$_POST['cmbFUNCION'],
				   $_POST['cmbINDICADOR'],$fila_1['id_bloque']); 

                   for( $i33 = 0 ; $i33<=pg_numrows($rs_x2_conceptos_bloque) ; $i33++ ) {
				       $fila_x2_con = pg_fetch_array($rs_x2_conceptos_bloque,$i33);
					   $array_misconceptos[$fila_x2_con['sigla']] = $fila_x2_con['id_concepto'];
					  }               
						
				   $array_result = array_diff($fe_con,$array_misconceptos);
				
				   $salida = "";
				   
					for( $i34=$f2;  $i34 < pg_num_rows($rs_concepto); $i34++ ){
					            	
					    $fila_con = pg_fetch_array($rs_concepto,$i34);
						
					
					if ($fila_1['id_concepto']  != $fila_con['id_concepto']) {
									
					
						$salida .= "<td  align='center' >&nbsp;</td>";
									
					
						}else{
							  
					$cont++;
			
			
					 // RESULTADO FINAL SIN Y CON PONDERACION						
					 if( $tipo_dato == 2 ){
					 	 
					  $salida .= "<td  align='center' >".$fila_1['result_cantidad_respuestas']."</td>"; 
					 
					 }elseif( $tipo_dato == 1 ){
					  
					  $totalponderado = ( $fila_1['result_cantidad_respuestas']*($porc_ponde/100) );
					  	
					  $salida .= "<td align='center' >".( $fila_1['result_cantidad_respuestas']*($porc_ponde/100) )."</td>";
					  
					  $sumaresultados = $sumaresultados + $totalponderado;
					  
					  //Tuve que dejar esta chanchada no tube otra laternativa ;)
					  if($fila_1['sigla']=='D') $d = ( $d + $totalponderado ) ;
					  if($fila_1['sigla']=='C') $c = ( $c + $totalponderado ) ;
					  if($fila_1['sigla']=='B') $b = ( $b + $totalponderado ) ;
					  if($fila_1['sigla']=='I') $i = ( $i + $totalponderado ) ;
					  if($fila_1['sigla']=='NO') $no = ( $no + $totalponderado ) ;
					  					  
					  			  
					 }
			 						
				$f2 = $i34+1;
				break;
									
				}
			
			
			} // FIN DE FOR
						   	
          	if( ( $i34 === 3 ) && ( pg_numrows($rs_x2_conceptos_bloque) != 5 )  ){
		        $cont++;
			 	$salida .= "<td align='center' >&nbsp;</td>"; 
			   }

			if( $cont === 5 ){
					
			       $results_total_x_bloque = $ob_reporte->total_xbloque(
			       $_POST['cmbANO'],$nacional,$_POST['cmbCORP'],
				   $_POST['cmbINST'],$_POST['cmbCARGO'],
				   $_POST['cmbGRUPO'],$_POST['cmbPAUTA'], 
				   $_POST['cmbDIMENSION'],$_POST['cmbFUNCION'],
				   $_POST['cmbINDICADOR'],$fila_1['id_bloque']);
			
			    $total_xbloque = pg_result($results_total_x_bloque,3);
			
				if( $tipo_dato == 2 ){ // RESULTADO FINAL SIN Y CON PONDERACION
				 
				 $salida .= "<td  align='center' >$total_xbloque</td>"; 
				
				}elseif( $tipo_dato == 1 ){
				 	
				 $salida .= "<td align='center' >".$sumaresultados."</td>";
				 
				 $total_final_ponderado_alamala = ($total_final_ponderado_alamala + $sumaresultados); 
			    
				}	
				
			}
				
		   echo  $salida;

		 }
  
 
   }  // totales interiores 
   
   
   echo "</tr>";
   
   // resultado final...
   
   echo '<tr class="tablatit3"><td><div align="center" >Total</div></td>';
	
   // CONSULTA	
   if($tipo_dato==2){ // RESULTADO FINAL SIN Y CON PONDERACION	
   
   $results_ = $ob_reporte->resultados_totales_xconceptos_mas_porcentajes( 
                 $_POST['cmbANO'],$nacional,$_POST['cmbCORP'],
				 $_POST['cmbINST'],$_POST['cmbCARGO'],
				 $_POST['cmbGRUPO'],$_POST['cmbPAUTA'], 
				 $_POST['cmbDIMENSION'],$_POST['cmbFUNCION'],
				 $_POST['cmbINDICADOR'] );
  
	   for ($itx=0; $itx < pg_num_rows($results_) ; $itx++) { 
	    $fila_ = pg_fetch_array($results_,$itx);
		echo '<td class="tablatit3"><div align="center" >'.$fila_['total_xconcepto'].'</div></td>';
	   }

  }elseif( $tipo_dato == 1 ){

   echo "<td><div align='center' >".$d."</div></td>";
   echo "<td><div align='center' >".$c."</div></td>";
   echo "<td><div align='center' >".$b."</div></td>";
   echo "<td><div align='center' >".$i."</div></td>";
   echo "<td><div align='center' >".$no."</div></td>";
   	
  }
   

   // CONSULTA
  // RESULTADO FINAL SIN Y CON PONDERACION	
   $results_ = $ob_reporte->total_respuestas(
                   $_POST['cmbANO'],$nacional,$_POST['cmbCORP'],
				   $_POST['cmbINST'],$_POST['cmbCARGO'],
				   $_POST['cmbGRUPO'],$_POST['cmbPAUTA'], 
				   $_POST['cmbDIMENSION'],$_POST['cmbFUNCION'],
				   $_POST['cmbINDICADOR'] );
   
   $total_respuestas_totales = pg_result($results_,0);
   
	   if($tipo_dato==2){    
		    echo '<td><div align="center" >'.$total_respuestas_totales .'</div></td>';
	   }elseif( $tipo_dato == 1 ){
			echo "<td><div align='center' >".$total_final_ponderado_alamala."</div></td>";
	   }
   
   echo '</tr>';
   echo '<tr class="tablatit3" ><td><div align="center" >Total %</div></td>';
   
   // CONSULTA	
   // RESULTADO FINAL SIN Y CON PONDERACION	
   if($tipo_dato==2){ 
   
   $results_ = $ob_reporte->resultados_totales_xconceptos_mas_porcentajes( 
                $_POST['cmbANO'],$nacional,$_POST['cmbCORP'],
				$_POST['cmbINST'],$_POST['cmbCARGO'],
				$_POST['cmbGRUPO'],$_POST['cmbPAUTA'], 
				$_POST['cmbDIMENSION'],$_POST['cmbFUNCION'],
				$_POST['cmbINDICADOR'] );
  
   for($i=0; $i < pg_num_rows($results_) ; $i++){ 
   	$fila_ = pg_fetch_array($results_,$i);
	echo '<td class="tablatit3"><div align="center" >'.$fila_['total_en_porcentaje'].'</div></td>';
	 }
  
   }elseif( $tipo_dato == 1 ){
	   	
	echo "<td><div align='center' >".round((($d*100)/$total_final_ponderado_alamala),2)."</div></td>";
    echo "<td><div align='center' >".round((($c*100)/$total_final_ponderado_alamala),2)."</div></td>";
    echo "<td><div align='center' >".round((($b*100)/$total_final_ponderado_alamala),2)."</div></td>";
    echo "<td><div align='center' >".round((($i*100)/$total_final_ponderado_alamala),2)."</div></td>";
    echo "<td><div align='center' >".round((($no*100)/$total_final_ponderado_alamala),2)."</div></td>";
   
   }
   
   echo '</tr>';
   
   ?>
   
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
  
    <td class="textosimple"><div align="right"><?
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
     $fechaEspanoll = strftime("%A %d de %B del %Y");
	 echo $fechaEspanoll;?></div></td>
	 
  </tr>
</table>
</body>
</html>
