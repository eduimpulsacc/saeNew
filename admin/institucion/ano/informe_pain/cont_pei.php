<?php 
require('../../../../util/header.inc');
session_start();
require "mod_pei.php";
$ob_pei = new Pain();

$funcion = $_POST['funcion'];
$institucion = $_SESSION['_INSTIT'];
if($funcion==0){
	?>
   <form id="frm1">
<table width="76%" border="0" align="center">
							  <tr><td colspan="2" class="fondo">1ro.- 
        Datos Plantilla</font>
        <input type="hidden" name="hiddenField" id="hiddenField" /></td></tr>
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
                                  <td width="92%"><?php 
	 	$sqlEns="select distinct tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo from  tipo_ense_inst inner join tipo_ensenanza on tipo_ense_inst.cod_tipo=tipo_ensenanza.cod_tipo where tipo_ense_inst.rdb='".$institucion."' and tipo_ense_inst.estado=0 or tipo_ense_inst.estado=1";
		$resultEns=pg_Exec($conn,$sqlEns);
			if (!$resultEns) {
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlEns);
			}

	 ?>
                                      <?php if($creada!=1){?>
                                      <select name="cmbEns" id="cmbEns">
                                        <option value="0" selected>Seleccione Tipo de Ense&ntilde;anza</option>
                                        <?php
		  
		  for($cEns=0 ; $cEns<pg_numrows($resultEns) ; $cEns++){
			  $filaEns=pg_fetch_array($resultEns,$cEns);
			  echo "<option value=".$filaEns['cod_tipo'].">".$filaEns['nombre_tipo']."</option>";	
		  }//fin for
		  
		  ?>
                                      </select>
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
			?>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">2.-
                                        <?php 
	  if($creada!=1){
	  echo "Seleccione grados a los que aplica esta Plantilla de Informe.";
	  }else{
	  echo "Grados a los que aplica esta Plantilla de Informe:";
	  }
	  ?>
&nbsp; <font size="2" face="Arial, Helvetica, sans-serif"><font size="1">Ed. Parvularia: SC=</font><font size="1" face="Arial, Helvetica, sans-serif"> 1&ordm; A&Ntilde;O, NMME= 2&ordm; A&Ntilde;O, NMMA= 3&ordm; A&Ntilde;O, 1NT= 4&ordm; A&Ntilde;O, 2NT= 5&ordm; A&Ntilde;O</font></font></font></td>
                                </tr>
                                <?php if($creada!=1){?>
                                <tr>
                                  <td width="8%">&nbsp;</td>
                                  <td colspan="2" class="textosesion"><table width="100%" border="0">
                                    <tr class="textosesion">
                                        <td><input name="pa" type="checkbox" id="pa" value="1">
                            PRIMER A&Ntilde;O</td>
                                        <td><input name="sa" type="checkbox" id="sa" value="1">
                            SEGUNDO A&Ntilde;O </td>
                                        <td><input name="ta" type="checkbox" id="ta" value="1">
                            TERCER A&Ntilde;O </td>

                                        <td><input name="cu" type="checkbox" id="cu" value="1">
                            CUARTO A&Ntilde;O </td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="qu" type="checkbox" id="qu" value="1">
                            QUINTO A&Ntilde;O</td>
                                        <td><input name="sx" type="checkbox" id="sx" value="1">
                            SEXTO A&Ntilde;O</td>
                                        <td><input name="sp" type="checkbox" id="sp" value="1">
                            SEPTIMO A&Ntilde;O</td>
                                        <td><input name="oc" type="checkbox" id="oc" value="1">
                            OCTAVO A&Ntilde;O</td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="nv" type="checkbox" id="nv" value="1">
                            NOVENO A&Ntilde;O</td>
                                        <td><input name="dc" type="checkbox" id="dc" value="1">
                            DECIMO A&Ntilde;O</td>
                                        <td><input name="un" type="checkbox" id="un" value="1">
                            UNDECIMO A&Ntilde;O</td>
                                        <td><input name="duo" type="checkbox" id="duo" value="1">
                            DUODECIMO A&Ntilde;O</td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="tre" type="checkbox" id="tre" value="1">
                            DECIMO TERCER A&Ntilde;O</td>
                                        <td><input name="cat" type="checkbox" id="cat" value="1">
                            DECIMO CUARTO A&Ntilde;O</td>
                                        <td><input name="quince" type="checkbox" id="quince" value="1">
                            DECIMO QUINTO A&Ntilde;O</td>
                                        <td><input name="diezseis" type="checkbox" id="diezseis" value="1">
DECIMO SEXTO A&Ntilde;O</td>
                                      </tr>
                                  </table></td>
                                </tr>
                                
                                <?php } else{?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">
                                    <?php 
		$sqlTraeGrados="SELECT * FROM informe_plantilla WHERE id_plantilla=".$plantilla;
		$resultGrados=pg_Exec($conn, $sqlTraeGrados);
			if (!$resultGrados) {
				error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$sqlTraeGrados);
			}
		for($countGr=0 ; $countGr<pg_numrows($resultGrados) ; $countGr++){
			$filaGr=pg_fetch_array($resultGrados);
			if ($filaGr['pa']==1) echo "PRIMERO   ";
			if ($filaGr['sa']==1) echo "SEGUNDO   ";
			if ($filaGr['ta']==1) echo "TERCERO   ";
			if ($filaGr['cu']==1) echo "CUARTO   ";
			if ($filaGr['qu']==1) echo "QUINTO   ";
			if ($filaGr['sx']==1) echo "SEXTO  ";
			if ($filaGr['sp']==1) echo "SEPTIMO   ";
			if ($filaGr['oc']==1) echo "OCTAVO   ";
			if ($filaGr['nc']==1) echo "NOVENO   ";
			if ($filaGr['dc']==1) echo "DECIMO   ";
			if ($filaGr['un']==1) echo "UNDECIMO   ";
			if ($filaGr['tre']==1) echo "DECIMO TERCER   ";
			if ($filaGr['duo']==1) echo "DUODECIMO   ";
			if ($filaGr['cat']==1) echo "DECIMO CUARTO   ";
			if ($filaGr['quince']==1) echo "DECIMO QUINTO   ";
			if ($filaGr['diezseis']==1) echo "DECIMO SEXTO   ";
		} ?>
                                  </font>&nbsp;</td>
                                </tr>
                                <?php }?>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">3.-
                                      Asigne un nombre a la nueva Plantilla de Informe
                                  </font> &nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td  class="textosesion">
                                    <?php if($creada!=1){
		echo "Nombre:";?>
                                    <input name="txtNombrePla" type="text" id="txtNombrePla" size="50" maxlength="50">
                                    <?php }else{
				$sqlTraeNombre="select nombre, orientacion from informe_plantilla where id_plantilla=".$plantilla;
				$resultTraeNombre=pg_Exec($conn, $sqlTraeNombre);
				if (!$resultTraeNombre) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$sqlTraeNombre);
				}
				$filaTraeNombre=pg_fetch_array($resultTraeNombre,0);
				echo "<font size=2 face=Arial, Helvetica, sans-serif>";
				echo $filaTraeNombre['nombre'];
				echo "</font>";
	  		} ?>
                                  </font></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr  >
                                  <td class="cuadro01" colspan="2">4.- Metas Plantilla</td>
                                 
                                </tr>
                                 <tr  >
                                  <td  >&nbsp;</td>
                                 <td><textarea name="textopln" cols="50" rows="5" id="textopln"></textarea></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                
                                <tr>
                                  <td colspan="2">
                                      <input class="botonXX"  type="button" name="Submit" value="GUARDAR" onClick="guardaPla()">
                                      
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2">&nbsp;</TD>
                                </tr>
                                <tr>
                                  <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">NOTA:</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">ELIMINAR: Permite eliminar la plantilla actual.</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">VOLVER : Vuelve al listado de Plantillas creadas.</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">MODIFICAR : Permite Modificar el texto de registros creados en la Plantilla actual.</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                               
	  
                              </table>
                              </form>
                              
<?

}

if($funcion==1){
//show($_POST);	
/*echo $_SESSION['_INSTIT'];*/
$pa=(isset($pa))?1:0;
$sa=(isset($sa))?1:0;
$ta=(isset($ta))?1:0;
$cu=(isset($cu))?1:0;
$qu=(isset($qu))?1:0;
$sx=(isset($sx))?1:0;
$sp=(isset($sp))?1:0;
$oc=(isset($oc))?1:0;
$nv=(isset($nv))?1:0;
$dc=(isset($dc))?1:0;
$un=(isset($un))?1:0;
$duo=(isset($duo))?1:0;
$tre=(isset($tre))?1:0;
$cat=(isset($cat))?1:0;
$quince=(isset($quince))?1:0;
$diezseis=(isset($diezseis))?1:0;

$rs_gu=$ob_pei->guardaPlantilla($conn,$institucion,$cmbEns,utf8_decode($txtNombrePla),$pa,$sa,$ta,$cu,$qu,$sx,$sp,$oc,$nv,$dc,$un,$duo,$tre,$cat,$quince,$diezseis,utf8_decode($textopln));
if($rs_gu){echo 1;}else{echo 0;}

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
 <input type="hidden" id="hiddenPlantilla" name="hiddenPlantilla" value="<?php echo $plantilla?>">

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
		 $query_ultimo_id="select max(id_item) as ultimo from  pain_area_item";
		$row_ultimo_id=pg_fetch_array(pg_exec($conn,$query_ultimo_id));
		$ultimo_id=$row_ultimo_id[ultimo];
		$ultimo_id = $ultimo_id+1;		
		 $query_ins_cat="INSERT INTO pain_area_item (id_item, id_plantilla, id_padre, glosa) VALUES($ultimo_id, $plantilla, 0, '".utf8_decode($cat[$i])."')";
		$result=pg_exec($conn,$query_ins_cat);
		 $query_ultima_cat="select max(id_item) as ultimo from  pain_area_item where id_plantilla='$plantilla' and id_padre='0'";
		$row_ultima_cat=pg_fetch_array(pg_exec($conn,$query_ultima_cat));
		$ultima_cat=$row_ultima_cat[ultimo];
		//echo "la ultima categoria es $ultima_cat <br>";
		$largo_sub=count($id_sub);
		for ($j=0;$j<$largo_sub;$j++){
			if ($i==$id_cat[$j]){
				//echo "---".$sub[$j]."<br>";
					$ultimo_id = $ultimo_id+1;
					 $query_ins_sub="INSERT INTO pain_area_item (id_item, id_plantilla, id_padre, glosa) VALUES($ultimo_id, $plantilla, '$ultima_cat', '".utf8_decode($sub[$j])."')";
					$result=pg_exec($conn,$query_ins_sub);
					echo $query_ins_sub."<br>";

				$query_ultima_sub="select max(id_item) as ultimo from  pain_area_item where id_plantilla='$plantilla' and id_padre<>'0'";					
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
					echo $query_ins_item="INSERT INTO pain_area_item (id_item, id_plantilla, id_padre, glosa,con_concepto) VALUES($ultimo_id, $plantilla, '$ultima_sub', '".utf8_decode($items[$z])."',$coc[$z])";
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

$rs_guarda = $ob_pei->guardaArea($conn,$institucion,$txt);	
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

$rs_guarda = $ob_pei->cambiaEstado($conn,$estado,$plantilla);
}

if($funcion==10){
	//show($_POST);
	$rs_plantilla = $ob_pei->traePlantilla($conn,$plantilla);
	?>
	<table width="100%" height="100%">
							<tr>
							  <td class="fondo">Informe de Plan de Apoyo Espec&iacute;fico Individual</td></tr>
                              <tr><td valign="top"><form method="post" >
                              <? $cont_radio=0;  ?>
                              <table width="76%" border="0" align="left">
                                <tr>
                                  <td colspan="2" class="cuadro01">1.-
       
		Tipo de Ense&ntilde;anza al que aplicar&aacute; este informe:
                                  </font>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="8%">&nbsp;</td>
                                  <td width="92%" class="textosesion">
                                      <?php //fin if($creada!=1)
				
				$resultTraeEns=$ob_pei->ensePlantilla($conn,$plantilla);
					
				
				$filaTraeEns=@pg_fetch_array($resultTraeEns,0);
				
				echo "<font size=2 face=Arial, Helvetica, sans-serif>";
				echo $filaTraeEns['nombre_tipo'];
				echo "</font>";
			
			?>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">2.-
                                        Grados a los que aplica esta Plantilla de Informe:
&nbsp; <font size="2" face="Arial, Helvetica, sans-serif"><font size="1">Ed. Parvularia: SC=</font><font size="1" face="Arial, Helvetica, sans-serif"> 1&ordm; A&Ntilde;O, NMME= 2&ordm; A&Ntilde;O, NMMA= 3&ordm; A&Ntilde;O, 1NT= 4&ordm; A&Ntilde;O, 2NT= 5&ordm; A&Ntilde;O</font></font></font></td>
                                </tr>
                              
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2" class="textosesion">
                                    <?php 
		
			$filaGr=pg_fetch_array($rs_plantilla,0);
			if ($filaGr['pa']==1) echo "PRIMERO   ";
			if ($filaGr['sa']==1) echo "SEGUNDO   ";
			if ($filaGr['ta']==1) echo "TERCERO   ";
			if ($filaGr['cu']==1) echo "CUARTO   ";
			if ($filaGr['qu']==1) echo "QUINTO   ";
			if ($filaGr['sx']==1) echo "SEXTO  ";
			if ($filaGr['sp']==1) echo "SEPTIMO   ";
			if ($filaGr['oc']==1) echo "OCTAVO   ";
			if ($filaGr['nc']==1) echo "NOVENO   ";
			if ($filaGr['dc']==1) echo "DECIMO   ";
			if ($filaGr['un']==1) echo "UNDECIMO   ";
			if ($filaGr['tre']==1) echo "DECIMO TERCER   ";
			if ($filaGr['duo']==1) echo "DUODECIMO   ";
			if ($filaGr['cat']==1) echo "DECIMO CUARTO   ";
			if ($filaGr['quince']==1) echo "DECIMO QUINTO   ";
			if ($filaGr['diezseis']==1) echo "DECIMO SEXTO   ";
		 ?>
                                  </font>&nbsp;</td>
                                </tr>
                                
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">3.-
                                       Nombre de la nueva Plantilla de Informe:
                                  </font> &nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td class="textosesion"><font size="2" face="Arial, Helvetica, sans-serif">
                                    
                                   <?php echo  $filaGr['nombre'] ?>
                                  </font></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                              
                                
                                <tr>
                                  <td colspan="2">         
								      <input class="botonXX"  type="button" name="cancelar" value="VOLVER" onClick="listaPlantila(<?php echo $institucion ?>)">
									
								      <input class="botonXX"  type="button" name="eliminar" value="ELIMINAR" onClick="confquitar(<?php echo $plantilla ?>,<?php echo $institucion ?>)">
								
                                      <input type="hidden" name="hiddenPlantilla" value="<?php echo $plantilla?>">
                                     
                                      <input class="botonXX" type="button" name="btn_salto" id="btn_salto" value="CONFIGURAR" onclick="configura(<? echo $plantilla;?>,<? echo $institucion;?>)" />
                                      <input class="botonXX"  type="button" name="cancelar" value="CONCEPTOS" onClick="lcon(<?php echo $plantilla ?>,<?php echo $institucion ?>)">
                                      <!--<input class="botonXX"  type="button" name="cancelar" value="AGREGAR REGISTROS" onClick="agregaReg(this.form)">-->

                                    
									  <input class="botonXX"  type="button" name="cancelar" value="PREVIEW" onClick="previa(<? echo $plantilla;?>,<? echo $institucion;?>)"> <input class="botonXX"  type="button" name="cancelar2" value="SALTOS DE PAGINA" onclick="psalto(<? echo $plantilla;?>,<? echo $institucion;?>)" /> </td>
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
                              </form></td></tr></table>
  <?
}
if($funcion==11){
	//show($_POST);
	$resultTraePlantillas=$ob_pei->plantillasTodo($conn,$rdb);
	 if($_PERFIL==0){?>
    <table width="100%" border="0">
       
        <tr> 
          <td width="69%">&nbsp;</td>
          <td width="15%">
		 
		  <input class="botonXX"  type="button" name="Submit2" value="AGREGAR" onClick="window.location='crea_pei.php'"></td>
		
          <td width="16%">&nbsp;</td>
        </tr>
      </table>
      <?php }?>
<table width="100%" border="0">
        <tr> 
          <td colspan="5" align="center"  class="tableindex">PLANTILLAS 
            PARA EVALUACION</td>
        </tr>
        <tr align="center"> 
          <td class="tablatit2-1">NOMBRE</td>
          <td class="tablatit2-1">TIPO ENSE&Ntilde;ANZA</td>
          <td class="tablatit2-1">FECHA DE CREACI&Oacute;N</td>
          <td class="tablatit2-1">ESTADO</td>
          
        </tr>
		<?php for ($countP=0 ; $countP<pg_numrows($resultTraePlantillas) ; $countP++){
				$filaP=pg_fetch_array($resultTraePlantillas);
				$fecha=$filaP['fecha_creacion'];
				
				//$qryEnse="select * from pain_area_evaluacion where id_area=".$filaP['area'];
				 $qryEnse="select nombre_tipo from tipo_ensenanza where cod_tipo=".$filaP['tipo_ensenanza'];
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
        <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' > 
          <td onClick="modPlantila(<?=$filaP["id_plantilla"]?>)"><font size="1" face="Arial, Helvetica, sans-serif" <?=$font_color?>><?php echo utf8_decode($filaP['nombre'])?>&nbsp;</font></td>
          <td align="center" onClick="modPlantila(<?=$filaP["id_plantilla"]?>)"><font size="1" face="Arial, Helvetica, sans-serif" <?=$font_color?>><?php echo $filaE['nombre_tipo']?>&nbsp;</font></td>
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
<tr class="textonegrita"><td colspan="2"><?php echo  $fila_area['glosa']?></td></tr>
<?php for($s=0;$s<pg_numrows($rs_subarea);$s++){
	$fila_subarea= pg_fetch_array($rs_subarea,$s);
	$rs_item = $ob_pei->ItemPlantilla($conn,$plantilla,$fila_subarea['id_item'])
	?>
<tr class="textonegrita" ><td colspan="2"> - <?php echo  $fila_subarea['glosa']?></td></tr>
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
