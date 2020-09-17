<?
require('../../../../util/header.inc');


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	echo $nroAno;
	$_POSP = 4;
	$_bot = 2;
	$sql="select situacion from ano_escolar where id_ano=$ano";
	$result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);

/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;
}else{
	if($nw==1){
		$_MENU =$menu;
		session_register('_MENU');
		$_CATEGORIA = $categoria;
		session_register('_CATEGORIA');
	}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}

	
	if (!$ano){?>
	<script>
	alert ('Es posible que no tenga un año Seleccionado\r\no simplemente no existe ningun año escolar para la intitucion \r\n');
	window.location= '../listarAno.php3';
</script>	
	
	<? exit;
		
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>

<script>



function creaf(){
	var parametros = "funcion=1";
//alert (parametros);
  $.ajax({
	url:"cont_fer.php",
	data:parametros,
	type:'POST',
	success:function(data){
		$("#fechasfr").html(data);
	$("#fechasfr").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 400,
   Height: 300,
   minWidth: 400,
   minHeight: 300,
   maxWidth: 400,
   maxHeight: 300,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
		
	 "Guardar Datos": function(){
		 if($('#fechaini').val()==""){
			alert("seleccione de inicio");
			$('#fechaini').focus();
			return false;
		}
		else if($('#fechater').val()==""){
			alert("seleccione de inicio");
			$('#fechater').focus();
			return false;
		}
		else if($('#desc').val()==""){
			alert("ingrese descripcion fecha");
			$('#desc').focus();
			return false;
		}
		else{
		   ingresar_fer();
		  
		   $(this).dialog("close");
		}
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }) 
		}
	})
	
	
	


}

function ingresar_fer(){
	
	var finicio=$('#fechaini').val();
	var termino=$('#fechater').val();
	var desc=$('#desc').val();
	var ano=$('#nanno').val();
	var parametros = "funcion=2&finicio="+finicio+"&termino="+termino+"&desc="+desc+"&ano="+ano;
	$.ajax({
	  url:'cont_fer.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 console.log(data);
		 if(data==1){
			alert("Datos almacenados");
			location.reload(); 
			}
			else{
				alert("Error al guardar");
				}
		// alert(data);&nbsp;
	    //$("#tabla").html(data);
		//cargatipo($("#crg").val(),iunidad)

		  }
	  })
}

function asignaf(){
	var funcion=3;
	var ano=$('#nanno').val();
	var parametros = "funcion="+funcion+"&ano="+ano;
	$.ajax({
	  url:'cont_fer.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 console.log(data);
		 if(data=1){
			alert("Datos almacenados");
			location.reload(); 
			}
			else{
				alert("Error al guardar");
				}
		

		  }
	  })
}

function cargaCurso(fer){
	var parametros = "funcion=4&fer="+fer;
//alert (parametros);
  $.ajax({
	url:"cont_fer.php",
	data:parametros,
	type:'POST',
	success:function(data){
		$("#fem").html(data);
	$("#fem").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 400,
   Height: 300,
   minWidth: 400,
   minHeight: 300,
   maxWidth: 400,
   maxHeight: 300,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
		
	 "Guardar Datos": function(){
		   ferCurso();
		  
		   $(this).dialog("close");
		
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }) 
		}
	})
	
	
	
	
}


function ferCurso(){
var funcion = 5;
var searchIDs = [];
var fer=$("#fer").val();
$("input.cb-element[type=checkbox]:checked").map(function(){
    searchIDs.push($(this).val());
  });
  var parametros = "funcion="+funcion+"&cur="+searchIDs+"&fer="+fer;
  $.ajax({
	  url:'cont_fer.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 console.log(data);
		 /*if(data=1){
			alert("Datos almacenados");
			location.reload(); 
			}
			else{
				alert("Error al guardar");
				}
		*/

		  }
	  })
	
}



</script>
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>



<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=2;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             
										
						
								  
							 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!-- AQUI VA TODA LA PROGRAMACIÓN  -->
								   <?php //echo tope("../../../../util/");?>
<table width="90%" border="0" align="center">
    <tr>
      <td><table width="100%" border="0">
          <tr>
            <td width="20%"> <FONT face="arial, geneva, helvetica" size=2> <strong>AÑO ESCOLAR</strong> 
              </FONT> </td>
            <td width="2%"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
            <td width="78%"><FONT face="arial, geneva, helvetica" size=2><strong>
              <?php
										if  ($ano){
										  	$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =pg_Exec($conn,$qry);
											if (!$result) {
													echo "error en la consulta";

											}else{
												if (pg_numrows($result)!=0){
													$fila1 = pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
													$nroAno=trim($fila1['nro_ano']);
												}
											}
											}?></strong></FONT>
              <input type="hidden" name="nanno" id="nanno" value="<?php echo trim($fila1['nro_ano'])?>">
            </tr>
        </table>
        <table width="100%" border="0">
          <tr>
            
          <td align="left"> 
		  <? 
		  if ($situacion !=0){
		  if($ingreso==1){?>
	            <input class="botonXX" type="button" name="Button" value="AGREGAR" onClick=document.location="seteaFeriado.php3?caso=2"> 
    	        <input class="botonXX"  type="button" name="Submit3" value="VOLVER" onClick=document.location="../ano_escolar.php3"></td>
          <td align="right"><img src="../images/icono_feriado2.png" width="133" height="103"></td>
		  <? }
		  }//cierre if año academico?>
          </tr>
        </table>

      
        <table width="100%" border="0">
          <tr> 
            
          <td></td>
          </tr>
        </table>
<?php if($_PERFIL==0){
	//feriados del año
	?>
        <br>
        <div id="ferglo">
        <table width="100%" border="0" bordercolor="#003b85">
          <tr>
            
          <td class="tableindex" colspan="3">&nbsp;Feriados 
            Calendario Global <span class="cuadro01">(no asociados a su instituci&oacute;n) 
            
            </span><input class="botonXX" type="button" name="Button2" value="CREAR" onClick="creaf()"> <input class="botonXX" type="button" name="Button2" value="ASIGNAR" onClick="asignaf()"></td>
          </tr>
           <tr align="left"> 
          <td colspan="2" align="center" valign="middle" class="tablatit3">FECHA</td>
          <td valign="middle" class="tablatit3">&nbsp;</td>
        </tr>
        <tr align="center"> 
          <td width="20%" valign="middle" class="tablatit3">DESDE</td>
          <td width="20%" valign="middle" class="tablatit3">HASTA</td>
          <td valign="middle" class="tablatit3">DESCRIPCI&Oacute;N</td>
        </tr>
        <?php  
		 $sql_fano="select * from feriado_ano where nro_ano=".$fila1['nro_ano']." order by fecha_inicio ";
		$res_fano=pg_exec($conn,$sql_fano);
		for($fa=0;$fa<pg_numrows($res_fano);$fa++){
			$fila_fa=pg_fetch_array($res_fano,$fa);
		?>
        <tr align="center" bgcolor=#ffffff onmouseover="this.style.background='yellow';this.style.cursor='pointer'" onmouseout="this.style.background='#ffffff'">
        <td width="20%" align="left"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo CambioFD($fila_fa['fecha_inicio']);?></font></td>
					<td width="20%" align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo CambioFD($fila_fa['fecha_termino']);?></font></td>
					<td align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $fila_fa['descripcion'];?></font></td>
         </tr>
         <?php }?>
        </table>
        </div>
<br><br>

<?php }?>
		<table width="100%" border="0" bordercolor="#003b85">
          <tr>
            
          <td class="tableindex">&nbsp;Feriados 
            Calendario <span class="cuadro01">(no asociados a su instituci&oacute;n)</span></td>
          </tr>
        </table>
        
      <table width="100%" border="0" align="center">
        <tr align="left"> 
          <td colspan="2" align="center" valign="middle" class="tablatit3">FECHA</td>
          <td valign="middle" class="tablatit3">&nbsp;</td>
        </tr>
        <tr align="center"> 
          <td width="20%" valign="middle" class="tablatit3">DESDE</td>
          <td width="20%" valign="middle" class="tablatit3">HASTA</td>
          <td width="60%" valign="middle" class="tablatit3">DESCRIPCI&Oacute;N</td>
        </tr>
		<?php
		  	$fecSis=getdate();
			$anoActual=$fecSis["year"];
					$sqlFer="select * from feriados_nac where descripcion not in (select descripcion from feriado where id_ano=".$ano.") order by id_feriado";
					//echo $sqlFer;
					$resultFerNac=pg_Exec($conn,$sqlFer);
					
					for($k=0 ; $k<=pg_numrows($resultFerNac) ; $k++){
					$filaFerNac=@pg_fetch_array($resultFerNac,$k);
					$fecIniFer=$filaFerNac["fecha_inicio"];
					if ($filaFerNac["fecha_fin"]!=0){
						$fecFinFer=$filaFerNac["fecha_fin"];
					}else{
						$fecFinFer="";
					}
					$descFer=$filaFerNac["descripcion"];
					
					if($modifica==1){?>
					<tr align="center" bgcolor=#ffffff onClick=go('seteaFeriado.php3?caso=3&id_feriado=<?php echo $filaFerNac["id_feriado"];?>&bool_fer=<?php echo $filaFerNac["bool_fer"];?>') onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff'> 
					<? }else{?>
					<tr align="center" bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff'> 
					<? } ?>
					<td align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $fecIniFer;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
					<td align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $fecFinFer;?></font></td>
					<td align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $descFer;?></font></td>
					</tr>
				<?php } ?>
      </table>
	  <table width="100%" border="0">
        <tr>
          <td>
            <?php  $sql2="select * from feriado where id_ano=".$ano." order by fecha_inicio";
					//echo $sql2;
					$result2=pg_Exec($conn,$sql2);
						if (!$result2) {
							error('<b> ERROR :</b>Error al acceder a la BD. (7)'.$sql2);
						}

				?>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" bordercolor="#003b85">
          <tr>
          </tr>
        </table>
        <table width="100%" border="0" bordercolor="#003b85">
          <tr>
            
          <td class="tableindex">&nbsp;Feriados Ingresados <span class="cuadro01">(asociados a su instituci&oacute;n)</span><?php if($_PERFIL==0){?><input name="" type="button" value="Copiar Feriados" onClick="traeFeriados()" class="botonXX"><?php }?></td>
          </tr>
        </table>
        
      <table width="100%" border="0" align="center">
        <tr align="left"> 
          <td colspan="2" valign="middle" class="tablatit3">FECHA</td>
          <td colspan="2" valign="middle" class="tablatit3">&nbsp;</td>
        
        </tr>
        <tr align="center"> 
          <td width="12%" valign="middle" class="tablatit3">DESDE</td>
          <td width="12%" valign="middle" class="tablatit3">HASTA</td>
          <td width="63%" valign="middle" class="tablatit3">DESCRIPCI&Oacute;N</td>
          
          
          <td width="13%" valign="middle" class="tablatit3">CURSOS</td>
		
        </tr>
        <?php 
		
		for($j=0 ; $j<pg_numrows($result2) ; $j++){
		  $filaFeriado=pg_fetch_array($result2,$j);
		  $fecIni = $filaFeriado["fecha_inicio"];
		  $fecFin = $filaFeriado["fecha_fin"];
		  $desc = $filaFeriado["descripcion"];
		  $idf = $filaFeriado["id_feriado"];
		  
		  if($modifica==1){?>
	        <tr align="center" bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff'  > 
		<? } ?>
          <td align="left" onClick=go('seteaFeriado.php?caso=3&id_feriado=<?php echo $filaFeriado["id_feriado"];?>&bool_fer=<?php echo $filaFeriado["bool_fer"];?>')><font size="1" face="Arial, Helvetica, sans-serif"><?php echo impF ($fecIni);//($filaFeriado["fecha_inicio"])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
          <td align="left" onClick=go('seteaFeriado.php?caso=3&id_feriado=<?php echo $filaFeriado["id_feriado"];?>&bool_fer=<?php echo $filaFeriado["bool_fer"];?>')><font size="1" face="Arial, Helvetica, sans-serif"><?php echo impF ($fecFin);//($filaFeriado["fecha_fin"]);?></font></td>
          <td align="left" onClick=go('seteaFeriado.php?caso=3&id_feriado=<?php echo $filaFeriado["id_feriado"];?>&bool_fer=<?php echo $filaFeriado["bool_fer"];?>')><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $desc;//$filaFeriado["descripcion"];?></font></td>
         
          <td align="center"><img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" onClick="cargaCurso(<?php echo $idf ?>);" title="Seleccione cursos a los que afecta este feriado"></td>
         
            </tr>
        <?php } ?>
      </table>
	
		
      </td>
    </tr>
  </table>
  
							  
							  		
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
															
								  </td>
							    </tr>
							 </table>							  
								  
								  
								  
								  
		
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<div id="fechasfr"></div>
<div id="fem" title="Asociar feriados a cursos"></div>
<script>
function traeFeriados(){
	var funcion = 6;
	var ano =<?php echo $ano; ?>;
	var nro_ano =<?php echo $nroAno ?>;
var parametros = "funcion="+funcion+"&ano="+ano+	 "&nro_ano="+nro_ano;
	 alert(parametros);
  $.ajax({
	  url:'cont_fer.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 console.log(data);
		 if(data=1){
			alert("Datos almacenados");
			location.reload(); 
			}
			else{
				alert("Error al guardar");
				}
		

		  }
	  })
}
</script>
</body>
</html>
