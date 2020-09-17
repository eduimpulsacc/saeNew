<?php 
require('../../../../util/header.inc');
session_start();
require "mod_pei.php";
$ob_pei = new Pei();

$funcion = $_POST['funcion'];
$institucion = $_SESSION['_INSTIT'];
if($funcion==0){
	?>
<div id="cmdd" title="Nueva &aacute;rea de evaluaci&oacute;n"></div>
<table width="76%" border="0" align="center">
							  <tr><td colspan="2" class="fondo">1ro.- 
        &Aacute;rea de evaluaci&oacute;n</font></td></tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">1.-
                                        <?php if($creada!=1){
        echo "Seleccione el Tipo de Ense&ntilde;anza al que aplicar&aacute; este informe.";
		}else{
		echo "Tipo de Ense&ntilde;anza al que aplicar&aacute; este informe:";
		}
		?>
                                  </font>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="8%">&nbsp;</td>
                                  <td width="92%">
								  <div id="areae">
								  <?php 
	 	$sqlEns="select * from pei_area_evaluacion where rdb='".$institucion."' order by nombre";
		$resultEns=pg_Exec($conn,$sqlEns);
			if (!$resultEns) {
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlEns);
			}

	 ?>
                                      <?php if($creada!=1){?>
                                     <span id="carea"> <select name="cmbArea" id="cmbArea">
                                        <option value="0" selected>Seleccione &Aacute;rea</option>
                                        <?php
		  
		  for($cEns=0 ; $cEns<pg_numrows($resultEns) ; $cEns++){
			  $filaEns=pg_fetch_array($resultEns,$cEns);
			  echo "<option value=".$filaEns['id_area'].">".$filaEns['nombre']."</option>";	
		  }//fin for
		  
		  ?>
                                      </select></span>
                                      <?php }else{ //fin if($creada!=1)
				$sqlTraeEns="select nombre_tipo from tipo_ensenanza inner join informe_plantilla on tipo_ensenanza.cod_tipo=informe_plantilla.tipo_ensenanza where informe_plantilla.id_plantilla=".$plantilla;
				$resultTraeEns=pg_Exec($conn,$sqlTraeEns);
					if (!$resultTraeEns) {
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$sqlTraeEns);
					}

				$filaTraeEns=@pg_fetch_array($resultTraeEns,0);
				echo "<font size=2 face=Arial, Helvetica, sans-serif>";
				echo $filaTraeEns['nombre_tipo'];
				echo "</font>";
			}
			?></span>
                                   <span>   <img src="../../../clases/img_jquery/iconos/function_icon_set/add_48.png" width="24" height="24" onclick="creaarea()"></span></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <?php if($creada!=1){?>
                                
                                <?php } else{?>
                                <?php }?>
                                <!--    <tr> 
      <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">4.- 
	  <?php 
		// echo "FORMATO DE IMPRESION";
	  ?>
	  </font></td>
    </tr>
     <tr> 
      <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">
	  <?php // if($creada!=1){?>
	          VERTICAL 
        <input type="radio" name="orientacion" value="0">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	  HORIZONTAL 
        <input type="radio" name="orientacion" value="1">
		<?php /*}else{
		if($filaTraeNombre['orientacion']==1) $impresion="HORIZONTAL";
		if($filaTraeNombre['orientacion']==0) $impresion="VERTICAL";
		}
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $impresion;*/
		 ?>
        </font></td>
    </tr>
	<TR><TD>&nbsp;</TD></TR> -->
                                <tr>
                                  <td colspan="2" class="cuadro01">2.- Asigne </font> &nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td  class="textosesion">
                                    <?php if($creada!=1){?>
									T&iacute;tulo Informe Educacional:
                                    <input name="txtNombre" type="text" id="txtNombre" size="30" maxlength="100">
                                  
                                    <?php }else{
				$sqlTraeTitulo="select nombre,  from pei_plantilla where id_plantilla=".$plantilla;
				$resultTraeTitulo=pg_Exec($conn, $sqlTraeTitulo);
				if (!$resultTraeTitulo) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$sqlTraeTitulo);
				}
				$filaTraeTitulo=pg_fetch_array($resultTraeTitulo,0);	
					echo "Reporte &nbsp;&nbsp;3: ".$filaTraeTitulo['titulo_informe1'];	
					
			} ?>
                                  </font></td>
                               
                                </tr>
                                 <tr>
                                  <td colspan="2">
                                      <input class="botonXX"  type="button" name="Submit" value="GUARDAR" onClick="guardaPla()">
                                      
                                  </td>
                                </tr>
                               
</table>
<?

}

if($funcion==1){
/*show($_POST);	
echo $_SESSION['_INSTIT'];*/
$rs_gu=$ob_pei->guardaPlantilla($conn,$institucion,$area,utf8_decode($nombre));

}
if($funcion==2){
$rs_car=$ob_pei->ulPlantilla($conn,$institucion);
$row_planilla = pg_fetch_array($rs_car,0);
?>
 <input type="hidden" id="hiddenPlantilla" value="<?php echo $row_planilla['id_plantilla']?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td class="fondo"><span class="Estilo5">2do.- Crear Conceptos evaluativos</span> (<? echo $row_planilla['nombre'];?>) </td>
</tr>
<tr><td> <input name="agrega" type="button" value="Agregar" class="botonXX" onClick="insRow('mytable')">
 								 <input name="elimina" type="button" value="Eliminar" class="botonXX" onClick="delRow('mytable')"> </td></tr>
</table><br>

<table width="95%" >
                                   
                                      <tr>
                                        <td width="33%" class="Estilo5"><span class="Estilo11">Nombre</span></td>
                                        <td width="33%" class="Estilo5"><span class="Estilo11">Sigla</span></td>
                                        <td width="33%" class="Estilo5"><span class="Estilo11">Glosa</span></td>
                                      </tr>
                                      <tr>
                                        <td colspan="3">
                                        <form id="aru" >
                                        <table id="mytable" width="100%">
                                        </table>
                                        </form>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="3">
											<input name="guardar" type="button" class="botonXX" value="Siguiente Paso" onClick="guardaConc()"></td>
                                      </tr>
                                   
                              </table>
<?	
}
if($funcion==3){
//show($_POST);
$a_nombre = explode(",",$nombre);
$a_glosa = explode(",",$glosa);
$a_sigla = explode(",",$sigla);
//var_dump($cuenta);
for($i=0;$i<count($a_nombre);$i++){
	$rs = $ob_pei->guardaConcepto($conn,$plantilla,utf8_decode($a_nombre[$i]),utf8_decode($a_glosa[$i]),utf8_decode($a_sigla[$i]));
}

}

if($funcion==4){
//show($_POST);
$rs_car=$ob_pei->traeconc($conn,$plantilla);

$row_planilla = pg_fetch_array($rs_car,0);
?>
<form id="frimtm">
<input type="hidden" name="ss">
 <input type="hidden" id="hiddenPlantilla" name="hiddenPlantilla" value="<?php echo $row_planilla['id_plantilla']?>">

<table width="100%" >
<tr>
<td class="fondo"><span class="Estilo5">2do.- Crear Conceptos evaluativos</span> (<? echo $row_planilla['nombre'];?>) </td>
</tr>
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
<tr>
  <td align="right"><input  type="button" name="siguiente"  value="Continuar" class="botonXX" onClick="guadaItem()"></td></tr>
</table>
</form>
<?
}
if($funcion==5){
//show($_POST);
$plantilla = $hiddenPlantilla;
	$largo_cat=count($cat);
	for ($i=0;$i<$largo_cat;$i++){
		//echo $cat[$i]."<br>";
		 $query_ultimo_id="select max(id_item) as ultimo from  pei_area_item";
		$row_ultimo_id=pg_fetch_array(pg_exec($conn,$query_ultimo_id));
		$ultimo_id=$row_ultimo_id[ultimo];
		$ultimo_id = $ultimo_id+1;		
		 $query_ins_cat="INSERT INTO pei_area_item (id_item, id_plantilla, id_padre, glosa) VALUES($ultimo_id, $plantilla, 0, '".utf8_decode($cat[$i])."')";
		$result=pg_exec($conn,$query_ins_cat);
		 $query_ultima_cat="select max(id_item) as ultimo from  pei_area_item where id_plantilla='$plantilla' and id_padre='0'";
		$row_ultima_cat=pg_fetch_array(pg_exec($conn,$query_ultima_cat));
		$ultima_cat=$row_ultima_cat[ultimo];
		//echo "la ultima categoria es $ultima_cat <br>";
		$largo_sub=count($id_sub);
		for ($j=0;$j<$largo_sub;$j++){
			if ($i==$id_cat[$j]){
				//echo "---".$sub[$j]."<br>";
					$ultimo_id = $ultimo_id+1;
					 $query_ins_sub="INSERT INTO pei_area_item (id_item, id_plantilla, id_padre, glosa) VALUES($ultimo_id, $plantilla, '$ultima_cat', '".utf8_decode($sub[$j])."')";
					$result=pg_exec($conn,$query_ins_sub);
					//echo $query_ins_sub."<br>";

				$query_ultima_sub="select max(id_item) as ultimo from  pei_area_item where id_plantilla='$plantilla' and id_padre<>'0'";					
				$row_ultima_sub=pg_fetch_array(pg_exec($conn,$query_ultima_sub));
				$ultima_sub=$row_ultima_sub[ultimo];
				//echo "la ultima sub- categoria es $ultima_sub<br>";

					
				$largo_items=count($items);	
				$coc=explode(",",$searchNom);
				for ($z=0;$z<$largo_items;$z++){
				//echo "($id_cat1[$z]---$id_sub1[$z])($i---$id_sub[$j])-->$items[$z].<br>";
					if (($id_sub1[$z]==$j)&&($id_cat1[$z]==$i)){
					//echo "------".$items[$z]."<br>";
					$ultimo_id = $ultimo_id+1;
					
					//$tcone=(!isset($searchNom[$z]))?0:1;
					echo $query_ins_item="INSERT INTO pei_area_item (id_item, id_plantilla, id_padre, glosa,con_concepto) VALUES($ultimo_id, $plantilla, '$ultima_sub', '".utf8_decode($items[$z])."',$coc[$z])";
					$result=pg_exec($conn,$query_ins_item);
					//echo $query_ins_sub."<br>";


					//."($id_cat1[$z]---$id_sub1[$z])($i---$j])</font><br>";
					}
				}
			}
		}
	}	
	
}
if($funcion==6)
{
//show($_POST);
?>
<input type="text" id="nombre_clas" />
<?
}
if($funcion==7){

$rs_guarda = $ob_pei->guardaArea($conn,$institucion,utf8_decode($txt));	
}
if($funcion==8){
	
	$resultEns = $ob_pei->traeArea($conn,$institucion);
	?>
    <select name="cmbArea" id="cmbArea">
                                        <option value="0" selected>Seleccione &Aacute;rea</option>
                                        <?php
		  
		  for($cEns=0 ; $cEns<pg_numrows($resultEns) ; $cEns++){
			  $filaEns=pg_fetch_array($resultEns,$cEns);
			  echo "<option value=".$filaEns['id_area'].">".$filaEns['nombre']."</option>";	
		  }//fin for
		  
		  ?>
                                      </select>
    <?
}
if($funcion==9){
//show($_POST);
$rs_plan = $ob_pei->cambiaEstado($conn,$estado,$plantilla);

}
if($funcion==10){
//show($_POST);
$rs_plantilla = $ob_pei->traePlantilla($conn,$plantilla);
$fila_plantilla = pg_fetch_array($rs_plantilla,0);
$rs_tenplan = $ob_pei->areaPlantilla($conn,$fila_plantilla['area']);
$fila_templan = pg_fetch_array($rs_tenplan,0); 
?>
<table width="76%" border="0" align="left">
<tr>
  <td class="fondo" colspan="2">Informe Plan Espec&iacute;fico Individual (PEI)</td></tr>
                                <tr>
                                  <td width="92%" colspan="2" >&nbsp;</td>
                                </tr>
                               
                                <tr class="cuadro01">
                                  <td colspan="2" >1.- &Aacute;rea de evaluaci&oacute;n                                  </td>
                                </tr>
                                
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2" class="textosesion"><?php echo $fila_templan['nombre'] ?></td>
                                </tr>
                                
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">3.-	   Nombre de la nueva Plantilla de Informe:	  </td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td class="textosesion"><font size="2" face="Arial, Helvetica, sans-serif">
                                   
				<font size=2 face=Arial, Helvetica, sans-serif><?php echo $fila_plantilla['nombre']; ?>
				</font>
                                  </font></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <!--    <tr> 
      <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">4.- 
	  <?php 
		// echo "FORMATO DE IMPRESION";
	  ?>
	  </font></td>
    </tr>
     <tr> 
      <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">
	  <?php // if($creada!=1){?>
	          VERTICAL 
        <input type="radio" name="orientacion" value="0">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	  HORIZONTAL 
        <input type="radio" name="orientacion" value="1">
		<?php /*}else{
		if($filaTraeNombre['orientacion']==1) $impresion="HORIZONTAL";
		if($filaTraeNombre['orientacion']==0) $impresion="VERTICAL";
		}
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $impresion;*/
		 ?>
        </font></td>
    </tr>
	<TR><TD>&nbsp;</TD></TR> -->
                                
                                </tr>
                               
                                <tr>
                                  <td colspan="2">         
								      <input class="botonXX"  type="button" name="cancelar" value="VOLVER" onClick="listaPlantila(<?php echo $fila_plantilla['rdb'] ?>);">
									
								      <input class="botonXX"  type="button" name="eliminar" value="ELIMINAR" onClick="confquitar(<?php echo $plantilla ?>,<?php echo $institucion ?>)">
									
                                      <input type="hidden" name="hiddenPlantilla" value="<?php echo $plantilla?>">
                                      <input class="botonXX"  type="button" name="cancelar3" value="CONFIGURAR" onclick="configura(<? echo $plantilla;?>,<? echo $institucion;?>)" />
                                      <input class="botonXX"  type="button" name="cancelar" value="CONCEPTOS" onClick="lcon(<?php echo $plantilla ?>,<?php echo $institucion ?>)">
                                      <!--<input class="botonXX"  type="button" name="cancelar" value="AGREGAR REGISTROS" onClick="agregaReg(this.form)">-->

                                      <input class="botonXX"  type="button" name="cancelar2" value="SALTOS DE PAGINA" onclick="psalto(<? echo $plantilla;?>,<? echo $institucion;?>)" />
<input class="botonXX"  type="button" name="cancelar" value="PREVIEW" onClick="previa(<? echo $plantilla;?>,<? echo $institucion;?>)">
									  
                                      
                                         
                                </td>
                                </tr>
                                <tr>
                                  <td colspan="2">&nbsp;</TD>
                                </tr>
                                <tr>
                                  <td colspan="2" class="textosesion"><font size="1" face="Arial, Helvetica, sans-serif">NOTA:</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="textosesion"><font size="1" face="Arial, Helvetica, sans-serif">ELIMINAR: Permite eliminar la plantilla actual.</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="textosesion"><font size="1" face="Arial, Helvetica, sans-serif">VOLVER : Vuelve al listado de Plantillas creadas.</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="textosesion"><font size="1" face="Arial, Helvetica, sans-serif">MODIFICAR : Permite Modificar el texto de registros creados en la Plantilla actual.</font></td>
                                </tr>
                                
                             
                              </table>
                              <?
}
if($funcion==11){
	
	$resultTraePlantillas=$ob_pei->plantillasTodo($conn,$rdb);
?>
 <?php if($_PERFIL==0){?>
<table width="76%%" border="0">
        <tr> 
          <td width="69%">&nbsp;</td>
          <td align="right">
		
		  <input class="botonXX"  type="button" name="Submit2" value="AGREGAR" onClick="window.location='crea_pei.php'"></td>
        </tr>
      </table><br />
<?php }?>
<table width="76%" border="0" align="center"  >
        <tr> 
          <td colspan="5" align="center"  class="tableindex">PLANTILLAS 
            PARA EVALUACION</td>
        </tr>
        <tr align="center"> 
          <td class="tablatit2-1">NOMBRE</td>
          <td class="tablatit2-1">AREA REVISION</td>
          <td class="tablatit2-1">FECHA DE CREACI&Oacute;N</td>
          <td class="tablatit2-1">ESTADO</td>
          <!--<td class="tablatit2-1">HABILITADO</td>-->
        </tr>
		<?php for ($countP=0 ; $countP<pg_numrows($resultTraePlantillas) ; $countP++){
				$filaP=pg_fetch_array($resultTraePlantillas);
				$fecha=$filaP['fecha_creacion'];
				
				$qryEnse="select * from pei_area_evaluacion where id_area=".$filaP['area'];
				$resultEnse=pg_exec($conn, $qryEnse);
					if (!$resultEnse) {
						error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>'.$qryEnse);
					}
				
				$filaE=@pg_fetch_array($resultEnse,0);
				
				if ($filaP['activa'] == 1) {
					$font_color = 'color="#336633"';
				} else {
					$font_color = 'color="#990000"';
				}
		?>
        <tr bgcolor="#ffffff" onMouseOver="this.style.backgroundColor = 'yellow';" onmouseout="this.style.backgroundColor = '#FFFFFF';" > 
          <td onClick="modPlantila(<?=$filaP["id_plantilla"]?>)"><font size="1" face="Arial, Helvetica, sans-serif" <?=$font_color?>><?php echo $filaP['nombre']?>&nbsp;</font></td>
          <td align="center" onClick="modPlantila(<?=$filaP["id_plantilla"]?>)"><font size="1" face="Arial, Helvetica, sans-serif" <?=$font_color?>><?php echo $filaE['nombre']?>&nbsp;</font></td>
          <td align="center" onClick="modPlantila(<?=$filaP["id_plantilla"]?>)"><font size="1" face="Arial, Helvetica, sans-serif" <?=$font_color?>><?php impF ($fecha)?>&nbsp;</font></td>
         
         <td align="center"><input type="button" name="button" id="button" value="<?php echo ($filaP['activa']==1)?"Desactivar":"Activar" ?>" class="botonXX" onClick="est(<?php echo $filaP['id_plantilla'] ?>,<?php echo ($filaP['activa']==1)?"0":"1" ?>)"></td>
        </tr>
		<?php } ?>
      </table>
<?
}
if($funcion==12){

$rs_cuenta =$ob_pei->tengoEvas($conn,$plantilla);
echo(pg_result($rs_cuenta,0)>0)?1:0;

}
if($funcion==13){
	//qplantilla
	//show($_POST);
	$rs_borra =$ob_pei->qplantilla($conn,$plantilla);
}
if($funcion==14){
//show($_POST);
$rs_area = $ob_pei->nivel1Plantilla($conn,$plantilla);
$rs_conc = $ob_pei->traeconc($conn,$plantilla);
?>
<input class="botonXX"  type="button" name="cancelar" value="VOLVER" onClick="modPlantila(<?php echo $plantilla ?>);">
<table border="1">
<tr>
<td colspan="2"  valign="bottom" class="textonegrita">glosa-nombre</td>
</tr>
<?php for($a=0;$a<pg_numrows($rs_area);$a++){
	$fila_area= pg_fetch_array($rs_area,$a);
	$rs_subarea = $ob_pei->subareaPlantilla($conn,$plantilla,$fila_area['id_item'])
	 ?>
<tr class="textonegrita"><td colspan="2"><?php echo  $fila_area['glosa']?></td></tr>
<?php for($s=0;$s<pg_numrows($rs_subarea);$s++){
	$fila_subarea= pg_fetch_array($rs_subarea,$s);
	$rs_item = $ob_pei->ItemPlantilla($conn,$plantilla,$fila_subarea['id_item'])
	?>
<tr class="textonegrita" ><td colspan="2"> - <?php echo  $fila_subarea['glosa']?></td></tr>
<?php for($i=0;$i<pg_numrows($rs_item);$i++){ 
$fila_item= pg_fetch_array($rs_item,$i);
?>
<tr class="textosimple" ><td>&nbsp;&nbsp;&nbsp;<?php echo  $fila_item['glosa']?></td><td>
<?php if($fila_item['con_concepto']==1){?>
<select>
<?php for($c=0;$c<pg_numrows($rs_conc);$c++){
	$fila_conc=pg_fetch_array($rs_conc,$c);
	?>
<option><?php echo $fila_conc['nombre'] ?></option>
<?php }?>
</select>
<?php }else{echo "&nbsp;";}?></td></tr>
<?php } //item?>
<?php }//subarea?>
<?php }//area?>
</table>
<?
}
if($funcion==15){
//show($_POST);
$rs_area = $ob_pei->nivel1Plantilla($conn,$plantilla);
$rs_conc = $ob_pei->traeconc($conn,$plantilla);
?>
<form id="gc">
<input class="botonXX"  type="button" name="cancelar" value="VOLVER" onClick="modPlantila(<?php echo $plantilla ?>);">
<table border="1">
<tr>
<td  valign="bottom" class="textonegrita">glosa-nombre</td>
<td  valign="bottom" class="textonegrita">Evaluable</td>
</tr>
<?php for($a=0;$a<pg_numrows($rs_area);$a++){
	$fila_area= pg_fetch_array($rs_area,$a);
	$rs_subarea = $ob_pei->subareaPlantilla($conn,$plantilla,$fila_area['id_item'])
	 ?>
<tr class="textonegrita"><td><?php echo  $fila_area['glosa']?></td>
  <td>&nbsp;</td>
</tr>
<?php for($s=0;$s<pg_numrows($rs_subarea);$s++){
	$fila_subarea= pg_fetch_array($rs_subarea,$s);
	$rs_item = $ob_pei->ItemPlantilla($conn,$plantilla,$fila_subarea['id_item'])
	?>
<tr class="textonegrita" ><td> - <?php echo  $fila_subarea['glosa']?></td>
  <td>&nbsp;</td>
</tr>
<?php for($i=0;$i<pg_numrows($rs_item);$i++){ 
$fila_item= pg_fetch_array($rs_item,$i);
?>
<tr class="textosimple" ><td>&nbsp;&nbsp;&nbsp;<?php echo  $fila_item['glosa']?><input name="itm[]" type="hidden" value="<?php echo $fila_item['id_item'] ?>" /></td><td><input name="conc[]" type="checkbox" value="<?php echo $fila_item['id_item'] ?>" <?php echo ($fila_item['con_concepto']==1)?"checked":"" ?> class="itm"/>
</td></tr>
<?php } //item?>
<?php }//subarea?>
<?php }//area?>
</table><br />
<input type="button" value="GUARDAR CAMBIOS" onclick="cambiaConc(<?php echo $plantilla ?>,<?php echo $institucion ?>)" class="botonXX" />
</form>
<?
}
if($funcion==16){
//show($_POST);
$conc=explode(",",$_POST['searchIDs']);
//echo count($conc);
$borra = $ob_pei->borraEstado($conn,$plantilla);
	for($c=0;$c<count($conc);$c++){
		//echo $conc[$c];	
		$cambia = $ob_pei->cambiaEstadoItem($conn,$plantilla,$conc[$c]);
	}	
}
if($funcion==17){
$rs_area = $ob_pei->nivel1Plantilla($conn,$plantilla);
$rs_conc = $ob_pei->traeconc($conn,$plantilla);
?>
<form id="gc">
<input class="botonXX"  type="button" name="cancelar" value="VOLVER" onClick="modPlantila(<?php echo $plantilla ?>);">
<table border="1">
<tr>
<td  valign="bottom" class="textonegrita">glosa-nombre</td>
<td  valign="bottom" class="textonegrita">Salto de P&aacute;gina</td>
</tr>
<?php for($a=0;$a<pg_numrows($rs_area);$a++){
	$fila_area= pg_fetch_array($rs_area,$a);
	$rs_subarea = $ob_pei->subareaPlantilla($conn,$plantilla,$fila_area['id_item'])
	 ?>
<tr class="textonegrita"><td><?php echo  $fila_area['glosa']?></td>
  <td><input name="conc[]" type="checkbox" value="<?php echo $fila_area['id_item'] ?>" <?php echo ($fila_area['salto_pagina']==1)?"checked":"" ?> class="itm"/></td>
</tr>
<?php for($s=0;$s<pg_numrows($rs_subarea);$s++){
	$fila_subarea= pg_fetch_array($rs_subarea,$s);
	$rs_item = $ob_pei->ItemPlantilla($conn,$plantilla,$fila_subarea['id_item'])
	?>
<tr class="textonegrita" ><td> - <?php echo  $fila_subarea['glosa']?></td>
  <td><input name="conc[]" type="checkbox" value="<?php echo $fila_subarea['id_item'] ?>" <?php echo ($fila_subarea['salto_pagina']==1)?"checked":"" ?> class="itm"/></td>
</tr>
<?php for($i=0;$i<pg_numrows($rs_item);$i++){ 
$fila_item= pg_fetch_array($rs_item,$i);
?>
<tr class="textosimple" ><td>&nbsp;&nbsp;&nbsp;<?php echo  $fila_item['glosa']?><input name="itm[]" type="hidden" value="<?php echo $fila_item['id_item'] ?>" /></td><td><input name="conc[]" type="checkbox" value="<?php echo $fila_item['id_item'] ?>" <?php echo ($fila_item['salto_pagina']==1)?"checked":"" ?> class="itm"/>
</td></tr>
<?php } //item?>
<?php }//subarea?>
<?php }//area?>
</table><br />
<input type="button" value="GUARDAR CAMBIOS" onclick="cambiaSalto(<?php echo $plantilla ?>,<?php echo $institucion ?>)" class="botonXX" />
</form>
<? }
if($funcion==18){
//show($_POST);
$conc=explode(",",$_POST['searchIDs']);
//echo count($conc);
$borra = $ob_pei->borraSalto($conn,$plantilla);
	for($c=0;$c<count($conc);$c++){
		//echo $conc[$c];	
		$cambia = $ob_pei->poneSalto($conn,$plantilla,$conc[$c]);
	}	
}

if($funcion==19){
	$result_todos =$ob_pei->traeconc($conn,$plantilla);
	?>
    <input class="botonXX"  type="button" name="cancelar" value="VOLVER" onClick="modPlantila(<?php echo $plantilla ?>);"><br />
    <div id="lcon">
<table>
 <tr>
  	<td colspan="5"><strong>Conceptos existentes</strong></td>
  </tr>
									<tr> 
										 <td width="33%"><strong>Nombre</strong></td>
                                        <td width="33%"><strong>Sigla</strong></td>
                                        <td width="33%"><strong>Glosa</strong></td>
                                        
										 <td width="33%">&nbsp;</td>
									</tr>
									<? 
									  $num_todos=pg_numrows($result_todos);?>
									  <? for ($i=0;$i<$num_todos;$i++){
									  $row_todos=pg_fetch_array($result_todos,$i);
									  ?>
  <tr id="tringresa_<? echo $row_todos['id_concepto'];?>"> 
										 <td width="33%" class="cuadro01"><? echo $row_todos['nombre'];?></td>
										<td width="33%" class="cuadro01"><? echo $row_todos['sigla'];?></td>
										<td width="33%" class="cuadro01"><? echo $row_todos['glosa'];?></td>
										
										<td nowrap>
										  <input type="button" value="Modificar"  onclick="cambia('tringresa_<? echo $row_todos['id_concepto'];?>','trmodifica_<? echo $row_todos['id_concepto'];?>')" class="botonXX">
										  <input  type="button" value="Eliminar"  onClick="eliminarconc('<? echo $row_todos[nombre];?>','<? echo $row_todos['id_concepto'];?>','<?php echo $plantilla ?>')" class="botonXX"></td>
									</tr>
									<form onSubmit="return valida(this);" method="post">
									<tr id="trmodifica_<? echo $row_todos['id_concepto'];?>" style="display:none "> 
										 <td width="33%" class="cuadro01"><input name="nombre" type="text" value="<? echo trim($row_todos['nombre']);?>" id="nombre_<? echo $row_todos['id_concepto'];?>"></td>
                                        <td width="33%" class="cuadro01"><input name="sigla" type="text" value="<? echo trim($row_todos['sigla']);?>" maxlength="10" id="sigla_<? echo $row_todos['id_concepto'];?>"></td>
                                        <td width="33%" class="cuadro01"><input name="glosa" type="text" value="<? echo trim($row_todos['glosa']);?>" id="glosa_<? echo $row_todos['id_concepto'];?>"></td>
                                        
										  <td width="33%" nowrap>
										  <input name="id_concepto" type="hidden" value="<? echo $row_todos[id_concepto];?>" id="concepto_<? echo $row_todos['id_concepto'];?>"> 
										  <input  name="modificar"type="button" value="Guardar" class="botonXX" onclick="modc(<? echo $row_todos['id_concepto'];?>,<?php echo $plantilla ?>)" >
									  <input  type="button" value="Cancelar" onClick="cambia('trmodifica_<? echo $row_todos['id_concepto'];?>','tringresa_<? echo $row_todos['id_concepto'];?>')" class="botonXX"></td>
									</tr>
									</form>
									<? }?>
									
									</table>
                                    </div>
<br />
<br />
<div id="ncon">
<table>
								  	<tr>
								  	  <td><strong>Nuevo Concepto</strong></td>
								  	</tr>
									<tr><td>
									<form method="post" onSubmit="return valida(this);" >
									<table>
									<tr> 
										 <td width="33%"><strong>Nombre</strong></td>
                                        <td width="33%"><strong>Sigla</strong></td>
                                        <td width="33%"><strong>Glosa
                                          <input type="hidden" name="ipp" id="ipp" value="<?php echo $plantilla ?>" />
                                        </strong></td>
									</tr>
									<tr> 
										 <td width="33%"><input name="nombre" id="n_nombre"></td>
                                        <td width="33%"><input name="sigla" id="n_sigla" maxlength="10"></td>
                                        <td width="33%"><input name="glosa" id="n_glosa"> </td>
									</tr>
									<tr> 
										 <td  colspan="3" align="center"><input name="nuevo" type="button" value="Guardar" class="botonXX" onclick="gcoo()"></td>
									</tr>
									</table>
									
								  </form>
								  
								
    <?
}if($funcion==20){
//show($_POST);
$rs_cuenta = $ob_pei->cuentaEvaluacionEconcepto($conn,$id_concepto);	
echo pg_result($rs_cuenta,0);
}
if($funcion==21){
show($_POST);	
$rs_cuenta = $ob_pei->qcon($conn,$id_concepto);	

}
if($funcion==22){

$rs = $ob_pei->guardaConcepto($conn,$plantilla,utf8_decode($nombre),utf8_decode($sigla),utf8_decode($glosa));	
}

if($funcion==23){

show($_POST);
$rs_up=$ob_pei->updateConcUno($conn,$concepto,utf8_decode($nombre),utf8_decode($sigla),utf8_decode($glosa),intval($orden));	
}
?>
