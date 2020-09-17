<?php require('../../../../../util/header.inc');?>

<?php 
	if ($ano){
		$_ANO=$ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
	  	};
	}
	if ($curso){
		$_CURSO=$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
	  	};
	}

//echo $_MENU."--".$_CATEGORIA."---".$_ITEM;
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;	
	$_POSP          = 5;
	
	$_bot           = 5;
	
	$sql="SELECT * FROM perfil_curso WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL."";
		if($_PERFIL!=0){
			$sql.=" AND rut_emp=".$_NOMBREUSUARIO;
		}
		//echo $sql;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		//curso.ensenanza=".pg_result($rs_acceso,3)."
		
		if(pg_num_rows($rs_acceso)!=0 && $_PERFIL!=0){
			/*$whe_perfil_curso=" AND curso.ensenanza in (";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['cod_tipo'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['cod_tipo'];
				}
			}*/
			$whe_perfil_curso.= /*)*/"  AND id_curso in(";
			
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['id_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['id_curso'];
				}
			}
			$whe_perfil_curso.=")";
		}else{
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)){$whe_perfil_ano=" and id_ano=$ano";}
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)&&($_PERFIL!=19)&&($_PERFIL!=2)&&($_PERFIL!=20)&&($_PERFIL!=27)){$whe_perfil_curso=" and curso.id_curso=$curso";}
		}
	if (trim($_url)=="") $_url=0;
	//imprime_array($_SESSION);

?>


 <?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../index.php";
		 </script>

<? } ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar   </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--p
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

 
		 
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}		 
		
//-->
</script>
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>

<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script>
$( document ).ready(function() {
    cargaAno();
	
	
	
});

function cargaAno(){
	 funcion=1;
	 var rdb="<?=$institucion;?>"
	var parametros='funcion='+funcion+'&rdb='+rdb;
	//alert(parametros);	
	
	$.ajax({
	  url:'con_vel.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// alert(data);
	    $("#an").html(data);
		  }
	  })
	}
	
	
function cCur(){
	var funcion=2;
	var ano= $("#cmb_ano").val();
	var parametros='funcion='+funcion+'&ano='+ano;
	if(ano!=0){
		$.ajax({
	  url:'con_vel.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// alert(data);
	    $("#cur").html(data);
		  }
	  })
	
	}
}

function buscaEva(){
var funcion = 3;
var ano= $("#cmb_ano").val();
var curso= $("#cmb_curso").val();
var fecha= $("#txtFECHA").val();
 var rdb="<?=$institucion;?>"
var parametros='funcion='+funcion+'&ano='+ano+"&curso="+curso+"&fecha="+fecha+'&rdb='+rdb;
$.ajax({
	  url:'con_vel.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#eva").html(data);
		  }
	  })
			
}

function guardaeva(){
	var funcion = 4;
	var frm= $("#frmeca").serialize();
	var ano= $("#cmb_ano").val();
	var curso= $("#cmb_curso").val();
	var fecha= $("#txtFECHA").val();
	var parametros='funcion='+funcion+'&ano='+ano+"&curso="+curso+"&fecha="+fecha+'&frm='+frm;
		$.ajax({
	  url:'con_vel.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//console.log(data);
	    //$("#cur").html(data);
		alert("Datos guardados");
		window.location.reload();
		  }
	  })

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
			<?   //include("../../../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
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
					  <table><tr><td><? $menu_lateral="3_1";?><?
					  
						 include("../../../../../menus/menu_lateral.php");
						 
						 
						 ?>
						 
						 
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%">
                              <tr>
                                <td valign="top"><table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
                                  <TR height=15>
                                    <TD width="600"><table border=0 align="left" cellpadding=1 cellspacing=1>
                                      <tr>
                                        <td align=left><font face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> </font> </td>
                                        <td><font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
                                        <td><font face="arial, geneva, helvetica" size=2> <strong>
                                          <?php  
                                                                               
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													
													echo trim($fila['nombre_instit']);
												}
											}
										?>
                                        </strong> </font> </td>
                                      </tr>
                                      <tr>
                                        <td align=left><font face="arial, geneva, helvetica" size=2> <strong>A&Ntilde;O ESCOLAR</strong> </font> </td>
                                        <td><font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
                                        <td><div id="an">
                                          <select name="select" id="select">
                                            <option value="0">seleccione</option>
                                          </select>
                                        </div></td>
                                      </tr>
                                      <tr>
                                        <td align=left><font face="arial, geneva, helvetica" size=2> <strong>CURSO</strong> </font> </td>
                                        <td><font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
                                        
                                          <td  valign="bottom">
                                          <div id="cur">
                                          <select name="select2" id="select2">
                                            <option value="0">seleccione</option>
                                          </select>
                                          </div>
                                          </td>
                                        
										
					
										
                                      </tr>
                                      <tr>
                                        <td align=left><font face="arial, geneva, helvetica" size=2> <strong>FECHA</strong></font></td>
                                        <td><font face="arial, geneva, helvetica" size=2> <strong>:</strong></font></td>
                                        <td  valign="bottom"><input name="txtFECHA" type="text" id="txtFECHA" readonly></td>
                                      </tr>
                                      
                                      <tr>
                                        <td align=left>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td  valign="bottom">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td colspan="3" align=left><input type="button" name="button" id="button" value="Buscar" onClick="buscaEva()" class="botonXX"></td>
                                      </tr>
                                    </table>
                            </TD>
                                  </TR>
							
                                </table>                                     <br>
<br>
<br>
<div id="eva">
</div>     
        </td>
                              </tr></table>                   </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
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
