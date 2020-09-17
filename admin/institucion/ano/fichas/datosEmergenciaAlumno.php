<?php require('../../../../util/header.inc');?>
<?php 	
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	//$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$institucion	=$_INSTIT;
	//$apoderado		=$_APODERADO;
	$pago			=$_PAGOS;
?>
<html>
<head>
<title>Contacto Alumno</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../Sea/estilos.css" rel="stylesheet" type="text/css">
</head>

<body >
<table width="100%" border="0" align="center">
  <tr> 
    <td><table width="100%" border="0">
        <tr> 
          <td class="tableindex">DATOS 
            ALUMNO</td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td>
	<?php
		$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO='".trim($alumno)."'";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}
		}
	 ?>
	</td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="16%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Rut:</strong></font></td>
			  <td width="29%"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $fila['rut_alumno']."-".$fila['dig_rut']; ?>&nbsp;</font></td>
          <td width="16%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Fec. 
            de Nac.:</strong></font></td>
          <td width="39%"><font size="2" face="Arial, Helvetica, sans-serif"><?php impF($fila['fecha_nac']); ?>&nbsp;</font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="16%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Nombre:</strong></font></td>
          <td width="84%"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo ($fila['nombre_alu']." ".$fila['ape_pat']." ".$fila['ape_mat']); ?>&nbsp;</font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="16%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Direcci&oacute;n:</strong></font></td>
          <td width="84%"> <font size="2" face="Arial, Helvetica, sans-serif"> 
            <?php imp($fila['calle']); ?>
            </font> <font size="2" face="Arial, Helvetica, sans-serif"> 
            <?php imp($fila['nro']);?>
            &nbsp;&nbsp;<strong>Depto:</strong>&nbsp; </font> <font size="2" face="Arial, Helvetica, sans-serif"> 
            <?php imp($fila['depto']);?>
            &nbsp;&nbsp;<strong>Block:</strong> </font> <font size="2" face="Arial, Helvetica, sans-serif"> 
            <?php imp($fila['block']);?>
            &nbsp;&nbsp;<strong>Villa/Pob:</strong></font> <font size="2" face="Arial, Helvetica, sans-serif"> 
            <?php imp($fila['villa']);?>
            </font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="16%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Telefono:</strong></font></td>
          <td width="84%"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $fila['telefono'];?>&nbsp;</font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td><hr color="003b85"></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr>
          <td>&nbsp; </td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td class="tableindex">APODERADO</td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td>
            <?php
				$qry1="SELECT tiene2.responsable, apoderado.relacion, apoderado.calle, apoderado.nro, apoderado.depto, apoderado.block, apoderado.villa, apoderado.telefono, apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, apoderado.rut_apo, apoderado.dig_rut FROM (alumno INNER JOIN tiene2 ON alumno.rut_alumno = tiene2.rut_alumno) INNER JOIN apoderado ON tiene2.rut_apo = apoderado.rut_apo WHERE (((alumno.rut_alumno)='".trim($alumno)."'));";
				$result1 =@pg_Exec($conn,$qry1);
				if (!$result1) {
					error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
				}else{
				if (pg_numrows($result1)!=0){//En caso de estar el arreglo vacio.
					$fila1 = @pg_fetch_array($result1,0);	
					if (!$fila1){
						echo "NO HAY APODERADOS REGISTRADOS PARA ESTE ALUMNO";
						exit();
					}
				}
			}
			?>
          </td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="16%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Rut:</strong></font></td>
          <td width="84%"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo ($fila1['rut_apo']."-".$fila1['dig_rut']) ?>&nbsp;</font></td>
        </tr>
      </table> 
      <table width="100%" border="0">
        <tr> 
          <td width="16%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Nombre:</strong></font></td>
          <td width="84%"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo ($fila1['nombre_apo']." ".$fila1['ape_pat']." ".$fila1['ape_mat'])?></font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="16%" height="20"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Direccion:</strong></font></td>
          <td width="84%"> <font face="Arial, Helvetica, sans-serif"> <font size="2" face="Arial, Helvetica, sans-serif"> 
            <?php imp($fila1['calle']) ?>
            &nbsp;&nbsp; </font> <font size="2" face="Arial, Helvetica, sans-serif"> 
            <?php imp($fila1['nro'])?>
            &nbsp;&nbsp;<strong>Depto:</strong>&nbsp; </font> <font size="2" face="Arial, Helvetica, sans-serif"> 
            <?php imp($fila1['depto'])?>
            &nbsp;&nbsp;<strong>Block:</strong> </font> <font size="2" face="Arial, Helvetica, sans-serif"> 
            <?php imp($fila1['block'])?>
            &nbsp;&nbsp;<strong>Villa/Pob:</strong> </font> <font size="2" face="Arial, Helvetica, sans-serif"> 
            <?php imp($fila1['villa'])?>
            </font> &nbsp;</font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="16%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Telefono:</strong></font></td>
          <td width="84%"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $fila1['telefono'];?>&nbsp;</font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td><hr color="003b85"></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
