<?
require('../../../../util/header.inc');
include ("calendario/calendario.php");


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$id_feriado		=$_IDFERIADO;
	$bool_fer		=$_BOOLFER;
	

?>

<html>
<head>
	<title>Utilizaci&oacute;n del calendario</title>
	<!--script language="JavaScript" src="../calendario-seleccion-fecha/calendario/javascripts.js"></script-->

	<script language="JavaScript" src="../feriado/calendario/javascripts.js"></script>
</head>

<body>
<?php echo tope("../../../../util/");?>

<br>
<br>
<br>
<form method=post name="fcalen" action="procesoFeriado.php3">

  <table width="64%" border="0" align="center">
    <tr>
      <td><table width="61%" border="0">
          <tr> 
            <td width="34%"><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></FONT></td>
            <td width="2%"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
            <td width="64%"><FONT face="arial, geneva, helvetica" size=2><strong>
              <?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												//if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												//}
 											}
										?>
              </strong></FONT></td>
          </tr>
          <tr>
            <td> <FONT face="arial, geneva, helvetica" size=2> <strong>AÑO ESCOLAR</strong> 
              </FONT> </td>
            <td><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
            <td><FONT face="arial, geneva, helvetica" size=2><strong>
              <?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
													$nroAno=trim($fila1['nro_ano']);
												}
											}
										?>
              </strong></FONT></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr>
            <td align="right"><input type="submit" name="Submit" value="GUARDAR">
			<?php if (($frmModo=="modificar") and ($bool_fer!=0)){?>
            <input type="button" name="Submit4" value="ELIMINAR" onClick=document.location="seteaFeriado.php3?caso=9&id_feriado=<?php echo $id_feriado;?>">
			<?php } ?>
            <input type="button" name="Submit3" value="CANCELAR" onClick=document.location="seteaFeriado.php3?caso=4"></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td width="17%" height="20" align="left" bgcolor="#0099CC"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;INGRESO 
              DE FERIADOS</strong></font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td height="30" align="left" valign="middle"><font color="#000033" size="1" face="Arial, Helvetica, sans-serif">NOTA: 
              En caso de ingresar s&oacute;lo un d&iacute;a, h&aacute;galo en 
              el campo &quot;Fecha inicio&quot;</font></td>
          </tr>
        </table>
        
      <table width="100%" border="0" align="left">
        <tr align="left" valign="top"> 
            <td width="17%" valign="middle"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Fecha 
              inicio</strong></font></td>
            <td width="2%" valign="middle"><font size="2" face="Arial, Helvetica, sans-serif"><strong>:</strong></font></td>
            <td width="81%"> &nbsp; 
              <?php //$sql="select distinct feriado.id_feriado, feriado.bool_fer, feriado.fecha_inicio, feriado.fecha_fin, feriado.descripcion from feriado where id_ano=".$ano." and id_feriado=".$id_feriado." and bool_fer=".$bool_fer." UNION select feriados_nac.id_feriado,feriados_nac.bool_fer,feriados_nac.fecha_inicio, feriados_nac.fecha_fin, feriados_nac.descripcion from feriados_nac where feriado.id_ano=".$ano." and id_feriado=".$id_feriado." and bool_fer=".$bool_fer;
			  $sql="select distinct feriado.id_feriado, feriado.bool_fer, feriado.fecha_inicio, feriado.fecha_fin, feriado.descripcion from feriado where id_ano=".$ano." and id_feriado=".$id_feriado." and bool_fer=".$bool_fer." UNION select feriados_nac.id_feriado,feriados_nac.bool_fer,feriados_nac.fecha_inicio, feriados_nac.fecha_fin, feriados_nac.descripcion from feriados_nac where id_feriado=".$id_feriado." and bool_fer=".$bool_fer;
					$result =@pg_Exec($conn,$sql);
							if (@pg_numrows($result)!=0){
								$fila=@pg_fetch_array($result,0);
								
									$fecIni=substr($fila["fecha_inicio"],8,2); //dia
									$fecIni=$fecIni. "-";
									$fecIni=$fecIni. substr($fila["fecha_inicio"],5,2); //mes
									$fecIni=$fecIni. "-";
									$fecIni=$fecIni. substr($fila["fecha_inicio"],0,4);  //año

									$fecFin=substr($fecFin=$fila["fecha_fin"],8,2); //dia
									$fecFin=$fecFin."-";
									$fecFin=$fecFin.substr($fila["fecha_fin"],5,2); //mes
									$fecFin=$fecFin."-";
									$fecFin=$fecFin.substr($fila["fecha_fin"],0,4);  //año
						}?>
              <?php
					escribe_formulario_fecha_vacio("fecha1","fcalen","$fecIni");
?>
            </td>
          </tr>
          <tr align="left" valign="top"> 
            <td valign="middle"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Fecha 
              final </strong> </font></td>
            <td valign="middle"><font size="2" face="Arial, Helvetica, sans-serif"><strong>:</strong></font></td>
            <td> &nbsp;
              <?
				escribe_formulario_fecha_vacio("fecha2","fcalen","$fecFin");
?>
            </td>
          </tr>
          <tr align="left" valign="top"> 
            <td valign="middle"><strong><font size="2" face="Arial, Helvetica, sans-serif">Descripci&oacute;n</font></strong></td>
            <td valign="middle"><strong><font size="2" face="Arial, Helvetica, sans-serif">:</font></strong></td>
          <td> &nbsp; 
            <?php if($frmModo=="ingresar"){ ?>
            <input name="descripcion" type="text" size="50" maxlength="60">
			<?php } ?>
			<?php if($frmModo=="modificar"){
					$descripcion= $desc;
					//$descripcion= $fila["descripcion"];?>
            <input type="text" name="descripcion" size="50" maxlength="60" value="<?php imp ($fila["descripcion"]);?>">
			</td>
			<?php } ?>
          </tr>
        </table>

	</table>
  <table width="100%" border="0">
    <tr>
      <td>&nbsp;<hr width="64%" color=#0099cc></td>
    </tr>
  </table>
  <table width="58%" border="0" align="center">
    <tr bgcolor="#48d1cc"> 
      <td align="center"> 
        <table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
          <tr> 
            <td align="left"> <font face="arial, geneva, helvetica" size="1" color=black> 
              <ul>
                <li>Debe ingresar los feriados a ser considerados en el m&oacute;dulo 
                  de Asistencia</li>
                <li>&quot;GUARDAR&quot;: Guarda las modificaciones hechas al feriado.</li>
                <?php if ($frmModo=="modificar"){?>
                <li><font face="arial, geneva, helvetica" size="1" color=black>&quot;ELIMINAR&quot; 
                  : Elimina toda la informaci&oacute;n del feriado ingresado.</font></li>
                <?php } ?>
                <li>"VOLVER" : Vuelve al listado de feriados.</li>
                <li>Para abandonar la sesión de usuario presionar "CERRAR SESION".</li>
              </ul>
              </font> </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td align="center">&nbsp;</td>
    </tr>
  </table>
  <table width="100%" border="0">
    <tr bgcolor="white"> 
      
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
	