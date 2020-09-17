<?php 
	require('../../../util/header.inc');
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
   
    
	$largoPagina=40;
	$pagOffset=$largoPagina*($pag-1);
?>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmbPLAN.value!=0){
				form.cmbPLAN.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'PlanIndica.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			
</script>

<html>
	<head>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		
		<SCRIPT language="JavaScript">
		
		
		
			function valida(form){
				if(!chkVacio(form.txtGRA,'Ingresar GRADO del curso.')){
					return false;
				};
				if(!nroOnly(form.txtGRA,'Se permiten sólo números para el GRADO del curso.')){
					return false;
				};
				//if(!chkVacio(form.txtLETRA,'Ingresar LETRA del curso.')){
				//	return false;
				//};
				//if(!letraOnly(form.txtLETRA,'Se permiten sólo letras para la LETRA del curso.')){
				//	return false;
				//};
				if(!chkSelect(form.cmbENS,'Seleccionar TIPO DE ENSEÑANZA del curso.')){
					return false;
				};

				if(!form.cmbPLAN.disabled){
					if(!chkSelect(form.cmbPLAN,'Seleccionar DECRETO DE PLAN DE ESTUDIO del curso.')){
						return false;
					};
				};
				if(!form.cmbEVAL.disabled){
					if(!chkSelect(form.cmbEVAL,'Seleccionar DECRETO DE EVALUACION del curso.')){
						return false;
					};
				};

				if(!chkSelect(form.cmbSUP,'Seleccionar SUPERVISOR del curso.')){
					return false;
				};
				//VALIDACION TIPO DE ENSEÑANZA
				/*if(form.cmbENS.value==110){
					if(form.txtGRA.value>8){
						alert('TIPO DE ENSENANZA no corresponde al grado del curso.');
						return false;
					}
				}else{
					if(form.txtGRA.value>5){
						alert('TIPO DE ENSENANZA no corresponde al grado del curso.');
						return false;
					};
				};*/
				//FIN VALIDACION TPO DE ENSEÑANZA
				if(!chkFecha(form.txtFECHARES,'Fecha inválida.')){
					        return false;
				        };
				return true;
			}
		</SCRIPT>
	</head>
<body>
	<form method="post" name="frm" action="procesoPlanEstudio.php3">
	<?php echo tope("../../../util/");?>
                        <table border="0" cellpadding="0" cellspacing="0" width=600  align="center">
                         <tr>
                            <TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>INSTITUCION</strong>
								</FONT>
							</TD>
							<TD width="1%">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD width="85%">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result){
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
                       </tr>
                     </table>
					<center>
					<table  border="0" cellpadding="0" cellspacing="0" width=600>
						<tr>
							<td align="left" width=0>
								<table width="99%" align=center>
            					<tr valign=bottom>
										
              <td width="17%" height="26"> </td>
										<td width="69%"align=right>
									 <INPUT TYPE="submit" value="GUARDAR" onClick=document.location="return valida(this.form);">
										</td>
             			 				<td width="14%" align=right>
			  						<INPUT TYPE="button" value="VOLVER" onClick=document.location="listarPlanesEstudio.php3"> </td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							
        <td align="center" colspan="2">&nbsp; </td>
						</tr>
					</table>
					</center>
				
<?php
           
			
	if($frmModo=="mostrar"){
	   
		$qry="SELECT DISTINCT plan_estudio.* FROM plan_estudio  WHERE ((plan_estudio.cod_decreto)=".$plan.") ORDER BY cursos";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>');
					exit();
				};
			};
		};
	};
?>

	<table border="0" cellpadding="1" cellspacing="1" bgcolor="white" WIDTH=600 align=center>
		<tr>
			<td colspan=6>
				<table width="100%" cellpadding="0" cellspacing="0" >
					<tr>
												
					</tr>
                        
				</table>
			</td>
		</tr>
		<tr height="20" bgcolor="#0099cc">
			
    <td colspan="6"> <font face="arial, geneva, helvetica" size="2" color="#ffffff"> 
      <strong> PLAN DE ESTUDIO</strong> </font> </td>
		</tr>
		
			
    <td ALIGN=CENTER WIDTH=187> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
      <strong>DECRETO DE PLAN DE ESTUDIO</strong> </font> </td>
			
    <td width="231" ALIGN=CENTER> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
      <strong>CODIGO DE DECRETO</strong></font> </td>
			 
    <td width="231" ALIGN=CENTER> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
      <strong>DESCRIPCION</strong> </font> </td>
 		</tr>
				
    
			<td align="center"> 
				<?php if($frmModo=="mostrar"){ ?>
				<?php } ?>
				<?php if($frmModo=="ingresar1"){ ?>
					<select name="cmbPLAN" onChange="enviapag(this.form);">
					<option value=0 selected>Selecione Plan de Estudio</option>
				<?php
					$qry="select * from plan_estudio where rdb=0"; 
					$result =@pg_Exec($conn,$qry);
					$fila= @pg_fetch_array($result,0);
						for($i=0 ; $i < @pg_numrows($result) ; $i++){
										$fila = @pg_fetch_array($result,$i);
											if ($fila["cod_decreto"]==$cmbPLAN){
												echo  "<option selected value=".$fila["cod_decreto"]." >".$fila["nombre_decreto"]."</option>";
											}else{
												echo  "<option value=".$fila["cod_decreto"]." >".$fila["nombre_decreto"]."</option>";
											}
														
									}?>
					
					</select>
						<?php };?>	
			</td>
			
			 
      <td align="center"> 
        <?php if($frmModo=="mostrar"){ ?>
        <? } ?>
        <?php if($frmModo=="ingresar1"){
	  $qry="select * from plan_estudio where cod_decreto=".$cmbPLAN;
		$result =@pg_Exec($conn,$qry);
		$fila= @pg_fetch_array($result,0);?>
	   <font size="2" face="Arial, Helvetica, sans-serif"> <?php echo $fila["cod_decreto"];?></font>
       <?php } ?>
      </td>
				<td align="center">
				<?php if($frmModo=="mostrar"){ ?>
				<? } ?>
				<?php if($frmModo=="ingresar1"){ ?>
		<font size="2" face="Arial, Helvetica, sans-serif"><?php echo $fila["cursos"];?></font>
				 <?PHP }?>
				</td>
			</tr>
			
		
		<tr>
			<td colspan="6">
			<br>
			
			</td>
		</tr>

		 <tr>
			<td colspan="6">
			<hr width="100%" color="#0099cc">
			</td>
		</tr>
		<tr height="50" bgcolor="white">
			
    <td align="middle" colspan="6">&nbsp; </td>
		</tr>
		   
	</table>
</form>
</body>
</html>