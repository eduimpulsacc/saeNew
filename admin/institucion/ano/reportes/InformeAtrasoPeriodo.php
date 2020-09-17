<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?
require('../../../../util/header.inc');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$periodo		=$cmb_periodos;
	$curso   		=$cmb_curso;
	$_POSP = 4;
	$_bot = 8;
	
	if ($periodo==0){
	   ## nada
	}else{
		 
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM institucion INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion."));";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'])) . " " . $fila_institu['nro'] . " - " . strtoupper($fila_institu['nom_com']);
	$telefono = $fila_institu['telefono'];
	//----------------------------------------------------------------------------
	// AÑO ESCOLAR
	//----------------------------------------------------------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = $fila_ano['nro_ano'];
	//----------------------------------------------------------------------------
	// DATOS PERIODO
	//----------------------------------------------------------------------------
	$sql_periodo = "select * from periodo where id_periodo = ".$periodo;
	$result_periodo = @pg_Exec($conn, $sql_periodo);
	$fila_periodo = @pg_fetch_array($result_periodo,0);
	$periodo_pal = $fila_periodo['nombre_periodo'] . " DEL " . $nro_ano;
	//----------------------------------------------------------------------------
	// DATOS CURSO
	//----------------------------------------------------------------------------	
	if ($curso == 0){
		$sql_curso = "select * from curso where id_ano= ".$ano ." order by ensenanza, grado_curso, letra_curso";
		$result_curso = @pg_Exec($conn, $sql_curso);
	}
	
}	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
	function enviapag(form){
		form.action = 'InformeAtrasoPeriodo.php?institucion=$institucion';
		form.submit(true);
    }
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
									
</script>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>
						
				      </td>
                       <td width="73%" align="left" valign="top"><!-- cuerpo de la página -->
                      <? if ($curso>0){ ?>
                         
						 <table width="700" border="0" cellpadding="0" cellspacing="0">
						  <tr>
							<td width="700">
							         <div id="capa0">
									 <div align="right"> 
					                 <input name="button3" TYPE="button" class="botonXX" onClick="MM_openBrWindow('prinInformeAtrasoPeriodo.php?cmb_meses=<?=$cmb_meses ?>&cmb_curso=<?=$cmb_curso ?>&periodo=<?=$periodo ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">				  
									 </div>
							         </div>
							</td>
						  </tr>
						</table>
						 
						 
						 
                         <table width="700" align="center" border=0 cellpadding=1 cellspacing=1>
						  <tr> 
							<td width="20%" align=left> <strong><font face="arial, geneva, helvetica" size="1"> INSTITUCION 
							  </font></strong> </td>
							<td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> 
							  </font> </td>
							<td width="80%"> <font face="arial, geneva, helvetica" size="1"> <strong> 
							  <?php  
                                                                               
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
              </strong> </font> </td>
          </tr>
          <tr> 
            <td align=left> <font face="arial, geneva, helvetica" size="1"> <strong>AÑO ESCOLAR</strong> </font> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> </font> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong> 
              <?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila['nro_ano']);
												}
											}
										?>
              </strong> </font> </td>
          </tr>
          <tr> 
            <td align=left> <font face="arial, geneva, helvetica" size="1"> <strong>CURSO</strong> 
              </font> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> 
              </font> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong> 
              <?php
											$qry="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";

											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{

												$fila1 = @pg_fetch_array($result,0);	
												if (!$fila1){
													error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
													exit();
												}
												
							if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
								echo "PRIMER NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==121987) or ($fila1['cod_decreto']==1521989)) ){
								echo "PRIMER CICLO"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==1) and ($fila1['cod_decreto']==1000)){
								echo "SALA CUNA"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==2) and (($fila1['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "SEGUNDO NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==121987) ){
								echo "SEGUNDO CICLO";
							}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==1000)){
								echo "NIVEL MEDIO MENOR"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==3) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
								echo "TERCER NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==3) and ($fila1['cod_decreto']==1000)){
								echo "NIVEL MEDIO MAYOR"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==4) and ($fila1['cod_decreto']==1000)){
								echo "TRANSICIÓN 1er NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==5) and ($fila1['cod_decreto']==1000)){
								echo "TRANSICIÓN 2do NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else{
								echo $fila1['grado_curso']." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}
												
											}
										?>
              </strong> </font> </td>
          </tr>
		  
		  
		  <tr> 
            <td align=left> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> PROFESOR JEFE 
              </font> </td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> : 
              </font> </td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">  
              <?
				$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
				$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
				$result =@pg_Exec($conn,$sql4);
				if (!$result) 
				{
					//error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
				}
				else
				{
					if (pg_numrows($result)!=0)
					{
						$fila = @pg_fetch_array($result,0);	
						if (!$fila)
						{
							//error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							//exit();
						}
					}
				}
				
				echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
				//$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
				
				?>
               </font> </td>
          </tr>
		  
        </table>
		
		
		
						 <br>
                         <table width="700" border="1" align="center" cellpadding="0" cellspacing="0">	
						   <tr> 
						     <td align="center" width="10%" class="tablatit2-1">N&ordm;</td>
								  <td align="center" width="20%" class="tablatit2-1">RUT</td>
						     <td align="center" width="60%" class="tablatit2-1">NOMBRE</td>
								  <td align="center" width="10%" class="tablatit2-1">ATRASOS</td>
								</tr>
							<?php
							$qry_alu="SELECT matricula.bool_ar, alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,alumno.telefono, alumno.calle, alumno.nro, alumno.region, alumno.ciudad, alumno.comuna, matricula.id_curso FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) and bool_ar='0'  order by nro_lista asc, ape_pat, ape_mat, nombre_alu asc ";
							$result_alu =@pg_Exec($conn,$qry_alu);
							
							for($i=0 ; $i < @pg_numrows($result_alu) ; $i++){
								$fila_alu = @pg_fetch_array($result_alu,$i);
								$rut_alumno = $fila_alu['rut_alumno'];
								
								/// Aqui determinar, los atrasos por periodo o anual
								if ($periodo>0){
								     
								     $sql_atraso = "select count(id_anotacion) as anotacion from anotacion where id_periodo = '$periodo' and rut_alumno = '$rut_alumno'";				
								}else{
								     $sql_atraso = "select count(id_anotacion) as anotacion from anotacion where  rut_alumno = '$rut_alumno'";
								}								
								$res_atraso = @pg_Exec($conn,$sql_atraso);
								$fil_atraso = @pg_fetch_array($res_atraso,0);
								$num_atraso = $fil_atraso['anotacion'];
								?>
							 <tr>
							   <td align="left" ><font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? echo $i+1; ?></font> </td>
								<td align="left" ><font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<?php echo $fila_alu["rut_alumno"]."-".$fila_alu["dig_rut"] ?></font> </td>
							   <td align="left" ><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>&nbsp;&nbsp;<?php echo $fila_alu["ape_pat"]." ".$fila_alu["ape_mat"].", ".$fila_alu["nombre_alu"]; ?></strong> </font></td>
								<td align="left" ><font face="arial, geneva, helvetica" size="1" color="#000000"><div align="right">&nbsp;<?=$num_atraso ?></div></font></td>
								</tr>
								<?
							}
							?>					
					     </table>					   
					   
					   <? } ?>
					   <!-- fin cuerpo -->
					   
					   
					   <!-- BUSCADOR AVANZADO -->
					   <form name="form1" method="post" action="">
                        
                         <table width="100%" height="43" border="0" cellpadding="0" cellspacing="0">
						  <tr>
							<td width="" class="tableindex">Buscador Avanzado </td>
						  </tr>
						  <tr>
							<td height="27">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="61" class="textosimple">Periodo</td>
								<td width="219">
								<select name="cmb_periodos" class="ddlb_9_x" onChange="enviapag(this.form);">
								<option value=0 selected>(ANUAL)</option>
								<?
								//// tomo todos los peridos ///
								// DATOS PERIODO
								//----------------------------------------------------------------------------
								$sql_periodo = "select * from periodo where id_ano = ".$_ANO;
								$result_per = @pg_Exec($conn, $sql_periodo);
								
								for($i=0 ; $i < @pg_numrows($result_per) ; $i++){
								  $fila = @pg_fetch_array($result_per,$i); 
								  if ($fila['id_periodo']==$cmb_periodos)
									  echo  "<option selected value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
								  else
									  echo  "<option value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
								  ?>
								<?
								} ?>
								</select></td>       
							</tr>
							<tr>
							  <td class="textosimple">Cursos</td>
							  <td>
							  
							  <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
								  <option value=0 selected>(Seleccione Curso)</option>
								  <?
								  $sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
								  $sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
								  $sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$_ANO.")) ";
								  $sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
								  $resultado_query_cue = pg_exec($conn,$sql_curso);
								  
								  
								  
								  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
								  {
									  $fila = @pg_fetch_array($resultado_query_cue,$i); 
									  if ($fila["id_curso"]==$cmb_curso){
											$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
											echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
									  }else{
											$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
											echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
									  }
								  } ?>
							</select>
							</td>
							  </tr>
						   </table>
						
							</td>
						   </tr>
						</table>	
						</form>				   
					   <!-- FIN BUSCADOR AVANZADO -->					   
					   
					   </td></tr>
                       <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<? pg_close($conn);?>
</body>
</html>
