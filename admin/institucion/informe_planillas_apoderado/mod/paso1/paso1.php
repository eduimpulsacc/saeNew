<?php require('../../../../../util/header.inc');
$institucion=$_INSTIT;
$_POSP = 4;
$_bot = 7;



	 	$sqlEns="select distinct tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo from  tipo_ense_inst inner join tipo_ensenanza on tipo_ense_inst.cod_tipo=tipo_ensenanza.cod_tipo where tipo_ense_inst.rdb='".$institucion."' and tipo_ense_inst.estado=0 or tipo_ense_inst.estado=1";
		$resultEns=pg_Exec($conn,$sqlEns);
			if (!$resultEns) {
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlEns);
			}
			

$institucion=$_INSTIT;
$ano = $_ANO;

session_start();
require "../../Class/mod_plantillas.php";
$obj_informe = new informeApo();

if($creada==1){
	$rs_plantilla = $obj_informe->getDatoPlantilla($conn,$id_plantilla);
	$fila_plantilla = pg_fetch_array($rs_plantilla,0);	
}else{
$id_plantilla=0;
}

?>
<!doctype html>
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta charset="utf-8" />
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!-- Scripts Editor WYSIWYG -->
<script src="../../../../clases/tinymce/tinymce.min.js"></script>
<!--
<script type="text/javascript">
  tinymce.init({
        selector: "textarea",
        statusbar: false,
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });
</script>-->

	<script>	
function Modifica(){
	
	var funcion =5;
	var formulario = $("#frm").serialize();
	var ense = $("#cmbEns").val();
	
	//alert(desc);
	
	//invocar carga listado
			$.ajax({
				url:"con_crear.php",
				data:"funcion="+funcion+"&formulario="+formulario+"&ense="+ense+"&id_plantilla="+<?php echo $id_plantilla ?>,
				type:'POST',
				success:function(data){
				//$('#alcurso').html(data);
				console.log(data);
				if(data>0){
					window.location.href = "paso1.php?id_plantilla=<?php echo $id_plantilla ?>&creada=1";
					
				}
		  }
		});  

	
	
}

function agregaReg(form){
		form.target='_parent';
		form.action='../paso2/paso2.php?plantilla=<? echo $id_plantilla;?>';
		
		form.submit(true);
}


function guardaNuevo(){
	var funcion =1;
	var formulario = $("#frm").serialize();
	var ense = $("#cmbEns").val();
	var cmbPlantilla = $("#cmbPlantilla").val();
	
	
	
	var chk = $('input[type="checkbox"]:checked').length;
	
	if(chk>0 && ense!=0 && cmbPlantilla != 0){
		
	//invocar carga listado
			$.ajax({
				url:"con_crear.php",
				data:"funcion="+funcion+"&formulario="+formulario+"&ense="+ense,
				type:'POST',
				success:function(data){
				//$('#alcurso').html(data);
				//console.log(data);
				if(data>0){
					window.location.href = "../paso2/paso2.php?plantilla="+data;
				}
		  }
		});  

	}else{
	alert("Debe completar el formulario")
	}
}

function activaTipo(){
	var ense = $("#cmbEns").val();
	
	if(ense<=10){
	$("#grado1").attr("disabled",false);
	$("#grado2").attr("disabled",false);
	$("#grado3").attr("disabled",false);
	$("#grado4").attr("disabled",false);
	$("#grado5").attr("disabled",false);
	$("#grado6").attr("disabled",true);
	$("#grado7").attr("disabled",true);
	$("#grado8").attr("disabled",true);
	$("#grado9").attr("disabled",true);
	$("#grado10").attr("disabled",true);
	$("#grado11").attr("disabled",true);
	$("#grado12").attr("disabled",true);
	$("#grado13").attr("disabled",true);
	$("#grado14").attr("disabled",true);
	$("#grado15").attr("disabled",true);
	}
	else if(ense<=110){
	$("#grado1").attr("disabled",false);
	$("#grado2").attr("disabled",false);
	$("#grado3").attr("disabled",false);
	$("#grado4").attr("disabled",false);
	$("#grado5").attr("disabled",false);
	$("#grado6").attr("disabled",false);
	$("#grado7").attr("disabled",false);
	$("#grado8").attr("disabled",false);
	$("#grado9").attr("disabled",true);
	$("#grado10").attr("disabled",true);
	$("#grado11").attr("disabled",true);
	$("#grado12").attr("disabled",true);
	$("#grado13").attr("disabled",true);
	$("#grado14").attr("disabled",true);
	$("#grado15").attr("disabled",true);
	}
	
	else if(ense>=310){
	$("#grado1").attr("disabled",false);
	$("#grado2").attr("disabled",false);
	$("#grado3").attr("disabled",false);
	$("#grado4").attr("disabled",false);
	$("#grado5").attr("disabled",true);
	$("#grado6").attr("disabled",true);
	$("#grado7").attr("disabled",true);
	$("#grado8").attr("disabled",true);
	$("#grado9").attr("disabled",true);
	$("#grado10").attr("disabled",true);
	$("#grado11").attr("disabled",true);
	$("#grado12").attr("disabled",true);
	$("#grado13").attr("disabled",true);
	$("#grado14").attr("disabled",true);
	$("#grado15").attr("disabled",true);
	}
	else{
	$("#grado1").attr("disabled",false);
	$("#grado2").attr("disabled",false);
	$("#grado3").attr("disabled",false);
	$("#grado4").attr("disabled",false);
	$("#grado5").attr("disabled",false);
	$("#grado6").attr("disabled",false);
	$("#grado7").attr("disabled",false);
	$("#grado8").attr("disabled",false);
	$("#grado9").attr("disabled",false);
	$("#grado10").attr("disabled",false);
	$("#grado11").attr("disabled",false);
	$("#grado12").attr("disabled",false);
	$("#grado13").attr("disabled",false);
	$("#grado14").attr("disabled",false);
	$("#grado15").attr("disabled",false);
	}
}

</script>	

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> <td>
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			<?   //include("../../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
					<?   include("../../../../../cabecera/menu_superior.php");?>
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
					  	 $menu_lateral=2;
						 include("../../../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%"><tr><td valign="top">
							<form  method="post" id="frm">
                              <table width="76%" border="0" align="center">
							  <tr><td colspan="2" class="fondo">1ro.- 
        Datos Plantilla</font></td></tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">1.-
                                        Seleccione tipo de ense&ntilde;anza
                                  </font>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="8%">&nbsp;</td>
                                  <td width="92%"><select name="cmbEns" id="cmbEns" onChange="activaTipo()">
                                        <option value="0" selected>Seleccione Tipo de Ense&ntilde;anza</option>
                                        <?php
		  
		  for($cEns=0 ; $cEns<pg_numrows($resultEns) ; $cEns++){
			  $filaEns=pg_fetch_array($resultEns,$cEns);?>
			 <option value="<?php echo $filaEns['cod_tipo'] ?>" <?php if($creada==1 && $fila_plantilla['tipo_ense']== $filaEns['cod_tipo'])echo "selected" ?>><?php echo $filaEns['nombre_tipo'] ?></option>
		 <?php  }//fin for
		  
		  ?>
                                      </select></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">2.- Seleccione tipo de plantilla</td>
                                  </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><select name="cmbPlantilla" id="cmbPlantilla">
                                    <option value="0" >Seleccione Tipo de Plantilla</option>
                                     <option value="1" <?php if($creada==1 && $fila_plantilla['tipo_plantilla']== 1)echo "selected" ?>>Apoderado</option>
                                      <option value="2" <?php if($creada==1 && $fila_plantilla['tipo_plantilla']== 2)echo "selected" ?>>Alumno</option>
                                       <option value="3" <?php if($creada==1 && $fila_plantilla['tipo_plantilla']== 3)echo "selected" ?>>Entrevistador</option>
                                 
                                  </select></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">2.-
                                        Seleccione a qu&eacute; grado(s) aplica este informe
&nbsp; <font size="2" face="Arial, Helvetica, sans-serif"><font size="1">Ed. Parvularia: SC=</font><font size="1" face="Arial, Helvetica, sans-serif"> 1&ordm; A&Ntilde;O, NMME= 2&ordm; A&Ntilde;O, NMMA= 3&ordm; A&Ntilde;O, 1NT= 4&ordm; A&Ntilde;O, 2NT= 5&ordm; A&Ntilde;O. Educaci&oacute;n de adultos grados 9</font><font size="2" face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif">&ordm;</font></font><font size="1" face="Arial, Helvetica, sans-serif"> a 12</font><font size="2" face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif">&ordm;</font></font><font size="1" face="Arial, Helvetica, sans-serif">. Educaci&oacute;n especial grados 13</font><font size="2" face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif">&ordm;</font></font><font size="1" face="Arial, Helvetica, sans-serif"> a 15</font><font size="2" face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif">&ordm;</font></font></font></font>. </td>
                                </tr>
                                <?php if($creada!=1){?>
                                <tr>
                                  <td width="8%">&nbsp;</td>
                                  <td colspan="2" class="textosesion"><table width="100%" border="0">
                                    <tr class="textosesion">
                                        <td><input name="grado1" type="checkbox" id="grado1" value="1">
                            PRIMER A&Ntilde;O</td>
                                        <td><input name="grado2" type="checkbox" id="grado2" value="1">
                            SEGUNDO A&Ntilde;O </td>
                                        <td><input name="grado3" type="checkbox" id="grado3" value="1">
                            TERCER A&Ntilde;O </td>
                                        <td><input name="grado4" type="checkbox" id="grado4" value="1">
                            CUARTO A&Ntilde;O </td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="grado5" type="checkbox" id="grado5" value="1">
                            QUINTO A&Ntilde;O</td>
                                        <td><input name="grado6" type="checkbox" id="grado6" value="1">
                            SEXTO A&Ntilde;O</td>
                                        <td><input name="grado7" type="checkbox" id="grado7" value="1">
                            SEPTIMO A&Ntilde;O</td>
                                        <td><input name="grado8" type="checkbox" id="grado8" value="1">
                            OCTAVO A&Ntilde;O</td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="grado9" type="checkbox" id="grado9" value="1">
                            NOVENO A&Ntilde;O</td>
                                        <td><input name="grado10" type="checkbox" id="grado10" value="1">
                            DECIMO A&Ntilde;O</td>
                                        <td><input name="grado11" type="checkbox" id="grado11" value="1">
                            UNDECIMO A&Ntilde;O</td>
                                        <td><input name="grado12" type="checkbox" id="grado12" value="1">
                            DUODECIMO A&Ntilde;O</td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="grado13" type="checkbox" id="grado13" value="1">
                            DECIMO TERCER A&Ntilde;O</td>
                                        <td><input name="grado14" type="checkbox" id="grado14" value="1">
                            DECIMO CUARTO A&Ntilde;O</td>
                                        <td><input name="grado15" type="checkbox" id="grado15" value="1">
                            DECIMO QUINTO A&Ntilde;O</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                  </table></td>
                                </tr>
                                
                                <?php } else{?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><table width="100%" border="0">
                                    <tr class="textosesion">
                                        <td><input name="grado1" type="checkbox" id="grado1" value="1" <?php echo ($fila_plantilla['grado1']==1)?"checked":"" ?>>
                            PRIMER A&Ntilde;O</td>
                                        <td><input name="grado2" type="checkbox" id="grado2" value="1" <?php echo ($fila_plantilla['grado2']==1)?"checked":"" ?>>
                            SEGUNDO A&Ntilde;O </td>
                                        <td><input name="grado3" type="checkbox" id="grado3" value="1" <?php echo ($fila_plantilla['grado3']==1)?"checked":"" ?>>
                            TERCER A&Ntilde;O </td>
                                        <td><input name="grado4" type="checkbox" id="grado4" value="1" <?php echo ($fila_plantilla['grado4']==1)?"checked":"" ?>>
                            CUARTO A&Ntilde;O </td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="grado5" type="checkbox" id="grado5" value="1" <?php echo ($fila_plantilla['grado5']==1)?"checked":"" ?>>
                            QUINTO A&Ntilde;O</td>
                                        <td><input name="grado6" type="checkbox" id="grado6" value="1" <?php echo ($fila_plantilla['grado6']==1)?"checked":"" ?>>
                            SEXTO A&Ntilde;O</td>
                                        <td><input name="grado7" type="checkbox" id="grado7" value="1" <?php echo ($fila_plantilla['grado7']==1)?"checked":"" ?>>
                            SEPTIMO A&Ntilde;O</td>
                                        <td><input name="grado8" type="checkbox" id="grado8" value="1" <?php echo ($fila_plantilla['grado8']==1)?"checked":"" ?>>
                            OCTAVO A&Ntilde;O</td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="grado9" type="checkbox" id="grado9" value="1" <?php echo ($fila_plantilla['grado9']==1)?"checked":"" ?>>
                            NOVENO A&Ntilde;O</td>
                                        <td><input name="grado10" type="checkbox" id="grado10" value="1" <?php echo ($fila_plantilla['grado1']==10)?"checked":"" ?>>
                            DECIMO A&Ntilde;O</td>
                                        <td><input name="grado11" type="checkbox" id="grado11" value="1" <?php echo ($fila_plantilla['grado1']==11)?"checked":"" ?>>
                            UNDECIMO A&Ntilde;O</td>
                                        <td><input name="grado12" type="checkbox" id="grado12" value="1" <?php echo ($fila_plantilla['grado1']==12)?"checked":"" ?>>
                            DUODECIMO A&Ntilde;O</td>
                                      </tr>
                                      <tr class="textosesion">
                                        <td><input name="grado13" type="checkbox" id="grado13" value="1" <?php echo ($fila_plantilla['grado1']==13)?"checked":"" ?>>
                            DECIMO TERCER A&Ntilde;O</td>
                                        <td><input name="grado14" type="checkbox" id="grado14" value="1" <?php echo ($fila_plantilla['grado1']==14)?"checked":"" ?>>
                            DECIMO CUARTO A&Ntilde;O</td>
                                        <td><input name="grado15" type="checkbox" id="grado15" value="1" <?php echo ($fila_plantilla['grado1']==15)?"checked":"" ?>>
                            DECIMO QUINTO A&Ntilde;O</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                  </table></td>
                                </tr>
                                <?php }?>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">3.- Asigne un nombre a la nueva Plantilla de Informe</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td  class="textosesion"><input name="nombre_informe" type="text" id="nombre_informe" size="50" maxlength="50" value="<?php echo $fila_plantilla['nombre_informe'] ?>">
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
                                <tr>
                                  <td colspan="2" class="cuadro01">4.- Encabezados</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td  class="textosesion">
								  T&iacute;tulo Informe :
                                  </td>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td  class="textosesion"><input name="titulo" type="text" id="titulo" size="30" maxlength="100" value="<?php echo utf8_decode($fila_plantilla['titulo']) ?>"></td>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td  class="textosesion">Texto                                    </td>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td  class="textosesion"><textarea name="descripcion" cols="50" rows="4" id="descripcion" ><?php echo htmlentities($fila_plantilla['descripcion']) ?></textarea>
                                  </td>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                      
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2"><?php if (($creada!=1) and ($eliminar!=1)){?>
                                      <input class="botonXX"  type="button" name="Submit" value="GUARDAR" onClick="guardaNuevo()">
                                      <?php }elseif(($creada==1) ){?>
                                      <input type="hidden" name="hiddenPlantilla" value="<?php echo $plantilla?>">
                                      <input class="botonXX"  type="button" name="cancelar" value="VOLVER"  onClick="window.location.href = '../../listaPlantillas.php'">
                                      <input class="botonXX"  type="button" name="cancelar" value="MODIFICAR" onClick="Modifica()">
                                      <input class="botonXX"  type="button" name="cancelar" value="CONTINUAR" onClick="agregaReg(this.form)">
                                      <?php }?></td>
                                </tr>
                                <tr>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">VOLVER : Vuelve al listado de Plantillas creadas.</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">MODIFICAR : Permite Modificar el texto de registros creados en la Plantilla actual.</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">CONTINUAR : Permite Agregar AREAS E ITEMES a la Plantilla actual, tambi&eacute;n permite eliminar elementos de la Plantilla.</font></td>
                                </tr>
                              
	  
                              </table>
                            </form></td></tr></table>                         </td>

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
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
