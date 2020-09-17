<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 9;
	$ano_ac=date("Y");
	
	if($ano==""){
		$sql_ano = "select * from ano_escolar where id_institucion=".$_INSTIT." and situacion=1";
		$result_ano = pg_exec($conn,$sql_ano);
		$fil = pg_fetch_array($result_ano,0);
		$ano = $fil['id_ano'] ;
		$_ANO=$ano;
	}
	
	 foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
//	echo "asignacion=$asignacion<br>";
   } 
   
    foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	/*echo "asignacion=$asignacion<br>";*/
   }
    
   
   	
	switch($ps)
	{
	 
	
	 case 1:
	 $ps1="none";
	 $ps2="block";
	 $ps3="block";
	 $ps4="none";
	 break;
	 
	 
	 case 2:
	 $ps1="none";
	 $ps2="none";
	 $ps3="none";
	 $ps4="block";
	 break;
	 
	 default:
	 $ps1="block";
	 $ps2="none";
	 $ps3="none";
	 $ps4="none";
	  break;
	}

	
 ?>
 
  <?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../index.php";
		 </script>

<? } ?>
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
function generar(){
	if(confirm('!!ESTE PROCESO AGREGA TODOS LOS ALUMNOS PROMOVIDOS Y NO RETIRADOS DEL AÑO ANTERIOR¡¡') == false){ return; };
	document.location="../procesoMatAuto.php3"
};


function Confirmacion(){
if(alert('¡EL INGRESO DE REGIMEN ES IRREVERSIBLE, DEBE ESTAR SEGURO DEL REGIMEN PARA ESTE AÑO ESCOLAR!') == false){ return; };
};
//-->



</script>

<SCRIPT language="JavaScript">
	//	var modo.value = <? echo $_FRMMODO ?>;
	/*
	function generar(){
		if(confirm('!!ESTE PROCESO AGREGARA A TODOS LOS ALUMNOS PROMIVIDOS Y NO RETIRADOIS EL AÑO ANTERIOR¡¡') == false){ return; };{
				document.location="procesoMatAuto";
	}*/
	
//function Confirmacion(){
	
		/*alert(modo.value);
		}*/
			//document.location="seteaCurso.php3?caso=9"
		
			//function Confirmacion(){
				//	if(confirm('¡¡SI ELIMINA EL AÑO ESCOLAR SE PERDERAN TODOS LOS DATOS!!') == false){ return; };
					//	document.location="seteaAno.php3?caso=9"
				//	};
</script>
<?php

$qry1="SELECT tipo_regimen FROM institucion WHERE rdb=".$_INSTIT;
	$result1 =@pg_Exec($conn,$qry1);
	$fila1 = @pg_fetch_array($result1,0);
	$regimen=$fila1['tipo_regimen'];

?>

	<?php if($frmModo!="ingresar"){
		$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
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
			}
		}
	}
?>

<HTML>
	<HEAD>
	
		

		<script language="JavaScript">
			function Abrir_ventana (pagina) {
				var opciones="toolbar=no,location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=380, height=200, top=85, left=140";
				window.open(pagina,"",opciones);
			}
		</script> 

<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtANO,'Ingresar AÑO.')){
					return false;
				};
				
				if(!chkSelect(form.cmbREGIMEN,'Debe Seleccionar Régimen.')){
					return false;
				};

				if(!nroOnly(form.txtANO,'Se permiten sólo números en el AÑO.')){
					return false;
				};

				if(!chkVacio(form.txtFECHAINI,'Ingresar FECHA INICIO.')){
					return false;
				};

				if(!chkFecha(form.txtFECHAINI,'Fecha Inicio inválida.')){
					return false;
				};

				if(!chkVacio(form.txtFECHATER,'Ingresar FECHA TERMINO.')){
					return false;
				};
				
				if(!chkFecha(form.txtFECHATER,'Fecha Término inválida.')){
					return false;
				};

				if(!chkFecha(form.txtFECHATER,'Fecha Término inválida.')){
					return false;
				};
				
				//VALIDACION INTERVALO DE FECHAS
				if(amd(form.txtFECHAINI.value)>=amd(form.txtFECHATER.value)){
					alert("Fecha de término no puede ser mayor o igual a la Fecha de inicio");
					return false;
				}

				return true;
			}
		</SCRIPT>
<?php }?>

<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
	<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 12px;
}
.Estilo2 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif;}
.Estilo3 {font-size: 10px}
-->
    </style>
	</HEAD>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
	  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral=3; include ("../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top"><!-- inicio codigo nuevo -->
								  
								  
								  <table width="95%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"> 
      
	    
	  
	   </td>
  </tr>
</table>
	<?php //echo tope("../../../../util/");?>
	
	<FORM method=post name="frm">
	  <TABLE WIDTH=95% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
	  <TR >
				<TD>
					
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
						<TR>
							
            
						</TR>
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
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila['nro_ano']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
		</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						
						<TR height=20>
						
						</TR>
					</TABLE>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
					</TABLE>
				</TD>
			</TR>
	  </TABLE>
	  <div id="inicio" style="display:<? echo $ps1?>">
	  <table width="589" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center" class="Estilo1">Para obtener acceso a generar los archivos txt de MATR&Iacute;CULA INICIAL, primero se debe validar la informaci&oacute;n </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">
      <input type="button" name="Submit" value="Verificar Informaci&oacute;n Matr&iacute;cula Inicial" class="botonXX" onClick="javascript:window.open('Menu_Actas.php?ps=1','_self')">
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div><!--style="display:none"-->
<div id="proceso" style="display:<? echo $ps2?>">
<table width="589" border="0" align="center" cellpadding="0" cellspacing="0" class="Estilo2">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="Estilo3">
      <?php 

	//// FUNCION QUE VALIDA EL RUT   ///////
	function validar_dav ($alumno,$dig_rut){	      
		 $alumno = $alumno;
		 $dig_rut = $dig_rut;		  
		 $largo_rut = strlen($alumno);
		 $multiplicador = 2;
		 $resultado = 0;
		 $err=0;
		 $largo=$largo_rut-1;			 
		 for ($i=0; $i < $largo_rut; $i++){
			 $num = substr($alumno,$largo,1);
			 
			 if ($multiplicador > 7){
				 $multiplicador = 2;
			 }
			 $resultado = $resultado + ($multiplicador * $num);			 
			 $multiplicador++; 
			 $largo--;		 
		 }				 
		 $resto = 11-($resultado%11);		 
		 
		 if ($resto==10){
			 $dig = "K";
		 }else{
		     if ($resto==11){
			     $dig = 0;
			 }else{	 
		         $dig = $resto;
			 }	 
		 }	 
		 
		 if ($dig_rut=="k"){
		     $dig_rut="K";   
		 } 
		 
		 if ($dig==$dig_rut){
			  $ok=1;  
		 }else{
			  $ok=0;
			  }	
		 return $ok;
		       	 
	}
	
//datos institucion
$sql1="select * from institucion where rdb= $institucion";
$res=pg_exec($conn,$sql1);	
$fil_cole=@pg_fetch_array($res,0);
$nom_inst=$fil_cole['nombre_instit'];
$rdb=$fil_cole['rdb'];
$dig_rdb=$fil_cole['dig_rdb'];


	
	//valido si hay algo en los horarios
$sql_corre="select * from tipo_ense_inst where rdb= $institucion";
//echo "<br>";
$res_corre=@pg_exec($conn,$sql_corre);
$tot_corre=pg_numrows($res_corre);

if($tot_corre==0)
echo "Institución $nom_inst error: Tipos de enseñanza no registrados<br>";
else
{
	

	for ($p=0;$p<$tot_corre;$p++)
	{	
		
		$fil_corre=@pg_fetch_array($res_corre,$p);
		$corre=$fil_corre['corre'];
		$ense=$fil_corre['cod_tipo'];
		
		
		//valido si colegio tiene tipos de enseñanza
		$sql_ens="select cod_tipo from tipo_ensenanza where  cod_tipo=$ense";
		$res_ens=@pg_exec($conn,$sql_ens);
		$tot_tipo=pg_numrows($res_ens);
		if ($tot_tipo==0)
		echo "Institución $nom_inst error: Tipos de enseñanza ($ense) no existente<br>";
		
		//consultar si tipo de enseñanza tiene horarios;
		$sql_jm="select * from hora_jm where corre=$corre";
		$res_jm=@pg_exec($conn,$sql_jm);
		$tot_hm=pg_numrows($res_jm);
		if ($tot_jm==0)
		{
		 // busco en jornada tarde
		 	$sql_jt="select * from hora_jt where corre=$corre";
			$res_jt=@pg_exec($conn,$sql_jt);
			$tot_ht=pg_numrows($res_jt);
			if ($tot_jt==0)
			{
			//busco en jornada completa
					
					$sql_mt="select * from hora_mt where corre=$corre";
					//echo "<br>";
					$res_mt=@pg_exec($conn,$sql_mt);
					$tot_mt=pg_numrows($res_mt);
					if ($tot_mt==0)
					{
					//busco en nocturna
						$sql_mt="select * from hora_vn where corre=$corre";
						//echo "<br>";
						$res_vn=@pg_exec($conn,$sql_vn);
						$tot_vn=pg_numrows($res_vn);
						if ($tot_vn==0)
						{
							echo "Institución $nom_inst error: Horario de entrada y salida no registrado (ninguna jornada) <br>";						
						}
						else
						{
						
							$fil_vn=@pg_fetch_array($res_vn,0);
							if (strlen($fil_vn['hora_ini'])<1 or strlen($fil_vn['hora_ter'])<1)
							echo "Institución $nom_inst error: Horario de entrada y/o salida no registrado (jornada vespertina)<br>";
				
						}
					
					}
					else
					{
					
						$fil_mt=@pg_fetch_array($res_mt,0);
						if (strlen($fil_mt['hora_ini'])<1 or strlen($fil_mt['hora_ter'])<1)
						echo "Institución $nom_inst error: Horario de entrada y/o salida no registrado (jornada completa)<br>";
			
					}
				
				
			}
			else
			{
			
				$fil_jt=@pg_fetch_array($res_jt,0);
				if (strlen($fil_jt['hora_ini'])<1 or strlen($fil_jt['hora_ter'])<1)
				echo "Institución $nom_inst error: Horario de entrada y/o salida no registrado (jornada tarde)<br>";
	
			}
		
		}
		else
		{
		
			$fil_jm=@pg_fetch_array($res_jm,0);
			if (strlen($fil_jm['hora_ini'])<1 or strlen($fil_jm['hora_ter'])<1)
			echo "Institución $nom_inst error: Horario de entrada y/o salida no registrado (jornada mañana)<br>";

		}
		
		
		/* $sql_jt="";
		$sql_mt="";
		$sql_vn=""; */
	
	
	}


}




    //valido los rut
	  $sql_rut="SELECT * FROM alumno INNER JOIN matricula ON (alumno.rut_alumno = matricula.rut_alumno) where  matricula.id_ano =$ano";
	$res_rut=@pg_exec($conn,$sql_rut);
	$total_filas		= pg_numrows($res_rut);
	
	$contador=0;

		for ($i=0; $i < $total_filas; $i++){
			$fila2 = @pg_fetch_array($res_rut,$i);
			$rut_alumno = $fila2['rut_alumno'];
			$dig_rut    = $fila2['dig_rut'];
			
			$ok = validar_dav($rut_alumno,$dig_rut);		
			   
			if ($ok==0){
				$contador_rut++;
				echo "rut alumno= $rut_alumno error: Rut no válido. Debe corregir la ficha del alumno<br>";
				
			}
		}	
		
	
	
	//valido los horarios
	
	//saco los demas datos del alumno  para validar
	$sql_alu="SELECT alumno.rut_alumno,alumno.sexo,alumno.nombre_alu,alumno.fecha_nac,alumno.region,alumno.ciudad,alumno.comuna,alumno.ape_pat,alumno.nombre_alu, matricula.id_curso FROM alumno INNER JOIN matricula ON (alumno.rut_alumno = matricula.rut_alumno) where matricula.id_ano =$ano order by matricula.id_curso group by matricula.id_curso" ;
	$res_alu=@pg_exec($conn,$sql_alu);
	
	for($j=0;$j<pg_numrows($res_alu);$j++)
	{
		$fil_alu=@pg_fetch_array($res_alu,$j);
		$r_alu=$fil_alu['rut_alumno'];
		
		//valido fecha de nacimiento (ano que sea mayor a 1950 y menor a año actual)
		$sql_fec="select date_part ('year', fecha_nac) as anio from alumno where rut_alumno=$r_alu";
		$res_fec=@pg_exec($conn,$sql_fec);
		for ($k=0;$k<pg_numrows($res_fec);$k++)
		{
			$fil_fec=@pg_fetch_array($res_fec,$k);
			$fec=$fil_fec['anio'];
			
			if ($fec<1950 || $fec>$ano_ac)
			echo "rut alumno $r_alu : Año de Nacimiento Inválido ($fec), rango 1950 - $ano_ac<br>";				
			
		}
		$fil_alu['sexo'];
		//valido sexo (que tenga)
		if ($fil_alu['sexo']<1 or $fil_alu['sexo']>2)
		echo "rut alumno $r_alu : Sexo no especificado<br>";
			
		if (strlen($fil_alu['ape_pat'])<1 or strlen($fil_alu['nombre_alu'])<1)
		echo "rut alumno $r_alu : Apellido Paterno o Nombre No especificado<br>";
		
			
		 	$sql_reg="select cod_reg from region where cod_reg=". $fil_alu['region'];
			//echo "<br>"; echo
			 $res_reg=@pg_exec($conn,$sql_reg);
			 $total_reg=pg_numrows($res_reg);
			 
			 if ($total_reg==0)
			echo "rut alumno $r_alu : error: Región no existente. Debe corregir la ficha del alumno<br>";
			
			//busco ciudad
			  $sql_ciu="select cor_pro from provincia where cod_reg=". $fil_alu['region']."and cor_pro=".$fil_alu['ciudad'];
			//echo "<br>";echo
			 $res_ciu=@pg_exec($conn,$sql_ciu);
			 $total_ciu=pg_numrows($res_ciu);
			 
			 if ($total_ciu==0)
			echo "rut alumno $r_alu : error: Ciudad no existente. Debe corregir la ficha del alumno<br>";
			
			//busco comuna
		 $sql_com="select * from comuna where cod_reg=". $fil_alu['region']."and cor_pro=".$fil_alu['ciudad']." and cor_com=".$fil_alu['comuna'];
			//echo "<br>";
			 $res_com=@pg_exec($conn,$sql_com);
			 $total_com=pg_numrows($res_com);
			 
			 if ($total_com==0)
			echo "rut alumno $r_alu : error: Comuna no existente. Debe corregir la ficha del alumno<br>"; /* */
		
			
	} 
	
	
	
	
	
	
	
	//valido run profesor jefe
	$sql_prof="SELECT * FROM empleado INNER JOIN supervisa ON (empleado.rut_emp = supervisa.rut_emp) INNER JOIN curso ON (supervisa.id_curso = curso.id_curso) WHERE (curso.id_ano = $ano)"; 
	$res_prof=@pg_exec($conn,$sql_prof);
	$total_prof		= pg_numrows($res_prof);
	
	$contador=0;

		for ($l=0; $l < $total_filas; $l++){
			$fila2 = @pg_fetch_array($res_prof,$l);
			$rut_emp = $fila2['rut_emp'];
			$dig_rut    = $fila2['dig_rut'];
			
			$ok = validar_dav($rut_emp,$dig_rut);		
			   
			if ($ok==1){
				$contador++;
				
			}
			if ($ok==0){
				$contador++;
				echo "rut empleado= $rut_emp error: Rut Inválido<br>";
			}
		}	
	
	
	
	//valido especialidad
	$sql_es="SELECT cod_es, grado_curso,letra_curso,cod_sector,id_curso,region,ciudad,comuna FROM curso WHERE
  (curso.id_ano = $ano ) AND (curso.ensenanza > 400)";
  
  $res_es=@pg_exec($conn,$sql_es);
	$total_es		= pg_numrows($res_es);
	for($m=0;$m<$total_es;$m++)
	{
			$fil_cur=@pg_fetch_array($res_es,$m);
			if (strlen($fil_cur['cod_es'])<1 or $fil_cur['cod_es']==0)
			{
				echo $fil_cur['grado_curso']." - ".$fil_cur['letra_curso']." error: Especialidad no especificada<br>";
			}
			else
			{
				// ver si el codigo existe en la bd
			 $sql_esp="select cod_esp from especialidad where cod_esp=". $fil_cur['cod_es'];
			//echo "<br>";
			 $res_esp=@pg_exec($conn,$sql_esp);
			 $total_esp=pg_numrows($res_esp);
			 
			 if ($total_esp==0)
			 echo $fil_cur['grado_curso']." - ".$fil_cur['letra_curso']." error: Especialidad no existente<br>";
			}
				 
					
			
			
		//veo sector economico	
			
			if (strlen($fil_cur['cod_sector'])<1 or $fil_cur['cod_sector']==0)
			{
				echo $fil_cur['grado_curso']." - ".$fil_cur['letra_curso']." error: Sector económico no especificado<br>";
			}
			else
			{
				// ver si el codigo existe en la bd
			 $sql_sec="select cod_sector from sector_eco where cod_sector=". $fil_cur['cod_sector'];
			//echo "<br>";
			 $res_sec=@pg_exec($conn,$sql_sec);
			 $total_sec=pg_numrows($res_sec);
			 
			 if ($total_sec==0)
			 echo $fil_cur['grado_curso']." - ".$fil_cur['letra_curso']." error: Sector económico no existente<br>";
			}
			
			// busco region
			
	}




 ?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>




</div>

<div id="paso" style="display:<? echo $ps3?>" >
  <table width="589" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<div align="left"><span class="Estilo1">
	Total Errores: <?php echo $contador_rut  ?>
	<br>
<br>
Atenci&oacute;n: </span><span class="Estilo2">El sistema de Validación ha finalizado: Si desea generar los archivos TXT, haga click en el botón </span></div></td>
  </tr>
  <tr>
    <td><div align="center">
      <input type="button" name="Submit2" value="Mostrar Listado de Archivos TXT" class="botonXX" onClick="javascript:window.open('Menu_Actas.php?ps=2','_self')">
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
	  <div id="listado" style="display:<? echo $ps4?>" >
	  <table width="589" border="0" align="center">
        <tr><td align=middle class="tableindex"><div align="center">ACTAS MINEDUC DE MATRICULA INICIAL</div></td></tr>
        <tr> 
      <td width="589" class="textolink"><p><img src="../../../../cortes/arrow.png" width="9" height="9">
	  
	     <a href="Archivo21_txt.php">Archivo 
        21. Datos del Establecimiento</a>
		
        <hr size="1" noshade>
        <img src="../../../../cortes/arrow.png" width="9" height="9">
		   <a href="Archivo22_txt.php">Archivo 22. Datos 
          de las Unidades Educativas</a><hr size="1">
        <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Archivo23_txt.php">Archivo 23. Nómina 
          de Estudiantes en Matrícula Inicial</a><hr size="1">
        <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="IniciaArchivo24.php">Archivo 24. Datos 
          de los Cursos</a><hr size="1">
        <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Archivo25_txt.php">Archivo 25. Estudiantes 
          de los Cursos</a><hr size="1">
        <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Archivo26_txt.php">Archivo 26. Estudiantes 
          de Enseñanza Media TP en Nóminas</a><hr size="1">
        <? if($_PERFIL==0){?>
        <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Rural_Inst_fijas.php">Rural </a><hr size="1">
        <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Rural_Inst_txt.php">Rural Dinamico </a><hr size="1">
        <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Rural_Subir.php">Rural Subir </a><hr size="1">
        <br><br><img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="javascript:Abrir_ventana('Rech/frmFoto.php')">Subir Archivos </a><hr size="1">
        <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Rech/copiarArchivosBD.php">Copiar Archivos a BD </a><hr size="1">
        <? } ?>
        <br>
        <!--a href="Manual_tecnico_matricula_inicial.doc" class="Estilo1">Bajar 
          Manual Técnico Matricula Inicial</a> </p-->
      <p>&nbsp; </p></td>
        </tr>
		</
		><TD>
					
					
				</TD>
				
        <tr>
        </tr>
      </table>
	  </div>
	  <TABLE WIDTH="589" BORDER=0 CELLSPACING=5 CELLPADDING=5 align="center" >
						
						<TR>
							<TD width="100%" align=middle class="tableindex">
								<div align="center">
								  <p>ACTAS MINEDUC DE PROMOCION</p>
								  </div></TD>
						</TR>
					</TABLE>
					<TABLE WIDTH="589" align="center" BORDER=0 CELLSPACING=5 CELLPADDING=5 >
					 
            <td width="589"> <font face="Arial, Helvetica, sans-serif"><img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Archivo01.php">Archivo 
              1. Nomina de Estudiantes</a><hr size="1">
              <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Archivo02.php">Archivo 
              2. Información del Curso</a><hr size="1">
              <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Archivo03.php">Archivo 
              3. Estudiantes del Curso</a><hr size="1">
              <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="IniciaArchivo04.php">Archivo 
              4. Antecedentes Académicos de los Estudiantes</a><hr size="1">
              <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Archivo05.php">Archivo 
              5. Situación de Promoción de los Estudiantes</a><hr size="1">
              <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Archivo06.php">Archivo 
              6. Docentes de los Subsectores, Asignaturas o Módulos</a><hr size="1">
              <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="procesoArchivo07.php?pagina=0">Archivo 
              7. Acta del Curso</a><hr size="1">
              <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Archivo08.php">Archivo 
              8. Subsectores, Asignaturas o Módulos</a><hr size="1">
			  <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Archivo09.php">Archivo 
              9. Nómina de Alumnos  Licenciados</a><hr size="1">
			  <img src="../../../../cortes/arrow.png" width="9" height="9">   <a href="Archivo10.php">Archivo 
              10. Nómina de Alumnos para Titulación</a><hr size="1">
		  </font></td>
					</TABLE>
	  

	</FORM>
								  
								  
								  
								  
						
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
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
<? pg_close($conn); ?>
</body>
</html>
