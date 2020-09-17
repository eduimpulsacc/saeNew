<?php 

require('../../../../../util/header.inc');
require('../../../../../util/funciones_new.php');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
	$_POSP = 5;
	$_bot   = 5;
	
	$sql="select situacion from ano_escolar where id_ano=$_ANO";
    $result =pg_exec($conn,$sql);
    $situacion_ano=pg_result($result,0);

if ($alumno == NULL){
   $alumno = $_ALUMNO;
}   
/********DATOS PARA PAGINA HOJA DE VIDA**********************/

$c_curso=$_GET['curso'];
if(strlen($_GET['curso'])<1){
	$c_curso=$id_curso;
}
$c_ano = $_GET['c_ano'];

/*******************************/
	
	// REGISTRO DE HISTORIAL DE NAVEGACION
	registrarnavegacion($_USUARIO,'SALUD DEL ALUMNO',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);
	//******************************************************//
		
	
// TOMO LOS DATOS DEL ALUMNO
 
 $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM alumno WHERE alumno.rut_alumno='".$alumno."'";
$result =@pg_Exec($conn,$qry);
if (!$result){
    error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
}else{
   	$n1 = pg_numrows($result);
	if ($n1 > 0){
	    $fila2 = pg_fetch_array($result,0);	
		if (!$fila2){
			error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
			exit();
		}
	}
}
$rut = $fila2["rut_alumno"];

$q2="SELECT '1' tipo, id_ficha, fecha,observaciones,rut_alumno,fecha_actualizacion,apo_actualizacion 
FROM ficha_medicanew WHERE rut_alumno = '$alumno' 
UNION SELECT '2' tipo,id_fichamedica, fecha_creacion, observaciones,rut_alumno,fecha_actualizacion,apo_actualizacion 
FROM ficha_medicanew3 WHERE RUT_ALUMNO=".$alumno;
				// echo $q2;exit;
				$r2 =@pg_Exec($conn,$q2);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>						
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
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

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function imprSelec(nombre)
{
  var ficha = document.getElementById(nombre);
  var ventimp = window.open(' ', 'popimpr');
  ventimp.document.write( ficha.innerHTML);
  ventimp.document.close();
 ventimp.print( );
}

function valida_elimina(a,b,c,d,e){
    if(confirm('Esta seguro que desea eliminar registro?')){
	     window.location='elimina_medica.php?id_ficha='+a+'&alumno='+b+'&caso='+c+'&id_curso='+d+"&tipoficha="+e;
		 
	}


}

function MuestraTipos(){
	
	<?php 
	if($_PERFIL==15 || $_PERFIL==16){
		?>
	document.location="seteaFicha.php3?caso=2&alumno=<?php echo $alumno?>&tipo_hoja=<?=$tipo_hoja?>&c_ano=<?=$c_ano?>&c_curso=<?=$c_curso?>&tipo=2";
	<?php
	 }
	
	elseif($institucion != 24907 && $institucion!= 24988){ ?>
	
	document.getElementById("tipoficha").innerHTML = '<input type="radio" name="radio" id="tipo" value="tipo" onClick="document.location=\'seteaFicha.php3?caso=2&alumno=<?php echo $alumno?>&tipo_hoja=<?=$tipo_hoja?>&c_ano=<?=$c_ano?>&c_curso=<?=$c_curso?>&tipo=1\'" >Tipo 1 <input type="radio" name="radio" id="tipo" value="tipo" onClick="document.location=\'seteaFicha.php3?caso=2&alumno=<?php echo $alumno?>&tipo_hoja=<?=$tipo_hoja?>&c_ano=<?=$c_ano?>&c_curso=<?=$c_curso?>&tipo=2\'"> Tipo2';
	<?php
	}
	else{?>
	document.location="seteaFicha.php3?caso=2&alumno=<?php echo $alumno?>&tipo_hoja=<?=$tipo_hoja?>&c_ano=<?=$c_ano?>&c_curso=<?=$c_curso?>&tipo=2";
	<?php }?>
}

//-->
</script>

<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
	

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
                        <? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top">
								  <!-- inicio codigo nuevo -->
								  
								  
								  
								  
								  
								  
<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>

<table width="90%"  border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center" valign="top"> 
      <? //include("../../../../../cabecera/menu_inferior.php"); ?> </td>
  </tr>
</table>
<? } ?>
	<?php //echo tope("../../../../../util/");?>
	
				<div align="right">     
<table width="90%">
					<tr>
				<td colspan=4 align="right" >
					  <!--<input name="button3" TYPE="button" class="botonXX" onClick="MM_openBrWindow('plistarFichasAlumno.php?curso=<?=$_GET["curso"]?>&rut=<?= $fila2["rut_alumno"]?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">-->
				<? 
								
				if(($_PERFIL!=20)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)&&($_PERFIL!=2)&&($_PERFIL!=16)){ 
				
				      if (($_PERFIL==17) AND ($_INSTIT==9566))  { 
			               // no muestro
			          }
					  else{ 
					   if ($situacion_ano != 0){
						   //if conteo
						// if(pg_numrows($r2)==0){
						   ?>
                          
					       <INPUT TYPE="button" value="AGREGAR" class="botonXX"  name="agregar" onClick="MuestraTipos()"><br>

				   <? 
						// }//if conteo
						  				   }// cierre if año escolar 
					  }?>
				
				<? }
				$_FRMMODO = "mostrar";
			if($tipo_hoja!=1){
				if ($_PERFIL == 17){
				    if (($_PERFIL!=2) and ($_PERFIL!=20) and $caso!=1){
				        ?>		
					    <INPUT TYPE="button" value="VOLVER" class="botonXX"  name="agregar" onClick=document.location="../../curso/alumno/alumno.php3">
				  <? }
			    }else{
				    if ($_PERFIL != 16 and $_PERFIL != 15 and $_PERFIL!=2 and $_PERFIL!= 20 and $caso!=1){  ?>		
					  <!--  <INPUT TYPE="button" value="VOLVER" class="botonXX"  onClick=document.location="../listarAlumnosMatriculados.php3?tipoFicha=1">-->
					  <INPUT TYPE="button" value="VOLVER" class="botonXX"  onClick="history.back()" name="volver">
					    <?
					}	
				}
			}
				if($tipo_hoja==1){?>
				<!--<INPUT TYPE="button" value="VOLVER" class="botonXX"  onClick=document.location="../../curso/alumno/HojaDeVida.php?c_alumno=<?=$alumno?>&c_curso=<?=$c_curso?>&c_ano=<?=$c_ano?>">-->
				<INPUT TYPE="button" value="VOLVER" class="botonXX"  onClick="history.back()" name="volver">
				<? }
				//echo $_CURSO;
				//echo $caso;
				if($caso==1){
				?>
					<INPUT TYPE="button" value="VOLVER" class="botonXX" name="volver" onClick="document.location='../listarAlumnosMatriculados.php3?tipoFicha=1&id_curso=<?= $_GET["curso"]?>'"><!--/document.location='../../hojavida/hoja_de_vida.php?cmb_curso='/-->
				<? }			
				?>
                
				</td>
			</tr>
					<tr>
					  <td colspan=4 align="right" class="textosimple"><div id="tipoficha">
</div></td>
					  </tr>
</table>
				</div>
               
<DIV ID="seleccion">

<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
		<table WIDTH="90%" BORDER="0" align="center" CELLPADDING="3" CELLSPACING="1">

			<TR height=15>
				<TD COLSPAN=4>
					<TABLE width="100%" BORDER=0 CELLPADDING=1 CELLSPACING=1>
						<TR>
							<TD align=left class="textosimple">												INSTITUCION															</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result	 =@pg_Exec($conn,$qry);
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
									</strong>								</FONT>							</TD>
							<TD rowspan="4" align="right"><img src="enfermeria_alumno.png" width="88" height="123"></TD>
						</TR>
						<TR>
						  <TD align=left><span class="textosimple">ALUMNO</span></TD>
						  <TD><span class="Estilo11">:</span></TD>
						  <TD><span class="Estilo11"><?php echo $fila2["ape_pat"]." ".$fila2["ape_mat"].", ".$fila2["nombre_alu"];?></span></TD>
						  </TR>
						<TR>
						  <TD align=left><span class="textosimple">RUT ALUMNO </span></TD>
						  <TD><span class="Estilo11">:</span></TD>
						  <TD><span class="Estilo11"><?php echo $fila2["rut_alumno"]." - ".$fila2["dig_rut"];?></span></TD>
						  </TR>
						<TR class="textosimple">
						  <TD align=left>CURSO</TD>
						  <TD>:</TD>
						  <TD>
						    
						    <? 				 $sqlcurso="select * from curso where id_ano=".$ano." and id_curso=".$_CURSO;
											$resultcurso =@pg_Exec($conn,$sqlcurso);
											$filacurso = @pg_fetch_array($resultcurso,0);
											echo CursoPalabra($_CURSO, 1, $conn);
											?>
						    &nbsp;</TD>
						  </TR>
					</TABLE></TD>
			</TR>

			<tr height="20">
				<td align="middle" colspan="4" class="tableindex">
					
							REGISTRO DE SALUD DEL ALUMNO				</td>
			</tr>
			<tr class="tablatit2-1">
				<td align="center" width="80">ULTIMA ACTUALIZACION</td>
				<td align="center" width="220">USUARIO ACTUALIZACION</td>
				<? if ($_PERFIL==14 or $_PERFIL==0){?><td align="center" width="220">&nbsp;</td>
				<td width="220" rowspan="2" align="center">&nbsp;</td>
			</tr>
			<? } ?>
			<?php
		
		 		 
				if (!$r2) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5xx)</B>');
				}else{
					//if (pg_numrows($r2)!=0){
						//$f2 = @pg_fetch_array($r2,0);
						
						
							
						//$fecha_c = $f2['fecha'];
						//$tipo=1;
						//$ficha = $f2["id_ficha"];
						/*if (!$f2){
							error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
							exit();
						}*/
					//}else{
					//$q2.=" UNION SELECT id_fichamedica, fecha_creacion, observaciones FROM ficha_medicanew3 WHERE RUT_ALUMNO=".$alumno." AND ID_ANO=".$_ANO." AND ID_CURSO=".$c_curso;
					//$r2 =@pg_Exec($conn,$q2);
					/*if (pg_numrows($r2)!=0){
						$f2 = @pg_fetch_array($r2,0);
						$fecha_c = $f2['fecha_creacion'];
						$tipo=2;	
						$ficha = $f2["id_fichamedica"];
						if (!$f2){
							error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
							exit();
						}
					}*/
					//}
					
					//echo $q2;
					
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($r2) ; $i++){
						$f2 = @pg_fetch_array($r2,$i);
						
						$tipo = $f2['tipo'];
						
						$ficha = $f2["id_ficha"];
						$fecha_c = ($f2["fecha_actualizacion"]!="")?$f2["fecha_actualizacion"]:$f2["fecha"];
						
						$sqr3 = "select apo_actualizacion from ficha_medicanew3 where rut_alumno=".$alumno;
						
						if($f2["apo_actualizacion"]!=""){
						 $sql_apo ="select a.ape_pat || ' ' || a.nombre_apo as nombre from apoderado a where rut_apo=".$f2["apo_actualizacion"];
						$rs_apo =@pg_exec($conn,$sql_apo);
						$nombre_apo = @pg_result($rs_apo,0);

						}else{
							$nombre_apo="Sin actualizaciones";
						}


						
						?>
						
						<tr >
							 <td align="center" bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaFicha.php3?alumno=<?php echo trim($f2["rut_alumno"]);?>&idFicha=<?php echo $ficha;?>&caso=1&tipo=<?php echo $tipo ?>&c_curso=<?php echo $c_curso ?>')>
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?
									 $fecha =$fecha_c;
									 $dd = substr($fecha,8,2);
									 $mm = substr($fecha,5,2);
									 $aa = substr($fecha,0,4);
									 $fecha = "$dd-$mm-$aa";
									
									 echo $fecha;
									 
									 
									 
									 ?></strong></font></td>
							<td align="left" bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaFicha.php3?alumno=<?php echo trim($f2["rut_alumno"]);?>&idFicha=<?php echo $ficha;?>&caso=1&tipo=<?php echo $tipo ?>&c_curso=<?php echo $c_curso ?>')><font face="arial, geneva, helvetica" size="1" color="#000000"> <strong><?php echo $nombre_apo?></strong></font></td>
							<? if ($_PERFIL==14 OR $_PERFIL==0){?> <td width="5%" align="left">
							<!--<input name="Submit" type="button" class="Botonxx" onClick="MM_goToURL('parent','elimina_medica.php?id_ficha=<?php //echo $f2["id_ficha"];?>&alumno=<?php //echo trim($f2["rut_alumno"]);?>&caso=1&id_curso=<? echo $_CURSO;?>');return document.MM_returnValue" value="E" >-->
							 <input name="Submit" type="button" class="Botonxx" onClick="valida_elimina('<?php echo $ficha;?>','<?php echo trim($f2["rut_alumno"]);?>','1','<? echo $c_curso;?>','<?php echo $tipo ?>');" value="Eliminar" >				
						    </tr>	
						<? } ?>		
			<?php
					}
				}
			?>
			
		</table>
</div>				  
						  <!-- fin codigo nuevo -->
							  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php");?></td>
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
