<?php require('../../../../../../util/header.inc');


	if ($id_ramo != NULL or $id_ramo != 0){
		$_RAMO=$id_ramo;
		session_register('_RAMO');
	}
	
	if ($viene_de){
		$_VIENEPAG=$viene_de;	
	}
	
	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$docente		=5; //Codigo Docente
	$_POSP          =6;
	$_bot           =5;

if($drop=="1"){ //Elimino la tabla temporal que se creo, al no efectuar los cambios
$qry_drop = "DROP TABLE $_TABLA_TEMP";	
$res_drop = @pg_Exec($qry_drop);
}
	/// AQUI CONSULTO SI ESTE RAMO ES PARTE DE ALGUNNA FORMULA (SUBSECTORRAMO)
	/// Y SI SE DEBE DAR LA OPCION DE INGRESAR NOTA O SOLO MOSTRAR
	$q1 = "select * from formula where id_ramo = '".trim($ramo)."' and modo = '2'";
	$r1 = @pg_Exec($conn,$q1);
	$n1 = @pg_numrows($r1);
	if ($n1>0){
	    $boton_ing = "no";
	}	
		
	
	
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
	if($aux!=1)	{//HACER LA CONSULTA Y DESPLEGAR EL PRIMER PERIODO
		$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY NOMBRE_PERIODO";
		$result =@pg_Exec($conn,$qry);
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
		else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
					exit();
				};
				$periodo	= $fila1['id_periodo'];
			}else{
				echo "NO EXISTEN PERIODOS INGRESADOS PARA ESTE AÑO";
			}
		};
	}

    $_PERIODORAMO	=	$periodo;
	if(!session_is_registered('_PERIODORAMO')){
		session_register('_PERIODORAMO');
	};
	
	// VERIFICO SI EL PERIODO ESTA CERRADO
	$q1 = "select * from periodo where id_periodo = ".$periodo."";
	$r1 = pg_Exec($conn,$q1);
	if (!$r1){
	   echo "Erro: No encontró el periodo";
	   exit();
	}else{
	   $f1 = pg_fetch_array($r1,0);
	   $cerradop = $f1['cerrado'];
	}      
	   
/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		/*if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
			$_ITEM =$item;
			session_register('_ITEM');
		}*/
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}	
	
?>

<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../../index.php";
		 </script>

<? } ?>
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
//-->
</script>

		
		<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>

		<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmbPERIODO.value!=0){
				form.cmbPERIODO.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'new_mostrarNotas.php3?aux=1&periodo='+ form.cmbPERIODO.value;
				form.submit(true);
				}
			}
			function enviapag2(form){
			if (form.cmbPERIODO.value!=0){
				form.cmbPERIODO.target="_blank";
//				form.action = form.cmbPERIODO.value;
				form.action = 'mostrarNotasexcel.php?aux=1&periodo='+ form.cmbPERIODO.value;
				form.submit(true);
				}
			}
		</SCRIPT>

<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">	

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include ("../../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
            
            <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            
                    <tr> 
                      
                      <td width="20%" height="363" align="left" valign="top">
					  <? 
					   $menu_lateral= '3_1'; include ("../../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="80%" align="left" valign="top">
                      
                      <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!-- inicio codigo antiguo -->
								  
								  

	<FORM method="post" name="frm">
		<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
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
									</strong>								</FONT>							</TD>
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
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.bloq_nota FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);
													$bloq_nota = $fila1['bloq_nota'];	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['grado_curso'])." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
												}
											}
										?>
									</strong>								</FONT>							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>SUBSECTOR</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT subsector.nombre, subsector.cod_subsector, modo_eval FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila10 = @pg_fetch_array($result,0);	
												echo trim($fila10['nombre']);
												$_SESSION['_MODOEVAL'] = trim($fila10['modo_eval']);
												
											}
										?>
									</strong>								</FONT>							</TD>
						</TR>
                          <TR>
							
                   
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>PLAN 
              DE ESTUDIO</strong> </FONT> </TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
                             <TD>
                                      <FONT face="arial, geneva, helvetica" size=2>
									<strong>
                                         <?php
											$qry4="SELECT curso.id_curso, plan_estudio.cod_decreto, plan_estudio.nombre_decreto FROM curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto WHERE (((curso.id_curso)=".$curso."))";
											//if($_PERFIL==0) echo $qry4;
														$result4 =@pg_Exec($conn,$qry4);
														$fila4= @pg_fetch_array($result4,0);
													
												echo trim($fila4['nombre_decreto']);
											
										?>
                                       </strong>								</FONT>                                </TD>
						</TR>
                         <TR>
							
                   <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>DECRETO 
                                DE EVAL</strong> </FONT> </TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
                            
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
                                         
										<?php 
	                                                     $qry4="SELECT curso.id_curso, evaluacion.cod_eval FROM curso INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval WHERE (((curso.id_curso)=".$curso."))";
														$result4 =@pg_Exec($conn,$qry4);
														$fila4= @pg_fetch_array($result4,0);
                                                           

													$qry5="SELECT * FROM EVALUACION WHERE COD_EVAL=".$fila4['cod_eval'];
													$result5 =@pg_Exec($conn,$qry5);
													if (!$result5) {
														error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
													}else{
														if (pg_numrows($result5)!=0){
															$fila9 = @pg_fetch_array($result5,0);	
															if (!$fila9){
																error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																exit();
															}
															echo trim($fila9['nombre_decreto_eval'])." (".trim($fila9['cursos']).")";
														}
													
												}
												
												
				$qry1106="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO = '$ano' AND ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
				$result1106 =@pg_Exec($conn,$qry1106);
				
				if (!$result1106){
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result1106)!=0){
						$fila1106 = @pg_fetch_array($result1106,0);	
						if (!$fila1106){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}else{
						  $fila1106 = @pg_fetch_array($result1106,0);
					    }	  
					}
											
				}				?>	</strong>								</FONT>							</TD>
						</TR> 
						
						
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>ESTADO DE INGRESO DE NOTAS</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<? if ($bloq_nota==1){ ?>								
								      <img src="../../../../../configuracion/cand_cerrado.jpg">
									  &nbsp; <FONT face="arial, geneva, helvetica" size=2>
									<strong>BLOQUEADO POR EL ADMINISTRADOR</strong></FONT>
							  <?  }else{ ?>
							          <img src="../../../../../configuracion/cand_abierto.jpg">
									  &nbsp; <FONT face="arial, geneva, helvetica" size=2>
									<strong>DISPONIBLE PARA INGRESO</strong></FONT>							  
							  <? } ?>							</TD>
						</TR>	
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
							<?	if($_PERFIL==0){ ?>
									<INPUT class="botonXX"  TYPE="button" value="Eliminar Tablas Temporales" name=btnCancelar onClick=document.location="elimina_temporales.php">&nbsp;<?
								} ?>							
							<?php //if(($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){  
							if($ingreso==1 || $modifica==1){?>							
							
										<INPUT class="botonXX"  TYPE="button" value="RESPALDAR EN EXCEL" onClick="enviapag2(this.form)">
										
										 <?		
										 /// proceso para ver si este ramo es un subsector padre del modo 2
										 /// si es así, no se debe permitir ingresar notas desde aquí
										 $qry_formula = "select * from formula where id_ramo = '$ramo' and modo = '2'";
										 $res_formula = @pg_Exec($conn,$qry_formula);
										 $num_formula = @pg_numrows($res_formula);
										 
										 /// fin proceso formula			 
										 
															 
										 if($fila1106['situacion']!=0){//CERRADO NO MOSTRAR LOS BOTONES INGRESAR							 
											   if($institucion==999955555){  /// codigo antiguo
													if ($cerradop != 1){
														 if ($num_formula==0){ ?>									  
		<!--<INPUT class="botonXX"  TYPE="button" value="INGRESAR." name=btnCancelar onClick=document.location="ingresoNota2.php3?curso=<?php echo trim($_CURSO)?>">
-->												  &nbsp;
<?
														 }									
													}	 									
											   }else{
													if ($ingreso==1 || $modifica==1){
														if ($cerradop != 1){  
															
															  if ($num_formula==0 and $bloq_nota!=1){  /*********vel***/?>								     
<!--<INPUT class="botonXX"  TYPE="button" value="INGRESAR.." name=btnCancelar onClick=document.location="new_generaTemporal.php?curso=<?php echo trim($_CURSO)?>">-->
&nbsp;
<?
															  }
														}
													}	
											   }
										 }		
									}?>	
									
									<?
									/// HABILITO EL INGRESO DE NOTAS PARA PERFIL JEFE DE UTP, PARA INSTITUCION 9239
									if ($_INSTIT==9239 and $_PERFIL==25){
									     if($fila1106['situacion']!=0){//CERRADO NO MOSTRAR LOS BOTONES INGRESAR							 
											  if ($cerradop != 1){
													if ($num_formula==0 and $bloq_nota!=1){ 
														if($ingreso==1){?>									  
<INPUT class="botonXX"  TYPE="button" value="INGRESAR..." name=btnCancelar onClick=document.location="new_generaTemporal.php?curso=<?php echo trim($_CURSO)?>">
&nbsp;
<?
														}
													}									
											  }
										  }	 									
											   					
									} ///// FIN OPCION PARA INSTITUCION 9239 Y PERFIL JEFE DE UTP   /////
									
									
									
									
			/// HABILITO EL INGRESO DE NOTAS PARA PERFIL 0
			
				
				if($fila1106['situacion']!=0){//CERRADO NO MOSTRAR LOS BOTONES INGRESAR							 
				if ($cerradop != 1){
				if ($num_formula==0 and $bloq_nota!=1){ 
				if($ingreso==1){
				?>									  
				
<INPUT class="botonXX"  TYPE="button" value="INGRESAR" name=btnCancelar onClick=document.location="new_ingresoNota_2.php3">
&nbsp;
<?				}
				}									
			  }
		  }	 									
											   					
	 
									
									?>								
									
								<INPUT class="botonXX"  TYPE="button" value="VOLVER" name=btnCancelar onClick=document.location="<? echo $_VIENEPAG;?>">&nbsp;
							</TD>
						</TR>
						<TR height=20 class="indextable">
							<TD align=middle colspan=2 class="fondo">
								Notas
							</TD>
						</TR>
						<TR height=20 	>
							<TD align="middle" colspan="2" >
								  <select name="cmbPERIODO" onChange="enviapag(this.form)" class="imput">
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
													if($fila1['id_periodo']==$periodo){
														echo  "<option value=".$fila1["id_periodo"]." selected>".$fila1["nombre_periodo"]."</option>";
													}else{
														echo  "<option value=".$fila1["id_periodo"].">".$fila1["nombre_periodo"]."</option>";
													}
												}
											}
										};
									?>
								</Select>
							</TD>
						</TR>
						<TR>
							<TD>
								<TABLE BORDER="1"  CELLSPACING="0" CELLPADDING="0" width="100%"  class="tabla02">
								<?php
									//ALUMNOS DEL CURSO
//                                     $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno) WHERE tiene$nro_ano.id_ramo=".$ramo." ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
    	                                $qry="SELECT matricula.rut_alumno, matricula.bool_ar, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso, matricula.nro_lista "; 
										$qry = $qry . " FROM alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno ";
										$qry = $qry . " INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno AND matricula.id_curso=".$curso."";
										$qry = $qry . " WHERE tiene$nro_ano.id_ramo=".$ramo." AND matricula.id_ano=".$ano." ";
										$qry = $qry . " ORDER BY  nro_lista, ape_pat, ape_mat, nombre_alu, rut_alumno asc ";
										$result =@pg_Exec($conn,$qry);
										
										//matricula.nro_lista asc,
										
									if (!$result) 
										error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>'.$qry);
									else{
										if (pg_numrows($result)!=0){
											$fila1 = @pg_fetch_array($result,0);	

												echo "<TR>";

												echo "<TD align=center>Nº";
												echo "</TD>";

												echo "<TD align=center>ALUMNO";
												echo "</TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(1º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(2º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(3º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(4º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(5º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(6º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(7º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(8º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(9º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(10º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(11º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(12º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(13º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(14º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(15º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(16º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(17º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(18º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(19º)</STRONG></FONT></TD>";
		echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(20º)</STRONG></FONT></TD>";
		echo "<TD align=center>PROM";
		echo "</TD>";
												echo "</TR>";

											for($i=0 ; $i < @pg_numrows($result) ; $i++){
												$fila1 = @pg_fetch_array($result,$i);
												if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
													if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
														
												        if ($fila1["bool_ar"] == 1){
														?>	
															<TR class="tachado">
														<? } else { ?>																																																								
															<TR class="textolink">
														<?php }
														
														
													}else{ ?>
												<TR bgcolor=#ffffff onmouseover=this.style.background='yellow'; this.style.cursor='hand'; onmouseout=this.style.background='transparent'; onClick="go('ingresoNota.php3?alumno=<?php echo $fila1['rut_alumno'];?>');">
												<?	}
												}else{
													echo "<TR bgcolor=#ffffff>";
												}

												echo "<TD align=left width=20>";
												echo  $fila1["nro_lista"];
												echo "</TD>";

												echo "<TD align=left width=380>";
												echo  $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_alu"];
												echo "</TD>";
													
												//NOTAS ALUMNO POR RAMO Y PERIODO
  											    $qry2="SELECT * FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)=".$fila1['rut_alumno'].") AND ((notas$nro_ano.id_periodo)=".$periodo.") AND ((notas$nro_ano.id_ramo)=".$ramo."))"; 
												$result2 =@pg_Exec($conn,$qry2);
												if (!$result2) 
													error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>');
												else{
													if (pg_numrows($result2)!=0){
														$fila2 = @pg_fetch_array($result2,0);
														if (!$fila2){
															error('<B> ERROR :</b>Error al acceder a la BD. (86)</B>');
															exit();
														};
														for($j=1;$j<22;$j++){
															$var="nota"."$j";
															echo "<TD align=center width=100 bgcolor=white>";
															if ($j==21){
															       if ($fila10['modo_eval']==2){
															    		if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I)){
															       			echo($fila2['promedio']);
															      		}
																	}
															       if ($fila10['modo_eval']==1){
															            if ( trim($fila2['promedio'])!=0){
															                echo($fila2['promedio']);
															            }
															        }
															       if ($fila10['modo_eval']==3){
															            if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I)){
															                echo($fila2['promedio']);
															            }
															        }
															       if ($fila10['modo_eval']==4){
															            if ($fila2['promedio']!=0){
															                echo($fila2['promedio']);
															            }
															        }
																	if ($fila10['modo_eval']==5){
															            if (trim($fila2['promedio'])!="0"){
															                echo($fila2['promedio']);
															            }
															        }

															}
															else{
															     if ($fila10['modo_eval']==2){
																	   if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I) OR $fila2["$var"]!=0){
																	      echo($fila2["$var"]);
																	   }
																 }
															     if ($fila10['modo_eval']==1){
																 	if(!strcmp($var,'nota20')){
															           if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I)){
															              echo($fila2["$var"]);
																		}
																		else{
																		   if ($fila2["$var"]!=0){
																			  echo($fila2["$var"]);
																		   }
																		}
																	}
																	else{
															           if ($fila2["$var"]!=0){
															              echo($fila2["$var"]);
															           }
																	}
															     }
															     if ($fila10['modo_eval']==3){
															           if ($fila2["$var"]!=0){
															              echo($fila2["$var"]);
															           }
															     }
															     if ($fila10['modo_eval']==4){
															           if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I)){
															              echo($fila2["$var"]);
															           }
															     }
																 if ($fila10['modo_eval']==5){
																    if (trim($fila2["$var"])!="0"){
															            echo($fila2["$var"]);
															        } 
															     }
															}
															echo "&nbsp;</TD>";
														}
													}else{
															echo "<TD align=center width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=center width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
													}
												};
											
											};


										};
									};
								?>

								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD colspan=4 align="center">
								<table width="327" border="0" cellpadding="0" cellspacing="0" class="boton02">
                                  <tr align="center" valign="middle">
                                    <td height="23"><a href="../seteaRamo.php3?caso=4" class="boton02" > <img src="../../../../cortes/atras.gif" width="11" height="11" border="0"> Volver</a></td>
                                    <td><a href="#arriba" class="boton02"><img src="../../../../cortes/subir.gif" width="11" height="11" border="0">Subir</a> </td>
                                    <td><a href="javascript:;" onClick="window.print();" class="boton02"><img src="../../../../cortes/print.gif" width="11" height="11" border="0"> Imprimir</a></td>
                                  </tr>
                                </table></TD>
						</TR>
					</TABLE>
				
			</TR>
		</TABLE>
	</FORM>

								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
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
