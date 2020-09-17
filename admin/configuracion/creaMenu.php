<?	require('../../util/header.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;	
	$frmModo		=$_FRMMODO;
	/*$_POSP = 4;
	$_bot = 8;*/
	
	
	

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
body{
color: #333;
font-size: 11px;
font-family: verdana;
}
a{
color: #fff;
text-decoration: none;
}
a:hover{
color: #DFE44F;
}
p{
margin: 0;
padding: 5px;
line-height: 1.5em;
text-align: justify;
border: 1px solid #CCCCCC;
}
#wrapper{
width: 950px;
margin: 0 auto;
}
.box{
background: #fff;
vertical-align:top;
background-position:top;

}
.boxholder{
clear: both;
padding: 3px;
background: #CCCCCC;
vertical-align:top;
}
.tab{
float: left;
height: 32px;
width: 150px;
margin: 0 1px 0 0;
text-align: center;
background: #CCCCCC url(images/greentab.jpg) no-repeat;
}
.tabtxt{
margin: 0;
color: #fff;
font-size: 12px;
font-weight: bold;
padding: 9px 0 0 0;
}
</style>
<script type="text/javascript" src="scripts/prototype.lite.js"></script>
<script type="text/javascript" src="scripts/moo.fx.js"></script>
<script type="text/javascript" src="scripts/moo.fx.pack.js"></script>
<script type="text/javascript">
function init(){
	var stretchers = document.getElementsByClassName('box');
	var toggles = document.getElementsByClassName('tab');
	var myAccordion = new fx.Accordion(
		toggles, stretchers, {opacity: false, height: true, duration: 600}
	);
	//hash functions
	var found = false;
	toggles.each(function(h3, i){
		var div = Element.find(h3, 'nextSibling');
			if (window.location.href.indexOf(h3.title) > 0) {
				myAccordion.showThisHideOpen(div);
				found = true;
			}
		});
		if (!found) myAccordion.showThisHideOpen(stretchers[0]);
}

var ArrayCategoria = new Array();
var contador_categoria;
<?php
	$SQL = "SELECT id_categoria,id_menu,nombre FROM menu_categoria ORDER BY nombre";
	$Conexion = @pg_exec($conn,$SQL);
	$i=0;
	if (!$Conexion){
		echo("</script><br><center><table><tr><td><b>No se pudo establecer comunicación con la base de datos 1 </b></td></tr></table></center>");
		exit();
	}
	if (@pg_numrows($Conexion)!=0){ 
		$filsprov = @pg_fetch_array($Conexion,0);
		for ($i=0;$i<@pg_numrows($Conexion);$i++){
			$filscat = @pg_fetch_array($Conexion,$i); ?>
			var ArrayFilCat = new Array(3);
			ArrayFilCat[0] = '<?php echo Trim($filscat["id_categoria"])?>';
			ArrayFilCat[1] = '<?php echo Trim($filscat["id_menu"])?>';
			ArrayFilCat[2] = '<?php echo Trim($filscat["nombre"])?>';
			ArrayCategoria[<?php echo $i?>] = ArrayFilCat;
			<?php                }
		}
@pg_close($Conexion); ?>
contador_categoria = <?php echo $i?>;

function LlenaProvincia(){
	var id_search;
	if (document.form3.cmbMENU.options.selectedIndex!=-1 || document.form3.cmbMENU.options[document.form3.cmbMENU.options.selectedIndex].value!="null"){
		id_search = document.form3.cmbMENU.options[document.form3.cmbMENU.options.selectedIndex].value;
		if (id_search!=""){
			document.form3.cmbCATEGORIA.length = 0;
			document.form3.cmbCATEGORIA.options[document.form3.cmbCATEGORIA.options.length++] = new Option("seleccione");
			document.form3.cmbCATEGORIA.options[document.form3.cmbCATEGORIA.options.length - 1].value = "null";
			for(i=0;i<=contador_categoria-1;i++){
				if (id_search==ArrayCategoria[i][1]){
					document.form3.cmbCATEGORIA.options[document.form3.cmbCATEGORIA.options.length++] = new Option(ArrayCategoria[i][2]);
					document.form3.cmbCATEGORIA.options[document.form3.cmbCATEGORIA.options.length - 1].value = ArrayCategoria[i][0];
				};
			};
		};
	};
};

function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
window.open(pagina,"",opciones);
}
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>" ></td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="top"><?
				include("../../cabecera/menu_superior.php");
				?>                </td>
              </tr>
          </table></td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><?
						$menu_lateral=2;
						include("../../menus/menu_lateral.php");
						?>              </td>
              <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td valign="top"><br />
                        <!-- INCLUYO CODIGO DE LOS BOTONES -->
                        <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="" height="30" align="center" valign="top"></td>
                          </tr>
                        </table>
                      
                      
                      <div id="wrapper">
                          <div id="content">
                            <h3 class="tab" title="Menu">
                              <div class="tabtxt"><a href="#">MEN&Uacute;</a></div>
                            </h3>
                            <div class="tab">
                              <h3 class="tabtxt" title="Categoria"><a href="#">CATEGORIA</a></h3>
                            </div>
                            <div class="tab">
                              <h3 class="tabtxt" title="item"><a href="#">ITEM </a></h3>
                            </div>
                            <div class="boxholder">
                              <div class="box"> <br />
                                  <form name="form1" action="procesoMenu.php" method="post">
                                    <input name="tipo" type="hidden" value="1" />
                                    <table width="650" border="0" align="center" cellpadding="3" cellspacing="0">
                                      <tr>
                                        <td><div align="left">Nombre Men&uacute; &nbsp;&nbsp;</div></td>
                                        <td><div align="left">
                                          <input name="txtMENU" type="text" id="txtMENU" size="30"  maxlength="50"/>
                                        </div></td>
                                        <td><div align="left">&nbsp; URL </div></td>
                                        <td><input type="text" name="txtURLMENU"  size="30"/></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><input type="submit" name="Submit" value="+"  class="botonXX"/></td>
                                      </tr>
                                      <tr>
                                        <td><div align="left">Nivel </div></td>
                                        <td><select name="cmbNIVEL">
                                          <option value="0">Admin</option>
                                          <option value="1">Cliente</option>
                                        </select></td>
                                        <td>Orden</td>
                                        <td><input name="txtORDENMENU" type="text" id="txtORDENMENU" size="5" maxlength="2" /></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td><div align="left">Permisos</div></td>
                                        <td><input name="ck_ingreso" type="checkbox" id="ck_ingreso" value="1" checked="checked" />
                                          I 
                                          <input name="ck_modifica" type="checkbox" id="ck_modifica" value="1" checked="checked" />
                                          M 
                                          <input name="ck_elimina" type="checkbox" id="ck_elimina" value="1" checked="checked" />
                                          E 
                                          <input name="ck_ver" type="checkbox" id="ck_ver" value="1" checked="checked" />
                                          V</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                    </table>
                                  </form>
                                <br />
								<hr color="#CCCCCC" />
                                  <table width="650" border="1" cellspacing="0" cellpadding="5" align="center">
                                    <tr>
                                      <td colspan="3" bgcolor="#CCCCCC"><blockquote>MEN&Uacute;</blockquote></td>
                                    </tr>
                                    <? 	$sql ="SELECT id_menu,nombre,orden FROM menu ORDER BY orden ASC";
										  		$rs_menu = @pg_exec($conn,$sql);
												for($i=0;$i<@pg_numrows($rs_menu);$i++){
													$fila_menu = @pg_fetch_array($rs_menu,$i);
										  ?>
                                    <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='ffffff' > 
                                      <td width="563">(<?=$fila_menu['orden'];?>)&nbsp;<?=$fila_menu['nombre'];?></td>
                                      <td width="26"><input name="cb_mod_menu" type="submit" id="cb_mod_menu" value="M" class="botonXX" onclick="Abrir_ventana('modificaMenu.php?nivel=1&menu=<?=$fila_menu['id_menu'];?>')" /></td>
                                      <td width="23"><input name="cb_eli_menu" type="submit" id="cb_eli_menu" value="E" class="botonXX" onclick="window.location='procesoMenu.php?tipo=4&menu=<?=$fila_menu['id_menu'];?>'"/></td>
                                    </tr>
                                    <? } ?>
                                  </table>
                                <br />
                              </div>
                              <div class="box"><br />
                                  <form name="form2" action="procesoMenu.php" method="post">
                                    <input name="tipo" type="hidden" value="2" />
                                    <table width="650" border="0" align="center" cellpadding="5" cellspacing="0">
                                      <tr>
                                        <td>Men&uacute;&nbsp;</td>
                                        <td><select name="cmbMENU">
                                            <option value="0">seleccione</option>
                                            <? for($i=0;$i<@pg_numrows($rs_menu);$i++){
													$fila_menu = @pg_fetch_array($rs_menu,$i);?>
                                            <option value="<?=$fila_menu['id_menu'];?>">
                                              <?=$fila_menu['nombre'];?>
                                          </option>
                                            <? } ?>
                                          </select>										</td>
                                        <td>&nbsp;</td>
                                        <td>Nombre Categoria &nbsp;</td>
                                        <td><input type="text" name="txtCATEGORIA"  maxlength="50"/></td>
                                        <td>&nbsp;</td>
                                        <td><input type="submit" name="Submit2" value="+"  class="botonXX"/></td>
                                      </tr>
                                      <tr>
                                        <td>Nivel</td>
                                        <td><select name="cmbNIVELC">
                                          <option value="0">Admin</option>
                                          <option value="1">Cliente</option>
                                        </select></td>
                                        <td>&nbsp;</td>
                                        <td>URL </td>
                                        <td><input name="txtURLCATEGORIA" type="text" id="txtURLCATEGORIA"  size="30"/></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td>Orden</td>
                                        <td><input name="txtORDENCATEGORIA" type="text" id="txtORDENCATEGORIA" size="5" maxlength="2" /></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td><div align="left">Permisos</div></td>
                                        <td><input name="ck_ingresoC" type="checkbox" id="ck_ingresoC" value="1" checked="checked" />
                                          I
                                          <input name="ck_modificaC" type="checkbox" id="ck_modificaC" value="1" checked="checked" />
                                          M
  <input name="ck_eliminaC" type="checkbox" id="ck_eliminaC" value="1" checked="checked" />
                                          E
  <input name="ck_verC" type="checkbox" id="ck_verC" value="1" checked="checked" />
                                          V</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                    </table>
                                  </form>
                                <br />
								  <hr color="#CCCCCC" />
								   <br />
                                  <table width="650" border="1" align="center" cellpadding="5" cellspacing="0">
                                    <tr>
                                      <td bgcolor="#CCCCCC" valign="bottom"> <blockquote>MEN&Uacute;</blockquote></td>
                                      <td bgcolor="#CCCCCC"><blockquote>CATEGORIA</blockquote></td>
                                    </tr>
									<? 	for($i=0;$i<@pg_numrows($rs_menu);$i++){
											$fila_menu = @pg_fetch_array($rs_menu,$i);
									?> 
                                     <tr>
                                      <td>(<?=$fila_menu['orden'];
 ?>)&nbsp;<?=$fila_menu['nombre'];?></td>
                                      <td><table width="100%" border="0" cellspacing="5" cellpadding="0">
									  <? 	$sql = "SELECT id_categoria, nombre, orden FROM menu_categoria WHERE id_menu=".$fila_menu['id_menu']." ORDER BY orden ASC";
									  		$rs_cat = @pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);
											for($j=0;$j<@pg_numrows($rs_cat);$j++){
												$fila_cat = @pg_fetch_array($rs_cat,$j);
									  ?>
                                        <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='ffffff'> 
                                          <td width="86%">&nbsp; (<?=$fila_cat['orden'];?>)&nbsp;<?=$fila_cat['nombre'];?></td>
                                          <td width="7%"><input name="cb_mod_cat" type="submit" id="cb_mod_cat" value="M"  class="botonXX" onclick="Abrir_ventana('modificaMenu.php?nivel=2&menu=<?=$fila_menu['id_menu'];?>&categoria=<?=$fila_cat['id_categoria'];?>')"/></td>
                                          <td width="7%"><input name="cb_eli_cat" type="submit" id="cb_eli_cat" value="E"  class="botonXX"  onclick="window.location='procesoMenu.php?tipo=5&categoria=<?=$fila_cat['id_categoria'];?>'"/></td>
                                        </tr>
									<? } ?>
                                      </table></td>
                                    </tr>
									<? } ?>
                                  </table>
                                <br />
                              </div>
                              <div class="box"><br />
                                  <form name="form3" action="procesoMenu.php" method="post">
                                    <input name="tipo" type="hidden" value="3" />
                                    <table width="800" border="0" cellspacing="0" cellpadding="3" align="center">
                                      <tr>
                                        <td>Men&uacute;&nbsp;</td>
                                        <td>
										<select name="cmbMENU" onChange="javascript:LlenaProvincia();">
										<option value="0">seleccione</option>
										<? for($i=0;$i<@pg_numrows($rs_menu);$i++){
												$fila_menu=@pg_fetch_array($rs_menu,$i);
										?>
										<option value="<?=$fila_menu['id_menu'];?>"><?=$fila_menu['nombre'];?></option>
										<? } ?>
                                        </select></td>
                                        <td>&nbsp;</td>
                                        <td>Categoria&nbsp;</td>
                                        <td>
										<select name="cmbCATEGORIA">
										<option value="">seleccione</option>
                                        </select></td>
                                        <td>&nbsp;</td>
                                        <td>Nombre Item &nbsp;</td>
                                        <td><input type="text" name="txtITEM"  maxlength="50"/></td>
                                        <td>&nbsp;</td>
                                        <td><input type="submit" name="Submit22" value="+"  class="botonXX"/></td>
                                      </tr>
                                      <tr>
                                        <td>URL</td>
                                        <td><input name="txtURLITEM" type="text" id="txtURLITEM" size="30"/></td>
                                        <td>&nbsp;</td>
                                        <td>Nivel</td>
                                        <td><select name="cmbNIVEL" id="cmbNIVEL">
                                          <option value="0">Admin</option>
                                          <option value="1">Cliente</option>
                                        </select></td>
                                        <td>&nbsp;</td>
                                        <td>Orden</td>
                                        <td><input name="txtORDENITEM" type="text" id="txtORDENITEM" size="5" maxlength="2" /></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td><div align="left">Permisos</div></td>
                                        <td><input name="ck_ingresoI" type="checkbox" id="ck_ingresoI" value="1" checked="checked" />
                                          I
                                          <input name="ck_modificaI" type="checkbox" id="ck_modificaI" value="1" checked="checked" />
                                          M
  <input name="ck_eliminaI" type="checkbox" id="ck_eliminaI" value="1" checked="checked" />
                                          E
  <input name="ck_verI" type="checkbox" id="ck_verI" value="1" checked="checked" />
                                          V</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                    </table>
                                  </form>
                                <br />
								  <hr color="#CCCCCC" />
								  <br />
                                  <table width="800" border="1" align="center" cellpadding="5" cellspacing="0">
                                    <tr>
                                      <td width="27%" bgcolor="#CCCCCC">MEN&Uacute;</td>
                                      <td width="39%" bgcolor="#CCCCCC">CATEGORIA</td>
                                      <td width="33%" bgcolor="#CCCCCC">ITEM</td>
                                    </tr>
									<? for($i=0;$i<@pg_numrows($rs_menu);$i++){
											$fila_menu = @pg_fetch_array($rs_menu,$i);
									?>		
                                    <tr>
                                      <td>&nbsp;(<?=$fila_menu['orden'];?>)&nbsp;<?=$fila_menu['nombre'];?></td>
                                      <td colspan="2">
										  <table width="100%" border="0" cellspacing="0" cellpadding="5">
											  <? $sql = "SELECT id_categoria,nombre FROM menu_categoria WHERE id_menu=".$fila_menu['id_menu'];
											  		$rs_categoria = @pg_exec($conn,$sql);
													for($j=0;$j<@pg_numrows($rs_categoria);$j++){
														$fila_cat = @pg_fetch_array($rs_categoria,$j);
											  ?>
											  <tr>
												<td valign="top">&nbsp;(<?=$fila_cat['orden'];?>)&nbsp;<?=$fila_cat['nombre'];?></td>
												<td>&nbsp;
													<table width="100%" border="0" cellspacing="0" cellpadding="5">
												  	<? $sql ="SELECT id_item,nombre,orden FROM menu_categ_item WHERE id_categoria=".$fila_cat['id_categoria']." ORDER BY orden ASC";
														$rs_item = @pg_exec($conn,$sql);
														for($x=0;$x<@pg_numrows($rs_item);$x++){
															$fila_item = @pg_fetch_array($rs_item,$x);
													?>
														<tr> 
															<td>&nbsp;(<?=$fila_item['orden'];?>)&nbsp;<?=$fila_item['nombre'];?></td>
												  		    <td><input type="button" name="cb_mof_item" value="M"  class="botonXX" onclick="Abrir_ventana('modificaMenu.php?nivel=3&menu=<?=$fila_menu['id_menu'];?>&categoria=<?=$fila_cat['id_categoria'];?>&item=<?=$fila_item['id_item'];?>')"/></td>
														    <td><input type="button" name="cb_eli_item" value="E"  class="botonXX" onclick="window.location='procesoMenu.php?tipo=6&item=<?=$fila_item['id_item'];?>'" /></td>
														</tr>
													<? } ?>
												  </table>
												</td>
											  </tr>
											  <? } ?>
										</table>
								 	  </td>
                                    </tr>
									<? } ?>
                                  </table>
                                <br />
                              </div>
                            </div>
                          </div>
                      </div>
                      <script type="text/javascript">
							Element.cleanWhitespace('content');
							init();
						</script>                    </td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr align="center" valign="middle">
        <td height="45" colspan="2" class="piepagina"><? include("../../cabecera/menu_inferior.php"); ?></td>
      </tr>
    </table></td>
  </tr>
            </table>
          </td>
           <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
</body>
</html>
<? pg_close($conn);?>