
<?php
require('../../../../../util/header.inc');
 	
	$institucion	=8420;
	$ano			=692;
	$curso			=16283;
	$docente		=5; //Codigo Docente
	$_POSP          =5;
	$_bot           =5;
	$_MDINAMICO     =1;
	$_VIENEPAG="listar_ramos.php3";
	
	
	if($curso!=""){
		$qryplan ="SELECT * FROM CURSO WHERE id_curso = '$curso'";
		$resultplan = pg_Exec($conn,$qryplan);
		$rowplan = pg_fetch_array($resultplan);
		$_PLAN=$rowplan[cod_decreto];
			if(!session_is_registered('_PLAN')){
				session_register('_PLAN');
			};
	}	

	
	session_register("_VIENEPAG");
	
	
	

	if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)&&($_PERFIL!=26)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=20)&&($_PERFIL!=14) &&($_PERFIL!=2)&&($_PERFIL!=25)&&($_PERFIL!=19)&&($_PERFIL!=26)&&($_PERFIL!=27)){$whe_perfil_curso=" and curso.id_curso=$curso";}
	
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
											
				}
	
	
?>

 <?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../index.php";
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

       function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="../seteaCurso.php3?caso=11&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 
		  function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../../seteaAno.php3?caso=10&pa=2&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }

		 
</script>
<style type="text/css">
<!--
.EstiloMODO {color: #FF0000 ; font-size: 10px;}
-->
</style>
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
							<? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height=""><!-- codigo antiguo -->
								  
								  
								  
								  
								  
<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<table width="90%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="" align="center" valign="top"> 
      <? include("../../../../../cabecera/menu_inferior.php"); ?> </td>
  </tr>
</table>
<?php } ?>
	<?php //echo tope("../../../../../util/");?>
	<center>
	
	
		<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#0000FF">
          <tr>
            <td>
			
			
			  <TABLE BORDER="0" CELLSPACING="1" CELLPADDING="1">
						
						<TR>
							<TD align=left class="textonegrita">AÑO ESCOLAR </TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion."  $whe_perfil_ano ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					} ?>
			 <form name="form"   action="" method="post">
		        <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
					
						<select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);++$i){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
							  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							} ?>
							</select></form>
				<? }	?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left class="textonegrita">												CURSO															</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
								
		    <form name="form"   action="" method="post">
		      <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
		      <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso  ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);


                 ?>
				 
				 
				 
		  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
            <option value="0" selected>(Seleccione un Curso)</option>
			 <?
			 $sw3 = 1;
			 
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		  
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
				   $sw3 = 0;
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
                }
		     } 
			
			 ?>
          </select>	 
		 </form>		   
		  
			</strong></FONT>
							</TD> 
						</TR>
					</TABLE>
				
			</td>
          </tr>
        </table>
					
		
		<form name="form2" method="post" action="elimina_ramos.php">
		<table BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=0>
				<TD colspan=3 valign="top">&nbsp;</TD>
			</TR>
			<tr>
				<td colspan=4 align=right>
		         <?
                   if ($_PERFIL==0){ ?>
					     <!-- <INPUT name="Enviar"  TYPE="submit" class="botonXX" value="ELIMINAR SUBSECTOR">-->
				 <? } 		 				

             
			 
			 if (($curso != 0) and ($curso != NULL) and ($sw3 != 1)){ ?> 							
		
					<?php if(($_PERFIL!=17) and ($_PERFIL!=19)){?>
						<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
								<?php if(($_PERFIL!=3)&&($_PERFIL!=5) &&($_PERFIL!=26)){ //FINANCIERO Y  CONTADOR
								
								if (($plan!=461987) and ($plan!=1901975) and ($plan!=771982) and ($plan!=121987)){
									
									
									if($fila1106['situacion']==0){//CERRADO NO MOSTRAR ESTE BOTON CON LINK
									    ?><INPUT class="botonXX"  TYPE="button" value="AGREGAR">
                                <?
								    }else{
									     ?>
                                <input name="button2"  type="button" class="botonXX" onClick=document.location="seteaRamo.php3?caso=2&plan=<?php echo $plan?>" value="AGREGAR">
                                <?
									}
									?>								
																	
									
									
									<INPUT name="button" TYPE="button" class="botonXX" onClick=document.location="Ordensubsector.php"  value="ORDENAR">
									<INPUT class="botonXX"  TYPE="button" value="SUBSECT. FORMULAS" onClick=document.location="listarFormulas.php3">
											<?php }?>
												<?php }?>
						<?php }?>
					<?php }?>	
					
					<? if ($_INSTIT==1756 and $_PERFIL==17){  ?> <INPUT name="button" TYPE="button" class="botonXX" onClick=document.location="Ordensubsector.php"  value="ORDENAR"> <? } ?>								</td>
			</tr>
			<tr height="20">
				<td align="middle" colspan="5" class="tableindex">Subsectores</td>
			</tr>
						<tr>
				<td align="left" colspan="5" class="textolink">
					<table width="100%" border="0">
                      <tr class="textolink">
                        <td><input name="button3"  type="button" class="botonXX" value="E" >
Evaluacion</td>
                        <td><input name="button4"  type="button" class="botonXX" value="I" >
Insc. alumnos</td>
                        <td><input name="button5"  type="button" class="botonXX" value="SF" >
Sit. Final</td>
                        <td><input name="button6"  type="button" class="botonXX" value="A" >
Archivos </td>
                      </tr>
                      <tr class="textolink">
                        <td><input name="button7"  type="button" class="botonXX" value="PN" >
Prueba Nivel</td>
                        <td><input name="button8" type="button" class="botonXX"  value="P">
Planificaci&oacute;n</td>
                        <td><input name="button9" type="button" class="botonXX" value="ES">
Exm. Semestral </td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
					</td>
			</tr>
			<tr class="tablatit2-1">
				<td align="center" >
					NOMBRE				</td>
				<td align="center" width="200">
					DOCENTE				</td>
				
				<td>MODO EVALUACI&Oacute;N </td>
				<td>OPCIONES</td>
			</tr>
			<?php
              if (($_SWA==1) and ($_PERFIL !=0)){
			     
			 echo  $qry="SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector,  ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, ramo.porc_examen FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE ramo.id_curso=".$curso." and ramo.id_ramo =".$_RAMO." order by ramo.id_orden";
			   
				  $result_qry =@pg_Exec($conn,$qry);  
				  $fila_modo = @pg_fetch_array($result_qry,0);	
				   $modismo = $fila_modo['modo_eval'];
				  
			  }else{
			      
		  	echo  $qry="SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector, ramo.eee,  ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, ramo.porc_examen FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso."))  order by ramo.id_orden";
              $result_qry =@pg_Exec($conn,$qry);
			  $fila_modo = @pg_fetch_array($result_qry,0);	
			  $modismo = $fila_modo['modo_eval'];
			 
			  }
			  
			  
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					//error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
						//	error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
			<?php
			
			
				   $contador = @pg_numrows($result);				 			        
				   ?>
				   <input type="hidden" name="contador" value="<?=$contador ?>">
				   <?
			
			
			     			        
			
					for($i=0 ; $i < @pg_numrows($result) ; ++$i){
						$fila = pg_fetch_array($result,$i);
			             
						?>
				       <tr  onMouseOver="this.style.background='yellow';" onMouseOut="this.style.background='transparent'" >
					   <!--<td align="center" class="textolink"><input type="checkbox" name="check<?=$i ?>" value="<? echo $fila["id_ramo"]; ?>" <? if ($fila["eee"]==1){ ?> checked="checked" <? } ?>>	</td>-->
				       <td align="left" class="textolink"   onClick="go('seteaRamo.php3?ramo=<?php echo $fila["id_ramo"];?>&caso=1&plan=<?php echo $fila['cod_decreto']; ?>&cod_subsector=<? echo $fila['cod_subsector']; ?>&swb=1')">
					       <?php echo $fila["id_ramo"];?>&nbsp;
					   
					   
					       <?
						   if ($fila["eee"]==1){ ?>
						       <font color="#FF0000">			   
				         	   <?php echo $fila['nombre'];  echo $fila['cod_subsector']; 
							   ?>
							   </font>
							   <?
						   }else{
						   	   echo $fila['nombre'];  echo $fila['cod_subsector']; 
						   }
						   ?>  
					   
											</td>
							<?php
							 //  $qry2="SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (dicta INNER JOIN empleado ON dicta.rut_emp = empleado.rut_emp) WHERE (((dicta.id_ramo)=".$fila["id_ramo"]."))";
							
								$qry55="select * from dicta where id_ramo=".$fila['id_ramo'];
							//	$qry55="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from (supervisa inner join empleado on supervisa.rut_emp = empleado.rut_emp) where((supervisa.id_curso)=".$fila['id_curso'].")";
								$result55 =@pg_Exec($conn,$qry55);
								$fila55 = @pg_fetch_array($result55,0);
								
								$qry2="select empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from empleado where rut_emp=".$fila55['rut_emp'];
							//	$qry5="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from (supervisa inner join empleado on supervisa.rut_emp = empleado.rut_emp) where((supervisa.id_curso)=".$fila['id_curso'].")";
								$result2 =@pg_Exec($conn,$qry2);
								$fila2 = @pg_fetch_array($result2,0);

							
							
								//$qry2="SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (dicta INNER JOIN empleado ON dicta.rut_emp = empleado.rut_emp) INNER JOIN ramo ON dicta.id_ramo = ramo.id_ramo WHERE (((ramo.id_ramo)=".$fila["id_ramo"]."))";
								$result2 =@pg_Exec($conn,$qry2);
								$fila2 = @pg_fetch_array($result2,0);	
							?>
							<td align="left" class="textolink" onClick="go('seteaRamo.php3?ramo=<?php echo $fila["id_ramo"];?>&caso=1&plan=<?php echo $fila['cod_decreto']; ?>&cod_subsector=<? echo $fila['cod_subsector']; ?>&swb=1')">
							
							 <?
							 if ($fila2['nombre_emp']==NULL){
							     echo "<font face='verdana' size='1' color='FF0000'>¡Falta información!</font>";
								 $cant_errores++;
								 $tipo_error_1 = 1;
						    }else{ ?>		 
								  <font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fila2["ape_pat"]." ".$fila2["ape_mat"].", ".$fila2["nombre_emp"];?></strong></font>
								  
						 <? } ?>
							
						
							</td>
							
							<td nowrap class="textolink"><? switch ($fila['modo_eval']) { //agregado el 25/01/2007/ by telnetk
											case 0:
															 imp('<span class="EstiloMODO">* Revisar </spam>');
															 break;
														 case 1:
															 imp('Numérico');
															 break;
														 case 2:
															 imp('Conceptual');
															 break;
														 case 3:
															 imp('Numérico-Conceptual');
															 break;
														 case 4:
															 imp('Conceptual-Numérico');
															 break;
													 };?>&nbsp;</td>
							<td nowrap>
							<?php
											$qry_per="SELECT periodo.id_periodo, ano_escolar.id_ano FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano."))";
											$result_per =pg_Exec($conn,$qry_per);
											if (pg_numrows($result_per)!=0){?>
								  <?
								  
								  if ($_INSTIT==25182){ ?>
								        <INPUT class="botonXX"  TYPE="button" value="E" onClick=document.location="notas/new_mostrarNotas_dav2.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3"> <?
								  }else{ ?>	
								  		<INPUT class="botonXX"  TYPE="button" value="E" onClick=document.location="notas/new_mostrarNotas_paso.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3">
										<?
								  }	?>				
								  
								  
								  
							  <INPUT class="botonXX"  TYPE="button" value="I" onClick=document.location="InscribirAlumnos.php?id_ramo=<? echo $fila[id_ramo];?>&viene_de=listarRamos.php3&_FRMMODO=mostrar">
							  
							  <? }?>
							  <?php if ($fila['conex']==1 ) { ?> 
							  
							  <input class="botonXX"  type="button" value="SF" onClick=document.location="situacionFinal.php3?frmModo=mostrar&viene_de=listarRamos.php3&id_ramo=<? echo $fila[id_ramo];?>">
							  
							  <? }?>
							  <INPUT class="botonXX"  TYPE="button" value="A" onClick=document.location="contenido/listarContenidos.php3?viene_de=../listarRamos.php3&id_ramo=<? echo $fila[id_ramo];?>">
							  
							  <?	//if(($fila[prueba_nivel]==1)&&(( $_PERFIL==0 )||($_PERFIL==14))){	?>
							  <?	if(($fila[prueba_nivel]==1)){	?>
							  <?	if($_PERFIL==14 && ($institucion==24977 || $institucion==25478)){	?>							  
							  <INPUT class="botonXX"  TYPE="button" value="PN" onClick=document.location="notas/mostrarNotasNivel.php3?id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3">
							  <?	}else if($_PERFIL==17 && ($institucion==24977 || $institucion==25478)){	?>							  
							  <?	}else{	?>							  							  							  
							  <INPUT class="botonXX"  TYPE="button" value="PN" onClick=document.location="notas/mostrarNotasNivel.php3?id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3">
							  <?	}	?>							  							  							  
							  <? }?>			
							  
							  <?  //echo $_NOMBREUSUARIO;
							  if ($fila2["nombre_emp"]!=NULL){ ?>	
							     <!-- <INPUT class="botonXX"  TYPE="button" value="P" 
                                  onClick=document.location="planificacion/planificacion.php?id_ramo=<? //echo $fila[id_ramo];?>&&viene_de=../listarRamos.php3">--->
								  <INPUT class="botonXX"  TYPE="button" value="P" onClick=document.location="planis/planificacion.php?id_ramo=<? echo $fila[id_ramo];?>&&viene_de=../listarRamos.php3"> 
							 <? 
							 } ?>							  
							 <? if($fila['porc_examen']!=100 &&  $fila['porc_examen']!=NULL){?>
							  <INPUT class="botonXX"  TYPE="button" value="ES" onClick=document.location="examen/seteaExamen.php?caso=1&id_ramo=<? echo $fila[id_ramo];?>"> 
							 <? } ?>
							   </td>
						</tr>
			             <?php
						 
						
					   }
				}
			?>		
		</table>
		</form>
	</center>
			  
<? }else{  ?>
      </td>
	  </tr>
	  </table>
 <? } ?>	  
 
 <? pg_close($conn)?>
    								  
								  
								  <!-- fin codigo antiguo --> </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
