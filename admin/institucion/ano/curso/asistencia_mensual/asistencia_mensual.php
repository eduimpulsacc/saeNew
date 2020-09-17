<?php 	require('../../../../../util/header.inc');

	$institucion = $_INSTIT;
	$corporacion =$_CORPORACION;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$_POSP          =5;
	$_bot           =5;
	
	
	if($_PERFIL==0){
		$sql ="SELECT num_corp FROM corp_instit WHERE rdb=".$institucion;
		$rs_corp = @pg_exec($conn,$sql);
		$corporacion = @pg_result($rs_corp,0);
	}
	 

	/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;
}else{
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}	
//echo $frmModo;

if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL!=17)&&($_PERFIL==19)) {$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL==19)&&($_PERFIL!=30)&&($_PERFIL!=32)){$whe_perfil_curso=" and curso.id_curso=$curso";}

	$fecha=getdate();
	
    if ($cmbMes==NULL){
	    $cmbMes= $fecha["mon"];
		
	}	
	$diaActual=$fecha["mday"];	
		
	$qry1106="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO = '$ano' AND ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
	$result1106 =@pg_Exec($conn,$qry1106);
	
	if (!$result1106){
		error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
	}else{
		if (pg_numrows($result1106)!=0){
			$fila1106 = @pg_fetch_array($result1106,0);	
			if (!$fila1106){
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}else{
			  $fila1106 = @pg_fetch_array($result1106,0);
			}	  
		}
								
	}
	
	$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
	}else{
		if (pg_numrows($result)!=0){
			$fila1 = @pg_fetch_array($result,0);	
			if (!$fila1){
				error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
				exit();
			}
			$nroAno=trim($fila1['nro_ano']);
		}
	}
	


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="../vitacora_alumno/includes/jquery-ui-1.8.6.custom.css">

<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="selectFichaAlumno.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>

<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}
-->
</style>
<head>
<?php 

?>
					


<script language= "JavaScript">

	function cargartabla(){
	
	var nroAno = "<?=$nroAno?>;"
	var curso = $('#cmb_curso').val()
	var ano = $('#cmb_ano').val()
	var cmbMes=$('#cmbMes').val()
	frmModo = "mostrar";
	
	$("#encabezado").html('Listado Alumnos Asistentes');
	
	var x ='<br><h5>Espere Por Favor Procesando...</h5><br>';
    x = x+'<img src="../../../../clases/img_jquery/ajax-loader.gif">'; 

$("#cargatabla").html(x);
	
	
	var parametros = "frmModo="+frmModo+"&curso="+curso+"&ano="+ano+"&cmbMes="+cmbMes+"&nroAno="+nroAno;
	//alert(parametros);
		$.ajax({
		  url:'lista_alumnos_asistentes.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#cargatabla').html(data);
						
						$("#cargatabla").html();
						}
				     }
		         })
	          } // fin funcion cargartabla

		 
 </script>
<LINK REL="STYLESHEET" HREF="../../../../util/td.css" TYPE="text/css">
<style>
.tachado {
    text-decoration: line-through;
}
</style>
<style>
.td_temp{font:12px monospace; border:3px solid; text-align:center; height:1.5em; width:50px; vertical-align:top}
.td_temp2{font:12px monospace; border:0px solid; text-align:center; height:1.5em; vertical-align:top }
#contEncCol{overflow:hidden; overflow-y:scroll; background:#99CCFF; width:40em; vertical-align:top}
#encCol{}
#contEncFil{overflow:hidden; overflow-x:scroll; background:#FFFFFF; height:20em; vertical-align:top}
#contenedor{overflow:auto; width:40em; height:20em; vertical-align:top; vertical-align:top}
#contenido{}
.tabla td{border:1px solid; width:6em; vertical-align:top}
.rell{width:2em; height:0; position:relative; top:-1em; z-index:0; bor der:1px solid red; vertical-align:top}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53"  align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <table width="100%">
              <tr align="left" valign="top"> 
                <td height="83" colspan="3">
				<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="1%" height="363" align="left" valign="top">
					  <table>
					  <tr> 
					  <td>&nbsp;
						</td>
						</tr>
						</table>
					  </td>
					
                      <td width="100%" align="left" valign="top">
					  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top" colspan="50"><? include("../../../../../cabecera/menu_superior.php"); ?></td>
                          </tr>
                          <tr> 
						  <td> 

<!-- inicio cuerpo de la pagina -->
<form name="form1" method="post" action="procesoAsistencia_mensual.php">

<input type="hidden" name="cmbMes2" value="<? echo $cmbMes; ?>" >
							 
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td width="20%" class="Estilo1">A&ntilde;o Escolar </td>
    <td width="50%">: 
	

<?	


	function generaano($institucion,$conn){
		
 $qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion."  $whe_perfil_ano ORDER BY NRO_ANO";
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

	} 	
?>

<input type="hidden" name="frmModo" value="<?=$frmModo ?>">
<select name="cmb_ano" id="cmb_ano" class="ddlb_x" onChange='cargaContenido(this.id)'>
<option value=0 selected>(Seleccione un Año)</option> <?

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
						 <? } }
						 
		generaano($institucion,$conn);
						 ?>					  
							  
							  
</td>
<td width="30%" rowspan="2"><div align="center">
<label>
<? if($fila1106['situacion']==0){//CERRADO NO MOSTRAR LOS BOTONES INGRESAR
  
  }else{

  if ($ingreso==1 || $modifica==1){ 
		
		if ($frmModo=="mostrar" and $curso>0){	  
			                               		?>
<!--<input class="botonXX"  type="button" name="Button2" value="MODIFICAR" onClick=window.location="seteaAsistencia.php3?caso=1&mes=<?php echo $cmbMes ?>">-->

<? }else{
										        
							
										
										   } ?>			
								  
								   <? } ?>  
									  <?
								} ?>	
								</label>
								
                                <label>
								
								
<? if ($frmModo=="mostrar"){								
	
	if (($_PERFIL == 19) OR ($_PERFIL == 0) OR ($_PERFIL == 14)){ ?>

<input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="../listarCursos.php3">
	
<? } 

	}else{

if (($_PERFIL == 19) OR ($_PERFIL == 0) OR ($_PERFIL == 14)){ ?>

<input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="../listarCursos.php3">
								  <? }							
								}
								?>  	
                                </label>
                              </div></td>
                            </tr>
            <tr>
            <td class="Estilo1">Curso:</td>
            <td rowspan="2"> 
            <div id="c_alumno" >
           :&nbsp;<select disabled="disabled" name="cmb_curso" id="cmb_curso">
            <option value="0">Selecciona opci&oacute;n...</option>
            </select>										  
            </div>
            
            </td>
            </tr>
</table>

<input type="hidden" name="ensenanza" value="<?=$filan['ensenanza']; ?>">	
						  
<table width="100%" border="0">
<tr>
                              <td><strong><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Feriado:</font></strong></td>
                              <td width="30" bgcolor="#FFE6E6">&nbsp;</td>
							  <td width="50" >&nbsp;</td>
                              <td><strong><font size="1" face="Arial, Helvetica, sans-serif">Fin 
              de Semana:</font></strong></td>
                              <td width="30" bgcolor="#EAEAEA">&nbsp;</td>
							  <td width="50" >&nbsp;</td>
                              <td><strong><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Actua:</font></strong></td>
                              <td width="30" bgcolor="#FFFFD7">&nbsp;</td>
							  <td width="50" >&nbsp;</td>
                              <td><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Asistencia:</font></td>
                              <td width="30" bgcolor="#E1EFFF">&nbsp;</td>
							  <td width="50" >&nbsp;</td>
                              <td><font size="1" face="Arial, Helvetica, sans-serif">Asistencias del Mes:</font></td>
                              <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;A.M.</font></td>
                            </tr>
                          </table>
						  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="20%" class="Estilo1">INASISTENCIA</td>
                              <td width="80%">:
							  
							  <select name="cmbMes" id="cmbMes" onChange="cargartabla();">
							   <option value="0" selected>Selecciones Mes</option>
								<?php 
								if($cmbMes==""){
								   $fecha=getdate();
								   $cmbMes=$fecha["mon"];
								}
								if ($cmbMes=="01"){
									 echo "<option value=01 selected>ENERO</option>";
								}else	 
									echo "<option value=01>ENERO</option>";
								if ($cmbMes=="02"){
									echo "<option value=02 selected>FEBRERO</option>";
								}else 
									echo "<option value=02>FEBRERO</option>";
								 if ($cmbMes=="03"){
								echo "	<option value=03 selected>MARZO</option>";
								 }else 
									echo "<option value=03>MARZO</option>";
								 if ($cmbMes=="04"){
									echo "<option value=04 selected>ABRIL</option>";
								 }else 
									echo "<option value=04>ABRIL</option>";
								 if ($cmbMes=="05"){
									echo "<option value=05 selected>MAYO</option>";
								 }else
									echo "<option value=05>MAYO</option>";
								 if ($cmbMes=="06"){
									echo "<option value=06 selected>JUNIO</option>";
								 }else
									echo "<option value=06>JUNIO</option>";
								
								 if ($cmbMes=="07"){
								echo "	<option value=07 selected>JULIO</option>";
								 }else
									echo "<option value=07>JULIO</option>";
								 if ($cmbMes=="08"){
								echo "	<option value=08 selected>AGOSTO</option>";
								 }else
									echo "<option value=08>AGOSTO</option>";
								 if ($cmbMes=="09"){
									echo "<option value=09 selected>SEPTIEMBRE</option>";
								 }else
									echo "<option value=09>SEPTIEMBRE</option>";
								 if ($cmbMes=="10"){
									echo "<option value=10 selected>OCTUBRE</option>";
								 }else
									echo "<option value=10>OCTUBRE</option>";
								 if ($cmbMes=="11"){
								echo "<option value=11 selected>NOVIEMBRE</option>";
								 }else
									echo "<option value=11>NOVIEMBRE</option>";
								 if ($cmbMes=="12"){
								echo "<option value=12 selected>DICIEMBRE</option>";
								 }else	echo "<option value=12>DICIEMBRE</option>";
								 ?>
							  </select>
							  
							  
							  </td>
                            </tr>
                          </table>
						
					<!--	  <table width="100%" height="300" border="1">-->
     <div class="tableindex" id="encabezado" >Listado Alumnos asistentes</div>                       
	<div id="cargatabla" title="Lista Alumnos Asistentes">&nbsp;</div>						  
							  

							  
   
  
       </table></td>						 
						 </tr>
					   </table>
						  </td>
                            <td height="395" align="left" valign="top"> 
                     
						    </td>
                          </tr>
                        </table></td> 
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
			    </td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</td></tr></table></form>
</body>
</html>
<? pg_close($conn);?>