<style>
.textosimple {
	FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.textonegrita {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif
}
</style>
<?
$conn = @pg_connect("dbname=coi_usuario host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino 1");


$sql="SELECT fs.fecha,i.nombre_instit,fs.nombre_solicitante,fs.id_soporte, ps.nombre
FROM soporte.fono_soporte fs 
INNER JOIN institucion i ON fs.rdb=i.rdb
INNER JOIN soporte.personal_soporte ps ON fs.rut_asignado=ps.rut_soporte
WHERE fs.estado<>4
ORDER BY fs.fecha ASC";
$rs_soporte = pg_exec($conn,$sql);
?>

<? for($i=0;$i<pg_num_rows($rs_soporte);$i++){
		$fila = pg_fetch_array($rs_soporte,$i);
	$mesg.=".
		<table width='650' border='0' style='border-collapse:collapse>
		  <tr>
			<td width='206' class='textonegrita'>&nbsp;FECHA</td>
			<td width='434' class='textosimple'>&nbsp;$fila[fecha]</td>
		  </tr>
		  <tr>
			<td class='textonegrita'>&nbsp;INSTITUCION</td>
			<td class='textosimple'>&nbsp;$fila[nombre_instit];</td>
		  </tr>
		  <tr>
			<td class='textonegrita'>&nbsp;SOLICITANTE</td>
			<td class='textosimple'>&nbsp;$fila[nombre_solicitante];</td>
		  </tr>
		  <tr>
			<td class='textonegrita'>&nbsp;ATENDIDO POR</td>
			<td class='textosimple'>&nbsp;$fila[nombre];</td>
		  </tr>
		  <tr>
			<td class='textonegrita'>&nbsp;OBSERVACIONES</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan='2' valign='top'><table width='100%' border='1' style='border-collapse:collapse'>";
			
			 $sql="SELECT fecha, observacion FROM soporte.fono_detalle_soporte fds WHERE fds.id_sol=".$fila['id_soporte'];
				$rs_detalle = pg_exec($conn,$sql);
				
				for($j=0;$j<pg_num_rows($rs_detalle);$j++){
					$fila_det = pg_fetch_array($rs_detalle,$j);
					$fecha=$fila_det['fecha'];
					$obs = utf8_decode($fila_det['observacion']);
		$mesg.="		
		  <tr>
			<td class='textosimple'>&nbsp;$fecha</td>
			<td class='textosimple'>&nbsp;$obs</td>
		  </tr>";
		  } 
        $mesg.="
		</table>
		</td>
		  </tr>
		 </table>";
		 if(!isset($mesg)){
			$mesg="NO EXISTEN SOLICITUDES PENDIENTES DE LLAMADO"; 
		 }
?>		 
 <br />

<? }
		$to0 ="erojas@colegiointeractivo.com";
		$to1="dzamora@colegiointeractivo.com";
		$to2="bvargas@colegiointeractivo.com";
		$to3="cgomez@colegiointeractivo.com";
		for($m=0;$m<4;$m++){
			$to=${"to".$m};
		$subject = "Reporte Diario de Soporte";
		$message = $mesg;
		$headers = "From: solicitudes@colegiointeractivo.com\r\n" .
			   'X-Mailer: PHP/' . phpversion() . "\r\n" .
			   "MIME-Version: 1.0\r\n" .
			   "Content-Type: text/html; charset=utf-8\r\n" .
			   "Content-Transfer-Encoding: 8bit\r\n\r\n";
		
		$a="<head>
		</style>
		
		
		
		</head>
		<body>";
		$url.="<span class=firma><br><br><b><font face='verdana' size='1'>ESTE CORREO SE GENERA AUTOMATICAMENTE, Y NO ESTA HABILITADO PARA RESPUESTAS. LOS TILDES HAN SIDO ELIMINADOS INTENCIONALMENTE	</font></b></span>";
		
		$url.="
		<span class=firma>
		<br>_________________________________<BR>
		<font face='verdana' size='1'>SAE 3.0(Nuevo Diseño)</font><br>
		
		<a href=\"http://www.colegiointeractivo.com/\"><font face='verdana' size='1'>http://www.colegiointeractivo.com/</font></a>
		</span>
		";
		
		
		$a=$a.$message."$url</body>";
		$message=$a;
		
		
		require_once("soporte_fono/mail/class.phpmailer.php");
		
		$mail = new PHPMailer();
		$mail->From     = "solicitudes@colegiointeractivo.com";
		//$mail->From     = "vsaavedra@colegiointeractivo.com";
		$mail->FromName = "Sistema de requerimientos SAE";
		$mail->Mailer   = "smtp";
		
		$mail->Host     = "mail.colegiointeractivo.com";
		$mail->Username = "solicitudes@colegiointeractivo.com";
		$mail->Password = "sol2010";
			
		$mail->IsHTML(true);
		$mail->SMTPAuth = true;
		$mail->Subject =  $subject;
		$mail->Body     =  $message;
		$mail->AddAddress($to);
		$mail->Send();

		}
 ?>

