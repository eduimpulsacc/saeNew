
<?php require('../../../../util/header.inc');?>

<?
	//---------------
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$_POSP = 4;
	$ano			=$_ANO;
	//----------------
?>
<html>
<head>
<title>Respaldo de Notas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../estilos.css" rel="stylesheet" type="text/css">
</head>
<body >
<center>
<table width="650" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td height="71">
        <div align="right">
          <INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="../Menu_Respaldo.php">
      </div></td>
    </tr>
</table>
  <table width="650" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
	    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableindex">
         <tr> 
           <td>Respaldo de Notas desde Colegio Electrónico</td>
         </tr>
        </table>  
	  </td>
    </tr>
  </table>
  

<?
	$sqlCursos ="select * from curso where id_ano = $ano and ensenanza > 109 order by ensenanza, grado_curso, letra_curso";

	$rsCurso =@pg_Exec($conn,$sqlCursos);
	for($i=0 ; $i < @pg_numrows($rsCurso) ; $i++)
	{	
		//---------------
		$fCurso = @pg_fetch_array($rsCurso,$i);
		$curso = $fCurso['id_curso'];
		$Curso_pal = CursoPalabra($curso, 0, $conn);		
		?>
		<table width="650" border="0" cellspacing="1" cellpadding="3">
		  <tr>
			<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $Curso_pal;?></strong></font></td>
		  </tr>
		  <?
			$sqlPeri = "select * from periodo where id_ano = $ano order by id_periodo";
			$rsPeri =@pg_Exec($conn,$sqlPeri);
			for($o=0 ; $o < @pg_numrows($rsPeri) ; $o++)
			{	
				//---------------
				$fPeri = @pg_fetch_array($rsPeri,$o);	
				$periodo = $fPeri['id_periodo'];
				$nombre_periodo = $fPeri['nombre_periodo'];
			?>
		  <tr>
			<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong><blockquote><? echo $nombre_periodo;?></blockquote></strong></font></td>
		  </tr>	
<?
		$sqlSub = "select * from subsector_ramo where id_curso = $curso order by id_orden";
		$rsSub =@pg_Exec($conn,$sqlSub);
		for($e=0 ; $e < @pg_numrows($rsSub) ; $e++)
		{	
			//---------------
			$fSub = @pg_fetch_array($rsSub,$e);			
			$ramo = $fSub['id_ramo'];
			$subsector = $fSub['nombre'];
		?>		  		  
		  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=window.open("RespaldoNotas.php?id_periodo=<? echo $periodo?>&id_curso=<? echo $curso?>&id_ramo=<? echo $ramo?>","","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=650,height=400,top=85,left=140")>
			<td >
			<font face="Arial, Helvetica, sans-serif" size="-1"><blockquote><blockquote>- <? echo $subsector;?></blockquote></blockquote></font>
			</td>

		  </tr>
		<? } } ?>		  
</table>

		<?
		
	}
	//---------------	

?>


</center>
</body>
</html>
