<?php require('../../../util/header.inc');
$plantilla	=$_PLANTILLA;
$area		=$_AREA;
$concepto	=$_CONCEPTO;
$_POSP = 3;
$_bot = 6;

$query_plantilla="select * from informe_plantilla where id_plantilla='$plantilla'";
$result_planilla=pg_exec($conn,$query_plantilla);
$num_planilla=pg_numrows($result_planilla);

if ($num_planilla>0){
	$row_planilla=pg_fetch_array($result_planilla);
	//imprime_array($row_planilla);
}
?>
<? if ($siguiente){

	$largo_cat=count($cat);
	for ($i=0;$i<$largo_cat;$i++){
		//echo $cat[$i]."<br>";
		$query_ultimo_id="select max(id) as ultimo from  informe_area_item";
		$row_ultimo_id=pg_fetch_array(pg_exec($conn,$query_ultimo_id));
		$ultimo_id=$row_ultimo_id[ultimo];
		$ultimo_id = $ultimo_id+1;		
		$query_ins_cat="INSERT INTO informe_area_item (id, id_plantilla, id_padre, glosa) VALUES($ultimo_id, $plantilla, 0, '$cat[$i]')";
		$result=pg_exec($conn,$query_ins_cat);
		$query_ultima_cat="select max(id) as ultimo from  informe_area_item where id_plantilla='$plantilla' and id_padre='0'";
		$row_ultima_cat=pg_fetch_array(pg_exec($conn,$query_ultima_cat));
		$ultima_cat=$row_ultima_cat[ultimo];
		//echo "la ultima categoria es $ultima_cat <br>";
		$largo_sub=count($id_sub);
		for ($j=0;$j<$largo_sub;$j++){
			if ($i==$id_cat[$j]){
				//echo "---".$sub[$j]."<br>";
					$ultimo_id = $ultimo_id+1;
					$query_ins_sub="INSERT INTO informe_area_item (id, id_plantilla, id_padre, glosa) VALUES($ultimo_id, $plantilla, '$ultima_cat', '$sub[$j]')";
					$result=pg_exec($conn,$query_ins_sub);
					//echo $query_ins_sub."<br>";

				$query_ultima_sub="select max(id) as ultimo from  informe_area_item where id_plantilla='$plantilla' and id_padre<>'0'";					
				$row_ultima_sub=pg_fetch_array(pg_exec($conn,$query_ultima_sub));
				$ultima_sub=$row_ultima_sub[ultimo];
				//echo "la ultima sub- categoria es $ultima_sub<br>";

					
				$largo_items=count($items);	
				for ($z=0;$z<$largo_items;$z++){
				//echo "($id_cat1[$z]---$id_sub1[$z])($i---$id_sub[$j])-->$items[$z].<br>";
					if (($id_sub1[$z]==$j)&&($id_cat1[$z]==$i)){
					//echo "------".$items[$z]."<br>";
					$ultimo_id = $ultimo_id+1;
					$query_ins_item="INSERT INTO informe_area_item (id, id_plantilla, id_padre, glosa) VALUES($ultimo_id, $plantilla, '$ultima_sub', '$items[$z]')";
					$result=pg_exec($conn,$query_ins_item);
					//echo $query_ins_sub."<br>";


					//."($id_cat1[$z]---$id_sub1[$z])($i---$j])</font><br>";
					}
				}
			}
		}
	}

header ("Location: crea_informe_4.php");
exit;

}?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script>
contador_sub=-1;
function nuevoItem(cat,pos_cat,id_sub_local,pos_sub)
{	
	largo=document.getElementById(cat).rows.length;
	var x=document.getElementById(cat).insertRow(largo);
	var y=x.insertCell(0);
	y.className="td2";
	label=pos_cat+1;
	pos_sub2=pos_sub-1;
	temp=largo+1; 		
	label=label+"."+pos_sub+"."+temp;
	y.innerHTML=label+" <input name=\"items[]\" size=70 > <input name=\"id_sub1[]\"  type=hidden  value=\""+id_sub_local+"\"><input name=\"id_cat1[]\" value=\""+pos_cat+"\"  type=hidden >";

}

function nuevaSub(cat,pos)
{	
	vhs=cat+"-----"+pos;
//	alert (vhs);
//	alert (cat);
//	cat=eval(cat);
	largo=document.getElementById(cat).rows.length;
//	alert (largo);
	var x=document.getElementById(cat).insertRow(largo);
	var y=x.insertCell(0);
	y.className="td2";
	temp=largo+1
	nombre_items="items"+pos+"_"+temp;
	temp=largo+1;
	label=pos+1;
	label=label+"."+temp;
	contador_sub=contador_sub+1;
	y.innerHTML=label+" <input name=\"sub[]\" size=70 ><input name=\"id_cat[]\" type=hidden value=\""+pos+"\"><input name=\"id_sub[]\" type=hidden  value=\""+contador_sub+"\"><input name=\"boton[]\" type=\"button\" class=\"botonXX\" value=\"Nuevo Item\"onclick=\"nuevoItem('"+nombre_items+"',"+pos+","+contador_sub+","+temp+");\">&nbsp;&nbsp;&nbsp;&nbsp;<input name=\"boton[]\" type=\"button\" class=\"botonXX\" value=\"Elimina Item\" onclick=\"eliminaItems('"+nombre_items+"');\"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<table id=\""+nombre_items+"\" ></table>";
}

function nuevaCategoria()
{
	largo=document.getElementById('tabla_categoria').rows.length;
	var x=document.getElementById('tabla_categoria').insertRow(largo);
	j=largo;
	var y=x.insertCell(0);
	y.className="td2";
	y.id="td"+j;
	nombre_sub="sub_infor"+j;
	j=j+1;
	anterior=j-1;	
	y.innerHTML="<table ><tr><td colspan=2>Categoria "+j+"<input name=\"cat[]\" size=70 ><input name=\"boton[]\" type=\"button\" class=\"botonXX\" value=\"Nueva Sub Cat\" onclick=\"nuevaSub('"+nombre_sub+"',"+anterior+");\">&nbsp;&nbsp;&nbsp;&nbsp;<input name=\"boton[]\" type=\"button\" class=\"botonXX\" value=\"Elimina Sub Cat\" onclick=\"eliminaSub('"+nombre_sub+"')\"></td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><table id=\""+nombre_sub+"\" cellpadding=\"0\" cellspacing=\"0\"></table></td></tr></table>";
}

function eliminaCategoria(){
largo=document.getElementById('tabla_categoria').rows.length;

	if (largo>0){
		largo=largo-1;
		document.getElementById('tabla_categoria').rows[largo].className="a_eliminar";
		a=confirm ('se Eliminara toda la zona con color ROJO, \r\nesta seguro');
			if (a==true){
				var x=document.getElementById('tabla_categoria').deleteRow(largo);
			}else{
				document.getElementById('tabla_categoria').rows[largo].className="normal";
			}

	}
}

function eliminaSub(subcate){
largo=document.getElementById(subcate).rows.length;

	if (largo>0){
		largo=largo-1;
		document.getElementById(subcate).rows[largo].className="a_eliminar";
		a=confirm ('se Eliminara toda la zona con color ROJO, \r\nesta seguro');
			if (a==true){
				var x=document.getElementById(subcate).deleteRow(largo);
			}else{
				document.getElementById(subcate).rows[largo].className="normal";
			}
		}
}

function eliminaItems(subcate){
largo=document.getElementById(subcate).rows.length;

	if (largo>0){
		largo=largo-1;
		document.getElementById(subcate).rows[largo].className="a_eliminar";
//		alert ("hola");
		a=confirm ('se Eliminara toda la zona con color ROJO, \r\nesta seguro');
		if (a==true){
			var x=document.getElementById(subcate).deleteRow(largo);
		}else{
			document.getElementById(subcate).rows[largo].className="normal";
		}
	}
}

</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> <td>
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			<?   //include("../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
					<?   include("../../../cabecera/menu_superior.php");?>
					</td></tr></table>
					
					</td>
                  
                  </tr>
               
					<!-- FIN DE COPIA DE CABECERA -->
                 
                </table></td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table><tr><td><?
					     $menu_lateral = 2;
						 include("../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%">
							<tr><td class="fondo">2do.- Crear Conceptos evaluativos (<? echo $row_planilla['nombre'];?>) </td>
							</tr>
                              <tr><td valign="top"><form method="post"  name="form"	>
							  
<table width="100%" >
<tr><td><table cellpadding="0" cellspacing="3">
  <tr>
    <td><input name="nueva_cat1" type="button" class="botonXX" value="Agregar Categoria" onClick="nuevaCategoria();">
    </td>
    <td><input name="elimina_cat1" type="button" class="botonXX" value="Eliminar Categoria" onClick="eliminaCategoria();">
    </td>
  </tr>
</table></td></tr><tr><td class="cuadro02">
<table><tr>
<td><img src="../../../cortes/p.gif" height="60" width="1" border="0"></td>
<td valign="top">
<table id="tabla_categoria">

</table>
</td></tr></table>
</td></tr>
<tr><td><table cellpadding="0" cellspacing="3">
  <tr><td>
  	<input name="nueva_cat2" type="button" class="botonXX" value="Agregar Categoria" onClick="nuevaCategoria();">
</td>

<td>
 	<input name="elimina_cat2" type="button" class="botonXX" value="Eliminar Categoria" onClick="eliminaCategoria();">
</td>
</tr></table></td></tr>
<tr><td align="right"><input  type="submit" name="siguiente"  value="Siguiente" class="botonXX"></td></tr>
</table>							  
</form>
							</td>
                              </tr></table>                         </td>

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
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
