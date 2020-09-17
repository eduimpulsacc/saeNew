<?
require('../util/header.inc');
require_once("includes/widgets/widgets_start.php");
$institucion	=$_INSTIT;
$ano			=$_ANO;
$_POSP = 2;
$_bot = 0;
$_MDINAMICO = 1;
$perfil = $_PERFIL; 
	
$usuarioensesion = $_USUARIOENSESION;

// tomo los cursos de esta institucion
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = @pg_Exec($conn,$sql_curso);



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function valida(){

	if(!CalculaDias(form1.fecha_inicio, form1.fecha_caduca)){
		return false;
	};	
	
	if(!fechaMayorOIgualQue(form1.fecha_inicio, form1.fecha_caduca)){
	return false;
	};
	
	if(!chkVacio(form1.titulo,'Ingrese Título.')){
		return false;
	};
	

	
//	document.form1.dias.value;
	document.form1.submit();
}

function chkVacio(box,msg){
	if (box.value==''){
		alert(msg);
		box.focus();
		box.select();
		return false;
	}else{
		return true;
	};
}

function fechaMayorOIgualQue(fec1, fec0){ 
    var bRes = false; 
    var sDia0 = fec0.value.substr(0, 2); 
    var sMes0 = fec0.value.substr(3, 2); 
    var sAno0 = fec0.value.substr(6, 4); 
    var sDia1 = fec1.value.substr(0, 2); 
    var sMes1 = fec1.value.substr(3, 2); 
    var sAno1 = fec1.value.substr(6, 4); 
    if (sAno0 >= sAno1) bRes = true; 
    else { 
     if (sAno0 == sAno1){ 
      if (sMes0 >= sMes1) bRes = true; 
      else { 
       if (sMes0 == sMes1) 
        if (sDia0 >= sDia1) bRes = true; 
      } 	
     } alert("Fecha de Termino debe ser mayor o igual que Fecha de Inicio");
    } 	
    return bRes; 
}
   
function CalculaDias(fec0, fec1){ 
    var Dia0 = fec0.value.substr(8, 2); 
	var Dia1 = fec1.value.substr(8, 2); 
	
    var Mes0 = fec0.value.substr(5, 2);
    var Mes1 = fec1.value.substr(5, 2);  

    var Ano0 = fec0.value.substr(0, 4); 
    var Ano1 = fec1.value.substr(0, 4); 

	fecha1 = Mes0+"-"+Dia0+"-"+Ano0
	fecha2 = Mes1+"-"+Dia1+"-"+Ano1
	fech1=new Date(fecha1)
	fech2=new Date(fecha2)
	var tiempoRestante = fech2.getTime() - fech1.getTime();
	var dias = Math.floor(tiempoRestante / (1000 * 60 * 60 * 24));
	
	if(dias > 14)
	{	
		alert("Su periodo de caducacion es de "+dias+" dias. El periodo máximo para establecer la fecha de caducacion es de 2 semanas")
		return false	
	}else{
		return true
	}
				

}





function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr align="left" valign="top">
              <td height="75" valign="top"><?
			         include("../cabecera/menu_superior.php");
			        ?>
              </td>
            </tr>
          </table>
     
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="362" align="left" valign="top"><!-- AQUI INSERTO EL MENÚ DINÁMICO -->
                  <?
				  		$menu_lateral=5;
						include("../menus/menu_lateral.php");
						?>
              </td>
              <td width="73%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#999999">
                        <tr align="center" valign="top">
                          <td height="162" align="center"><table width="100%">
                              <tr>
                                <td class="tableindex"><div align="center">INGRESO DE INFORMACION A LA AGENDA DIARIA</div></td>
                              </tr>
                            </table>
                              <br>
							  <? 	$qry_mod = "select * from agenda where id_padre = $id_padre";
							  		$res_mod = pg_Exec($conn,$qry_mod);
									$tot_mod = pg_num_rows($res_mod);
									$fila_mod = pg_fetch_array($res_mod);
																  
							  
							  
							  ?>
                              <form action="ing_mod_agenda.php?id_padre=<?=$id_padre?>" method="post" enctype="multipart/form-data" name="form1">
                                <table width="80%" border="0" align="center" cellpadding="0" cellspacing="5">
                                  <tr>
                                    <td class="cuadro02">Fecha Inicio</td>
                                    <td class="cuadro01">
									
                                <input name="fecha_inicio" type="widget" id="fecha_inicio" size="12" maxlength="10"  subtype="wcalendar" format="%Y-%m-%d" skin="blue" language="es" label="..." mondayfirst="true" singleclick="true"  readonly="true" value="<?=$fila_mod['fecha']?>" />                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="cuadro02">Fecha Caduca</td>
                                    <td class="cuadro01">
									<? $fechacad = $fila_mod['caduca'];
									if ($fechacad == "2001-01-01"){
									    $fechacad = "";
									}	
														 									
									?>	
																	
                                      <input name="fecha_caduca" type="widget" class="texto" id="fecha_caduca" size="12" maxlength="10"  subtype="wcalendar" format="%Y-%m-%d" skin="blue" language="es" label="..." mondayfirst="true" singleclick="true"  readonly="true" value="<?=$fechacad?>"/></td>
                                  </tr>
                                  <tr>
                                    <td class="cuadro02">Publicar para</td>
                                    <td class="cuadro01">
									<? 	$Curso_pal=CursoPalabra($fila_mod['para'], 1, $conn);
										if($fila_mod['para'] == 0)$Curso_pal = "TODOS LOS CURSOS";
									?>
									<select name="cmb_curso"  class="ddlb_9_x">									
                                        <option value="<?=$fila_mod['para']?>" selected><?=$Curso_pal?></option>
                                        <?	
														if($fila_mod['para'] != 0)
															{
																echo "<option value=0>"."TODOS LOS CURSOS"."</option>";
															}
		                                               for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		                                                   {
		                                                   $fila = @pg_fetch_array($resultado_query_cue,$i); 
		                                                   if ($fila["id_curso"]==$cmb_curso){
  				                                               $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				                                               echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		                                                   }else{
  				                                               $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				                                               echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		                                                   }
                                                       }
													   ?>
                                      </select>                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="cuadro02">T&iacute;tulo</td>
                                    <td class="cuadro01"><input name="titulo" type="text" id="titulo" size="40" value="<?=$fila_mod['titulo']?>"></td>
                                  </tr>
                                  <tr>
                                    <td class="cuadro02">Detalle</td>
                                    <td class="cuadro01"><textarea name="detalle" cols="35" rows="5" id="detalle"><?=$fila_mod['detalle']?></textarea></td>
                                  </tr>
                                  <tr>
                                    <td class="cuadro02">Archivo Adjunto</td>
                                    <td class="cuadro01"><label>
                                      <input type="file" name="file">
                                    </label>
									<? if ($fila_mod['file']!=NULL){ ?>																	     
										<a href="files/<? echo $fila_mod['file']; ?>">[ Archivo Subido ]</a></td>
									<? }?>
                                  </tr>
                                  <tr>
                                    <td class="cuadro02">Subir imagen</td>
                                    <td class="cuadro01"><label>
                                      <input name="imagen" type="file" id="imagen">
									  <? 
									  if ($fila_mod['imagen']!=NULL){?>											 
									  	<img src=images/<?php echo $fila_mod['imagen'] ?>  width="50" height="50"><?
									  }?>	
                                    </label></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" class="cuadro01"><div align="center">
                                        <input name="b1" type="button" id="b1" value="Guardar" class="botonXX" onClick="valida()">
                                        <input name="b2" type="button" id="b2"  class="botonXX" onClick="MM_callJS('history.go(-1)')" value="Volver">
                                    </div></td>
								  </tr>
								  <tr>
										<td class="cuadro01" colspan="2">*NOTA: AL GUARDAR SE MODIFICARAN TODOS LOS REGISTROS QUE DURE EL EVENTO. </td>									
                                  </tr>
                                </table>
                            </form></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr align="center" valign="middle">
              <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
  </tr>
      </table>
</td>
  </tr>
</table>
</body>
</html>
<? require_once("includes/widgets/widgets_end.php");?>