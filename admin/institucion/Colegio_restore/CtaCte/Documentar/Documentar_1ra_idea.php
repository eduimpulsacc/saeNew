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
		//----------- SELECT DE COMPROBANTE TEMP------------
		$sql_temp_sum = "SELECT sum(monto) as total FROM con_documento_temp WHERE id_temp = " . $max_comp . "";
		$resultado_sum = @pg_exec($conexion,$sql_temp_sum);
		$fils = @pg_fetch_array($resultado_sum,0);
		$total = trim($fils['total']);
		
		$sql_com_temp = "SELECT estado FROM con_comprobante_temp WHERE id_temp=" . $max_comp;
		$resultado_comp = @pg_exec($conexion,$sql_com_temp);
		$fila = @pg_fetch_array($resultado_comp,0);
		$id_cuenta = trim($fila['estado']);
				
		$sql_doc_comp= "UPDATE con_documenta_comprobante SET ";
		$sql_doc_comp= $sql_doc_comp. "id_usuario = '" . $_USUARIO . "',";
		$sql_doc_comp= $sql_doc_comp. "fecha = to_date('".$fecha_actual."', 'MM DD YYYY'), ";
		$sql_doc_comp= $sql_doc_comp. "hora = '" . $ldt_hora_actual . "',";
		$sql_doc_comp= $sql_doc_comp. "id_cuenta = " . $id_cuenta . ",";
		$sql_doc_comp= $sql_doc_comp. "monto = " . $total . " ";
		$sql_doc_comp= $sql_doc_comp. " WHERE id_comprobante_doc = " . $max_comp . " AND id_ctacte = '" . $ls_ctacte . "'";
		$resultado_doc_comp = @pg_exec($conexion,$sql_doc_comp);

		$sql_doc_temp = "SELECT * FROM con_documento_temp WHERE id_temp = " . $max_comp . "";
		$resultado_doc_1 = @pg_exec($conexion, $sql_doc_temp);
		$hasta = @pg_numrows($resultado_doc_1);
		for($k=0 ; $k<$hasta ; $k++){
			$fila = @pg_fetch_array($resultado_doc_1, $k);
			$sql_doc = "INSERT INTO con_documenta_doc VALUES (" . trim($fila['id_temp']) . ", " . trim($fila['item']) . ", " . trim($fila['id_tipo_documento']) . ", '" . trim($fila['numero']) ."', " . trim($fila['monto']) . ", to_date('".trim($fila['observacion01'])."', 'MM DD YYYY') , '" . trim($fila['observacion02']) . "' ) ";
			$resultado_doc = @pg_exec($conexion,$sql_doc);
		}
		$sql_delete = "DELETE FROM con_documento_temp WHERE id_temp=" . $delete . "";
		$resulta_delete = pg_exec($conexion,$sql_delete);
		
		$sql_delete_comp ="DELETE FROM con_comprobante_temp WHERE id_temp=" . $delete . "";
		$resulta_delete_temp = @pg_exec($conexion,$sql_delete_temp);
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
	$sql = "Select distinct a.rdb, a.id_ano, b.rut_apo, c.nombre_apo, c.ape_pat, c.ape_mat, e.nro_ano From matricula a inner join tiene2 b on a.rut_alumno = b.rut_alumno inner join apoderado c on b.rut_apo = c.rut_apo, ano_escolar e where a.rdb = $_INSTIT And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.nro_ano = $year_actual And e.situacion = 1  Order by 4 ;";
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
	$sql= "Select * from con_tipo_documento Order By nombre ;";
	$resultado_query_doc   = @pg_exec($conexion,$sql);
	$total_filas_tipo  = @pg_numrows($resultado_query_doc);

	//----------BUSQUEDA DE VALORES DE CUENTAS SEGUN EL APODERADO
	$sql_datos_cuentas= "SELECT DISTINCT a.rdb, a.id_cuenta, b.rut_apoderado, c.id_ctacte, c.cuenta_nombre, c.monto, b.id_ctacte FROM con_categoria_cuenta a, con_apoderado_ctacte b, con_estado_pago_detalle c WHERE a.rdb = $_INSTIT and a.rdb = b.rdb and b.rut_apoderado = '$cmbapoderado' and c.periodo = '$periodo' and b.id_ctacte = c.id_ctacte and a.id_cuenta = c.cuenta_id Order by 5,6 ";
	$resultado_query_datos_cuentas = @pg_exec($conexion,$sql_datos_cuentas);
	$total_filas_datos_cuentas     = @pg_numrows($resultado_query_datos_cuentas);
	$ls_ctacte					   = Trim(@pg_result($resultado_query_datos_cuentas, 0, 6));
	
	//------------INSERT DE CAMPOS TEMPORALES---------------------
	if ($paso=="1"){
		if ($max_comp==""){
				$ls_item=1;
				$sql_comp = "INSERT INTO con_documenta_comprobante (id_ctacte, rut_apo) VALUES ('". $ls_ctacte . "', '$cmbapoderado' )";
				$resultado_query_comp = @pg_exec($conexion,$sql_comp);
			
				$sql_max = "SELECT max(id_comprobante_doc) FROM con_documenta_comprobante WHERE id_ctacte='" . $ls_ctacte ."'";
				$resultado_max = @pg_exec($conexion,$sql_max);
				$max_comp = @pg_result($resultado_max , 0,0);
				
				$sql_temp ="INSERT INTO con_comprobante_temp (id_temp, id_ctacte, estado) VALUES (" . $max_comp . ", '" . $ls_ctacte . "', " . $cmbcuenta . ")";
				$resultado_temp = @pg_exec($conexion,$sql_temp);
				for($i=0 ; $i<$cuenta_alum ; $i++){
					if(trim($chk[$i])!=""){
						$sql_cuenta ="INSERT INTO con_documenta_alumno VALUES ('" . trim($chk[$i]) . "'," . $max_comp .")";
						$resultado_cuenta = @pg_exec($conexion,$sql_cuenta);
					}
				}
		}

	$sql_documento = "INSERT INTO con_documento_temp (id_temp, item, id_tipo_documento, numero, monto, observacion01, observacion02) VALUES (" . trim($max_comp) .", " . trim($ls_item) . ", " . trim($cmbtipo_doc) . ", '" . trim($serie) . "', ". trim($monto) . ",'" . trim($venc) ."' , '" . trim($obs) ."')";
	$resultado_documento = @pg_exec($conexion,$sql_documento);
	
	$sql_doc_temp = "SELECT * FROM con_documento_temp WHERE id_temp=" . $max_comp;
	$resultado_doc_temp = @pg_exec($conexion,$sql_doc_temp);

	}
//---------BUSQUEDA DE ALUMNOS SEGUN APODERADOS-----------
	
	if($alumno!="1"){
		$sql_datos_alumno= "Select distinct a.rut_alumno, b.rut_apo, a.rdb, a.id_ano, a.id_curso, f.nombre_alu, f.ape_pat, f.ape_mat, f.dig_rut, f1.grado_curso, f1.letra_curso From matricula a, tiene2 b, ano_escolar e, alumno f, curso f1 where a.rdb = $_INSTIT and b.rut_apo = '$cmbapoderado' And a.rut_alumno = b.rut_alumno And a.rut_alumno = f.rut_alumno And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.nro_ano = $year_actual And e.situacion = 1 And a.id_curso = f1.id_curso Order by 1 ; ";
	}else{
		$sql_datos_alumno= "Select distinct a.rut_alumno, b.rut_apo, a.rdb, a.id_ano, a.id_curso, f.nombre_alu, f.ape_pat, f.ape_mat, f.dig_rut, f1.grado_curso, f1.letra_curso From matricula a inner join con_documenta_alumno g on a.rut_alumno = g.rut_alumno , tiene2 b, ano_escolar e, alumno f, curso f1 where a.rdb = $_INSTIT and b.rut_apo = '$cmbapoderado' And a.rut_alumno = b.rut_alumno And a.rut_alumno = f.rut_alumno And a.rdb = e.id_institucion And a.id_ano = e.id_ano  And e.nro_ano = $year_actual And e.situacion = 1 And a.id_curso = f1.id_curso and g.id_documenta=$max_comp  AND a.rut_alumno=g.rut_alumno Order by 1 ;";
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
			if (form.cmbcuenta.value!=0){
				form.cmbcuenta.target="self";
				form.alumno.value="0";
			}
			if (form.cmbapoderado.value!=0){
				form.cmbapoderado.target="self";	
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

		if (!ValVac(document.form.serie,document.form.serie.value,"Debe ingresar el N�mero del Cheque")){ return; };
		if (!ValEnt(document.form.serie,"Debe ingresar solo n�meros en el campo N� Cheque")){ return; };
		
		if (!ValVac(document.form.monto,document.form.monto.value,"Debe ingresar el Monto Pago ")){ return; };
		if (!ValEnt(document.form.monto,"Debe ingresar solo n�meros en el campo N� Cheque")){ return; };
		
		if (!ValVac(document.form.venc,document.form.venc.value,"Debe ingresar la Fecha de Vencimiento")){ return; };
		if (!ValFecha(document.form.venc,"La fecha ingresada es incorrecta, int�ntelo nuevamente")){ return; };
		
		form.paso.value="1";
		form.alumno.value="1";
		form.action = 'Documentar.php';
		form.submit(true);
}
function imprimir(){
	document.getElementById("capa0").style.display='none';
	document.getElementById("capa1").style.display='none';
	//document.getElementById("capa2").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
	document.getElementById("capa2").style.display='block';
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
      <td colspan="2" class="linea_datos_02"><div align="center">DOCUMENTAR <? echo (@pg_result($resultado_query_cue, 0, 2));?></div></td>
    </tr>
    <tr> 
      <td class="linea_datos_02">INSTITUCI&Oacute;N</td>
      <td class="linea_datos_02"> <?print Trim(@pg_result($resultado_query_instit, 0, 1));?></td>
    </tr>
    <tr>
      <td class="linea_datos_02">N&ordm; COMPROBANTE</td>
      <td class="linea_datos_02"><? echo $max_comp;?>&nbsp;</td>
    </tr>
  </table>
<BR>
<table width="650" border="1" align="center" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="24" colspan="2" class="linea_datos_02">APODERADO</td>
    <td colspan="2" class="linea_datos_02">ESTADO DE CUENTAS</td>
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
    <td class="linea_datos_02">CUENTA :</td>
    <? if ($paso==1){?>
		<td class="membrete_datos"> <? echo Trim(@pg_result($resultado_query_cue, $x, 2));?><input name="cmbcuenta" type="hidden" value="<? echo $cmbcuenta;?>"></td>
		
	<? }else{ ?>
	<td> <select name="cmbcuenta" class="text_9_x_100" onChange="enviapag(this.form);" >
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
		
		<? } ?>
  </tr>
  <tr> 
    <td class="linea_datos_02">RUT:</td>
    <td class="membrete_datos"> <?
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
        <?=Trim(pg_result($resultado_query_dig, 0, 0))?></td>
    <td class="linea_datos_02">TOTAL A PARGAR:</td>
    <td class="membrete_datos">     <?
		For ($j=0; $j < $total_filas_datos_alumno; $j++){
			$ls_rut_alumno = Trim(pg_result($resultado_query_datos_alumno, $j, 0));
			$ls_grado = Trim(pg_result($resultado_query_datos_alumno, $j, 9));
			$ls_rdb = Trim(pg_result($resultado_query_datos_alumno, $j, 2));
			$sql_grado= "select distinct grado,monto from con_categoria_cuenta b, con_categoria_grado a where grado=$ls_grado and b.rdb=$_INSTIT and b.id_categoria=a.id_categoria and b.id_cuenta=$cmbcuenta";
			$resultado_query_grado = @pg_exec($conexion,$sql_grado);
			$total_filas_grado = @pg_numrows($resultado_query_grado);
			$ls_total_matr=$ls_total_matr + @pg_result($resultado_query_grado, 0, 1);
		}
	?>
        <b>
        <?=number_format($ls_total_matr,2)?></td>
  </tr>
 
</table>
<BR>
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
    <td class="linea_datos_02">MONTO <? echo (pg_result($resultado_query_cue, 0, 2));?></td>
  </tr>
   <?
	For ($j=0; $j < $total_filas_datos_alumno; $j++)
	{
	$ls_rut_alumno = Trim(pg_result($resultado_query_datos_alumno, $j, 0));
	$ls_grado = Trim(pg_result($resultado_query_datos_alumno, $j, 9));
	$ls_rdb = Trim(pg_result($resultado_query_datos_alumno, $j, 2));
	$sql_grado= "select distinct grado,monto from con_categoria_cuenta b, con_categoria_grado a where grado=$ls_grado and b.rdb=$_INSTIT and b.id_categoria=a.id_categoria and b.id_cuenta=$cmbcuenta";
	$resultado_query_grado = @pg_exec($conexion,$sql_grado);
	$total_filas_grado = @pg_numrows($resultado_query_grado);
	
	?>
    <tr> <? if ($alumno!=1){?>
			<td><input name="chk[<? echo $j ?>]" type="checkbox" value="<? echo $ls_rut_alumno;?> "></td><? } ?>
        <input name="cuenta_alum" type="hidden" value="<? echo $total_filas_datos_alumno;?>">
      <td class="membrete_datos">&nbsp;<?print Trim(pg_result($resultado_query_datos_alumno, $j, 6));?> <?print Trim(pg_result($resultado_query_datos_alumno, $j, 7));?> <?print Trim(pg_result($resultado_query_datos_alumno, $j, 5));?></td>
      <td class="membrete_datos">
        <div align="right">&nbsp; 
          <?print pg_result($resultado_query_datos_alumno, $j, 9);?>
          <?print Trim(pg_result($resultado_query_datos_alumno, $j, 10));?>
        </div>
      </td>
      <td class="membrete_datos"><div align="right">&nbsp; <? echo(@pg_result($resultado_query_grado, 0, 1));?></div>
	  </td>
    </tr>
	<?
	$total_matricula=$total_matricula + @pg_result($resultado_query_grado, 0, 1);
	}
	?>
  <tr> 
    <td colspan="<? if ($alumno!=1) echo "3"; else echo "2"; ?>" class="linea_datos_02">TOTAL <? echo (pg_result($resultado_query_cue, 0, 2));?></td>
    <td class="membrete_datos"><div align="right"><? echo number_format($total_matricula,'2'); ?></div></td>
  </tr>
</table>
<BR>
<table width="650" border="1" align="center" cellspacing="0" cellpadding="0" id="capa1">
  <tr> 
    <td colspan="6" class="linea_datos_02"><div align="center">DOCUMENTO PAGO</div></td>
  </tr>
  <tr> 
    <td class="linea_datos_05">TIPO DOCUMENTO</td>
    <td class="linea_datos_05">NUMERO-SERIE</td>
    <td class="linea_datos_05">MONTO $</td>
    <td class="linea_datos_05">FECHA VENC</td>
    <td class="linea_datos_05">OBSERVACION</td>
    <td class="linea_datos_05">&nbsp; </td>
  </tr>
  <tr> 
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
<? if($paso== "1"){?>
<table width="650" border="1" align="center" cellspacing="0" cellpadding="0">
  <tr>
      <td class="linea_datos_02">TIPO DOCUMENTO</td>
      <td class="linea_datos_02">NUMERO SERIE</td>
      <td class="linea_datos_02">MONTO $</td>
      <td class="linea_datos_02">FECHA VEC.</td>
      <td class="linea_datos_02">OBSERVACION</td>
      <td class="linea_datos_02"></td>
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
    <td class="membrete_datos"> <? print Trim($fila_doc['nombre']);?>&nbsp;</td>
    <td class="membrete_datos"><? echo $fila['numero'];?>&nbsp;</td>
    <td class="membrete_datos"><? echo $fila['monto'];?>&nbsp;</td>
    <td class="membrete_datos"><? echo trim($fila['observacion01']);?>&nbsp;</td>
    <td class="membrete_datos"><? echo $fila['observacion02'];?>&nbsp </td>
    <td class="membrete_datos"><input type="button" name="cb_delete" value="E" class="cb_submit_9_20x17" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="if (confirm('�Esta seguro de eliminar este Documento ?')){MM_delete.value = <? echo $id_temp;?>;MM_delete_02.value = <? echo $item; ?>;this.form.submit()}"></td>
  </tr>
 <? 
 }
 	$ls_item = $ls_item+1;
?>
</table>
<? }?>
  <input name="ls_item" type="hidden" value="<? echo $ls_item;?>">
  <input type="hidden" name="MM_delete">
  <input type="hidden" name="MM_delete_02">
  <input type="hidden" name="delete" value="<? echo $id_temp;?>">
  
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
