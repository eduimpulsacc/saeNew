<?	require('../../util/header.inc');
	//include('../clases/class_MotorBusqueda.php');
	//include('../../clases/class_Membrete.php');
	//include('../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
//	echo $cmb_ense;
//	echo "<br/>";
//	echo $cmb_curso;
//	echo "<br/>";
//	echo $rut;
	
	//$curso			=$c_curso	;
	//$alumno			=$c_alumno	;
	//$reporte		=$c_reporte;
	//$_POSP = 4;
	//$_bot = 8;
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--<link href="../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">-->

<SCRIPT language="JavaScript">
function enviapag2(f1){
    f1.submit(true);		
}
function enviapag(){
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
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../cabecera/menu_superior.php");
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
						include("../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
<!--								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="" align="center" valign="top"> >>>>>>>>><? include("../../cabecera/menu_inferior.php");?></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>-->

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<center>
</center>	

		<FORM method="post" name="form" action="procesaPracticas.php">			<center>		 
		 <table width="95%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="4"><div align="right">
  &nbsp;&nbsp;&nbsp;
  <input align="right" type="button" name="button" id="button" value="VOLVER" class="botonXX" onClick="window.location='alumnoPractica.php?cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>'">
 </div></td> <br/>
              </tr>
            
           <?
            	$sql= "select rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat from alumno where rut_alumno=$rut";
				$rs_alumno = pg_exec($conn,$sql);
		   		$fila = pg_fetch_array($rs_alumno,0);	
		   
		   
		   ?>
            <tr align="left">
              <td colspan="3" class="tableindex">ALUMNO :
                <?=ucfirst($fila['nombre_alu']." ".$fila['ape_pat']." ".$fila['ape_mat'])?></td>
              <td width="25%" class="tableindex"><label></label></td>
              </tr>
            <tr>
              <td colspan="4" class="tablatit2-1"> Practicas :</td>
              </tr>
			
            <tr align="left">
              <td colspan="4" class="cuadro01">
              <input align="right" type="button" name="button2" id="button2" value="AGREGAR" class="botonXX" onClick="window.location='ingresarPractica.php?rut=<?=$rut;?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>'"></td>
              </tr>
            <? 
					$sql =" select * from practicas where rut_alu=$rut";
					$resp = pg_exec($conn,$sql);
					
			?>
            <tr align="center">
            
              <td width="26%" class="cuadro01"><div align="left">ID</div></td>
              <td width="21%" class="cuadro01"><div align="left">Nombre Empresa</div></td>
              <td width="28%" class="cuadro01"><div align="left">Encargado Alumno</div></td>
              <td class="cuadro01"><div align="left">Fecha Inicio</div></td>
            </tr>
               <?
            
				for($i=0;$i<pg_numrows($resp);$i++){
				 $lista=pg_fetch_array($resp,$i);
				 $id_practica=$lista['id_practica'];
				 
				/* $sql2="select min(calificacion) from eval_practicas where id_practica=$id_practica ";
				 $rs2= pg_exec($conn,$sql2);
				 $min= pg_result($rs2,0);   */
			
			
				//////////////////////////////////////////////////
				$FECHAC1= $lista['fecha_ini'];
				$AA1 = substr ("$FECHAC1;", 0, -7); 
				$mm1 = substr ("$FECHAC1;", 5, -4);
				$dd1 = substr ("$FECHAC1;", 8, -1);
				$dia11 = getdate(mktime(0,0,0,$mm1,$dd1,$AA1));
				$dia1 = $dia11["mday"];
				if($dia1<10){
					$dia1 = "0".$dia1;
				}else{
					$dia1;
					}
				$mes1 = $dia11["mon"];
				if($mes1<10){
					$mes1 = "0".$mes1;
				}else{
					$mes1;
				}
				$fecha_mes1 = $dia1."-".$mes1;
				$FECHAC1 = $fecha_mes1."-".$dia11["year"];
				////////////////////////////////////////////////
			
			
			
			   ?>
            <tr align="center" onmouseover=this.style.background='#FFFFFF';this.style.cursor='hand' onmouseout=this.style.background='#FFFFFF' onClick="window.location='ingresarPractica.php?id_practica=<?=$lista['id_practica'];?>&rut=<?=$rut;?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>'">
              <td class="cuadro01"><?=$lista['id_practica']?></td>
              <td class="cuadro01"><?=$lista['nombre_emp']?></td>
              <td class="cuadro01"><?=$lista['encargado_alu']?></td>
              <td class="cuadro01"><?=$FECHAC1?></td>
            </tr>  <? } ?>
          </table>
		  </FORM>
		  <!-- FIN CUERPO DE LA PAGINA -->								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>