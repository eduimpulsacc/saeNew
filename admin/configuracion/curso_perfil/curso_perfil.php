<?	require('../../../util/header.inc');
	
	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$_POSP = 3;
//	$_bot = 8;
	
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
<html><head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<SCRIPT language="JavaScript">

function cambia_grados(){
	var ano =<?=$_ANO;?>;
	var ensen = $("#cmbENSENANZA").val();
 	var parametros="funcion=1&ano="+ano+"&ensenanza="+ensen;
 $.ajax({
	  url:'cont_curso.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#grados").html(data);
		Listado();
		  }
	  })	
}
function Empleado(){
	var perfil = $("#cmbPERFIL").val(); 
 	var parametros="funcion=5&perfil="+perfil;

 $.ajax({
	  url:'cont_curso.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#personal").html(data);
		Listado();

		  }
	  })	
}
function Listado(){
	var ano =<?=$_ANO;?>;
	var ensen = $("#cmbENSENANZA").val();
	var grados = $("#cmbGRADO").val();
	var perfil = $("#cmbPERFIL").val();
	var rut	   = $("#cmbPERSONAL").val(); 
 	var parametros="funcion=2&ano="+ano+"&ensenanza="+ensen+"&grado="+grados+"&perfil="+perfil+"&rut="+rut;
 $.ajax({
	  url:'cont_curso.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#tabla").html(data);

		  }
	  })	
	
}

function agregar(id_curso,grado){
	var ensen = $("#cmbENSENANZA").val();
	var perfil = $("#cmbPERFIL").val();
	var rut	   = $("#cmbPERSONAL").val(); 
	var parametros ="funcion=3&ensenanza="+ensen+"&id_curso="+id_curso+"&perfil="+perfil+"&rut="+rut+"&grado="+grado;
	$.ajax({
		url:'cont_curso.php',
		data:parametros,
		type:'POST',
		success: function(data){
			//alert(data);
			if(data=1){
				Listado();
			}else{
				alert("ERROR DE BASE DE DATOS");	
			}
		}
	})
}

function Borrar(id_curso){
	var ensen = $("#cmbENSENANZA").val();
	var perfil = $("#cmbPERFIL").val();
	var parametros ="funcion=4&ensenanza="+ensen+"&id_curso="+id_curso+"&perfil="+perfil;
	
	$.ajax({
		url:'cont_curso.php',
		data:parametros,
		type:'POST',
		success: function(data){
			if(data=1){
				Listado();
			}else{
				alert("ERROR DE BASE DE DATOS");	
			}
		}
	})
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

<style type="text/css">
<!--
.Estilo13 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; }
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg');
<? if($tipo==1){?>
	txt_ciclo();
<? }?>
">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../cabecera/menu_superior.php");
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
						include("../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="99%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br> <br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <table width="90%" border="0" align="center">
                                      <tr>
                                        <td width="24%" class="textonegrita">Perfil</th>
                                        <td width="3%" class="textonegrita">&nbsp;:</td>
                                        <td width="73%"><select name="cmbPERFIL" id="cmbPERFIL" onChange="Empleado()">
                                        	<option value="0">seleccione...</option>
                                        <? 	 $sql="SELECT id_perfil, nombre_perfil FROM perfil WHERE id_perfil not in(0,24,59,62,63,51,57,15,16)  AND sistema=1 ORDER BY nombre_perfil ASC ";
											$rs_perfil = pg_exec($connection,$sql);
											
											for($i=0;$i<pg_numrows($rs_perfil);$i++){
												$fila = pg_fetch_array($rs_perfil,$i);
										?>
                                        	<option value="<?=$fila['id_perfil'];?>"><?=$fila['nombre_perfil'];?></option>
                                        <? } ?>
                                        </select></td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">Empleado                                        
                                        <td class="textonegrita">&nbsp;:</td>
                                        <td><div id="personal">
                                        <select name="cmbPERSONAL" id="cmbPERSONAL">
                                        	<option value="0">seleccione...</option>
                                        </select>
                                        </div></td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">Tipo de Ense&ntilde;anza</th>
                                        <td class="textonegrita">&nbsp;:</td>
                                        <td>
                                        <select name="cmbENSENANZA" id="cmbENSENANZA" onChange="cambia_grados()">
                                        	<option value="0">seleccione...</option>
                                         <? $sql="SELECT DISTINCT te.cod_tipo, nombre_tipo FROM tipo_ensenanza te INNER JOIN tipo_ense_inst tei ON te.cod_tipo=tei.cod_tipo WHERE rdb=".$_INSTIT." ORDER BY te.cod_tipo ASC";
										 	$rs_tipo = pg_exec($conn,$sql);
											for($i=0;$i<pg_numrows($rs_tipo);$i++){
												$fila = pg_fetch_array($rs_tipo,$i);
										?>
                                        	<option value="<?=$fila['cod_tipo'];?>"><?="(".$fila['cod_tipo'].") ".$fila['nombre_tipo'];?></option>
                                        <? } ?>
                                        </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">Grados</th>
                                        <td class="textonegrita">&nbsp;:</td>
                                        <td>
                                        <div id="grados">
                                        <select name="cmbGRADO" id="cmbGRADO">
                                        	<option value="0">seleccione...</option>
                                        </select>                                        
                                        </div>
                                        </td>
                                      </tr>
                                    </table><br>
<br>

                                    <div id="tabla">&nbsp;</div>

 								  								  
								 <br>
<br>

								  
								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>