<?php
 
 
if (isset($_POST["captcha"])) 
 {
    session_start();
	//Verifying user input captcha text with google generated captcha
    if ($_SESSION["captcha"] == $_POST["captcha"]) 
	{
		
		if($_POST["cmbPerfil"]==1){
		$c = " and accede.id_perfil=16";
		}
		elseif($_POST["cmbPerfil"]==2){
		$c = " and accede.id_perfil=15";
		}
		if($_POST["cmbPerfil"]==3){
		$c = " and accede.id_perfil not in(0,15,16)";
		}
		
		$r = explode("-",$_POST["rut"]);
		$rut = $r[0];
		
		$connection=pg_connect("dbname=coi_usuario host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conex Coi_Usuario");
		
		 $sql = "select nombre_usuario,pw,id_base from usuario
inner join accede on accede.id_usuario = usuario.id_usuario
where usuario.nombre_usuario = '".$rut."' and accede.estado=1  $c GROUP by nombre_usuario,pw,id_base;";
	$rs = pg_exec($connection,$sql);
	
	if(pg_numrows($rs)>0){
		
		$id_base = pg_result($rs,2);
		$login = pg_result($rs,0);
		$pw = pg_result($rs,1);
		
		if($id_base==1)
		{
			$BaseDatos = "coi_final";	
			$Servidor = "192.168.1.10";		
		}
		
		elseif($id_base==2)
		{
			$BaseDatos = "coi_final_vina";	
			$Servidor = "192.168.1.12";	
		}
		
		elseif($id_base==3)
		{
			$BaseDatos = "coi_antofagasta";	
			$Servidor = "192.168.1.11";	
		}
		
		elseif($id_base==4)
		{
			$BaseDatos = "coi_corporaciones";	
			$Servidor = "192.168.1.12";	
		}
		
		$Usuario = "postgres";
		$Clave = "f4g5h6.j";
		$Port = "5432";
		
		$cadenaconeccion = "dbname = ".$BaseDatos." host=".$Servidor." port = ".$Port." user = ".$Usuario."  password = ".$Clave." ";
		
			$Conect = pg_connect($cadenaconeccion) or die("no conecta");
			
			//echo $cadenaconeccion; exit;
			
		if($_POST["cmbPerfil"]==1){
		//alumno
		$sql_u ="select nombre_alu, ape_pat, ape_mat from alumno where rut_alumno = $rut";
		}
		elseif($_POST["cmbPerfil"]==2){
			$sql_u ="select nombre_apo, ape_pat, ape_mat from apoderado where rut_apo = $rut";
		
		}
		if($_POST["cmbPerfil"]==3){
		$sql_u ="select nombre_emp, ape_pat, ape_mat from empleado where rut_emp = $rut";
		}
		
		$rs_u = pg_exec($Conect,$sql_u);
		
		$nom= pg_result($rs_u,0);
		$ape_pat= pg_result($rs_u,1);
		$ape_mat= pg_result($rs_u,2);
		
		
	//mail("ccanto@colegiointeractivo.com","aaaa","hola");
	echo "<b class=\"correct\">Se ha enviado su contrase&ntilde;a a la direcci&oacute;n de correo ingresada.  Si no ve el mensaje en su bandeja de entrada, revise su bandeja de SPAM.</b>";
	
	
	
	
	
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <contacto@colegiointeractivo.com>' . "\r\n";
	$subject = "[Sistema SAE] Recuperar contraseña";
	
	$message = "
	<html>
	<body>
	Estimado(a) usuario(a) $nom $ape_pat $ape_mat:<br />
<br />
A continuación encontrará los datos de acceso a la plataforma:
 <br /><br /><br />
<table border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td width='174' valign='top'><b>URL</b></td>
      <td width='573' valign='top'><a href='http://www.colegiointeractivo.cl' target='_blank'><b>www.colegiointeractivo.cl</b></a></td>
    </tr>
    <tr>
      <td width='174' valign='top'>
       <b>Usuario</b>
        </td>
      <td width='573' valign='top'><b>$login </b></td>
    </tr>
    <tr>
      <td width='174' valign='top'>
       <b>Contraseña</b>
        </td>
      <td width='573' valign='top'><b>$pw </b></td>
    </tr>
  </tbody>
</table>

	
	 <p><i>Este es un mensaje automático, por favor no lo responda.</i></p>
	</body>
	</html>
	";
	
	//echo $message;
	
	mail($_POST["email"],$subject,$message,$headers);
	}
	else{
		echo "<b class=\"wrong\">Datos no encontrados. Comun&iacute;quese con el administrador del sistema SAE en su colegio</b>";
	}
	//var_dump($_POST);	
   // header("location:mensaje.php");
    } 
	else 
	{
    echo "<b class=\"wrong\">C&oacute;digo incorrecto</b>";
    }
    unset($_SESSION['captcha']);
}
?>