
<?php

require('../../../../../util/header.inc');
 	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
   	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$_POSP          =5;
	$_bot           =5;
	$_MDINAMICO     =1;
	$_VIENEPAG="listar_ramos.php3";
	
	$sql="select situacion from ano_escolar where id_ano=$_ANO";
    $result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
	
	
	if($_PERFIL==0){
		//echo $curso;
		}
	
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
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
			$_ITEM =$item;
			session_register('_ITEM');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
	
		$sql="SELECT * FROM perfil_curso WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL."";
		
		if($_PERFIL!=0){
			$sql.=" AND rut_emp=".$_NOMBREUSUARIO;
		}
		
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		
		if(pg_num_rows($rs_acceso)!=0 && $_PERFIL!=0){
			$whe_perfil_curso=" AND curso.ensenanza=".pg_result($rs_acceso,3)." AND grado_curso in(";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['grado_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['grado_curso'];
				}
			}
			$whe_perfil_curso.=")";
		}else{

	if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)&&($_PERFIL!=26)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=20)&&($_PERFIL!=14)&&($_PERFIL!=2)&&($_PERFIL!=21)&&($_PERFIL!=54)&&($_PERFIL!=35)&&($_PERFIL!=22)&&($_PERFIL!=1)&&($_PERFIL!=25)&&($_PERFIL!=19)&&($_PERFIL!=28)&&($_PERFIL!=30)&&($_PERFIL!=53)&&($_PERFIL!=31)&&($_PERFIL!=32)&&($_PERFIL!=33)&&($_PERFIL!=26)&&($_PERFIL!=27)){$whe_perfil_curso=" and curso.id_curso=$curso";}
	
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
<link  rel="shortcut icon" href="/images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript" type="text/JavaScript">
<!--
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.EstiloMODO {color: #FF0000 ; font-size: 10px;}
-->
</style>
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="1240" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50"  rowspan="3" background="../../../../../cortes/<?=$institucion;?>/fondo_01_reca.jpg"></td>
    <td colspan="2" width="1000"><? include("../../../../../cabecera_new/head_sae.php"); ?></td>
    <td rowspan="3" background="../../../../../cortes/<?=$institucion;?>/fomdo_02_reca.jpg" width="50"></td>
  </tr>
  <tr>
    <td  valign="top"><br>
<? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
    <td  valign="top"><br>

    <table width="90%" border="0" class="cajaborde" align="center">
  <tr>
    <td>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#0000FF">
          <tr>
            <td>
			  <TABLE BORDER="0" CELLSPACING="1" CELLPADDING="1">

						<TR>
							<TD align=left class="titulo_new">AÑO ESCOLAR </TD>
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
					
						<select name="cmb_ano" class="select_redondo" onChange="enviapag2(this.form);">
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
							<TD>&nbsp;</TD>
							<TD><span class="titulo_new">CURSO </span></TD>
							<TD><form name="form"   action="" method="post">
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
				 
				 
				 
		  <select name="cmb_curso" class="select_redondo" onChange="enviapag(this.form);">
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
		 </form></TD>
						</TR>
						
				  </TABLE></td>
           
          </tr>
        </table>
        <div id="botonera1">
        <table width="845" height="80" border="0" cellpadding=" 0" cellspacing="0">
          <tr>
            <td width="86" align="center"><div class="buttons"><a href="" class="regular">Agregar</a></div></td>
            <td width="87" align="center"><div class="buttons"><a href="" class="regular">Ordenar</a></div></td>
           	<td width="116" align="center"><div class="buttons"><a href="" class="regular">Asig. Formulas</a></div></td>
            <td width="145" align="center"><div class="buttons"><a href="" class="regular">Config. Asignaturas</a></div></td>
            <td width="125" align="center"><div class="buttons"><a href="" class="regular">Config. Modulos</a></div></td>
            <td width="128" align="center"><div class="buttons"><a href="" class="regular">Config. Modulos</a></div></td>
           	<td width="130" align="center"><div class="buttons"><a href="" class="regular">Config. Modulos</a></div></td>
          </tr>
        </table>
        
        </div>
          <div id="conte_tabla">
 
          <table width="885" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td width="188" rowspan="4" align="center" bgcolor="#589FE3">SUBSECTORES</td>
            <td width="147" height="25" bgcolor="#3E70B7">Evaluación </td>
            <td width="147" height="25" bgcolor="#589FE3">&nbsp;</td>
            <td width="147" height="25" bgcolor="#3E70B7">&nbsp;</td>
            <td width="147" height="25" bgcolor="#589FE3">&nbsp;</td>
            <td width="147" height="25" bgcolor="#3E70B7">&nbsp;</td>
            </tr>
          <tr>
            <td width="188" height="25" bgcolor="#3E70B7">Dato</td>
            <td width="188" bgcolor="#589FE3">&nbsp;</td>
            <td width="175" bgcolor="#3E70B7">&nbsp;</td>
            <td width="103" bgcolor="#589FE3">&nbsp;</td>
            <td bgcolor="#3E70B7">&nbsp;</td>
            </tr>
          <tr>
            <td width="188" height="25" bgcolor="#3E70B7">&nbsp;</td>
            <td bgcolor="#589FE3">&nbsp;</td>
            <td bgcolor="#3E70B7">&nbsp;</td>
            <td bgcolor="#589FE3">&nbsp;</td>
            <td bgcolor="#3E70B7">&nbsp;</td>
            </tr>
          <tr>
            <td width="188" height="25" bgcolor="#3E70B7">&nbsp;</td>
            <td bgcolor="#589FE3">&nbsp;</td>
            <td bgcolor="#3E70B7">&nbsp;</td>
            <td bgcolor="#589FE3">&nbsp;</td>
            <td bgcolor="#3E70B7">&nbsp;</td>
            </tr>
          <tr>
            <td height="15" colspan="6">&nbsp;</td>
          </tr>
          <tr>
            <td height="15" colspan="6"><img src="../../../../../cortes/<?=$institucion;?>/sombra.png" width="885" height="24" /></td>
          </tr>
          </table>
        
        </div>
		<form name="form2" method="post" action="elimina_ramos.php">
        <div id="fdo_tabla">
		<div class="datagrid">
		  <table width="95%" BORDER="0" CELLPADDING="3" CELLSPACING="1" align="center">
			
			<tr>
				<td colspan=4 align=right>
		        <?
			 if (($curso != 0) and ($curso != NULL) and ($sw3 != 1)){ ?> 							
		
			
			
						
			<tr class="tablatit2-1">
				<td align="center" >NOMBRE</td>
				<td align="center" width="200">DOCENTE</td>
				<td>MODO EVALUACI&Oacute;N </td>
				<td>OPCIONES</td>
			</tr>
			<?php
              if (($_SWA==1) and ($_PERFIL !=0)){
			     
			   $qry="SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector,  ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, ramo.porc_examen, ramo.conexper,ramo.prueba_especial,ramo.bool_nquiz,ramo.conexquiz,ramo.bool_pu,ramo.bool_psintesis FROM subsector 
			   INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE ramo.id_curso=".$curso." and ramo.id_ramo =".$_RAMO." order by ramo.id_orden";
			  
				  $result_qry =@pg_Exec($conn,$qry);  
				  $fila_modo = @pg_fetch_array($result_qry,0);	
				  $modismo = $fila_modo['modo_eval'];
				  
			  }else{
			      
		  	  $qry="SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector, ramo.eee,  ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, ramo.porc_examen, ramo.conexper,ramo.prueba_especial,ramo.bool_nquiz,ramo.conexquiz, ramo.coef2,ramo.bool_pu,ramo.bool_psintesis FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso."))  order by ramo.id_orden";			   
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
			
			
			     	$cant_errores = 0;		        
			
					for($i=0 ; $i < @pg_numrows($result) ; ++$i){
						$fila = pg_fetch_array($result,$i);
			             
						?>
				       <tr  onMouseOver="this.style.background='yellow';" onMouseOut="this.style.background='transparent'" >
					  
				       <td align="left"  onClick="go('seteaRamo.php3?ramo=<?php echo $fila["id_ramo"];?>&caso=1&plan=<?php echo $fila['cod_decreto']; ?>&cod_subsector=<? echo $fila['cod_subsector']; ?>&swb=1')">
					       <?php echo $fila["id_ramo"]." ".$fila['nombre']." ".$fila['cod_subsector'];?>											</td>							<?php
							 
								$qry55="select * from dicta where id_ramo=".$fila['id_ramo'];
								$result55 =@pg_Exec($conn,$qry55);
								$fila55 = @pg_fetch_array($result55,0);
								
								$qry2="select empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from empleado where rut_emp=".$fila55['rut_emp'];
								$result2 =@pg_Exec($conn,$qry2);
								$fila2 = @pg_fetch_array($result2,0);
					
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
								  
						 <? } ?>											</td>
							
							<td nowrap class="textolink"><? switch ($fila['modo_eval']) { //agregado el 25/01/2007/ by telnetk
											case 0:
															 imp('<span class="EstiloMODO">* Revisar </spam>');
															 break;
														 case 1:
															 imp('N');
															 break;
														 case 2:
															 imp('C(I,S,B,MB)');
															 break;
														 case 3:
															 imp('N-C');
															 break;
														 case 4:
															 imp('C-N');
															 break;
														 case 5:
															 imp('C E(SIGLAS)');
															 break;	 
															 
													 };?>&nbsp;</td>
							<td nowrap>
							<?php
											$qry_per="SELECT periodo.id_periodo, ano_escolar.id_ano FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano."))";
											
											
											$result_per =pg_Exec($conn,$qry_per);
											if (pg_numrows($result_per)!=0){?>
								
								
							<!-- nuevo 	directo
								       <INPUT class="botonXX"  TYPE="button" value="E" onClick=document.location="notas/new_mostrarNotas_dav2.php3?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3">   -->
							     		
										
							<!-- antiguo con redireccion -->
							<!--<INPUT class="botonXX"  TYPE="button" value="NE" onClick=document.location="notas/grilla_notas_jscrip/new_mostrarNotas.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3">--> 
                            
                            	<!--<input name="button10"  type="button" class="botonXX" onClick=document.location="notas/grilla_notas_jscrip/new_mostrarNotas.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3" value="NE">-->
                                <? if($_PERFIL==0){?>
                            <input name="button100"  type="button" class="botonXX" onClick=document.location="notas/grilla_notas_jscrip_x/new_mostrarNotas.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3" value="E3">
							<? }?>
						
<input name="button10"  type="button" class="botonXX" onClick=document.location="notas/grilla_notas_jscrip/new_mostrarNotas.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3" value="E">
					  
								  
								  
							  <INPUT class="botonXX"  TYPE="button" value="I" onClick=document.location="InscribirAlumnos.php?id_ramo=<? echo $fila[id_ramo];?>&viene_de=listarRamos.php3&_FRMMODO=mostrar">
							  
							  <? }?>
							  <?php if ($fila['conex']==1 ) { ?> 
							  
							  <input class="botonXX"  type="button" value="SF" onClick=document.location="situacionFinal.php3?frmModo=mostrar&viene_de=listarRamos.php3&id_ramo=<? echo $fila[id_ramo];?>">
							  
							  <? }?>
							  <INPUT class="botonXX"  TYPE="button" value="A" onClick=document.location="contenido/listarContenidos.php3?viene_de=../listarRamos.php3&id_ramo=<? echo $fila[id_ramo];?>">
							  
							  <?	//if(($fila[prueba_nivel]==1)&&(( $_PERFIL==0 )||($_PERFIL==14))){	?>
							  <?	if(($fila[prueba_nivel]==1)){	?>
							  <?	//if($_PERFIL==14 && ($institucion==24977 || $institucion==25478)){	?>							  
							  <!--<INPUT class="botonXX"  TYPE="button" value="PN" onClick=document.location="notas/mostrarNotasNivel.php3?id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3">-->
							  <?	//}
							  if($_PERFIL==17 && ($institucion==24977 || $institucion==25478)){	?>							   <INPUT class="botonXX"  TYPE="button" value="PN" onClick=document.location="notas/mostrarNotasNivel.php3?id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3">
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
							<input type="button" value="AP" onClick="window.location='seteaApreciacion.php?id_ramo=<? echo $fila[id_ramo];?>&caso=1&curso=<?=$curso;?>'" class="botonXX">
							<?
							if ($_PERFIL==0 or $_PERFIL==14 or $_PERFIL==26){ ?>
							<input name="CP"  type="button" class="botonXX" id="CP" onClick="MM_openBrWindow('notas/config_porcentaje.php?id_ramo=<? echo $fila[id_ramo];?>','','scrollbars=yes,width=1000,height=300')" value="CP">
						  <? } 						
						  $conexper = $fila['conexper'];
						 
    /*AQUI ESTOY YO*/       if ($conexper==1){?>
    	
		<input name="SFP"  type="button" class="botonXX" id="SFP" onClick="window.location = 'seteaSituacionFinalPeriodo.php?&id_ramo=<? echo $fila[id_ramo];?>&caso=1&curso=<?=$curso;?>'" value="SFP">
						  <? } 	
						  //if($_PERFIL==0){
							  
                           if($fila['prueba_especial']==1){?>
    	
		<input name="PE"  type="button" class="botonXX" id="PE" onClick="window.location = 'prueba_especial.php?&id_ramo=<?=$fila[id_ramo];?>&curso=<?=$curso;?>'" value="PE">
						  <? } //}
						  if($fila['bool_nquiz']==1){
						  ?>	
                          <input name="NQ"  type="button" class="botonXX" id="NQ" onClick="window.location =' notasqz/grilla_notas_jscrip/new_mostrarNotas.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3'" value="NQ">
                          <?php }
						  if($fila['conexquiz']==1){
						  ?>	
                          <input name="EXP"  type="button" class="botonXX" id="EXQ" onClick="window.location ='examen_quiz/examen_quiz.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3'" value="EXP">
                          <?php }
						  if($fila['coef2']==1){ ?>
						  <input name="ECF2"  type="button" class="botonXX" id="ECF2" onClick="window.location ='coef2/examen.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3'" value="ECF2">
						  <? }
                           if($fila['bool_pu']==1){ ?>
						  <input name="PU"  type="button" class="botonXX" id="PU" onClick="window.location =' notaspu/grilla_notas_jscrip/new_mostrarNotas.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3'" value="PU">
						  <? }?>
                          <? if($_PERFIL==0){?>
                          <input type="button" onClick="window.location='../../../../../planificacion/unidad/unidad.php'" value="PI" class="botonXX">
                          <? }?>
                         
                            <? //if($_PERFIL==0){
								if($fila['bool_psintesis']==1){;
								?>
                          <input type="button" onClick="window.location='psintesis/psintesis.php?id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3'" value="PS" class="botonXX">
                          <? 
								}
						  //}?>
						  </td>
						</tr>
			             <?php
						 
						
					   }
				}
			?>		
		</table>
        </div>
		
		
								<?
								if ($cant_errores>0){ ?>	  
	                                  <br>
									  <table width="80%" border="1"  cellpadding="0" cellspacing="0">
									  <tr>
									  <td bgcolor="#FFFFFF">
										  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
											<tr>
											  <td width="10%"><div align="center"><img src="../../../../../icono_atencion.gif" width="33" height="28"></div></td>
											  <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" >Atenci&oacute;n esta p&aacute;gina contiene <font color="#FF0000"><b><?=$cant_errores?></b></font> observaciones, las cuales debe corregir. </font></td>
											</tr>
											<tr>
											  <td>&nbsp;</td>
											  <td>
											   <? if ($tipo_error_1==1){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><font color="#FF0000">- Falta informaci&oacute;n, </font> En uno o más campos falta informaci&oacute;n para determinar ciertos procesos. </font><br><? } ?>
											   <? if ($tipo_error_2==1){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><font color="#FF0000">- Información incorrecta, </font> Información errónea o no concuerda con la información requerida. </font><br><? } ?>
											   <? if ($error_conf==1){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><font color="#FF0000">*</font> Entre a la configuración del Curso y corriga la información faltante</font><? } ?>
											   
											   <br>											   											  
											 </td>
											</tr>
										  </table>
									  </td>
									  </tr>
									  </table>
							 <? } ?>
		
		
		</form>
	</center>
			  
<? }else{  ?>
      </td>
	  </tr>
	  </table>
 <? } ?>	  
 </div>
 <?     pg_close($conn);
	pg_close($connection);?>
    <table width="885" border="0" cellspacing="0" cellpadding=" 0">
  <tr>
    <td width="885"><img src="../../../../../cortes/<?=$institucion;?>/sombra.png" width="885" height="32" /></td>
  </tr>
</table>								  

  </td>
  </tr>
</table>  
								  
								  <!-- fin codigo antiguo -->
    </td>
  </tr>
  <tr>
    <td colspan="2" width="50" align="center"><img src="../../../../../cabecera_new/img/abajo.jpg" width="1140" height="89" border="0" /></td>
  </tr>
</table>


</body>
</html>
