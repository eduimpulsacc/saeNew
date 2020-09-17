<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP           = 3;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
								  
								  
								  
								  
								  
	<?php //echo tope("../../../util/");?>
	<center>
		<table WIDTH="700" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<tr>
				<td colspan=5 align=right>
					<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarEmpleado.php3">				</td>
			</tr>
			<tr height="20" class="tableindex">
				<td align="middle" colspan="5">
					PERSONAL TOTAL DE LA INSTITUCION = 
						<?php
											$qry="SELECT COUNT(*) AS SUMA FROM TRABAJA WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila7 = @pg_fetch_array($result,0);	
													if (!$fila7){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila7['suma']);
												}
											}
										?>				</td>
			</tr>
			<tr class="tablatit2-1">
				
      <td align="center" width="268"> <div align="center">NOMBRE </div></td>
				
      <td align="center" width="150"> <div align="center">USUARIO </div></td>
				
      <td align="center" width="160"> <div align="center">CLAVE </div></td>
	  
	  <td align="center" width="160"> <div align="center">TIPOS DE ACCESO </div></td>
	  
	  
			</tr>
			<?php
			/*	$qry="SELECT DISTINCT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.telefono,empleado.telefono2,empleado.telefono3, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro, usuario.nombre_usuario, usuario.pw FROM (((empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN usuario ON trabaja.rut_emp=usuario.nombre_usuario)INNER JOIN accede ON accede.id_usuario=usuario.id_usuario)  WHERE (((trabaja.rdb)=$institucion)and accede.estado=1) order by  ape_pat, ape_mat, nombre_emp asc";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
				}else{
					if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
						$fila1 = @pg_fetch_array($result,0);	
						if (!$fila1){
							error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
							exit();
						}
					}*/
					
					
			  $qry="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.telefono,empleado.telefono2,empleado.telefono3, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM trabaja inner join empleado on trabaja.rut_emp=empleado.rut_emp WHERE (((rdb)=".$institucion.")) order by ape_pat, ape_mat, nombre_emp";
				$result =@pg_Exec($conn,$qry);
				
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
				}else{
					if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
						$fila1 = @pg_fetch_array($result,0);	
						if (!$fila1){
							error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
							exit();
						}
					}

					
					
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila1 = @pg_fetch_array($result,$i);
						
						
				$qry2="SELECT usuario.* FROM usuario inner join accede on usuario.id_usuario=accede.id_usuario where nombre_usuario='".$fila1['rut_emp']."'and accede.estado=1";
				$result2 =@pg_Exec($conn,$qry2);

				if (!$result2) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
				}else{
					if (pg_numrows($result2)!=0){//En caso de estar el arreglo vacio.
						$fila2 = @pg_fetch_array($result2,0);	
						if (!$fila2){
							error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
							exit();
						}

			?>

						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' >
					      <td align="left" onClick=go('usuario/claveAcceso.php3?empleados=<?php echo trim($fila1["rut_emp"]);?>&caso=1')> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
      					  <strong><?php echo $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"];?></strong> 
       						 </font> </td>
							
      <td align="left" onClick=go('usuario/claveAcceso.php3?empleados=<?php echo trim($fila1["rut_emp"]);?>&caso=1')> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
        <strong>
        <?php echo $fila2["nombre_usuario"];?>        </strong> </font> </td>
							<td align="left" onClick=go('usuario/claveAcceso.php3?empleados=<?php echo trim($fila1["rut_emp"]);?>&caso=1')>
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
										<?php echo $fila2["pw"];?>									</strong>								</font>							</td>
							<td align="center">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><? 
						$id_usuario = $fila2['id_usuario'];
						$qry3 = "select id_perfil from accede where id_usuario = '$id_usuario'";
						$res3 = pg_Exec($qry3);
						for($x=0;$x<pg_numrows($res3);$x++)
						{
							$id_fila = pg_fetch_array($res3,$x);
							$id_perfil = $id_fila['id_perfil'];										
							$qry4 = "select nombre_perfil from perfil where id_perfil = '$id_perfil'";
							$res4=pg_Exec($qry4);
							$nombre_p = pg_fetch_array($res4,0);							
							$nombre_perfil = $nombre_p['nombre_perfil'];
							$tot_nombre[$i] = "<option disabled='disabled'>".$nombre_perfil.$tot_nombre[$i]."</option>";						
						}	
							if(pg_numrows($res3)==1)
							{	?>
								<label><?=$tot_nombre[$i]?></label>
						<?	}else{?>
							
							<select>	
								<? echo $tot_nombre[$i];?>
							</select>						 									
						<?	}	?>									
									</strong>
								</font>							
							</td>
										
						</tr>
			<?php
			
			}
		
		}

					}
				}
			?>
			<tr>
				<td colspan="5">
				<hr width="100%" color="#0099cc">				</td>
			</tr>
		</table>
	</center>

								  
								  
								
</body>
</html>
