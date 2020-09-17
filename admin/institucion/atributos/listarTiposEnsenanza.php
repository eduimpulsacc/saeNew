<?php 
	require('../../../util/header.inc');
	$institucion	=$_INSTIT;
    
	$largoPagina=40;
	$pagOffset=$largoPagina*($pag-1);
?>
<html>
	<head>
	
				<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>

		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
	
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../../../menu/adm/imag/fondomain.gif);
	margin-left: 75px;
}
-->
</style></head>

<body topmargin="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<!--table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../ano/periodo/listarPeriodo.php3"><img src="../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../ano/feriado/listaFeriado.php3"><img src="../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../planEstudio/listarPlanesEstudio.php3"><img src="../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../botones/tipos_roll.gif" name="Image5" width="81" height="30" border="0" id="Image5" ></a></td>
          <td width="81" height="30"><a href="../ano/curso/listarCursos.php3"><img src="../botones/cursos.gif" name="Image6" width="81" height="30" border="0" id="Image6" onMouseOver="MM_swapImage('Image6','','../botones/cursos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../ano/matricula/listarMatricula.php3"><img src="../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../ano/ActasMatricula/Menu_Actas.php?botonera=1"><img src="../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="#"><img src="../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table -->


	<?php echo //tope("../../../util/");?>
                        <table border="0" cellpadding="0" cellspacing="0" width=600  >
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
  

			
				<form method="post" name="frm1" action="listarInstituciones.php?listar=A&pag=1">
					
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
											<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="../ano/ano_escolar.php"<? $_FRMMODO='mostrar' ?>>
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
	
	

	<table border="0" cellpadding="1" cellspacing="1" bgcolor="white" WIDTH=600 >
		<tr>
			<td colspan=6>
				<table width="100%" cellpadding="0" cellspacing="0" >
					<tr>
												
					</tr>
                        
				</table>
			</td>
		</tr>
		<tr height="20" bgcolor="#003b85">
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
		<tr VALIGN=TOP bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaTipoEnse.php?corre=<?php echo $fila["corre"];?>&ensenanza=<?php echo trim($fila["cod_tipo"]);?>&plan=<?php echo trim($fila["cod_decreto"]);?>&caso=1&institucion1=<?php echo $institucion ?>')>

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
				<td align="left">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>
                          
						<?php 
							 impF($fila['fecha_res']) 
						?>
						</strong>
					</font>
				</td>
				<td align="left">
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
			<hr width="100%" color="#003b85">
			</td>
		</tr>
		<tr height="50" bgcolor="white">
			<td align="middle" colspan="6">

				<?php 
                      
                      if($pag!=0){?>
					<a HREF="listarTiposEnsenanza.php?pag=<?php echo ($pag-1)?>&listar=<?php echo trim($listar)?>&amp;tipoIns=<?php echo trim($tipoIns) ?>">
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
					<a HREF="listarTiposEnsenanza.php?pag=<?php echo ($pag+1)?>&listar=<?php echo trim($listar)?>&amp;tipoIns=<?php echo trim($tipoIns) ?>">
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