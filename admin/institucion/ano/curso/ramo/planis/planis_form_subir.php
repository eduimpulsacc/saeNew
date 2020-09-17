<?php
	require('../../../../../../util/header.inc');
//print_r($_GET);


$rut_emp= $_NOMBREUSUARIO;
$id_curso = $_CURSO;





?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link href="./scripts/SpryData.css" rel="stylesheet" type="text/css">
<script src="scripts/utils.js"></script>



<title>Subir Archivo</title>
</head>

<body>



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
	                            					<tr>
														<td height="390" valign="top">


   
    
<form method="post" action="guarda_archivo.php" name="form_archivo" id="form_archivo" enctype="multipart/form-data"  >
<input type="hidden" id="rutemp" name="rutemp" value="<?=$rut_emp?>">
 <input type="hidden" id="id_curso" name="id_curso" value="<?=$id_curso?>">
 <input type="hidden" id="id_ramo" name="id_ramo" value="<?=$id_ramo?>">

<table>
<tr>
<td><h3><p>Subir Planificaciones</p></h3></td>
</tr>
</table>
<table>
    <tr>
      
        <td class="texto2">&nbsp;</td>
    </tr>
    
     <tr>
        <td width="87" class="texto1">&nbsp;&nbsp;Archivo:&nbsp;</td>
        <td  class="texto2"><input name="archivo" id="archivo" type="file" width="50px" ></td>
    </tr>
    <tr>
        <td colspan="3" class="texto2">&nbsp;</td>
    </tr>
    
	<tr>
		<td class="texto1">&nbsp;&nbsp;Descripci&oacute;n:&nbsp;</td>
		<td  class="texto2"><label><textarea  name="text_descripcion" id="text_descripcion" cols="50" rows="3"></textarea></label></td>
		</tr>
        <tr>
        <td colspan="3" class="texto2">&nbsp;</td>
    </tr>
        
       
        <tr>
        
        <td>&nbsp;</td>
        <td width="317">
        <input type="submit" value="Guardar">&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" value="Volver" onclick=document.location="planificacion.php?id_ramo=<?php echo $id_ramo; ?>" />
        </td>
        <td width="238">&nbsp;</td>
        </tr>
        
        
         <tr>
        <td>&nbsp;
     
        </td>
        </tr>
        
        </table>
        <br>
</form>



	  	<table width="100%" border="1" class="titulo1" style="border-collapse:collapse">
	     	<tr valign="top" align="center">
				
                <th >Fecha</th>
                <th >Observacion</th>
                <th >Nombre Archivo</th>
                 <th >descargar</th>
				 <th >Eliminar</th>
		  </tr>
            
            
            <?php

 $sql_archivos="select * from plani_archivos where rut_emp =".$_NOMBREUSUARIO." and id_ramo=$id_ramo and id_curso=$id_curso";
		$result_archivos = pg_Exec($conn, $sql_archivos);
               for ($j = 0; $j < pg_numrows($result_archivos); $j++){
				$fila_archivos = pg_fetch_array($result_archivos,$j) or die("Error obteniendo Archivos");
				$archivo=$fila_archivos['ruta_archivo'];
			   
?>
			<tr  class="fila_archivos" >
				
        <td valign="top"><?=$fila_archivos['fecha']?></td>
        <td valign="top"><?=$fila_archivos['observ']?></td>
        <td valign="top"><?=$fila_archivos['ruta_archivo']?></td>
               
        <td align="center">
        <!--"descargar_archivo.php?archivo=-->
         <a href="archivos/<?=$archivo;?>" target="_blank"> <img src="../../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/ICO/Save.ico" width="30" height="30"/></a>		
        
        </td>
        <td align="center">
        
    <img src="../../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/ICO/Delete.ico" width="30" height="30" style="cursor: pointer" onclick="elimina(<?=$fila_archivos['id_archivo']?>)"/>		
        
        </td>
        
        
        
				
			</tr>
            <?
            }
			?>
           
            </table>


<br>

</body>
</html>
