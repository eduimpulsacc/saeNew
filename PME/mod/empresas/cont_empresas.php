<? header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "mod_empresas.php";

$obEmpresas = new Empresas($_IPDB,$_ID_BASE);

$funcion = $_POST['funcion'];

if($funcion=="Listado"){
	$result = $obEmpresas->ListadoEmpresas($_INSTIT);
	?>
	
	<BR><BR><table width='90%' border='0' align='center'>
			  <tr class='Estilo19'>
				<td>LISTADO DE EMPRESAS</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td align='right'>&nbsp;<img src="img/PNG-48/Add.png" width="30" height="30" onclick='IngresoDatos()'  onmouseover=this.style.cursor='pointer'>				  </td>
			  </tr>
			</table>
			<table width='90%' border='1' style='border-collapse:collapse' align='center'>
			  <tr class="cuadro02">
				<td>RUT</td>
				<td>RAZON SOCIAL</td>
				<td>CONTACTO</td>
				<td colspan='4' align="center">OPCIONES</td>
			  </tr>
              <? if(pg_numrows($result)!=0){
				  	for($i=0;$i<pg_numrows($result);$i++){
						$fila = pg_fetch_array($result,$i);
				?>
			  <tr class="datos">
				<td>&nbsp;<?=$fila['rut_empresa']."-".$fila['dig_rut'];?></td>
				<td>&nbsp;<?=$fila['razon_social'];?></td>
				<td>&nbsp;<?=$fila['contacto'];?></td>
				<td align="center"><img src="img/PNG-48/Modify.png" width="30" height="30" border="0" onclick="Modificar(<?=$fila['rdb'];?>,<?=$fila['rut_empresa'];?>)" onmouseover=this.style.cursor='pointer'></td>
				<td align="center"><img src="img/PNG-48/Delete.png" width="30" height="30" alt="Eliminar" border="0" onClick="Elimina(<?=$fila['rdb'];?>,<?=$fila['rut_empresa'];?>)" onmouseover=this.style.cursor='pointer'></td>
				<td align="center">
                <? if($fila['archivo']!=""){?>
                <a href="mod/empresas/images/<?=$fila['rut_empresa'].".pdf";?>" target="_blank"><img src="img/PNG-48/Picture.png" width="30" height="30" onmouseover=this.style.cursor='pointer' title="Visualizar registro ATE" /></a><!--onclick="Archivo(<?=$fila['rdb'];?>,<?=$fila['rut_empresa'];?>)"-->
                <? }else{?>
                <img src="img/PNG-48/Load.png" width="30" height="30" onmouseover=this.style.cursor='pointer' onClick="window.open('mod/empresas/frmFoto.php?rdb=<?=$_INSTIT?>&rut=<?=$fila['rut_empresa'];?>&estilo=<?=$_ESTILO;?>','','width=600,height=180,top=200,left=200')" name="btnFoto" title="Subir Imagen registro ATE"/>
                <? } ?>
                </td>
                <td align='CENTER'><a href="mailto:<?=$fila['email'];?>"><img src="img/PNG-48/Email.png" width="30" height="30"  title="Enviar Mail"/></a></td>
			  </tr>
              <?	 }
			  	}else{?>
			  <tr class="datos">
				<td colspan="6" class="textosimple">SIN INFORMACIÓN</td>
			  </tr>
              
              
              <? } ?>
			</table>
            <br />
            <br />

	
<? }

if($funcion=="Ingreso"){?>
<BR><BR><table width='90%' border='0' align='center'>
			  <tr class='Estilo19'>
				<td>REGISTRO DE EMPRESAS</td>
				
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				
			  </tr>
			  <tr>
				<td align='right'>&nbsp;<img src="img/PNG-48/Back.png" width="30" height="30" title="VOLVER" onClick="MostrarListado()"  onmouseover=this.style.cursor='pointer'>&nbsp;&nbsp;
                <img src="img/PNG-48/Save.png" id="modifica" width="30" height="30" onclick='ModificarDatos()' title="MODIFICAR"  onmouseover=this.style.cursor='pointer'>				
                <img src="img/PNG-48/Save.png" id="guarda" width="30" height="30" onclick='GuardarDatos()' title="GUARDAR" onmouseover=this.style.cursor='pointer'>
                </td>
				
			  </tr>
			</table>
            
            <table width="90%" border="1" style="border-collapse:collapse" align="center">
              <tr>
                <td class="cuadro02">&nbsp;R.U.T.</td>
                <td class="cuadro01"><p>
                  <input name="txtRUT"  id="txtRUT" type="text" size="10" maxlength="8">
                  -<input name="txtDIG" id="txtDIG" type="text" size="3" maxlength="1">
                </p></td>
                <td class="cuadro02">FOLIO</td>
                <td class="cuadro01"><input name="txtFOLIO" type="text" id="txtFOLIO" size="15"></td>
              </tr>
              <tr>
                <td class="cuadro02">RAZON SOCIAL</td>
                <td class="cuadro01"><input type="text" name="txtRAZON" id="txtRAZON"></td>
                <td class="cuadro02">E-MAIL</td>
                <td class="cuadro01"><input name="txtMAIL" type="text" id="txtMAIL" size="40"></td>
              </tr>
              <tr>
                <td class="cuadro02">DIRECCIÓN</td>
                <td class="cuadro01"><input name="txtDIREC" type="text" id="txtDIREC" size="40"></td>
                <td class="cuadro02">FAX</td>
                <td class="cuadro01"><input type="text" name="txtFAX" id="txtFAX"></td>
              </tr>
              <tr>
                <td class="cuadro02">TELEFÓNO</td>
                <td class="cuadro01"><input type="text" name="txtFONO" id="txtFONO"></td>
                <td class="cuadro02">GIRO</td>
                <td class="cuadro01"><input type="text" name="txtGIRO" id="txtGIRO" /></td>
              </tr>
              <tr>
                <td class="cuadro02">CONTACTO</td>
                <td class="cuadro01"><input type="text" name="txtCONTACTO" id="txtCONTACTO"></td>
                <td class="cuadro02">&nbsp;</td>
                <td class="cuadro01">&nbsp;</td>
              </tr>
            </table>
            <br />
            <br />

<? }

if($funcion=="Imagen"){
	$result = $obEmpresas->ArchivoATE($rdb,$rut);
	$fila = pg_fetch_array($result,0);
	
?>
	<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="mod/empresas/images/<?=$fila['archivo'];?>" width="520" height="650" /></td>
  </tr>
</table>

	
	
<?
}

if($funcion=="Modificar"){
	$result = $obEmpresas->BuscaDatos($rdb,$rut);
	$fila = pg_fetch_array($result,0);
?>
	<input type="hidden" name="_txtRUT" id="_txtRUT" value="<?=$fila['rut_empresa'];?>" />
<input type="hidden" name="_txtDIG" id="_txtDIG" value="<?=$fila['dig_rut'];?>" />
    <input type="hidden" name="_txtRAZON" id="_txtRAZON" value="<?=$fila['razon_social'];?>" />
    <input type="hidden" name="_txtFOLIO" id="_txtFOLIO" value="<?=$fila['folio'];?>" />
<input type="hidden" name="_txtDIREC" id="_txtDIREC" value="<?=$fila['direccion'];?>" />
   	<input type="hidden" name="_txtMAIL" id="_txtMAIL" value="<?=$fila['email'];?>" />
   	<input type="hidden" name="_txtFONO" id="_txtFONO" value="<?=$fila['telefono'];?>" />
   	<input type="hidden" name="_txtFAX" id="_txtFAX" value="<?=$fila['fax'];?>" />
    <input type="hidden" name="_txtCONTACTO" id="_txtCONTACTO" value="<?=$fila['contacto'];?>" />
    <input type="hidden" name="_txtGIRO" id="_txtGIRO" value="<?=$fila['giro'];?>" />
		
<? } 

if($funcion=="Actualizar"){
	//print_r($_POST);
	$result = $obEmpresas->Modificar($rdb,$rut,$folio,$razon,$direccion,$mail,$fono,$fax,$contacto,$giro);
	
	if($result){
		echo 1;	
	}else{
		echo 0;
	}	
}

if($funcion=="Guardar"){
	$result = $obEmpresas->GuardarDatos($rdb,$rut,$dig,$folio,$razon,$direccion,$mail,$fono,$fax,$contacto,$giro);
	
	if($result){
		echo 1;	
	}else{
		echo 0;
	}
}

if($funcion=="Eliminar"){
	$result = $obEmpresas->EliminaDatos($rdb,$rut);
	
	if($result){
		echo 1;
	}else{
		echo 0;
	}	
}

?>