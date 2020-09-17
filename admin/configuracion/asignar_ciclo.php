<?	require('../../util/header.inc');
	//include('../clases/class_MotorBusqueda.php');
	//include('../clases/class_Membrete.php');
	//include('../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$_POSP = 2;
	$_bot = 2;
	
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

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--<link href="../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">
-->
<SCRIPT language="JavaScript">
function txt_ciclo(){
	document.form.txt_ciclo.focus();
}
function elimina_curso(id_curso,id_ciclo,ensenanza){
	window.location="procesa_ciclo.php?tipo=3&id_curso="+id_curso+"&id_ciclo="+id_ciclo+"&ensenanza="+ensenanza;
	//form.submit(true);
}
function Show_cursos(id_ciclo){
	var ensenanza = document.form.cmb_ensenanza.value;
	window.location="asignar_ciclo.php?tipo=2&id_ciclo="+id_ciclo+"&cmb_ensenanza="+ensenanza;
}
function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}


function vacio(q) {  
         for ( i = 0; i < q.length; i++ ) {  
                 if ( q.charAt(i) != " " ) {  
                         return true  
                 }  
         }  
         return false  
}  

function valida(form) {  
           
         if( vacio(form.txt_ciclo.value) == false ) {  
                 alert("Introduzca un nombre para el ciclo.")  
                 return false  
         } else {    
                 return true 
         }  
           
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

function confirmar(id_ciclo){
    if (confirm('¿Está seguro de eliminar el ciclo?')){
	    window.location='elimina_ciclo.php?id_ciclo='+id_ciclo;	
	}else{
	    return false;	
	}
}
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg');
<? if($tipo==1){?>
	txt_ciclo();
<? }?>
">
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
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="30" align="center" valign="top"></td>	  
	  <tr>		</tr> 
</table>
 								  								  
								  <? if($tipo==1){?>
								  <form id="form" name="form" action="procesa_ciclo.php?rdb=<?=$institucion?>&tipo=1&ano=<?=$ano?>" method="post" onSubmit="return valida(this);">
								  <table align="center" width="70%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td colspan="2" class="tableindex">CICLOS</td>
                                    </tr>
									<?
									 if ($situacion !=0){
									 if($ingreso==1){?>
                                    <tr>
                                      <td width="32%" align="center" class="textonegrita">Nombre Ciclo </td>
                                      <td width="68%"><input type="text" name="txt_ciclo"></td>
                                    </tr>
                                    <tr>
                                      <td>&nbsp;</td>
                                      <td><input type="submit" name="n_cliclo" id="n_ciclo" class="botonXX" value="CREAR"></td>
                                    </tr>
									<? } 
									 }?>
                                    <tr>
                                      <td colspan="2"><br><table width="100%" border="1 " cellpadding="3" cellspacing="0">
                                        <tr class="tableindex">
                                          <td width="45%">NOMBRE CICLO </td>
                                          <td width="45%">CURSOS QUE APLICA </td>
										  <? if($elimina==1){?>
                                          <td width="10%">ELIMINAR CICLO </td>
										  <? } ?>
										</tr>
										<?
										$sql = "SELECT * FROM ciclo_conf WHERE rdb=".$institucion."AND id_ano=".$ano;
										$resp = pg_exec($conn,$sql);
										$num_ciclos = pg_numrows($resp);
										for($i=0;$i<$num_ciclos;$i++){
										$fila_ciclos = pg_fetch_array($resp,$i);
										?>
                                       <!--  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=window.location='asignar_ciclo.php?tipo=2&id_ciclo=<?=$fila_ciclos['id_ciclo']?>'>
                                      <td colspan="2" class="textosesion"></td>
                                    </tr>-->
                                    <tr bgcolor=#ffffff >
									<? if($modifica==1){
											$url = "asignar_ciclo.php?tipo=2&id_ciclo=".$fila_ciclos['id_ciclo']."";
										}else{
											$url="#";
										}
									?>
                                      <td class="textosesion" onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=window.location='<?=$url;?>'><div align="left">-<?=$fila_ciclos['nomb_ciclo']?></div></td>
                                      <td class="textosesion" onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=window.location='<?=$url;?>'>
									  <? 
									   	$sql = "SELECT ciclos.id_curso FROM ciclos INNER JOIN curso ON ciclos.id_curso=curso.id_curso WHERE id_ciclo=".$fila_ciclos['id_ciclo']." ORDER BY grado_curso,letra_curso ASC";
										$resp_ciclos = pg_exec($conn,$sql);
										$num_cursos = pg_numrows($resp_ciclos);
										for($e=0;$e<$num_cursos;$e++){
											$fila_cursos = pg_fetch_array($resp_ciclos,$e);
											echo CursoPalabra($fila_cursos['id_curso'],0,$conn)."<br />";
										}
									  ?>&nbsp;</td>
                                      <? if($elimina==1){?>
									  <td class="textosesion"><div align="center">
                                        <label>
                                        <input type="button" name="elimina_ciclo" value="E" class="botonXX" onClick="confirmar(<?=$fila_ciclos['id_ciclo']?>);">
                                        </label>
                                      </div></td>
									  <? } ?>
                                    </tr>
									<? }?>
                                      </table></td>
                                    </tr>
									
                                   
                                  </table>
								  </form>
								  <? }
								  if($tipo==2){?>
								  <form id="form" name="form" action="procesa_ciclo.php?tipo=2&id_ciclo=<?=$id_ciclo?>&ano=<?=$ano?>" method="post">
								  <table width="100%" border="0" cellpadding="0" cellspacing="0">
								  <tr>
									<td colspan="5" class="tableindex">
									<?
										$resp = pg_exec($conn,"SELECT nomb_ciclo FROM ciclo_conf WHERE id_ciclo=".$id_ciclo);
										echo pg_result($resp,0);
								  ?></td>
								  </tr>
								  <? 
								  	$sql = "SELECT * FROM ciclos WHERE id_ciclo in (SELECT id_ciclo FROM ciclo_conf ";
									$sql.= " WHERE id_ciclo=".$id_ciclo." AND rdb =".$institucion." )AND id_ano=".$ano." ORDER BY id_curso ASC";
									$resp = pg_exec($conn,$sql);
									$num_cursos = pg_numrows($resp);
									for($i=0;$i<$num_cursos;$i++){
								  	$fila_cursos = pg_fetch_array($resp,$i);
								  ?>
								  <tr
								  <? if (($i % 2) ==0){ 
								  		echo "class='listadetalleoff'"; 
									}else{ 
										echo "class='listadetalleon'";
									}?>>
									<td width="9%" ><div align="center">-</div></td>
								    <td colspan="2" ><?=CursoPalabra($fila_cursos['id_curso'],0,$conn)?></td>
								    <td >&nbsp;</td>
								    <td ><? if($elimina==1){?><input type="button" name="Eliminar<?=$i?>" value="E" class="botonXX" onClick="javascript:elimina_curso(<?=$fila_cursos['id_curso']?>,<?=$id_ciclo?>,<? if(isset($cmb_ensenanza)){echo $cmb_ensenanza;}else{echo "0";}?>)"><? } ?></td>
								  </tr>
								  <? }?>
								  <tr>
									<td colspan="5">&nbsp;</td>
								  </tr>
								      <td colspan="2" class="textonegrita"><div align="right">Seleccione Tipo de Ense&ntilde;anza: &nbsp;</div></td>
								        <td colspan="3" align="left">
									<?
										$sql="SELECT * FROM tipo_ensenanza WHERE cod_tipo  ";
										$sql.="IN (SELECT ensenanza FROM curso WHERE id_ano=".$ano.") ";
										$sql.=" ORDER BY cod_tipo ASC";
										$resp_ense = pg_exec($conn,$sql);
										
									?>
									<select name="cmb_ensenanza" class="ddlb_x" onChange="javascript:Show_cursos(<?=$id_ciclo?>);">
										<option value=0 selected>(Seleccione Tipo Enseñanaza)</option>
										 <?
										 for($i=0;$i<@pg_numrows($resp_ense);$i++)
											{  
											$fila = @pg_fetch_array($resp_ense,$i); 
											if($fila['cod_tipo']==$cmb_ensenanza){
											  echo "<option value=".$fila['cod_tipo']." selected='selected'>".$fila['nombre_tipo']." </option>";
											}else{
											  echo "<option value=".$fila['cod_tipo'].">".$fila['nombre_tipo']." </option>";
											}
											}
										 ?>
									  </select>									</td>
								    </tr>
								  <tr>
								    <td colspan="2" class="textonegrita">&nbsp;</td>
								    <td colspan="3">&nbsp;</td>
								    </tr>
									<?
										$sql_cursos ="SELECT * FROM curso WHERE ensenanza=".$cmb_ensenanza." AND ";
										$sql_cursos.=" id_ano=".$ano." AND id_curso NOT IN (SELECT id_curso FROM ciclos WHERE ";
										$sql_cursos.=" id_ano=".$ano.") ORDER BY grado_curso ASC";
										$resp_cursos = pg_exec($conn,$sql_cursos);
										$num_cursos = pg_numrows($resp_cursos);
										?>
										<input type="hidden" name="count_curso" value="<?=$num_cursos?>">
										<input type="hidden" name="ensenanza" value="<?=$cmb_ensenanza?>">

										<?
										for($e=0;$e<$num_cursos;$e++){
										$fila_cursos = pg_fetch_array($resp_cursos,$e);
										$curso = $fila_cursos['id_curso'];
									?>
									  <tr>
										<td colspan="2" align="right"><input class="cuadro01" type="checkbox" name="ck_<?=$e?>" value="1"></td>
										<td colspan="3" class="textosesion">
											<input type="hidden" name="curso<?=$e?>" value="<?=$curso?>">
											<?=CursoPalabra($curso,0,$conn)?>
										</td>
									  </tr>
									<tr>
									<? }?>
									<tr>
								    <td colspan="2" class="textonegrita">&nbsp;</td>
								    <td colspan="3">
									<? if($ingreso==1 || $modifica==1){?>
									<input type="submit" name="asig_curso" value="GUARGAR" class="botonXX">
									&nbsp;&nbsp;<input type="button" name="Volver" class="botonXX" value="VOLVER" onClick="javascript:window.location='asignar_ciclo.php?tipo=1'"></td>
									<? } ?>
								    </tr>
									<? if($_PERFIL==0){?>
									<tr>
									  <td colspan="2" class="textonegrita">&nbsp;</td>
									  <td colspan="3"><input type="button" name="defecto" class="botonXX" value="DEFECTO CONF" onClick="javasctipt:window.location='procesa_ciclo.php?tipo=22&ano=<?=$ano?>'">
									  &nbsp;&nbsp;<input type="button" name="defecto" class="botonXX" value="DEFECTO CICLOS" onClick="javasctipt:window.location='procesa_ciclo.php?tipo=23&ano=<?=$ano?>'">
									  </td>
									  </tr>
									  <? }?>
								</table>
								  </form>
								<? }?>
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../cabecera/menu_inferior.php");?></td>
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