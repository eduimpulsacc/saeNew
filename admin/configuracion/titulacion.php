<?	require('../../util/header.inc');
	//include('../clases/class_MotorBusqueda.php');
	//include('../../clases/class_Membrete.php');
	//include('../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
//	echo $cmb_ense;
//	echo "<br/>";
//	echo $cmb_curso;
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
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
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

		<FORM method="post" name="form" action="alumnoPractica.php">			<center>
		  <table width="95%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="6"><div align="right"> &nbsp;&nbsp;&nbsp;
                      <input align="right" type="button" name="button" id="button" value="VOLVER" class="botonXX" onClick="window.location='alumnoPractica.php?rut=<?=$rut?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>'">
              </div></td>
              <br/>
            </tr>
            <tr>
              <td colspan="6" class="tableindex">TITULACI&Oacute;N</td>
            </tr>
            <?
           		$sql= "select distinct a.nombre_tipo,b.grado_curso,letra_curso from tipo_ensenanza a ";
				$sql.=" inner JOIN curso b on (a.cod_tipo=b.ensenanza) where b.id_ano=$ano and b.ensenanza=$cmb_ense ";
				$sql.=" and b.id_curso=$cmb_curso";
		        $rs_curso = pg_exec($conn,$sql);
		   		$fila = pg_fetch_array($rs_curso,0);	
		   
		   
		   ?>
            <tr>
              <td colspan="6" class="tablatit2-1">CURSOS&nbsp;:
                <?=$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo']?></td>
              </tr>
            <tr>
              <td colspan="6" class="cuadro01"><!--<input align="right" type="button" name="agregar" id="agregar" value="AGREGAR" class="botonXX" onClick="window.location='alumnoPractica.php?rut=<?=$rut?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>'">--></td>
              </tr>
            <tr align="left">
              <td class="cuadro01"><div align="left">RUT</div></td>
              <td class="cuadro01"><div align="left">Nombre Alumno</div></td>
              <td class="cuadro01"><div align="center">Calificacion</div></td>
              <td class="cuadro01"><div align="left">Nº Titulo</div></td>
              <td class="cuadro01"><div align="left">Fecha Entrega Titulo</div></td>
            </tr>
            <?
            
					$sql=" select distinct a.rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat, ";
					$sql.="c.estado,d.id_practica,d.calificacion,e.* from alumno a  ";
					$sql.="inner join matricula b on (a.rut_alumno=b.rut_alumno) ";
					$sql.="inner join practicas c on (a.rut_alumno=c.rut_alu)  ";
					$sql.="inner join eval_practicas d on (c.id_practica=d.id_practica) ";
					$sql.="inner join titulacion e on (a.rut_alumno=e.rut_alu)";
					$sql.=" where b.rdb=$institucion and d.calificacion>40 "; //b.id_ano=$ano and b.id_curso=$cmb_curso and 
					$rs_alumno = pg_exec($conn,$sql);
					
				for($i=0;$i<pg_numrows($rs_alumno);$i++){
				   $fila = pg_fetch_array($rs_alumno,$i);
				   $rut = $fila['rut_alumno'];
				    
				   //$sql2= " select max(a.calificacion) from eval_practicas a INNER JOIN practicas b ";
				   //$sql2.=" ON (a.id_practica=b.id_practica) where b.rut_alu=$rut";
				   //$rs_sql2 = pg_exec($conn,$sql2);
				   //$total2  = pg_result($rs_sql2,0);
				   //////////////////////////////////////////////////
				   $FECHAC1= $fila['fecha_entrega_titulo'];
				   
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
					$fecha_mes1 =$dia1."-".$mes1;
					$FECHAC1 = $fecha_mes1."-".$dia11["year"];
				////////////////////////////////////////////////
			     	
			
			?>
            <tr align="center" class="cuadro01" onmouseover=this.style.background='#FFFFFF';this.style.cursor='hand' onmouseout=this.style.background='#FFFFFF' onClick="window.location='ingresartitulacion.php?id_practica=<?=$fila['id_practica']?>&rut=<?=$rut;?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>'" >
              <td class="cuadro01"><div align="left"><?=$fila['rut_alumno']."-".$fila['dig_rut'];?></div></td>
              <td class="cuadro01"><div align="left"><?=$fila['nombre_alu']." ".$fila['ape_pat'];?></div></td>
              <td class="cuadro01"><div align="center"><?=$fila['calificacion'];?></div></td>
              <td class="cuadro01"><div align="left"><?=$fila['numero_titulo'];?></div></td>
              <td colspan="2" class="cuadro01"><div align="left"><?=impF($fila['fecha_entrega_titulo']);?></div></td>
              </tr>
               <?  } ?>
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