<? include"../../Coneccion/conexion.php";?>
<html>
<head>
<title>Untitled Document</title>
<link rel="stylesheet" href="../../css/objeto.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script>
	function envia(form){
			if (form.cmb_usuario.value!=0){
				form.cmb_usuario.target="self";
				form.action = 'resumen_docum_caja.php';
				form.submit(true);
			}	
				
	}
	
function imprimir(){
	document.getElementById("capa0").style.display='none';
	document.getElementById("capa1").style.display='none';
	document.getElementById("capa2").style.display='block';
	document.getElementById("capa3").style.display='block';	
	window.print();
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
	document.getElementById("capa2").style.display='none';
	document.getElementById("capa3").style.display='none';	
}
	
</script>

</head>
<?


//-------BUSQUEDA DE INSTITUCION-----
	$sql_instit= "Select rdb, nombre_instit From institucion Where rdb = $_INSTIT ;";
	$resultado_query_instit = @pg_exec($conexion,$sql_instit);

//------SI YA SELECCIONO USUARIO  TRAE COMPROBANTES POR FRECHA Y USUARIO----- CDC=con_documenta_comprobante // CDD= con_documenta_doc  ----
	if($fecha_buscar!=""){
		/*$sql_comp = "select distinct cdc.id_comprobante_doc, cdc.id_usuario, cdc.fecha, cdc.id_cuenta, cdd.id_tipo_documento, sum(cdd.monto) as monto, count(cdd.id_tipo_documento)" . " ";
		$sql_comp = $sql_comp . "from con_documenta_comprobante as cdc inner join con_documenta_doc as cdd on cdc.id_comprobante_doc = cdd.id_comprobante_doc" . " ";
		$sql_comp = $sql_comp . "where cdc.id_usuario = ". $_USUARIO." and cdc.fecha = to_date('".$fecha_buscar."', 'MM DD YYYY')" . " ";
		echo $sql_comp = $sql_comp . "group by cdc.id_comprobante_doc, cdc.id_usuario, cdc.fecha, cdd.id_tipo_documento, cdc.id_cuenta";*/
		//$sql_comp = "select id_comprobante_doc, id_cuenta, monto from con_documenta_comprobante where id_usuario= $cmb_usuario and fecha= to_date('".$fecha_buscar."', 'MM DD YYYY')";
	if($_PERFIL!=5){
		$sql_comp = "select distinct cdd.id_cuenta, cdd.id_comprobante_doc, cdc.nro_comprobante from con_documenta_comprobante as cdc inner join con_documenta_doc as cdd on  cdc.id_comprobante_doc=cdd.id_comprobante_doc and cdc.fecha=to_date('".$fecha_buscar."', 'MM DD YYYY') and id_usuario= ".$cmb_usuario."  order by cdd.id_comprobante_doc";
	}else{
		$sql_comp = "select distinct cdd.id_cuenta, cdd.id_comprobante_doc, cdc.nro_comprobante from con_documenta_comprobante as cdc inner join con_documenta_doc as cdd on  cdc.id_comprobante_doc=cdd.id_comprobante_doc and cdc.fecha=to_date('".$fecha_buscar."', 'MM DD YYYY') and id_usuario= ".$_USUARIO."  order by cdd.id_comprobante_doc";
	}
		$result_comp = pg_exec($conexion, $sql_comp);
		}

//--------TRAE USUARIOS QUE HACEN CAJA-------

	//$sql_user = "SELECT * FROM empleado WHERE rut_empleado='$_USUARIO'";
	if($_PERFIL!=5){
		$sql_users = "select empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.rut_emp, empleado.id_usuario from empleado inner join accede on empleado.id_usuario = accede.id_usuario";
		 $sql_users = $sql_users . " where accede.id_perfil=5 and empleado.rut_emp in (select empleado.rut_emp from empleado inner join trabaja on empleado.rut_emp=trabaja.rut_emp where accede.rdb=$_INSTIT) ";
	}else{
		$sql_users = "select empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.rut_emp, empleado.id_usuario from empleado inner join accede on empleado.id_usuario = accede.id_usuario";
		$sql_users = $sql_users . " where accede.id_perfil=5 and empleado.rut_emp in (select empleado.rut_emp from empleado inner join trabaja on empleado.rut_emp=trabaja.rut_emp where accede.rdb=$_INSTIT and empleado.id_usuario=$_USUARIO) ";
	}
	$result_users = pg_exec($conexion, $sql_users);
?>
<body>
<form action="" method="post">
 <table width="650" border="1" align="center" cellspacing="0" cellpadding="0">
 <tr> 
      <td width="96" class="linea_datos_02">INSTITUCI&Oacute;N</td>
      <td width="405" class="linea_datos_02" align="center"> <? print Trim(@pg_result($resultado_query_instit, 0, 1));?></td>
      <td width="141" class="linea_datos_02">
	  <div align="right" id="capa3" style="display:none">
          <table width="50%" border="0" align="right">
            <tr> 
      <td width="50%">
	  	<?
		$result = @pg_exec($conexion,"select * from institucion where rdb=".$_INSTIT);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conexion,$output);?>
		<table width="125" border="0" cellpadding="0" cellspacing="0" align="right">
          <tr>
            <td width="125" align="center">

							<img src=../../../../../../tmp/<? echo trim($_INSTIT)."insignia" ?> ALT="NO DISPONIBLE"  width=80 ></td>
			 </tr>
             </table>
			<? } ?>

	  &nbsp;</td>
    </tr>
  </table>
  </div>
&nbsp;</td>
    </tr>
 </table>
 <br>
  <table width="650" border="1" align="center" cellspacing="0" cellpadding="0">
    
	<tr> 
      <td colspan="3" class="linea_datos_02"><div align="center">Resumen de Documentaci&oacute;n<? echo (@pg_result($resultado_query_cue, 0, 2));?></div></td>
    </tr>
    
  </table>
<br>
  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="73" class="linea_datos_02">Fecha</td>
      <td class="linea_datos_02"><input name="fecha_buscar" type="text" value="<? echo trim($fecha_buscar)?>" size="10" class="text_9_x_100">
        dd-mm-aaaa</td>
      <? if($_PERFIL==5){ ?>
	  	<td class="linea_datos_02"><div id="capa1" class="linea_datos_02"><input type="submit" name="Submit" value="Traer" class="cb_none_9_x_100"></div></td>
	  <? }else{?>
	  	<td class="linea_datos_02"><div id="capa1"></div></td>
		<? }?>
	  
    </tr>
    <tr> 
      <td class="linea_datos_02">usuario</td>
      <td width="301" class="membrete_datos"> 
        <? if($_PERFIL!=5){?>
        <select name="cmb_usuario" class="ddlb_9_x_250" onChange="envia(this.form)">
          <option value="0">Seleccione Usuario</option>
          <? 
		  	for($count=0 ; $count<@pg_numrows($result_users) ; $count++){
				$fila_user = @pg_fetch_array($result_users, $count);
					if(trim($cmb_usuario) == trim($fila_user['id_usuario'])){
						echo "<option value=\" ".trim($fila_user['id_usuario'])." \" selected>".trim($fila_user['nombre_emp'])."  ".trim($fila_user['ape_pat'])."  ".trim($fila_user['ape_mat'])."</option>";
					}else{
						echo "<option value=\" ".trim($fila_user['id_usuario'])." \">".trim($fila_user['nombre_emp'])."  ".trim($fila_user['ape_pat'])."  ".trim($fila_user['ape_mat'])."</option>";
					}
			}
		  ?>
        </select>
        <? }else{ 
			$fila_user = @pg_fetch_array($result_users, 0);
			echo trim($fila_user['nombre_emp'])."  ".trim($fila_user['ape_pat'])."  ".trim($fila_user['ape_mat']);
			
			?>
        <input type="hidden" name="cmb_usuario" value="<? echo trim($fila_user['id_usuario'])?>"></td>
		<? }?>
      <td width="268" class="linea_datos_02">&nbsp;</td>
    </tr>
  </table>
<br>
  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td colspan="6" class="linea_datos_02"><div align="center">TOTAL DOCUMENTADO 
          EN CAJA</div></td>
    </tr>
    <tr> 
      <td width="105" class="linea_datos_05">cuenta</td>
      <td width="94" class="linea_datos_05"> comprobante</td>
      <td width="105" class="linea_datos_05">total cheques</td>
      <td width="109" class="linea_datos_05">total letras</td>
      <td width="112" class="linea_datos_05">total contado</td>
      <td width="113" class="linea_datos_05">total</td>
    </tr>
    <? 
	//-----MUESTRO COMPROBANTES
		for($countComp = 0 ; $countComp < @pg_numrows($result_comp) ; $countComp++){
			$filaComp=@pg_fetch_array($result_comp, $countComp);
	?>
    <tr> 
      <td class="membrete_datos"> 
        <? $sql_cta = "select * from con_cuenta where id_cuenta ='". trim($filaComp['id_cuenta']) ."' and rdb =".$_INSTIT;
	  								 $res_cta = pg_exec($conexion, $sql_cta);
									$fila_cta = pg_fetch_array($res_cta,0);
									echo trim($fila_cta['nombre']);
								?>
        &nbsp;</td>
      <td class="membrete_datos" align="center"><? echo trim($filaComp['nro_comprobante'])?>&nbsp;</td>
      <td class="membrete_datos" align="right"> 
        <? //if($f==0){	
	  									$sql_chq = "select distinct sum(cdd.monto) as monto, count(cdd.id_tipo_documento) from con_documenta_comprobante as cdc inner join con_documenta_doc as cdd on cdc.id_comprobante_doc = cdd.id_comprobante_doc where cdc.id_usuario = $cmb_usuario and cdc.fecha = to_date('".$fecha_buscar."', 'MM DD YYYY') and cdd.id_tipo_documento=2 and cdc.id_comprobante_doc=".$filaComp['id_comprobante_doc']."and cdd.id_cuenta='".$filaComp['id_cuenta']."'";
										$res_chq = pg_exec($conexion, $sql_chq);
										$fila_chq = pg_fetch_array($res_chq,0);
										$chq = $fila_chq['monto'];
										echo number_format($fila_chq['monto'],'2') ," ","(", $fila_chq['count'], ")";
								
										//}
										?>
        &nbsp;</td>
      <td class="membrete_datos" align="right"> 
        <?		$sql_ltr = "select distinct sum(cdd.monto) as monto, count(cdd.id_tipo_documento) from con_documenta_comprobante as cdc inner join con_documenta_doc as cdd on cdc.id_comprobante_doc = cdd.id_comprobante_doc where cdc.id_usuario = $cmb_usuario and cdc.fecha = to_date('".$fecha_buscar."', 'MM DD YYYY') and cdd.id_tipo_documento=3 and cdc.id_comprobante_doc=".$filaComp['id_comprobante_doc']."and cdd.id_cuenta='".$filaComp['id_cuenta']."'";
										$res_ltr = pg_exec($conexion, $sql_ltr);
										$fila_ltr = pg_fetch_array($res_ltr,0);
										$ltr = $fila_ltr['monto'];
										echo number_format($fila_ltr['monto'],'2')," ","(", $fila_ltr['count'], ")";
										?>
        &nbsp;</td>
      <td align="right" class="membrete_datos">
	  <?		$sql_ctdo = "select distinct sum(cdd.monto) as monto, count(cdd.id_tipo_documento) from con_documenta_comprobante as cdc inner join con_documenta_doc as cdd on cdc.id_comprobante_doc = cdd.id_comprobante_doc where cdc.id_usuario = $cmb_usuario and cdc.fecha = to_date('".$fecha_buscar."', 'MM DD YYYY') and cdd.id_tipo_documento=1 and cdc.id_comprobante_doc=".$filaComp['id_comprobante_doc']."and cdd.id_cuenta='".$filaComp['id_cuenta']."'";
										$res_ctdo = pg_exec($conexion, $sql_ctdo);
										$fila_ctdo = pg_fetch_array($res_ctdo,0);
										$ctdo = $fila_ctdo['monto'];
										echo number_format($fila_ctdo['monto'],'2')," ","(", $fila_ctdo['count'], ")";
										?>
		&nbsp; </td>
      <td align="right" class="membrete_datos">
        <? 
	  /*								$sql_tot_cta = "select distinct sum(cdd.monto) from con_documenta_doc cdd inner join con_documenta_comprobante cdc on cdd.id_comprobante_doc=cdc.id_comprobante_doc where  cdd.id_cuenta='".$filaComp['id_cuenta']."'";
									$res_tot = pg_exec($conexion, $sql_tot_cta);
									$fila_tot = pg_fetch_array($res_tot,0);
									echo trim($fila_tot['sum']);
									$tot_cta = $fila_tot['sum']*/
									$tot_reg = $ltr + $chq + $ctdo;
									echo number_format($tot_reg,'2');//.".00";
									?>
      </td>
    </tr>
    <?
	$cheques_total = ($cheques_total + trim($fila_chq['monto']));
	$letras_total = ($letras_total + trim($fila_ltr['monto']));
	$ctdo_total = ($ctdo_total + trim($fila_ctdo['monto']));
	$total_count_chq = ($total_count_chq + trim($fila_chq['count']));
	$total_count_ltr = ($total_count_ltr + trim($fila_ltr['count']));
	$total_count_ctdo = ($total_count_ctdo + trim($fila_ctdo['count']));
	$total_gral = ($total_gral + $tot_reg);
	} ?>
  </table>
  <br>
  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="198" class="membrete_datos">TOTAL GENERAL&nbsp;</td>
      <td width="105" class="membrete_datos" align="right"><? echo number_format($cheques_total, '2'), " " , "(" , trim($total_count_chq), ")";?>&nbsp;</td>
      <td width="107" class="membrete_datos" align="right"><? echo number_format($letras_total, '2'), " " , "(" , trim($total_count_ltr), ")"?>&nbsp;</td>
      <td width="112" class="membrete_datos" align="right"><? echo number_format($ctdo_total, '2'), " " , "(" , trim($total_count_ctdo), ")"?>&nbsp;</td>
      <td width="116" class="membrete_datos" align="right"><? echo number_format($total_gral, '2');?>&nbsp;</td>
    </tr>
  </table>

<br>
<br>
  <table width="650" border="0" align="center">
    <tr>
    <td align="right" class="membrete_datos">&nbsp;<?php setlocale ("LC_TIME", "es_ES"); echo (strftime("%d de %B de %Y")); ?></td>
  </tr>
</table>

<br>
<br>

<br>
<br>
  <div align="right" id="capa2" style="display:none"><table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr align="center"> 
      <td>_________________________</td>
      <td>_________________________</td>
  </tr>
    <tr align="center" > 
      <td class="membrete_datos">firma cajero</td>
      <td class="membrete_datos">firma tesorero</td>
  </tr>
</table></div>

  <table width="%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td> 
        <div align="center" id="capa0"> 
          <input name="cmdimprimiroriginal" type="button" class="cb_none_9_x_100" id="cmdimprimiroriginal" onclick="imprimir();" value="Imprimir">		  
        </div>
      </td>
  </tr>
</table>

</form>
</body>
</html>
