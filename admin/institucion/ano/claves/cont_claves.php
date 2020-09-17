<?php require('../../../../util/header.inc');

?>

<?
//header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_claves.php";
$ob_reporte = new Claves();

$funcion = $_POST['funcion'];

if($funcion==1){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
	<tr>
		<td colspan="2" align="center">
        	<table width="100%" border="0" cellpadding="3" cellspacing="1">
				<TR height=20>
					<TD align=center colspan=2 class="tableindex"> Administrador de Claves</TD>
				</TR>
			</table>
        </td>
	</tr>
	<tr> 
		<td align="left"><!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
						
<br>
<center>
  <script language="javascript">
function redire() 
{ 
  elem=document.getElementById("mensaje");
  elem.style.display=""; 
   window.location.href="GeneraClaveAlumno.php";    
}
</script>

<script language="javascript">
function redire2() 
{ 
  elem=document.getElementById("mensaje");
  elem.style.display=""; 
   window.location.href="GeneraClaveApoderado.php";    
}
</script>


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
	<tr> 
	  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
	  <td width="92%" class="datosB"><a href="#" onClick="AdminClaves(1)">Claves Alumnos </a></td>
	</tr>
	<tr> 
	  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
	  <td class="datosB"><a href="#" onClick="AdminClaves(2)">Claves Apoderados</a></td>
	</tr>
	  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
	  <td class="datosB"><a href="#" onclick="GeneraClavesAlumno()">Generar Claves para Alumnos </a></td>
	</tr>
	<tr> 
	  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
	  <td class="datosB"><a href="#" onclick="GeneraClavesApoderado()">Generar Claves para Apoderados </a></td>
	</tr>

</table>
</center>
      </td>
      <td align="right" width="118"><img src="../images/icono_claves_usuarios.png" width="118" height="118"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
 </table>
<?	
}

if($funcion==2){
	if($tipo==1){
		$texto="Alumnos";	
	}else{
		$texto="Apoderados";	
	}
	?>
    <div align="right"><INPUT class="botonXX" name="button" TYPE="button" onClick="Listado()" value="VOLVER"></div>
<table width="650" border="0" cellspacing="1" cellpadding="3">
	<TR height=20>
		<TD colspan=2 align=center class="tableindex"> Administrador de Claves- <? echo $texto ?>		</TD>
	</TR>
</table>
<br>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
      <tr>
        <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
        <td class="datosB"><a href="#" onClick="ClavesCurso(<? echo $tipo ?>)">Listar Claves por Curso</a></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
        <td class="datosB"><a href="#" onclick="BusquedaRUT(<? echo $tipo ?>)" >B&uacute;squeda por RUT  </a></td>
      </tr>
    </table></td>
  </tr>
</table>

<? }

if($funcion==3){
	if($curso!=0){
		$rsResultado=$ob_reporte->Claves($conn,$_ANO,$tipo,$curso);
	}
	if($tipo==1){
		$texto="Alumnos.";
	}else{
		$texto="Apoderados.";
	}
	?>
<table width="650" border="0">
  <tr>
    <td colspan="4" align="right">&nbsp;<input name="volver" id="volver" type="button" value="volver" onClick="Listado();" class="botonXX"></td>
  </tr>
  <tr>
    <td width="115" align="left" class="textonegrita">Activar Todos</td>
    <td width="147" align="left" class="textonegrita">&nbsp;<A href="#"><img src='../../../../cortes/PNG-24/Add.png' width='24' height='24' onClick='UsuarioCurso(1,<?=$tipo;?>)' title='ACTIVAR TODOS LOS ALUMNOS DEL CURSO'></A></td>
    <td width="188" align="left" class="textonegrita">Bloquear Todos</td>
    <td width="172" align="left" class="textonegrita">&nbsp;<a href="#"><img src='../../../../cortes/PNG-24/Delete.png' width='24' height='24' onClick='BloqueoCurso(1,<?=$tipo;?>)' title='BLOQUEAR TODOS LOS ALUMNOS DEL CURSO'></a></td>
  </tr> 
 
  <tr>
    <td align="left" class="textonegrita">Desactivar todos</td>
    <td align="left" class="textonegrita">&nbsp;<a href="#"><img src='../../../../cortes/PNG-24/Delete.png' width='24' height='24' onClick='UsuarioCurso(0,<?=$tipo;?>)' title='DESACTIVAR TODAS LAS CUENTAS DEL CURSO'></a></td>
    <td align="left" class="textonegrita">Desbloquear Todos</td>
    <td align="left" class="textonegrita">&nbsp;<a href="#"><img src='../../../../cortes/PNG-24/Add.png' width='24' height='24' onClick='BloqueoCurso(0,<?=$tipo;?>)' title='DESBLOQUEAR TODOS LOS ALUMNOS DEL CURSO'></a></td>
  </tr>
</table>

<table width="650" border="0" cellspacing="1" cellpadding="3">
	<TR height=20>
		<TD align=center colspan=2 class="tableindex"> Administrador de Claves - <? echo $texto?>		</TD>
	</TR>
</table>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
	<td width="92" class="tablatit2-1">Activo/Inactivo</td>
	<td width="109" class="tablatit2-1">NOMBRE USUARIO </td>
    <td width="80" class="tablatit2-1">CLAVE</td>
    <td width="235" class="tablatit2-1">NOMBRE  </td>
    <td width="98" class="tablatit2-1">BLOQUEAR</td>
    </tr>
  <?
	for($i=0;$i < @pg_numrows($rsResultado);$i++){
		$fResultado= @pg_fetch_array($rsResultado,$i);
		$Rs_Clave = $ob_reporte->Estado($connection,$fResultado['rut']);
		$filsClave = @pg_fetch_array($Rs_Clave,0);
		if($filsClave['estado']==1){
			$img="<img src='../../../../cortes/PNG-24/Add.png' width='24' height='24' onClick='ModificaClave($fResultado[rut],2,$tipo)' title='CUENTA ACTIVADA'>";
		}else{
			$img="<img src='../../../../cortes/PNG-24/Delete.png' width='24' height='24' onClick='ModificaClave($fResultado[rut],1,$tipo)' title='CUENTA DESACTIVADA'>";	
		}
?>
  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'>
    <td align="center"><a href="#"><?=$img;?></a></td>
	<td class="textosimple"><? echo $fResultado['rut']?></td>
    <td class="textosimple">
	<?
	$rsUsuario =$ob_reporte->ClaveUsuario($connection,$fResultado['rut']);
	$fUsuario= @pg_fetch_array($rsUsuario,0);	
	echo $fUsuario['pw'];
	?>
	&nbsp;</td>
    
    <? 
	$rs_alumno = $ob_reporte->EstadoBloqueo($conn,$fResultado['rut']);
	$bloqueo = pg_result($rs_alumno,0);
	if($bloqueo==0){
		$img_bloqueo="<img src='../../../../cortes/PNG-24/Add.png' width='24' height='24' onClick='ModificaBloqueo($fResultado[rut],1,$tipo)' title='CUENTA ACTIVADA'>";
	}else{
		$img_bloqueo="<img src='../../../../cortes/PNG-24/Delete.png' width='24' height='24' onClick='ModificaBloqueo($fResultado[rut],0,$tipo)' title='CUENTA BLOQUEADA'>";	
	}
	?>
    <td class="textosimple"><? echo ucwords(strtolower(trim($fResultado['ape_pat'])." ".trim($fResultado['ape_mat'])." ".trim($fResultado['nombres'])))?></td>
    <td align="center"><a href="#"><?=$img_bloqueo;?></a></td>
	
  </tr>
  <? } ?>
</table>
 
</center>
<br>
<br>
<center>
<table width="600" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="600">
	<table width="600" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="600" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78" class="cuadro01">Curso</td>
    <td width="263">
    <? $resultado_query_cue = $ob_reporte->Curso($conn,$_ANO); ?>
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso" id="cmb_curso"  class="ddlb_9_x"  onChange="MuestraClaves(<?=$tipo;?>,this.value)">
          <option value=0 selected>(Seleccione Curso)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if ($fila["id_curso"]==$curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
        </select>
</font>	  </div></td>
    
  </tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
<? }

if($funcion==4){
	$result = $ob_reporte->ModificaClave($connection,$rut,$estado,$tipo);
	
	if($result){
		echo 1;	
	}else{
		echo 0;
	}
}

if($funcion==5){
	$result = $ob_reporte->ModificaBloqueo($conn,$rut,$estado,$tipo);
	
	if($result){
		echo 1;	
	}else{
		echo 0;
	}
}

if($funcion==6){
	$result = $ob_reporte->UsuarioCurso($connection,$conn,$curso,$estado,$tipo);
	
	if($result){
		echo 1;	
	}else{
		echo 0;
	}
}

if($funcion==7){
	$result = $ob_reporte->BloqueoCurso($conn,$curso,$estado,$tipo);
	
	if($result){
		echo 1;	
	}else{
		echo 0;
	}
}

if($funcion==8){
	
	if($tipo==1){
		$texto="ALUMNOS.";
	}else{
		$texto="APODERADOS.";
	}
?>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="right"><INPUT class="botonXX"  name="button" TYPE="button" onClick="Listado()" value="VOLVER"></td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="1" cellpadding="3">
	<TR height=20>
		<TD align=center colspan=2 class="tableindex">
			ADMINISTRADOR DE CLAVES - <? echo $texto?>
		</TD>
	</TR>
</table>
<br>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="114"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>RUT USUARIO </strong></font></td>
    <td width="120"><input name="nombre_usuario" id="nombre_usuario" type="text"  size="20" maxlength="10" value = "<? echo $rut ?>"></td>
    <td width="394"><input class="botonXX"  type="button" name="Submit2" value="BUSCAR" onClick="BuscaClave(<?=$tipo;?>)"></td>
  </tr>
</table><br />
<br />

<? 	$rs_clave = $ob_reporte->BuscaClave($connection,$usuario,$tipo,$_INSTIT);
	$fUsuario=pg_fetch_array($rs_clave,0);
	
	$rs_datos = $ob_reporte->DatosUsuario($conn,$usuario,$tipo,$_ANO);
	$fResultado=pg_fetch_array($rs_datos,0);
	
	if(isset($usuario)){?>
 <table width="650" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse">
      <tr>
        <td width="100"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>NOMBRE</strong></font><strong><font color="#000000" size="1" face="arial, geneva, helvetica"> USUARIO </font></strong></td>
        <td width="529"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $usuario?></font>&nbsp;</td>
      </tr>
      <tr>
        <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>CLAVE</strong></font></td>
        <td><font face="Arial, Helvetica, sans-serif" size="-1"><?
	    echo $fUsuario['pw'];
	    ?></font>&nbsp;</td>
      </tr>
      <tr>
        <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>NOMBRE</strong></font><strong><font color="#000000" size="1" face="arial, geneva, helvetica"> </font></strong></td>
        <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo ucwords(strtolower(trim($fResultado['ape_pat'])." ".trim($fResultado['ape_mat'])." ".trim($fResultado['nombres'])))?></font>&nbsp;</td>
      </tr>
     </table><br>
    
<?	
	}
}

if($funcion==10){
	$result = $ob_reporte->GeneraClaveAlumno($conn,$connection,$ano,$rdb,$base);
	
	if($result){
		echo 1;	
	}else{
		echo 0;
	}
}

if($funcion==11){
	$result = $ob_reporte->GeneraClaveApoderado($conn,$connection,$ano,$rdb,$base);
	
	if($result){
		echo 1;	
	}else{
		echo 0;
	}
}
?>

