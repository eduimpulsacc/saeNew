<?php require('../../../../../../util/header.inc');



	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
 	$ramo			=$_RAMO;
	$frmModo		=$_FRMMODO;
	$docente		=5; //Codigo Docente
	$_POSP          =6;
	$_bot           = 5;
//	$_MDINAMICO = 1;
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
		
	if($frmModo=="modificar"){
		$cmbPERIODO	= $_PERIODO;
	}
	if($frmModo=="mostrar" AND $_PERIODO!=""){
		$cmbPERIODO	= $_PERIODO;
	}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

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

			
				function round(number,X) {
					// rounds number to X decimal places, defaults to 2
					X = (!X ? 0 : X);
					return Math.round(number*Math.pow(10,X))/Math.pow(10,X);
				}	

//-->

function enviapag(form){
if (form.cmbPERIODO.value!=0){
	form.cmbPERIODO.target="self";
	form.action = 'examen.php?cmbPERIODO='+ form.cmbPERIODO.value;
	form.submit(true);
	}
}
</script>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
<script language="javascript" >
function validaNota(box){
	if(box.value.length==0)	
		return true; // acepta longitud 0
	if(!notaNroOnly(box,'Nota inválida.')) 
		return false;	
	return true;
} 
function valida(form){
	var el = document.forms[0].elements;
	for (var zz=7;zz<el.length;zz++){ 
		if(el[zz].type == "radio"){	
			alert(el[zz].value);
		}
	/*	if(!validaNota(document.form.elements[zz])){
			alert('NOOOO');
		}else{
			alert(document.form.elements[zz].value);
			alert('ok');
		}*/
	}
}


</script>
</head>


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../../cabecera/menu_superior.php"); ?>
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <? $menu_lateral="3_1";?> 
                        <? include("../../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top">
						<!--codigo antiguo inicio-->
								<form name="form" action="procesaExamen.php" method="post">
									<input type="hidden" name="ramo" value="<?=$ramo;?>">
									<input type="hidden" name="curso" value="<?=$curso;?>">
									<input type="hidden" name="ano" value="<?=$ano;?>">
								  <table width="100%" border="0">
								  <tr>
									<td><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
                                            <TR>
                                              <TD align=left><FONT face="arial, geneva, helvetica" size=2> <strong>A&Ntilde;O ESCOLAR</strong> </FONT> </TD>
                                              <TD><FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>
                                              <TD><FONT face="arial, geneva, helvetica" size=2> <strong>
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
												}
											}
										?>
                                              </strong> </FONT> </TD>
                                            </TR>
                                            <TR>
                                              <TD align=left><FONT face="arial, geneva, helvetica" size=2> <strong>CURSO</strong> </FONT> </TD>
                                              <TD><FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>
                                              <TD><FONT face="arial, geneva, helvetica" size=2> <strong>
                                                <?php
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>'.$qry);
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
												}
											}
											
										?>
                                              </strong> </FONT> </TD>
                                            </TR>
                                            <TR>
                                              <TD align=left><font face="arial, geneva, helvetica" size=2><strong>PLAN DE ESTUDIO</strong></font></TD>
                                              <TD align=left><font face="arial, geneva, helvetica" size=2><strong>:</strong></font></TD>
                                              <TD align=left><font face="arial, geneva, helvetica" size=2><strong>
                                                <?php
														$qry4="SELECT curso.truncado_per, curso.id_curso,curso.cod_decreto, plan_estudio.nombre_decreto FROM curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto WHERE (((curso.id_curso)=".$curso."))";
										$result4 =@pg_Exec($conn,$qry4);
										$fila4= @pg_fetch_array($result4,0);
										echo trim($fila4['nombre_decreto']);
										$truncado_per = $fila4['truncado_per'];
										
									?>
                                              </strong></font></TD>
                                            </TR>
                                            <TR>
                                              <TD align=left><strong><FONT face="arial, geneva, helvetica" size=2>SUBSECTOR</FONT> </strong></TD>
                                              <TD align=left><strong><FONT face="arial, geneva, helvetica" size=2>: </FONT> </strong></TD>
                                              <TD align=left><strong>
                                                <?php
											$qry="SELECT subsector.nombre, ramo.conex, ramo.porc_examen FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$result =@pg_Exec($conn,$qry);
											if (@pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);
												$exim = $fila1['nota_exim'];
												$porc_examen = $fila1['porc_examen'];
												echo trim($fila1['nombre']);
												if($pct_examen!="0"){
													$examen = 1;	
												}
											}
			?>
                                              </strong> </TD>
                                            </TR>
                                        </TABLE></td>
								  </tr>
								  <tr>
									<td><table width="100%" border="0">
                                      <tr>
                                        <td><div align="right">
										<? if($frmModo=="modificar"){?>
                                          <INPUT class="botonXX"  TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form);">
                                          <INPUT class="botonXX"  name="button3" TYPE="button" onClick=document.location="seteaExamen.php?caso=1&id_ramo=<? echo $_RAMO;?>" value="CANCELAR">
										  <? } ?>
                                        </div></td>
                                        <td> <div align="right">
                                          <? if($frmModo=="mostrar"){?>
										  <input class="botonXX"  name="button1" type="button" onClick=document.location="seteaExamen.php?caso=3&cmbPERIODO=<? echo $cmbPERIODO;?>" value="MODIFICAR">
                                          <input class="botonXX" name="button32" type="button" onClick=document.location="../listarRamos.php3" value="VOLVER">
										  <? } ?>
                                        </div></td>
                                      </tr>
                                    </table></td>
								  </tr>
								  <tr>
									<td><table width="100%" border="0">
                                      <tr>
                                        <td colspan="4" class="nombre_campo"><div align="center">EXAMENES</div></td>
                                      </tr>
                                      <tr>
                                        <td colspan="4"><div align="center">
										<? if($frmModo=="mostrar"){?>
                                          <select name="cmbPERIODO" onChange="enviapag(this.form)" class="imput">
										  	<option value="0">Seleccione Periodo</option>
                                            <?php
										$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano."))  order by id_periodo";
										$result =@pg_Exec($conn,$qry);
										if (!$result) 
											error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
										else{
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												if (!$fila1){
													error('<B> ERROR :</b>Error al acceder a la BD. (84)</B>');
													exit();
												};
												for($i=0 ; $i < @pg_numrows($result) ; $i++){
													$fila1 = @pg_fetch_array($result,$i);
													if($fila1['id_periodo']==$cmbPERIODO){
														echo  "<option value=".$fila1["id_periodo"]." selected>".$fila1["nombre_periodo"]."</option>";
													}else{
														echo  "<option value=".$fila1["id_periodo"].">".$fila1["nombre_periodo"]."</option>";
													}
												}
											}
										};
									?>
                                          </Select>
										  <? } 
										  		if($frmModo=="modificar"){?>
												   <select name="cmbPERIODO" onChange="enviapag(this.form)" class="imput">
										  	<option value="0">Seleccione Periodo</option>
                                            <?php
										$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano."))  order by id_periodo";
										$result =@pg_Exec($conn,$qry);
										if (!$result) 
											error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
										else{
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												if (!$fila1){
													error('<B> ERROR :</b>Error al acceder a la BD. (84)</B>');
													exit();
												};
												for($i=0 ; $i < @pg_numrows($result) ; $i++){
													$fila1 = @pg_fetch_array($result,$i);
													if($fila1['id_periodo']==$cmbPERIODO){
														echo  "<option value=".$fila1["id_periodo"]." selected>".$fila1["nombre_periodo"]."</option>";
													}else{
														echo  "<option value=".$fila1["id_periodo"].">".$fila1["nombre_periodo"]."</option>";
													}
												}
											}
										};
									?>
                                          </Select>
												
												
											<? } ?>
                                        </div></td>
                                      </tr>
                                      
                                      <tr class="fondo">
                                        <td>ALUMNOS</td>
                                        <td>PROMEDIO</td>
										<? 	$sql = "SELECT * FROM examen_semestral WHERE id_curso=".$curso." AND id_ramo=".$ramo;
											$rs_curso = @pg_exec($conn,$sql);
											
											for($i=0;$i<@pg_numrows($rs_curso);$i++){
												$fila_ex=@pg_fetch_array($rs_curso,$i);
										?>
                                        <td><?=strtoupper($fila_ex['nombre']);?></td>
										<? } ?>
                                        <td>PROMEDIO <br>
                                          FINAL</td>
                                      </tr>
									  <? if($cmbPERIODO!=0){
									  		 $qry="SELECT matricula.rut_alumno, matricula.bool_ar, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso, matricula.nro_lista "; 
											$qry = $qry . " FROM alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno ";
											$qry = $qry . " INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno ";
											$qry = $qry . " WHERE tiene$nro_ano.id_ramo=".$ramo." AND matricula.id_ano=".$ano." ";
											$qry = $qry . " ORDER BY  nro_lista, ape_pat, ape_mat, nombre_alu, rut_alumno asc ";
											$result =@pg_exec($conn,$qry);
										
										for($j=0;$j<@pg_numrows($result);$j++){
											$SumaExamen=0;
											$PromPeriodo=0;
											$fila_alu = @pg_fetch_array($result,$j);?>
											<input name="rut<?=$j;?>" type="hidden" value="<?=$fila_alu['rut_alumno'];?>">
										
											<? 
											$sql = "SELECT promedio FROM notas$nro_ano WHERE rut_alumno=".$fila_alu['rut_alumno']." AND id_ramo=".$ramo." AND  id_periodo=".$cmbPERIODO."";
											$rs_notas = @pg_exec($conn,$sql);
											$Promedio =@pg_result($rs_notas,0);
											$PromPeriodo = ($Promedio * $porc_examen)/100;
											?>
                                      <tr>
                                        <td class="datos"><? echo $fila_alu['ape_pat']." ".$fila_alu['nombre_alu'];?></td>
                                        <td class="datos" align="center"><?=$Promedio;?>&nbsp;</td>
											<? 	$sql = "SELECT * FROM examen_semestral WHERE id_curso=".$curso." AND id_ramo=".$ramo;
											$rs_curso = @pg_exec($conn,$sql);
											
											for($i=0;$i<@pg_numrows($rs_curso);$i++){
												$fila_ex=@pg_fetch_array($rs_curso,$i);
												$Porc_Examen = 0;
												$sql = "SELECT nota FROM notas_examen WHERE id_examen=".$fila_ex['id_examen']." AND id_curso=".$curso." AND id_ano=".$ano." AND periodo=".$cmbPERIODO." AND id_ramo=".$ramo." AND rut_alumno=".$fila_alu['rut_alumno'];
												$rs_notas_alu = @pg_exec($conn,$sql);
												$Notas_alu = @pg_result($rs_notas_alu,0);
												$Porc_Examen = ($Notas_alu * $fila_ex['porc'])/100;
												$SumaExamen = $SumaExamen + $Porc_Examen;
												
												
										?>
											<input name="id_examen<?=$i;?>" type="hidden" value="<?=$fila_ex['id_examen'];?>">
                                        <td align="right" valign="middle">
											<? if($frmModo=="modificar"){?>
											<input name="txtEXAMEN<?=$j;?><?=$i;?>" type="text" size="3" maxlength="2" value="<?=$Notas_alu;?>">
											<? } 
											if($frmModo=="mostrar"){
												echo "<div align=center class=datos>".$Notas_alu."</div>";
											} ?>	
										</td>
											
										<? } 
											if($SumaExamen==0){
												$PromPeriodo=$Promedio;
											}else{	
												$PromPeriodo = $PromPeriodo + $SumaExamen;
											}
											if($fila_ex['bool_ap']==1){
												$PromPeriodo = round($PromPeriodo);
											}else{
												$PromPeriodo=abs($PromPeriodo);
											}
										?>
									
                                        <td align="center" class="datos"><? echo $PromPeriodo;?></td>
                                      </tr>
									  	<input name="promedio<?=$j;?>" type="hidden" value="<?=$PromPeriodo;?>">
									  <? }
									  } ?>
									  	<input name="contadorj" type="hidden" value="<?=$j;?>" >
										<input name="contadori" type="hidden" value="<?=$i;?>" >
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                    </table></td>
								  </tr>
								</table>
								</form>								  
                                  <!--fin codigo antiguo--></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
    </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
