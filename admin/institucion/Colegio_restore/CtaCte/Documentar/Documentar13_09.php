<? include"../../Coneccion/conexion.php";
	
	$ldt_hora_hours    = date(H);
	$ldt_hora_minutes  = date(i);
	$ldt_hora_seconds  = date(s);
	$ldt_hora_actual   = ($ldt_hora_hours.$ldt_hora_minutes.$ldt_hora_seconds);
	
	$ldt_mes_consulta = Trim($_GET["ai_mes"]);
	$hoy = getdate();
	$year_actual = $hoy["year"];
	$mes_actual  = date(m);
	$dia_actual  = $hoy["mday"];
	$periodo = $year_actual.$mes_actual;
	$fecha_actual = $dia_actual."/".$mes_actual."/".$year_actual = $hoy["year"];
	
	//--------INICIA ELIMINAR DOCUMENTO DE TEMP
	if($_POST["MM_delete"] != ''){
		
		$id_temp    = $_POST["MM_delete"];
		$item        = $_POST["MM_delete_02"];
		
		$sql_delete = "DELETE FROM con_documento_temp WHERE id_temp=" . $id_temp . " AND item= " . $item . "";
		$resulta_delete = @pg_exec($conexion,$sql_delete);
		
		$sql_count = "SELECT count(*) FROM con_documento_temp WHERE id_temp=" . $id_temp . "";
		$resultado_count = @pg_exec($conexion,$sql_count);
		$fila=pg_fetch_array($resultado_count);
			if ($fila['count']<= 0 ){
				$paso=0;
			}
	}
	
	//--------TERMINA ELIMINAR DOCUMENTO DE TEMP
	
	//-------COMIENZA FINALIZAR PAGO

	if ($cb_finaliza!=""){
		$paso=0;
		$alumno=0;
		
		//----------- SELECT DE COMPROBANTE TEMP------------
		$sql_temp_sum = "SELECT sum(monto) as total FROM con_documento_temp WHERE id_temp = " . $max_comp . "";
		$resultado_sum = @pg_exec($conexion,$sql_temp_sum);
		$fils = @pg_fetch_array($resultado_sum,0);
		$total = trim($fils['total']);
		
		$sql_com_temp = "SELECT estado FROM con_comprobante_temp WHERE id_temp=" . $max_comp;
		$resultado_comp = @pg_exec($conexion,$sql_com_temp);
		$fila = @pg_fetch_array($resultado_comp,0);
		$id_cuenta = trim($fila['estado']);
				
		$sqlNroComp = "SELECT MAX(nro_comprobante) FROM con_documenta_comprobante WHERE RDB=".$_INSTIT;
		$resNroComp = pg_exec($conexion, $sqlNroComp);
		$filaNroComp = pg_fetch_array($resNroComp,0);
		$newNroComprobante = $filaNroComp['max'] + 1;

		$sql_doc_comp= "UPDATE con_documenta_comprobante SET ";
		$sql_doc_comp= $sql_doc_comp. "id_usuario = '" . $_USUARIO . "',";
		$sql_doc_comp= $sql_doc_comp. "fecha = to_date('".$fecha_actual."', 'MM DD YYYY'), ";
		$sql_doc_comp= $sql_doc_comp. "hora = '" . $ldt_hora_actual . "',";
		//$sql_doc_comp= $sql_doc_comp. "id_cuenta = " . $id_cuenta . ",";
		$sql_doc_comp= $sql_doc_comp. "monto = " . $total . ", ";
//		$sql_doc_comp= $sql_doc_comp. "nro_comprobante = " . $newNroComprobante . ", ";
		$sql_doc_comp= $sql_doc_comp. "rdb = " . $_INSTIT . " ";
		$sql_doc_comp= $sql_doc_comp. " WHERE id_comprobante_doc = " . $max_comp . " AND id_ctacte = '" . $ls_ctacte . "'";
		$resultado_doc_comp = @pg_exec($conexion,$sql_doc_comp);

		$sql_doc_temp = "SELECT * FROM con_documento_temp WHERE id_temp = " . $max_comp . "";
		$resultado_doc_1 = @pg_exec($conexion, $sql_doc_temp);
		$hasta = @pg_numrows($resultado_doc_1);
		for($k=0 ; $k<$hasta ; $k++){
			$fila = @pg_fetch_array($resultado_doc_1, $k);
			$sql_doc = "INSERT INTO con_documenta_doc VALUES (" . trim($fila['id_temp']) . ", " . trim($fila['item']) . ", " . trim($fila['id_tipo_documento']) . ", '" . trim($fila['numero']) ."', " . trim($fila['monto']) . ", to_date('".trim($fila['observacion01'])."', 'MM DD YYYY') , '" . trim($fila['observacion02']) . "' , ".$fila['id_cuenta']." ) ";
			$resultado_doc = @pg_exec($conexion,$sql_doc);
		}
		$sql_delete = "DELETE FROM con_documento_temp WHERE id_temp=" . $delete . "";
		$resulta_delete = pg_exec($conexion,$sql_delete);
		
		$sql_delete_comp ="DELETE FROM con_comprobante_temp WHERE id_temp=" . $delete . "";
		$resulta_delete_temp = @pg_exec($conexion,$sql_delete_temp);
	
		$max_comp = "";
		$cmbcuenta=0;

	}//if ($_POST["cb_finaliza"])
		


	//-|--------TERMINA FINALIZAR PAGO
	
	$sql = "Select distinct a.rdb, a.id_ano, b.rut_apo, c.nombre_apo, c.ape_pat, c.ape_mat, e.nro_ano From matricula a inner join tiene2 b on a.rut_alumno = b.rut_alumno inner join apoderado c on b.rut_apo = c.rut_apo, ano_escolar e where a.rdb = $_INSTIT And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.situacion = 1 Order by 4 ;";
	//$sql = "Select distinct a.rdb, a.id_ano, b.rut_apo, c.nombre_apo, c.ape_pat, c.ape_mat, e.nro_ano From matricula a, tiene2 b, apoderado c, ano_escolar e where a.rdb = $_INSTIT And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.situacion = 1 and a.rut_alumno = b.rut_alumno and b.rut_apo = c.rut_apo Order by 4 ;";
	$resultado_query = @pg_exec($conexion,$sql);
	$total_filas     = @pg_numrows($resultado_query);

	//-------BUSQUEDA DE INSTITUACION-----
	$sql_instit= "Select rdb, nombre_instit From institucion Where rdb = $_INSTIT ;";
	$resultado_query_instit = @pg_exec($conexion,$sql_instit);
	$total_filas_instit     = @pg_numrows($resultado_query_instit);
	
	//----------- BUSQUEDA DE APODERADOS--------
	$sql = "Select distinct a.rdb, a.id_ano, b.rut_apo, c.nombre_apo, c.ape_pat, c.ape_mat, e.nro_ano From matricula a inner join tiene2 b on a.rut_alumno = b.rut_alumno inner join apoderado c on b.rut_apo = c.rut_apo, ano_escolar e where a.rdb = $_INSTIT And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.nro_ano = $year_actual And e.situacion = 1 And b.sostenedor=1 Order by 5,6 ;";
	//$sql = "Select distinct a.rdb, a.id_ano, b.rut_apo, c.nombre_apo, c.ape_pat, c.ape_mat, e.nro_ano From matricula a, tiene2 b, apoderado c, ano_escolar e where a.rdb = $_INSTIT And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.nro_ano = $year_actual And e.situacion = 1 and a.rut_alumno = b.rut_alumno and b.rut_apo = c.rut_apo Order by 4 ;";
	$resultado_query = @pg_exec($conexion,$sql);
	$total_filas     = @pg_numrows($resultado_query);
	If($total_filas > 0){
	  If(Trim($cmbapoderado) == ''){
	  	$cmbapoderado = Trim(@pg_result($resultado_query, 0, 2));
	  }Else{
	 	$cmbapoderado = $cmbapoderado;
	  }
	}
	//----------BUSQUEDA DE DIGITO----------
	$sql= "Select dig_rut From apoderado where rut_apo = '$cmbapoderado' ;";
	$resultado_query_dig = @pg_exec($conexion,$sql);

	//--------BUSQUEDA DE CUENTA-------------
	$sql= "Select * From con_cuenta where rdb = $_INSTIT and asignar< 3 Order by nombre;";
	$resultado_query_cue = @pg_exec($conexion,$sql);
	$total_filas_cue     = @pg_numrows($resultado_query_cue);

	//-----------BUSQUEDA DE TIPO DE DOCUMENTOS----------------
	$sql= "Select * from con_tipo_documento where nombre = 'CHEQUE' OR  nombre = 'LETRAS' OR  nombre = 'CONTADO' Order By nombre ;";
	$resultado_query_doc   = @pg_exec($conexion,$sql);
	$total_filas_tipo  = @pg_numrows($resultado_query_doc);

	//----------BUSQUEDA DE VALORES DE CUENTAS SEGUN EL APODERADO
	//$sql_datos_cuentas= "SELECT DISTINCT a.rdb, a.id_cuenta, b.rut_apoderado, c.id_ctacte, c.cuenta_nombre, c.monto, b.id_ctacte FROM con_categoria_cuenta a, con_apoderado_ctacte b, con_estado_pago_detalle c WHERE a.rdb = $_INSTIT and a.rdb = b.rdb and b.rut_apoderado = '$cmbapoderado' and b.id_ctacte = c.id_ctacte and a.id_cuenta = c.cuenta_id Order by 5,6 ";
	$sql_datos_cuentas= "SELECT DISTINCT a.rdb, a.id_cuenta, b.rut_apoderado, b.id_ctacte FROM con_categoria_cuenta a, con_apoderado_ctacte b WHERE a.rdb = $_INSTIT and a.rdb = b.rdb and b.rut_apoderado = '$cmbapoderado' Order by 3,4 ";
	$resultado_query_datos_cuentas = @pg_exec($conexion,$sql_datos_cuentas);
	$total_filas_datos_cuentas     = @pg_numrows($resultado_query_datos_cuentas);
	$ls_ctacte					   = Trim(@pg_result($resultado_query_datos_cuentas, 0, 3));
	
	//------------INSERT DE CAMPOS TEMPORALES---------------------
	if ($paso=="1"){
		if ($max_comp==""){
				$ls_item=1;
				
				$sqlNroComp = "SELECT MAX(nro_comprobante) FROM con_documenta_comprobante WHERE RDB=".$_INSTIT;
				$resNroComp = pg_exec($conexion, $sqlNroComp);
				$filaNroComp = pg_fetch_array($resNroComp,0);
				$newNroComprobante = $filaNroComp['max'] + 1;

				$sql_comp = "INSERT INTO con_documenta_comprobante (id_ctacte, rut_apo, nro_comprobante) VALUES ('". $ls_ctacte . "', '". $cmbapoderado ."', ". $newNroComprobante." )";
				$resultado_query_comp = pg_exec($conexion,$sql_comp);
			
				//echo $sql_max = "SELECT max(id_comprobante_doc) FROM con_documenta_comprobante WHERE id_ctacte='" . $ls_ctacte ."'";
				$sql_max = "SELECT max(id_comprobante_doc) FROM con_documenta_comprobante WHERE rut_apo='" . $cmbapoderado ."'";
				$resultado_max = @pg_exec($conexion,$sql_max);
				$max_comp = @pg_result($resultado_max , 0,0);
				
				$sql_temp ="INSERT INTO con_comprobante_temp (id_temp, id_ctacte, estado) VALUES (" . $max_comp . ", '" . $ls_ctacte . "', " . $cmbcuenta . ")";
				$resultado_temp = pg_exec($conexion,$sql_temp);
				for($i=0 ; $i<$cuenta_alum ; $i++){
					if(trim($chk[$i])!=""){
						$sql_cuenta ="INSERT INTO con_documenta_alumno VALUES ('" . trim($chk[$i]) . "'," . $max_comp .")";
						$resultado_cuenta = @pg_exec($conexion,$sql_cuenta);
					}
				}
		}

	$sql_documento = "INSERT INTO con_documento_temp (id_temp, item, id_tipo_documento, numero, monto, observacion01, observacion02, id_cuenta) VALUES (" . trim($max_comp) .", " . trim($ls_item) . ", " . trim($cmbtipo_doc) . ", '" . trim($serie) . "', ". trim($monto) . ",'" . trim($venc) ."' , '" . trim($obs) ."', ".$cmbcuenta.")";
	$resultado_documento = @pg_exec($conexion,$sql_documento);
	
	$sql_doc_temp = "SELECT * FROM con_documento_temp WHERE id_temp=" . $max_comp;
	$resultado_doc_temp = @pg_exec($conexion,$sql_doc_temp);
	echo "<script>window.location='#tabla';</script>";
	}
//---------BUSQUEDA DE ALUMNOS SEGUN APODERADOS-----------
	if($alumno!=1){
		$sql_datos_alumno= "Select distinct a.rut_alumno, b.rut_apo, a.rdb, a.id_ano, a.id_curso, f.nombre_alu, f.ape_pat, f.ape_mat, f.dig_rut, f1.grado_curso, f1.ensenanza, f1.letra_curso From matricula a, tiene2 b, ano_escolar e, alumno f, curso f1 where a.rdb = $_INSTIT and b.rut_apo = '$cmbapoderado' And a.rut_alumno = b.rut_alumno And a.rut_alumno = f.rut_alumno And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.nro_ano = $year_actual And e.situacion = 1 And a.id_curso = f1.id_curso Order by 1 ; ";
	}else{
		$sql_datos_alumno= "Select distinct a.rut_alumno, b.rut_apo, a.rdb, a.id_ano, a.id_curso, f.nombre_alu, f.ape_pat, f.ape_mat, f.dig_rut, f1.grado_curso, f1.ensenanza, f1.letra_curso From matricula a inner join con_documenta_alumno g on a.rut_alumno = g.rut_alumno , tiene2 b, ano_escolar e, alumno f, curso f1 where a.rdb = $_INSTIT and b.rut_apo = '$cmbapoderado' And a.rut_alumno = b.rut_alumno And a.rut_alumno = f.rut_alumno And a.rdb = e.id_institucion And a.id_ano = e.id_ano  And e.nro_ano = $year_actual And e.situacion = 1 And a.id_curso = f1.id_curso and g.id_comprobante=$max_comp  AND a.rut_alumno=g.rut_alumno Order by 1 ;";
	}
		$resultado_query_datos_alumno = pg_exec($conexion,$sql_datos_alumno);
		$total_filas_datos_alumno     = pg_numrows($resultado_query_datos_alumno);

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link rel="stylesheet" href="../../css/objeto.css" type="text/css">
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="Validaciones.js"></SCRIPT>
<SCRIPT language="JavaScript">
			function enviapag(form){
			/*if (form.cmbcuenta.value!=0){
				form.cmbcuenta.target="self";
				form.alumno.value="0";
			}*/
			if (form.cmbapoderado.value!=0){
				form.cmbapoderado.target="self";
				form.alumno.value="0";	
//				form.action = form.cmbPERIODO.value;
			}
				
				form.action = 'Documentar.php?paso=0&alumno=0';
				form.submit(true);
	
				
			}
	function Validar(){
	/*var cuenta;
	var i;
	
		cuenta = document.form.cuenta_alum.value;
		var a = new Array[cuenta];
		contador=0;
		alert(cuenta);
		for(i=0;i<cuenta;i++){

			if (document.form.chk+a.checked==true){
				contador=1;
				alert("msg");
			}
		};
		if (contador!=1){
			alert("Debe seleccionar al alumno a pagar");
			document.form.chk.focus();
			return;
		};*/
		
		if (!ValVac(document.form.cmbtipo_doc,document.form.cmbtipo_doc.options[document.form.cmbtipo_doc.options.selectedIndex].value,"Debe seleccionar el Tipo de Documento")){ return; };

		if (!ValVac(document.form.serie,document.form.serie.value,"Debe ingresar el Número del Cheque")){ return; };
		if (!ValEnt(document.form.serie,"Debe ingresar solo números en el campo Nº Cheque")){ return; };
		
		if (!ValVac(document.form.monto,document.form.monto.value,"Debe ingresar el Monto Pago ")){ return; };
		if (!ValEnt(document.form.monto,"Debe ingresar solo números en el campo Nº Cheque")){ return; };
		
		if (!ValVac(document.form.venc,document.form.venc.value,"Debe ingresar la Fecha de Vencimiento")){ return; };
		if (!ValFecha(document.form.venc,"La fecha ingresada es incorrecta, inténtelo nuevamente")){ return; };
		
		form.paso.value="1";
		form.alumno.value="1";
		form.action = 'Documentar.php';
		form.submit(true);
}
function imprimir(){
	document.getElementById("capa0").style.display='none';
	document.getElementById("capa1").style.display='none';
	document.getElementById("capa3").style.display='block';
	document.getElementById("capa4").style.display='block';
	window.print();
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
	document.getElementById("capa2").style.display='block';
	document.getElementById("capa3").style.display='none';
	document.getElementById("capa4").style.display='none';	
}
</script>
</head>

<body>
<form name="form" action="" method="post">
<input name="paso" type="hidden" value="<? echo $paso;?>">
<input name="alumno" type="hidden" value="<? echo $alumno;?>">
<input name="ls_ctacte" type="hidden" value="<? echo $ls_ctacte;?>">
<input name="imprime" type="hidden" value="<? echo $imprime;?>">
<table width="650" border="1" align="center" cellspacing="0" cellpadding="0">
 <tr> 
      <td width="96" class="linea_datos_02">INSTITUCI&Oacute;N</td>
      <td width="405" class="linea_datos_02" align="center"> <? print Trim(@pg_result($resultado_query_instit, 0, 1));?></td>
      <td width="141" class="linea_datos_02">
	  <div align="right" id="capa4" style="display:none">
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
      <td width="133" class="linea_datos_02">N&ordm; COMPROBANTE </td>
      <td width="511" class="linea_datos_02"><? if($alumno==1) echo $newNroComprobante;?>&nbsp;<input name="newNroComprobante" type="hidden" value="<? echo $newNroComprobante;?>"></td>
    </tr>
  </table>
<BR>
  <table width="650" border="1" align="center" cellspacing="0" cellpadding="0">
    <tr> 
      <td height="24" colspan="2" class="linea_datos_02">sostenedor</td>
    </tr>
    <tr> 
      <td class="linea_datos_02">NOMBRE:</td>
      <td class="membrete_datos"><select name="cmbapoderado" class="ddlb_9_x_250" OnChange="enviapag(this.form);">
          <?
	For ($j=0; $j < $total_filas; $j++)
	{
	?>
          <option value="<?=Trim(@pg_result($resultado_query, $j, 2));?>" <? If(Trim(@pg_result($resultado_query, $j, 2)) == $cmbapoderado) {echo("selected");}?> > 
          <?=Trim(@pg_result($resultado_query, $j, 4));?>
          <?=Trim(@pg_result($resultado_query, $j, 5));?>
          <?=Trim(@pg_result($resultado_query, $j, 3));?>
          </option>
          <?
	}
	
	?>
        </select></td>
      <? //if ($paso==1){
			For ($x=0; $x<$total_filas_cue; $x++){?>
      <? }
	 //} ?>
    </tr>
    <tr> 
      <td class="linea_datos_02">RUT:</td>
      <td class="membrete_datos"> 
        <?
	  If(Trim($cmbapoderado) == '')
	  {
	  	$cmbapoderado = Trim(pg_result($resultado_query, 0, 2));
	  }Else
	  {
	  	$cmbapoderado = $cmbapoderado;
	  }
	  ?>
        <?=($cmbapoderado);?>
        - 
        <?=Trim(pg_result($resultado_query_dig, 0, 0))?>
      </td>
    </tr>
  </table>
<BR>
  <table width="650" border="1" align="center" cellspacing="0" cellpadding="0">
    <tr> 
	<? //if ($paso==1){
			//For ($x=0; $x<$total_filas_cue; $x++){
			For ($j=0; $j < $total_filas_datos_alumno; $j++){
			$ls_rut_alumno = Trim(pg_result($resultado_query_datos_alumno, $j, 0));
			$ls_grado = Trim(pg_result($resultado_query_datos_alumno, $j, 9));
			$ls_rdb = Trim(pg_result($resultado_query_datos_alumno, $j, 2));
			$sql_grado= "select id_cuenta, grado, sum (monto) as monto from con_categoria_cuenta b, con_categoria_grado a where grado=$ls_grado and b.rdb=$_INSTIT and b.id_categoria=a.id_categoria and b.id_cuenta in (Select id_cuenta From con_cuenta where rdb = $_INSTIT and asignar< 3 Order by nombre) group by grado";
			$resultado_query_grado = @pg_exec($conexion,$sql_grado);
?>

      <? }//}
	 //} ?>
    </tr>
    <tr> 
      <td class="linea_datos_02">TOTAL A documentar:</td>
      <td class="membrete_datos"> 
        <?
		For ($j=0; $j < $total_filas_datos_alumno; $j++){
			$ls_rut_alumno = Trim(pg_result($resultado_query_datos_alumno, $j, 0));
			$ls_ensenanza = Trim(pg_result($resultado_query_datos_alumno, $j, 10));
			$ls_grado = Trim(pg_result($resultado_query_datos_alumno, $j, 9));
			$ls_rdb = Trim(pg_result($resultado_query_datos_alumno, $j, 2));
			$sql_grado_0= "select  id_cuenta, grado ,monto, a.id_categoria from con_categoria_cuenta b, con_categoria_grado a where grado=$ls_grado and ensenanza=$ls_ensenanza and b.rdb=$_INSTIT and b.id_categoria=a.id_categoria and b.id_cuenta in (Select id_cuenta From con_cuenta where rdb = $_INSTIT and asignar< 3 Order by nombre)";
			$resultado_query_grado_0 = @pg_exec($conexion,$sql_grado_0);
			$total_filas_grado_0 = @pg_numrows($resultado_query_grado_0);
			for($count=0 ; $count < $total_filas_grado_0 ; $count++){
				$sqlCount="select count(id_cuenta) from con_categoria_cuenta_periodo where id_cuenta=".@pg_result($resultado_query_grado_0, $count, 0)." and id_categoria = ".@pg_result($resultado_query_grado_0, $count, 3)."";
				$resCount = pg_exec($conexion, $sqlCount);
				$filaCount = pg_fetch_array($resCount, 0);
				$cant = $filaCount['count'];
				$monto = $cant * @pg_result($resultado_query_grado_0, $count, 2);
				$tot = $tot + $monto;
			}
			//$ls_total_matr_0 = $ls_total_matr_0 + $monto;
			//$ls_total_matr_0=$ls_total_matr_0 + @pg_result($resultado_query_grado_0, 0, 1);
		}
	?><b>
        <div align="center"><?=number_format($tot,2)?></div>
      </td>
    </tr>
  </table>

<br>
<table width="650" border="1" align="center" cellspacing="0" cellpadding="0">
  <tr> 
    <td colspan="<? if ($alumno!=1) echo "4"; else echo "3"; ?>" class="linea_datos_02"><div align="center">ALUMNOS</div></td>
  </tr>
  <tr> 
 <? if ($alumno!=1){?>
    <td class="linea_datos_02">&nbsp;</td>
 <? }?>
    <td class="linea_datos_02">NOMBRE</td>
    <td class="linea_datos_02">CURSO</td>
      <td class="linea_datos_02">MONTO </td>
  </tr>
   <?
	For ($j=0; $j < $total_filas_datos_alumno; $j++)
	{
	$ls_rut_alumno = Trim(pg_result($resultado_query_datos_alumno, $j, 0));
	$ls_ensenanza = Trim(pg_result($resultado_query_datos_alumno, $j, 10));
	$ls_grado = Trim(pg_result($resultado_query_datos_alumno, $j, 9));
	$ls_rdb = Trim(pg_result($resultado_query_datos_alumno, $j, 2));
	$sql_grado= "select distinct id_cuenta, grado,monto,a.id_categoria from con_categoria_cuenta b, con_categoria_grado a where grado=$ls_grado and ensenanza =$ls_ensenanza and b.rdb=$_INSTIT and b.id_categoria=a.id_categoria and b.id_cuenta in (Select id_cuenta From con_cuenta where rdb = $_INSTIT and asignar< 3 Order by nombre )";
	$resultado_query_grado = @pg_exec($conexion,$sql_grado);
	$total_filas_grado = @pg_numrows($resultado_query_grado);
	
	?>
     
	
		<? for ($count_0=0 ; $count_0<$total_filas_grado ; $count_0++ ){?>
			<tr><? if ($alumno!=1){?><td><input name="chk[<? echo $j ?>]" type="checkbox" value="<? echo $ls_rut_alumno;?> "></td><? } ?>
        <input name="cuenta_alum" type="hidden" value="<? echo $total_filas_datos_alumno;?>">
      <td class="membrete_datos">&nbsp;<? print Trim(pg_result($resultado_query_datos_alumno, $j, 6));?> <? print Trim(pg_result($resultado_query_datos_alumno, $j, 7));?> <? print Trim(pg_result($resultado_query_datos_alumno, $j, 5));?></td>
      <td class="membrete_datos">
        <div align="right">&nbsp; 
          <? print pg_result($resultado_query_datos_alumno, $j, 9);?>
          <? print Trim(pg_result($resultado_query_datos_alumno, $j, 11));?>
        </div>
      </td>
      <td class="membrete_datos"><div align="right">&nbsp; <? $val=@pg_result($resultado_query_grado, $count_0, 0);
										  $sqlCta="select nombre from con_cuenta where id_cuenta=".$val;
										  $resCta = pg_exec($conexion, $sqlCta);
										  $fila =pg_fetch_array($resCta,0);
										  echo $fila['nombre'];
										  echo "  -  ";
										//for($count_0=0 ; $count_0 < $total_filas_grado_0 ; $count_0++){
											$sqlCount_0="select count(id_cuenta) from con_categoria_cuenta_periodo where id_cuenta=".@pg_result($resultado_query_grado, $count_0, 0)." and id_categoria = ".@pg_result($resultado_query_grado, $count_0, 3)."";
											$resCount_0 = pg_exec($conexion, $sqlCount_0);
											$filaCount_0 = pg_fetch_array($resCount_0, 0);
											$cant_0 = $filaCount_0['count'];
											$monto_0 = $cant_0 * @pg_result($resultado_query_grado, $count_0, 2);
											echo number_format($monto_0,'2');
											//echo " | ",$tot_0 = $tot_0 + $monto_0;
											if($nomcta0=="") {
												$nomcta0=$fila['nombre'];
											}
											if ($nomcta0 == $fila['nombre']) {
												$mcta0 = $monto_0 + $mcta0;
											}else {
												$nomcta1 = $fila['nombre'];
												$mcta1 = $monto_0 + $mcta1;
											}
											//echo $nomcta1, "  |  ", $mcta1;
										//}

										  //echo(@pg_result($resultado_query_grado, $count, 2));?></div>
										  
	  </td>
	  </tr>
	  <? $total_matricula=$total_matricula + @pg_result($resultado_query_grado, $count, 2);
	  } ?>
    
	<?
	
	}
	?>
	

	<tr>
		
      <td colspan="<? if ($alumno!=1) echo "3"; else echo "2"; ?>" class="linea_datos_02">subtotal <? echo $nomcta0?> 
      </td>
		<td class="linea_datos_02"><div align="right"><? echo number_format($mcta0,'2')?></div>
		</td>
		
	</tr>
	<tr>
		
      <td colspan="<? if ($alumno!=1) echo "3"; else echo "2"; ?>" class="linea_datos_02">subtotal <? echo $nomcta1 ?>
      </td>
		<td class="linea_datos_02"><div align="right"><? echo number_format($mcta1,'2')?></div>
		</td>
		
	</tr>
  <tr> 
      <td colspan="<? if ($alumno!=1) echo "3"; else echo "2"; ?>" class="linea_datos_02">TOTAL 
      </td>
    <td class="linea_datos_02"><div align="right"><? echo number_format($tot,'2'); ?></div></td>
  </tr>
</table>
<BR>
<div><a name="tabla"></a></div>
<table width="650" border="1" align="center" cellspacing="0" cellpadding="0" id="capa1">
  <tr> 
    <td colspan="7" class="linea_datos_02"><div align="center">DOCUMENTO PAGO</div></td>
  </tr>
  <tr> 
    <td class="linea_datos_05">CUENTA</td>
    <td class="linea_datos_05">TIPO DOCUMENTO</td>
    <td class="linea_datos_05">NUMERO-SERIE</td>
    <td class="linea_datos_05">MONTO $</td>
    <td class="linea_datos_05">FECHA VENC</td>
    <td class="linea_datos_05">OBSERVACION</td>
    <td class="linea_datos_05">&nbsp; </td>
  </tr>
  <tr>
  <td>
  <select name="cmbcuenta" class="text_9_x_100">
          <option value=0 selected>Seleccione Cuenta</option>
		  <?
			For ($x=0; $x<$total_filas_cue; $x++)
			{
		  		if (@pg_result($resultado_query_cue, $x, 1)==$cmbcuenta){?>
		          <option value="<?=Trim(@pg_result($resultado_query_cue, $x, 1));?>" selected> 
        		  <?=Trim(@pg_result($resultado_query_cue, $x, 2));?>
          		  </option>
				 <? }else{ ?>
			      <option value="<?=Trim(@pg_result($resultado_query_cue, $x, 1));?>"> 
        		  <?=Trim(pg_result($resultado_query_cue, $x, 2));?>
          		  </option>
		<?			}
		  }
		  ?>
        </select>
  </td> 
    <td><select name="cmbtipo_doc" class="ddlb_x">
         <?
			For ($j=0; $j < $total_filas_tipo; $j++){
		?>
            <option value="<?=pg_result($resultado_query_doc, $j, 0)?>"> 
            <?=Trim(pg_result($resultado_query_doc, $j, 1))?>
            </option>
        <?	}?>
          </select>
    </td>
    <td class="membrete_datos"><div align="center"><input type="text" name="serie" class="text_9_x_80"></div></td>
    <td class="membrete_datos"><div align="center"><input type="text" name="monto" class="text_9_x_100"></div></td>
    <td class="membrete_datos"><div align="center"><input type="text" name="venc" class="text_9_x_100"></div></td>
    <td class="membrete_datos"><div align="center"><textarea name="obs" rows="3" class="text_9_x_100"></textarea></div></td>
    <td><input name="max_comp" type="hidden" value="<? echo $max_comp;?>">
	<input  type="button" name="cb_save" value="+" class="cb_submit_9_20x17" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="javascript:Validar();"></td>
  </tr>
</table>
<br>
<? if($paso==1){?>
  <table width="650" border="1" align="center" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="88" class="linea_datos_02">cuenta</td>
      <td width="73" class="linea_datos_02">TIPO DOCUMENTO</td>
      <td width="131" class="linea_datos_02">NUMERO SERIE</td>
      <td width="82" class="linea_datos_02">MONTO $</td>
      <td width="99" class="linea_datos_02">FECHA VEC.</td>
      <td width="127" class="linea_datos_02">OBSERVACION</td>
      <td width="34" class="linea_datos_02">&nbsp;</td>
    </tr>
    <? 	
	
	for($i=0;$i<@pg_numrows($resultado_doc_temp);$i++){
		$fila = @pg_fetch_array($resultado_doc_temp,$i);
		$tipo = $fila['id_tipo_documento'];
		$id_temp = trim($fila['id_temp']);
		$item = trim($fila['item']);
	 
	$sql_doc= "Select a.*, b.nombre From con_documento_temp a, con_tipo_documento b Where a.id_temp = $id_temp And a.id_tipo_documento = b.id_tipo_documento Order By 2,3;";
	$resultado_query_doc   = pg_exec($conexion,$sql_doc);
	$fila_doc = pg_fetch_array($resultado_query_doc,$i);
	
  ?>
    <tr> 
      <td class="membrete_datos"><? $val=@pg_result($resultado_query_grado, $count, 0);
										  $sqlCta="select nombre from con_cuenta where id_cuenta=".$fila_doc['id_cuenta'];
										  $resCta = pg_exec($conexion, $sqlCta);
										  $filaCta =pg_fetch_array($resCta,0);
										  echo $filaCta['nombre'];?>&nbsp; </td>
      <td class="membrete_datos"><? print Trim($fila_doc['nombre']);?></td>
      <td class="membrete_datos"><? echo $fila['numero'];?>&nbsp;</td>
      <td class="membrete_datos" align="right"><? echo number_format($fila['monto'], '2');?>&nbsp;</td>
      <td class="membrete_datos" align="center"><? echo trim($fila['observacion01']);?>&nbsp;</td>
      <td class="membrete_datos"><? echo $fila['observacion02'];?>&nbsp </td>
      <td class="membrete_datos"><input type="button" name="cb_delete" value="E" class="cb_submit_9_20x17" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="if (confirm('¿Esta seguro de eliminar este Documento ?')){MM_delete.value = <? echo $id_temp;?>;MM_delete_02.value = <? echo $item; ?>;this.form.submit()}"></td>
    </tr>
    <? 
		$total_doc = $total_doc + $fila['monto'];
 }
 	$ls_item = $ls_item+1;
?>
  </table>
<? }?>
<br>
  <input name="ls_item" type="hidden" value="<? echo $ls_item;?>">
  <input type="hidden" name="MM_delete">
  <input type="hidden" name="MM_delete_02">
  <input type="hidden" name="delete" value="<? echo $id_temp;?>">
  
  <br>
  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="481" class="linea_datos_02">total documentado</td>
      <td width="169" class="membrete_datos">$<? echo number_format($total_doc, '2');?></td>
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
  <div align="right" id="capa3" style="display:none"><table width="50%" border="0" align="center">
    <tr align="center"> 
        <td width="47%">_________________________</td>
      <td width="53%">_________________________</td>
  </tr>
  <tr>
      <td align="center" class="membrete_datos">Firma Sostenedor</td>
      <td align="center" class="membrete_datos">Firma Cajero</td>
  </tr>
</table></div>

<br>

  
    <table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
    <td><div align="right" id="capa2" style="display:none">
          <input type="submit" name="cb_finaliza" value="Finalizar PAGO" class="cb_none_9_x_100" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' >
        </div>
      </td>
  </tr>
 
</table>
<br>
 <? if ($paso==1){ ?>
  <table width="%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td> 
        <div align="center" id="capa0"> 
          <input name="cmdimprimiroriginal" type="button" class="cb_none_9_x_100" id="cmdimprimiroriginal" onclick="imprimir();" value="Imprimir">		  
        </div>
      </td>
  </tr>
</table>
<? }?>
</form>
<BR>
</body>
</html>
