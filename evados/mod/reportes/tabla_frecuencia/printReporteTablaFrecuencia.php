<? 
session_start();
require "../../../class/Membrete.class.php";
require "../class_reporte/class_sql.php";

//print_r($_POST);

$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
$ob_membrete->estilosae($_INSTIT);
$fila_inst=$ob_membrete->institucion($_INSTIT);
$fila_ano = $ob_membrete->anoescolar($_INSTIT);

$bloque		= $_POST['cmbCARGO'];
$corporacion		= $_POST['cmbCORP'];
$instirucion	= $_POST['cmbINST'];
$nacional	= $_NACIONAL;
$ano=$_POST['cmbANO'];

$ob_reporte = new SQL($_IPDB,$_ID_BASE);
$rs_ = $ob_reporte->tabladefrecuencia($nacional,$ano,$corporacion,$instirucion,$bloque);
$nom_Copr = pg_result($rs_,2);
$nom_pauta = pg_result($rs_,5);

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
    <td width="149" class="textonegrita">Corporaci&oacute;n </td>
    <td width="24" class="textonegrita"><div align="center">:</div></td>
    <td width="463" class="textosimple">&nbsp;<?=strtoupper(trim($nom_Copr));?></td>
  </tr>
  <tr>
    <td width="149" class="textonegrita">Instituci&oacute;n  </td>
    <td width="24" class="textonegrita"><div align="center">:</div></td>
    <td width="463" class="textosimple">&nbsp;<? echo strtoupper(trim($fila_inst['nombre_instit'])) ?></td>
  </tr>
  <tr>
    <td class="textonegrita">Pauta </td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<?=strtoupper($nom_pauta);?></td>
  </tr>
  
  <tr>
    <td class="textonegrita">Datos</td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<? echo ($tipo==1)?"PONDERADOS":"SIN PONDERAR";?></td>
  </tr>
</table>
<br />

<table  align="center" border="1" >
	<tr>
		<td>Corporacion</td>
		<td>Institucion</td>
		<td>Pauta</td>
		<td>Rut Evaluado</td>
		<td>Nombre Funcionario</td>
		<td>Resultado</td>
		<td>Concepto</td>
	</tr>	

<?


$rs_ = $ob_reporte->tabladefrecuencia($nacional,$ano,$corporacion,$instirucion,$bloque);

   for($x=0;$x<pg_numrows($rs_);$x++){
  	
    	$fila_ = pg_fetch_array($rs_,$x);
	
		$rut_emp_2 = $fila_['rut_emp'];
						
		$fila_['num_corp'];
		$fila_['id_plantilla'];
		$fila_['nombre_corporacion'];
		$fila_['rdb'];
		$fila_['nombre_institucion'];
		$fila_['nombre_pauta'];
		$fila_['rut_emp'];
		$fila_['nombre_emp'];
		$fila_['ape_pat'];
		$fila_['ape_mat'];
		$fila_['id_cargo_evaluado'];
		$fila_['sigla'];
		$fila_['resultado'];
	
	  echo "<tr>
			<td>".$fila_['nombre_corporacion']."</td>
			<td>".$fila_['nombre_institucion']."</td>
			<td>".$fila_['nombre_pauta']."</td>
			<td>".$fila_['rut_emp']."</td>
			<td>".$fila_['ape_pat']." ".$fila_['ape_mat']." ".$fila_['nombre_emp']."</td>";
			
		 $final = 0;
		 		 
		 for( $xw = $x; $xw <= pg_numrows( $rs_ ); $xw++ ){
										
		   $e = "";
			 		 
		   $fila_1 = pg_fetch_array($rs_,$xw);
				   
		  	if( $rut_emp_2 != $fila_1['rut_emp'] ){

				$x = $xw-1;
				break;						
			 } 
		

		  // CONSULTA
    	 /* $rs_2 = $ob_reporte->gruposdebloques($fila_1['id_plantilla']);
										
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
			} */
					  
		 // Enviar numero ano si no se toma todo los anos ??
		 
		 /*$rs_3 = $ob_reporte->grupoporcentajes($e,$ano); 
					  					  
		   $fila_3  =  pg_fetch_array($rs_3,0);
					  	
		   if($fila_1['id_bloque'] == $fila_3['bloque1']){
			  $porc_ponde = $fila_3['porcentaje1'];
		   }elseif($fila_1['id_bloque'] == $fila_3['bloque2']){
			  $porc_ponde = $fila_3['porcentaje2'];
		   }elseif($fila_1['id_bloque'] == $fila_3['bloque3']){
			  $porc_ponde = $fila_3['porcentaje3'];  
		   }elseif($fila_1['id_bloque'] == $fila_3['bloque4']){
			  $porc_ponde = $fila_3['porcentaje4'];	  
		   }elseif($fila_1['id_bloque'] == $fila_3['bloque5']){
			  $porc_ponde = $fila_3['porcentaje5'];		  
		   } */
		  
	 $rs_2 = $ob_reporte->resultado_general_individual($nacional,$ano,$corporacion,$instirucion,$bloque,$fila_1['rut_emp']);
	$fila_total = pg_fetch_array($rs_2,0);
	$fila_total['total_general'];

     
		
	 //$totalponderado = ($fila_1['resultado']/100) * $fila_total['total_general'];
		   
	 //echo "<td>".($fila_1['resultado']/100)."*".$fila_total['total_general']."==".$totalponderado."</td>";
		   
	 $final = ( $final + $fila_1['resultado'] );
			 						
   }
		

/*DESTACADO (D)
El desempeño del profesional es consistente con lo que se espera, de acuerdo al criterio evaluado
90 -100*/

/*COMPETENTE ©
El desempeño profesional es adecuado, de acuerdo al criterio evaluado
75 -89*/

/*BÁSICO (B)
El desempeño del profesional presenta ciertas debilidades susceptibles de mejorar
60 – 74*/

/*INSATISFACTORIO (I)
Indica un desempeño profesional que presenta claras debilidades en el criterio evaluado y éstas afectan significativamente el quehacer profesional
 Menos de 60*/

  $result = round( (($final*100)/$fila_total['total_general']),1);
  
  //echo "<td>".$result. "</td>";
 
   if( $result >=90 && $result <= 100 ){
		 echo "<td>".$result."%</td>";
		 echo "<td>DESTACADO</td>";		
       }	
	
	if( $result >=75 && $result <= 89 ){
		 echo "<td>".$result."%</td>";
		 echo "<td>COMPETENTE</td>";		
       }	
	
	if( $result >= 60 && $result <= 75 ){
		 echo "<td>".$result."%</td>";
		 echo "<td>BASICO</td>";		
       }	
	
	if( $result <= 59 ){
		 echo "<td>".$result."%</td>";
		 echo "<td>INSATISFACTORIO</td>";		
       }
 			 
	 echo "</tr>";
   
   } // fin for

?>

</table>


<br />
<table width="650" border="0" align="center">
  <tr>
  
    <td class="textosimple"><div align="right"><?
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
     $fechaEspanol = strftime("%A %d de %B del %Y");
	 echo $fechaEspanol;?></div></td>
	 
  </tr>
</table>
</body>
</html>
