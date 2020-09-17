<?	require('../../util/header.inc');
	
	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$_POSP = 4;
	$_bot = 8;
	
	
	$sql="select situacion from ano_escolar where id_ano=$ano";
	$result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
	
	
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
	}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}

/// obtener los niveles de la institución
/// listado de subsectores del curso
$qry3 = "select ciclo_conf.id_ciclo, ciclo_conf.nomb_ciclo from ciclo_conf where rdb = '$institucion' and id_ano = '$ano' ";	
$result3 =@pg_Exec($conn,$qry3);
$num3    =@pg_numrows($result3);

for ($i=0; $i < $num3; $i++){
    $fila13 = @pg_fetch_array($result3,$i);	
    $id_ciclo_[]          = $fila13['id_ciclo'];
	$nombre_ciclo_[]      = $fila13['nomb_ciclo'];	
}


/// obtener los niveles de la institución
/// listado de subsectores del curso
$qry4 = "select id_nivel, nombre from niveles order by nombre";	
$result4 =@pg_Exec($conn,$qry4);
$num4    =@pg_numrows($result4);

for ($j=0; $j < $num4; $j++){
    $fila14 = @pg_fetch_array($result4,$j);	
    $id_nivel_[]          = $fila14['id_nivel'];
	$nombre_nivel_[]      = $fila14['nombre'];	
}	
	

if (isset($_POST['guardar'])){
    for ($i=0; $i < $num3; $i++){
         //$id_ciclo_[] 
		 	   
		 if ($radio==$i){		 
	         //echo "<br>ciclo: ".$nombre_ciclo_[$i];
			      
				  for ($j=0; $j < $num4; $j++){
					   			       
					   $nivel = "nivel".$j;
					   $nivel = $$nivel;
					   					   
					   if ($nivel=="1"){
					        //echo "<br> nivel: ".$nombre_nivel_[$j];
							// borra primero la información para no ingresarla dos veces
							$sql_borrar = "delete from ciclo_niveles where id_ciclo = '$id_ciclo_[$i]' and id_nivel = '$id_nivel_[$j]' and id_ano = '$ano' and rdb = '$institucion'";
							$res_borrar = @pg_Exec($conn, $sql_borrar);							
							
							// guardar información
							$sql_insert = "insert into ciclo_niveles (id_ciclo, id_nivel, id_ano, rdb) values ('$id_ciclo_[$i]','$id_nivel_[$j]','$ano','$institucion')";
							$res_insert = @pg_Exec($conn, $sql_insert);
							
					   }else{
					        // eliminar
					        $sql_borrar = "delete from ciclo_niveles where id_ciclo = '$id_ciclo_[$i]' and id_nivel = '$id_nivel_[$j]' and id_ano = '$ano' and rdb = '$institucion'";
							$res_borrar = @pg_Exec($conn, $sql_borrar);
					  				
					   }		
				  
				  }	
			 
			    			 
		 }	 		 
    }
}


if (isset($_POST['actualizar'])){
    $sql_cic_niv2 = "select * from ciclo_niveles where rdb = '$institucion' order by id_ciclo, id_nivel";
    $res_cic_niv2 = @pg_Exec($conn, $sql_cic_niv2);
    for ($i=0; $i < @pg_numrows($res_cic_niv2); $i++){
	     $fil_cic_niv2 = @pg_fetch_array($res_cic_niv2,$i);
	     $id_ciclo_inst2_[]    = $fil_cic_niv2['id_ciclo'];
	     $id_nivel_inst2_[]    = $fil_cic_niv2['id_nivel'];
		 
		  $nivel = "nivel".$i;
		  $nivel = $$nivel;
		  
		  if ($nivel!="1"){
		       // borro
			   $qry_del = "delete from ciclo_niveles where rdb = '$institucion' and id_ciclo = '$id_ciclo_inst2_[$i]' and id_nivel = '$id_nivel_inst2_[$i]'";
			   $res_del = @pg_Exec($conn, $qry_del);
		  }		 
	}     
}	




/// seleccionamos los ciclos - niveles que tiene esta institución
$sql_cic_niv = "select * from ciclo_niveles where rdb = '$institucion' order by id_ciclo, id_nivel";
$res_cic_niv = @pg_Exec($conn, $sql_cic_niv);
for ($i=0; $i < @pg_numrows($res_cic_niv); $i++){
	$fil_cic_niv = @pg_fetch_array($res_cic_niv,$i);
	$id_ciclo_inst_[]    = $fil_cic_niv['id_ciclo'];
	$id_nivel_inst_[]    = $fil_cic_niv['id_nivel'];
	
	// rescatar el nombre del ciclo
	$qry_nom_cic = "select ciclo_conf.id_ciclo, ciclo_conf.nomb_ciclo from ciclo_conf where rdb = '$institucion' and id_ano = '$ano' and id_ciclo = '$id_ciclo_inst_[$i]' ";	
    $res_nom_cic = @pg_Exec($conn,$qry_nom_cic);
    $fil_nom_cic = @pg_fetch_array($res_nom_cic,0);	
    $nombre_ciclo_inst_[] = $fil_nom_cic['nomb_ciclo'];	
	
	
    
	// rescatamos el nombre del nivel
	$qry_nom_niv = "select id_nivel, nombre from niveles where id_nivel = '$id_nivel_inst_[$i]'";	
    $res_nom_niv = @pg_Exec($conn,$qry_nom_niv);
    $fil_niv     = @pg_fetch_array($res_nom_niv,0);	
    $nombre_nivel_inst_[] = $fil_niv['nombre'];
	
}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
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

function muestra(div){
     if (div=="agregar"){
          document.getElementById('agregar').style.visibility='visible';
		  document.getElementById('agregar').style.display='block';
	      document.getElementById('listado').style.display='none';
	 }
	 if (div=="listado"){
          document.getElementById('listado').style.display='block';
	      document.getElementById('agregar').style.display='none';
	 }
}


//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="muestra('listado');">
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
                                  <td valign="top">
								  
								  <div id="listado">
								  <form name="form1" method="post" action="#">
								  <table width="100%" border="0" cellpadding="3" cellspacing="3">
                                    <tr>
                                      <td colspan="3" class="tableindex">CONFIGURACI&Oacute;N CICLOS NIVELES </td>
                                      </tr>
                                    <tr>
                                      <td width="30%">&nbsp;</td>
                                      <td width="10%">&nbsp;</td>
                                      <td width="60%" align="right">
									  <? 
									  if ($situacion !=0){
									  if($ingreso==1){?>
									  <input type="button" name="Submit" value="AGREGAR / RELACIONAR" class="botonXX" onClick="muestra('agregar');">
									  <? } ?>
                                        <label>
									  <? if($modifica==1){?>
                                        <input type="submit" name="actualizar" value="ACTUALIZAR" class="botonXX">
										</label>
									  <? } 
									  }// cierre if año escolar?>								
	                                    </td>
                                      </tr>
                                    <tr>
                                      <td class="tabla01"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">CICLOS</font></td>
                                      <td class="tabla01"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">NIVELES</font></td>
                                      <td align="center" class="tabla01">&nbsp;</td>
                                      </tr>
									<?
									for ($i=0; $i < @pg_numrows($res_cic_niv); $i++){
										?>  
										<tr>
										  <td><input type="hidden" name="radio" value="<?=$i?>">&nbsp;<font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=$nombre_ciclo_inst_[$i]?></font></td>
										  <td><input type="checkbox" name="nivel<?=$i?>" value="1" class="botonXX" checked="checked">&nbsp;<font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=$nombre_nivel_inst_[$i]?></font></td>
										  <td align="center"></td>
									    </tr>
                                  <? } ?>
                                  </table>
								  </form>
								  </div>
								  
							  <div id="agregar" style="visibility:hidden">
							  <form name="form1" method="post" action="#">
							  <table width="100%" border="0" cellpadding="3" cellspacing="3">
                                <tr>
                                  <td colspan="2" class="tableindex">RELACI&Oacute;N CICLO NIVELES </td>
                                  </tr>
                                <tr>
                                  <td colspan="2" align="right"><label>
                                    <input name="guardar" type="submit"  class="botonXX" id="guardar" value="GUARDAR">
                                  </label>
                                    <label>
                                    <input type="button" name="Submit3" value="VOLVER"  class="botonXX" onClick="muestra('listado');">
                                    </label></td>
                                  </tr>
                                <tr>
                                  <td width="50%" class="tabla01"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">CICLOS</font></td>
                                  <td width="50%" class="tabla01"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">NIVELES</font></td>
                                </tr>
                                <tr>
                                  <td valign="top">
								   <?
								   for ($i=0; $i < $num3; $i++){
                                   ?>
                                    <table width="100%" border="0">
                                      <tr>
                                        <td width="1%"><input name="radio" type="radio"  class="botonXX" value="<?=$i?>" <? if ($i==0){ ?> checked <? } ?>></td>
                                        <td width="99%"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=$nombre_ciclo_[$i]?></font></td>
                                      </tr>
                                    </table>
                                  <? } ?>
								     </td>
                                  <td valign="top">
								   <?
								   for ($j=0; $j < $num4; $j++){
                                   ?>
                                    <table width="100%" border="0">
                                      <tr>
                                        <td width="1%"><input type="checkbox" name="nivel<?=$j?>" value="1"  class="botonXX"></td>
                                        <td width="99%"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=$nombre_nivel_[$j]?></font></td>
                                      </tr>
                                    </table>
                                   <? } ?>  
									</td>
                                </tr>
                              </table>
							  </form>
							  </div>
								  
								  
								  
								  </td>
                                </tr>
                              </table>							  
							                                
							  </td>
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
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>