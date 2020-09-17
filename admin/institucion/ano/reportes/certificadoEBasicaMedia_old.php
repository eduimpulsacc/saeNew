<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?php require('../../../../util/header.inc');?>
<?php 
setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$c_alumno;
	
	$sqlEns="select ensenanza from curso where id_curso =".$c_curso;
	$resEns=@pg_exec($conn, $sqlEns);
	$ensenanza=@pg_fetch_array($resEns,0);
	
	$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, (empleado.nombre_emp || ' ' || empleado.ape_pat ||' ' || empleado.ape_mat) as nombre, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultDIR =@pg_Exec($conn,$qryDIR);
	$filaDIR=@pg_fetch_array($resultDIR);	
	
	$sqlAlu="select (trim(nombre_alu) || ' ' || trim(ape_pat) || ' ' || trim(ape_mat)) as nombre from alumno where rut_alumno=".$alumno;
	$resAlu=@pg_exec($conn, $sqlAlu);
	$nombreAlu=@pg_fetch_array($resAlu);
	
	$sqlAno="select nro_ano from ano_escolar where id_ano=".$_ANO;
	$resAno=@pg_exec($conn, $sqlAno);
	$ano=@pg_fetch_array($resAno,0);
	
	$sqlInsit="SELECT nombre_instit, region, ciudad, comuna, nu_resolucion, fecha_resolucion FROM institucion WHERE rdb=".$_INSTIT;
	$resInstit=@pg_exec($conn, $sqlInsit);
	$filaInstit=@pg_fetch_array($resInstit,0);
	
	$sqlReg="select nom_reg from region where cod_reg=".$filaInstit['region'];
	$resReg=@pg_exec($conn, $sqlReg);
	$region=@pg_fetch_array($resReg,0);
	
	$sqlPro="select nom_pro from provincia where cod_reg=".$filaInstit['region']." and cor_pro=".$filaInstit['ciudad'];
	$resPro=@pg_exec($conn, $sqlPro);
	$ciudad=@pg_fetch_array($resPro,0);	
	
	$sqlCom="select nom_com from comuna where cod_reg=".$filaInstit['region']." and cor_pro=".$filaInstit['ciudad']." and cor_com=".$filaInstit['comuna'];
	$resCom=@pg_exec($conn, $sqlCom);
	$comuna=@pg_fetch_array($resCom,0);	
	
 ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%"  border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><div id="capa0">
		<div align="right">
          <input name="button3" type="button" class="botonX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
        </div>
      </div></td>
  </tr>
</table>

<table width="100%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>

		<tr> 
          <td colspan="4"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>REPUBLICA 
              DE CHILE</strong></font></div></td>
          <td width="198" rowspan="6" align="center"><img  src="escudo.jpg" width="120" height="80"></td>
          <td width="69"> <div align="left"></div></td>
          <td width="143"><div align="left"></div>
            <font size="1" face="Arial, Helvetica, sans-serif">REGION</font></td>
          <td width="198"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $region['nom_reg']?></font></div></td>
        </tr>
        <tr> 
          <td colspan="4"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">MINISTERIO 
              DE EDUCACION</font></div></td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">PROVINCIA</font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $ciudad['nom_pro']?></font></div></td>
        </tr>
        <tr> 
          <td colspan="4"><div align="center"><font face="Arial, Helvetica, sans-serif"><font size="1">DIVISION 
              DE EDUCACION GENERAL</font></font></div></td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">COMUNA</font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $comuna['nom_com']?></font></div></td>
        </tr>
        <tr> 
          <td colspan="4"><div align="center"><font face="Arial, Helvetica, sans-serif"><font size="1">SECRETARIA 
              REGIONAL MINISTERIAL DE EDUCACION</font></font></div></td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">ROL BASE DE DATOS</font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo number_format($_INSTIT,0,'','.');?></font></div></td>
        </tr>
        <tr> 
          <td colspan="4" rowspan="3">&nbsp;</td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">A&Ntilde;O ESCOLAR 
            </font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?PHP echo  number_format($ano['nro_ano'],0,'','.')?></font></div></td>
        </tr>
        <tr> 
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">Decreto Cooperador 
            de la Funci&oacute;n</font></td>
          <td><div align="left"></div></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">Educacional del 
            Estado</font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $filaInstit['nu_resolucion']." "; impF($filaInstit['fecha_resolucion']); ?></font></div></td>
        </tr>
        <tr> 
          <td width="235">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="6%">&nbsp;</td>
          <td width="12%">
		  <?php $result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		$arr[rdb];
		if 	(!empty($fila_foto['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);
			if ($arr['insignia']!="Null"){?>
			<img src=../../../../../../tmp/<? echo $institucion ?> ALT="INSIGNIA"  width="80">
			<? }
			} ?></td>
          <td width="62%"><div align="center"><strong><font size="5" face="Arial, Helvetica, sans-serif">CERTIFICADO 
              DE ENSE&Ntilde;ANZA <?php if ($ensenanza['ensenanza']>110){ 
			  							echo "MEDIA"; 
										}
					if (($ensenanza['ensenanza']<=110) and ($ensenanza['ensenanza']!="") and ($ensenanza['ensenanza']!=10)){
						 echo "BASICA";
				   }
				   if(($ensenanza['ensenanza']==10)){
						 echo "PRE BASICA";
				   }
					?></font></strong></div></td>
          <td width="20%">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="25%"></td>
          <td width="59%" rowspan="3"><p>&nbsp;</p>
            <p><font size="4" face="Arial, Helvetica, sans-serif">Establecimiento 
              : <strong><?php echo $filaInstit['nombre_instit']?></strong></font></p>
            <p><font size="4" face="Arial, Helvetica, sans-serif">CERTIFICO que 
              don(a) : <strong><?php echo $nombreAlu['nombre']?></strong></font></p>
			  <?php if ($ensenanza['ensenanza']>110){ 
			  			$educacion="Media"; 
					}
					if(($ensenanza['ensenanza']<=110) and ($ensenanza['ensenanza']!="") and ($ensenanza['ensenanza']!=10)){
						 $educacion="General B&aacute;sica y";
				   }
				   	if(($ensenanza['ensenanza']==10)){
						 $educacion="Pre Básica";
				   }
										  ?>
            <pre align="justify"><font size="4" face="Arial, Helvetica, sans-serif">ha aprobado todos los cursos correspondiente a la Educaci&oacute;n <?php echo $educacion?>
			

por lo tanto, ha dado cumplimiento a la obligatoriedad escolar dispuesta 

en el art&iacute;culo 19, N&ordm; 10 de la Constituci&oacute;n Pol&iacute;tica de la Rep&uacute;blica de Chile</font></pre></td>
          <td width="16%">&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
<!--        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
         <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
 -->        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td width="61%">&nbsp;</td>
          <td width="19%">__________________________________</td>
          <td width="20%">&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">
		  <?php 
		  	if($institucion == 24511){
				echo "MEZA GOTOR MARCELO";
			}
			else{
				echo $filaDIR['nombre'];
			}
		  ?></font></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Director(a)</font></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo ucwords(strtolower($comuna['nom_com'])).", ".strftime("%d",time())." de ".ucwords(strftime("%B",time()))." de ".strftime("%Y",time())?> 
		  </font></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>