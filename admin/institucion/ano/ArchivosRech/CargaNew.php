<? 
	require('../../../../util/header.inc');
	include('../../../../util/rpc.php3');
	

foreach($_POST as $nombre_campo => $valor)
   { 
      
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	//echo "asignacion=$asignacion<br>";
	
   }
   
    foreach($_GET as $nombre_campo => $valor)
   { 
   
   
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	//echo "asignacion=$asignacion<br>";
   }

	//$institucion	= $_INSTIT;
	 
/*	$institucion	=$_INSTIT;
	$_POSP = 3;
	$cram = $_GET['mdi'];
	$_MDINAMICO = $cram;
	
	if ($_PERFIL == 1){
	   $_MDINAMICO = 1;
	}   
if ($botonera==1){
	$frmModo="mostrar";
	}else{
	$frmModo		=$_FRMMODO;
	}
	$ano			=$_ANO;
	$empleado		=$_EMPLEADO;
*/
$ano = $_ANO;

?>
<?
if (isset($_POST['guardar_comentario']))
{
	
	
	foreach($_POST as $nombre_campo => $valor)
   { 
      
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	//echo "asignacion=$asignacion<br>";
	
   }
   
    foreach($_GET as $nombre_campo => $valor)
   { 
   
   
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	//echo "asignacion=$asignacion<br>";
   }
	

		$Flag=0;
		
			
function DiaHoraHoy1()
{
	return strftime("%Y-%m-%d-%H-%M-%S",time());
}

	  //Variables definidas por el usario
	  $abpath = "Archivos"; //Directorio donde los archivos serán subidos
	  $sizelim = "no"; //Activando el limite de archivo a subir	  
	  $size = "1638400000"; //Soporte para archivos no mayores a 800 KB
	  //Tipos de archivos a soportar
	  $T1 = "image/pjpeg"; //Jpeg type 1 .jpg
	  $T2 = "image/jpeg"; //Jpeg type 2 .jpg
	  $T3 = "image/gif"; //Gif type .gif
	  $T4 = "application/octet-stream"; //Archivos de office .doc .xls
	  $T5 = "text/plain"; //Texto plano .txt 
	  $T6 = "application/msword"; //Texto plano .txt 
	  $log = ""; //Mensaje que se mostrará al usuario 
	  $exten = substr ($Documento_name, -3); //Extensión del archivo a subir
	  $Tip_er = 0; //Variable para indicar algún tipo de error
	  $subirlo = 0; //Variable utilizada para indicar exito
	 // $conn=$connRPC;

		$Otro = $Documento;	
//		$Ruta_completa = "$abpath/" . substr($Documento_name, 0, strcspn($Documento_name,".")) . $_SESSION['Condominio_Id'] . "$fecha.$exten";  
		$Ruta_completa = "Archivos/".substr($Documento_name, 0, strcspn($Documento_name,".")).".".$exten;  
//		$Ruta_completa2 = "Archivos/".substr($Documento2_name, 0, strcspn($Documento2_name,".")).".".$exten;  
//		echo "Ruta_completa=$Ruta_completa<br>";
		$Ruta_copia = "Archivos/Antiguo/".substr($Documento_name, 0, strcspn($Documento_name,"."))."_".$anio_escolar.".".$exten;  
//echo "Ruta_copia=$Ruta_copia<br>";
//exit();
	  //Si se eligio un archivo comenzar
   if ($Documento_name != "") 
	   {
			$subirlo = 0;
			//Chequear que el archivo exista  
			if (file_exists($Ruta_completa)) 
			{ 
				//echo "<br>existe";
				 $log .= "El archivo ya fue recibido durante este dia, por lo que ha sido satisfactoriamente actualizado";
				 $subirlo =1;
				 $Tip_er = 0;
				 
				 			 								
					$sql_reemplaza = "delete from archivo_rech WHERE nombre_archivo= '".$Documento_name."'";
				// echo "sql_reemplaza=$sql_reemplaza<br>";
				$result_reemplaza = pg_exec($conn,$sql_reemplaza);	
				
				chmod ($Otro,777);			 // permiso
				 copy($Otro, $Ruta_copia);

/* ********************** */
			   if (($sizelim == "yes") && ($Documento_size > $size))  
			   { 
					$log .= "El tamaño del archivo no esta permitido.<br>";
					$Tip_er = 1;
					$subirlo = 0;
			   }
			   else
			   {
				//Chequea el tipo de archivo
					if ((($Documento_type == $T1) || ($Documento_type == $T2) || ($Documento_type == $T3) || ($Documento_type == $T4) || ($Documento_type == $T5) || ($Documento_type == $T6)) && (($exten == "txt") || ($exten == "doc") || ($exten == "xls") || ($exten == "pdf") || ($exten == "gif") || ($exten == "jpg"))) 
					{
							  //Subiendo el archivo al directorio
							 copy($Documento, $Ruta_completa);
	
							 //Comprobando si subio o no
	
							 if (file_exists($Ruta_completa)) 
							 {
								  $log .= "El archivo fue recibido correctamente.<br>"; 
								  $Tip_er = 0;
								  $subirlo = 1;
	// insertar el archivo a la tabla archivo_rech, para llevar un control de los archivos ingresados
									$rdb_nro = substr ($Documento_name, 1,-4); //Extensión del archivo a subir
									$separa = explode('_',$rdb_nro);
									$nro = substr($Documento_name,-6,2);
									$rdb = substr($Documento_name,1,-7);
														
									if($nro>10)
									{
										$nro = substr($Documento_name,-6,2);
										$rdb = substr($Documento_name,1,-7);
									}
									else
									{
										$nro = substr($Documento_name,-5,1);
										$rdb = substr($Documento_name,1,-6);
									}
	//								$nombre = substr($Documento_name,0,-4);
									$nombre = setType($Documento_name,"string");
									//$Documento_name=DiaHoraHoy1().".".$exten;
									
									
				 
$sql_insert = "INSERT INTO archivo_rech (rdb,numero,nombre_archivo,estado_archivo) VALUES(".$rdb.",".$nro.",'".$Documento_name."',0)";						  
//echo "sql_insert=$sql_insert<br>";
$result_insert = @pg_exec($conn,$sql_insert)or die($sql_insert.'no lo hizo 1');
						 			  
							 } 
							 else
							 {
								  $log .= "El archivo no pudo ser recibido.<br>";
								  $Tip_er = 1;
								  $subirlo = 0;
							 } 
					  } 
					  else 
					  {
						   $log .= "El archivo no posee un tipo permitido.<br>";
						   $Tip_er = 1;
						   $subirlo = 0;
					  }
				 }

/* ********************** */


			} 
			else 
  		   {
			   //Chequear el tamaño del archivo
			   if (($sizelim == "yes") && ($Documento_size > $size))  
			   { 
					$log .= "El tamaño del archivo no esta permitido.<br>";
					$Tip_er = 1;
					$subirlo = 0;
			   }
			   else
			   {
				//Chequea el tipo de archivo
					if ((($Documento_type == $T1) || ($Documento_type == $T2) || ($Documento_type == $T3) || ($Documento_type == $T4) || ($Documento_type == $T5) || ($Documento_type == $T6)) && (($exten == "txt") || ($exten == "doc") || ($exten == "xls") || ($exten == "pdf") || ($exten == "gif") || ($exten == "jpg"))) 
					{
						  //Subiendo el archivo al directorio
						 copy($Documento, $Ruta_completa);

						 //Comprobando si subio o no

						 if (file_exists($Ruta_completa)) 
						 {
							  $log .= "El archivo fue recibido correctamente.<br>"; 
							  $Tip_er = 0;
							  $subirlo = 1;
// insertar el archivo a la tabla archivo_rech, para llevar un control de los archivos ingresados
								$rdb_nro = substr ($Documento_name, 1,-4); //Extensión del archivo a subir
								$separa = explode('_',$rdb_nro);
								$nro = substr($Documento_name,-6,2);
								$rdb = substr($Documento_name,1,-7);
							if(($nro==21) || ($nro==22) || ($nro==23) || ($nro==24) || ($nro==25) || ($nro==26))
									{
										$nro = substr($Documento_name,-6,2);
										$rdb = substr($Documento_name,1,-7);
									}
									else
									{
										$nro = substr($Documento_name,-5,1);
										$rdb = substr($Documento_name,1,-6);
									}
								$nombre = setType($Documento_name,"string");
								//$Documento_name=DiaHoraHoy1().".".$exten;
								
								
								
$sql_insert = "INSERT INTO archivo_rech (rdb,numero,nombre_archivo,estado_archivo) VALUES(".$rdb.",".$nro.",'".$Documento_name."',0)";						  
$result_insert = @pg_exec($conn,$sql_insert)or die($sql_insert.'no lo hizo 2');
						 //$oid=pg_last_oid($result_insert); 
						 //echo "sql_insert=$sql_insert<br>";
						 } 
						 else
						 {
							  $log .= "El archivo no pudo ser recibido.<br>";
							  $Tip_er = 1;
							  $subirlo = 0;
						 } 
					  } 
					  else 
					  {
						   $log .= "El archivo no posee un tipo permitido.<br>";
						   $Tip_er = 1;
						   $subirlo = 0;
					  }
				 }
			}
		}
		else
		{
			 $log .= "El archivo no pudo ser recibido.<br>";
			 $Tip_er = 1;
			 $subirlo = 0;
			 $Flag=1;
		} 
        
		 if($Flag==0){
		   
 	 		echo "<script>window.location = 'CargaNew.php?rdb=$rdb&caso=1&anio_escolar=$anio_escolar&regimen=$regimen'</script>";
		}
		else{
		   
 	 	echo "<script>window.location = 'CargaNew.php?rdb=$rdb&caso=1&anio_escolar=$anio_escolar&regimen=$regimen'</script>"; 	
 			
			
		} 

		//pg_close($conn);
}
?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 1; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>

<script language="javascript">
function validar(form)
{
	if (form.anio_escolar.value=="")
	{
		alert("Debe ingresar año válido");
		form.anio_escolar.focus();
		return false
	}
	
	if (form.periodo.value==0)
	{
		alert("Debe Seleccionar tipo periodos");
		form.periodo.focus();
		return false
	}
	
	if (form.Documento.value==0)
	{
		alert("Debe Seleccionar documento");
		form.Documento.focus();
		return false
	}
	
}

function solonumero()
{
   if (event.keyCode < 48 || event.keyCode > 57) 
    event.returnValue = false; 
}
</script></head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >

<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
	function delRow(a)
	{
		b="adjunta["+a+"]";
		a="td"+a;
		z=document.getElementById(b);
		z.disabled=true;
		x=document.getElementById(a);
		x.style.display="none";
		//x=document.getElementById('mytable').deleteRow(a)
	}
	
	function insRow()
	{
		largo=document.getElementById('mytable').rows.length;
		var x=document.getElementById('mytable').insertRow(largo);
		j=largo;
		var y=x.insertCell(0)
		y.className="td2";
		y.id="td"+j;
		y.innerHTML="<input name='adjunta["+j+"]' type='file' id='adjunta["+j+"]'><input name='nombreadjunta["+j+"]' type='hidden' id='adjunta["+j+"]'>		<a href=\"javascript:;\" onclick=\"delRow('"+j+"');\">elimina</a>"
	
	}
	
	function coloca_nombre(){
		largo=document.getElementById('mytable').rows.length;
		for (ii=1;ii<largo;ii++){
			origen="adjunta["+ii+"]";
			z=document.getElementById(origen);
			temp=tomaNombre(z)
			
			destino="nombreadjunta["+ii+"]";
			zz=document.getElementById(destino);
			zz.value=temp;	
		}
	}

</script>
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

								   <!-- INSERTAMOS CODIGO NUEVO -->
			
			
			
			
			
			<form action="<? echo $PHP_SELF; ?>" method="post" enctype="multipart/form-data" target="_self" onSubmit="return validar(this)" name="form">
			
				<table width="100%">
					<tr>
						<td colspan="2" class="tablatit2-1" ><CENTER>
						  Alta Nuevo Colegio 
						      <A href="#" alt="galeria"onclick="javascript:window.open('ejarch.php','verdana1','toolbar=no,width=595,height=400,top=100');"><font color="#ffffff">(Ver Archivos Requeridos)</font></a>
						</CENTER>						</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>	
		
					  <tr>
						<td width="25%"><FONT face="arial, geneva, helvetica" size=1 color=BLACK> <strong>A&ntilde;o Escolar (Sólo números)</strong></FONT>  </td>
					    <td width="75%"><!-- <input name="anio_escolar" type="text" id="anio_escolar" onkeypress="javascript:solonumero()" size="10" maxlength="4" value="<?php echo $anio_escolar ?>" />
					      --><select name="anio_escolar">
						<option value="0">--Seleccione--</option>
						<?php 
							$selected="";
							if($anio_escolar>0)
							$selected="selected";
						?>
						<option value="2008" <?php echo $selected ?>>2008</option>
					      </select></td>
					  </tr>
					  <tr>
					    <td><strong><font color="BLACK" size="1" face="arial, geneva, helvetica">Seleccione tipo r&eacute;gimen </font></strong></td>
					    <td><select name="regimen">
						<option value="0">--Seleccione--</option>
						<?php 
							switch($regimen)
							{
								case 3:
								$selected3="selected";
								break;
								
								case 2:
								$selected2="selected";
								break;
							}
						?>
						<option value="3" <?php echo $selected3 ?>>Semestral</option>
						<option value="2" <?php echo $selected2 ?>>Trimestral</option>
					      </select>					    </td>
					  </tr>
					  <tr>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
					    </tr>
					  
					  <tr>
					    <td><FONT face="arial, geneva, helvetica" size=1 color=BLACK> <strong>Archivo </strong></FONT></td>
					    <td><input name="Documento" type="file" size="40" accept="application/*" />
					      &nbsp;&nbsp;&nbsp;&nbsp;
					      <input name="guardar_comentario" type="submit" class="botonXX" value="Guardar" /></td>
					  </tr>
					  <tr>
					    <td colspan="2"><div align="center"></div></td>
					    </tr>
					  <tr>
					    <td colspan="2"><FONT face="arial, geneva, helvetica" size=2 color=BLACK> <strong>NOTA: </strong>DEBE INSERTAR Y PROCESAR UN ARCHIVO A LA VEZ. ALGUNOS DATOS POSTERIORMENTE DEBERÁN SER MODIFICADOS MANUALMENTE </FONT></td>
					    </tr>
</table>	
			</form>	


 <!-- FIN DE INGRESO DE CODIGO NUEVO --> 
							      </td>
							    </tr>
							 </table>	
                          </tr>
                        </table>
						<?php 
						 if ($caso==1)
						{ 
							
							
						
						
						?>
						<br />
						<br />
						<form action="insertaTablas2.php" method="post">
						<table width="100%" border="1" cellpadding="0"  cellspacing="0" bordercolor="#CCCCCC" >
                          <tr class="tablatit2-1">
                            <td colspan="2">Archivos Insertados y distribuidos exitosamente<input type="hidden" name="anio_escolar" value="<?php echo $anio_escolar ?>" />
                            <input type="hidden" name="regimen" value="<?php echo $regimen ?>"  />
                            <input type="hidden" name="rdb" value="<?php echo $rdb ?>" /></td>
                          </tr>
						 <tr>
                            <td colspan="2">&nbsp;</td>
                          </tr>	 <?php 
						  	
								$sql_b="select * from archivo_rech where rdb=".$rdb;
								$result_b = @pg_exec($conn,$sql_b);
								$encontrados=pg_numrows($result_b);
						  		//echo "encontrados= ".pg_numrows($result_b)."<br>";
							
								for ($i=0;$i<$encontrados;$i++)
								{
									$narchivo=pg_result($result_b,$i,'"nombre_archivo"');
									$idarch=pg_result($result_b,$i,'"id_archivo"');
									$estado=pg_result($result_b,$i,'"estado_archivo"');
									
									if ($estado==0)
									$est="No Procesado";
									elseif ($estado==1)
									$est="Procesado";
						   ?>
                          
                          <tr>
                            <td width="30%"><FONT face="arial, geneva, helvetica" size=1 color=BLACK> <strong><?php echo $narchivo ?></strong></FONT></td>
                            <td width="70%"><FONT face="arial, geneva, helvetica" size=1 color=BLACK> <strong>(<?php echo $est ?>)</strong></FONT></td>
                          </tr>
						  <?php }?>
                          <tr>
                            <td colspan="2">&nbsp;</td>
                          </tr>
                          
                          <tr class="tablatit2-1">
                            <td colspan="2" align="center"><input name="Enviar" type="submit" class="botonXX" value="Distribuir Informaci&oacute;n"  /></td>
                          </tr>
                        </table>
						</form>
						<?php }?>
						
					  </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
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