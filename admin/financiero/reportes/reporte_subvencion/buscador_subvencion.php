<?php require('../../../../util/header.inc');
//print_r($_GET);

    echo $_PERFIL;
	echo "--->".$_CORPORACION;
	
	echo $_FRMMODO;
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		 	
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" border="0" cellpadding="0" cellspacing="0">
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
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
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
                                  <td>
					            	
									<!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
	<center>
	<form name="form" action="procesaEstablecimiento.php" method="post">
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">

			<tr height="20">
				
				<td colspan="2" align="middle" class="tableindex">Seleccione las Instituciones que desea visualizar en los Reportes</td>
				<? if($_FRMMODO=="mostrar"){?>
					<td align="center" class="tableindex">&nbsp;&nbsp;&nbsp;<input type="submit" class="botonXX"  value="Modificar"></td>																
				<? }else{?>
					<td align="center" class="tableindex">&nbsp;&nbsp;&nbsp;<input type="submit" class="botonXX"  value="Guardar"></td>				
				<? }?>
			</tr>
			<tr>
				<td align="center" width="50" class="tablatit2-1">
					<div align="center">RBD</div></td>
				<td align="center" width="150" class="tablatit2-1">
					<div align="center">INSTITUCIONES</div></td>
				<td align="center" width="150" class="tablatit2-1">
					<div align="center">ESTADO</div></td>
			</tr>
			<?php
				$qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
				$result_ins=@pg_Exec($conn,$qry_ins);
				for($i=0;$i<pg_numrows($result_ins);$i++)
				{	
					$fila_ins = pg_fetch_array($result_ins,$i);
					$rdb = $fila_ins['rdb'];
				?>
				<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff'>
					<td align="center" class="textosimple"><?=$fila_ins['rdb']?></td>
					<td class="textosimple">&nbsp;&nbsp;<?=$fila_ins['nombre_instit']?></td>
					<? if($_FRMMODO=="modificar"){?>
					<td align="center" class="textosimple"><? if($fila_ins['estado']=='t'){?><input type="checkbox" checked="checked" name="<?=$rdb?>"><? }else{ ?><input type="checkbox"  name="<?=$rdb?>"><? }?></td>
					<? }?>
					
					<? if($_FRMMODO=="mostrar"){?>
						<td align="center" class="textosimple"><? if($fila_ins['estado']=='t')echo "Activado";else echo "Desactivado";?></td>
					<? } ?>
				</tr>						
				
			<?	}	?>

		</table>
	</form>
	</center>
	<?
	$ano			=$_ANO;
	?>
									 
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
									
									
									
								  </td>
							   </tr>
							 </table>							  
								  
								  
								  
								  
		
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
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
</body>
</html>
