<?php 
require('../../util/header.inc');
require('../../util/funciones_new.php'); 
require("mod_clave.php");

$ob_clave = new Clave();

	//--------------------------------
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
    $alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$_POSP          =2;
	//-------------------------------
	$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
	$result =@pg_Exec($conn,$qry);
	$fila = @pg_fetch_array($result,0);	
	$nro_ano=$fila['nro_ano'];

	$sql="SELECT nombre_alu ||' '|| ape_pat ||' '|| ape_mat AS nombre FROM alumno WHERE rut_alumno=".$alumno;
	$rs_alumno = pg_exec($conn,$sql);
	$nombre_alumno = pg_result($rs_alumno,0);
	
	
	// REGISTRO DE HISTORIAL DE NAVEGACION
	registrarnavegacion($_USUARIO,'CAMBIO DE CLAVE',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);
	//******************************************************//


if($funcion==1){?>
	<table width="95%" border="0" align="center">
  <tr>
    <td class="tableindexredondo">CAMBIAR CLAVE DE ACCESO</td>
    </tr>
</table>
	<br>
    <table width="85%" border="0" align="center">
      <tr>
        <td align="right">&nbsp;<input name="cmbGUARDAR" type="button" value="GUARDAR" class="botonXX" onClick="guardar();"></td>
      </tr>
    </table>

	<table width="85%" border="1" align="center" style="border-collapse:collapse">
	  <tr class="detalleon">
	    <td>INGRESAR CLAVE ACTUAL</td>
	    <td>INGRESAR NUEVA CLAVE ACCESO</td>
	    <td>REPETIR NUEVA CLAVE ACCESO</td>
      </tr>
	  <tr>
	    <td><input name="txtCLAVE" type="password" id="txtCLAVE" onBlur="valida();" maxlength="8"></td>
	    <td><input name="txtNEWCLAVE" type="password" id="txtNEWCLAVE" maxlength="8"></td>
	    <td><input name="txtNEWCLAVE2" type="password" id="txtNEWCLAVE2" maxlength="8"></td>
      </tr>
</table>

<?	
}
if($funcion==2){
	$rs_modifica = $ob_clave->ModificarClave($connection,$usuario,$clavenew);
	
	if($rs_modifica){
		echo 1;
	}else{
		echo 0;
	}
	
}

if($funcion==3){
	$rs_valida = $ob_clave->Valida($connection,$usuario,$claveant);
	
	if(pg_numrows($rs_valida)!=0){
		echo 1;	
	}else{
		echo 0;
	}
		
}
?>
