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
									</strong>
								</FONT>
							</TD>
                       </tr>
                     </table>
  

			
				<form method="post" name="frm1" action="listarInstituciones.php3?listar=A&pag=1">
					<center>
					<table  border="0" cellpadding="0" cellspacing="0" width=600>
						<tr>
							<td align="left" width=0>
								<table width="94%" align=center>
            <tr valign=bottom>
										<td width="8%">
											
										</td>
										<td width="13%">
										<!-----	<input type="submit" value="LISTAR" name="submit2"> ---->
                                             
										</td>
										<!------------------/filtro por RBD/-------------->
											
              <td width="65%"align=right> <!--<input name="button" type="button" onClick=document.location="seteaTipoEnse.php3?caso=2&institucion1=<?php echo $institucion ?>" value="AGREGAR TIPO DE ENSEÑANZA" ></td>-->
											<td width="14%" align=right>
											<INPUT TYPE="button" value="VOLVER" onClick=document.location="../ano/ano_escolar.php3"<? $_FRMMODO='mostrar' ?>>
						                  </td>
									<!------------------/find filtro por RBD/-------------->
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
           $qry = "SELECT * FROM tipo_ense_inst as TEI, tipo_ensenanza as TE WHERE tei.cod_tipo=te.cod_tipo and tei.rdb=".$institucion;
           $result =@pg_Exec($conn,$qry);                
                  if (@pg_numrows($result)!=0){ 
                         

	$filRBD=(trim($swrbd)=='1')?$filtroRBD:"";
	if ($filRBD!='')                
//		$qry = "SELECT * FROM tipo_ense_inst AS TEI INNER JOIN tipo_ensenanza AS TE ON TEI.cod_tipo=TE.cod_tipo WHERE TEI.rdb=$institucion ORDER BY cod_tipo LIMIT $largoPagina OFFSET $pagOffset";
//                $result =@pg_Exec($conn,$qry);                
//                 if (@pg_numrows($result)!=0){ 
                
                
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
			<td align="middle" colspan="6">
				<font face="arial, geneva, helvetica" size="2" color="#ffffff">
					<strong>LISTA DE TIPOS DE ENSEÑANZA</strong>
				</font>
			</td>
		</tr>
		<tr bgcolor="#48d1cc">
			
    <td ALIGN=CENTER WIDTH=67> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
      <strong>CODIGO</strong> </font> </td>
			<td ALIGN=CENTER WIDTH=263>
				<font face="arial, geneva, helvetica" size="1" color="#000000">
					<strong>NOMBRE TIPO DE ENSEÑANZA </strong>
				</font>
			</td>
			<td width="127" ALIGN=CENTER>
				<font face="arial, geneva, helvetica" size="1" color="#000000">
					<strong>FECHA DE RESOLUCION</strong>
				</font>
			</td>
			<td width="130" ALIGN=CENTER>
				<font face="arial, geneva, helvetica" size="1" color="#000000">
					<strong>PLAN</strong>
				</font>
			</td>
			
		</tr>
		<?php
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila = @pg_fetch_array($result,$i);
                   
		?>
		<tr VALIGN=TOP bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaTipoEnse.php3?corre=<?php echo $fila["corre"];?>&ensenanza=<?php echo trim($fila["cod_tipo"]);?>&plan=<?php echo trim($fila["cod_decreto"]);?>&caso=1&institucion1=<?php echo $institucion ?>')>

				<td align="right" >
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong><?php echo $fila["cod_tipo"];?></strong>&nbsp;&nbsp;&nbsp;
					</font>
				</td>
				<td align="left" >
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong><?php echo $fila["nombre_tipo"];?></strong>
					</font>
				</td>
				<td align="center">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>
                          
						<?php 
							 impF($fila['fecha_res']) 
						?>
						</strong>
					</font>
				</td>
				<td align="center">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>
                          
						<?php 
							 echo($fila['cod_decreto']) 
						?>
						</strong>
					</font>
				</td>
				
			</tr>
		<?php 
              
}  ?>
		<tr>
			<td colspan="6">
			<hr width="100%" color="#0099cc">
			</td>
		</tr>
		<tr height="50" bgcolor="white">
			<td align="middle" colspan="6">

				<?php 
                      
                      if($pag!=0){?>
					<a HREF="listarTiposEnsenanza.php3?pag=<?php echo ($pag-1)?>&listar=<?php echo trim($listar)?>&amp;tipoIns=<?php echo trim($tipoIns) ?>">
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
					<a HREF="listarTiposEnsenanza.php3?pag=<?php echo ($pag+1)?>&listar=<?php echo trim($listar)?>&amp;tipoIns=<?php echo trim($tipoIns) ?>">
						<font face="arial, geneva, helvetica" size="2" color="black">
							<strong>Siguientes <?php echo $largoPagina?> ...</strong>
						</font>
					</a>
				<?php }?>
			</td>
		</tr>
	</table>
	<?php }  ?>


<?php 
	//	echo "pag:".$pag."<BR>";
	//	echo "pagOffset:".$pagOffset."<BR>";
	//	echo "pg_numrows:".pg_numrows($result)."<BR>";
?>
</body>
</html>