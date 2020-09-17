<?
//include "../util/funciones_utiles.php";
session_start();	

  $nombreusuario=$_NOMBREUSUARIO;
  $usuario = $_USUARIO;

	
   function error($error) {
	 echo "<html><title>ERROR</title></head>";
	 echo "<body><center>";
	 echo $error;
	 echo "</center></body></html>";
	}
	
	$conn=pg_connect("dbname=coi_usuario host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j");
	
	if (!$conn){
	  error('<b>ERROR:</b>No se puede conectar a la base de datos.(1)');
	  exit;
	}
	
	
	

$_POSP = 1;
$_NOMBREUSUARIO = $_SESSION['_NOMBREUSUARIO'];

function conector($sql){
	
    $conectores = array();
	/*$conectores[] = array("coi_final","10.132.10.36","5432","postgres","cole#newaccess");
	$conectores[] = array("coi_corporaciones","200.29.21.124","5432","postgres","cole#newaccess");
	$conectores[] = array("coi_antofagasta","200.29.70.184","5432","postgres","anto2010");
    $conectores[] = array("coi_final_vina","200.29.21.124","5432","postgres","cole#newaccess");*/
	
  /*  $conectores[] = array("coi_final","192.168.100.203","5432","postgres","300600");
    $conectores[] = array("coi_corporaciones","192.168.100.203","5432","postgres","300600");
	$conectores[] = array("coi_final_vina","192.168.100.203","5432","postgres","300600");
	$conectores[] = array("coi_antofagasta","192.168.100.203","5432","postgres","300600");*/
	
	for($e1=0;$e1<count($conectores);$e1++){
		
		$dbname = $conectores[$e1][0];
		$host = $conectores[$e1][1];
		$port = $conectores[$e1][2];
		$user = $conectores[$e1][3];
		$password = $conectores[$e1][4];
		
		$conect =pg_connect("dbname=$dbname host=$host port=$port user=$user password=$password");
		 		
		$result = pg_Exec($conect,$sql);
		
		return $result;
			
		pg_close($conect);
				
	 }  // fin for conector

  } // fin function conectores

	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilos.css" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
<style type="text/css">
<!--
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 10px; }
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo5 {font-size: 10px}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC? DEBE IR CON INCLUDE -->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				
				 <? include("../cabecera/menu_superior.php"); ?>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">&nbsp;</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><div align="center">
								  
								     <!-- INSERTAMOS NUEVO CODIGO -->
									 
									 
		<table width="600" border="0" cellspacing="1" cellpadding="3">
		  <tr>
		    <td align="right"><INPUT class="botonXX"  name="button" TYPE="button" onClick=document.location="../menu/salida.php" value="SALIR"></td>
		  </tr>		
		</table>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3" >
			<tr>
				<td colspan=4 align=left>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR >
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>USUARIO</strong>								</FONT>							</TD>
							<TD>
							<FONT face="arial, geneva, helvetica" size=2>
							<strong>:</strong>
                            </FONT>
                            </TD>
						<TD>
						<FONT face="arial, geneva, helvetica" size=2>
						<strong>
						<?php
                        
                        $qry="SELECT * FROM USUARIO WHERE nombre_usuario='".$_NOMBREUSUARIO."'";
                       /* $res = pg_Exec($conn,$qry);
                        if(pg_num_rows($res)!=0){  
                                    $fila1 = @pg_fetch_array($res,0);		
                                }*/
                        
                        $qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$_NOMBREUSUARIO."";
                       /* $res = pg_Exec($conn,$qry);
                        if(pg_num_rows($res)!=0){  
                                    $fil = @pg_fetch_array($res,0);	
                                    echo trim($fil['nombre_emp']." ".$fil['ape_pat']." ".$fil['ape_mat']);
                                } */
                            
                        ?>
</strong>
</FONT>	
</TD>
</TR>
</TABLE>
</td>
</tr>
<tr>
<td colspan=4 align=right>
<!--INPUT TYPE="button" value="SALIR" onClick=document.location="seteaInstitucion.php3?caso=2"-->				</td>
</tr>
<tr height="20">
<td colspan="4" align="middle" class="tableindex Estilo4 Estilo5">PERFILES DE ACCESO ASOCIADOS</td>
</tr>
<tr>
<td width="150" align="CENTER" class="tablatit2-1 Estilo4 Estilo5">PERFIL</td>
<td width="350" align="CENTER" class="tablatit2-1 Estilo4 Estilo5">INSTITUCION</td>
<td width="100" align="CENTER" class="tablatit2-1 Estilo4 Estilo5">SISTEMA</td>
<td width="100" align="CENTER" class="tablatit2-1 Estilo4 Estilo5">ESTADO</td>
</tr>

<?php 

$num_result = 0;

$qry="SELECT  usuario.id_usuario,perfil.id_perfil,perfil.nombre_perfil,accede.id_perfil, 
accede.estado, accede.id_base,upper(institucion.nombre_instit) as nombre_instit,institucion.rdb, s.nombre, c.nombre_corp
FROM usuario 
INNER JOIN accede ON usuario.id_usuario = accede.id_usuario 
INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil 
INNER JOIN sistemas s ON s.id_sistema=accede.id_sistema
LEFT JOIN institucion ON institucion.rdb = accede.rdb 
LEFT JOIN corp_instit ci ON ci.rdb=institucion.rdb
LEFT JOIN corporacion c ON  CAST(c.num_corp as integer)=ci.num_corp
WHERE usuario.nombre_usuario = '".$_NOMBREUSUARIO."' AND accede.estado=1; ";

$result =@pg_Exec($conn,$qry);
$num_result = pg_num_rows($result);

$_APODERADO = $_NOMBREUSUARIO;
$_SESSION['_APODERADO'] = $_APODERADO;


for($i=0 ; $i < @pg_numrows($result) ; $i++){
	
	
		$fila = @pg_fetch_array($result,$i);
		
		/*
		if($fila['id_nacional']!=NULL){
		$_NACIONAL=$fila['id_nacional'];
		$_SESSION['_NACIONAL'] = $_NACIONAL ;
	  }*/


if($fila['id_perfil']!=3 && $fila['id_perfil']!=4 && $fila['id_perfil']!=5 && $fila['id_perfil']!=7 && $fila['id_perfil']!=21){				

	if($fila["estado"]==1){

	$idrdb = $fila['rdb'];
	$rdbid = base64_encode($idrdb);

    $idperfilas = $fila['id_perfil'];
	$encripta = base64_encode($idperfilas);
	
	//$num_corp = $fila['num_corp'];
		
	  if($fila['id_perfil'] == 44 and $fila['id_perfil'] == 45 ){
             //$num_corp = $fila["id_nacional"];  // si es perfil nacional  hacer segimiento a la variable que solo se le cambia el valor
      }elseif ($fila['id_perfil'] == 26 ){
             //$num_corp = $fila['num_corp']; // si es perfil sostenedor
      }
 	   
	   if($fila['id_perfil'] == 40 ){
            // $num_corp = $fila["id_nacional"];  // si es perfil nacional  hacer segimiento a la variable que solo se le cambia el valor
      }
	  
	  
	  $num_corp = 1;
	  
	   $corp_num = base64_encode($num_corp);

	?>
<tr bgcolor=#ffffff onmouseover=this.style.background='#FFFFCC';this.style.cursor='hand' onmouseout=this.style.background='transparent' 
onClick=go('seteaUsuario.php?institucion=<?=$idrdb?>&perfil=<?=$idperfilas?>&caso=1&id_base=<?=$fila["id_base"]?>')>
<?php }else{?>
<tr class="Estilo3">
<?php }?>
<td align="right">
<span class="Estilo3">
<font color="#999999">
<?=$fila["nombre_perfil"]."-".$idperfilas;?>
</font>
</span>
</td>
<td align="left" >
<span class="Estilo3">
<font color="#999999">

<?
	if($fila['id_perfil']==26 || $fila['id_perfil']==47){
		echo $fila["nombre_corp"];
	}else{
		echo $fila["nombre_instit"];
	}

?>  
</font>
</span>
</td>
<td align="left" ><span class="Estilo3">
<font color="#999999"><?=$fila["nombre"]?></font>
</span>
</td>
<td align="left" ><span class="Estilo3"><font color="#999999">
							<?php 
								switch ($fila["estado"]) {
									 case 0:
										 echo 'DESHABILITADO';
										 break;
									 case 1:
										 echo 'HABILITADO';
										 break;
								 };

								?>
							</font> </span></td>
		  </tr>
		  <?				}	// fin if de los perfiles no usados		?>
			<?php
					}
			
			?>
			<tr>
				<td colspan="4">
				<hr width="100%" color="#0099cc">				</td>
			</tr>
		</table>			</td>
			</tr>

<? if($fila1['nombre_usuario']==12166738){?>
	<tr>
	  <td align="center" class="Estilo3">EL ADMINISTRADOR WEB TIENE LA POSIBILIDAD DE CREAR M?S PERFILES<br>
(ORIENTADOR, JEFE DE UTP, DIRECTOR, ALUMNO, ETC)</td>
	</tr>
<? } ?>
	
	</table>
		  <!-- FIN DE NUEVO CODIGO -->
		  
		  
								  </div></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include('../cabecera/menu_inferior.php');?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>