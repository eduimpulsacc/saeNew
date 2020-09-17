<? header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "mod_ano_escolar.php";
 $_NRO_ANO_;
$funcion = $_POST['funcion'];

$Ob_ano = new AnoEscolar($_IPDB,$_ID_BASE);

if($funcion==1)
{
	
	$regis = $Ob_ano->busca_anos($rdb);
	
//	if(pg_numrows($regis > 0)){
		
		?>
        	<table width='90%' border='0' align='center' id="tb_agregar">
			  <tr class='Estilo19'>
				<td>A&Ntilde;OS ACADEMICOS</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td align='right'>&nbsp;<!--<img src="img/PNG-48/Add.png" id="btn_agregar" width="30" height="30" onclick='tabla_ingreso()' onmouseover=this.style.cursor='pointer' title="AGREGAR NUEVO A&Ntilde;O">	-->			  
              </td>
			  </tr>
			</table>
        <table width="90%" align="center">
        <tr class="cuadro02">
        <td>RDB</td>
        <td>A&ntilde;o</td>
        <td>Situaci&oacute;n</td>
        </tr>
        <?
			for($x=0;$x < pg_numrows($regis);$x++)
			{
				$fila = pg_fetch_array($regis,$x);
				?>
                <tr class="cuadro01" align="center" id="<?="id_$x";?>" style="background-color:#f0f0f0; cursor:pointer" onmousemove="cambiar('<?="id_$x";?>','#FFFF00')" onmouseout="cambiar('<?php echo "id_$x";?>','#f0f0f0')" onclick="CambiaAno(<?=$fila['nro_ano']?>)">
                
                <td><?=$fila['rdb']?></td>
                <td><?=$fila['nro_ano']?></td>
                <td><?=$fila['estados']?></td>
                
                
                <?
					
			}
		
		?>
        
        </tr>
        </table>
        
		<?
	//	}else{
		//echo 0;	
		//}
}



if($funcion==2){
	echo $_POST['nro_ano'];
	//echo "A&ntilde;o Actual = ".$nro_ano=$_POST['nro_ano'];
	$_SESSION['_NRO_ANO_']=$_POST['nro_ano'];
    $_NRO_ANO_=$_SESSION['_NRO_ANO_'];
	
	 global $_NRO_ANO_;
		
	}
	
	
	if($funcion==3)
{
	$regis = $Ob_ano->busca_ano_actual($_NRO_ANO_,$rdb);
	
//	if(pg_numrows($regis > 0)){
		
		?>
        	<table width='90%' border='0' align='center' id="tb_agregar">
			  <tr class='Estilo19'>
				<td>A&Ntilde;O ACTUAL</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td align='right'>&nbsp;<img src="img/PNG-48/Back.png" id="btn_volver" width="30" height="30" onclick='volver()' onmouseover=this.style.cursor='pointer' title="VOLVER">
               <!-- <img src="img/PNG-48/Modify.png" id="btn_modificar" width="30" height="30" onclick='tabla_modifica()' onmouseover=this.style.cursor='pointer' title="MODIFICAR">	-->			  
              </td>
			  </tr>
			</table>
        <table width="90%" align="center">
        <tr class="cuadro02">
        <td>RDB</td>
        <td>A&ntilde;o</td>
        <td>Situaci&oacute;n</td>
        </tr>
        <?
			for($x=0;$x < pg_numrows($regis);$x++)
			{
				$fila = pg_fetch_array($regis,$x);
				?>
                <tr class="cuadro01" align="center" id="<?="id_$x";?>" style="background-color:#f0f0f0; cursor:pointer" onmousemove="cambiar('<?="id_$x";?>','#FFFF00')" onmouseout="cambiar('<?php echo "id_$x";?>','#f0f0f0')">
                
               <td><?=$fila['rdb']?></td>
                <td><?=$fila['nro_ano']?></td>
                <td><?=$fila['estados']?></td>
                
                
                <?
					
			}
		
		?>
        
        </tr>
        </table>
        
		<?
	//	}else{
		//echo 0;	
		//}
}


?>

