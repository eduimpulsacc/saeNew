<?
require('../../../../../util/header.inc'); 
//include('../../../../clases/class_MotorBusqueda.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$alumno 		= $c_alumno;
	$reporte		= $c_reporte;
	$frmModo		= $_FRMMODO;
	
	$_POSP = 4;
	$_bot = 8;
	
		
	if ($dia == ""){
	   ## si el campo esta vacío poner la fecha actual
	   $dia   = strftime("%d",time());
	   $mes   = strftime("%m",time());
	   $mes   = envia_mes($mes);	   
	   $ano2  = strftime("%Y",time());
	   $mes2  = date("F"); 
	}
	 $mes2  = date("F"); 
	 
	 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<STYLE>

 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }

</style>
<script language="JavaScript" type="text/JavaScript">

function enviardatos(){
	
var cmbNIVEL = document.getElementById('cmbNIVEL').value;
var cmb_ano = document.getElementById('cmb_ano').value;
var c_reporte = document.getElementById('c_reporte').value;

	if ( cmb_ano == "0" ){		
		alert('DEBE SELECCIONAR UN AÑO');
		return false;
		};
		
	if ( cmbNIVEL == "0" ){		
		alert('DEBE SELECCIONAR UN NIVEL');
		return false;
		};	

//var caracteristicas = "height=800,width=800,scrollTo,resizable=1,scrollbars=1,location=0"; 
var caracteristicas = "toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=800,left=240,top=112,fullscreen=yes"; 
window.open('../printCantidadAprobadosyReprobadosporNivel.php?idnivel='+cmbNIVEL+'&idano='+cmb_ano+'&c_reporte='+c_reporte +'','Popup',caracteristicas);  
 
	}		
 
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../../cabecera/menu_superior.php");
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
						include("../../../../../menus/menu_lateral.php");
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
                                  <td>
								  <br>
								  
					

<!-- INICIO FORMULARIO DE BUSQUEDA -->
<table align="center" width="90%" height="43" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
  <tr>
    <td class="tableindex" >Cantiadad Aprobados y Reprobados por Nivel</td>
  </tr>
  <tr>
    <td height="27">
	<table width="100%" border="1" style="border-collapse:collapse" >
      <tr>
        <td width="20%">A&ntilde;o escolar </td>
        <td width="50%">
           <?php				
											
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." $whe_perfil_ano ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					} ?>
					<select name="cmb_ano" id="cmb_ano" class="ddlb_x" >
                           <option value="0" selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
							  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							} ?>
							</select>
					
				<? }	?>        </td>
        <td width="50%" align="center"><label>
          <input type="button" name="buscar"  value="Buscar" class="BotonXX" onClick="enviardatos()">
		  <input name="c_reporte"  id="c_reporte" type="hidden" value="<?=$reporte?>">
        </label></td>
      </tr>
     
      <tr>
        <td>Nivel</td>
        <td><select name="cmbNIVEL"  id="cmbNIVEL" class="ddlb_x" >
          <option value="0">Seleccione Nivel </option>
          <?
		  // tomar los niveles asociados
			$qry7 = "select id_nivel, nombre from niveles order by id_nivel";
			$result7 =@pg_Exec($conn,$qry7);
			for ($i=0; $i < @pg_numrows($result7); $i++){
				 $fila7 = @pg_fetch_array($result7,$i);	
				 $nombre_nivel_[]  = $fila7['nombre'];
				 $id_nivel_[]      = $fila7['id_nivel'];
				 ?>
          <option value="<?=$id_nivel_[$i]; ?>"><?=$nombre_nivel_[$i]?></option>
          <? 
			}		  
          
		  ?>
        </select></td>
        <td><div align="center">
          <input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" value="Volver"onClick="window.location='../Menu_Reportes_new2.php'">
        </div></td>

      </tr>
      
      
    </table></td>
  </tr>
</table>
<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
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
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>