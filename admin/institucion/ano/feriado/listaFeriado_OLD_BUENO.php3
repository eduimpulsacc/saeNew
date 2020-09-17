<?
require('../../../../util/header.inc');
//include ("calendario/calendario.php");


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
?>

<html>
<head>
	<title>Utilizaci&oacute;n del calendario</title>

		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT></head>

<body>
<?php echo tope("../../../../util/");?>

<br>
<br>
<br>
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
            <td align="right">
				<input type="button" name="Button" value="AGREGAR" onClick=document.location="seteaFeriado.php3?caso=2"> 
              <input type="button" name="Submit3" value="VOLVER" onClick=document.location="../ano_escolar.php3"></td>
          </tr>
        </table>

      
        <table width="100%" border="0">
          <tr> 
            
          <td>&nbsp; </td>
          </tr>
        </table>
		<table width="100%" border="0" bordercolor="#0099CC">
          <tr>
            <td bgcolor="#0099CC">&nbsp;<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>FERIADOS 
              INGRESADOS</strong></font></td>
          </tr>
        </table>
        
      <table width="100%" border="0" align="center">
        <tr align="left" bgcolor="#48d1cc"> 
          <td colspan="3" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FECHA</font></td>
        </tr>
        <tr align="center" bgcolor="#48d1cc"> 
          <td width="20%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">DESDE</font></td>
          <td width="20%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">HASTA</font></td>
          <td width="60%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">DESCRIPCI&Oacute;N</font></td>
        </tr>
        <?php 
		
		/*for($j=0 ; $j<pg_numrows($result2) ; $j++){
		  $filaFeriado=@pg_fetch_array($result2,$j);
		  $fecIni = $filaFeriado["fecha_inicio"];
		  $fecFin = $filaFeriado["fecha_fin"];
		  $desc = $filaFeriado["descripcion"];*/
		  
		   ?>
        <tr align="center" bgcolor=#ffffff onClick=go('seteaFeriado.php3?caso=3&id_feriado=<?php echo $filaFeriado["id_feriado"];?>&bool_fer=<?php echo $filaFeriado["bool_fer"];?>') onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'> 
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo impF ($fecIni);//($filaFeriado["fecha_inicio"])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo impF ($fecFin);//($filaFeriado["fecha_fin"]);?></font></td>
          <td align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $desc;//$filaFeriado["descripcion"];?></font></td>
        </tr>
        <?php //} ?>
      </table>
	  <table width="100%" border="0">
        <tr>
          <td>
            <?php $sql2="select distinct feriado.id_feriado, feriado.bool_fer, feriado.fecha_inicio, feriado.fecha_fin, feriado.descripcion from feriado where id_ano=244 UNION select feriados_nac.id_feriado,feriados_nac.bool_fer,feriados_nac.fecha_inicio, feriados_nac.fecha_fin, feriados_nac.descripcion from feriados_nac where feriado.id_ano=".$ano." and fecha_inicio not in (select fecha_inicio from feriado) order by fecha_inicio";
					$result2=@pg_Exec($conn,$sql2);
						if (!$result2) {
							error('<b> ERROR :</b>Error al acceder a la BD. (7)'.$sql2);
						}

				?>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" bordercolor="#0099CC">
          <tr>
          </tr>
        </table>
        <table width="100%" border="0" bordercolor="#0099CC">
          <tr>
            <td bgcolor="#0099CC">&nbsp;<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>FERIADOS 
              INGRESADOS</strong></font></td>
          </tr>
        </table>
        
      <table width="100%" border="0" align="center">
        <tr align="left" bgcolor="#48d1cc"> 
          <td colspan="3" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FECHA</font></td>
        </tr>
        <tr align="center" bgcolor="#48d1cc"> 
          <td width="20%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">DESDE</font></td>
          <td width="20%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">HASTA</font></td>
          <td width="60%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">DESCRIPCI&Oacute;N</font></td>
        </tr>
        <?php 
		
		for($j=0 ; $j<pg_numrows($result2) ; $j++){
		  $filaFeriado=@pg_fetch_array($result2,$j);
		  $fecIni = $filaFeriado["fecha_inicio"];
		  $fecFin = $filaFeriado["fecha_fin"];
		  $desc = $filaFeriado["descripcion"];
		  
		   ?>
        <tr align="center" bgcolor=#ffffff onClick=go('seteaFeriado.php3?caso=3&id_feriado=<?php echo $filaFeriado["id_feriado"];?>&bool_fer=<?php echo $filaFeriado["bool_fer"];?>') onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'> 
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo impF ($fecIni);//($filaFeriado["fecha_inicio"])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo impF ($fecFin);//($filaFeriado["fecha_fin"]);?></font></td>
          <td align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $desc;//$filaFeriado["descripcion"];?></font></td>
        </tr>
        <?php } ?>
      </table>
	
		<table width="100%" border="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr>
            <td><hr width="100%" color=#0099cc></td>
          </tr>
        </table>
        
      <table width="100%" border="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr bgcolor="#48d1cc"> 
          <td align="center"> <table WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" bgcolor=white>
              <tr> 
                <td align="left"> <font face="arial, geneva, helvetica" size="1" color=black> 
                  <ul>
                    <li>Para Modificar un feriado haga click sobre la fecha en 
                      el listado.</li>
                    <li>Listado de feriados ingresados para su Instituci&oacute;n.</li>
                    <li>Para abandonar la sesión de usuario presionar "CERRAR 
                      SESION".</li>
                  </ul>
                  </font> </td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <br>
<br>

</body>
</html>
	