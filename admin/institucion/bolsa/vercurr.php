<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
?>
<html>
	<head>
		<SCRIPT language="JavaScript" 
src="../../../util/chkform.js"></SCRIPT>
	</head>
<body>
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR>
				<TD COLSPAN=2>
<form method="post" action="vercurr.php?caso=1&id=<?php echo $id?>">
					<TABLE BORDER=0 CELLSPACING=1 
CELLPADDING=1>
						<TR>
							<TD align=left>
								<FONT face="arial, 
geneva, helvetica" size=2>
									
<strong>INSTITUCION</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, 
geneva, helvetica" size=2>
									<strong>
										<?php

if ($caso==1) {
$qrydel="delete from postulantes where rdb=$institucion and rut_postulante='$rut'";
@pg_Exec($conn,$qrydel);
}
											
$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											
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
													
echo trim($fila['nombre_instit']);
												
}
											
}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>

				</TD>
			</TR>
			<tr>
				<td colspan=4 align=right>
					<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ 
//ACADEMICO Y LEGAL?>
											
<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
					<INPUT TYPE="button" value="VOLVER" 
onClick=document.location="listarSolicitudes.php">
											
<?php }?>
					<?php }?>

					
				</td>
			</tr>
			<tr height="20" bgcolor="#0099cc">
				<td align="middle" colspan="4">
					<font face="arial, geneva, helvetica" 
size="2" color="#ffffff">
						<strong>POSTULANTES</strong>
					</font>
				</td>
			</tr>
			<tr bgcolor="#48d1cc">
				<td align="center" width="10">
					<font face="arial, geneva, helvetica" 
size="1" color="#000000">
						<strong></strong>
					</font>
				</td>
				<td align="center" width="400">
					<font face="arial, geneva, helvetica" 
size="1" color="#000000">
						<strong>NOMBRE</strong>
					</font>
				</td>
				<td align="center" width="100">
	<font face="arial, geneva, helvetica" size="1" color="#000000">
					</font>
<font face="arial, geneva, helvetica" 
size="1" color="#000000">
				RUT</font></td>
			<td align="center" width="100">
	<font face="arial, geneva, helvetica" size="1" color="#000000">DESCARGUE CURRICULUM</font></td>

			</tr>
			<?php
				$qry="SELECT * FROM postulantes WHERE RDB=$institucion AND id_solicitud=$id"; 
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = 
@pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR 
:</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($result) ; 
$i++){
						$fila = 
@pg_fetch_array($result,$i);


$output= "select lo_export(".$fila["curriculum"].",'/var/www/html/tmp/CURR".$fila["rut_postulante"].".doc');";
$retrieve_result = @pg_exec($conn,$output);
			?>
			<tr bgcolor=#ffffff >
			<td align="center" >
		<INPUT TYPE="radio" NAME="rut" value="<?php echo $fila["rut_postulante"] ?>">
			</td>
							<td align="center" >
								<font face="arial, 
geneva, helvetica" size="1" color="#000000">
									<strong>&nbsp&nbsp
									
<?php echo $fila["nombre"] ;?>
										
									</strong>
								</font>
							</td>
							<td align="left">
								<font face="arial, 
geneva, helvetica" size="1" color="#000000">
									
<strong><?php echo $fila["rut_postulante"];?></strong>
								</font>
							</td>
							<td align="left">
					<font face="arial, 
geneva, helvetica" size="1" color="#000000">
									
<strong><a href="../../../../tmp/<?php echo ,"CURR",$fila["rut_postulante"],".doc" ?>"><img src="word.jpg" border=0></a></strong>
								</font>
							</td>
								
						</tr>
			<?php
					}
				}
			?>
		<tr>
				<td colspan="4">
				<hr width="100%" color="#0099cc">
				</td>
			</tr>
		</table>
		<div align="left"><input type ="submit" value="Eliminar"></div>
	</form>
	</center>
</body>
</html>