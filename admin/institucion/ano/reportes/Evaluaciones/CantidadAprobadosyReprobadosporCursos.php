<?
require('../../../../../util/header.inc'); 
include('../../../../clases/class_MotorBusqueda.php');

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


/*function enviapag2(form){
	var ano, frmModo; 
	ano2=form.cmb_ano.value;
		
	if (form.cmb_ano.value!="0"){
		form.target="_self";		
		pag="../../seteaAno.php3?caso=10&pa=30&ano="+ano2
		form.action = pag;
		form.submit(true);	
	}		
 }*/
 
 

/*function valida(form){
	

	if (form.cmb_ano.value=="0"){		
		alert('DEBE SELECCIONAR UN AÑO');
		form.cmb_ano.focus();	
		return false;
		};
		
	if (form.cmbNIVEL.value=="0"){		
		alert('DEBE SELECCIONAR UN NIVEL');
		form.cmbNIVEL.focus();	
		return false;
		};	
		
	  form.target="_blank";
	  form.action = '../printCantidadAprobadosyReprobadosporCursos.php';
	  form.submit(true);
	}	*/	

 
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
		 
		var caracteristicas = "height=800,width=800,scrollTo,resizable=1,scrollbars=1,location=0";  
		window.open('../printCantidadAprobadosyReprobadosporNivel.php?idnivel='+cmbNIVEL+'&c_reporte='+c_reporte +'','Popup',
		caracteristicas);  
 
	} 
  
  
/*function crear_curso () {  // crea combo curso

	    ajax=nuevoAjax();
		
		var divimg = document.getElementById('curso'); // div a modificar html
		var idano  = document.getElementById('cmb_ano'); // parametro
		var curso  = 'curso'; // indicador del combo que se creara
					
		ajax.open("POST","crearselects.php",true);
						
		  divimg.innerHTML=""
		  divimg.innerHTML="<strong>Buscando Cursos... </strong>";
						
		  ajax.onreadystatechange=function() { //*
		
			if (ajax.readyState==4) {
				divimg.innerHTML=ajax.responseText; // Muestra resultados
			 }else  { divimg.innerHTML = "<strong>Buscando Cursos... </strong>";
														  
		  } //*
		
		  ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          ajax.send("select="+curso+"&idano="+idano)
		
		}*/


//-->
</script>

<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>

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
<table align="center" width="90%" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex">Cantidad Aprobados y Reprobados por Curso</td>
  </tr>
  <tr>
    <td height="27"><table width="100%" border="1">
      <tr>
        <td width="20%">A&ntilde;o escolar </td>
        <td width="50%">
		
           <? 
		   
		     //$ob_motor = new MotorBusqueda();
		     
			 //$ob_motor->rdb = $institucion;
			  
		     //$file = $ob_motor->Ano($conn);
			 // se genera la consulta y trae todos os registros para ser recorriga por un ciclo
		   		  
			 echo   '<select name="cmb_ano" id="cmb_ano" class="ddlb_x" onChange="crear_curso();">';
             echo   '<option value="0" selected>(Seleccione un Año)</option> ';
				
						   for($i=0;$i < @pg_numrows($file);$i++){
						      $reg = @pg_fetch_array($file,$i);
							   
							  $id_ano  = $reg['id_ano'];  
   		                      $nro_ano = $reg['nro_ano'];
							  $situacion = $reg['situacion'];
							  
							              if ($situacion == 0) $estado = "Cerrado";
							  			  if ($situacion == 1) $estado = "Abierto";
							  							  	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							
							} 
				 echo "</select>";  ?>
			
		
		
		</td>
        
		<td width="50%" align="center">
          <input type="button" name="Submit" value="Buscar" class="BotonXX" onClick="enviardatos()" >
		  <input name="c_reporte" id="c_reporte" type="hidden" value="<?=$reporte?>">
		</td>
      </tr>
     
      <tr>
        <td>Cursos</td>
        <td>
		<div id="curso" > <!--se solicita por ajax la creacion del combo curso-->
		<select name="cmb_curso" id="cmb_curso" class="ddlb_9_x" onChange="();">
            <option value=0 selected>(Seleccione un Año)</option>
         </select>
		</div>
		</td>
        <td>&nbsp;</td>
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