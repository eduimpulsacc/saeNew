<?php require('../../../../util/header.inc');
       require('../../../../util/LlenarCombo.php3');
	    require('../../../../util/SeleccionaCombo.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
//	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$plan			=$_PLAN;
	$docente		=5; //Codigo Docente
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
<html>
<head>
<title>Documento sin t&iacute;tulo</title>

<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<center>
<FORM method=post name="frm" action="procesoRamoInscribir.php">
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
		<TR>
			<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></FONT></TD>
			<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
			<TD><FONT face="arial, geneva, helvetica" size=2><strong><?php echo trim($fCurso['nombre_instit']); ?></strong></FONT></TD>
		</TR>
		<TR>
			<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>AÑO ESCOLAR</strong></FONT></TD>
			<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
			<TD><FONT face="arial, geneva, helvetica" size=2><strong><?php echo trim($fCurso['nro_ano']); ?></strong></FONT></TD>
		</TR>
		<TR>
			<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>CURSO</strong></FONT></TD>
			<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
			<TD><FONT face="arial, geneva, helvetica" size=2><strong>
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
					</strong></FONT>
			</TD>
		</TR>
		
	</TABLE></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="right">
	<?php if($frmModo=="modificar"){ ?>
		<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form)">
		<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarRamos.php3?plan=<?php echo $plan ?>">
	<?php };?>
<?php if($frmModo=="mostrar"){ ?>
	<?php if($_PERFIL==17){ ?>
			<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="INICIO" onClick=parent.location.href="../../../../../fichas/docente/index.html">
			<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaClaves.php3?curso=<?php echo $curso?>&caso=3">
	<?php }?>
	<?php if( $_PERFIL==14 || $_PERFIL==0 ){ ?>
			<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaClaves.php3?curso=<?php echo $curso?>&caso=3">
	<?php }?>
			<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="seteaCurso.php3?curso=<?php echo $curso;?>">   
<?php }?>			
	</td>
  </tr>
</table>

<table width="650" border="0" cellspacing="1" cellpadding="3">
 <TR height=20 bgcolor=#003b85>
	    <TD align=center colspan=2> <FONT face="arial, geneva, helvetica" size=2 color=White> 
          <strong>ACTIVAR CLAVES DE ACCESO</strong></FONT></TD>
</TR>
</table>

<TABLE WIDTH="650" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										 
                  <td> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>CLAVES ACTIVADAS</strong></font> 
                  </td>
									</TR>
                                   <tr bgcolor="#003b85">
                
				            
                  <td align="left" width="289"> 
                    <?php    if($frmModo=="modificar"){  ?>
                    <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"> 
                    <strong>CLAVES ACTIVADAS &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; </strong> 
                    </font>  
                    <?php  }  ?>&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; 
                    <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"> 
                    <strong>NOMBRE</strong> </font> </td>
				
			</tr>
			<?php    if(($frmModo=="modificar")||($frmModo=="mostrar")) {  ?>
                     <?php
				$qryP="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM matricula inner join alumno on matricula.rut_alumno=alumno.rut_alumno  WHERE matricula.id_curso=".$curso." order by ape_pat, ape_mat, nombre_alu asc ";
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
						$sql = " SELECT estado FROM usuario INNER JOIN accede ON usuario.id_usuario=accede.id_usuario WHERE rdb=".$institucion." AND nombre_usuario='".$filaP['rut_alumno']."' AND estado=1";
						$Rs_Estado = @pg_exec($conn,$sql);

                           
			?>   
                  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='cursor' onmouseout=this.style.background='transparent'>           
                  <td align="left"> 
                    
					<?php if ($frmModo=="modificar"){ ?>
                    <input type="checkbox" name="alum[<? echo $i?>]" value=<?php echo $filaP["rut_alumno"];?>>  
					<input name="rut_alum[<? echo $i?>]" type="hidden" value="<?php echo $filaP["rut_alumno"];?>">
					<?php } ?>                     
                               <?php    // }  ?> &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                                <?php    if(($frmModo=="modificar")or($frmModo=="mostrar")&&(@pg_numrows($Rs_Estado)!=0)) {  ?> 
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $filaP["ape_pat"]." ".$filaP["ape_mat"].", ".$filaP["nombre_alu"];?></strong>
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
                    <strong>CLAVES DESACTIVADAS</strong></font> </td>
									</TR>
                                   <tr bgcolor="#003b85">
                
				            
                  <td align="left" width="289"> 
                    <?php    if($frmModo=="modificar"){  ?>
                    <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"> 
                    <strong>INSCRIBIR &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; </strong> </font> 
                    <?php    }  ?>
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"> 
                    <strong> NOMBRE</strong> </font> </td>
				
			</tr>
					<?php    if(($frmModo=="modificar")|| ($frmModo=="mostrar")){  ?>
                       <?php
                /*echo  $qryA="SELECT * FROM (alumno inner join matricula on alumno.rut_alumno=matricula.rut_alumno) inner join curso on curso.id_curso=matricula.id_curso WHERE  matricula.id_curso='".$curso."' and  alumno.rut_alumno NOT IN (SELECT rut_alumno FROM tiene$nro_ano WHERE tiene$nro_ano.id_ramo='".$ramo."')"; 
				    $resultA =@pg_Exec($conn,$qryA);
  					$filaA = @pg_fetch_array($resultA,0);*/
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
						//$filaA = @pg_fetch_array($resultA,$i);
						$filaP = @pg_fetch_array($resultP,$i);
						echo $sql = " SELECT estado FROM usuario INNER JOIN accede ON usuario.id_usuario=accede.id_usuario WHERE rdb=".$institucion." AND nombre_usuario='".$filaP['rut_alumno']."' AND estado=0";
						$Rs_Estado = @pg_exec($conn,$sql);
			       ?>              
                                 
                   <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='cursor' onmouseout=this.style.background='transparent'>							
                  <td align="left"> 
                    <?php if ($frmModo=="modificar"){ ?>
                    <input type="checkbox" name="alu[<? echo $i?>]" value=<?php echo $filaA["rut_alumno"];?>>  
					<input name="rut_alu[<? echo $i?>]" type="hidden" value="<?php echo $filaA["rut_alumno"];?>">					                     
					<?php } ?>
                                  <?php  //  }  ?> &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                                <?php   // if(($frmModo=="modificar")or($frmModo=="mostrar")) {  ?> 
								<font face="arial, geneva, helvetica" size="1" color="#666666">
									<strong><?php echo $filaP["ape_pat"]." ".$filaP["ape_mat"].", ".$filaP["nombre_alu"];?></strong>
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
<? pg_close($conn); ?>
</center>
</body>
</html>
