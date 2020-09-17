<?php require('../../../../../util/header.inc');
       require('../../../../../util/LlenarCombo.php3');
	    require('../../../../../util/SeleccionaCombo.inc');?>
<?php 
	if ($id_ramo){
	    $_RAMO = $id_ramo;
		if(!session_is_registered('_RAMO')){
			session_register('_RAMO');
		};
		$_FRMMODO="mostrar";		
	}
	
	if ($modificar){
		$_FRMMODO="modificar";
	}
	
	if ($viene_de){
		$_VIENEPAG=$viene_de;	
	}

	$institucion	=$_INSTIT;
 	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
//	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
 	$ramo			=$_RAMO;
	$plan			=$_PLAN;
	$docente		=5; //Codigo Docente
	$_POSP          =5;
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
//-------
	$sqlCurso = "select institucion.nombre_instit, ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto ";
	$sqlCurso = $sqlCurso . " from institucion, ano_escolar, curso, tipo_ensenanza ";
	$sqlCurso = $sqlCurso . " where institucion.rdb = $institucion and ano_escolar.id_ano = $ano and curso.id_curso = $curso";
	$sqlCurso = $sqlCurso . "and curso.ensenanza = tipo_ensenanza.cod_tipo";
	$rsCurso =@pg_Exec($conn,$sqlCurso);												
	$fCurso = @pg_fetch_array($rsCurso,0);		
	//-------		
	
?>
				<script>
					function valida(form){
						return true;
					}
				</SCRIPT>
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">


function ChequearTodos(chkbox)
{
	for (var i=0;i < document.forms[0].elements.length;i++)
	{
		var elemento = document.forms[0].elements[i];
		if (elemento.type == "checkbox")
		{
			elemento.checked = chkbox.checked
		}
	}
}
</script>
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
//-->
</script>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
</head>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>            <table width="100%"><tr><td>&nbsp;</td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						  $menu_lateral="3_1";
						  include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top">
								  <!-- inicio codigo antiguo -->
								  
								  
								  
<center>

<FORM method=post name="frm" action="procesoRamoInscribir.php">
<table width="90%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO ESCOLAR</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php echo trim($fCurso['nro_ano']); ?>									</strong>								</FONT>							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>CURSO</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
													if ( ($fCurso['grado_curso']==1) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
														echo "PRIMER NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
													
													}else if ( ($fCurso['grado_curso']==1) and (($fCurso['cod_decreto']==121987) or ($fCurso['cod_decreto']==1521989)) ){
														echo "PRIMER CICLO"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
													
													}else if ( ($fCurso['grado_curso']==2) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
														echo "SEGUNDO NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
													
													}else if ( ($fCurso['grado_curso']==2) and ($fCurso['cod_decreto']==121987) ){
														echo "SEGUNDO CICLO"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
													
													}else if ( ($fCurso['grado_curso']==3) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
														echo "TERCER NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
													
													}else{
														echo $fCurso['grado_curso']." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
													}
										?>
									</strong>								</FONT>							</TD>
						</TR>
						<TR>
                          <TD align=left>
                            <?php if (($frmModo=="mostrar") or ($frmModo=="modificar")){ ?>
                            <FONT face="arial, geneva, helvetica" size=2> <strong>ASIGNATURA</strong> </FONT> </TD>
                          <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT>
                              <?php }?>                          </TD>
                          <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>
                            <?php
											//$qry="SELECT subsector.nombre, ramo.sub_obli, ramo.sub_elect, ramo.bool_ip, ramo.bool_sar FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$qry="SELECT * FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$result =@pg_Exec($conn,$qry);
											if (@pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												echo trim($fila1['nombre']);
											}
										?>
                          </strong> </FONT> </TD>
		    </TR>
					</TABLE></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="right">
	<?php if($frmModo=="modificar"){ ?>
		<INPUT class="botonXX"  TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form)">
		<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="InscribirAlumnos.php?id_ramo=<? echo $ramo;?>">
	<?php };?>
<?php if($frmModo=="mostrar"){ ?>
	<?php if($_PERFIL==17){
	
	         if (($_PERFIL==17) AND ($_INSTIT==9566 || $_INSTIT==24977)){ 
			      // no muestro
			 }else{	  
			      ?>
				  <INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="InscribirAlumnos.php?id_ramo=<?php echo $ramo?>&caso=3&modificar=1">
	       <? } ?> 
	<?php }?>
	<?php if( $_PERFIL==14 || $_PERFIL==0 || $_PERFIL==25 || $_PERFIL==27  || ($_PERFIL==25 and $_INSTIT==9239)){ ?>
			<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="InscribirAlumnos.php?id_ramo=<?php echo $ramo?>&caso=3&modificar=1">
	<?php }?>
			<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="<? echo $_VIENEPAG;?>">   
<?php }?>			
	</td>
  </tr>
</table>

<table width="650" border="0" cellspacing="1" cellpadding="3">
 <TR height=20 class="indextable">
	    <TD colspan=2 align=center class="tableindex">INSCRIPCION DE ALUMNOS EN LA ASIGNATURA<br>
	      <!--
		  <br>
	      <table width="450" border="0" align="left" cellpadding="3" cellspacing="0">
            <tr>
              <td><label>
                <input name="todos_sub" type="radio" value="1">
                <span class="Estilo1">En todos los subsectores                </span></label></td>
              <td> <label>
                <input name="todos_sub" type="radio" value="0">
              </label>
                <span class="Estilo1">Desmarcar todos los subsectores</span> </td>
            </tr>
          </table>
	      <br>
	      <br>
		  -->
		  </TD>
</TR>
</table>

<TABLE WIDTH="650" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										 
                  <td> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>ALUMNOS INSCRITOS EN LA ASIGNATURA</strong></font> 
                  </td>
									</TR>
                                   <tr class="tablatit2-1">
                
				            
                  <td align="left" width="289"> 
                    <?php    if($frmModo=="modificar"){  ?>
                   ELIMINAR &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; </strong> 
                     
                    <?php  }  ?>&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; 
                    
                   NOMBRE </td>
				
			</tr>
			<?php    if(($frmModo=="modificar")||($frmModo=="mostrar")) {  ?>
                     <?php
 $qryP="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno INNER JOIN matricula ON matricula.rut_alumno=alumno.rut_alumno AND tiene$nro_ano.rut_alumno=matricula.rut_alumno and tiene$nro_ano.id_curso=matricula.id_curso)   WHERE (((tiene$nro_ano.id_ramo)=".$ramo.") AND((tiene$nro_ano.id_curso)=".$curso.")) order by nro_lista,ape_pat, ape_mat, nombre_alu asc ";
				$resultP =@pg_Exec($conn,$qryP);			
				if (pg_numrows($resultP)!=0){
					$filaP = @pg_fetch_array($resultP,0);	
				}
				
				
				?>
				<?php if ($frmModo=="modificar"){ ?>
			 <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"><strong>
                  <td><!--input type="checkbox" name="checkbox11" value="checkbox" onClick="ChequearTodos(this);"-->
                   </td>
                       </strong></font>
					<input name="ins" type="hidden" value="<? echo @pg_numrows($resultP)?>">
					 <?php  }?>	
			<?php
					for($i=0 ; $i < @pg_numrows($resultP) ; $i++){
						$filaP = @pg_fetch_array($resultP,$i);
                           
			?>   
                  <tr  onmouseover=this.style.background='yellow';this.style.cursor='cursor' onmouseout=this.style.background='transparent'>           
                  <td align="left"> 
                    
					<?php if ($frmModo=="modificar"){ ?>
                    <input type="checkbox" name="alum<? echo $i?>" value=<?php echo $filaP["rut_alumno"];?>>  
					<input name="rut_alum<? echo $i?>" type="hidden" value="<?php echo $filaP["rut_alumno"];?>">
					<?php } ?>                     
                               <?php    // }  ?> &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                                <?php    if(($frmModo=="modificar")or($frmModo=="mostrar")) {  ?> 
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $filaP["ape_pat"]." ".$filaP["ape_mat"].", ".$filaP["nombre_alu"];?> <?php echo $filaP["rut_alumno"];?></strong>
								</font>
                                 <?php     } } ?>
							</td>
						</tr>
			<?php
					}
                  
                  
//				}
			?>
			<tr>
				<td colspan="3">
				<hr width="100%" color="#003b85">
				</td>
			</tr>

                  <tr>
                    
                  <td> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>ALUMNOS NO INSCRITOS</strong></font> </td>
									</TR>
                                   <tr class="tablatit2-1">
                
				            
                  <td align="left" width="289"> 
                    <?php    if($frmModo=="modificar"){  ?>
                    INSCRIBIR &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;
                    <?php    }  ?>
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; NOMBRE </td>
				
			</tr>
					<?php    if(($frmModo=="modificar")|| ($frmModo=="mostrar")){  ?>
                       <?php
                 $qryA="SELECT * FROM (alumno inner join matricula on alumno.rut_alumno=matricula.rut_alumno) inner join curso on curso.id_curso=matricula.id_curso WHERE  matricula.id_curso='".$curso."' and  alumno.rut_alumno NOT IN (SELECT rut_alumno FROM tiene$nro_ano WHERE tiene$nro_ano.id_ramo='".$ramo."' AND((tiene$nro_ano.id_curso)=".$curso.")) order by ape_pat, ape_mat, nombre_alu "; 
				    $resultA =@pg_Exec($conn,$qryA);
  					$filaA = @pg_fetch_array($resultA,0);
			                   ?>
							   <?php if ($frmModo=="modificar"){ ?>
			 						<font face="arial, geneva, helvetica" size="1" color="#FFFFFF"><strong>
                  						<td><input type="checkbox" name="checkbox11" value="checkbox" onClick="ChequearTodos(this);">


										<font face="arial, geneva, helvetica" size="1" color="#000000"> 
                    							<strong>TODOS</strong> </font>
                   						</td>
                       				</strong></font>
									<input name="des" type="hidden" value="<? echo @pg_numrows($resultA)?>">
					 		   <?php  }?>
			         <?php
					for($i=0 ; $i < @pg_numrows($resultA) ; $i++){
						$filaA = @pg_fetch_array($resultA,$i);
                           
			                ?>              
                                 
                   <tr onmouseover=this.style.background='yellow';this.style.cursor='cursor' onmouseout=this.style.background='transparent'>							
                  <td align="left"> 
                    <?php if ($frmModo=="modificar"){ ?>
                    <input type="checkbox" name="alu<? echo $i?>" value=<?php echo $filaA["rut_alumno"];?>>  
					<input name="rut_alu<? echo $i?>" type="hidden" value="<?php echo $filaA["rut_alumno"];?>">
                     
					<?php } ?>
                                  <?php  //  }  ?> &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                                <?php   // if(($frmModo=="modificar")or($frmModo=="mostrar")) {  ?> 
								<font face="arial, geneva, helvetica" size="1" color="#666666">
									<strong><?php echo $filaA["ape_pat"]." ".$filaA["ape_mat"].", ".$filaA["nombre_alu"];?></strong>
								</font>
                                 <?php  }  ?>
							</td>
						</tr>
			<?php
					}
//				}
			?>
			<tr>
				<td colspan="3">
				<hr width="100%" color="#003b85">
				</td>
</TABLE>
</form>
</center>

								  
								  
								  <!-- fin codigo antiguo -->
							      </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          
        </tr>
      </table></td><td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table>
</body>
</html>
