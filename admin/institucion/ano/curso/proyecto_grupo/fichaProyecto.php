<?	require('../../../../../util/header.inc');


	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 6;

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
		$_ITEM = $item;
		session_register('_ITEM');
	}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}


$sql = "SELECT * FROM alumno_proyecto WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_proy=".$cmbPROYECTO." AND rut_alumno=".$cmbALUMNO."";
$rs_existe = @pg_exec($conn,$sql);
$fila_alumno = @pg_fetch_array($rs_existe,0);
	
if($cmbALUMNO!=0 && $cmbPROYECTO!=0 && $caso!=2){
	
	if(@pg_numrows($rs_existe)>0){
		$caso=4;
	}else{
		$caso=1;
	}
	
}

function CambioFechaDisplay($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m."/".$a;
	else
		$retorno="";
	return $retorno;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="javascript" src="../../../../clases/jquery/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/themes/smoothness/jquery.ui.datepicker.css">
<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/themes/smoothness/jquery.ui.all.css">

<SCRIPT language="JavaScript">




function enviapag(form){
	form.action='fichaProyecto.php';
	form.submit(true);
}		

function mform(caso,id){
$('#tblform').css('display','block');
if(caso==0)
	{
	$('#caso').val(1);
	var caso2=1;
	var fecha="";
	$('#dataint').css('display','none');
	$('#btnag').css('display','none');
		
	}
else{
	$('#caso').val(2);
	var caso2=2;
	var fechar=$('#hidden_fecha_'+id+'').val();
	$('#dataint').css('display','none');
	$('#btnag').css('display','none');
	
		
}

//alert(fechar);
	//invocar formulario
		$.ajax({
			url:"data_proyecto.php",
			data:"caso="+caso2+"&cmbPROYECTO="+$('#cmbPROYECTO').val()+"&cmbALUMNO="+$('#cmbALUMNO').val()+"&fechar="+fechar,
			type:'POST',
			success:function(data){
			$('#tblform').html(data);
			$('#fa2').val(fechar);
	  }
	  });  
	 
}	

/*function ver_fecha(){
	var fecha = $('#fecha_reporte').val();
	alert(fecha);

		//invocar formulario
		$.ajax({
			url:"data_proyecto.php",
			data:"v_fecha=1&cmbPROYECTO="+$('#cmbPROYECTO').val()+"&cmbALUMNO="+$('#cmbALUMNO').val()+"&fecha_reporte="+$('#fecha_reporte').val(),
			type:'POST',
			success:function(data){
			//$('#tblform').html(data);
			alert(data);
	  }
	  });  
	
	}	*/
		
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
.Estilo16 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo21 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
.Estilo22 {font-size: 10}
.Estilo25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style> 

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg');
<? if($tipo==1){?>
	txt_ciclo();
<? }?>
">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>"></td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<?
				include("../../../../../cabecera/menu_superior.php");
				?></td>
              </tr>
          </table></td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><?
						$menu_lateral=3;
						include("../../../../../menus/menu_lateral.php");
						?>              <span class="textosimple">
                
              </span></td>
              <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  
                  <tr>
                    <td height="395" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                        <tr>
                          <td valign="top"><!-- INCLUYO CODIGO DE LOS BOTONES -->
                              
                            <form id="form" name="form" action="procesaProyecto.php" method="post">
                              <input name="caso" id="caso" value="<?=$caso;?>"  type="hidden">
                                <input name="id_pro" value="<?=$id_pro;?>" type="hidden">
                                <table width="650" border="0" align="center" cellpadding="5" cellspacing="0">
                                  <tr>
                                    <td width="289"><span class="Estilo16">Proyecto Intergraci&oacute;n o Grupo Diferencial </span></td>
                                    <td width="3"><strong>:</strong></td>
                                    <td width="328">
									<?  $sql = "SELECT id_proy,nombre,tipo FROM proyecto_grupo WHERE rdb=".$institucion." ORDER BY tipo ASC";
										$rs_proyecto = @pg_exec($conn,$sql);
									?>
									<select name="cmbPROYECTO" id="cmbPROYECTO" onChange="enviapag(this.form)">
										<option value="0">seleccione</option>
										<? for($i=0;$i<@pg_numrows($rs_proyecto);$i++){
												$fila_pro = @pg_fetch_array($rs_proyecto,$i);
											if($fila_pro['tipo']==1){
												if($fila_pro['id_proy']==$cmbPROYECTO){?>
													<option value="<?=$fila_pro['id_proy'];?>" selected="selected"><?=$fila_pro['nombre']." (PI)";?></option>
												<? }else{?>
													<option value="<?=$fila_pro['id_proy'];?>"><?=$fila_pro['nombre']." (PI)";?></option>
												<? } ?>
											<? }else{?>
												<? if($cmbPROYECTO==$fila_pro['id_proy']){ ?>
													<option value="<?=$fila_pro['id_proy'];?>" selected="selected"><?=$fila_pro['nombre']." (GD)";?></option>
												<? }else{ ?>
													<option value="<?=$fila_pro['id_proy'];?>"><?=$fila_pro['nombre']." (GD)";?></option>
												<? } ?>
										<? 	   }
										} ?>
									</select>
									&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td><span class="Estilo16">Alumno</span></td>
                                    <td><strong>:</strong></td>
                                    <td>
									<? $sql = "SELECT   DISTINCT b.rut_alumno,a.id_curso,b.nombre_alu || cast(' ' as varchar) || b.ape_pat || CAST(' ' as varchar ) || ape_mat as nombre FROM matricula a INNER JOIN alumno b ON a.rut_alumno=b.rut_alumno WHERE a.id_ano=".$ano." AND b.rut_alumno in (SELECT rut_alumno FROM inscribe_proyecto where id_proy=".$cmbPROYECTO.") ORDER BY nombre ASC";
										$rs_alumno = @pg_exec($conn,$sql);
									?>
									<select name="cmbALUMNO" onChange="enviapag(this.form)" id="cmbALUMNO">
										<option value="0">seleccione</option>
										<? for($i=0;$i<@pg_numrows($rs_alumno);$i++){
												$fila_alu = @pg_fetch_array($rs_alumno,$i);
											if($fila_alu['rut_alumno']==$cmbALUMNO){?>
												<option value="<?=$fila_alu['rut_alumno'];?>" selected="selected"><?=strtoupper($fila_alu['nombre']);?></option>
											<? }else{ ?>
												<option value="<?=$fila_alu['rut_alumno'];?>"><?=strtoupper($fila_alu['nombre']);?></option>
											<? } ?>
										<? } ?>											
									</select>
									</td>
                                  </tr>
                              </table>
								<br>
								<? if($cmbPROYECTO!=0 && $cmbALUMNO!=0){ ?>
								<table width="650" border="0" align="center">
                                  <tr>
                                    <td><div align="right" id="btnag">
                                    <input type="button" name="agr" value="AGREGAR" class="botonXX" onClick="mform(0,'')">
                                   <!-- &nbsp;
									  	<input type="submit" name="Submit" value="GUARDAR" class="botonXX">
										&nbsp;<input type="button" name="button" value="CANCELAR" class="botonXX" onClick="window.location='fichaProyecto.php'">-->
                                    </div></td>
                                  </tr>
                                </table>
								<br>
								<table width="650" border="0" align="center">
                                  <tr>
                                    <td class="tableindex">
									<? 	$sql = "SELECT * FROM proyecto_grupo WHERE id_proy=".$cmbPROYECTO;
										$rs_pro = @pg_exec($conn,$sql);
										$fila_proy = @pg_fetch_array($rs_pro,0);
										if($fila_proy['tipo']==1){
											echo "PROYECTO DE INTEGRACIÓN";
										}else{
											echo "GRUPO DIFERENCIAL ";
										}
									?>
									
									&nbsp;</td>
                                  </tr>
                                </table>
								<br>
								<?php
								$qryp="select * from alumno_proyecto where rdb=$institucion and id_ano =$ano and id_proy=$cmbPROYECTO and rut_alumno=$cmbALUMNO";
								$rsp= @pg_exec($conn,$qryp);
								if(@pg_num_rows($rsp)>0){
								 ?>
								<table width="650" border="0" align="center" cellpadding="3" cellspacing="5" id="dataint">
								  <tr><td colspan="5" class="tableindex">Registros asociados</td></tr>
                                <tr>
                                  <td width="93" class="tableindex">N&deg;</td>
                                  <td width="93" class="tableindex">Fecha</td>
                                  <td width="302" class="tableindex">Instituci&oacute;n que emite informe</td>
                                  <td colspan="2" align="center" class="tableindex">Acciones</td>
                                  </tr>
                               <?php for($p=0;$p<@pg_num_rows($rsp);$p++){
								   $filp=@pg_fetch_array($rsp,$p);
								   ?>
                                <tr>
                                  <td class="textosimple"><?php echo $p+1 ?>&nbsp;</td>
                                  <td class="textosimple"><?php echo CambioFechaDisplay($filp['fecha_reporte']) ?><input type="hidden" id="hidden_fecha_<?php echo $p+1?>" name="hidden_fecha" value="<?php echo $filp['fecha_reporte'] ?>"></td>
                                  <td class="textosimple"><?php echo $filp['institucion'] ?></td>
                                  <td width="109" align="center" class="textosimple"><input type="button" name="modificar" value="MODIFICAR" class="botonXX" onClick="mform(1,<?php echo $p+1 ?>)"></td>
                                  <td width="97" align="center" class="textosimple"><input type="button" name="modificar2" value="ELIMINAR" class="botonXX" onClick="window.location='procesaProyecto.php?caso=3&cmbPROYECTO=<?=$cmbPROYECTO;?>&cmbALUMNO=<?=$cmbALUMNO;?>&hidden_fecha=<?php echo $filp['fecha_reporte'] ?>'"></td>
                                </tr>
                                <?php }//fin registros?>
                              </table>
                                <?php }//fin conteo
								else{?>
                                 <table width="650" border="0" align="center" cellpadding="3" cellspacing="5"> <tr><td align="center" class="textosimple">No se encuentran registros asociados</td></tr>
                                <tr></table>
                                <?php } ?>
                                
								<? } ?>
								<br>
                                <div id="tblform" >
                                
                                </div>
								<br>
                            </form></td>
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
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
   </tr>
      </table>
 </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>