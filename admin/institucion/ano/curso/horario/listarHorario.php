<?php 
require('../../../../../util/header.inc');
require('../../../../../util/funciones_new.php'); 

        $institucion	=$_INSTIT;
		$frmModo		=$_FRMMODO;
		$ano			=$_ANO;
		$curso 			=$cmb_curso;
		$curso			=$_CURSO;
		$_POSP          =5;
		$_MDINAMICO     =1;
		$_bot = 5;
		
		$sql="select situacion from ano_escolar where id_ano=$_ANO";
        $result =pg_exec($conn,$sql);
        $situacion_ano=pg_result($result,0);


		$sql="SELECT * FROM horario WHERE id_curso=".$curso;
		$rs_existe = pg_exec($conn,$sql);

		echo $sql="SELECT * FROM perfil_curso WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		
		//curso.ensenanza=".pg_result($rs_acceso,3)." AND
		if(pg_num_rows($rs_acceso)!=0 && $_PERFIL!=0){
			$whe_perfil_curso=" AND  id_curso in(";
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
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)&&($_PERFIL!=19)&&($_PERFIL!=72)){$whe_perfil_ano=" and id_ano=$ano";}
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)&&($_PERFIL!=31)&&($_PERFIL!=1)&&($_PERFIL!=35)&&($_PERFIL!=27)&&($_PERFIL!=19)&&($_PERFIL!=2)&&($_PERFIL!=20)){$whe_perfil_curso=" and curso.id_curso=$curso";}
		}

	// REGISTRO DE HISTORIAL DE NAVEGACION
	registrarnavegacion($_USUARIO,'LISTADO HORARIO',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);
	//******************************************************//
	
	
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
		$_ITEM = $item;
		session_register('_ITEM');
	}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}	
?>

<?php 
	function calcula_numero_dia_semana($dia,$mes,$ano)
	{
		$numerodiasemana = date('w', mktime(0,0,0,$mes,$dia,$ano));
		if ($numerodiasemana == 0) 
			$numerodiasemana = 6;
		else
			$numerodiasemana--;
		return $numerodiasemana;
	}

	//funcion que devuelve el último día de un mes y año dados
	function ultimoDia($mes,$ano){ 
		$ultimo_dia=28; 
		while (checkdate($mes,$ultimo_dia + 1,$ano)){ 
		   $ultimo_dia++; 
		} 
		return $ultimo_dia; 
	} 

	function dame_nombre_mes($mes){
		 switch ($mes){
			case 1:
				$nombre_mes="ENERO";
				break;
			case 2:
				$nombre_mes="FEBRERO";
				break;
			case 3:
				$nombre_mes="MARZO";
				break;
			case 4:
				$nombre_mes="ABRIL";
				break;
			case 5:
				$nombre_mes="MAYO";
				break;
			case 6:
				$nombre_mes="JUNIO";
				break;
			case 7:
				$nombre_mes="JULIO";
				break;
			case 8:
				$nombre_mes="AGOSTO";
				break;
			case 9:
				$nombre_mes="SEPTIEMBRE";
				break;
			case 10:
				$nombre_mes="OCTUBRE";
				break;
			case 11:
				$nombre_mes="NOVIEMBRE";
				break;
			case 12:
				$nombre_mes="DICIEMBRE";
				break;
		}
		return $nombre_mes;
	}

	function SelHor($id_curso,$dia,$con,$institucion)
	{
//		$SQL = "SELECT a.id_horario,to_char(a.horaini,'HH24:MI') || CAST ('-' AS CHARACTER) || to_char(a.horafin,'HH24:MI') AS hora, trim(c.nombre) AS nombre FROM horario a, ramo b, subsector c WHERE a.id_ramo=b.id_ramo AND b.cod_subsector=c.cod_subsector AND a.id_curso=" . $id_curso . " AND a.dia=" . $dia . " union (SELECT a.id_horario,to_char(a.horaini,'HH24:MI') || CAST ('-' AS CHARACTER) || to_char(a.horafin,'HH24:MI') AS hora, trim(c.nombre_taller) AS nombre FROM horario a, taller c WHERE a.id_taller=c.id_taller AND c.rdb=" . $institucion ." AND a.dia=" . $dia . "AND a.id_curso=" . $id_curso . ") order by hora";		
		$SQL = "SELECT id_horario, id_ramo, id_taller, to_char(horaini,'HH24:MI') || CAST ('-' AS CHARACTER) || to_char(horafin,'HH24:MI') AS hora from horario where id_curso = '$id_curso' and dia = '$dia' order by horaini";
		$lishor = @pg_exec($con,$SQL);

		$sql_noasignado = "select id_horario, id_ramo, to_char(horaini,'HH24:MI') || CAST ('-' AS CHARACTER) || to_char(horafin,'HH24:MI') AS hora from horario where id_curso = '$id_curso' and dia = '$dia' and id_taller = '0'  order by horaini";
		$res_noasignado = @pg_Exec($con,$sql_noasignado);	
		$cant = pg_numrows($res_noasignado);
/*		
		$SQL2 = "SELECT id_horario, id_ramo, id_taller, to_char(horaini,'HH24:MI') || CAST ('-' AS CHARACTER) || to_char(horafin,'HH24:MI') AS hora from horario where id_curso = '$id_curso' and dia = '$dia' order by horaini";
		$lishor2 = @pg_exec($con,$SQL);
*/		
		?>
<TABLE width='100%' BORDER=1 CELLSPACING=1 CELLPADDING=1><?
		for($y=0;$y<$cant;$y++){
			$fila_noasignado = pg_fetch_array($res_noasignado,$y);
			$sql_comprueba = "select * from ramo where id_ramo = '$fila_noasignado[id_ramo]'";
			$res_comprueba = pg_Exec($sql_comprueba);
			$tot = @pg_numrows($res_comprueba);			
			if($tot==0){ 
 ?>
		<TR bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_noasignado['id_horario']; ?>&caso=1')">
				<td align='center' valign="top">
					<font face='arial, geneva, helvetica' size='1' color='#000000'>
					<strong><?=$fila_noasignado['hora']?></strong>
					</font>
				</td>
				<td align='center' valign="top">
					<font face='arial, geneva, helvetica' size='1' color='#000000'>
					<strong>Indeterminado</strong>
					</font>
				</td>				
					
				</tr>
<?php		
				}		
			}
?>
</table>
<?			
		
		if (!$lishor){
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			exit();
		};
		if (@pg_NumRows($lishor)!=0){
			$fila_aux = @pg_fetch_array($lishor,0);
			if (!$fila_aux){
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			};
		
			return $lishor;
		}else{
			return "0";
		};
	};
?>

<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
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
       function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="../seteaCurso.php3?caso=11&p=5&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 
		 function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../../seteaAno.php3?caso=10&pa=4&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }


</script>


</head>
<style type="text/css">
.da	{ background-color:	#FFFFD7; }
.fs	{ background-color:	#EAEAEA; }
</style>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral="3_1"; include ("../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="200" valign="top"><!-- codigo antiguo -->
								  
								  
				
			<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
				<TR height=15>
					<TD>
						<TABLE width="100%" BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
							<TR>
								<TD align=left>
									<FONT face="arial, geneva, helvetica" size=2>
										<strong>AÑO ESCOLAR</strong>
									</FONT>
								</TD>
								<TD>
									<FONT face="arial, geneva, helvetica" size=2>
										<strong>:</strong>
									</FONT>
								</TD>
								<TD>
											<?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion."   $whe_perfil_ano  ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					} ?>
			 <form name="form"   action="" method="post">
		        <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
					
						<select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
			                  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							} ?>
							</select>
				<? }	?>
								</TD></form>
							</TR>
							<TR>
								<TD align=left>
									<FONT face="arial, geneva, helvetica" size=2>
										<strong>CURSO</strong>
									</FONT>
								</TD>
								<TD>
									<FONT face="arial, geneva, helvetica" size=2>
										<strong>:</strong>
									</FONT>
								</TD>
								<TD>
									<FONT face="arial, geneva, helvetica" size=2>
										<strong>
											<form name="form"   action="" method="post">
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
		     <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
				$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
				$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
				$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano."))  $whe_perfil_curso  ";
				$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
				//echo $sql_curso;
				$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
				  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
					<option value=0 selected>(Seleccione un Curso)</option>
					 <?
					 for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
						{  
						$fila = @pg_fetch_array($resultado_query_cue,$i); 
						$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
						
						if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
						   echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
						}else{	    
						   echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
						}
					 } ?>
				  </select>	 
										</strong>
									</FONT>
								</TD> </form>
							</TR>
						</TABLE>
					</TD>
				</TR>				
				
			<?					
			if (($curso != 0) or ($curso != NULL)){ ?>	
				
				<FORM ACTION="listarHorario.php" METHOD="POST">
				<TR>
                <img  align="right"src="icono_horario.png" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="107" height="85" id="ALUMNO">
					<TD align="right">
						<TABLE>
							<TR>
								<TD>
                                
								<?php
								if ($situacion_ano !=0){
								if ($ingreso==1){ ?>
										<INPUT  class="botonXX"   TYPE="button" value="AGREGAR" onClick=document.location="seteaHorario.php?caso=2">
                                <? if(pg_numrows($rs_existe)==0){?>
                                        <INPUT class="botonXX"  TYPE="button" value="COPIAR AÑO ANTERIOR" onClick=document.location="procesoTraspaso.php">
                                <? } ?>
									    <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="../seteaCurso.php3?caso=4">	
							<?php } 
								}?>
							        <input class= "botonXX" type="button" value="IMPRIMIR" onClick="javascript:window.open('print_horario1.php', '', 'width=900, height=600, scrollbars=NO')"> 
								</TD>
                       
							</TR>
                            
						</TABLE>
                        
					</TD>
				</TR>
				<TR height=15>
					<TD>
			<?php	if (!$HTTP_POST_VARS && !$HTTP_GET_VARS)
					{
						$tiempo_actual = time();
						$mes = date("n", $tiempo_actual);
						$ano = date("Y", $tiempo_actual);
						$dia = date("d");
						$fecha = $dia . "/" . $mes . "/" . $ano;
					}
					else 
					{
						$mes = $nuevo_mes;
						$ano = $nuevo_ano;
						$dia = $dia;
						$fecha = $dia . "/" . $mes . "/" . $ano;
					}

					$mes_hoy = date("m");
					$ano_hoy = date("Y");

					if (($mes_hoy <> $mes) || ($ano_hoy <> $ano))
					{
						$hoy = 0;
					}
					else
					{
						$hoy = date("d");
					}
					//tomo el nombre del mes que hay que imprimir
					$nombre_mes = dame_nombre_mes($mes);
					
					//construyo la cabecera de la tabla ?>
					<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
						<tr>
							<td align="center">
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
									<tr height=20 >
										<td align="center" class="tableindex">
											Horario
										<?php	//calculo el mes y ano del mes anterior
												$mes_anterior = $mes - 1;
												$ano_anterior = $ano;
												if ($mes_anterior==0)
												{
													$ano_anterior--;
													$mes_anterior = 12;
												} ?>
										<?php	//calculo el mes y ano del mes siguiente
												$mes_siguiente = $mes + 1;
												$ano_siguiente = $ano;
												if ($mes_siguiente==13)
												{
													$ano_siguiente++;
													$mes_siguiente=1;
												} ?></td>
									</tr>
								</table>
							</td>
						</tr>
						<TR><TD><TABLE WIDTH="100%" BORDER=0 CELLSPACING=1 CELLPADDING=1>	
						<tr>
							<td width="14%" align="center" class="cuadro02">Lunes</td>
							<td width="14%" align="center" class="cuadro02">Martes</td>
							<td width="14%" align="center" class="cuadro02">Miércoles</td>
							<td width="14%" align="center" class="cuadro02">Jueves</td>
							<td width="14%" align="center" class="cuadro02">Viernes</td>
							<td width="14%" align="center" class="cuadro02">Sábado</td>
							<td width="14%" align="center" class="cuadro02">Domingo</td>
						</tr>
						<?php	//Variable para llevar la cuenta del dia actual
								$dia_actual = 1;

								//calculo el numero del dia de la semana del primer dia
								$numero_dia = calcula_numero_dia_semana($hoy,$mes,$ano);

								//echo ("Numero del dia de demana del primer:" . $numero_dia . "<br>");
					
								//calculo el último dia del mes
								$ultimo_dia = ultimoDia($mes,$ano); ?>
						<TR bgcolor="#E1EFFF">
							<TD width="14%" height="100" valign="top" <?php if ($numero_dia==0){ echo ("class='da'"); };?>><!-- LUNES -->&nbsp;
							<?php	$ArrayHorario = SelHor($curso,0,$conn,$institucion); 
//									if (@pg_numrows($ArrayHorario)!=0){
										echo ("<TABLE width='100%' BORDER=1 CELLSPACING=1 CELLPADDING=1>");								
										for($z=0;$z<@pg_numrows($ArrayHorario);$z++){ 
											$fila_aux = @pg_fetch_array($ArrayHorario,$z); 
											$sql_hor = "select nombre_taller from taller where id_taller = '$fila_aux[id_taller]'";
											$res_hor = pg_Exec($conn, $sql_hor);
											$fila_hor = pg_fetch_array($res_hor);
											$nombre_hor = $fila_hor['nombre_taller'];																															
											if($nombre_hor ==''){
												$sql_hor2 = "select s.nombre from subsector s, ramo r where s.cod_subsector = r.cod_subsector and r.id_ramo = '$fila_aux[id_ramo]'";
												$res_hor2 = pg_Exec($conn, $sql_hor2);												
												$fila_hor2 = pg_fetch_array($res_hor2);
												$nombre_hor = $fila_hor2['nombre'];
												if($nombre_hor ==''){
												$nombre_hor = INDETERMINADO;
												}												
											}											
											if($modifica==1){
											?>
											<TR bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_aux['id_horario']; ?>&caso=1')">
											<? }else{?>
											<TR bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='#ffffff'">
											
											<? } ?>
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['hora']); ?></strong>
											</font>
											</td>
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php /*imp($fila_aux['nombre'])*/echo $nombre_hor; ?></strong>
											</font>
											</td>
											</TR>
							<?php		};
										echo ("</TABLE>");
//									};

							?>
							</TD>
							<TD width="14%" height="100" valign="top" <?php if ($numero_dia==1){ echo ("class='da'"); };?>><!-- MARTES -->&nbsp;
							<?php	$ArrayHorario = SelHor($curso,1,$conn,$institucion); 
									if (@pg_numrows($ArrayHorario)!=0){
										echo ("<TABLE width='100%' BORDER=1 CELLSPACING=1 CELLPADDING=1>");
										for($z=0;$z<@pg_numrows($ArrayHorario);$z++){ 
											$fila_aux = @pg_fetch_array($ArrayHorario,$z); 
											$sql_hor = "select nombre_taller from taller where id_taller = '$fila_aux[id_taller]'";
											$res_hor = pg_Exec($conn, $sql_hor);
											$fila_hor = pg_fetch_array($res_hor);
											$nombre_hor = $fila_hor['nombre_taller'];																															
											if($nombre_hor ==''){
												$sql_hor2 = "select s.nombre from subsector s, ramo r where s.cod_subsector = r.cod_subsector and r.id_ramo = '$fila_aux[id_ramo]'";
												$res_hor2 = pg_Exec($conn, $sql_hor2);												
												$fila_hor2 = pg_fetch_array($res_hor2);
												$nombre_hor = $fila_hor2['nombre'];
												if($nombre_hor ==''){
												$nombre_hor = INDETERMINADO;
												}												
											}											
											if($modifica==1){
											?>											
											<TR bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_aux['id_horario']; ?>&caso=1')">
											<? }else{?>
											<TR bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='#ffffff'">
											<? } ?>
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['hora']); ?></strong>
											</font>
											</td>
											<td align='center'>
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php /*imp($fila_aux['nombre'])*/echo $nombre_hor; ?></strong>
											</font>
											</td>
											</TR>
							<?php		};
										echo ("</TABLE>");
									};
							?>
							</TD>
							<TD width="14%" height="100" valign="top" <?php if ($numero_dia==2){ echo ("class='da'"); };?>><!-- MIERCOLES -->&nbsp;
							<?php	$ArrayHorario = SelHor($curso,2,$conn,$institucion); 
									if (@pg_numrows($ArrayHorario)!=0){
										echo ("<TABLE width='100%' BORDER=1 CELLSPACING=1 CELLPADDING=1>");
										for($z=0;$z<@pg_numrows($ArrayHorario);$z++){ 
											$fila_aux = @pg_fetch_array($ArrayHorario,$z); 
											$sql_hor = "select nombre_taller from taller where id_taller = '$fila_aux[id_taller]'";
											$res_hor = pg_Exec($conn, $sql_hor);
											$fila_hor = pg_fetch_array($res_hor);
											$nombre_hor = $fila_hor['nombre_taller'];																															
											if($nombre_hor ==''){
												$sql_hor2 = "select s.nombre from subsector s, ramo r where s.cod_subsector = r.cod_subsector and r.id_ramo = '$fila_aux[id_ramo]'";
												$res_hor2 = pg_Exec($conn, $sql_hor2);												
												$fila_hor2 = pg_fetch_array($res_hor2);
												$nombre_hor = $fila_hor2['nombre'];
												if($nombre_hor ==''){
												$nombre_hor = INDETERMINADO;
												}												
											}
											if($modifica==1){?>
											<TR bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_aux['id_horario']; ?>&caso=1')">
											<? }else{?>
											<TR bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='#ffffff'">
											<? } ?>
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['hora']); ?></strong>
											</font>
											</td>
											<td align='center'>
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php /*imp($fila_aux['nombre'])*/echo $nombre_hor; ?></strong>
											</font>
											</td>
											</TR>
							<?php		};
										echo ("</TABLE>");
									};
							?>
							</TD>
							<TD width="14%" height="100" valign="top" <?php if ($numero_dia==3){ echo ("class='da'"); };?>><!-- JUEVES -->&nbsp;
							<?php	$ArrayHorario = SelHor($curso,3,$conn,$institucion); 
									if (@pg_numrows($ArrayHorario)!=0){
										echo ("<TABLE width='100%' BORDER=1 CELLSPACING=1 CELLPADDING=1>");
										for($z=0;$z<@pg_numrows($ArrayHorario);$z++){ 
											$fila_aux = @pg_fetch_array($ArrayHorario,$z); 
											$sql_hor = "select nombre_taller from taller where id_taller = '$fila_aux[id_taller]'";
											$res_hor = pg_Exec($conn, $sql_hor);
											$fila_hor = pg_fetch_array($res_hor);
											$nombre_hor = $fila_hor['nombre_taller'];																															
											if($nombre_hor ==''){
												$sql_hor2 = "select s.nombre from subsector s, ramo r where s.cod_subsector = r.cod_subsector and r.id_ramo = '$fila_aux[id_ramo]'";
												$res_hor2 = pg_Exec($conn, $sql_hor2);												
												$fila_hor2 = pg_fetch_array($res_hor2);
												$nombre_hor = $fila_hor2['nombre'];
												if($nombre_hor ==''){
												$nombre_hor = INDETERMINADO;
												}												
											}																						
											if($modifica==1){
											?>
											<TR bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_aux['id_horario']; ?>&caso=1')">
											<? }else{?>
											<TR bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='#ffffff'">
											<? } ?>
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['hora']); ?></strong>
											</font>
											</td>
											<td align='center'>
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php /*imp($fila_aux['nombre'])*/echo $nombre_hor; ?></strong>
											</font>
											</td>
											</TR>
							<?php		};
										echo ("</TABLE>");
									};
							?>
							</TD>
							<TD width="14%" height="100" valign="top" <?php if ($numero_dia==4){ echo ("class='da'"); };?>><!-- VIERNES -->&nbsp;
							<?php	$ArrayHorario = SelHor($curso,4,$conn,$institucion); 
									if (@pg_numrows($ArrayHorario)!=0){
										echo ("<TABLE width='100%' BORDER=1 CELLSPACING=1 CELLPADDING=1>");
										for($z=0;$z<@pg_numrows($ArrayHorario);$z++){ 
											$fila_aux = @pg_fetch_array($ArrayHorario,$z); 
											$sql_hor = "select nombre_taller from taller where id_taller = '$fila_aux[id_taller]'";
											$res_hor = pg_Exec($conn, $sql_hor);
											$fila_hor = pg_fetch_array($res_hor);
											$nombre_hor = $fila_hor['nombre_taller'];																															
											if($nombre_hor ==''){
												$sql_hor2 = "select s.nombre from subsector s, ramo r where s.cod_subsector = r.cod_subsector and r.id_ramo = '$fila_aux[id_ramo]'";
												$res_hor2 = pg_Exec($conn, $sql_hor2);												
												$fila_hor2 = pg_fetch_array($res_hor2);
												$nombre_hor = $fila_hor2['nombre'];
												if($nombre_hor ==''){
												$nombre_hor = INDETERMINADO;
												}												
											}
											if($modifica==1){?>
											<TR bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_aux['id_horario']; ?>&caso=1')">
											<? }else{?>
											<TR bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='#ffffff'" >
											<? } ?>
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['hora']); ?></strong>
											</font>
											</td>
											<td align='center'>
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php /*imp($fila_aux['nombre'])*/echo $nombre_hor; ?></strong>
											</font>
											</td>
											</TR>
							<?php		};
										echo ("</TABLE>");
									};
							?>
							</TD>
							<TD width="14%" bgcolor="#EAEAEA" height="100" valign="top" <?php if ($numero_dia==5){ echo ("class='da'"); }else{ echo ("class='fs'"); };?>><!-- SABADO -->&nbsp;
							<?php	$ArrayHorario = SelHor($curso,5,$conn,$institucion); 
									if (@pg_numrows($ArrayHorario)!=0){
										echo ("<TABLE width='100%' BORDER=1 CELLSPACING=1 CELLPADDING=1>");
										for($z=0;$z<@pg_numrows($ArrayHorario);$z++){ 
											$fila_aux = @pg_fetch_array($ArrayHorario,$z); 
											$sql_hor = "select nombre_taller from taller where id_taller = '$fila_aux[id_taller]'";
											$res_hor = pg_Exec($conn, $sql_hor);
											$fila_hor = pg_fetch_array($res_hor);
											$nombre_hor = $fila_hor['nombre_taller'];																															
											if($nombre_hor ==''){
												$sql_hor2 = "select s.nombre from subsector s, ramo r where s.cod_subsector = r.cod_subsector and r.id_ramo = '$fila_aux[id_ramo]'";
												$res_hor2 = pg_Exec($conn, $sql_hor2);												
												$fila_hor2 = pg_fetch_array($res_hor2);
												$nombre_hor = $fila_hor2['nombre'];
												if($nombre_hor ==''){
												$nombre_hor = INDETERMINADO;
												}												
											}											?>
											<TR bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_aux['id_horario']; ?>&caso=1')">
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['hora']); ?></strong>
											</font>
											</td>
											<td align='center'>
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php /*imp($fila_aux['nombre'])*/echo $nombre_hor; ?></strong>
											</font>
											</td>
											</TR>
							<?php		};
										echo ("</TABLE>");
									};
							?>
							</TD>
							<TD width="14%" bgcolor="#EAEAEA" height="100" valign="top" <?php if ($numero_dia==6){ echo ("class='da'"); }else{ echo ("class='fs'"); };?>><!-- DOMINGO -->&nbsp;
							<?php	$ArrayHorario = SelHor($curso,6,$conn,$institucion); 
									if (@pg_numrows($ArrayHorario)!=0){
										echo ("<TABLE width='100%' BORDER=1 CELLSPACING=1 CELLPADDING=1>");
										for($z=0;$z<@pg_numrows($ArrayHorario);$z++){ 
											$fila_aux = @pg_fetch_array($ArrayHorario,$z); 
											$sql_hor = "select nombre_taller from taller where id_taller = '$fila_aux[id_taller]'";
											$res_hor = pg_Exec($conn, $sql_hor);
											$fila_hor = pg_fetch_array($res_hor);
											$nombre_hor = $fila_hor['nombre_taller'];																															
											if($nombre_hor ==''){
												$sql_hor2 = "select s.nombre from subsector s, ramo r where s.cod_subsector = r.cod_subsector and r.id_ramo = '$fila_aux[id_ramo]'";
												$res_hor2 = pg_Exec($conn, $sql_hor2);												
												$fila_hor2 = pg_fetch_array($res_hor2);
												$nombre_hor = $fila_hor2['nombre'];
												if($nombre_hor ==''){
												$nombre_hor = INDETERMINADO;
												}												
											}											?>
											<TR bgcolor="#ffffff" onMouseOver="this.style.background='yellow';this.style.cursor='hand'" onMouseOut="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_aux['id_horario']; ?>&caso=1')">
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['hora']); ?></strong>
											</font>
											</td>
											<td align='center'>
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php /*imp($fila_aux['nombre'])*/echo $nombre_hor; ?></strong>
											</font>
											</td>
											</TR>
							<?php		};
										echo ("</TABLE>");
									};
							?>
							</TD>
						</TR>
						</TABLE></TD></TR>
					</table>
				</TD>
				</TR>
				<TR>
					<TD>&nbsp;</TD>
				</TR>
				<TR>
					<TD><hr width="100%" color="#003b85"></TD>
				</TR>
			</TABLE>
		</FORM>
		<CENTER>
		<TABLE WIDTH="600">
			<TR>
				<TD valign="top" align="right">
					<table WIDTH="600" CELLSPACING="0" CELLPADDING="1" bgcolor="white">
						<tr>
							<td>
								<TABLE width="600" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
									<TR>
										<TD width="485">&nbsp;</TD>
										<TD bgcolor="#FFFFD7" width="15" height="10">&nbsp;</TD>
										<TD width="100"><font face="arial, geneva, helvetica" size="1" color=black>Día Actual</font></TD>
									</TR>
									<TR>
										<TD width="485">&nbsp;</TD>
										<TD bgcolor="#E1EFFF" width="15" height="10">&nbsp;</TD>
										<TD width="100"><font face="arial, geneva, helvetica" size="1" color=black>Días Hábiles</font></TD>
									</TR>
									<TR>
										<TD width="485">&nbsp;</TD>
										<TD bgcolor="#EAEAEA" width="15" height="10">&nbsp;</TD>
										<TD width="100"><font face="arial, geneva, helvetica" size="1" color=black>Fin de semana</font></TD>
									</TR>
								</TABLE>
							</td>
						</tr>
					</table>
				</TD>
			</TR>	
			
		</TABLE>
		</CENTER>
		<BR>
	     <? }else{  ?>
		        </td>
				</tr>
				</table>
		<? } ?>		
							  
								  <!-- fin codigo antiguo --> </td>
                                </tr>
                              </table></td>
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
