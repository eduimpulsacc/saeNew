<?php 
	require('../../../util/header.inc');
	$institucion	=$_INSTIT;
    
	$largoPagina=40;
	$pagOffset=$largoPagina*($pag-1);
?>
<html>
	<head>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
	</head>
<body>
	<?php echo tope("../../../util/");?>
                        
<table border="0" cellpadding="0" cellspacing="0" width=578  align="center">
  <tr> 
    <TD width="17%" align=left> <FONT face="arial, geneva, helvetica" size=2> 
      <strong>INSTITUCION</strong> </FONT> </TD>
    <TD width="2%"> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
      </FONT> </TD>
    <TD width="81%"> <FONT face="arial, geneva, helvetica" size=2> <strong> 
      <?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
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
     					 </strong> </FONT> </TD>
  					</tr>
				</table>
                 <br>
				 <br>
			
				<form method="post" name="frm1" action="../atributos/listarInstituciones.php3?listar=A&pag=1">
					<center>
					
    <table  border="0" cellpadding="0" cellspacing="0" width=580>
      <tr>
							<td align="left" width=590>
								<table width="557" align=center>
            <tr valign=bottom>
									    <tr>
										 
              <td width="62%"><font face="arial, geneva, helvetica" size="2" color="#000000">
					                       <strong>AGREGAR PLAN DE ESTUDIO :</strong>
				                         </font> </td>
              <td width="20%">&nbsp; </td>
										<td width="40%" align="center">
										
 										</td>
										</tr>
										<td width="22%"><INPUT TYPE="button" value="INDICATIVO" onClick=document.location="seteaPlanIndica.php3?caso=2&institucion1=<?php echo $institucion ?>" >&nbsp;&nbsp;
											<INPUT TYPE="button" value="PROPIO" onClick=document.location="seteacreaPlanEstudio.php3?&caso=2&institucion1=<?php echo $institucion ?>" >
										</td>
										
              <td width="20%"> </td>
										 <!------------------/filtro por RBD/-------------->
											<td width="70%" align=RIGHT>
							                
						                  </td>
									     <!------------------/find filtro por RBD/-------------->
									       <td width="15%" align=RIGHT><INPUT TYPE="button" value="VOLVER" onClick=document.location="../ano/ano_escolar.php3?<? $_FRMMODO='mostrar' ?>">
							                
						                  </td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							
        <td align="center" colspan="2">&nbsp; </td>
						</tr>
					</table>
					</center>
				</form>
<?php
  		$qry = "SELECT DISTINCT plan_estudio.* from plan_estudio, plan_inst where plan_estudio.cod_decreto = plan_inst.cod_decreto and plan_estudio.rdb=".$institucion;			
             $result =@pg_Exec($conn,$qry);                
	            $filRBD=(trim($swrbd)=='1')?$filtroRBD:"";
	                if ($filRBD!='')                
	?>
	
	<table border="0" cellpadding="1" cellspacing="1" bgcolor="white" WIDTH=600 align=center>
		
		<tr height="20" bgcolor="#0099cc">
			
    <td align="middle" colspan="6"> <font face="arial, geneva, helvetica" size="2" color="#ffffff"> 
      <strong>PLANES DE ESTUDIO PROPIOS</strong> </font> </td>
		</tr>
		<tr bgcolor="#48d1cc">
			
    
			
    <td ALIGN=CENTER WIDTH=187> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
      <strong>RESOLUCION</strong> </font> </td>
			<td width="231" ALIGN=CENTER>
				<font face="arial, geneva, helvetica" size="1" color="#000000">
					<strong>DESCRIPCION</strong>
				</font>
			</td>
 		</tr>
		<?php
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila = @pg_fetch_array($result,$i);
                   
		?>
		<tr VALIGN=TOP bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('PlanEstudio.php3?plan=<?php echo trim($fila["cod_decreto"]);?>&caso=1&institucion1=<?php echo $institucion ?>')>
				<td align="center" >
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong><?php echo $fila["nombre_decreto"];?></strong>
					</font>
				</td>
				<td align="center">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>
						<?php 
							 echo($fila['cursos']) 
						?>
						</strong>
					</font>
				</td>
			</tr>
		<?php 
		}  
	 ?>
<TR>
<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
<?php // } ?>
</TR>
	<tr height="20" bgcolor="#0099cc">
			<td align="middle" colspan="6">
				<font face="arial, geneva, helvetica" size="2" color="#ffffff">
					<strong>PLANES DE ESTUDIO <font face="arial, geneva, helvetica" size="2" color="#ffffff"><strong>INDICATIVOS</strong></font></strong>
				</font>
			</td>
		</tr>
		<tr bgcolor="#48d1cc">
	<?php		
    $qry2="SELECT DISTINCT plan_estudio.* FROM (plan_estudio INNER JOIN plan_inst ON plan_estudio.cod_decreto = plan_inst.cod_decreto) WHERE (plan_inst.rdb=".$institucion." and plan_estudio.rdb=0) ORDER BY nombre_decreto";
	  $result2 =@pg_Exec($conn,$qry2);                
          if (@pg_numrows($result2)!=0){ 
	?>		
    <td ALIGN=CENTER WIDTH=187> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
      <strong>RESOLUCION</strong> </font> </td>
			<td width="231" ALIGN=CENTER>
				<font face="arial, geneva, helvetica" size="1" color="#000000">
					<strong>DESCRIPCION</strong>
				</font>
			</td>
 		</tr>
		<?php
			for($i=0 ; $i < @pg_numrows($result2) ; $i++){
				$fila2 = @pg_fetch_array($result2,$i);
                   
		?>
		<tr VALIGN=TOP bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('PlanEstudio.php3?plan=<?php echo trim($fila2["cod_decreto"]);?>&caso=1&institucion1=<?php echo $institucion ?>')>

				
				<td align="center" >
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong><?php echo $fila2["nombre_decreto"];?></strong>
					</font>
				</td>
				<td align="center">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>
						<?php 
							 echo($fila2['cursos']) 
						?>
							</strong>
						</font>
					</td>
				</tr>
				<?php 
              
		} 
		} ?>
		<tr>
			<td colspan="6">
			<hr width="100%" color="#0099cc">
			</td>
		</tr>
		<tr height="50" bgcolor="white">
			<td align="middle" colspan="6">

				<?php 
                      
                      if($pag!=0){?>
					<a HREF="../atributos/listarTiposEnsenanza.php3?pag=<?php echo ($pag-1)?>&listar=<?php echo trim($listar)?>&tipoIns=<?php echo trim($tipoIns) ?>">
						<font face="arial, geneva, helvetica" size="2" color="black">
							<strong>Anteriores <?php echo $largoPagina?> ...</strong>
						</font>
					</a>
					<?php if(pg_numrows($result)==$largoPagina){?>
						&nbsp;&nbsp;&nbsp;
						<font face="arial, geneva, helvetica" size="5" color="black">
							<strong>-</strong>
						</font>
						&nbsp;&nbsp;&nbsp;
					<?php }?>

				<?php }?>
				<?php if(pg_numrows($result)==$largoPagina){?>
					<a HREF="../atributos/listarTiposEnsenanza.php3?pag=<?php echo ($pag+1)?>&listar=<?php echo trim($listar)?>&tipoIns=<?php echo trim($tipoIns) ?>">
						<font face="arial, geneva, helvetica" size="2" color="black">
							<strong>Siguientes <?php echo $largoPagina?> ...</strong>
						</font>
					</a>
				<?php }?>
			</td>
		</tr>
	</table>
	


</body>
</html>