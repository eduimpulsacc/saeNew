<?php require('../../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$comunicacion 	=$_COMUNICACION;
	$ramo			=$_RAMO;
	$alumno			=$_ALUMNO;
	$apoderado		=$_APODERADO;
?>

<script language="JavaScript" type="text/javascript">
function ChequearTodos(chkbox)
{
	for (var i=0;i < document.forms[0].elements.length;i++)
	{
		var elemento = document.forms[0].elements[i];
		if (elemento.type == "checkbox")
		{
		elemento.checked = chkbox.checked
		}
	}
}
function Confirmacion(){
		if(confirm('¿ESTA SEGURO DE ELIMINAR ESTOS DATOS?') == false){ return; };
			document.location="seteaComunicacion.php?caso=9"
};
</script>
<SCRIPT language="JavaScript" src="../../../../util/chkform.js">

function valida(form){
		if(!chkVacio(form.fecha,'Ingresar Fecha de la comunicacion.')){
			return false;
		};titulo
		if(!chkVacio(form.titulo,'Ingresar Titulo de la comunicacion.')){
			return false;
		};
		if(!chkSelect(form.tipo,'Seleccionar TIPO DE COMUNICACION del curso.')){
			return false;
		};
		document.form.submit();
		return true;
}

</script>
	<?
	if (($frmModo=="mostrar") OR ($frmModo=="modificar")){
		$qry = "";
		$qry = "SELECT a.*, b.nombre FROM comunicacion a INNER JOIN tipo_comun b ON  a.tipo_comun=b.id_tipo_comun WHERE id_comun = ".$comunicacion;
		$Rs_Comun = @pg_exec($conn,$qry);
		$fila_Comun = @pg_fetch_array($Rs_Comun,0);
	
		$qyr="";
		$qry = "SELECT ape_pat, ape_mat, nombre_emp FROM empleado WHERE rut_emp=" . $fila_Comun['rut_emp'];
		$Rs_Doc = @pg_exec($conn,$qry);
		$filsDoc = @pg_fetch_array($Rs_Doc,0);
		$Nombre_Doc = $filsDoc['ape_pat'] ." ".$filsDoc['ape_mat']." ".$filsDoc['nombre_emp'];
		
		$qry = "";
		$qry = "SELECT * FROM comun_alumno WHERE id_comun = " . $comunicacion;
		$Rs_alumno = @pg_exec($conn,$qry);

	}
	if (($frmModo=="ingresar") OR ($frmModo=="modificar")){
	
	$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA WHERE ID_ANO=(".$ano.")  AND ID_CURSO=(".$curso.")";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}else{
		if (pg_numrows($result)!=0){
			$fila7 = @pg_fetch_array($result,0);	
			if (!$fila7){
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}
			
		}
	}
	$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) order by ape_pat, ape_mat, nombre_alu asc ";
	$result =@pg_Exec($conn,$qry);
	
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
	}else{
		if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
			$fila = @pg_fetch_array($result,0);	
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (4) No hay alumnos inscritos en este curso</B>');
				exit();
			}
		}
	}
	$qry = "";
	$qry = "SELECT * FROM comunicacion a INNER JOIN tipo_comun b ON  a.tipo_comun=b.id_tipo_comun WHERE id_comun= " . $comunicacion;
	$Rs_combo = @pg_exec($conn,$qry);
	$fila_Comun = @pg_fetch_array($Rs_combo,0);
	$Id_tipo = $fila_Comun['id_tipo'];
	} // fin If Modo ingresar
	$qry = "";
	$qry = "SELECT *  FROM tipo_comun";
	$Rs_tipo = @pg_exec($conn,$qry);
	
	$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
	$result1 =@pg_Exec($conn,$qry);
	$filano = @pg_fetch_array($result1,0);	
	$nro_ano=$filano['nro_ano'];
	
	$sqlProfesores = "select distinct empleado.rut_emp, empleado.ape_pat, empleado.ape_mat,empleado.nombre_emp ";
	$sqlProfesores = $sqlProfesores. "from matricula, empleado,supervisa,dicta ";
	$sqlProfesores = $sqlProfesores. "where matricula.rut_alumno =" . $alumno ." and matricula.id_ano = " . $ano . " and supervisa.id_curso=" . $curso ." ";
	$sqlProfesores = $sqlProfesores. "and empleado.rut_emp=supervisa.rut_emp and empleado.rut_emp=dicta.rut_emp ";
	$rsProfesores =@pg_Exec($conn,$sqlProfesores);
	
?>
<html>
<head>
<title>Untitled Document</title>
<LINK REL="STYLESHEET" HREF="../../../../../../util/td.css" TYPE="text/css">
<link href="../../../../../../util/objeto.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php if(($_PERFIL!=15)and ($_PERFIL!=16)and ($_PERFIL!=17)){?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../../periodo/listarPeriodo.php3"><img src="../../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../feriado/listaFeriado.php3"><img src="../../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../planEstudio/listarPlanesEstudio.php3"><img src="../../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../atributos/listarTiposEnsenanza.php3"><img src="../../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../../botones/cursos_roll.gif" name="Image6" width="81" height="30" border="0" id="Image6"></a></td>
          <td width="81" height="30"><a href="../../matricula/listarMatricula.php3"><img src="../../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../../../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../periodo/listarPeriodo.php3"><img src="../../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table>
	  <?php } ?>
	   </td>
  </tr>
</table><br>
<form action="procesoComunicacion.php" method="post" name="form">
<table width="600" border="0" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td colspan="7" align="right"><?php if (($_PERFIL==0) OR ($_PERFIL==17) OR ($_PERFIL==14) OR ($_PERFIL==15)) { ?>
		<? if($_PERFIL==0 OR $_PERFIL==17 OR $_PERFIL==14 OR ($_PERFIL==15)){
			if(($frmModo=="ingresar") OR ($frmModo=="modificar")){?>
			<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR" name=btnGuardar onclick="return valida(this.form);">
			<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ELIMINAR" name=btnGuardar onclick="Confirmacion();">
		<? }} 
			if(($frmModo=="mostrar")&&($_PERFIL==17)&&($fila_Comun['rut_apo']=="")){ ?>
			<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" name=btnGuardar onclick=document.location="seteaComunicacion.php?caso=3&comunicacion=<? echo $fila_Comun['id_comun']; ?>">
			<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" name=btnGuardar onclick=document.location="ListaComunicacion.php">
		<? } 
			if(($frmModo=="mostrar")&&($_PERFIL==15)&&($fila_Comun['rut_apo']!="")){?>
			<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" name=btnGuardar onclick=document.location="seteaComunicacion.php?caso=3&comunicacion=<? echo $fila_Comun['id_comun']; ?>">
		<? } ?>
		
		<?php } ?> 
		<? if($_PERFIL==15 OR $_PERFIL==16 OR $_PERFIL==14){ ?>
      	  	<input name="button" type="button" class="botonX" onclick=document.location="ListaComunicacion.php?alumno=<? echo $alumno;?>" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="VOLVER"> 
        <? } ?>
		<? if($_PERFIL==0 OR $_PERFIL==17 ){  // OR $_PERFIL==14  ?>
	        <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="ListaComunicacion.php">
        <? } ?>
        <? if($_PERFIL==8){ ?>
      	  	<input name="button" type="button" class="botonX" onClick=document.location="../ramo/seteaRamo.php3?caso=1&ramo=<? echo $ramo;?>" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="VOLVER"> 
        <? } ?>
		&nbsp;</td>
	</tr>
	<tr height=20 bgcolor=#003b85>
		<TD align=middle colspan="7"><FONT face="arial, geneva, helvetica" size=2 color=White><strong>COMUNICACIONES</strong></FONT></TD>
	</tr>
	<tr>
		<td colspan="7">&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
	<td><font size="1" face="Arial, Helvetica, sans-serif">FECHA</font></td>
	<td>&nbsp;:&nbsp;</td>
	
	<td><font face="Arial, Helvetica, sans-serif" size="2"><strong><? if ($frmModo=="mostrar"){?>
					<? impF($fila_Comun['fecha']); }
						if ($frmModo=="ingresar"){?> 
					<input name="fecha" type="text">
					<? } 
					if ($frmModo=="modificar"){?> 
					<input name="fecha" type="text" value="<? impF($fila_Comun['fecha']);?>">
					<? } ?></strong></font></td>
	<td>&nbsp;&nbsp;</td>
	<td><font size="1" face="Arial, Helvetica, sans-serif">TITULO</font></td>
	<td>&nbsp;:&nbsp;</td>
	<td><font face="Arial, Helvetica, sans-serif" size="2"><strong><? if ($frmModo=="mostrar") {?>
					<? echo strtoupper($fila_Comun['titulo']); }
						if ($frmModo=="ingresar"){?> 
							<input name="titulo" type="text">
					<? } 
						if ($frmModo=="modificar"){?> 
							<input name="titulo" type="text" value="<? echo $fila_Comun['titulo'];?>">
					<? } ?></strong></font></td></td>
</tr>
<tr>
	<td colspan="7">&nbsp;</td>
</tr>
<tr>
	<td colspan="7"><font size="1" face="Arial, Helvetica, sans-serif">COMUNICACION</font></td>
</tr>
<tr>
	<td colspan="7"><font face="Arial, Helvetica, sans-serif" size="2"><strong><? if ($frmModo=="mostrar"){?><blockquote><blockquote>
					<? echo nl2br(strtoupper($fila_Comun['nota'])); }?></blockquote></blockquote>
					<? if ($frmModo=="ingresar"){?> 
							<textarea name="memo" cols="60" rows="5"></textarea>
					<? } 
						if ($frmModo=="modificar"){?> 
							<textarea name="memo" cols="60" rows="5"><? echo $fila_Comun['nota'];?></textarea>
					<? } ?></strong></font>
	</td>
</tr>
<tr>
	<td colspan="7">&nbsp;</td>
</tr>
	
	<tr>
      <td width="%"><font size="1" face="Arial, Helvetica, sans-serif">TIPO COMUNICACION </font></td>
	  <td width="%"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;:&nbsp; </font></td>

	  <? if($frmModo=="mostrar"){?>
	  <td><font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo strtoupper($fila_Comun['nombre']);?></strong></font></td>
	  <? }
	    if(($frmModo=="ingresar") OR ($frmModo=="modificar")){?>
	  <td colspan="6"><select name="tipo">
	  	<option>Seleccionar  comunicacion</option>
	<? 	for($i=0 ; $i < @pg_numrows($Rs_tipo) ; $i++){ 
			$fila= @pg_fetch_array($Rs_tipo,$i);?>
				<option value="<? echo $fila['id_tipo_comun'] ?>"<?  if($fila['id_tipo_comun']==$fila_Comun['tipo_comun']){?>selected <? } ?>><? echo $fila["nombre"] ?></option>
	<?
		}
	?>		
	  </select></td>
	  <? } ?>
	</tr>
	<tr>
		<td colspan="6">&nbsp;</td>
	</tr>
	<? if($apoderado!=""){?>
	<tr>
	    <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">DOCENTE</font></div></td>
		<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;:&nbsp;</font></td>
		 <? if($frmModo=="mostrar"){?>
	  <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo strtoupper($Nombre_Doc);?></strong></font></div></td>
	  <? }
	if(($frmModo=="ingresar") OR ($frmModo=="modificar")){?>
      <td colspan="6"><select name="cmbDocente">
	  	<option>Seleccionar Docente</option>
	<? 	for($i=0 ; $i < @pg_numrows($rsProfesores) ; $i++){ 
			$fila= @pg_fetch_array($rsProfesores,$i);?>
				<option value="<? echo $fila['rut_emp'] ?>"<?  if($fila['rut_emp']==$fila_Comun['rut_emp']){?>selected <? } ?>><? echo $fila['ape_pat']." " .$fila['ape_mat']." " .$fila['nombre_emp'] ?></option>
	<?
		}
	?>		
	  </select></td>
	  <?
		}
	?>		
	</tr>
	<? } ?>
	<? if($apoderado==""){
	if(($frmModo=="ingresar") OR ($frmModo=="modificar")){?>
	<tr>
	    <td colspan="7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="23%"><font size="1" face="Arial, Helvetica, sans-serif">SELECCIONAR ALUMNOS</font></td>
			
			<td width="77%"><font size="1" face="Arial, Helvetica, sans-serif"><input name="SI" type="checkbox" value="1" onClick="ChequearTodos(this)"></font></td>
          </tr>
        </table></td>
	</tr>
	<? } ?>
	<tr>
	  <td colspan="7"><hr width="100%" color=#003b85></td>
	</tr>
	<? 
		
			if(($frmModo=="ingresar") OR ($frmModo=="modificar")){?>
				<tr bgcolor="#48d1cc">
					<td align="center" width="95"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>SELECCIONAR</strong></font></td>
					<td align="center" colspan="6"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>NOMBRE</strong></font></td>
				</tr>
				<? for($i=0; $i<@pg_numrows($result);$i++){
					$fila = @pg_fetch_array($result,$i);
					$valor=0;
						 for($j=0; $j<@pg_numrows($Rs_alumno); $j++){ 
							$fila_alum = @pg_fetch_array($Rs_alumno,$j);
							if($fila_alum['rut_alum']==$fila['rut_alumno'])
								$valor=1;
						}
				?>
			<tr bgcolor=#ffffff onmouseover=this.style.background='yellow'; onmouseout=this.style.background='transparent'>
					<td align="center"><font face="arial, geneva, helvetica" size="0" color="#000000"><strong><input name="alumno[]" type="checkbox" value="<? echo $fila['rut_alumno'];?>" <? echo ($valor==1)?"checked":"";?>></strong> </font></td>
					<td align="left" colspan="6"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fila["ape_pat"]."  ".$fila["ape_mat"].", ".$fila["nombre_alu"];?></strong></font></td>
					<!-- <input name="rut_alumno[]" type="hidden" value="<? echo $fila['rut_alumno'];?>"> -->
			</tr>
			<? } // fin for
			}
			} // fin If
			?>


</table>

</form>
</body>
</html>
